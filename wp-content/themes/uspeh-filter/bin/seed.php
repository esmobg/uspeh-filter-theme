<?php
/**
 * Idempotent seed for local MVP content.
 *
 * Run: docker compose run --rm wpcli wp eval-file /var/www/html/wp-content/themes/uspeh-filter/bin/seed.php
 */

if (!defined('ABSPATH')) {
    fwrite(STDERR, "This file must be run via WP-CLI eval-file.\n");
    exit(1);
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

update_option('blogname', 'Успех Филтър ССБ');
update_option('blogdescription', 'Български производител на професионални филтри');
update_option('permalink_structure', '/%postname%/');
flush_rewrite_rules();

foreach (get_posts(['post_type' => 'post', 'post_status' => 'any', 'numberposts' => 20]) as $default_post) {
    if (in_array($default_post->post_name, ['hello-world', 'zdravei-sviat'], true) || 'Здравей, свят!' === $default_post->post_title) {
        wp_delete_post($default_post->ID, true);
    }
}

$attachment_ids = [];

function uspeh_seed_attachment(string $filename, array &$cache): int {
    if (isset($cache[$filename])) {
        return $cache[$filename];
    }

    $existing = get_posts([
        'post_type'      => 'attachment',
        'title'          => $filename,
        'posts_per_page' => 1,
        'post_status'    => 'inherit',
        'fields'         => 'ids',
    ]);
    if ($existing) {
        $cache[$filename] = (int) $existing[0];
        return $cache[$filename];
    }

    $src = get_template_directory() . '/assets/images/' . $filename;
    if (!is_readable($src)) {
        return 0;
    }

    $upload = wp_upload_bits($filename, null, (string) file_get_contents($src));
    if (!empty($upload['error'])) {
        return 0;
    }

    $filetype = wp_check_filetype($filename);
    $attach_id = wp_insert_attachment([
        'post_mime_type' => $filetype['type'] ?: 'image/jpeg',
        'post_title'     => $filename,
        'post_status'    => 'inherit',
    ], $upload['file']);

    if ($attach_id && !is_wp_error($attach_id)) {
        wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $upload['file']));
        $cache[$filename] = (int) $attach_id;
        return (int) $attach_id;
    }

    return 0;
}

function uspeh_seed_page(string $slug, string $title, string $template, string $content = ''): int {
    $existing = get_page_by_path($slug);
    if ($existing instanceof WP_Post) {
        update_post_meta($existing->ID, '_wp_page_template', $template);
        return $existing->ID;
    }

    $id = wp_insert_post([
        'post_type'    => 'page',
        'post_status'  => 'publish',
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_content' => $content,
    ]);

    if (is_wp_error($id) || !$id) {
        return 0;
    }

    update_post_meta((int) $id, '_wp_page_template', $template);
    return (int) $id;
}

function uspeh_seed_term(string $taxonomy, string $slug, string $name, string $description = '', int $parent = 0): int {
    $existing = get_term_by('slug', $slug, $taxonomy);
    if ($existing instanceof WP_Term) {
        return (int) $existing->term_id;
    }
    $result = wp_insert_term($name, $taxonomy, [
        'slug'        => $slug,
        'description' => $description,
        'parent'      => $parent,
    ]);
    if (is_wp_error($result)) {
        return 0;
    }
    return (int) $result['term_id'];
}

$slide1 = uspeh_seed_attachment('slide1.jpg', $attachment_ids);
$slide2 = uspeh_seed_attachment('slide2.jpg', $attachment_ids);
$slide3 = uspeh_seed_attachment('slide3.jpg', $attachment_ids);
$prod   = uspeh_seed_attachment('page-production.jpg', $attachment_ids);
$qual   = uspeh_seed_attachment('page-quality.jpg', $attachment_ids);
$about  = uspeh_seed_attachment('page-about.jpg', $attachment_ids);

$home_id = uspeh_seed_page('nachalo', 'Начало', 'default');
update_option('show_on_front', 'page');
update_option('page_on_front', $home_id);

uspeh_seed_page('poiskaj-oferta', 'Поискай оферта', 'page-templates/template-quote.php');
uspeh_seed_page('individualno-proizvodstvo', 'Индивидуално производство', 'page-templates/template-custom-production.php');
$hepa_page = uspeh_seed_page('hepa-filtri', 'HEPA филтри', 'page-templates/template-hepa.php');
$about_page = uspeh_seed_page('za-nas', 'За нас', 'page-templates/template-about.php', 'Успех Филтър ССБ е български производител с над 40 години опит във филтрацията за вентилация, климатизация, HEPA приложения и двигатели.');
if ($about && $about_page) {
    set_post_thumbnail($about_page, $about);
}
uspeh_seed_page('proizvodstvo', 'Производство', 'page-templates/template-production.php', 'Производството включва плисиране, изработка на рамки, сглобяване, лепене, контрол и опаковане.');
uspeh_seed_page('kachestvo', 'Качество и сертификати', 'page-templates/template-quality.php', 'ISO 9001:2015 е рамката на системата за качество. Сертификатите се публикуват като PDF след качване.');
uspeh_seed_page('kontakti', 'Контакти', 'page-templates/template-contact.php');
uspeh_seed_page('blagodaria', 'Благодарим', 'page-templates/template-thank-you.php');
uspeh_seed_page('vaprosi', 'Често задавани въпроси', 'page-templates/template-faq.php');
uspeh_seed_page('prilozhenia', 'Приложения', 'page-templates/template-applications.php');
uspeh_seed_page('referencii', 'Референции', 'default');
uspeh_seed_page('politika-poveritelnost', 'Политика за поверителност', 'default', 'Настоящата политика описва как Успех Филтър ССБ обработва лични данни, събирани чрез формите за запитване на сайта. Данните се използват единствено за обработка на запитването и не се предоставят на трети страни.');
uspeh_seed_page('politika-biskvitki', 'Политика за бисквитки', 'default', 'Сайтът използва само технически необходими бисквитки за функционирането на формите и навигацията. Не използваме маркетингови или проследяващи бисквитки без изрично съгласие.');

