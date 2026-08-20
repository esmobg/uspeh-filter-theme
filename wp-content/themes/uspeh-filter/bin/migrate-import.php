<?php
declare(strict_types=1);

/**
 * Етап 3 от миграцията: внася събраното от migrate-fetch.php в WordPress.
 *
 * Пуска се през WP-CLI, от новия сайт:
 *
 *   wp eval-file wp-content/themes/uspeh-filter/bin/migrate-import.php -- --dir=migration
 *   wp eval-file wp-content/themes/uspeh-filter/bin/migrate-import.php -- --dir=migration --dry-run
 *
 * Опции:
 *   --dir=DIR     директория с old-site.json и mapping.csv (по подразбиране: migration)
 *   --dry-run     само отчита какво би направил, без да записва
 *   --only=TYPE   внася само записи от този тип (page, product, engine_filter, ...)
 *   --auto        сам решава тип и шаблон за редовете, които mapping.csv не уточнява
 *                 (заглавията се съпоставят със шаблоните на темата); mapping.csv
 *                 винаги има приоритет, така че ръчните решения не се губят
 *
 * Съдържанието се превръща в Gutenberg блокове, така че страниците се отварят
 * директно в редактора. Blocks-first логиката на темата ги рендира вместо
 * PHP секциите — виж README.
 *
 * Скриптът е идемпотентен: всеки запис пази стария си адрес в _migrated_from
 * и при повторно пускане се обновява, вместо да се дублира.
 */

if (!defined('ABSPATH')) {
    fwrite(STDERR, "Пуска се през: wp eval-file ...\n");
    exit(1);
}

