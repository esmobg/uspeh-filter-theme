<?php
/**
 * Template Name: Благодарим
 */
get_header();
?>

<section class="section thank-you">
    <div class="container text-center">
        <svg class="thank-you__icon" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <h1><?php esc_html_e('Благодарим за запитването!', 'uspeh-filter'); ?></h1>
        <p class="thank-you__lead">
            <?php esc_html_e('Получихме информацията. Представител на Успех Филтър ССБ ще се свърже с Вас.', 'uspeh-filter'); ?>
        </p>
        <div class="thank-you__box">
            <p><strong><?php esc_html_e('За спешно запитване:', 'uspeh-filter'); ?></strong></p>
            <p>
                <a class="thank-you__phone" href="<?php echo esc_url(uspeh_phone_link(uspeh_get_phone('sales'))); ?>">
                    <?php echo esc_html(uspeh_get_phone('sales')); ?>
                </a>
            </p>
            <p><a href="mailto:info@uspehfilter.com">info@uspehfilter.com</a></p>
        </div>
        <div class="thank-you__home">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--outline"><?php esc_html_e('Към началната страница', 'uspeh-filter'); ?></a>
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