$predfitri = uspeh_seed_term('product_cat', 'predfitri', 'Предфилтри', 'Класове G2–G4 и ISO 16890 за предварителна филтрация.');
$fini      = uspeh_seed_term('product_cat', 'fini-filtri', 'Фини филтри', 'Втора степен на филтрация. Класове M5/M6 до F9.');
$epa       = uspeh_seed_term('product_cat', 'epa', 'EPA филтри', 'Класове E10–E12 по EN 1822.');
$hepa      = uspeh_seed_term('product_cat', 'hepa', 'HEPA филтри', 'Класове H13–H14 за приложения с високи изисквания към чистотата.');
$ulpa      = uspeh_seed_term('product_cat', 'ulpa', 'ULPA филтри', 'Класове U15–U17.');
$karbon    = uspeh_seed_term('product_cat', 'karbonovi', 'Карбонови филтри', 'Контрол на миризми и газообразни замърсители.');
uspeh_seed_term('product_cat', 'panelni', 'Панелни филтри');
uspeh_seed_term('product_cat', 'dzhobni', 'Джобни филтри');
uspeh_seed_term('product_cat', 'mini-pleat', 'Mini Pleat');
uspeh_seed_term('product_cat', 'deep-pleat', 'Deep Pleat');
uspeh_seed_term('product_cat', 'kompaktni', 'Компактни филтри');
uspeh_seed_term('product_cat', 'filturni-materii', 'Филтърни материи');
$industrial = uspeh_seed_term('product_cat', 'industrialni', 'Индустриални филтри', 'Прахови камери, сушилни, прахово боядисване.');
uspeh_seed_term('product_cat', 'prahovi-kameri', 'Филтри за прахови камери', '', $industrial);
uspeh_seed_term('product_cat', 'sushilni', 'Филтри за сушилни', '', $industrial);
uspeh_seed_term('product_cat', 'prahovo-boyadisvane', 'Филтри за прахово боядисване', '', $industrial);
$others = uspeh_seed_term('product_cat', 'drugi', 'Други продукти');
uspeh_seed_term('product_cat', 'kupe', 'Филтри за купе', '', $others);
uspeh_seed_term('product_cat', 'eko-filtri', 'Еко-филтри', '', $others);
uspeh_seed_term('product_cat', 'maski', 'Филтри за маски', '', $others);

uspeh_seed_term('engine_filter_type', 'vazdushen', 'Въздушен');
uspeh_seed_term('engine_filter_type', 'maslen', 'Маслен');
uspeh_seed_term('engine_filter_type', 'goriven', 'Горивен');
uspeh_seed_term('vehicle_type', 'kamioni', 'Камиони');
uspeh_seed_term('vehicle_type', 'avtobusi', 'Автобуси');
uspeh_seed_term('vehicle_type', 'selskostopanska', 'Селскостопанска техника');
uspeh_seed_term('vehicle_type', 'stroitelna', 'Строителна техника');
uspeh_seed_term('vehicle_make', 'man', 'MAN');
uspeh_seed_term('vehicle_make', 'mercedes-benz', 'Mercedes-Benz');
uspeh_seed_term('vehicle_make', 'volvo', 'Volvo');
uspeh_seed_term('vehicle_make', 'scania', 'Scania');
uspeh_seed_term('vehicle_make', 'daf', 'DAF');
uspeh_seed_term('vehicle_make', 'iveco', 'Iveco');
uspeh_seed_term('vehicle_make', 'john-deere', 'John Deere');
uspeh_seed_term('vehicle_make', 'caterpillar', 'Caterpillar');
uspeh_seed_term('tech_topic', 'standarti', 'Стандарти и класове');
uspeh_seed_term('tech_topic', 'poddrazhka', 'Поддръжка и експлоатация');

