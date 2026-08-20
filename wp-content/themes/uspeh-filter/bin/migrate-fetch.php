<?php
declare(strict_types=1);

/**
 * Етап 1 от миграцията: обхожда стария сайт и записва съдържанието му като JSON.
 *
 * Пуска се със самостоятелен PHP (БЕЗ WordPress), от машина, която достига стария сайт:
 *
 *   php bin/migrate-fetch.php --base=https://uspehfilter.com/ --out=migration
 *
 * Опции:
 *   --base=URL      начален адрес (задължително)
 *   --out=DIR       директория за резултата (по подразбиране: migration)
 *   --max=N         таван на брой страници (по подразбиране 300)
 *   --delay=MS      пауза между заявките в милисекунди (по подразбиране 400)
 *   --lang=1        обхожда само адреси с този lang параметър (празно = всички)
 *   --no-images     пропуска сваляне на изображения
 *
 * Резултат:
 *   <out>/old-site.json   по един запис на страница: адрес, заглавие, текст, HTML,
 *                         заглавия, таблици, изображения
 *   <out>/images/         свалените изображения
 *   <out>/mapping.csv     чернова за съпоставяне стар адрес → нова цел (етап 2)
 *
 * Нищо не се записва в WordPress на този етап — прегледай JSON-а, преди да импортираш.
 */

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "Пуска се само от команден ред.\n");
    exit(1);
}

$opts = [];
foreach (array_slice($argv, 1) as $arg) {
    if (preg_match('/^--([a-z-]+)(?:=(.*))?$/', $arg, $m)) {
        $opts[$m[1]] = $m[2] ?? true;
    }
}

$base = isset($opts['base']) && is_string($opts['base']) ? rtrim($opts['base'], '/') . '/' : '';
if ($base === '' || !filter_var($base, FILTER_VALIDATE_URL)) {
    fwrite(STDERR, "Липсва или е невалиден --base. Пример:\n  php bin/migrate-fetch.php --base=https://uspehfilter.com/\n");
    exit(1);
}

$outDir    = is_string($opts['out'] ?? null) ? $opts['out'] : 'migration';
$maxPages  = (int) ($opts['max'] ?? 300);
$delayMs   = (int) ($opts['delay'] ?? 400);
$langFilter = isset($opts['lang']) && is_string($opts['lang']) ? $opts['lang'] : '';
$withImages = !isset($opts['no-images']);

$host = (string) parse_url($base, PHP_URL_HOST);
$imgDir = $outDir . '/images';

foreach ([$outDir, $imgDir] as $dir) {
    if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
        fwrite(STDERR, "Не мога да създам директория: $dir\n");
        exit(1);
    }
}

/**
 * Сваля адрес и връща [html, contentType] или null.
 */
function mig_get(string $url): ?array {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 5,
        CURLOPT_TIMEOUT        => 40,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_USERAGENT      => 'uspeh-filter-migration/1.0 (+съдържание на собствен сайт)',
        CURLOPT_ENCODING       => '',
    ]);
    $body = curl_exec($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    $type = (string) curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($body === false || $code >= 400) {
        fwrite(STDERR, sprintf("  ! %s (HTTP %d%s)\n", $url, $code, $err ? ", $err" : ''));
        return null;
    }
    return [(string) $body, $type];
}

/**
 * Старите български сайтове често са windows-1251. Разпознаваме и конвертираме към UTF-8.
 */
function mig_to_utf8(string $html, string $contentType): string {
    $charset = '';
    if (preg_match('/charset=([\w-]+)/i', $contentType, $m)) {
        $charset = strtolower($m[1]);
    }
    if ($charset === '' && preg_match('/<meta[^>]+charset=["\']?([\w-]+)/i', $html, $m)) {
        $charset = strtolower($m[1]);
    }
    if ($charset === '' || $charset === 'utf-8' || $charset === 'utf8') {
        // Проверяваме дали наистина е валиден UTF-8; ако не — приемаме cp1251.
        if (mb_check_encoding($html, 'UTF-8')) {
            return $html;
        }
        $charset = 'windows-1251';
    }
    $converted = @mb_convert_encoding($html, 'UTF-8', $charset);
    return is_string($converted) && $converted !== '' ? $converted : $html;
}

function mig_dom(string $html): ?DOMDocument {
    $doc = new DOMDocument();
    $prev = libxml_use_internal_errors(true);
    // Префиксът принуждава libxml да чете входа като UTF-8.
    $ok = $doc->loadHTML('<?xml encoding="UTF-8">' . $html);
    libxml_clear_errors();
    libxml_use_internal_errors($prev);
    return $ok ? $doc : null;
}

