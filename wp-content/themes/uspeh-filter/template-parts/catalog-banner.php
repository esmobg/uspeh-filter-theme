<?php
$catalog_bg = uspeh_theme_image('page-quality.jpg') ?: uspeh_theme_image('slide3.jpg');
?>
<section class="catalog-banner">
    <?php if ($catalog_bg) : ?>
        <img src="<?php echo esc_url($catalog_bg); ?>" alt="" class="catalog-banner__bg" width="1920" height="800" loading="lazy">
    <?php endif; ?>
    <div class="catalog-banner__inner">
        <span class="section__label"><?php esc_html_e('КАТАЛОГ', 'uspeh-filter'); ?></span>
        <h2><?php esc_html_e('Каталог с филтри за вентилация, климатизация и специални приложения', 'uspeh-filter'); ?></h2>
        <p><?php esc_html_e('Разгледайте основните продуктови групи, а при нестандартно задание изпратете размери, снимка или спецификация за изработка по поръчка.', 'uspeh-filter'); ?></p>
        <div class="catalog-banner__actions">
            <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="btn btn--detail">
                <?php esc_html_e('+ Разгледай каталога', 'uspeh-filter'); ?>
            </a>
            <a href="<?php echo esc_url(uspeh_quote_page_url()); ?>" class="btn btn--accent">
                <?php esc_html_e('Поискай оферта', 'uspeh-filter'); ?>
            </a>
        </div>
    </div>
</section>
