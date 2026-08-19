<?php get_header(); ?>

<?php uspeh_render_breadcrumbs(); ?>

<article class="single-post section">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <header class="single-post__header">
                <span class="section__label"><?php echo esc_html(get_the_date()); ?></span>
                <h1><?php the_title(); ?></h1>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <figure class="single-post__thumbnail">
                    <?php the_post_thumbnail('product-gallery'); ?>
                </figure>
            <?php endif; ?>

            <div class="single-post__content">
                <?php the_content(); ?>
            </div>

            <div class="single-post__cta" style="margin-top: 3rem; padding: 2rem; background: var(--color-bg-alt); border-radius: var(--radius-lg); text-align: center;">
                <h3><?php esc_html_e('Нуждаете се от подходящ филтър?', 'uspeh-filter'); ?></h3>
                <p style="color: var(--color-text-light); margin: 0.75rem 0 1.5rem;"><?php esc_html_e('Изпратете ни размерите или се свържете с нас за консултация.', 'uspeh-filter'); ?></p>
                <a href="<?php echo esc_url(home_url('/poiskaj-oferta/')); ?>" class="btn btn--accent"><?php esc_html_e('ПОИСКАЙ ОФЕРТА', 'uspeh-filter'); ?></a>
            </div>
        <?php endwhile; ?>
    </div>
</article>

<?php get_footer(); ?>
