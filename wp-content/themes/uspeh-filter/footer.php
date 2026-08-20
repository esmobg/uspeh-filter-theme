</main>

<footer class="site-footer">
    <div class="site-footer__main">
        <div class="container site-footer__grid">
            <div class="site-footer__col site-footer__about">
                <?php uspeh_render_logo('footer'); ?>
                <p><?php esc_html_e('Български производител на въздушни, HEPA, карбонови, двигателни и специални филтри за вентилация, климатизация, чисти помещения и индустрия. Над 40 години производствен опит в София.', 'uspeh-filter'); ?></p>
            </div>

            <div class="site-footer__col">
                <h2 class="site-footer__heading"><?php esc_html_e('Продукти и услуги', 'uspeh-filter'); ?></h2>
                <?php
                if (has_nav_menu('footer')) {
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'site-footer__links',
                        'depth'          => 1,
                    ]);
                } else {
                    uspeh_render_footer_products_fallback();
                }
                ?>
            </div>

            <div class="site-footer__col">
                <h2 class="site-footer__heading"><?php esc_html_e('Компания', 'uspeh-filter'); ?></h2>
                <?php
                if (has_nav_menu('footer-company')) {
                    wp_nav_menu([
                        'theme_location' => 'footer-company',
                        'container'      => false,
                        'menu_class'     => 'site-footer__links',
                        'depth'          => 1,
                    ]);
                } else {
                    uspeh_render_footer_company_fallback();
                }
                ?>
            </div>

            <div class="site-footer__col">
                <h2 class="site-footer__heading"><?php esc_html_e('Контакти', 'uspeh-filter'); ?></h2>
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
                <?php
                if (has_nav_menu('footer-legal')) {
                    wp_nav_menu([
                        'theme_location' => 'footer-legal',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'depth'          => 1,
                        'walker'         => new Uspeh_Footer_Legal_Walker(),
                    ]);
                } else {
                    uspeh_render_footer_legal_fallback();
                }
                ?>
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
