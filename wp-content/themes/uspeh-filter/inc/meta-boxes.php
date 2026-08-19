<?php
declare(strict_types=1);

function uspeh_product_meta_boxes(): void {
    add_meta_box(
        'uspeh_product_details',
        __('Продуктови детайли', 'uspeh-filter'),
        'uspeh_product_details_callback',
        'product',
        'normal',
        'high'
    );
    add_meta_box(
        'uspeh_product_specs',
        __('Технически характеристики', 'uspeh-filter'),
        'uspeh_product_specs_callback',
        'product',
        'normal',
        'default'
    );
    add_meta_box(
        'uspeh_product_documents',
        __('Документи (PDF)', 'uspeh-filter'),
        'uspeh_product_documents_callback',
        'product',
        'normal',
        'default'
    );
    add_meta_box(
        'uspeh_product_faq',
        __('FAQ', 'uspeh-filter'),
        'uspeh_product_faq_callback',
        'product',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'uspeh_product_meta_boxes');

function uspeh_product_details_callback(\WP_Post $post): void {
    wp_nonce_field('uspeh_product_meta', 'uspeh_product_nonce');

    $filter_class     = get_post_meta($post->ID, '_filter_class', true);
    $materials        = get_post_meta($post->ID, '_materials', true);
    $applications     = get_post_meta($post->ID, '_applications', true);
    $advantages       = get_post_meta($post->ID, '_advantages', true) ?: [];
    $sizes            = get_post_meta($post->ID, '_available_sizes', true) ?: [];
    $custom_sizes     = get_post_meta($post->ID, '_supports_custom_sizes', true);
    $gallery          = get_post_meta($post->ID, '_gallery', true) ?: [];
    ?>
    <table class="form-table">
        <tr>
            <th><label for="filter_class"><?php esc_html_e('Клас на филтрация', 'uspeh-filter'); ?></label></th>
            <td><input type="text" id="filter_class" name="filter_class" value="<?php echo esc_attr($filter_class); ?>" class="regular-text" placeholder="G4, M5, F7, H13..."></td>
        </tr>
        <tr>
            <th><label for="materials"><?php esc_html_e('Материали', 'uspeh-filter'); ?></label></th>
            <td><textarea id="materials" name="materials" rows="3" class="large-text"><?php echo esc_textarea($materials); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="applications"><?php esc_html_e('Приложения', 'uspeh-filter'); ?></label></th>
            <td><textarea id="applications" name="applications" rows="3" class="large-text"><?php echo esc_textarea($applications); ?></textarea></td>
        </tr>
        <tr>
            <th><?php esc_html_e('Индивидуални размери', 'uspeh-filter'); ?></th>
            <td><label><input type="checkbox" name="supports_custom_sizes" value="1" <?php checked($custom_sizes, '1'); ?>> <?php esc_html_e('Поддържа индивидуални размери', 'uspeh-filter'); ?></label></td>
        </tr>
    </table>

    <h4><?php esc_html_e('Предимства', 'uspeh-filter'); ?></h4>
    <div id="uspeh-advantages">
        <?php foreach ($advantages as $i => $adv) : ?>
            <p><input type="text" name="advantages[]" value="<?php echo esc_attr($adv); ?>" class="regular-text"> <button type="button" class="button uspeh-remove-row">&times;</button></p>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button" onclick="document.getElementById('uspeh-advantages').insertAdjacentHTML('beforeend','<p><input type=\'text\' name=\'advantages[]\' class=\'regular-text\'> <button type=\'button\' class=\'button uspeh-remove-row\'>&times;</button></p>')">
        <?php esc_html_e('+ Добави предимство', 'uspeh-filter'); ?>
    </button>

    <h4><?php esc_html_e('Налични размери', 'uspeh-filter'); ?></h4>
    <div id="uspeh-sizes">
        <?php foreach ($sizes as $i => $size) : ?>
            <p>
                <input type="text" name="sizes_w[]" value="<?php echo esc_attr($size['w'] ?? ''); ?>" placeholder="Ш (mm)" style="width:80px">
                &times;
                <input type="text" name="sizes_h[]" value="<?php echo esc_attr($size['h'] ?? ''); ?>" placeholder="В (mm)" style="width:80px">
                &times;
                <input type="text" name="sizes_d[]" value="<?php echo esc_attr($size['d'] ?? ''); ?>" placeholder="Д (mm)" style="width:80px">
                <button type="button" class="button uspeh-remove-row">&times;</button>
            </p>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button" onclick="document.getElementById('uspeh-sizes').insertAdjacentHTML('beforeend','<p><input type=\'text\' name=\'sizes_w[]\' placeholder=\'Ш (mm)\' style=\'width:80px\'> &times; <input type=\'text\' name=\'sizes_h[]\' placeholder=\'В (mm)\' style=\'width:80px\'> &times; <input type=\'text\' name=\'sizes_d[]\' placeholder=\'Д (mm)\' style=\'width:80px\'> <button type=\'button\' class=\'button uspeh-remove-row\'>&times;</button></p>')">
        <?php esc_html_e('+ Добави размер', 'uspeh-filter'); ?>
    </button>

    <h4><?php esc_html_e('Галерия', 'uspeh-filter'); ?></h4>
    <div id="uspeh-gallery">
        <?php foreach ($gallery as $img_id) : ?>
            <div class="uspeh-gallery-item" style="display:inline-block;margin:5px;">
                <?php echo wp_get_attachment_image((int) $img_id, 'thumbnail'); ?>
                <input type="hidden" name="gallery[]" value="<?php echo esc_attr($img_id); ?>">
                <button type="button" class="button uspeh-remove-row">&times;</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button" id="uspeh-add-gallery"><?php esc_html_e('+ Добави снимки', 'uspeh-filter'); ?></button>

    <script>
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('uspeh-remove-row')) {
            e.target.closest('p, div.uspeh-gallery-item')?.remove();
        }
    });
    document.getElementById('uspeh-add-gallery')?.addEventListener('click', function() {
        var frame = wp.media({ multiple: true });
        frame.on('select', function() {
            var attachments = frame.state().get('selection').toJSON();
            var container = document.getElementById('uspeh-gallery');
            attachments.forEach(function(att) {
                var html = '<div class="uspeh-gallery-item" style="display:inline-block;margin:5px;">' +
                    '<img src="' + (att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url) + '" width="100">' +
                    '<input type="hidden" name="gallery[]" value="' + att.id + '">' +
                    '<button type="button" class="button uspeh-remove-row">&times;</button></div>';
                container.insertAdjacentHTML('beforeend', html);
            });
        });
        frame.open();
    });
    </script>
    <?php
}

