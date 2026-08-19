<section class="section hepa-highlight">
    <div class="container">
        <div class="hepa-highlight__inner">
            <div class="hepa-highlight__content">
                <span class="section__label">HEPA <?php esc_html_e('ФИЛТРАЦИЯ', 'uspeh-filter'); ?></span>
                <h2><?php esc_html_e('EPA, HEPA и ULPA филтри за обекти с високи изисквания', 'uspeh-filter'); ?></h2>
                <p><?php esc_html_e('Старият сайт поставяше силен акцент върху HEPA решенията и това остава запазено: филтри за крайна степен на очистване на въздуха в болници, фармация, лаборатории, чисти помещения и технологични производства.', 'uspeh-filter'); ?></p>
                <ul class="hepa-highlight__list">
                    <li><?php esc_html_e('HEPA сепараторни филтри', 'uspeh-filter'); ?></li>
                    <li><?php esc_html_e('HEPA mini-pleat филтри', 'uspeh-filter'); ?></li>
                    <li><?php esc_html_e('HEPA високодебитни H14', 'uspeh-filter'); ?></li>
                    <li><?php esc_html_e('EPA E10 - E12 и HEPA H13 - H14', 'uspeh-filter'); ?></li>
                    <li><?php esc_html_e('ULPA U15 - U17', 'uspeh-filter'); ?></li>
                </ul>
                <div class="hepa-highlight__trust">
                    <div class="hepa-highlight__trust-item">
                        <strong><?php esc_html_e('100% контрол', 'uspeh-filter'); ?></strong>
                        <span><?php esc_html_e('Всеки HEPA филтър преминава изпитване', 'uspeh-filter'); ?></span>
                    </div>
                    <div class="hepa-highlight__trust-item">
                        <strong><?php esc_html_e('Сертификат', 'uspeh-filter'); ?></strong>
                        <span><?php esc_html_e('Индивидуален сертификат за всеки продукт', 'uspeh-filter'); ?></span>
                    </div>
                </div>
                <a href="<?php echo esc_url(home_url('/hepa-filtri/')); ?>" class="btn btn--primary btn--large"><?php esc_html_e('ВИЖ HEPA РЕШЕНИЯТА', 'uspeh-filter'); ?> →</a>
            </div>
            <div class="hepa-highlight__image">
                <?php $hepa_img = get_theme_mod('hepa_highlight_img', uspeh_theme_image('slide2.jpg')); ?>
                <?php if ($hepa_img) : ?>
                    <img src="<?php echo esc_url($hepa_img); ?>" alt="HEPA" width="600" height="600" loading="lazy">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
