<?php
$news = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

if (!$news->have_posts()) {
    return;
}
?>

<section class="section news-teaser">
    <div class="container">
        <div class="section__header">
            <span class="section__label"><?php esc_html_e('ЗНАНИЯ И ТЕХНОЛОГИИ', 'uspeh-filter'); ?></span>
            <h2><?php esc_html_e('Новини и полезна информация', 'uspeh-filter'); ?></h2>
        </div>

        <div class="grid grid--3">
            <?php while ($news->have_posts()) : $news->the_post(); ?>
                <article class="card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="card__image">
                            <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('product-card'); ?></a>
                        </div>
                    <?php endif; ?>
                    <div class="card__body">
                        <span class="card__date"><?php echo esc_html(get_the_date()); ?></span>
                        <h3 class="card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="card__text"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 15)); ?></p>
                        <a href="<?php the_permalink(); ?>" class="card__link"><?php esc_html_e('Прочети', 'uspeh-filter'); ?> →</a>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <div class="text-center news-teaser__more">
            <?php
            $tech_archive = get_post_type_archive_link('tech_article');
            $news_archive = $tech_archive ?: home_url('/technical/');
            ?>
            <a href="<?php echo esc_url($news_archive); ?>" class="btn btn--outline"><?php esc_html_e('ВСИЧКИ ПУБЛИКАЦИИ', 'uspeh-filter'); ?> →</a>
        </div>
    </div>
</section>
