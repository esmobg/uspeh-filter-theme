<?php
/**
 * Template Name: Производство
 */
get_header();
$bg = get_theme_mod('production_hero_img', uspeh_theme_image('page-production.jpg') ?: uspeh_theme_image('slide3.jpg'));
?>

<?php uspeh_render_breadcrumbs(); ?>

<section class="hero hero--compact">
    <div class="hero__bg">
        <?php if ($bg) : ?>
            <img src="<?php echo esc_url($bg); ?>" alt="" class="hero__bg-img" loading="eager">
        <?php endif; ?>
        <div class="hero__overlay"></div>
    </div>
    <div class="container hero__content">
        <span class="hero__label"><?php esc_html_e('СОБСТВЕНО ПРОИЗВОДСТВО', 'uspeh-filter'); ?></span>
        <h1 class="hero__title"><?php esc_html_e('От материала до готовия филтър', 'uspeh-filter'); ?></h1>
        <p class="hero__text"><?php esc_html_e('Модерно оборудване, контролирани процеси и дългогодишен опит.', 'uspeh-filter'); ?></p>
    </div>
</section>

<?php get_template_part('template-parts/how-we-produce'); ?>

<section class="section">
    <div class="container">
        <div class="section__header">
            <h2><?php esc_html_e('Нашето производство', 'uspeh-filter'); ?></h2>
            <p><?php esc_html_e('Разполагаме с оборудване за плисиране, сглобяване, тестване и контрол на въздушни, HEPA, двигателни и индустриални филтри.', 'uspeh-filter'); ?></p>
        </div>
        <?php the_content(); ?>
    </div>
</section>

<?php get_template_part('template-parts/final-cta'); ?>

<?php get_footer(); ?>
