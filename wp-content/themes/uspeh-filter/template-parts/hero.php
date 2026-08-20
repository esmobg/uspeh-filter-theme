<?php
$hero_image = get_theme_mod('hero_image', uspeh_theme_image('slide1.jpg') ?: uspeh_theme_image('cat-hepa.jpg'));
$catalog_url = get_post_type_archive_link('product') ?: home_url('/vazdushni-filtri/');
?>
<section class="hero hero--split" data-animate-hero>
    <div class="container hero--split__grid">
        <div class="hero__visual">
            <?php if ($hero_image) : ?>
                <img src="<?php echo esc_url($hero_image); ?>" alt="<?php esc_attr_e('Продуктов каталог на Успех Филтър', 'uspeh-filter'); ?>" class="hero__visual-img" width="720" height="540" loading="eager">
            <?php else : ?>
                <div class="hero__visual-fallback" aria-hidden="true"></div>
            <?php endif; ?>
            <div class="hero__badge">
                <span><?php esc_html_e('Високоефективни продукти', 'uspeh-filter'); ?></span>
            </div>
        </div>
        <div class="hero__content">
            <p class="hero__script"><?php esc_html_e('Чист въздух. Увереност.', 'uspeh-filter'); ?></p>
            <h1 class="hero__title">
                <span class="hero__title-accent"><?php esc_html_e('Продуктов', 'uspeh-filter'); ?></span>
                <?php esc_html_e('каталог', 'uspeh-filter'); ?>
            </h1>
            <p class="hero__text"><?php esc_html_e('Професионални филтри за вентилация, климатизация, чисти помещения и индустрия — собствено производство в София.', 'uspeh-filter'); ?></p>
            <div class="hero__actions">
                <a href="<?php echo esc_url($catalog_url); ?>" class="btn btn--accent btn--large">
                    <?php esc_html_e('Разгледайте каталога', 'uspeh-filter'); ?>
                </a>
            </div>
        </div>
    </div>
</section>
