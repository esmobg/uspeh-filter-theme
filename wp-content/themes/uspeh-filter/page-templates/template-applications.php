<?php
/**
 * Template Name: Приложения
 */
get_header();
?>

<?php uspeh_render_breadcrumbs(); ?>

<section class="section">
    <div class="container">
        <div class="section__header">
            <span class="section__label"><?php esc_html_e('ПРИЛОЖЕНИЯ', 'uspeh-filter'); ?></span>
            <h1><?php esc_html_e('Къде се използват нашите филтри', 'uspeh-filter'); ?></h1>
            <p><?php esc_html_e('Решения за различни индустрии и приложения, съобразени с конкретните изисквания.', 'uspeh-filter'); ?></p>
        </div>

        <?php
        $apps = new WP_Query([
            'post_type'      => 'application',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ]);
        ?>

        <?php if ($apps->have_posts()) : ?>
            <div class="grid grid--3">
                <?php while ($apps->have_posts()) : $apps->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="card__image" style="aspect-ratio: 16/10;">
                                <?php the_post_thumbnail('product-card'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="card__body">
                            <h3 class="card__title"><?php the_title(); ?></h3>
                            <p class="card__text"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 15)); ?></p>
                            <span class="card__link"><?php esc_html_e('Научи повече', 'uspeh-filter'); ?> →</span>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php endif; ?>
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

<?php get_template_part('template-parts/final-cta'); ?>

<?php get_footer(); ?>
