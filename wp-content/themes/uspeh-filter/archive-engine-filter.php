<?php get_header(); ?>

<?php uspeh_render_breadcrumbs(); ?>

<section class="section engine-catalog">
    <div class="container">
        <div class="section__header">
            <h1><?php esc_html_e('Двигателни филтри — онлайн каталог', 'uspeh-filter'); ?></h1>
            <p><?php esc_html_e('Търсете по OEM номер, каталожен номер, производител на превозното средство или модел.', 'uspeh-filter'); ?></p>
        </div>

        <?php get_template_part('template-parts/engine-search-form'); ?>

        <div id="engine-search-results" class="engine-catalog__results" style="margin-top: 2rem;">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/engine-result-card'); ?>
                <?php endwhile; ?>
                <div style="margin-top: 2rem; text-align: center;">
                    <?php the_posts_pagination(['mid_size' => 2]); ?>
                </div>
            <?php else : ?>
                <p class="text-center" style="color: var(--color-text-light); padding: 2rem 0;"><?php esc_html_e('Използвайте формата за търсене по-горе, за да намерите необходимия филтър.', 'uspeh-filter'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container text-center">
        <h2><?php esc_html_e('Не намирате вашия филтър?', 'uspeh-filter'); ?></h2>
        <p style="color: var(--color-text-light); margin: 0.75rem 0 1.5rem;"><?php esc_html_e('Изпратете ни OEM номер, снимка или описание и ще ви предложим подходящ еквивалент.', 'uspeh-filter'); ?></p>
        <a href="<?php echo esc_url(home_url('/poiskaj-oferta/')); ?>" class="btn btn--accent btn--large"><?php esc_html_e('ИЗПРАТИ ЗАПИТВАНЕ', 'uspeh-filter'); ?></a>
    </div>
</section>

<?php get_footer(); ?>
