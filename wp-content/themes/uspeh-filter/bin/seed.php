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
uspeh_seed_term('vehicle_make', 'man', 'MAN');
uspeh_seed_term('vehicle_make', 'mercedes-benz', 'Mercedes-Benz');
uspeh_seed_term('vehicle_make', 'volvo', 'Volvo');

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
    ['slug' => 'bolnici', 'title' => 'Болници'],
    ['slug' => 'farmacia', 'title' => 'Фармация'],
    ['slug' => 'chisti-pomeshtenia', 'title' => 'Чисти помещения'],
    ['slug' => 'industria', 'title' => 'Индустрия'],
    ['slug' => 'hoteli', 'title' => 'Хотели'],
    ['slug' => 'ofis-sgradi', 'title' => 'Офис сгради'],
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
        'post_excerpt' => 'Препоръчителни филтри и класове според приложението.',
        'post_content' => 'Подбираме класа и конструкцията според изискванията на обекта. Изпратете техническо задание за оферта.',
    ]);
    if ($aid && !is_wp_error($aid) && $slide1) {
        set_post_thumbnail((int) $aid, $slide1);
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

$locations = get_theme_mod('nav_menu_locations');
if (!is_array($locations)) {
    $locations = [];
}
$locations['primary'] = $menu_id;
$locations['mobile']  = $menu_id;
set_theme_mod('nav_menu_locations', $locations);

flush_rewrite_rules();

WP_CLI::success('Seed completed: pages, menu, categories, products, engine filters.');
