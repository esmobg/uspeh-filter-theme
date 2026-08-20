<section class="section sectors-grid-section">
    <div class="container">
        <header class="section__header">
            <span class="section__label"><?php esc_html_e('ПРИЛОЖЕНИЯ', 'uspeh-filter'); ?></span>
            <h2><?php esc_html_e('Филтри с приложение във вентилационни и климатични инсталации на:', 'uspeh-filter'); ?></h2>
            <p><?php esc_html_e('Филтрираме въздуха там, където чистотата е пряко свързана с безопасността, комфорта и качеството на производството — в болници, фармация, индустрия и обществени сгради.', 'uspeh-filter'); ?></p>
        </header>

        <?php
        $engine_archive = get_post_type_archive_link('engine_filter') ?: home_url('/dvigatelni-filtri/');
        $sectors = [
            ['img' => 'slide2.jpg', 'label' => __('Болници', 'uspeh-filter'), 'url' => uspeh_application_url('bolnici')],
            ['img' => 'page-quality.jpg', 'label' => __('Фармация', 'uspeh-filter'), 'url' => uspeh_application_url('farmacia')],
            ['img' => 'cat-hepa.jpg', 'label' => __('Чисти помещения', 'uspeh-filter'), 'url' => uspeh_application_url('chisti-pomeshtenia')],
            ['img' => 'cat-industrial.jpg', 'label' => __('Индустрия', 'uspeh-filter'), 'url' => uspeh_application_url('industria')],
            ['img' => 'page-about.jpg', 'label' => __('Хотели', 'uspeh-filter'), 'url' => uspeh_application_url('hoteli')],
            ['img' => 'slide3.jpg', 'label' => __('Летища', 'uspeh-filter'), 'url' => home_url('/vazdushni-filtri/')],
            ['img' => 'slide1.jpg', 'label' => __('Офис сгради', 'uspeh-filter'), 'url' => uspeh_application_url('ofis-sgradi')],
            ['img' => 'cat-hvac.jpg', 'label' => __('HVAC системи', 'uspeh-filter'), 'url' => home_url('/vazdushni-filtri/')],
            ['img' => 'cat-engine.jpg', 'label' => __('Автомобили', 'uspeh-filter'), 'url' => $engine_archive],
        ];
        ?>

        <div class="sectors-grid">
            <?php foreach ($sectors as $sector) :
                $src = uspeh_theme_image($sector['img']);
                ?>
                <a href="<?php echo esc_url($sector['url']); ?>" class="sectors-grid__item" aria-label="<?php echo esc_attr($sector['label']); ?>">
                    <?php if ($src) : ?>
                        <img src="<?php echo esc_url($src); ?>" alt="" width="600" height="600" loading="lazy">
                    <?php endif; ?>
                    <span class="sectors-grid__label"><?php echo esc_html($sector['label']); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
