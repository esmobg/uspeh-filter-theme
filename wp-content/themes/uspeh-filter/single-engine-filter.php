<?php get_header(); ?>

<?php uspeh_render_breadcrumbs(); ?>

<?php while (have_posts()) : the_post(); ?>

<?php
$catalog = get_post_meta(get_the_ID(), '_catalog_number', true);
$oems    = get_post_meta(get_the_ID(), '_oem_numbers', true) ?: [];
$cross   = get_post_meta(get_the_ID(), '_cross_refs', true) ?: [];
$dim_a   = get_post_meta(get_the_ID(), '_dim_a', true);
$dim_b   = get_post_meta(get_the_ID(), '_dim_b', true);
$dim_h   = get_post_meta(get_the_ID(), '_dim_h', true);
$models  = get_post_meta(get_the_ID(), '_vehicle_models', true) ?: [];
$pdf     = get_post_meta(get_the_ID(), '_pdf_datasheet', true);
$types   = get_the_terms(get_the_ID(), 'engine_filter_type');
$makes   = get_the_terms(get_the_ID(), 'vehicle_make');
$vtypes  = get_the_terms(get_the_ID(), 'vehicle_type');
?>

<article class="section single-engine">
    <div class="container">
        <div class="single-engine__grid">
            <div class="single-engine__image">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('product-gallery'); ?>
                <?php endif; ?>
            </div>

            <div class="single-engine__info">
                <?php if ($catalog) : ?>
                    <span class="single-engine__catalog"><?php echo esc_html($catalog); ?></span>
                <?php endif; ?>
                <h1><?php the_title(); ?></h1>

                <?php if ($types && !is_wp_error($types)) : ?>
                    <p class="single-engine__type"><?php echo esc_html($types[0]->name); ?></p>
                <?php endif; ?>

                <table class="specs-table" style="margin-top: 1.5rem;">
                    <?php if ($dim_a || $dim_b || $dim_h) : ?>
                        <tr><td>A</td><td><?php echo esc_html($dim_a); ?> mm</td></tr>
                        <tr><td>B</td><td><?php echo esc_html($dim_b); ?> mm</td></tr>
                        <tr><td>H</td><td><?php echo esc_html($dim_h); ?> mm</td></tr>
                    <?php endif; ?>
                </table>

                <?php if ($makes && !is_wp_error($makes)) : ?>
                    <div style="margin-top: 1.5rem;">
                        <h2><?php esc_html_e('Подходящ за', 'uspeh-filter'); ?></h2>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem;">
                            <?php foreach ($makes as $mk) : ?>
                                <span style="background: var(--color-bg-alt); padding: 0.3rem 0.75rem; border-radius: 20px; font-size: 0.85rem;"><?php echo esc_html($mk->name); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($models)) : ?>
                    <div style="margin-top: 1rem;">
                        <h3><?php esc_html_e('Модели', 'uspeh-filter'); ?></h3>
                        <ul style="margin-top: 0.5rem; columns: 2; font-size: 0.9rem; color: var(--color-text-light);">
                            <?php foreach ($models as $model) : ?>
                                <li style="margin-bottom: 0.3rem;"><?php echo esc_html($model); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($oems)) : ?>
                    <div style="margin-top: 1.5rem;">
                        <h3>OEM <?php esc_html_e('номера', 'uspeh-filter'); ?></h3>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem;">
                            <?php foreach ($oems as $oem) : ?>
                                <code style="background: var(--color-bg-alt); padding: 0.25rem 0.6rem; border-radius: 4px; font-size: 0.85rem;"><?php echo esc_html($oem); ?></code>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($pdf) : ?>
                    <div style="margin-top: 1.5rem;">
                        <a href="<?php echo esc_url($pdf); ?>" target="_blank" class="btn btn--outline btn--small">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/></svg>
                            PDF Datasheet
                        </a>
                    </div>
                <?php endif; ?>

                <div class="single-engine__actions" style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="#" class="btn btn--accent btn--large" data-product-inquiry="<?php echo esc_attr($catalog ?: get_the_title()); ?>" data-popup-open="popup-quote"><?php esc_html_e('ПОИСКАЙ ЦЕНА', 'uspeh-filter'); ?></a>
                </div>
            </div>
        </div>
    </div>
</article>

<?php endwhile; ?>


<?php get_footer(); ?>
