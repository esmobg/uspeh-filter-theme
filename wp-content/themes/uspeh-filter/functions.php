<?php
declare(strict_types=1);

define('USPEH_VERSION', '1.4.1');
define('USPEH_DIR', get_template_directory());
define('USPEH_URI', get_template_directory_uri());

require_once USPEH_DIR . '/inc/enqueue.php';
require_once USPEH_DIR . '/inc/custom-post-types.php';
require_once USPEH_DIR . '/inc/taxonomies.php';
require_once USPEH_DIR . '/inc/meta-boxes.php';
require_once USPEH_DIR . '/inc/engine-filter-meta.php';
require_once USPEH_DIR . '/inc/inquiry-cpt.php';
require_once USPEH_DIR . '/inc/admin-columns.php';
require_once USPEH_DIR . '/inc/ajax-handlers.php';
require_once USPEH_DIR . '/inc/engine-search.php';
require_once USPEH_DIR . '/inc/forms.php';
require_once USPEH_DIR . '/inc/email-notifications.php';
require_once USPEH_DIR . '/inc/utm-tracking.php';
require_once USPEH_DIR . '/inc/schema-markup.php';
require_once USPEH_DIR . '/inc/redirects.php';
require_once USPEH_DIR . '/inc/helpers.php';
require_once USPEH_DIR . '/inc/block-patterns.php';

function uspeh_setup(): void {
    load_theme_textdomain('uspeh-filter', USPEH_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');

    set_post_thumbnail_size(800, 600, true);
    add_image_size('product-card', 600, 600, true);
    add_image_size('product-gallery', 1200, 900, true);
    add_image_size('hero-slide', 1920, 800, true);

    register_nav_menus([
        'primary'      => __('Основно меню', 'uspeh-filter'),
        'footer'       => __('Футър меню', 'uspeh-filter'),
        'mobile'       => __('Мобилно меню', 'uspeh-filter'),
        'footer-legal' => __('Правна информация', 'uspeh-filter'),
    ]);
}
add_action('after_setup_theme', 'uspeh_setup');

function uspeh_widgets_init(): void {
    register_sidebar([
        'name'          => __('Футър колона 1', 'uspeh-filter'),
        'id'            => 'footer-1',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget__title">',
        'after_title'   => '</h4>',
    ]);
    register_sidebar([
        'name'          => __('Футър колона 2', 'uspeh-filter'),
        'id'            => 'footer-2',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget__title">',
        'after_title'   => '</h4>',
    ]);
    register_sidebar([
        'name'          => __('Футър колона 3', 'uspeh-filter'),
        'id'            => 'footer-3',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget__title">',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'uspeh_widgets_init');

function uspeh_allow_svg_upload(array $mimes): array {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'uspeh_allow_svg_upload');

function uspeh_excerpt_length(): int {
    return 25;
}
add_filter('excerpt_length', 'uspeh_excerpt_length');

function uspeh_excerpt_more(): string {
    return '...';
}
add_filter('excerpt_more', 'uspeh_excerpt_more');

function uspeh_flush_rewrites(): void {
    uspeh_register_product_cpt();
    uspeh_register_taxonomies();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'uspeh_flush_rewrites');

function uspeh_maybe_flush_rewrites(): void {
    $stored = get_option('uspeh_rewrite_version', '');
    if ($stored !== USPEH_VERSION) {
        flush_rewrite_rules(false);
        update_option('uspeh_rewrite_version', USPEH_VERSION);
    }
}
add_action('init', 'uspeh_maybe_flush_rewrites', 99);

function uspeh_remove_noindex_production(array $robots): array {
    if (!defined('WP_LOCAL_DEV') || !WP_LOCAL_DEV) {
        unset($robots['noindex']);
        $robots['index'] = true;
        $robots['follow'] = true;
    }
    return $robots;
}
add_filter('wp_robots', 'uspeh_remove_noindex_production');
