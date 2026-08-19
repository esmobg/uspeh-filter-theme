<?php get_header(); ?>

<?php uspeh_render_breadcrumbs(); ?>

<section class="section">
    <div class="container">
        <div class="section__header">
            <span class="section__label"><?php esc_html_e('ТЕХНИЧЕСКИ ЦЕНТЪР', 'uspeh-filter'); ?></span>
            <h1><?php esc_html_e('Стандарти и техническа информация', 'uspeh-filter'); ?></h1>
            <p><?php esc_html_e('Подробна информация за стандарти, класове на филтрация и технологии.', 'uspeh-filter'); ?></p>
        </div>

        <?php if (have_posts()) : ?>
            <div class="grid grid--3">
                <?php while (have_posts()) : the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="card">
                        <div class="card__body">
                            <h3 class="card__title"><?php the_title(); ?></h3>
                            <p class="card__text"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                            <span class="card__link"><?php esc_html_e('Прочети', 'uspeh-filter'); ?> →</span>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
