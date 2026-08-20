<?php
/**
 * Начална страница: blocks-first — ако страницата има Gutenberg съдържание
 * (напр. вмъкнат pattern „Начална страница"), рендира се то; иначе PHP секциите.
 */
get_header();

if (uspeh_maybe_render_block_page(false)) {
    return;
}
?>

<?php get_template_part('template-parts/hero'); ?>
<?php get_template_part('template-parts/product-directions'); ?>
<?php get_template_part('template-parts/applications-grid'); ?>
<?php get_template_part('template-parts/catalog-banner'); ?>
<?php get_template_part('template-parts/production-showcase'); ?>
<?php get_template_part('template-parts/hepa-highlight'); ?>
<?php get_template_part('template-parts/engine-catalog-teaser'); ?>
<?php get_template_part('template-parts/news-teaser'); ?>
<?php get_template_part('template-parts/final-cta'); ?>

<?php get_footer(); ?>
