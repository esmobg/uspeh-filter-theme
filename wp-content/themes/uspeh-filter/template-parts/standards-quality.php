<section class="section standards-quality">
    <div class="container">
        <div class="standards-quality__inner">
            <div class="standards-quality__content">
                <span class="section__label"><?php esc_html_e('КАЧЕСТВО И СТАНДАРТИ', 'uspeh-filter'); ?></span>
                <h2><?php esc_html_e('Качество, което може да бъде документирано', 'uspeh-filter'); ?></h2>
                <p><?php esc_html_e('Продукцията на Успех Филтър ССБ се произвежда в съответствие с европейски и международни стандарти. Системата за управление на качеството е сертифицирана по ISO 9001:2015.', 'uspeh-filter'); ?></p>

                <div class="standards-quality__items">
                    <div class="standards-quality__item">
                        <strong>ISO 9001:2015</strong>
                        <span><?php esc_html_e('Система за управление на качеството', 'uspeh-filter'); ?></span>
                    </div>
                    <div class="standards-quality__item">
                        <strong>EN 1822</strong>
                        <span><?php esc_html_e('EPA, HEPA, ULPA филтри', 'uspeh-filter'); ?></span>
                    </div>
                    <div class="standards-quality__item">
                        <strong>ISO 16890</strong>
                        <span><?php esc_html_e('Въздушни филтри за обща вентилация', 'uspeh-filter'); ?></span>
                    </div>
                    <div class="standards-quality__item">
                        <strong>EN 779</strong>
                        <span><?php esc_html_e('Класификация на фини филтри', 'uspeh-filter'); ?></span>
                    </div>
                </div>

                <a href="<?php echo esc_url(home_url('/kachestvo/')); ?>" class="btn btn--outline"><?php esc_html_e('СЕРТИФИКАТИ И КАЧЕСТВО', 'uspeh-filter'); ?> →</a>
            </div>
            <div class="standards-quality__visual">
                <?php $cert_img = get_theme_mod('quality_section_img', uspeh_theme_image('page-quality.jpg')); ?>
                <?php if ($cert_img) : ?>
                    <img src="<?php echo esc_url($cert_img); ?>" alt="<?php esc_attr_e('Контрол на качеството', 'uspeh-filter'); ?>" width="600" height="600" loading="lazy">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
