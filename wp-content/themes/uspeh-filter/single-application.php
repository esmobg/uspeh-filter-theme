<?php get_header(); ?>

<?php uspeh_render_breadcrumbs(); ?>

<?php while (have_posts()) : the_post(); ?>

<section class="section">
    <div class="container">
        <span class="section__label"><?php esc_html_e('ПРИЛОЖЕНИЕ', 'uspeh-filter'); ?></span>
        <h1><?php the_title(); ?></h1>

        <?php if (has_post_thumbnail()) : ?>
            <figure style="margin: 2rem 0; border-radius: var(--radius-lg); overflow: hidden;">
                <?php the_post_thumbnail('product-gallery'); ?>
            </figure>
        <?php endif; ?>

        <div class="page-content__body">
            <?php the_content(); ?>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container text-center">
        <h2><?php printf(esc_html__('Нуждаете се от филтри за %s?', 'uspeh-filter'), strtolower(get_the_title())); ?></h2>
        <p style="color: var(--color-text-light); margin: 0.75rem 0 1.5rem;"><?php esc_html_e('Изпратете ни запитване с вашите изисквания.', 'uspeh-filter'); ?></p>
        <a href="<?php echo esc_url(home_url('/poiskaj-oferta/')); ?>" class="btn btn--accent btn--large"><?php esc_html_e('ПОИСКАЙ ОФЕРТА', 'uspeh-filter'); ?></a>
    </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>
