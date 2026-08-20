<?php
/**
 * Template Name: Поискай оферта
 */
get_header();

if (uspeh_maybe_render_block_page()) {
    return;
}
?>

<?php uspeh_render_breadcrumbs(); ?>

<section class="section quote-page">
    <div class="container">
        <div class="quote-page__grid">
            <div class="quote-page__form-col">
                <span class="section__label"><?php esc_html_e('ЗАПИТВАНЕ', 'uspeh-filter'); ?></span>
                <h1><?php esc_html_e('Поискайте оферта директно от производителя', 'uspeh-filter'); ?></h1>
                <p class="quote-page__lead"><?php esc_html_e('Попълнете формата и изпратете размери, снимка, каталожен номер или техническа спецификация. Наш представител ще се свърже с Вас с решение за Вашия обект или машина.', 'uspeh-filter'); ?></p>
                <?php uspeh_render_quote_notice(); ?>
                <?php uspeh_render_quote_form(['id_prefix' => 'page-quote', 'variant' => 'full']); ?>
            </div>

            <div class="quote-page__sidebar">
                <div class="quote-page__contact-card">
                    <h2><?php esc_html_e('Или се свържете директно', 'uspeh-filter'); ?></h2>
                    <p><?php esc_html_e('Подходящо за въздушни филтри, HEPA решения, двигателни филтри и индивидуално производство.', 'uspeh-filter'); ?></p>
                    <div class="quote-page__block">
                        <p><strong><?php esc_html_e('Търговски отдел', 'uspeh-filter'); ?></strong></p>
                        <p><a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('sales'))); ?>"><?php echo esc_html(uspeh_get_phone('sales')); ?></a></p>
                        <p><a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('sales2'))); ?>"><?php echo esc_html(uspeh_get_phone('sales2')); ?></a></p>
                    </div>
                    <div class="quote-page__block">
                        <p><strong><?php esc_html_e('Управител', 'uspeh-filter'); ?></strong></p>
                        <p><a href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('manager'))); ?>"><?php echo esc_html(uspeh_get_phone('manager')); ?></a></p>
                    </div>
                    <div class="quote-page__block">
                        <p><strong>Email</strong></p>
                        <p><a href="mailto:<?php echo esc_attr(uspeh_get_email()); ?>"><?php echo esc_html(uspeh_get_email()); ?></a></p>
                    </div>
                    <div class="quote-page__block">
                        <p><strong><?php esc_html_e('Адрес', 'uspeh-filter'); ?></strong></p>
                        <p><?php echo esc_html(uspeh_get_address()); ?></p>
                    </div>
                    <div class="quote-page__block">
                        <p><strong><?php esc_html_e('Какво да изпратите', 'uspeh-filter'); ?></strong></p>
                        <p><?php esc_html_e('Размери, клас на филтрация, дебит, снимка на стар филтър или каталожен номер.', 'uspeh-filter'); ?></p>
                    </div>
                </div>
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
