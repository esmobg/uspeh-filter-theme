<?php
/**
 * Template Name: Контакти
 */
get_header();

if (uspeh_maybe_render_block_page()) {
    return;
}
?>

<?php uspeh_render_breadcrumbs(); ?>

<section class="section contacts-page">
    <div class="container">
        <div class="section__header">
            <h1><?php esc_html_e('Контакти', 'uspeh-filter'); ?></h1>
            <p><?php esc_html_e('Свържете се директно с производителя за въздушни, HEPA, двигателни и нестандартни филтри.', 'uspeh-filter'); ?></p>
        </div>

        <div class="contacts-page__grid">
            <div class="contacts-page__info">
                <h2><?php esc_html_e('Успех Филтър ССБ', 'uspeh-filter'); ?></h2>

                <div class="contacts-page__department">
                    <h3><?php esc_html_e('Търговски отдел', 'uspeh-filter'); ?></h3>
                    <p><a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('sales'))); ?>"><?php echo esc_html(uspeh_get_phone('sales')); ?></a></p>
                    <p><a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('sales2'))); ?>"><?php echo esc_html(uspeh_get_phone('sales2')); ?></a></p>
                </div>

                <div class="contacts-page__department">
                    <h3><?php esc_html_e('HVAC филтри', 'uspeh-filter'); ?></h3>
                    <p><a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('sales'))); ?>"><?php echo esc_html(uspeh_get_phone('sales')); ?></a></p>
                </div>

                <div class="contacts-page__department">
                    <h3><?php esc_html_e('Двигателни филтри', 'uspeh-filter'); ?></h3>
                    <p><a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('sales2'))); ?>"><?php echo esc_html(uspeh_get_phone('sales2')); ?></a></p>
                </div>

                <div class="contacts-page__department">
                    <h3><?php esc_html_e('Технически въпроси', 'uspeh-filter'); ?></h3>
                    <p><a href="mailto:<?php echo esc_attr(uspeh_get_email()); ?>"><?php echo esc_html(uspeh_get_email()); ?></a></p>
                </div>

                <div class="contacts-page__department">
                    <h3><?php esc_html_e('Администрация', 'uspeh-filter'); ?></h3>
                    <p><a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('manager'))); ?>"><?php echo esc_html(uspeh_get_phone('manager')); ?></a></p>
                </div>

                <div class="contacts-page__department">
                    <h3><?php esc_html_e('Адрес', 'uspeh-filter'); ?></h3>
                    <p><?php echo esc_html(uspeh_get_address()); ?></p>
                </div>

                <div class="contacts-page__department">
                    <h3><?php esc_html_e('Работим с', 'uspeh-filter'); ?></h3>
                    <p><?php esc_html_e('Болници, фармация, промишленост, хотели, летища, офис сгради и автопарк клиенти.', 'uspeh-filter'); ?></p>
                </div>

                <div class="contacts-page__map">
                    <iframe src="https://www.google.com/maps?q=бул.+Европа+138+София&output=embed" title="<?php esc_attr_e('Карта — бул. Европа 138, София', 'uspeh-filter'); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <div class="contacts-page__form-col">
                <h3><?php esc_html_e('Изпратете ни съобщение', 'uspeh-filter'); ?></h3>
                <?php uspeh_render_quote_notice(); ?>
                <?php uspeh_render_quote_form(['id_prefix' => 'contact', 'variant' => 'compact', 'submit' => __('ИЗПРАТИ', 'uspeh-filter')]); ?>
            </div>
        </div>
    </div>
</section>

<?php
$extra = get_the_content();
if ($extra) : ?>
<section class="section">
    <div class="container">
        <?php the_content(); ?>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