function mig_text(DOMNode $n): string {
    return trim(preg_replace('/\s+/u', ' ', (string) $n->textContent) ?? '');
}

/**
 * Избира основния съдържателен блок евристично: най-много текст при най-малко
 * връзки. Работи без да знаем markup-а на стария сайт и се справя с
 * таблични оформления, каквито има при CMS от онази епоха.
 */
function mig_main_content(DOMDocument $doc): ?DOMElement {
    $xp = new DOMXPath($doc);

    foreach ($xp->query('//script | //style | //noscript | //iframe') as $junk) {
        $junk->parentNode?->removeChild($junk);
    }

    $best = null;
    $bestScore = 0.0;
    $candidates = $xp->query('//main | //article | //div | //td | //section');
    if (!$candidates) {
        return null;
    }

    foreach ($candidates as $el) {
        if (!$el instanceof DOMElement) {
            continue;
        }
        $text = mig_text($el);
        $len  = mb_strlen($text);
        if ($len < 150) {
            continue;
        }

        $linkLen = 0;
        foreach ($xp->query('.//a', $el) as $a) {
            $linkLen += mb_strlen(mig_text($a));
        }
        $linkDensity = $len > 0 ? $linkLen / $len : 1.0;
        if ($linkDensity > 0.6) {
            continue; // навигационен блок
        }

        // Предпочитаме блокове с абзаци и по-плитка вложеност.
        $paras = $xp->query('.//p | .//li', $el);
        $paraBonus = $paras ? min($paras->length, 40) * 12 : 0;
        $depth = 0;
        for ($p = $el; $p !== null; $p = $p->parentNode) { $depth++; }

        $score = ($len * (1 - $linkDensity)) + $paraBonus - ($depth * 8);
        if ($score > $bestScore) {
            $bestScore = $score;
            $best = $el;
        }
    }

    return $best;
}

function mig_abs(string $url, string $pageUrl): string {
    $url = trim($url);
    if ($url === '' || str_starts_with($url, 'data:') || str_starts_with($url, 'mailto:')
        || str_starts_with($url, 'tel:') || str_starts_with($url, 'javascript:')) {
        return '';
    }
    if (preg_match('#^https?://#i', $url)) {
        return $url;
    }
    $parts = parse_url($pageUrl);
    if (!$parts || empty($parts['scheme']) || empty($parts['host'])) {
        return '';
    }
    $root = $parts['scheme'] . '://' . $parts['host'] . (isset($parts['port']) ? ':' . $parts['port'] : '');
    if (str_starts_with($url, '//')) {
        return $parts['scheme'] . ':' . $url;
    }
    if (str_starts_with($url, '/')) {
        return $root . $url;
    }
    if (str_starts_with($url, '?')) {
        return $root . ($parts['path'] ?? '/') . $url;
    }
    $dir = rtrim(dirname($parts['path'] ?? '/'), '/');
    return $root . $dir . '/' . $url;
}

/** Пропускаме служебни картинки (разделители, точки, брояча). */
function mig_is_junk_image(string $url): bool {
    return (bool) preg_match('/(spacer|blank|pixel|dot|shim|1x1|clear)\.(gif|png)$/i', $url);
}

$queue   = [$base];
$seen    = [];
$records = [];
$imagesSaved = [];

fwrite(STDOUT, "Обхождам $base\n");

