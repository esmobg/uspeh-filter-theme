<?php
$catalog = get_post_meta(get_the_ID(), '_catalog_number', true);
$oems    = get_post_meta(get_the_ID(), '_oem_numbers', true) ?: [];
$dim_a   = get_post_meta(get_the_ID(), '_dim_a', true);
$dim_b   = get_post_meta(get_the_ID(), '_dim_b', true);
$dim_h   = get_post_meta(get_the_ID(), '_dim_h', true);
$models  = get_post_meta(get_the_ID(), '_vehicle_models', true) ?: [];
$types   = get_the_terms(get_the_ID(), 'engine_filter_type');
$makes   = get_the_terms(get_the_ID(), 'vehicle_make');
?>

<div class="engine-result">
    <div class="engine-result__left">
        <?php if (has_post_thumbnail()) : ?>
            <div class="engine-result__img">
                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
            </div>
        <?php endif; ?>
    </div>
    <div class="engine-result__body">
        <div class="engine-result__header">
            <?php if ($catalog) : ?>
                <span class="engine-result__catalog"><?php echo esc_html($catalog); ?></span>
            <?php endif; ?>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php if ($types && !is_wp_error($types)) : ?>
                <span class="engine-result__type"><?php echo esc_html($types[0]->name); ?></span>
            <?php endif; ?>
        </div>

        <?php if ($makes && !is_wp_error($makes)) : ?>
            <div class="engine-result__meta">
                <strong><?php esc_html_e('Марки:', 'uspeh-filter'); ?></strong>
                <?php echo esc_html(implode(', ', wp_list_pluck($makes, 'name'))); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($models)) : ?>
            <div class="engine-result__meta">
                <strong><?php esc_html_e('Модели:', 'uspeh-filter'); ?></strong>
                <?php echo esc_html(implode(', ', array_slice($models, 0, 5))); ?>
                <?php if (count($models) > 5) : ?>
                    <a href="<?php the_permalink(); ?>">+<?php echo count($models) - 5; ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($oems)) : ?>
            <div class="engine-result__meta">
                <strong>OEM:</strong>
                <?php echo esc_html(implode(', ', array_slice($oems, 0, 3))); ?>
                <?php if (count($oems) > 3) : ?>...<?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($dim_a || $dim_b || $dim_h) : ?>
            <div class="engine-result__meta">
                <strong><?php esc_html_e('Размери:', 'uspeh-filter'); ?></strong>
                A: <?php echo esc_html($dim_a); ?> mm, B: <?php echo esc_html($dim_b); ?> mm, H: <?php echo esc_html($dim_h); ?> mm
            </div>
        <?php endif; ?>
    </div>
    <div class="engine-result__actions">
        <a href="<?php the_permalink(); ?>" class="btn btn--outline btn--small"><?php esc_html_e('Детайли', 'uspeh-filter'); ?></a>
        <a href="#" class="btn btn--accent btn--small" data-product-inquiry="<?php echo esc_attr($catalog ?: get_the_title()); ?>" data-popup-open="popup-quote"><?php esc_html_e('Поискай цена', 'uspeh-filter'); ?></a>
    </div>
</div>

