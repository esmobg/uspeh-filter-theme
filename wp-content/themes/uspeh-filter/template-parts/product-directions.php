<section class="section product-rows">
    <div class="container">
        <header class="section__header">
            <span class="section__label"><?php esc_html_e('ПРОДУКТИ И УСЛУГИ', 'uspeh-filter'); ?></span>
            <h2><?php esc_html_e('Основни групи филтри', 'uspeh-filter'); ?></h2>
            <p><?php esc_html_e('Производствената гама на Успех Филтър следва реалните приложения от стария каталог: груба и фина филтрация, високоефективни HEPA решения и филтри за газове, миризми и специални процеси.', 'uspeh-filter'); ?></p>
        </header>

        <?php
        $directions = [
            [
                'url'     => get_post_type_archive_link('product'),
                'img'     => get_theme_mod('direction_hvac_img', uspeh_theme_image('cat-hvac.jpg') ?: uspeh_theme_image('slide1.jpg')),
                'title'   => __('Предфилтри и груба филтрация', 'uspeh-filter'),
                'bullets' => [
                    __('Панелни, таванни и джобни филтри за първа степен на очистване.', 'uspeh-filter'),
                    __('Висока прахозадържаща способност и защита на следващите филтърни степени.', 'uspeh-filter'),
                    __('Подходящи за климатични камери, вентилационни инсталации и индустриални линии.', 'uspeh-filter'),
                ],
            ],
            [
                'url'     => home_url('/vazdushni-filtri/'),
                'img'     => get_theme_mod('direction_fine_img', uspeh_theme_image('slide1.jpg')),
                'title'   => __('Фина филтрация', 'uspeh-filter'),
                'bullets' => [
                    __('Торбни, компактни и панелни филтри за HVAC системи с по-висока чистота на въздуха.', 'uspeh-filter'),
                    __('Класове по EN 779 / ISO 16890 според необходимата ефективност и дебит.', 'uspeh-filter'),
                    __('Изпълнения за болници, хотели, офис сгради, фармация и промишлени помещения.', 'uspeh-filter'),
                ],
            ],
            [
                'url'     => home_url('/hepa-filtri/'),
                'img'     => get_theme_mod('direction_hepa_img', uspeh_theme_image('cat-hepa.jpg') ?: uspeh_theme_image('slide2.jpg')),
                'title'   => __('EPA, HEPA и ULPA филтрация', 'uspeh-filter'),
                'bullets' => [
                    __('Филтри за крайна степен на очистване за чисти помещения, лаборатории и операционни.', 'uspeh-filter'),
                    __('Класове E10, E11, E12, H13, H14, U15, U16 и U17 по EN 1822.', 'uspeh-filter'),
                    __('Сепараторни, mini-pleat и високодебитни изпълнения с индивидуален сертификат.', 'uspeh-filter'),
                ],
            ],
            [
                'url'     => home_url('/vazdushni-filtri/industrialni/'),
                'img'     => get_theme_mod('direction_industrial_img', uspeh_theme_image('cat-industrial.jpg') ?: uspeh_theme_image('page-production.jpg')),
                'title'   => __('Карбонови и специални филтри', 'uspeh-filter'),
                'bullets' => [
                    __('Решения за миризми, газове, аерозоли и специфични производствени среди.', 'uspeh-filter'),
                    __('Активен въглен и специални филтърни материали в панелен, компактен и патронен формат.', 'uspeh-filter'),
                    __('Изработка по размер, касета или техническо задание за нестандартни приложения.', 'uspeh-filter'),
                ],
            ],
        ];
        foreach ($directions as $dir) :
            ?>
            <article class="product-row">
                <div class="product-row__image">
                    <?php if ($dir['img']) : ?>
                        <img src="<?php echo esc_url($dir['img']); ?>" alt="<?php echo esc_attr($dir['title']); ?>" width="1200" height="900" loading="lazy">
                    <?php endif; ?>
                </div>
                <div class="product-row__content">
                    <h2 class="product-row__title"><?php echo esc_html($dir['title']); ?></h2>
                    <ul class="product-row__list">
                        <?php foreach ($dir['bullets'] as $bullet) : ?>
                            <li><?php echo esc_html($bullet); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?php echo esc_url($dir['url']); ?>" class="btn btn--detail">
                        <?php esc_html_e('+ Детайли', 'uspeh-filter'); ?>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
