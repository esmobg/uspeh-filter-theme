</main>

<footer class="site-footer">
    <div class="site-footer__main">
        <div class="container site-footer__grid">
            <div class="site-footer__col site-footer__about">
                <img src="<?php echo esc_url(USPEH_URI . '/assets/images/logo.png'); ?>" alt="Успех Филтър ССБ" class="site-footer__logo" width="180" height="54" loading="lazy">
                <p><?php esc_html_e('Български производител на въздушни, HEPA, карбонови, двигателни и специални филтри за вентилация, климатизация, чисти помещения и индустрия. Над 40 години производствен опит в София.', 'uspeh-filter'); ?></p>
            </div>

            <div class="site-footer__col">
                <h2 class="site-footer__heading"><?php esc_html_e('Продукти и услуги', 'uspeh-filter'); ?></h4>
                <ul class="site-footer__links">
                    <li><a href="<?php echo esc_url(home_url('/vazdushni-filtri/')); ?>"><?php esc_html_e('Въздушни филтри', 'uspeh-filter'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/vazdushni-filtri/fini-filtri/')); ?>"><?php esc_html_e('Фини филтри', 'uspeh-filter'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/hepa-filtri/')); ?>"><?php esc_html_e('EPA, HEPA, ULPA', 'uspeh-filter'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/vazdushni-filtri/karbonovi/')); ?>"><?php esc_html_e('Карбонови филтри', 'uspeh-filter'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/dvigatelni-filtri/')); ?>"><?php esc_html_e('Двигателни филтри', 'uspeh-filter'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/individualno-proizvodstvo/')); ?>"><?php esc_html_e('Индивидуално производство', 'uspeh-filter'); ?></a></li>
                </ul>
            </div>

            <div class="site-footer__col">
                <h2 class="site-footer__heading"><?php esc_html_e('Компания', 'uspeh-filter'); ?></h4>
                <ul class="site-footer__links">
                    <li><a href="<?php echo esc_url(home_url('/za-nas/')); ?>"><?php esc_html_e('За нас', 'uspeh-filter'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/proizvodstvo/')); ?>"><?php esc_html_e('Производство', 'uspeh-filter'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/kachestvo/')); ?>"><?php esc_html_e('Качество', 'uspeh-filter'); ?></a></li>
                    <li><a href="<?php echo esc_url(uspeh_quote_page_url()); ?>"><?php esc_html_e('Поискай оферта', 'uspeh-filter'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/kontakti/')); ?>"><?php esc_html_e('Контакти', 'uspeh-filter'); ?></a></li>
                </ul>
            </div>

            <div class="site-footer__col">
                <h2 class="site-footer__heading"><?php esc_html_e('Контакти', 'uspeh-filter'); ?></h4>
                <address class="site-footer__address">
                    <p><?php echo esc_html(uspeh_get_address()); ?></p>
                    <p><strong><?php esc_html_e('Управител:', 'uspeh-filter'); ?></strong> <a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('manager'))); ?>"><?php echo esc_html(uspeh_get_phone('manager')); ?></a></p>
                    <p><a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('sales'))); ?>"><?php echo esc_html(uspeh_get_phone('sales')); ?></a></p>
                    <p><a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('sales2'))); ?>"><?php echo esc_html(uspeh_get_phone('sales2')); ?></a></p>
                    <p><a href="mailto:<?php echo esc_attr(uspeh_get_email()); ?>"><?php echo esc_html(uspeh_get_email()); ?></a></p>
                    <p><a href="<?php echo esc_url(uspeh_quote_page_url()); ?>" class="site-footer__cta-link"><?php esc_html_e('Изпратете запитване за оферта', 'uspeh-filter'); ?></a></p>
                </address>
            </div>
        </div>
    </div>

    <div class="site-footer__bottom">
        <div class="container site-footer__bottom-inner">
            <p>&copy; <?php echo esc_html(date('Y')); ?> <?php esc_html_e('Успех Филтър ССБ. Всички права запазени.', 'uspeh-filter'); ?></p>
            <nav class="site-footer__legal" aria-label="<?php esc_attr_e('Правна информация', 'uspeh-filter'); ?>">
                <a href="<?php echo esc_url(home_url('/politika-poveritelnost/')); ?>"><?php esc_html_e('Поверителност', 'uspeh-filter'); ?></a>
                <a href="<?php echo esc_url(home_url('/politika-biskvitki/')); ?>"><?php esc_html_e('Бисквитки', 'uspeh-filter'); ?></a>
            </nav>
        </div>
    </div>
</footer>

<?php get_template_part('template-parts/sticky-buttons'); ?>
<?php get_template_part('template-parts/mobile-bottom-bar'); ?>
<?php get_template_part('template-parts/popup-quote-form'); ?>

<?php wp_footer(); ?>
</body>
</html>