$products = [
    [
        'slug'  => 'panelen-predfiltar-g4',
        'title' => 'Панелен предфилтър G4',
        'cats'  => ['predfitri', 'panelni'],
        'class' => 'G4 / ISO Coarse',
        'img'   => $slide1,
        'excerpt' => 'Панелен филтър за първа степен на филтрация в климатични и вентилационни камери.',
        'content' => 'Предфилтрите задържат едър прах и предпазват следващите степени. Класове G2–G4 с съответствие по ISO 16890 за предварителна филтрация.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'G4'],
            ['param' => 'Стандарт', 'value' => 'EN 779 / ISO 16890'],
            ['param' => 'Рамка', 'value' => 'Картон / метал / пластмаса'],
            ['param' => 'Начално съпротивление', 'value' => '45–80 Pa'],
            ['param' => 'Работна температура', 'value' => 'до 70 °C'],
        ],
    ],
    [
        'slug'  => 'dzhoben-predfiltar-g4',
        'title' => 'Джобен предфилтър G4',
        'cats'  => ['predfitri', 'dzhobni'],
        'class' => 'G4',
        'img'   => $slide1,
        'excerpt' => 'Джобна конструкция за по-голяма филтрираща повърхност при предварителна филтрация.',
        'content' => 'Подходящ за вентилационни камери, където е нужна по-голяма прахоемкост спрямо панелния тип.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'G4'],
            ['param' => 'Конструкция', 'value' => 'Джобна'],
            ['param' => 'Стандарт', 'value' => 'EN 779 / ISO 16890'],
        ],
    ],
    [
        'slug'  => 'zig-zag-fin-f7',
        'title' => 'Zig-Zag фин филтър F7',
        'cats'  => ['fini-filtri'],
        'class' => 'F7 / ePM1',
        'img'   => $slide2,
        'excerpt' => 'Фин филтър втора степен за климатични камери.',
        'content' => 'Фините филтри са втора степен на филтрация. Класове от M5/M6 до F9.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'F7'],
            ['param' => 'Конструкция', 'value' => 'Zig-Zag'],
            ['param' => 'Стандарт', 'value' => 'EN 779 / ISO 16890'],
        ],
    ],
    [
        'slug'  => 'dzhoben-fin-f9',
        'title' => 'Джобен фин филтър F9',
        'cats'  => ['fini-filtri', 'dzhobni'],
        'class' => 'F9',
        'img'   => $slide2,
        'excerpt' => 'Високоефективен джобен филтър за втора степен.',
        'content' => 'Използва се след предфилтър в системи с повишени изисквания към чистотата на приточния въздух.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'F9'],
            ['param' => 'Конструкция', 'value' => 'Джобна'],
        ],
    ],
    [
        'slug'  => 'mini-pleat-f7',
        'title' => 'Mini Pleat F7',
        'cats'  => ['fini-filtri', 'mini-pleat'],
        'class' => 'F7',
        'img'   => $slide2,
        'excerpt' => 'Компактна Mini Pleat конструкция с голяма филтрираща площ.',
        'content' => 'Mini Pleat технология за фина филтрация при ограничена монтажна дълбочина.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'F7'],
            ['param' => 'Конструкция', 'value' => 'Mini Pleat'],
        ],
    ],
    [
        'slug'  => 'hepa-h13-mini-pleat',
        'title' => 'HEPA H13 Mini Pleat',
        'cats'  => ['hepa', 'mini-pleat'],
        'class' => 'H13',
        'img'   => $slide2,
        'excerpt' => 'HEPA H13 Mini Pleat за болници, лаборатории и чисти помещения.',
        'content' => 'Високоефективен филтър по EN 1822. Всеки филтър преминава контрол преди доставка.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'H13'],
            ['param' => 'Стандарт', 'value' => 'EN 1822'],
            ['param' => 'Ефективност', 'value' => '≥ 99.95 %'],
            ['param' => 'Конструкция', 'value' => 'Mini Pleat'],
            ['param' => 'Начално съпротивление', 'value' => '250 Pa'],
            ['param' => 'Крайно препоръчително съпротивление', 'value' => '500 Pa'],
            ['param' => 'Работна температура', 'value' => 'до 70 °C'],
        ],
    ],
    [
        'slug'  => 'hepa-h14-deep-pleat',
        'title' => 'HEPA H14 Deep Pleat',
        'cats'  => ['hepa', 'deep-pleat'],
        'class' => 'H14',
        'img'   => $slide2,
        'excerpt' => 'HEPA H14 Deep Pleat за фармация, електроника и чисти помещения.',
        'content' => 'Deep Pleat конструкция за по-висок дебит при клас H14.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'H14'],
            ['param' => 'Стандарт', 'value' => 'EN 1822'],
            ['param' => 'Ефективност', 'value' => '≥ 99.995 %'],
            ['param' => 'Конструкция', 'value' => 'Deep Pleat'],
        ],
    ],
    [
        'slug'  => 'epa-e11',
        'title' => 'EPA E11',
        'cats'  => ['epa'],
        'class' => 'E11',
        'img'   => $slide2,
        'excerpt' => 'EPA филтър клас E11 за високоефективна филтрация преди HEPA степен.',
        'content' => 'Класове E10–E12 по EN 1822.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'E11'],
            ['param' => 'Стандарт', 'value' => 'EN 1822'],
        ],
    ],
    [
        'slug'  => 'ulpa-u15',
        'title' => 'ULPA U15',
        'cats'  => ['ulpa'],
        'class' => 'U15',
        'img'   => $slide2,
        'excerpt' => 'ULPA филтър за най-строги изисквания към чистотата на въздуха.',
        'content' => 'Класове U15–U17 по EN 1822.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'U15'],
            ['param' => 'Стандарт', 'value' => 'EN 1822'],
        ],
    ],
    [
        'slug'  => 'karbonov-panelen',
        'title' => 'Карбонов панелен филтър',
        'cats'  => ['karbonovi', 'panelni'],
        'class' => 'Активен въглен',
        'img'   => $slide1,
        'excerpt' => 'Панелен карбонов филтър за миризми и газообразни замърсители.',
        'content' => 'Приложение: контрол на миризми във вентилационни и климатични системи. Налични панелни, плисирани и цилиндрични изпълнения.',
        'specs' => [
            ['param' => 'Тип', 'value' => 'Панелен с активен въглен'],
            ['param' => 'Приложение', 'value' => 'Миризми и газове'],
        ],
    ],
    [
        'slug'  => 'kompakten-w-f7',
        'title' => 'Компактен W филтър F7',
        'cats'  => ['fini-filtri', 'kompaktni'],
        'class' => 'F7',
        'img'   => $slide3,
        'excerpt' => 'Компактна W конструкция за климатични камери.',
        'content' => 'Висока филтрираща повърхност при компактни габарити.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'F7'],
            ['param' => 'Конструкция', 'value' => 'Компактна W'],
        ],
    ],
    [
        'slug'  => 'filtarna-materia-g3',
        'title' => 'Филтърна материя G3',
        'cats'  => ['filturni-materii', 'predfitri'],
        'class' => 'G3',
        'img'   => $slide1,
        'excerpt' => 'Филтърна материя за предфилтрация, рязана по размер.',
        'content' => 'Доставя се на рула или нарязана по задание на клиента.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'G3'],
            ['param' => 'Форма', 'value' => 'Материя / руло'],
        ],
    ],
    [
        'slug'  => 'panelen-predfiltar-g3',
        'title' => 'Панелен предфилтър G3',
        'cats'  => ['predfitri', 'panelni'],
        'class' => 'G3 / ISO Coarse',
        'img'   => $slide1,
        'excerpt' => 'Икономичен панелен филтър за първа степен на филтрация.',
        'content' => 'Подходящ за системи с умерени изисквания към предварителната филтрация — битова и офис вентилация, рекуператори.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'G3'],
            ['param' => 'Стандарт', 'value' => 'EN 779 / ISO 16890'],
            ['param' => 'Рамка', 'value' => 'Картон / пластмаса'],
        ],
    ],
    [
        'slug'  => 'dzhoben-fin-f7',
        'title' => 'Джобен фин филтър F7',
        'cats'  => ['fini-filtri', 'dzhobni'],
        'class' => 'F7 / ePM1',
        'img'   => $slide2,
        'excerpt' => 'Най-търсеният клас за финална филтрация в комфортната вентилация.',
        'content' => 'Джобен филтър F7 по ISO 16890 (ePM1 ≥ 50%). Стандартни и нестандартни размери, брой джобове по задание.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'F7'],
            ['param' => 'Конструкция', 'value' => 'Джобна'],
            ['param' => 'Стандарт', 'value' => 'ISO 16890 ePM1'],
            ['param' => 'Начално съпротивление', 'value' => '95–120 Pa'],
        ],
    ],
    [
        'slug'  => 'mini-pleat-f9',
        'title' => 'Mini Pleat F9',
        'cats'  => ['fini-filtri', 'mini-pleat'],
        'class' => 'F9',
        'img'   => $slide2,
        'excerpt' => 'Максимална фина филтрация преди EPA/HEPA степен.',
        'content' => 'Mini Pleat касета F9 — типична предпоследна степен преди HEPA филтрация в болници и чисти помещения.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'F9'],
            ['param' => 'Конструкция', 'value' => 'Mini Pleat'],
        ],
    ],
    [
        'slug'  => 'hepa-h13-s-razdelitely',
        'title' => 'HEPA H13 с разделители',
        'cats'  => ['hepa', 'deep-pleat'],
        'class' => 'H13',
        'img'   => $slide2,
        'excerpt' => 'Класическа конструкция с алуминиеви разделители за висок дебит.',
        'content' => 'Deep Pleat HEPA H13 за вентилационни системи с висок дебит — индустриални чисти зони, боядисъчни камери с рекуперация.',
        'specs' => [
            ['param' => 'Клас', 'value' => 'H13'],
            ['param' => 'Стандарт', 'value' => 'EN 1822'],
            ['param' => 'Ефективност', 'value' => '≥ 99.95 %'],
            ['param' => 'Конструкция', 'value' => 'Deep Pleat с разделители'],
        ],
    ],
    [
        'slug'  => 'karbonov-cilindrichen',
        'title' => 'Карбонов цилиндричен филтър',
        'cats'  => ['karbonovi'],
        'class' => 'Активен въглен',
        'img'   => $slide1,
        'excerpt' => 'Цилиндрична касета с активен въглен за газове и миризми.',
        'content' => 'Използва се в кухненски аспирации, лаборатории и системи за контрол на миризми. Възможност за презареждане на въглена.',
        'specs' => [
            ['param' => 'Тип', 'value' => 'Цилиндричен с активен въглен'],
            ['param' => 'Приложение', 'value' => 'Миризми, ЛОС, газове'],
        ],
    ],
    [
        'slug'  => 'filtar-prahova-kamera',
        'title' => 'Филтър за прахова камера',
        'cats'  => ['industrialni', 'prahovi-kameri'],
        'class' => 'По задание',
        'img'   => $slide3,
        'excerpt' => 'Касети и ръкави за прахоулавящи инсталации.',
        'content' => 'Изработваме филтърни касети и ръкави за прахови камери по образец или чертеж — с антистатични и водоотблъскващи материи при нужда.',
        'specs' => [
            ['param' => 'Тип', 'value' => 'Касета / ръкав'],
            ['param' => 'Изпълнение', 'value' => 'По образец или чертеж'],
        ],
    ],
    [
        'slug'  => 'filtar-prahovo-boyadisvane',
        'title' => 'Филтър за прахово боядисване',
        'cats'  => ['industrialni', 'prahovo-boyadisvane'],
        'class' => 'По задание',
        'img'   => $slide3,
        'excerpt' => 'Филтри за камери за прахово боядисване.',
        'content' => 'Патронни и панелни филтри за камери за прахово боядисване, съвместими с най-разпространените системи.',
        'specs' => [
            ['param' => 'Тип', 'value' => 'Патронен / панелен'],
        ],
    ],
    [
        'slug'  => 'eko-filtar-kupe',
        'title' => 'Еко-филтър за купе',
        'cats'  => ['drugi', 'kupe', 'eko-filtri'],
        'class' => 'Купе',
        'img'   => $slide1,
        'excerpt' => 'Салонен филтър за автомобили — стандартен или с активен въглен.',
        'content' => 'Салонни (купе) филтри за леки и товарни автомобили. Вариант с активен въглен за градска среда.',
        'specs' => [
            ['param' => 'Тип', 'value' => 'Салонен филтър'],
            ['param' => 'Вариант', 'value' => 'Стандартен / активен въглен'],
        ],
    ],
];

