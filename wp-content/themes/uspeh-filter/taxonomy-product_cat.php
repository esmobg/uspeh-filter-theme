<?php get_header(); ?>

<?php uspeh_render_breadcrumbs(); ?>

<?php $term = get_queried_object(); ?>

<section class="section product-category">
    <div class="container">
        <div class="section__header">
            <h1><?php single_term_title(); ?></h1>
            <?php if (term_description()) : ?>
                <p><?php echo wp_kses_post(term_description()); ?></p>
            <?php endif; ?>
        </div>

        <?php
        $children = get_terms([
            'taxonomy'   => 'product_cat',
            'parent'     => $term->term_id,
            'hide_empty' => false,
        ]);
        ?>

        <?php if ($children && !is_wp_error($children) && count($children) > 0) : ?>
            <div class="grid grid--4 product-category__children">
                <?php foreach ($children as $child) : ?>
                    <a href="<?php echo esc_url(get_term_link($child)); ?>" class="card">
                        <div class="card__body">
                            <h3 class="card__title"><?php echo esc_html($child->name); ?></h3>
                            <span class="card__link"><?php esc_html_e('Виж', 'uspeh-filter'); ?> →</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (have_posts()) : ?>
            <div class="grid grid--3">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/product-card-loop'); ?>
                <?php endwhile; ?>
            </div>

            <div class="pagination-wrap">
                <?php
                the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => '← ' . __('Предишна', 'uspeh-filter'),
                    'next_text' => __('Следваща', 'uspeh-filter') . ' →',
                ]);
                ?>
            </div>
        <?php else : ?>
            <p class="text-center product-category__empty"><?php esc_html_e('Все още няма добавени продукти в тази категория.', 'uspeh-filter'); ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="section section--alt section-cta">
    <div class="container">
        <h2><?php esc_html_e('Не намирате необходимия размер?', 'uspeh-filter'); ?></h2>
        <p><?php esc_html_e('Произвеждаме филтри по индивидуални размери и спецификации.', 'uspeh-filter'); ?></p>
        <a href="<?php echo esc_url(uspeh_quote_page_url()); ?>" class="btn btn--accent btn--large"><?php esc_html_e('ПОИСКАЙТЕ ФИЛТЪР ПО РАЗМЕР', 'uspeh-filter'); ?></a>
    </div>
</section>

<?php get_footer(); ?>