if (!class_exists('WP_CLI')) {
    // Позволява пускане и през обикновен php -r с зареден wp-load.php.
    class WP_CLI {
        public static function success(string $m): void { fwrite(STDOUT, "  [ok] $m\n"); }
        public static function warning(string $m): void { fwrite(STDOUT, "  [!]  $m\n"); }
        public static function line(string $m): void { fwrite(STDOUT, "$m\n"); }
        public static function error(string $m): void { fwrite(STDERR, "  [ERR] $m\n"); exit(1); }
    }
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$args = [];
foreach ($GLOBALS['argv'] ?? [] as $a) {
    if (preg_match('/^--([a-z-]+)(?:=(.*))?$/', (string) $a, $m)) {
        $args[$m[1]] = $m[2] ?? true;
    }
}

$dir     = is_string($args['dir'] ?? null) ? rtrim($args['dir'], '/') : 'migration';
$dryRun  = isset($args['dry-run']);
$only    = is_string($args['only'] ?? null) ? $args['only'] : '';
$auto    = isset($args['auto']);

$jsonPath = $dir . '/old-site.json';
if (!is_readable($jsonPath)) {
    WP_CLI::error("Липсва $jsonPath — пусни първо bin/migrate-fetch.php.");
}

$data = json_decode((string) file_get_contents($jsonPath), true);
if (!is_array($data)) {
    WP_CLI::error("Не мога да прочета $jsonPath.");
}
if (empty($data['pages'])) {
    WP_CLI::error(
        "$jsonPath не съдържа страници — обхождането не е свалило нищо.\n"
        . "  Пусни отново bin/migrate-fetch.php от машина с достъп до стария сайт."
    );
}

/** Съпоставяне стар адрес → цел. Липсващите редове се третират като 'page'. */
$mapping = [];
$mapPath = $dir . '/mapping.csv';
if (is_readable($mapPath) && ($fh = fopen($mapPath, 'r')) !== false) {
    $header = fgetcsv($fh, 0, ",", "\"", "\\");
    if (is_array($header)) {
        while (($row = fgetcsv($fh, 0, ",", "\"", "\\")) !== false) {
            $r = array_combine(array_pad($header, count($row), ''), $row);
            if (!is_array($r) || empty($r['old_url'])) {
                continue;
            }
            $mapping[trim((string) $r['old_url'])] = $r;
        }
    }
    fclose($fh);
}

/* ------------------------------------------------------------------ */
/* HTML → Gutenberg блокове                                            */
/* ------------------------------------------------------------------ */

function mig_esc_block_text(string $s): string {
    return trim(preg_replace('/\s+/u', ' ', $s) ?? '');
}

function mig_inline_html(DOMNode $node): string {
    $out = '';
    foreach ($node->childNodes as $child) {
        if ($child instanceof DOMText) {
            $out .= esc_html($child->textContent);
        } elseif ($child instanceof DOMElement) {
            $tag = strtolower($child->nodeName);
            $inner = mig_inline_html($child);
            if ($inner === '') {
                continue;
            }
            switch ($tag) {
                case 'a':
                    $href = $child->getAttribute('href');
                    $out .= $href !== ''
                        ? '<a href="' . esc_url($href) . '">' . $inner . '</a>'
                        : $inner;
                    break;
                case 'strong': case 'b':
                    $out .= '<strong>' . $inner . '</strong>'; break;
                case 'em': case 'i':
                    $out .= '<em>' . $inner . '</em>'; break;
                case 'br':
                    $out .= '<br>'; break;
                default:
                    $out .= $inner;
            }
        }
    }
    return mig_esc_block_text($out);
}

/**
 * Обхожда съдържателния HTML и връща блоков markup: заглавия, абзаци,
 * списъци и таблици. Оформлението на стария сайт (вложени таблици,
 * шрифтови тагове) се изхвърля — остава само смисълът.
 */
function mig_html_to_blocks(string $html, array $imageUrlToId = []): string {
    if (trim($html) === '') {
        return '';
    }

    $doc = new DOMDocument();
    $prev = libxml_use_internal_errors(true);
    $doc->loadHTML('<?xml encoding="UTF-8">' . $html);
    libxml_clear_errors();
    libxml_use_internal_errors($prev);

    $blocks = [];
    $seenText = [];

    $emitParagraph = static function (string $text) use (&$blocks, &$seenText): void {
        $text = mig_esc_block_text($text);
        $plain = strip_tags($text);
        if (mb_strlen($plain) < 3) {
            return;
        }

        // Къс абзац, съставен предимно от връзки, е навигация или хлебни трохи,
        // а не съдържание — новата тема ги рендира сама.
        if (mb_strlen($plain) < 120) {
            $linkText = '';
            if (preg_match_all('/<a[^>]*>(.*?)<\/a>/is', $text, $m)) {
                $linkText = strip_tags(implode('', $m[1]));
            }
            if (mb_strlen($linkText) > 0 && mb_strlen($linkText) / mb_strlen($plain) > 0.7) {
                return;
            }
            // Верига от типа „Начало / Продукти / Предфилтри" — хлебни трохи.
            if (mb_strlen($linkText) > 0 && preg_match('~[/›»→>]|&gt;~u', $plain)) {
                return;
            }
        }

        $key = md5($plain);
        if (isset($seenText[$key])) {
            return;
        }
        $seenText[$key] = true;
        $blocks[] = "<!-- wp:paragraph -->\n<p>{$text}</p>\n<!-- /wp:paragraph -->";
    };

    $walk = static function (DOMNode $node) use (&$walk, &$blocks, &$seenText, $emitParagraph, $imageUrlToId): void {
        foreach ($node->childNodes as $child) {
            if ($child instanceof DOMText) {
                continue;
            }
            if (!$child instanceof DOMElement) {
                continue;
            }
            $tag = strtolower($child->nodeName);

            // Блокове, чийто клас или id ги обявява за навигация, се прескачат изцяло.
            $marker = strtolower($child->getAttribute('class') . ' ' . $child->getAttribute('id'));
            if ($marker !== ' ' && preg_match('/breadcrumb|crumb|nav|menu|sidebar|widget|share|social|pagination/', $marker)) {
                continue;
            }

            switch ($tag) {
                case 'h1': case 'h2': case 'h3': case 'h4': case 'h5': case 'h6':
                    $text = mig_inline_html($child);
                    if ($text === '') { break; }
                    $level = max(2, (int) substr($tag, 1)); // h1 остава за заглавието на страницата
                    $blocks[] = "<!-- wp:heading {\"level\":{$level}} -->\n"
                        . "<h{$level} class=\"wp-block-heading\">{$text}</h{$level}>\n<!-- /wp:heading -->";
                    break;

                case 'p':
                    $emitParagraph(mig_inline_html($child));
                    break;

                case 'ul': case 'ol':
                    $items = [];
                    foreach ($child->childNodes as $li) {
                        if ($li instanceof DOMElement && strtolower($li->nodeName) === 'li') {
                            $t = mig_inline_html($li);
                            if ($t !== '') {
                                $items[] = "<!-- wp:list-item -->\n<li>{$t}</li>\n<!-- /wp:list-item -->";
                            }
                        }
                    }
                    if ($items) {
                        $ordered = $tag === 'ol' ? '{"ordered":true} ' : '';
                        $openTag = $tag === 'ol' ? 'ol' : 'ul';
                        $blocks[] = "<!-- wp:list {$ordered}-->\n<{$openTag} class=\"wp-block-list\">"
                            . implode("\n", $items) . "</{$openTag}>\n<!-- /wp:list -->";
                    }
                    break;

                case 'table':
                    $rows = [];
                    $xp = new DOMXPath($child->ownerDocument);
                    foreach ($xp->query('.//tr', $child) as $tr) {
                        $cells = [];
                        foreach ($xp->query('./td | ./th', $tr) as $td) {
                            $cells[] = mig_inline_html($td);
                        }
                        if (array_filter($cells, static fn($c) => $c !== '')) {
                            $rows[] = $cells;
                        }
                    }
                    // Таблица с една колона почти винаги е оформление, не данни.
                    $maxCols = $rows ? max(array_map('count', $rows)) : 0;
                    if (count($rows) > 1 && $maxCols > 1) {
                        $head = array_shift($rows);
                        $thead = '<thead><tr>' . implode('', array_map(
                            static fn($c) => '<th>' . $c . '</th>', $head)) . '</tr></thead>';
                        $tbody = '<tbody>' . implode('', array_map(
                            static fn($r) => '<tr>' . implode('', array_map(
                                static fn($c) => '<td>' . $c . '</td>', $r)) . '</tr>', $rows)) . '</tbody>';
                        $blocks[] = "<!-- wp:table -->\n<figure class=\"wp-block-table\"><table>"
                            . $thead . $tbody . "</table></figure>\n<!-- /wp:table -->";
                        break;
                    }
                    $walk($child); // оформление — влизаме навътре
                    break;

                case 'img':
                    $src = $child->getAttribute('src');
                    $id  = $imageUrlToId[$src] ?? 0;
                    if ($id) {
                        $url = wp_get_attachment_url($id);
                        $alt = esc_attr($child->getAttribute('alt'));
                        $blocks[] = "<!-- wp:image {\"id\":{$id},\"sizeSlug\":\"large\"} -->\n"
                            . "<figure class=\"wp-block-image size-large\"><img src=\"" . esc_url((string) $url)
                            . "\" alt=\"{$alt}\" class=\"wp-image-{$id}\"/></figure>\n<!-- /wp:image -->";
                    }
                    break;

                case 'script': case 'style': case 'noscript': case 'form':
                    break;

                default:
                    // Ако елементът съдържа само текст (без структурни деца), правим абзац.
                    $hasStructural = false;
                    foreach ($child->childNodes as $g) {
                        if ($g instanceof DOMElement && in_array(strtolower($g->nodeName),
                            ['p','h1','h2','h3','h4','h5','h6','ul','ol','table','div','td','tr','img','section','article'], true)) {
                            $hasStructural = true;
                            break;
                        }
                    }
                    if ($hasStructural) {
                        $walk($child);
                    } else {
                        $emitParagraph(mig_inline_html($child));
                    }
            }
        }
    };

    $body = $doc->getElementsByTagName('body')->item(0);
    if ($body) {
        $walk($body);
    }

    return implode("\n\n", $blocks);
}

/* ------------------------------------------------------------------ */
/* Внасяне на изображения                                              */
/* ------------------------------------------------------------------ */

function mig_import_image(string $localFile, string $title, bool $dryRun): int {
    if (!is_readable($localFile)) {
        return 0;
    }
    $name = basename($localFile);

    $existing = get_posts([
        'post_type'      => 'attachment',
        'post_status'    => 'inherit',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'meta_key'       => '_migrated_file',
        'meta_value'     => $name,
    ]);
    if ($existing) {
        return (int) $existing[0];
    }
    if ($dryRun) {
        return -1; // би било внесено; отрицателно, за да не се използва като истинско ID
    }

    $upload = wp_upload_bits($name, null, (string) file_get_contents($localFile));
    if (!empty($upload['error'])) {
        return 0;
    }
    $type = wp_check_filetype($name);
    $id = wp_insert_attachment([
        'post_mime_type' => $type['type'] ?: 'image/jpeg',
        'post_title'     => $title !== '' ? $title : pathinfo($name, PATHINFO_FILENAME),
        'post_status'    => 'inherit',
    ], $upload['file']);

    if (!$id || is_wp_error($id)) {
        return 0;
    }
    wp_update_attachment_metadata((int) $id, wp_generate_attachment_metadata((int) $id, $upload['file']));
    update_post_meta((int) $id, '_migrated_file', $name);
    return (int) $id;
}

/* ------------------------------------------------------------------ */
/* Внасяне на страниците                                               */
/* ------------------------------------------------------------------ */

function mig_find_existing(string $oldUrl): ?WP_Post {
    $found = get_posts([
        'post_type'      => 'any',
        'post_status'    => 'any',
        'posts_per_page' => 1,
        'meta_key'       => '_migrated_from',
        'meta_value'     => $oldUrl,
    ]);
    return $found ? $found[0] : null;
}

/**
 * Кирилица → латиница, за да съвпадат новите адреси с приетата в темата
 * схема (vazdushni-filtri, za-nas). WordPress иначе оставя кирилицата и
 * адресът излиза процентно кодиран.
 */
function mig_translit(string $s): string {
    $map = [
        'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ж'=>'zh','з'=>'z',
        'и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p',
        'р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'ts','ч'=>'ch',
        'ш'=>'sh','щ'=>'sht','ъ'=>'a','ь'=>'y','ю'=>'yu','я'=>'ya',
    ];
    $s = mb_strtolower($s, 'UTF-8');
    $s = strtr($s, $map);
    $s = preg_replace('/[^a-z0-9]+/u', '-', $s) ?? $s;
    return trim($s, '-');
}

function mig_slug_from(string $url, string $title, string $base = ''): string {
    $path  = trim((string) parse_url($url, PHP_URL_PATH), '/');
    $query = (string) parse_url($url, PHP_URL_QUERY);

    // Началната страница на стария сайт.
    if (($path === '' || $path === 'index.php') && $query === '') {
        return 'nachalo';
    }

    if ($path !== '' && $path !== 'index.php') {
        $slug = mig_translit(basename($path));
        if ($slug !== '') {
            return $slug;
        }
    }
    if ($query !== '') {
        parse_str($query, $q);
        if (!empty($q['m'])) {
            return 'stranica-' . preg_replace('/[^a-z0-9]/i', '', (string) $q['m']);
        }
    }
    $slug = mig_translit($title);
    return $slug !== '' ? $slug : 'stranica-' . substr(md5($url), 0, 8);
}

/* ------------------------------------------------------------------ */
/* Автоматично разпознаване (--auto)                                   */
/* ------------------------------------------------------------------ */

/**
 * Съпоставя ЗАГЛАВИЕТО на стара страница със шаблон на темата.
 *
 * Нарочно е консервативно и гледа само заглавието: празният резултат е
 * безопасен, защото page.php така или иначе рендира блоковете коректно,
 * докато сгрешен шаблон подменя целия дизайн на страницата. Правилата са
 * подредени от най-конкретното към най-общото.
 */
function mig_guess_template(string $title, string $url, string $text): string {
    $t = mb_strtolower(trim($title), 'UTF-8');
    if ($t === '') {
        return '';
    }

    $rules = [
        'page-templates/template-thank-you.php'         => ['благодар', 'thank you'],
        'page-templates/template-faq.php'               => ['често задавани', 'въпроси и отговори', 'faq'],
        'page-templates/template-quote.php'             => ['поискай оферта', 'запитване за оферта', 'заявка за оферта', 'искане на оферта'],
        'page-templates/template-custom-production.php' => ['индивидуално производство', 'нестандартни размери', 'филтри по размер', 'по поръчка'],
        'page-templates/template-quality.php'           => ['качество', 'сертификат', 'quality'],
        'page-templates/template-production.php'        => ['производство', 'production'],
        'page-templates/template-contact.php'           => ['контакт', 'contact'],
        'page-templates/template-about.php'             => ['за нас', 'about us', 'история на', 'кои сме'],
        'page-templates/template-applications.php'      => ['приложения', 'сектори', 'applications'],
        'page-templates/template-hepa.php'              => ['hepa филтри', 'hepa, ulpa', 'epa, hepa'],
    ];

    foreach ($rules as $template => $phrases) {
        foreach ($phrases as $phrase) {
            if (str_contains($t, $phrase)) {
                return $template;
            }
        }
    }
    return '';
}

/**
 * Познава типа съдържание. Двигателните филтри се разпознават по каталожен/OEM
 * номер, продуктите — по филтърен клас. Всичко останало остава страница.
 */
function mig_guess_post_type(array $page): string {
    $title = (string) ($page['title'] ?? '');
    $text  = (string) ($page['text'] ?? '');
    $url   = (string) ($page['url'] ?? '');
    $hay   = mb_strtolower($title . ' ' . mb_substr($text, 0, 600), 'UTF-8');

    // Двигателен филтър: каталожен номер тип UF-1234 или явно OEM поле.
    if (preg_match('/\bUF[-\s]?\d{3,5}\b/iu', $title . ' ' . $text)
        || (str_contains($hay, 'oem') && preg_match('/\b\d{6,}\b/', $text))) {
        return 'engine_filter';
    }

    // Продукт: заглавието носи филтърен клас (G4, M5, F7, E11, H13, U15).
    if (preg_match('/\b(?:G[2-4]|M[5-6]|F[7-9]|E1[0-2]|H1[3-4]|U1[5-7])\b/u', $title)) {
        return 'product';
    }

    // Техническа статия — само по ясен адрес, не по споменаване на стандарт
    // (стандартите се цитират и в обикновени продуктови описания).
    if (preg_match('~/(tech|technical|statii|stati|articles?|novini|blog)/~i', $url)) {
        return 'tech_article';
    }

    return 'page';
}

/** Изважда каталожен номер и OEM номера от текста на страница за двигателен филтър. */
function mig_extract_engine_meta(array $page): array {
    $text = (string) ($page['text'] ?? '');
    $meta = [];

    if (preg_match('/\bUF[-\s]?(\d{3,5})\b/iu', (string) ($page['title'] ?? '') . ' ' . $text, $m)) {
        $meta['_catalog_number'] = 'UF-' . $m[1];
    }
    if (preg_match('/OEM[^:]{0,12}:?\s*([0-9A-Za-z ,\/-]{6,120})/u', $text, $m)) {
        $oems = preg_split('/[,;\/]+/', trim($m[1])) ?: [];
        $oems = array_values(array_filter(array_map('trim', $oems),
            static fn($o) => preg_match('/\d{4,}/', $o) === 1));
        if ($oems) {
            $meta['_oem_numbers'] = array_slice($oems, 0, 12);
        }
    }
    if (preg_match('/A[:\s]+(\d{2,4})\s*mm.{0,20}B[:\s]+(\d{2,4})\s*mm.{0,20}H[:\s]+(\d{2,4})/isu', $text, $m)) {
        $meta['_dim_a'] = $m[1];
        $meta['_dim_b'] = $m[2];
        $meta['_dim_h'] = $m[3];
    }
    return $meta;
}

/** Изважда филтърния клас от заглавието на продукт. */
function mig_extract_product_meta(array $page): array {
    $meta = [];
    if (preg_match('/\b(G[2-4]|M[5-6]|F[7-9]|E1[0-2]|H1[3-4]|U1[5-7])\b/u', (string) ($page['title'] ?? ''), $m)) {
        $meta['_filter_class'] = $m[1];
    }
    return $meta;
}

$imgDir = $dir . '/images';
$stats  = ['created' => 0, 'updated' => 0, 'skipped' => 0, 'images' => 0, 'guessed' => 0];
$redirects = [];

WP_CLI::line(sprintf(
    "Внасям %d страници от %s%s",
    count($data['pages']),
    $data['base'] ?? '?',
    $dryRun ? '  (ПРОБНО — нищо не се записва)' : ''
));

foreach ($data['pages'] as $page) {
    $oldUrl = (string) ($page['url'] ?? '');
    if ($oldUrl === '') {
        continue;
    }
    $map = $mapping[$oldUrl] ?? [];

    if (!empty($map['skip'])) {
        $stats['skipped']++;
        continue;
    }

    // mapping.csv винаги печели; --auto попълва само празните решения.
    $postType = trim((string) ($map['post_type'] ?? ''));
    $guessed  = false;
    if ($postType === '' && $auto) {
        $postType = mig_guess_post_type($page);
        $guessed  = true;
    }
    $postType = $postType ?: 'page';

    if ($only !== '' && $postType !== $only) {
        continue;
    }
    if (!post_type_exists($postType)) {
        WP_CLI::warning("Непознат тип '$postType' за $oldUrl — пропускам.");
        $stats['skipped']++;
        continue;
    }

    // Заглавието на стария сайт обикновено носи " – Име на сайта" — отрязваме го.
    $title = (string) ($page['title'] ?? '');
    $title = preg_split('/\s+[–—|]\s+/u', $title)[0] ?? $title;
    $title = trim($title) !== '' ? trim($title) : 'Без заглавие';

    $slug = trim((string) ($map['slug'] ?? '')) ?: mig_slug_from($oldUrl, $title);

    // Изображения: първо в медийната библиотека, за да ги вържем в блоковете.
    $urlToId = [];
    foreach ((array) ($page['image_files'] ?? []) as $src => $file) {
        $id = mig_import_image($imgDir . '/' . $file, $title, $dryRun);
        if ($id > 0) {
            $urlToId[$src] = $id;
            $stats['images']++;
        } elseif ($id === -1) {
            $stats['images']++; // пробно пускане: само отчитаме
        }
    }

    $blocks = mig_html_to_blocks((string) ($page['html'] ?? ''), $urlToId);
    if ($blocks === '' && !empty($page['text'])) {
        $blocks = "<!-- wp:paragraph -->\n<p>" . esc_html(mig_esc_block_text((string) $page['text']))
            . "</p>\n<!-- /wp:paragraph -->";
    }

    $existing = mig_find_existing($oldUrl);

    $template = trim((string) ($map['template'] ?? ''));
    if ($template === '' && $auto && $postType === 'page') {
        $template = mig_guess_template($title, $oldUrl, (string) ($page['text'] ?? ''));
    }

    if ($guessed) {
        $stats['guessed']++;
    }

    if ($dryRun) {
        WP_CLI::line(sprintf(
            "  %-9s %-32s %-14s %-34s (%d блока, %d изобр.)",
            $existing ? 'обновява' : 'създава',
            mb_strimwidth($title, 0, 32),
            $postType . ($guessed ? '*' : ''),
            $template !== '' ? basename($template) : '—',
            substr_count($blocks, '<!-- wp:'),
            count($urlToId)
        ));
        $existing ? $stats['updated']++ : $stats['created']++;
        continue;
    }

    $postArr = [
        'post_type'    => $postType,
        'post_status'  => 'publish',
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_content' => $blocks,
        'post_excerpt' => mb_substr(mig_esc_block_text((string) ($page['meta_desc'] ?? $page['text'] ?? '')), 0, 200),
    ];

    if ($existing) {
        $postArr['ID'] = $existing->ID;
        $postId = wp_update_post($postArr, true);
        $stats['updated']++;
    } else {
        $postId = wp_insert_post($postArr, true);
        $stats['created']++;
    }

    if (is_wp_error($postId) || !$postId) {
        WP_CLI::warning("Грешка при $oldUrl: " . (is_wp_error($postId) ? $postId->get_error_message() : '?'));
        continue;
    }
    $postId = (int) $postId;

    update_post_meta($postId, '_migrated_from', $oldUrl);

    if ($template !== '' && $postType === 'page') {
        update_post_meta($postId, '_wp_page_template', $template);
    }

    // Метаполета според типа, за да се напълнят кутиите на темата.
    $typeMeta = match ($postType) {
        'engine_filter' => mig_extract_engine_meta($page),
        'product'       => mig_extract_product_meta($page),
        default         => [],
    };
    foreach ($typeMeta as $k => $v) {
        update_post_meta($postId, $k, $v);
    }

    if ($urlToId && !has_post_thumbnail($postId)) {
        set_post_thumbnail($postId, (int) reset($urlToId));
    }

    $target = trim((string) ($map['redirect_to'] ?? ''));
    $oldPath = (string) parse_url($oldUrl, PHP_URL_PATH);
    $oldQuery = (string) parse_url($oldUrl, PHP_URL_QUERY);
    $oldRequest = $oldPath . ($oldQuery !== '' ? '?' . $oldQuery : '');
    $redirects[$oldRequest] = $target !== '' ? $target : '/' . $slug . '/';

    WP_CLI::success(sprintf('%s → %s (%s)', mb_strimwidth($title, 0, 40), get_permalink($postId), $postType));
}

// Готов масив за inc/redirects.php.
if ($redirects && !$dryRun) {
    $lines = [];
    foreach ($redirects as $from => $to) {
        $lines[] = sprintf("        %s => %s,", var_export($from, true), var_export($to, true));
    }
    $snippet = "<?php\n// Генерирано от bin/migrate-import.php — постави в inc/redirects.php\n"
        . "\$redirects = [\n" . implode("\n", $lines) . "\n];\n";
    file_put_contents($dir . '/redirects.generated.php', $snippet);
    WP_CLI::line("Пренасочванията са записани в $dir/redirects.generated.php");
}

WP_CLI::line(sprintf(
    "\nГотово: %d създадени, %d обновени, %d пропуснати, %d изображения.%s",
    $stats['created'], $stats['updated'], $stats['skipped'], $stats['images'],
    $stats['guessed'] > 0
        ? sprintf("\n%d записа са типизирани автоматично (отбелязани с *) — прегледай ги в администрацията.", $stats['guessed'])
        : ''
));