foreach ($products as $product) {
    $existing = get_page_by_path($product['slug'], OBJECT, 'product');
    if ($existing) {
        $pid = $existing->ID;
    } else {
        $pid = wp_insert_post([
            'post_type'    => 'product',
            'post_status'  => 'publish',
            'post_title'   => $product['title'],
            'post_name'    => $product['slug'],
            'post_excerpt' => $product['excerpt'],
            'post_content' => $product['content'],
        ]);
    }
    if (!$pid || is_wp_error($pid)) {
        continue;
    }
    wp_set_object_terms((int) $pid, $product['cats'], 'product_cat');
    update_post_meta((int) $pid, '_filter_class', $product['class']);
    update_post_meta((int) $pid, '_supports_custom_sizes', '1');
    update_post_meta((int) $pid, '_specs', $product['specs']);
    update_post_meta((int) $pid, '_advantages', [
        'Собствено производство',
        'Индивидуални размери',
        'Контрол на качеството',
    ]);
    update_post_meta((int) $pid, '_available_sizes', [
        ['w' => '592', 'h' => '592', 'd' => '48'],
        ['w' => '287', 'h' => '592', 'd' => '48'],
    ]);
    update_post_meta((int) $pid, '_applications', 'Климатични камери, вентилация, чисти помещения според класа.');
    update_post_meta((int) $pid, '_materials', 'Синтетична или стъкловлакнеста материя; рамка по спецификация.');
    if (!empty($product['img'])) {
        set_post_thumbnail((int) $pid, $product['img']);
    }
}

