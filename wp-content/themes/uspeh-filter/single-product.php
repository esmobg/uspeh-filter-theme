<?php get_header(); ?>

<?php uspeh_render_breadcrumbs(); ?>

<?php while (have_posts()) : the_post(); ?>

<?php
$filter_class     = get_post_meta(get_the_ID(), '_filter_class', true);
$materials        = get_post_meta(get_the_ID(), '_materials', true);
$applications_txt = get_post_meta(get_the_ID(), '_applications', true);
$advantages       = get_post_meta(get_the_ID(), '_advantages', true) ?: [];
$sizes            = get_post_meta(get_the_ID(), '_available_sizes', true) ?: [];
$custom_sizes     = get_post_meta(get_the_ID(), '_supports_custom_sizes', true);
$gallery          = get_post_meta(get_the_ID(), '_gallery', true) ?: [];
$specs            = get_post_meta(get_the_ID(), '_specs', true) ?: [];
$docs             = get_post_meta(get_the_ID(), '_documents', true) ?: [];
$faqs             = get_post_meta(get_the_ID(), '_faq', true) ?: [];
?>

<article class="section single-product-page">
    <div class="container">
        <div class="single-product-page__grid">
            <div class="single-product-page__gallery">
                <div class="single-product-page__main-img">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('product-gallery'); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url(uspeh_theme_image('slide2.jpg')); ?>" alt="<?php the_title_attribute(); ?>" width="1200" height="900">
                    <?php endif; ?>
                </div>
                <?php if (!empty($gallery)) : ?>
                    <div class="single-product-page__thumbs">
                        <?php foreach ($gallery as $img_id) : ?>
                            <div class="single-product-page__thumb">
                                <?php echo wp_get_attachment_image((int) $img_id, 'thumbnail'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="single-product-page__info">
                <h1><?php the_title(); ?></h1>
                <?php if ($filter_class) : ?>
                    <span class="single-product-page__class"><?php echo esc_html($filter_class); ?></span>
                <?php endif; ?>
                <div class="single-product-page__excerpt">
                    <?php the_content(); ?>
                </div>

                <?php if (!empty($advantages)) : ?>
                    <div class="single-product-page__advantages">
                        <h4><?php esc_html_e('Предимства', 'uspeh-filter'); ?></h4>
                        <ul>
                            <?php foreach ($advantages as $adv) : ?>
                                <li><?php echo esc_html($adv); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="single-product-page__actions">
                    <a href="#product-inquiry" class="btn btn--accent btn--large"><?php esc_html_e('ПОИСКАЙТЕ ЦЕНА', 'uspeh-filter'); ?></a>
                    <?php if ('1' === $custom_sizes) : ?>
                        <a href="<?php echo esc_url(home_url('/individualno-proizvodstvo/')); ?>" class="btn btn--outline"><?php esc_html_e('НЕСТАНДАРТЕН РАЗМЕР?', 'uspeh-filter'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (!empty($specs)) : ?>
            <div class="single-product-page__section">
                <h2><?php esc_html_e('Технически характеристики', 'uspeh-filter'); ?></h2>
                <table class="specs-table">
                    <?php foreach ($specs as $spec) : ?>
                        <tr>
                            <td><?php echo esc_html($spec['param']); ?></td>
                            <td><?php echo esc_html($spec['value']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($materials) : ?>
                        <tr><td><?php esc_html_e('Материали', 'uspeh-filter'); ?></td><td><?php echo esc_html($materials); ?></td></tr>
                    <?php endif; ?>
                </table>
            </div>
        <?php endif; ?>

        <?php if (!empty($sizes)) : ?>
            <div class="single-product-page__section">
                <h3><?php esc_html_e('Налични размери', 'uspeh-filter'); ?></h3>
                <table class="specs-table">
                    <tr class="specs-table__head">
                        <td><?php esc_html_e('Ширина (mm)', 'uspeh-filter'); ?></td>
                        <td><?php esc_html_e('Височина (mm)', 'uspeh-filter'); ?></td>
                        <td><?php esc_html_e('Дебелина (mm)', 'uspeh-filter'); ?></td>
                    </tr>
                    <?php foreach ($sizes as $size) : ?>
                        <tr>
                            <td><?php echo esc_html($size['w']); ?></td>
                            <td><?php echo esc_html($size['h']); ?></td>
                            <td><?php echo esc_html($size['d']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($applications_txt) : ?>
            <div class="single-product-page__section">
                <h3><?php esc_html_e('Приложения', 'uspeh-filter'); ?></h3>
                <p><?php echo nl2br(esc_html($applications_txt)); ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($docs)) : ?>
            <div class="single-product-page__section">
                <h3><?php esc_html_e('Технически документи', 'uspeh-filter'); ?></h3>
                <div class="single-product-page__docs">
                    <?php foreach ($docs as $doc) : ?>
                        <a href="<?php echo esc_url($doc['url']); ?>" target="_blank" rel="noopener" class="btn btn--outline btn--small">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                            <?php echo esc_html($doc['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($faqs)) : ?>
            <div class="single-product-page__section">
                <h3><?php esc_html_e('Често задавани въпроси', 'uspeh-filter'); ?></h3>
                <div class="faq-list">
                    <?php foreach ($faqs as $faq) : ?>
                        <div class="faq-item">
                            <button class="faq-item__question"><?php echo esc_html($faq['q']); ?></button>
                            <div class="faq-item__answer"><div class="faq-item__answer-inner"><?php echo esc_html($faq['a']); ?></div></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="single-product-page__cta-block" id="product-inquiry">
            <h2><?php printf(esc_html__('Поискайте цена за %s', 'uspeh-filter'), get_the_title()); ?></h2>
            <p><?php esc_html_e('Формата автоматично включва информация за този продукт.', 'uspeh-filter'); ?></p>
            <?php uspeh_render_quote_form(['id_prefix' => 'product', 'variant' => 'full', 'product' => get_the_title()]); ?>
        </div>
    </div>
</article>

<?php endwhile; ?>


<?php get_footer(); ?>
