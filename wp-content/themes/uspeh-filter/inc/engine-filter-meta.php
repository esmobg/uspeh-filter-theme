<?php
declare(strict_types=1);

function uspeh_engine_filter_meta_boxes(): void {
    add_meta_box(
        'uspeh_engine_details',
        __('Детайли на двигателния филтър', 'uspeh-filter'),
        'uspeh_engine_details_callback',
        'engine_filter',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'uspeh_engine_filter_meta_boxes');

function uspeh_engine_details_callback(\WP_Post $post): void {
    wp_nonce_field('uspeh_engine_meta', 'uspeh_engine_nonce');

    $catalog_number = get_post_meta($post->ID, '_catalog_number', true);
    $oem_numbers    = get_post_meta($post->ID, '_oem_numbers', true) ?: [];
    $cross_refs     = get_post_meta($post->ID, '_cross_refs', true) ?: [];
    $dim_a          = get_post_meta($post->ID, '_dim_a', true);
    $dim_b          = get_post_meta($post->ID, '_dim_b', true);
    $dim_h          = get_post_meta($post->ID, '_dim_h', true);
    $vehicle_models = get_post_meta($post->ID, '_vehicle_models', true) ?: [];
    $pdf_datasheet  = get_post_meta($post->ID, '_pdf_datasheet', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="catalog_number"><?php esc_html_e('Каталожен номер (UF-XXXX)', 'uspeh-filter'); ?></label></th>
            <td><input type="text" id="catalog_number" name="catalog_number" value="<?php echo esc_attr($catalog_number); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><?php esc_html_e('Размери', 'uspeh-filter'); ?></th>
            <td>
                A: <input type="text" name="dim_a" value="<?php echo esc_attr($dim_a); ?>" style="width:80px"> mm &nbsp;
                B: <input type="text" name="dim_b" value="<?php echo esc_attr($dim_b); ?>" style="width:80px"> mm &nbsp;
                H: <input type="text" name="dim_h" value="<?php echo esc_attr($dim_h); ?>" style="width:80px"> mm
            </td>
        </tr>
        <tr>
            <th><label for="pdf_datasheet"><?php esc_html_e('PDF Datasheet URL', 'uspeh-filter'); ?></label></th>
            <td><input type="url" id="pdf_datasheet" name="pdf_datasheet" value="<?php echo esc_attr($pdf_datasheet); ?>" class="large-text"></td>
        </tr>
    </table>

    <h4><?php esc_html_e('OEM номера', 'uspeh-filter'); ?></h4>
    <div id="uspeh-oem">
        <?php foreach ($oem_numbers as $oem) : ?>
            <p><input type="text" name="oem_numbers[]" value="<?php echo esc_attr($oem); ?>" class="regular-text"> <button type="button" class="button uspeh-remove-row">&times;</button></p>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button" onclick="document.getElementById('uspeh-oem').insertAdjacentHTML('beforeend','<p><input type=\'text\' name=\'oem_numbers[]\' class=\'regular-text\'> <button type=\'button\' class=\'button uspeh-remove-row\'>&times;</button></p>')">
        <?php esc_html_e('+ Добави OEM номер', 'uspeh-filter'); ?>
    </button>

    <h4><?php esc_html_e('Cross-reference (Етап 2)', 'uspeh-filter'); ?></h4>
    <div id="uspeh-crossref">
        <?php foreach ($cross_refs as $ref) : ?>
            <p>
                <input type="text" name="crossref_brand[]" value="<?php echo esc_attr($ref['brand'] ?? ''); ?>" placeholder="<?php esc_attr_e('Бранд (MANN, Donaldson...)', 'uspeh-filter'); ?>" style="width:35%">
                <input type="text" name="crossref_number[]" value="<?php echo esc_attr($ref['number'] ?? ''); ?>" placeholder="<?php esc_attr_e('Номер', 'uspeh-filter'); ?>" style="width:35%">
                <button type="button" class="button uspeh-remove-row">&times;</button>
            </p>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button" onclick="document.getElementById('uspeh-crossref').insertAdjacentHTML('beforeend','<p><input type=\'text\' name=\'crossref_brand[]\' placeholder=\'Бранд\' style=\'width:35%\'> <input type=\'text\' name=\'crossref_number[]\' placeholder=\'Номер\' style=\'width:35%\'> <button type=\'button\' class=\'button uspeh-remove-row\'>&times;</button></p>')">
        <?php esc_html_e('+ Добави cross-reference', 'uspeh-filter'); ?>
    </button>

    <h4><?php esc_html_e('Подходящи модели превозни средства', 'uspeh-filter'); ?></h4>
    <div id="uspeh-models">
        <?php foreach ($vehicle_models as $model) : ?>
            <p><input type="text" name="vehicle_models[]" value="<?php echo esc_attr($model); ?>" class="regular-text" placeholder="MAN TGA 18.480, Mercedes Actros..."> <button type="button" class="button uspeh-remove-row">&times;</button></p>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button" onclick="document.getElementById('uspeh-models').insertAdjacentHTML('beforeend','<p><input type=\'text\' name=\'vehicle_models[]\' class=\'regular-text\' placeholder=\'Модел превозно средство\'> <button type=\'button\' class=\'button uspeh-remove-row\'>&times;</button></p>')">
        <?php esc_html_e('+ Добави модел', 'uspeh-filter'); ?>
    </button>
    <?php
}

function uspeh_save_engine_meta(int $post_id): void {
    if (!isset($_POST['uspeh_engine_nonce']) || !wp_verify_nonce($_POST['uspeh_engine_nonce'], 'uspeh_engine_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, '_catalog_number', sanitize_text_field($_POST['catalog_number'] ?? ''));
    update_post_meta($post_id, '_dim_a', sanitize_text_field($_POST['dim_a'] ?? ''));
    update_post_meta($post_id, '_dim_b', sanitize_text_field($_POST['dim_b'] ?? ''));
    update_post_meta($post_id, '_dim_h', sanitize_text_field($_POST['dim_h'] ?? ''));
    update_post_meta($post_id, '_pdf_datasheet', esc_url_raw($_POST['pdf_datasheet'] ?? ''));

    $oem = array_filter(array_map('sanitize_text_field', $_POST['oem_numbers'] ?? []));
    update_post_meta($post_id, '_oem_numbers', array_values($oem));

    $cross_refs = [];
    $brands  = $_POST['crossref_brand'] ?? [];
    $numbers = $_POST['crossref_number'] ?? [];
    foreach ($brands as $i => $brand) {
        if ('' !== trim($brand)) {
            $cross_refs[] = [
                'brand'  => sanitize_text_field($brand),
                'number' => sanitize_text_field($numbers[$i] ?? ''),
            ];
        }
    }
    update_post_meta($post_id, '_cross_refs', $cross_refs);

    $models = array_filter(array_map('sanitize_text_field', $_POST['vehicle_models'] ?? []));
    update_post_meta($post_id, '_vehicle_models', array_values($models));
}
add_action('save_post_engine_filter', 'uspeh_save_engine_meta');