$engines = [
    [
        'slug'    => 'uf-2101',
        'title'   => 'UF-2101 Въздушен филтър',
        'catalog' => 'UF-2101',
        'type'    => 'vazdushen',
        'vehicle' => 'kamioni',
        'make'    => 'man',
        'oem'     => ['81259006020', '5100900'],
        'a'       => '278', 'b' => '178', 'h' => '320',
        'img'     => $slide3,
    ],
    [
        'slug'    => 'uf-3302',
        'title'   => 'UF-3302 Маслен филтър',
        'catalog' => 'UF-3302',
        'type'    => 'maslen',
        'vehicle' => 'kamioni',
        'make'    => 'mercedes-benz',
        'oem'     => ['A0001802609'],
        'a'       => '96', 'b' => '96', 'h' => '142',
        'img'     => $slide3,
    ],
    [
        'slug'    => 'uf-4501',
        'title'   => 'UF-4501 Горивен филтър',
        'catalog' => 'UF-4501',
        'type'    => 'goriven',
        'vehicle' => 'avtobusi',
        'make'    => 'volvo',
        'oem'     => ['20976003'],
        'a'       => '85', 'b' => '85', 'h' => '170',
        'img'     => $slide3,
    ],
    [
        'slug'    => 'uf-2102',
        'title'   => 'UF-2102 Въздушен филтър',
        'catalog' => 'UF-2102',
        'type'    => 'vazdushen',
        'vehicle' => 'kamioni',
        'make'    => 'scania',
        'oem'     => ['1869993', '1421021'],
        'a'       => '304', 'b' => '304', 'h' => '400',
        'img'     => $slide3,
    ],
    [
        'slug'    => 'uf-2103',
        'title'   => 'UF-2103 Въздушен филтър',
        'catalog' => 'UF-2103',
        'type'    => 'vazdushen',
        'vehicle' => 'kamioni',
        'make'    => 'daf',
        'oem'     => ['1310901', '1657525'],
        'a'       => '265', 'b' => '265', 'h' => '360',
        'img'     => $slide3,
    ],
    [
        'slug'    => 'uf-2104',
        'title'   => 'UF-2104 Въздушен филтър',
        'catalog' => 'UF-2104',
        'type'    => 'vazdushen',
        'vehicle' => 'selskostopanska',
        'make'    => 'john-deere',
        'oem'     => ['AL172780', 'RE68048'],
        'a'       => '210', 'b' => '210', 'h' => '295',
        'img'     => $slide3,
    ],
    [
        'slug'    => 'uf-2105',
        'title'   => 'UF-2105 Въздушен филтър',
        'catalog' => 'UF-2105',
        'type'    => 'vazdushen',
        'vehicle' => 'stroitelna',
        'make'    => 'caterpillar',
        'oem'     => ['1421339', '6I-2501'],
        'a'       => '240', 'b' => '240', 'h' => '330',
        'img'     => $slide3,
    ],
    [
        'slug'    => 'uf-3303',
        'title'   => 'UF-3303 Маслен филтър',
        'catalog' => 'UF-3303',
        'type'    => 'maslen',
        'vehicle' => 'kamioni',
        'make'    => 'man',
        'oem'     => ['51055040108'],
        'a'       => '110', 'b' => '110', 'h' => '155',
        'img'     => $slide3,
    ],
    [
        'slug'    => 'uf-3304',
        'title'   => 'UF-3304 Маслен филтър',
        'catalog' => 'UF-3304',
        'type'    => 'maslen',
        'vehicle' => 'avtobusi',
        'make'    => 'iveco',
        'oem'     => ['2996570'],
        'a'       => '93', 'b' => '93', 'h' => '148',
        'img'     => $slide3,
    ],
    [
        'slug'    => 'uf-4502',
        'title'   => 'UF-4502 Горивен филтър',
        'catalog' => 'UF-4502',
        'type'    => 'goriven',
        'vehicle' => 'kamioni',
        'make'    => 'scania',
        'oem'     => ['1873016'],
        'a'       => '92', 'b' => '92', 'h' => '186',
        'img'     => $slide3,
    ],
    [
        'slug'    => 'uf-4503',
        'title'   => 'UF-4503 Горивен филтър',
        'catalog' => 'UF-4503',
        'type'    => 'goriven',
        'vehicle' => 'selskostopanska',
        'make'    => 'john-deere',
        'oem'     => ['RE522688'],
        'a'       => '88', 'b' => '88', 'h' => '162',
        'img'     => $slide3,
    ],
    [
        'slug'    => 'uf-4504',
        'title'   => 'UF-4504 Горивен филтър',
        'catalog' => 'UF-4504',
        'type'    => 'goriven',
        'vehicle' => 'kamioni',
        'make'    => 'mercedes-benz',
        'oem'     => ['A4570920001'],
        'a'       => '90', 'b' => '90', 'h' => '175',
        'img'     => $slide3,
    ],
];

foreach ($engines as $engine) {
    $existing = get_page_by_path($engine['slug'], OBJECT, 'engine_filter');
    if ($existing) {
        $eid = $existing->ID;
    } else {
        $eid = wp_insert_post([
            'post_type'   => 'engine_filter',
            'post_status' => 'publish',
            'post_title'  => $engine['title'],
            'post_name'   => $engine['slug'],
        ]);
    }
    if (!$eid || is_wp_error($eid)) {
        continue;
    }
    wp_set_object_terms((int) $eid, [$engine['type']], 'engine_filter_type');
    wp_set_object_terms((int) $eid, [$engine['vehicle']], 'vehicle_type');
    wp_set_object_terms((int) $eid, [$engine['make']], 'vehicle_make');
    update_post_meta((int) $eid, '_catalog_number', $engine['catalog']);
    update_post_meta((int) $eid, '_oem_numbers', $engine['oem']);
    update_post_meta((int) $eid, '_dim_a', $engine['a']);
    update_post_meta((int) $eid, '_dim_b', $engine['b']);
    update_post_meta((int) $eid, '_dim_h', $engine['h']);
    if (!empty($engine['img'])) {
        set_post_thumbnail((int) $eid, $engine['img']);
    }
}

