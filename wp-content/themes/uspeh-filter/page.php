<?php get_header(); ?>

<?php uspeh_render_breadcrumbs(); ?>

<article class="page-content section">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <h1 class="page-content__title"><?php the_title(); ?></h1>
            <div class="page-content__body">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</article>

<?php get_footer(); ?>
