<?php get_header(); ?>
<?php uspeh_render_breadcrumbs(); ?>

<section class="section">
    <div class="container">
        <div class="section__header">
            <h1><?php single_term_title(); ?></h1>
            <?php if (term_description()) : ?><p><?php echo wp_kses_post(term_description()); ?></p><?php endif; ?>
        </div>
        <?php get_template_part('template-parts/engine-search-form'); ?>
        <div style="margin-top: 2rem;">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/engine-result-card'); ?>
            <?php endwhile; the_posts_pagination(); endif; ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