$apps = [
    [
        'slug'    => 'bolnici',
        'title'   => 'Болници',
        'excerpt' => 'HEPA H13/H14 за операционни зали и изолационни стаи, F7–F9 за общите зони.',
        'content' => 'В болнична среда филтрацията е част от инфекциозния контрол. За операционни зали и изолационни стаи препоръчваме HEPA филтри клас H13 или H14 по EN 1822, с индивидуален протокол от изпитване за всеки филтър. Общите зони се обслужват от каскада предфилтър G4 плюс фин филтър F7–F9. Изработваме филтри по точния размер на съществуващите касети, за да се избегне подмяна на рамките.',
    ],
    [
        'slug'    => 'farmacia',
        'title'   => 'Фармация',
        'excerpt' => 'Валидируеми HEPA решения за производствени зони по GMP изисквания.',
        'content' => 'Фармацевтичното производство изисква документирана филтрация с проследимост. Доставяме HEPA филтри H14 с протокол за всеки брой, включително изпълнения с гел-уплътнение за DOP тестване на място. Предлагаме и карбонови степени за задържане на активни субстанции и разтворители.',
    ],
    [
        'slug'    => 'chisti-pomeshtenia',
        'title'   => 'Чисти помещения',
        'excerpt' => 'Филтърни касети за класове по ISO 14644 — от ISO 8 до ISO 5.',
        'content' => 'За постигане на клас на чистота по ISO 14644 подбираме финалната степен според изискването: H13 за ISO 7–8, H14 или U15 за ISO 5–6. Изработваме таванни касети, филтърни модули за FFU и уплътнения по конкретното задание.',
    ],
    [
        'slug'    => 'industria',
        'title'   => 'Индустрия',
        'excerpt' => 'Прахоулавяне, боядисъчни камери, сушилни и компресорни станции.',
        'content' => 'Индустриалните приложения често изискват нестандартни размери и устойчивост на температура, влага или абразивни частици. Изработваме касети, ръкави и патрони по образец или чертеж — включително антистатични и водоотблъскващи изпълнения.',
    ],
    [
        'slug'    => 'hoteli',
        'title'   => 'Хотели',
        'excerpt' => 'Комфортна филтрация с ниско енергийно потребление.',
        'content' => 'В хотелската вентилация балансът между качество на въздуха и енергийни разходи е ключов. Джобните филтри F7 с оптимизирана прахоемкост поддържат ниско съпротивление по-дълго, което намалява потреблението на вентилаторите. Поддържаме складова наличност за редовна подмяна.',
    ],
    [
        'slug'    => 'ofis-sgradi',
        'title'   => 'Офис сгради',
        'excerpt' => 'ISO ePM1 филтрация за приточния въздух в административни сгради.',
        'content' => 'Съвременните офис сгради се проектират с филтрация по ISO 16890 — обичайно ePM1 50% (F7) на финална степен. Предлагаме пълна каскада с предфилтър, както и карбонови степени за сгради в натоварена градска среда.',
    ],
    [
        'slug'    => 'laboratorii',
        'title'   => 'Лаборатории',
        'excerpt' => 'EPA и HEPA степени за ламинарни боксове и изпитвателни зони.',
        'content' => 'За лабораторна среда доставяме EPA E11–E12 и HEPA H13–H14 касети за ламинарни боксове, шкафове за биологична безопасност и изпитвателни помещения, включително карбонови степени при работа с летливи вещества.',
    ],
    [
        'slug'    => 'hranitelno-vkusova',
        'title'   => 'Хранително-вкусова промишленост',
        'excerpt' => 'Филтрация за производствени и опаковъчни зони с хигиенни изисквания.',
        'content' => 'В хранителната индустрия филтрацията предпазва продукта в зоните на пълнене и опаковане. Използваме материали, подходящи за влажна среда и почистване, а при нужда изработваме филтри с неръждаема рамка.',
    ],
    [
        'slug'    => 'boyadisachni-kameri',
        'title'   => 'Боядисъчни камери',
        'excerpt' => 'Таванни материи, подови филтри и финални степени за камери за боядисване.',
        'content' => 'Пълна гама за боядисъчни камери: таванна филтрираща материя, подови (paint stop) филтри и финални степени. Изработваме по размерите на конкретната камера, включително за стари инсталации без наличен оригинален номер.',
    ],
];
foreach ($apps as $app) {
    if (get_page_by_path($app['slug'], OBJECT, 'application')) {
        continue;
    }
    $aid = wp_insert_post([
        'post_type'    => 'application',
        'post_status'  => 'publish',
        'post_title'   => $app['title'],
        'post_name'    => $app['slug'],
        'post_excerpt' => $app['excerpt'],
        'post_content' => $app['content'],
    ]);
    if ($aid && !is_wp_error($aid) && $slide1) {
        set_post_thumbnail((int) $aid, $slide1);
    }
}

