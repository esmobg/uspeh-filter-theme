<?php
$hero_slides = array_values(array_filter([
    get_theme_mod('hero_image', uspeh_theme_image('slide1.jpg')),
    uspeh_theme_image('slide2.jpg'),
    uspeh_theme_image('slide3.jpg'),
]));
?>
<section class="hero" data-hero-slider>
    <div class="hero__slides" aria-hidden="true">
        <?php foreach ($hero_slides as $i => $slide) : ?>
            <div class="hero__slide<?php echo 0 === $i ? ' is-active' : ''; ?>">
                <img src="<?php echo esc_url($slide); ?>" alt="" class="hero__bg-img" width="1920" height="800" <?php echo 0 === $i ? 'loading="eager"' : 'loading="lazy"'; ?>>
            </div>
        <?php endforeach; ?>
        <?php if (!$hero_slides) : ?>
            <div class="hero__slide is-active hero__slide--fallback"></div>
        <?php endif; ?>
    </div>
    <div class="hero__fade"></div>
    <div class="container hero__content">
        <p class="hero__script"><?php esc_html_e('Въздушни филтри за климатични и вентилационни инсталации', 'uspeh-filter'); ?></p>
        <h1 class="hero__title">
            <span class="hero__title-accent"><?php esc_html_e('Производство на филтри', 'uspeh-filter'); ?></span>
            <?php esc_html_e('за въздух, течности и газове', 'uspeh-filter'); ?>
        </h1>
        <p class="hero__text"><?php esc_html_e('Успех Филтър ССБ произвежда предфилтри, фини филтри, EPA, HEPA, ULPA и карбонови филтри за болници, фармация, летища, хотели, офис сгради и индустрия.', 'uspeh-filter'); ?></p>
        <div class="hero__actions">
            <a href="<?php echo esc_url(home_url('/vazdushni-filtri/')); ?>" class="btn btn--accent btn--large">
                <?php esc_html_e('Разгледайте продуктите', 'uspeh-filter'); ?>
            </a>
            <a href="<?php echo esc_url(uspeh_quote_page_url()); ?>" class="btn btn--outline-white btn--large">
                <?php esc_html_e('Поискайте оферта', 'uspeh-filter'); ?>
            </a>
        </div>
        <ul class="hero__usp-list">
            <li><?php esc_html_e('Собствено производство в София', 'uspeh-filter'); ?></li>
            <li><?php esc_html_e('Над 40 години опит', 'uspeh-filter'); ?></li>
            <li><?php esc_html_e('Решения по размер и техническо задание', 'uspeh-filter'); ?></li>
        </ul>
    </div>
    <?php if (count($hero_slides) > 1) : ?>
        <div class="hero__dots" role="tablist" aria-label="<?php esc_attr_e('Слайдове', 'uspeh-filter'); ?>">
            <?php foreach ($hero_slides as $i => $slide) : ?>
                <button type="button" class="hero__dot<?php echo 0 === $i ? ' is-active' : ''; ?>" data-hero-dot="<?php echo esc_attr((string) $i); ?>" role="tab" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr(sprintf(__('Слайд %d', 'uspeh-filter'), $i + 1)); ?>"></button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
