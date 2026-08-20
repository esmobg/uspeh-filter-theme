<?php
/**
 * Стандартен шаблон за страница: при Gutenberg съдържание рендира блоковете
 * на пълна ширина (alignfull/alignwide работят); иначе — класически контейнер.
 */
get_header();

uspeh_render_breadcrumbs();

if (uspeh_page_has_block_layout()) {
    uspeh_render_block_layout();
    get_footer();
    return;
}
?>

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
