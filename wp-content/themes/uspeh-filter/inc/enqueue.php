<?php
declare(strict_types=1);

function uspeh_enqueue_assets(): void {
    wp_enqueue_style(
        'uspeh-fonts',
        'https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Montserrat:ital,wght@0,500;0,600;0,700;0,800&family=Source+Sans+3:wght@400;500;600;700&display=swap',
        [],
        null
    );

    wp_enqueue_style('uspeh-main', USPEH_URI . '/assets/css/main.css', ['uspeh-fonts'], USPEH_VERSION);
    wp_enqueue_style('uspeh-home', USPEH_URI . '/assets/css/home.css', ['uspeh-main'], USPEH_VERSION);
    wp_enqueue_style('uspeh-catalog', USPEH_URI . '/assets/css/catalog.css', ['uspeh-main'], USPEH_VERSION);
    wp_enqueue_style('uspeh-pages', USPEH_URI . '/assets/css/pages.css', ['uspeh-main'], USPEH_VERSION);
    wp_enqueue_style('uspeh-components', USPEH_URI . '/assets/css/components.css', ['uspeh-main'], USPEH_VERSION);

    wp_enqueue_script('uspeh-main', USPEH_URI . '/assets/js/main.js', [], USPEH_VERSION, true);
    wp_enqueue_script('uspeh-utm', USPEH_URI . '/assets/js/utm-capture.js', [], USPEH_VERSION, true);
    wp_enqueue_script('uspeh-file-upload', USPEH_URI . '/assets/js/file-upload.js', [], USPEH_VERSION, true);
    wp_enqueue_script('uspeh-popup-form', USPEH_URI . '/assets/js/popup-form.js', ['uspeh-main'], USPEH_VERSION, true);

    if (is_post_type_archive('engine_filter') || is_singular('engine_filter') || is_tax(['engine_filter_type', 'vehicle_type', 'vehicle_make'])) {
        wp_enqueue_script(
            'uspeh-engine-search',
            USPEH_URI . '/assets/js/engine-search.js',
            [],
            USPEH_VERSION,
            true
        );
        wp_localize_script('uspeh-engine-search', 'uspehAjax', [
            'url'   => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('uspeh_engine_search'),
        ]);
    }

    wp_localize_script('uspeh-main', 'uspehData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('uspeh_general'),
        'homeUrl' => home_url('/'),
    ]);
}
add_action('wp_enqueue_scripts', 'uspeh_enqueue_assets');

function uspeh_enqueue_admin_assets(string $hook): void {
    if (in_array($hook, ['post.php', 'post-new.php'], true)) {
        wp_enqueue_style(
            'uspeh-admin',
            USPEH_URI . '/assets/css/admin.css',
            [],
            USPEH_VERSION
        );
    }
}
add_action('admin_enqueue_scripts', 'uspeh_enqueue_admin_assets');
