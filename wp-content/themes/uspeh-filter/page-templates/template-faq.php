<?php
/**
 * Template Name: FAQ
 */
get_header();

if (uspeh_maybe_render_block_page()) {
    return;
}
?>

<?php uspeh_render_breadcrumbs(); ?>

<section class="section">
    <div class="container" style="max-width: 800px;">
        <div class="section__header">
            <h1><?php esc_html_e('Често задавани въпроси', 'uspeh-filter'); ?></h1>
        </div>

        <div class="faq-list">
            <?php the_content(); ?>
        </div>
    </div>
</section>

<?php get_template_part('template-parts/final-cta'); ?>

<?php get_footer(); ?>
