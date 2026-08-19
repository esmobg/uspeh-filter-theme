<article class="card product-card">
    <div class="card__image">
        <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('product-card'); ?>
            <?php else : ?>
                <img src="<?php echo esc_url(uspeh_theme_image('slide2.jpg')); ?>" alt="<?php the_title_attribute(); ?>" width="600" height="600" loading="lazy">
            <?php endif; ?>
        </a>
    </div>
    <div class="card__body">
        <h3 class="card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php
        $filter_class = get_post_meta(get_the_ID(), '_filter_class', true);
        if ($filter_class) :
            ?>
            <span class="product-card__class"><?php echo esc_html($filter_class); ?></span>
        <?php endif; ?>
        <p class="card__text"><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 15)); ?></p>
        <span class="card__link"><?php esc_html_e('Подробности', 'uspeh-filter'); ?> →</span>
    </div>
</article>
