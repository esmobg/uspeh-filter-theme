<?php get_header(); ?>

<?php uspeh_render_breadcrumbs(); ?>

<?php while (have_posts()) : the_post(); ?>

<article class="section single-post">
    <div class="container" style="max-width: 900px;">
        <header class="single-post__header">
            <span class="section__label"><?php esc_html_e('ТЕХНИЧЕСКИ ЦЕНТЪР', 'uspeh-filter'); ?></span>
            <h1><?php the_title(); ?></h1>
        </header>

        <div class="single-post__content">
            <?php the_content(); ?>
        </div>

        <div class="single-post__cta" style="margin-top: 3rem; padding: 2rem; background: var(--color-bg-alt); border-radius: var(--radius-lg); text-align: center;">
            <h2><?php esc_html_e('Нуждаете се от консултация?', 'uspeh-filter'); ?></h2>
            <p style="color: var(--color-text-light); margin: 0.75rem 0 1.5rem;"><?php esc_html_e('Нашите специалисти ще ви помогнат да изберете правилния филтър.', 'uspeh-filter'); ?></p>
            <a href="<?php echo esc_url(home_url('/poiskaj-oferta/')); ?>" class="btn btn--accent"><?php esc_html_e('ПОИСКАЙ ОФЕРТА', 'uspeh-filter'); ?></a>
        </div>
    </div>
</article>

<?php endwhile; ?>

<?php get_footer(); ?>
