<?php
/**
 * Template Name: Landing Page (Google Ads)
 */
get_header();

if (uspeh_maybe_render_block_page(false)) {
    return;
}
?>

<section class="hero hero--compact">
    <div class="hero__bg">
        <?php if (has_post_thumbnail()) : ?>
            <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'hero-slide')); ?>" alt="" class="hero__bg-img" loading="eager">
        <?php endif; ?>
        <div class="hero__overlay"></div>
    </div>
    <div class="container hero__content">
        <h1 class="hero__title"><?php the_title(); ?></h1>
        <?php if (has_excerpt()) : ?>
            <p class="hero__text"><?php the_excerpt(); ?></p>
        <?php endif; ?>
        <div class="hero__actions">
            <a href="#lp-form" class="btn btn--accent btn--large"><?php esc_html_e('ПОЛУЧИ ОФЕРТА ОТ ПРОИЗВОДИТЕЛ', 'uspeh-filter'); ?></a>
            <a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('sales'))); ?>" class="btn btn--outline-white btn--large"><?php echo esc_html(uspeh_get_phone('sales')); ?></a>
        </div>
    </div>
</section>

<?php get_template_part('template-parts/advantages-bar'); ?>

<section class="section">
    <div class="container">
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </div>
</section>

<section class="section section--alt" id="lp-form">
    <div class="container lp-form">
        <div class="section__header">
            <h2><?php esc_html_e('Поискайте оферта', 'uspeh-filter'); ?></h2>
        </div>
        <?php get_template_part('template-parts/custom-size-form'); ?>
    </div>
</section>

<?php get_template_part('template-parts/final-cta'); ?>

<?php get_footer(); ?>
