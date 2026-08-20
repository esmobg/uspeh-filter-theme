<?php
/**
 * Template Name: HEPA филтри
 */
get_header();

if (uspeh_maybe_render_block_page(false)) {
    return;
}

$hero = uspeh_theme_image('slide2.jpg');
?>

<section class="hero hero--compact">
    <div class="hero__bg">
        <?php if ($hero) : ?>
            <img src="<?php echo esc_url($hero); ?>" alt="" class="hero__bg-img" loading="eager">
        <?php endif; ?>
        <div class="hero__overlay"></div>
    </div>
    <div class="container hero__content">
        <span class="hero__label"><?php esc_html_e('EPA, HEPA, ULPA', 'uspeh-filter'); ?></span>
        <h1 class="hero__title"><?php esc_html_e('HEPA филтри за крайно очистване на въздуха', 'uspeh-filter'); ?></h1>
        <p class="hero__text"><?php esc_html_e('Проектирани за болници, фармацевтична индустрия, лаборатории, чисти помещения, електроника и други приложения с високи изисквания към чистотата на въздуха.', 'uspeh-filter'); ?></p>
        <div class="hero__actions">
            <a href="<?php echo esc_url(uspeh_quote_page_url()); ?>" class="btn btn--accent btn--large"><?php esc_html_e('ПОИСКАЙТЕ ЦЕНА', 'uspeh-filter'); ?></a>
            <a href="<?php echo esc_url(home_url('/kontakti/')); ?>" class="btn btn--outline-white btn--large"><?php esc_html_e('Свържете се с нас', 'uspeh-filter'); ?></a>
        </div>
    </div>
</section>

<section class="section hepa-hub">
    <div class="container">
        <div class="section__header">
            <h2><?php esc_html_e('Абсолютни филтри от производителя', 'uspeh-filter'); ?></h2>
            <p><?php esc_html_e('Основните HEPA изпълнения, класове и типични приложения — събрани на едно място за бърз избор и запитване за оферта.', 'uspeh-filter'); ?></p>
        </div>

        <div class="hepa-hub__trust">
            <div class="hepa-hub__trust-item">
                <h3><?php esc_html_e('Изпитване', 'uspeh-filter'); ?></h3>
                <p><?php esc_html_e('Всеки HEPA филтър преминава контрол преди доставка.', 'uspeh-filter'); ?></p>
            </div>
            <div class="hepa-hub__trust-item">
                <h3><?php esc_html_e('Проследимост', 'uspeh-filter'); ?></h3>
                <p><?php esc_html_e('Партида и производствен запис за всеки продукт.', 'uspeh-filter'); ?></p>
            </div>
            <div class="hepa-hub__trust-item">
                <h3><?php esc_html_e('Сертификат', 'uspeh-filter'); ?></h3>
                <p><?php esc_html_e('Индивидуален сертификат към високоефективните филтри.', 'uspeh-filter'); ?></p>
            </div>
            <div class="hepa-hub__trust-item">
                <h3><?php esc_html_e('Стандарти', 'uspeh-filter'); ?></h3>
                <p>EN 1822 • E10–E12 • H13–H14 • U15–U17</p>
            </div>
        </div>

        <div class="hepa-hub__applications">
            <div class="hepa-hub__applications-card">
                <h3><?php esc_html_e('Типични приложения', 'uspeh-filter'); ?></h3>
                <ul>
                    <li><?php esc_html_e('Операционни блокове и болнични зони', 'uspeh-filter'); ?></li>
                    <li><?php esc_html_e('Фармацевтични и лабораторни помещения', 'uspeh-filter'); ?></li>
                    <li><?php esc_html_e('Чисти помещения и електроника', 'uspeh-filter'); ?></li>
                </ul>
            </div>
            <div class="hepa-hub__applications-card">
                <h3><?php esc_html_e('Основни изпълнения', 'uspeh-filter'); ?></h3>
                <ul>
                    <li><?php esc_html_e('HEPA H14 сепараторни', 'uspeh-filter'); ?></li>
                    <li><?php esc_html_e('HEPA H14 mini-pleat', 'uspeh-filter'); ?></li>
                    <li><?php esc_html_e('HEPA високодебитни H14', 'uspeh-filter'); ?></li>
                </ul>
            </div>
        </div>

        <?php
        $hepa_query = new WP_Query([
            'post_type'      => 'product',
            'posts_per_page' => 12,
            'tax_query'      => [[
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => ['hepa', 'epa', 'ulpa'],
            ]],
        ]);
        ?>

        <?php if ($hepa_query->have_posts()) : ?>
            <div class="grid grid--3 hepa-hub__models">
                <?php while ($hepa_query->have_posts()) : $hepa_query->the_post(); ?>
                    <?php get_template_part('template-parts/product-card-loop'); ?>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <p class="catalog-empty text-center"><?php esc_html_e('Продуктите ще бъдат публикувани след въвеждане в каталога.', 'uspeh-filter'); ?></p>
        <?php endif; ?>
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

<?php get_template_part('template-parts/final-cta'); ?>

<?php get_footer(); ?>
