<?php
/**
 * Template Name: Индивидуално производство
 */
get_header();
$bg = get_theme_mod('custom_prod_hero', uspeh_theme_image('slide2.jpg'));
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
        <span class="hero__label"><?php esc_html_e('ИНДИВИДУАЛНО ПРОИЗВОДСТВО', 'uspeh-filter'); ?></span>
        <h1 class="hero__title"><?php esc_html_e('Произвеждаме филтри по вашите изисквания', 'uspeh-filter'); ?></h1>
        <p class="hero__text"><?php esc_html_e('По размер, мостра или предоставена техническа документация. Над 40 години производствен опит.', 'uspeh-filter'); ?></p>
    </div>
</section>

<?php get_template_part('template-parts/custom-production'); ?>

<section class="section">
    <div class="container">
        <div class="section__header">
            <h2><?php esc_html_e('Изпратете вашите изисквания', 'uspeh-filter'); ?></h2>
            <p><?php esc_html_e('Попълнете формата с размери, тип и количество. При нужда качете снимка, чертеж или спецификация.', 'uspeh-filter'); ?></p>
        </div>
        <?php uspeh_render_quote_notice(); ?>
        <?php get_template_part('template-parts/custom-size-form'); ?>
    </div>
</section>

<?php
$extra = get_the_content();
if ($extra) : ?>
<section class="section">
    <div class="container">
        <?php the_content(); ?>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
