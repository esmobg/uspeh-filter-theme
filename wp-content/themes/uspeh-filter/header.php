<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php
    if (!defined('WPSEO_VERSION') && !defined('RANK_MATH_VERSION')) :
        if (is_front_page()) {
            $uspeh_meta_desc = get_bloginfo('description');
        } elseif (is_singular()) {
            $uspeh_meta_desc = get_the_excerpt();
            if (!$uspeh_meta_desc) {
                $uspeh_meta_desc = wp_trim_words(wp_strip_all_tags(get_the_content()), 25, '...');
            }
            if (!$uspeh_meta_desc) {
                $uspeh_meta_desc = get_the_title() . ' — ' . get_bloginfo('name');
            }
        } elseif (is_archive()) {
            $uspeh_meta_desc = get_the_archive_description() ?: (get_the_archive_title() . ' — ' . get_bloginfo('name'));
        } else {
            $uspeh_meta_desc = get_bloginfo('description');
        }
        if ($uspeh_meta_desc) :
    ?>
    <meta name="description" content="<?php echo esc_attr(wp_trim_words($uspeh_meta_desc, 25, '...')); ?>">
    <?php
        endif;
    endif;
    ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
<a href="#main-content" class="skip-link"><?php esc_html_e('Към съдържанието', 'uspeh-filter'); ?></a>

<header class="site-header" id="site-header">
    <div class="site-header__main">
        <div class="container site-header__main-inner">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-header__logo" aria-label="<?php esc_attr_e('Начало', 'uspeh-filter'); ?>">
                <img src="<?php echo esc_url(USPEH_URI . '/assets/images/logo.png'); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" width="200" height="60" loading="eager">
            </a>

            <nav class="site-nav" id="site-nav" aria-label="<?php esc_attr_e('Основна навигация', 'uspeh-filter'); ?>">
                <?php uspeh_render_primary_navigation(); ?>
            </nav>

            <div class="site-header__actions">
                <a href="<?php echo esc_url(get_post_type_archive_link('engine_filter') ?: home_url('/dvigatelni-filtri/')); ?>" class="site-header__search" aria-label="<?php esc_attr_e('Търсене на двигателен филтър', 'uspeh-filter'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </a>
                <a href="<?php echo esc_url(uspeh_quote_page_url()); ?>" class="btn btn--accent site-header__cta"><?php esc_html_e('Поискай оферта', 'uspeh-filter'); ?></a>
                <button class="site-header__burger" id="burger-toggle" aria-label="<?php esc_attr_e('Меню', 'uspeh-filter'); ?>" aria-expanded="false" aria-controls="site-nav">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </div>
</header>

<main class="site-main" id="main-content">
