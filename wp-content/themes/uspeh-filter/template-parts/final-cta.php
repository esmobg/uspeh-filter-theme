<section class="section section--dark final-cta">
    <div class="container text-center">
        <span class="section__label"><?php esc_html_e('КОНТАКТ', 'uspeh-filter'); ?></span>
        <h2><?php esc_html_e('Търсите конкретен филтър или решение по задание?', 'uspeh-filter'); ?></h2>
        <p class="final-cta__text">
            <?php esc_html_e('Изпратете размери, снимка, каталожен номер или техническа спецификация. Търговският ни екип ще предложи подходяща филтрация за Вашия обект, машина или производствен процес.', 'uspeh-filter'); ?>
        </p>
        <div class="final-cta__actions">
            <a href="<?php echo esc_url(uspeh_quote_page_url()); ?>" class="btn btn--accent btn--large"><?php esc_html_e('ИЗПРАТИ ЗАПИТВАНЕ', 'uspeh-filter'); ?></a>
            <a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('sales'))); ?>" class="btn btn--outline-white btn--large">
                <?php esc_html_e('Обадете се:', 'uspeh-filter'); ?> <?php echo esc_html(uspeh_get_phone('sales')); ?>
            </a>
        </div>
        <p class="final-cta__contact-line">
            <a href="mailto:<?php echo esc_attr(uspeh_get_email()); ?>"><?php echo esc_html(uspeh_get_email()); ?></a>
            <span aria-hidden="true">|</span>
            <span><?php echo esc_html(uspeh_get_address()); ?></span>
        </p>
    </div>
</section>