while ($queue && count($records) < $maxPages) {
    $url = array_shift($queue);
    $key = rtrim($url, '/');
    if (isset($seen[$key])) {
        continue;
    }
    $seen[$key] = true;

    $res = mig_get($url);
    if ($res === null) {
        continue;
    }
    [$raw, $ctype] = $res;
    if (stripos($ctype, 'html') === false) {
        continue;
    }

    $html = mig_to_utf8($raw, $ctype);
    $doc  = mig_dom($html);
    if (!$doc) {
        continue;
    }
    $xp = new DOMXPath($doc);

    $title = '';
    $tNode = $xp->query('//title')->item(0);
    if ($tNode) {
        $title = mig_text($tNode);
    }
    $metaDesc = '';
    $mNode = $xp->query('//meta[translate(@name,"DESCRIPTION","description")="description"]/@content')->item(0);
    if ($mNode) {
        $metaDesc = trim($mNode->nodeValue ?? '');
    }

    $content = mig_main_content($doc);

    $bodyHtml = '';
    $bodyText = '';
    $headings = [];
    $tables   = [];
    $images   = [];

    if ($content) {
        $bodyHtml = (string) $doc->saveHTML($content);
        $bodyText = mig_text($content);

        foreach ($xp->query('.//h1 | .//h2 | .//h3 | .//h4', $content) as $h) {
            $t = mig_text($h);
            if ($t !== '') {
                $headings[] = ['level' => (int) substr($h->nodeName, 1), 'text' => $t];
            }
        }

        foreach ($xp->query('.//table', $content) as $tbl) {
            $rows = [];
            foreach ($xp->query('.//tr', $tbl) as $tr) {
                $cells = [];
                foreach ($xp->query('./td | ./th', $tr) as $td) {
                    $cells[] = mig_text($td);
                }
                if (array_filter($cells, static fn($c) => $c !== '')) {
                    $rows[] = $cells;
                }
            }
            if (count($rows) > 1) {
                $tables[] = $rows;
            }
        }
    }

    // Изображения: от съдържателния блок, а ако няма — от цялата страница.
    $imgScope = $content ?? $doc->documentElement;
    foreach ($xp->query('.//img', $imgScope) as $img) {
        if (!$img instanceof DOMElement) {
            continue;
        }
        $src = mig_abs($img->getAttribute('src'), $url);
        if ($src === '' || mig_is_junk_image($src)) {
            continue;
        }
        $images[] = ['src' => $src, 'alt' => trim($img->getAttribute('alt'))];
    }

    $records[] = [
        'url'         => $url,
        'title'       => $title,
        'meta_desc'   => $metaDesc,
        'text'        => $bodyText,
        'html'        => $bodyHtml,
        'headings'    => $headings,
        'tables'      => $tables,
        'images'      => array_values(array_unique(array_column($images, 'src'))),
        'images_meta' => $images,
    ];

    fwrite(STDOUT, sprintf("  %3d  %-58s %s\n", count($records), mb_strimwidth($title ?: '(без заглавие)', 0, 58), $url));

    // Следващи адреси — само в рамките на домейна.
    foreach ($xp->query('//a/@href') as $href) {
        $next = mig_abs((string) $href->nodeValue, $url);
        if ($next === '' || parse_url($next, PHP_URL_HOST) !== $host) {
            continue;
        }
        $next = strtok($next, '#');
        if ($next === false) {
            continue;
        }
        if ($langFilter !== '' && str_contains($next, 'lang=') && !str_contains($next, 'lang=' . $langFilter)) {
            continue;
        }
        if (preg_match('/\.(pdf|zip|rar|doc|docx|xls|xlsx|jpe?g|png|gif|svg)$/i', $next)) {
            continue;
        }
        if (!isset($seen[rtrim($next, '/')])) {
            $queue[] = $next;
        }
    }

    if ($delayMs > 0) {
        usleep($delayMs * 1000);
    }
}

// Сваляне на изображенията.
if ($withImages) {
    $allImages = [];
    foreach ($records as $r) {
        foreach ($r['images'] as $src) {
            $allImages[$src] = true;
        }
    }
    fwrite(STDOUT, "\nСвалям " . count($allImages) . " изображения\n");
    foreach (array_keys($allImages) as $src) {
        $name = basename((string) parse_url($src, PHP_URL_PATH));
        if ($name === '' || $name === '/') {
            continue;
        }
        $name = preg_replace('/[^A-Za-z0-9._-]/', '_', $name) ?? $name;
        $dest = $imgDir . '/' . $name;
        if (file_exists($dest)) {
            $imagesSaved[$src] = $name;
            continue;
        }
        $res = mig_get($src);
        if ($res === null) {
            continue;
        }
        if (file_put_contents($dest, $res[0]) !== false) {
            $imagesSaved[$src] = $name;
        }
        if ($delayMs > 0) {
            usleep((int) ($delayMs * 500));
        }
    }
    fwrite(STDOUT, "  запазени: " . count($imagesSaved) . "\n");
}

foreach ($records as &$r) {
    $r['image_files'] = [];
    foreach ($r['images'] as $src) {
        if (isset($imagesSaved[$src])) {
            $r['image_files'][$src] = $imagesSaved[$src];
        }
    }
}
unset($r);

$payload = [
    'base'       => $base,
    'fetched_at' => date('c'),
    'count'      => count($records),
    'pages'      => $records,
];

file_put_contents(
    $outDir . '/old-site.json',
    json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
);

// Чернова за съпоставяне — попълва се на ръка преди импорта.
$csv = fopen($outDir . '/mapping.csv', 'w');
if ($csv) {
    fputcsv($csv, ['old_url', 'title', 'post_type', 'slug', 'template', 'redirect_to', 'skip']);
    foreach ($records as $r) {
        fputcsv($csv, [$r['url'], $r['title'], 'page', '', '', '', '']);
    }
    fclose($csv);
}

fwrite(STDOUT, sprintf(
    "\nГотово: %d страници → %s/old-site.json\nПопълни %s/mapping.csv и продължи с migrate-import.php\n",
    count($records),
    $outDir,
    $outDir
));
