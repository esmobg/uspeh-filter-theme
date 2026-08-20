<?php
/**
 * Template Name: Качество и сертификати
 */
get_header();

if (uspeh_maybe_render_block_page()) {
    return;
}
?>

<?php uspeh_render_breadcrumbs(); ?>

<section class="section">
    <div class="container">
        <div class="section__header">
            <span class="section__label"><?php esc_html_e('КАЧЕСТВО', 'uspeh-filter'); ?></span>
            <h1><?php esc_html_e('Качество, което може да бъде документирано', 'uspeh-filter'); ?></h1>
            <p><?php esc_html_e('Системата за управление на качеството на Успех Филтър ССБ е сертифицирана по ISO 9001:2015.', 'uspeh-filter'); ?></p>
        </div>

        <div class="grid grid--3 quality-cards">
            <div class="card quality-card">
                <div class="card__body">
                    <h3>ISO 9001:2015</h3>
                    <p class="card__text"><?php esc_html_e('Система за управление на качеството', 'uspeh-filter'); ?></p>
                    <p class="card__text"><?php esc_html_e('Сертификатът е наличен при запитване.', 'uspeh-filter'); ?></p>
                </div>
            </div>
            <div class="card quality-card">
                <div class="card__body">
                    <h3><?php esc_html_e('Контрол на производството', 'uspeh-filter'); ?></h3>
                    <p class="card__text"><?php esc_html_e('Проверка на всеки етап от производствения процес', 'uspeh-filter'); ?></p>
                </div>
            </div>
            <div class="card quality-card">
                <div class="card__body">
                    <h3><?php esc_html_e('HEPA изпитване', 'uspeh-filter'); ?></h3>
                    <p class="card__text"><?php esc_html_e('100% контрол на високоефективните филтри', 'uspeh-filter'); ?></p>
                </div>
            </div>
        </div>

        <div class="entry-content">

            <?php the_content(); ?>

        </div>
    </div>
</section>

<?php get_template_part('template-parts/final-cta'); ?>

<?php get_footer(); ?>