$tech_articles = [
    [
        'slug'    => 'iso-16890-sreshtu-en-779',
        'title'   => 'ISO 16890 срещу EN 779: какво се промени',
        'topic'   => 'standarti',
        'excerpt' => 'Защо старите класове G4/M5/F7 отстъпват място на ePM1, ePM2.5 и ePM10.',
        'content' => "EN 779 класифицираше филтрите по задържане на синтетичен прах и по средна ефективност спрямо частици от 0,4 µm. ISO 16890 сменя логиката: филтърът се оценява спрямо реалните прахови фракции във външния въздух — PM1, PM2.5 и PM10.\n\nПрактическата разлика е, че вече избирате филтър според това коя фракция искате да задържите. Филтър, обявен като ePM1 50%, задържа поне половината от частиците под 1 µm — точно тези, които достигат до белодробните алвеоли. Приблизителното съответствие със стария F7 е ePM1 50–65%, но точното съответствие зависи от конкретния филтър и не бива да се приема автоматично.\n\nЗа проектантите това означава, че спецификацията трябва да се актуализира: „филтър F7\" вече не е достатъчно еднозначно за нови проекти.",
    ],
    [
        'slug'    => 'koga-se-smenya-filtar',
        'title'   => 'Кога се сменя въздушен филтър',
        'topic'   => 'poddrazhka',
        'excerpt' => 'Крайното съпротивление, а не календарът, определя момента на подмяна.',
        'content' => "Най-честата грешка при поддръжката е подмяна по календар. Правилният критерий е достигнатото крайно съпротивление, измерено с манометър през филтърната степен.\n\nОриентировъчни стойности: предфилтри G3–G4 се сменят при 150–200 Pa, фини филтри F7–F9 при 300–450 Pa, HEPA степени при двойно начално съпротивление или по указание на производителя. Работата над крайното съпротивление увеличава енергийните разходи на вентилатора и рискува пробив на материята.\n\nПри липса на манометър приемете за отправна точка 3–6 месеца за предфилтри и 6–12 месеца за фини филтри, като коригирате според запрашеността на средата.",
    ],
    [
        'slug'    => 'hepa-klasove-en-1822',
        'title'   => 'HEPA класове по EN 1822: E10 до U17',
        'topic'   => 'standarti',
        'excerpt' => 'Какво означава MPPS и защо H13 не е същото като H14.',
        'content' => "EN 1822 класифицира високоефективните филтри по ефективност спрямо MPPS — най-трудно задържания размер частица, обичайно между 0,1 и 0,3 µm. Това е най-неблагоприятният случай: за всички други размери филтърът задържа повече.\n\nКласовете E10–E12 (EPA) покриват 85–99,5%. H13 задържа минимум 99,95%, H14 — минимум 99,995%. Разликата изглежда малка, но в брой преминали частици е десетократна: при H13 през филтъра минават 5 от 10 000 частици, при H14 — 5 от 100 000.\n\nЗа класове H13 и нагоре всеки отделен филтър подлежи на индивидуално изпитване и се доставя с протокол — серийна декларация не е достатъчна.",
    ],
    [
        'slug'    => 'energiyna-efektivnost-na-filtrite',
        'title'   => 'Енергийна ефективност на филтрите',
        'topic'   => 'poddrazhka',
        'excerpt' => 'Филтърът е под 10% от разхода за филтрация — останалото плаща вентилаторът.',
        'content' => "При изчисляване на цената на филтрацията покупната цена на филтъра е малката част. Основният разход е електроенергията, която вентилаторът изразходва, за да преодолее съпротивлението на филтъра през целия му експлоатационен живот.\n\nФилтър с по-голяма филтрираща повърхност струва повече, но започва с по-ниско начално съпротивление и го задържа по-дълго. При работа 24/7 разликата в потреблението често изплаща по-скъпия филтър в рамките на един цикъл на подмяна.\n\nEurovent класифицира филтрите по енергийна ефективност (A+ до E) точно на тази база. При избор сравнявайте не цената за брой, а очакваното средно съпротивление за периода на експлоатация.",
    ],
];

foreach ($tech_articles as $article) {
    if (get_page_by_path($article['slug'], OBJECT, 'tech_article')) {
        continue;
    }
    $tid = wp_insert_post([
        'post_type'    => 'tech_article',
        'post_status'  => 'publish',
        'post_title'   => $article['title'],
        'post_name'    => $article['slug'],
        'post_excerpt' => $article['excerpt'],
        'post_content' => $article['content'],
    ]);
    if ($tid && !is_wp_error($tid)) {
        wp_set_object_terms((int) $tid, [$article['topic']], 'tech_topic');
        if ($slide2) {
            set_post_thumbnail((int) $tid, $slide2);
        }
    }
}

$posts = [
    [
        'slug'    => 'nova-liniya-mini-pleat',
        'title'   => 'Разширяваме производството на Mini Pleat касети',
        'excerpt' => 'Нова линия в базата ни в София съкращава сроковете за фини филтри.',
        'content' => "Въведохме в експлоатация допълнителна линия за производство на Mini Pleat касети. Разширението съкращава стандартния срок за изработка на фини филтри по индивидуален размер и увеличава капацитета за поръчки с кратък срок.\n\nЗа клиенти с рамкови договори това означава по-надеждно планиране на подмяната при обекти с голям брой филтърни степени.",
    ],
    [
        'slug'    => 'kak-da-podadete-zapitvane',
        'title'   => 'Как да подадете запитване за нестандартен филтър',
        'excerpt' => 'Три размера и снимка на стария филтър са достатъчни за оферта.',
        'content' => "За да офертираме нестандартен филтър, най-често са ни нужни само три неща: външни размери (широчина, височина, дълбочина), желан филтърен клас и снимка на съществуващия филтър или рамка.\n\nАко нямате данни за класа, опишете приложението — болнична зона, боядисъчна камера, офис вентилация — и ние ще предложим подходящия клас. При по-сложни случаи организираме оглед и замерване на място.",
    ],
    [
        'slug'    => 'podgotovka-za-otoplitelen-sezon',
        'title'   => 'Подготовка на вентилацията за отоплителния сезон',
        'excerpt' => 'Какво да проверите в климатичните камери преди студените месеци.',
        'content' => "Преди началото на отоплителния сезон е добре да се направи пълна проверка на филтърните степени: измерване на текущото съпротивление, оглед за пробиви и деформации на рамките, проверка на уплътненията.\n\nЗапушен филтър през зимата натоварва не само вентилатора, но и топлообменника. Подмяната преди сезона е по-евтина от аварийната намеса в средата му.",
    ],
];

foreach ($posts as $post_data) {
    if (get_page_by_path($post_data['slug'], OBJECT, 'post')) {
        continue;
    }
    $post_id = wp_insert_post([
        'post_type'    => 'post',
        'post_status'  => 'publish',
        'post_title'   => $post_data['title'],
        'post_name'    => $post_data['slug'],
        'post_excerpt' => $post_data['excerpt'],
        'post_content' => $post_data['content'],
    ]);
    if ($post_id && !is_wp_error($post_id) && $prod) {
        set_post_thumbnail((int) $post_id, $prod);
    }
}