function uspeh_product_specs_callback(\WP_Post $post): void {
    $specs = get_post_meta($post->ID, '_specs', true) ?: [];
    ?>
    <div id="uspeh-specs">
        <?php foreach ($specs as $spec) : ?>
            <p>
                <input type="text" name="spec_param[]" value="<?php echo esc_attr($spec['param'] ?? ''); ?>" placeholder="<?php esc_attr_e('Параметър', 'uspeh-filter'); ?>" class="regular-text" style="width:40%">
                <input type="text" name="spec_value[]" value="<?php echo esc_attr($spec['value'] ?? ''); ?>" placeholder="<?php esc_attr_e('Стойност', 'uspeh-filter'); ?>" class="regular-text" style="width:40%">
                <button type="button" class="button uspeh-remove-row">&times;</button>
            </p>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button" onclick="document.getElementById('uspeh-specs').insertAdjacentHTML('beforeend','<p><input type=\'text\' name=\'spec_param[]\' placeholder=\'Параметър\' class=\'regular-text\' style=\'width:40%\'> <input type=\'text\' name=\'spec_value[]\' placeholder=\'Стойност\' class=\'regular-text\' style=\'width:40%\'> <button type=\'button\' class=\'button uspeh-remove-row\'>&times;</button></p>')">
        <?php esc_html_e('+ Добави характеристика', 'uspeh-filter'); ?>
    </button>
    <?php
}

function uspeh_product_documents_callback(\WP_Post $post): void {
    $docs = get_post_meta($post->ID, '_documents', true) ?: [];
    ?>
    <div id="uspeh-docs">
        <?php foreach ($docs as $doc) : ?>
            <p>
                <input type="text" name="doc_name[]" value="<?php echo esc_attr($doc['name'] ?? ''); ?>" placeholder="<?php esc_attr_e('Име на документа', 'uspeh-filter'); ?>" style="width:40%">
                <input type="text" name="doc_url[]" value="<?php echo esc_attr($doc['url'] ?? ''); ?>" placeholder="<?php esc_attr_e('URL на PDF', 'uspeh-filter'); ?>" style="width:40%">
                <button type="button" class="button uspeh-remove-row">&times;</button>
            </p>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button" onclick="document.getElementById('uspeh-docs').insertAdjacentHTML('beforeend','<p><input type=\'text\' name=\'doc_name[]\' placeholder=\'Име\' style=\'width:40%\'> <input type=\'text\' name=\'doc_url[]\' placeholder=\'URL на PDF\' style=\'width:40%\'> <button type=\'button\' class=\'button uspeh-remove-row\'>&times;</button></p>')">
        <?php esc_html_e('+ Добави документ', 'uspeh-filter'); ?>
    </button>
    <?php
}

