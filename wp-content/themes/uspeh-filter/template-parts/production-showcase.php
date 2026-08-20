<section class="section about-split">
    <div class="container">
        <div class="about-split__inner">
            <div class="about-split__media">
                <?php $prod_img = get_theme_mod('production_showcase_img', uspeh_theme_image('page-production.jpg') ?: uspeh_theme_image('slide3.jpg')); ?>
                <?php if ($prod_img) : ?>
                    <img src="<?php echo esc_url($prod_img); ?>" alt="<?php esc_attr_e('Производство', 'uspeh-filter'); ?>" width="1200" height="900" loading="lazy">
                <?php endif; ?>
            </div>
            <div class="about-split__content">
                <span class="section__label"><?php esc_html_e('ЗА НАС', 'uspeh-filter'); ?></span>
                <h2><?php esc_html_e('Собствено производство в София', 'uspeh-filter'); ?></h2>
                <h3><?php esc_html_e('От филтърната материя до готовия продукт', 'uspeh-filter'); ?></h3>
                <p><?php esc_html_e('Успех Филтър ССБ поддържа собствен производствен процес за въздушни, HEPA, карбонови и двигателни филтри. Изпълняваме стандартни серии и нестандартни размери според обект, машина или конкретно техническо задание.', 'uspeh-filter'); ?></p>
                <div class="about-split__stats">
                    <div class="about-split__stat">
                        <strong>40+</strong>
                        <span><?php esc_html_e('години опит', 'uspeh-filter'); ?></span>
                    </div>
                    <div class="about-split__stat">
                        <strong><?php esc_html_e('София', 'uspeh-filter'); ?></strong>
                        <span><?php esc_html_e('собствено производство', 'uspeh-filter'); ?></span>
                    </div>
                    <div class="about-split__stat">
                        <strong>ISO</strong>
                        <span>9001:2015</span>
                    </div>
                </div>
                <ul class="about-split__list">
                    <li><?php esc_html_e('Плисиране, сглобяване и контрол в собствена база', 'uspeh-filter'); ?></li>
                    <li><?php esc_html_e('Изработка по размер, касета, рамка и клас на филтрация', 'uspeh-filter'); ?></li>
                    <li><?php esc_html_e('Подходящо за болници, фармация, промишленост и специализирани производства', 'uspeh-filter'); ?></li>
                </ul>
                <div class="about-split__actions">
                    <a href="<?php echo esc_url(home_url('/proizvodstvo/')); ?>" class="btn btn--detail">
                        <?php esc_html_e('+ Виж производството', 'uspeh-filter'); ?>
                    </a>
                    <a href="<?php echo esc_url(uspeh_quote_page_url()); ?>" class="btn btn--primary">
                        <?php esc_html_e('Изпрати запитване', 'uspeh-filter'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