$menu_name = 'Основно меню';
$menu = wp_get_nav_menu_object($menu_name);
if (!$menu) {
    $menu_id = wp_create_nav_menu($menu_name);
} else {
    $menu_id = (int) $menu->term_id;
    $items = wp_get_nav_menu_items($menu_id);
    if ($items) {
        foreach ($items as $item) {
            wp_delete_post((int) $item->ID, true);
        }
    }
}

$parent_air = wp_update_nav_menu_item($menu_id, 0, [
    'menu-item-title'  => 'Въздушни филтри',
    'menu-item-url'    => get_post_type_archive_link('product'),
    'menu-item-status' => 'publish',
]);

foreach (['predfitri' => 'Предфилтри', 'fini-filtri' => 'Фини филтри', 'hepa' => 'HEPA филтри', 'karbonovi' => 'Карбонови'] as $slug => $label) {
    $term = get_term_by('slug', $slug, 'product_cat');
    if (!$term) {
        continue;
    }
    wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'      => $label,
        'menu-item-object'     => 'product_cat',
        'menu-item-object-id'  => $term->term_id,
        'menu-item-type'       => 'taxonomy',
        'menu-item-status'     => 'publish',
        'menu-item-parent-id'  => $parent_air,
    ]);
}

wp_update_nav_menu_item($menu_id, 0, [
    'menu-item-title'  => 'HEPA',
    'menu-item-url'    => home_url('/hepa-filtri/'),
    'menu-item-status' => 'publish',
]);
wp_update_nav_menu_item($menu_id, 0, [
    'menu-item-title'  => 'Двигателни филтри',
    'menu-item-url'    => get_post_type_archive_link('engine_filter'),
    'menu-item-status' => 'publish',
]);
wp_update_nav_menu_item($menu_id, 0, [
    'menu-item-title'  => 'Индивидуално производство',
    'menu-item-url'    => home_url('/individualno-proizvodstvo/'),
    'menu-item-status' => 'publish',
]);

$about_parent = wp_update_nav_menu_item($menu_id, 0, [
    'menu-item-title'  => 'За нас',
    'menu-item-url'    => home_url('/za-nas/'),
    'menu-item-status' => 'publish',
]);
wp_update_nav_menu_item($menu_id, 0, [
    'menu-item-title'     => 'Производство',
    'menu-item-url'       => home_url('/proizvodstvo/'),
    'menu-item-status'    => 'publish',
    'menu-item-parent-id' => $about_parent,
]);
wp_update_nav_menu_item($menu_id, 0, [
    'menu-item-title'     => 'Качество',
    'menu-item-url'       => home_url('/kachestvo/'),
    'menu-item-status'    => 'publish',
    'menu-item-parent-id' => $about_parent,
]);
wp_update_nav_menu_item($menu_id, 0, [
    'menu-item-title'  => 'Контакти',
    'menu-item-url'    => home_url('/kontakti/'),
    'menu-item-status' => 'publish',
]);

/**
 * Създава (или изчиства и презарежда) меню от плосък списък [заглавие => URL].
 */
function uspeh_seed_flat_menu(string $menu_name, array $items): int {
    $menu = wp_get_nav_menu_object($menu_name);
    if (!$menu) {
        $id = wp_create_nav_menu($menu_name);
        if (is_wp_error($id)) {
            return 0;
        }
        $id = (int) $id;
    } else {
        $id = (int) $menu->term_id;
        $existing = wp_get_nav_menu_items($id);
        if ($existing) {
            foreach ($existing as $item) {
                wp_delete_post((int) $item->ID, true);
            }
        }
    }

    foreach ($items as $title => $url) {
        wp_update_nav_menu_item($id, 0, [
            'menu-item-title'  => $title,
            'menu-item-url'    => $url,
            'menu-item-status' => 'publish',
        ]);
    }

    return $id;
}

$footer_menu_id = uspeh_seed_flat_menu('Футър — Продукти и услуги', [
    'Въздушни филтри'            => get_post_type_archive_link('product') ?: home_url('/vazdushni-filtri/'),
    'Фини филтри'                => home_url('/vazdushni-filtri/fini-filtri/'),
    'EPA, HEPA, ULPA'            => home_url('/hepa-filtri/'),
    'Карбонови филтри'           => home_url('/vazdushni-filtri/karbonovi/'),
    'Двигателни филтри'          => get_post_type_archive_link('engine_filter') ?: home_url('/dvigatelni-filtri/'),
    'Индивидуално производство'  => home_url('/individualno-proizvodstvo/'),
]);

$footer_company_id = uspeh_seed_flat_menu('Футър — Компания', [
    'За нас'          => home_url('/za-nas/'),
    'Производство'    => home_url('/proizvodstvo/'),
    'Качество'        => home_url('/kachestvo/'),
    'Референции'      => home_url('/referencii/'),
    'Често задавани въпроси' => home_url('/vaprosi/'),
    'Поискай оферта'  => home_url('/poiskaj-oferta/'),
    'Контакти'        => home_url('/kontakti/'),
]);

$footer_legal_id = uspeh_seed_flat_menu('Правна информация', [
    'Поверителност' => home_url('/politika-poveritelnost/'),
    'Бисквитки'     => home_url('/politika-biskvitki/'),
]);

$locations = get_theme_mod('nav_menu_locations');
if (!is_array($locations)) {
    $locations = [];
}
$locations['primary'] = $menu_id;
unset($locations['mobile']);
if ($footer_menu_id) {
    $locations['footer'] = $footer_menu_id;
}
if ($footer_company_id) {
    $locations['footer-company'] = $footer_company_id;
}
if ($footer_legal_id) {
    $locations['footer-legal'] = $footer_legal_id;
}
set_theme_mod('nav_menu_locations', $locations);

flush_rewrite_rules();

WP_CLI::success('Seed completed: pages, menu, categories, products, engine filters.');
