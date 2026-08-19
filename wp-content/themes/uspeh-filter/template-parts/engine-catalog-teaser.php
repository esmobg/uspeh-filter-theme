<section class="section section--alt engine-teaser">
    <div class="container">
        <div class="engine-teaser__inner">
            <div class="engine-teaser__content">
                <span class="section__label"><?php esc_html_e('ДВИГАТЕЛНИ ФИЛТРИ', 'uspeh-filter'); ?></span>
                <h2><?php esc_html_e('Онлайн каталог за двигателни филтри', 'uspeh-filter'); ?></h2>
                <p><?php esc_html_e('Въздушни, маслени и горивни филтри за леки автомобили, камиони, автобуси, селскостопанска, строителна и индустриална техника.', 'uspeh-filter'); ?></p>
                <p><?php esc_html_e('Търсете по OEM номер, каталожен номер на Успех Филтър, производител или модел.', 'uspeh-filter'); ?></p>

                <form class="engine-teaser__search" action="<?php echo esc_url(get_post_type_archive_link('engine_filter')); ?>" method="get">
                    <input type="text" name="s" placeholder="<?php esc_attr_e('Въведете OEM или каталожен номер...', 'uspeh-filter'); ?>" class="engine-teaser__input" aria-label="<?php esc_attr_e('Търсене на двигателен филтър', 'uspeh-filter'); ?>">
                    <button type="submit" class="btn btn--accent"><?php esc_html_e('ТЪРСИ', 'uspeh-filter'); ?></button>
                </form>

                <a href="<?php echo esc_url(get_post_type_archive_link('engine_filter')); ?>" class="btn btn--outline engine-teaser__cta"><?php esc_html_e('ОТВОРИ КАТАЛОГА', 'uspeh-filter'); ?> →</a>
            </div>
            <div class="engine-teaser__image">
                <?php $engine_img = get_theme_mod('engine_teaser_img', uspeh_theme_image('slide3.jpg')); ?>
                <?php if ($engine_img) : ?>
                    <img src="<?php echo esc_url($engine_img); ?>" alt="<?php esc_attr_e('Двигателни филтри', 'uspeh-filter'); ?>" width="600" height="600" loading="lazy">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
