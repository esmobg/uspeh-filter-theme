<?php get_header(); ?>

<?php uspeh_render_breadcrumbs(); ?>

<section class="section product-archive">
    <div class="container">
        <div class="section__header">
            <span class="section__label"><?php esc_html_e('ПРОДУКТИ И УСЛУГИ', 'uspeh-filter'); ?></span>
            <h1><?php esc_html_e('Въздушни филтри за климатични и вентилационни инсталации', 'uspeh-filter'); ?></h1>
            <p><?php esc_html_e('Предфилтри, фини филтри, EPA, HEPA, ULPA, карбонови филтри и филтърни материи за обекти с високи изисквания към чистотата на въздуха.', 'uspeh-filter'); ?></p>
        </div>

        <div class="product-archive__intro">
            <div class="product-archive__intro-card">
                <h2><?php esc_html_e('Къде се прилагат', 'uspeh-filter'); ?></h2>
                <p><?php esc_html_e('Решения за болници, фармация, промишленост, хотели, летища, офис сгради и други HVAC приложения.', 'uspeh-filter'); ?></p>
            </div>
            <div class="product-archive__intro-card">
                <h2><?php esc_html_e('Как работим', 'uspeh-filter'); ?></h2>
                <p><?php esc_html_e('Предлагаме стандартни серии и изработка по размер, според камера, касета, дебит, клас и рамка.', 'uspeh-filter'); ?></p>
            </div>
            <div class="product-archive__intro-card">
                <h2><?php esc_html_e('Как да получите оферта', 'uspeh-filter'); ?></h2>
                <p><?php esc_html_e('Изпратете размери, снимка или техническа спецификация и ще подготвим предложение от производителя.', 'uspeh-filter'); ?></p>
            </div>
        </div>

        <?php
        $categories = get_terms([
            'taxonomy'   => 'product_cat',
            'parent'     => 0,
            'hide_empty' => false,
            'orderby'    => 'name',
        ]);
        ?>

        <?php if ($categories && !is_wp_error($categories)) : ?>
            <div class="grid grid--3">
                <?php foreach ($categories as $cat) : ?>
                    <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="card">
                        <?php
                        $thumb_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                        $img      = $thumb_id ? wp_get_attachment_image((int) $thumb_id, 'product-card') : '';
                        ?>
                        <div class="card__image">
                            <?php
                            if ($img) {
                                echo $img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            } else {
                                echo '<img src="' . esc_url(uspeh_theme_image('slide1.jpg')) . '" alt="' . esc_attr($cat->name) . '" width="600" height="600" loading="lazy">';
                            }
                            ?>
                        </div>
                        <div class="card__body">
                            <h3 class="card__title"><?php echo esc_html($cat->name); ?></h3>
                            <?php if ($cat->description) : ?>
                                <p class="card__text"><?php echo esc_html($cat->description); ?></p>
                            <?php endif; ?>
                            <span class="card__link"><?php esc_html_e('Виж продуктите', 'uspeh-filter'); ?> →</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="product-archive__cta">
            <a href="<?php echo esc_url(uspeh_quote_page_url()); ?>" class="btn btn--accent"><?php esc_html_e('Поискай оферта за въздушни филтри', 'uspeh-filter'); ?></a>
        </div>

        <?php if (have_posts()) : ?>
            <div class="product-archive__products">
                <h2><?php esc_html_e('Всички продукти', 'uspeh-filter'); ?></h2>
                <div class="grid grid--3 product-archive__products-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('template-parts/product-card-loop'); ?>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_template_part('template-parts/final-cta'); ?>

<?php get_footer(); ?>
