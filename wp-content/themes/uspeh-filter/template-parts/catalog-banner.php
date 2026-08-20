<?php
$catalog_image = get_theme_mod('catalog_banner_img', uspeh_theme_image('page-quality.jpg') ?: uspeh_theme_image('slide3.jpg'));
$catalog_url = get_post_type_archive_link('product') ?: home_url('/vazdushni-filtri/');
?>
<section class="catalog-banner catalog-banner--split">
    <div class="container catalog-banner--split__grid">
        <div class="catalog-banner__visual">
            <?php if ($catalog_image) : ?>
                <img src="<?php echo esc_url($catalog_image); ?>" alt="<?php esc_attr_e('Каталог с филтри', 'uspeh-filter'); ?>" width="720" height="540" loading="lazy">
            <?php endif; ?>
        </div>
        <div class="catalog-banner__content">
            <span class="section__label"><?php esc_html_e('КАТАЛОГ', 'uspeh-filter'); ?></span>
            <h2><?php esc_html_e('Каталог с филтри за вентилация, климатизация и специални приложения', 'uspeh-filter'); ?></h2>
            <p><?php esc_html_e('Разгледайте основните продуктови групи, а при нестандартно задание изпратете размери, снимка или спецификация за изработка по поръчка.', 'uspeh-filter'); ?></p>
            <div class="catalog-banner__actions">
                <a href="<?php echo esc_url($catalog_url); ?>" class="btn btn--accent">
                    <?php esc_html_e('Разгледай каталога', 'uspeh-filter'); ?>
                </a>
                <a href="<?php echo esc_url(uspeh_quote_page_url()); ?>" class="btn btn--detail">
                    <?php esc_html_e('Поискай оферта', 'uspeh-filter'); ?>
                </a>
            </div>
        </div>
    </div>
</section>
