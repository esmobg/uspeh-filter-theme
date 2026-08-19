<?php
/**
 * Template Name: За нас
 */
get_header();
?>

<?php uspeh_render_breadcrumbs(); ?>

<section class="section about-hero">
    <div class="container">
        <div class="about-hero__inner">
            <div class="about-hero__content">
                <span class="section__label"><?php esc_html_e('ЗА НАС', 'uspeh-filter'); ?></span>
                <h1><?php esc_html_e('Над 40 години опит във филтрацията', 'uspeh-filter'); ?></h1>
                <p><?php esc_html_e('Успех Филтър ССБ е български производител на професионални филтри за вентилация, климатизация, HEPA приложения, двигатели и индустриални системи. Компанията съчетава дългогодишен опит с модерни технологии.', 'uspeh-filter'); ?></p>
            </div>
            <div class="about-hero__image">
                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail('product-gallery');
                } else {
                    $about_img = uspeh_theme_image('page-about.jpg');
                    if ($about_img) {
                        echo '<img src="' . esc_url($about_img) . '" alt="">';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <h2 class="text-center"><?php esc_html_e('История', 'uspeh-filter'); ?></h2>
        <div class="timeline">
            <?php
            $milestones = [
                ['year' => '1982', 'text' => __('Основаване на компанията', 'uspeh-filter')],
                ['year' => '1990', 'text' => __('Разширяване на производството', 'uspeh-filter')],
                ['year' => '2000', 'text' => __('Въвеждане на HEPA производство', 'uspeh-filter')],
                ['year' => '2010', 'text' => __('Модернизация на оборудването', 'uspeh-filter')],
                ['year' => '2015', 'text' => __('Сертификация ISO 9001:2015', 'uspeh-filter')],
                ['year' => '2020', 'text' => __('Нови производствени линии', 'uspeh-filter')],
            ];
            foreach ($milestones as $m) : ?>
                <div class="timeline__item">
                    <span class="timeline__year"><?php echo esc_html($m['year']); ?></span>
                    <p class="timeline__text"><?php echo esc_html($m['text']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php the_content(); ?>
    </div>
</section>

<?php get_template_part('template-parts/final-cta'); ?>


<?php get_footer(); ?>