function uspeh_product_faq_callback(\WP_Post $post): void {
    $faqs = get_post_meta($post->ID, '_faq', true) ?: [];
    ?>
    <div id="uspeh-faq">
        <?php foreach ($faqs as $faq) : ?>
            <div style="margin-bottom:10px;padding:10px;background:#f9f9f9;">
                <p><input type="text" name="faq_q[]" value="<?php echo esc_attr($faq['q'] ?? ''); ?>" placeholder="<?php esc_attr_e('Въпрос', 'uspeh-filter'); ?>" class="large-text"></p>
                <p><textarea name="faq_a[]" rows="2" class="large-text" placeholder="<?php esc_attr_e('Отговор', 'uspeh-filter'); ?>"><?php echo esc_textarea($faq['a'] ?? ''); ?></textarea></p>
                <button type="button" class="button uspeh-remove-row">&times;</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button" onclick="document.getElementById('uspeh-faq').insertAdjacentHTML('beforeend','<div style=\'margin-bottom:10px;padding:10px;background:#f9f9f9;\'><p><input type=\'text\' name=\'faq_q[]\' placeholder=\'Въпрос\' class=\'large-text\'></p><p><textarea name=\'faq_a[]\' rows=\'2\' class=\'large-text\' placeholder=\'Отговор\'></textarea></p><button type=\'button\' class=\'button uspeh-remove-row\'>&times;</button></div>')">
        <?php esc_html_e('+ Добави въпрос', 'uspeh-filter'); ?>
    </button>
    <?php
}

function uspeh_save_product_meta(int $post_id): void {
    if (!isset($_POST['uspeh_product_nonce']) || !wp_verify_nonce($_POST['uspeh_product_nonce'], 'uspeh_product_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, '_filter_class', sanitize_text_field($_POST['filter_class'] ?? ''));
    update_post_meta($post_id, '_materials', sanitize_textarea_field($_POST['materials'] ?? ''));
    update_post_meta($post_id, '_applications', sanitize_textarea_field($_POST['applications'] ?? ''));
    update_post_meta($post_id, '_supports_custom_sizes', isset($_POST['supports_custom_sizes']) ? '1' : '0');

    $advantages = array_filter(array_map('sanitize_text_field', $_POST['advantages'] ?? []));
    update_post_meta($post_id, '_advantages', $advantages);

    $sizes = [];
    $ws = $_POST['sizes_w'] ?? [];
    $hs = $_POST['sizes_h'] ?? [];
    $ds = $_POST['sizes_d'] ?? [];
    foreach ($ws as $i => $w) {
        if ('' !== trim($w) || '' !== trim($hs[$i] ?? '') || '' !== trim($ds[$i] ?? '')) {
            $sizes[] = [
                'w' => sanitize_text_field($w),
                'h' => sanitize_text_field($hs[$i] ?? ''),
                'd' => sanitize_text_field($ds[$i] ?? ''),
            ];
        }
    }
    update_post_meta($post_id, '_available_sizes', $sizes);

    $gallery = array_filter(array_map('absint', $_POST['gallery'] ?? []));
    update_post_meta($post_id, '_gallery', $gallery);

    $specs = [];
    $params = $_POST['spec_param'] ?? [];
    $values = $_POST['spec_value'] ?? [];
    foreach ($params as $i => $param) {
        if ('' !== trim($param)) {
            $specs[] = [
                'param' => sanitize_text_field($param),
                'value' => sanitize_text_field($values[$i] ?? ''),
            ];
        }
    }
    update_post_meta($post_id, '_specs', $specs);

    $docs = [];
    $doc_names = $_POST['doc_name'] ?? [];
    $doc_urls  = $_POST['doc_url'] ?? [];
    foreach ($doc_names as $i => $name) {
        if ('' !== trim($name)) {
            $docs[] = [
                'name' => sanitize_text_field($name),
                'url'  => esc_url_raw($doc_urls[$i] ?? ''),
            ];
        }
    }
    update_post_meta($post_id, '_documents', $docs);

    $faqs = [];
    $faq_qs = $_POST['faq_q'] ?? [];
    $faq_as = $_POST['faq_a'] ?? [];
    foreach ($faq_qs as $i => $q) {
        if ('' !== trim($q)) {
            $faqs[] = [
                'q' => sanitize_text_field($q),
                'a' => sanitize_textarea_field($faq_as[$i] ?? ''),
            ];
        }
    }
    update_post_meta($post_id, '_faq', $faqs);
}
add_action('save_post_product', 'uspeh_save_product_meta');
