<?php
declare(strict_types=1);

function uspeh_register_inquiry_cpt(): void {
    register_post_type('inquiry', [
        'labels' => [
            'name'               => __('Запитвания', 'uspeh-filter'),
            'singular_name'      => __('Запитване', 'uspeh-filter'),
            'all_items'          => __('Всички запитвания', 'uspeh-filter'),
            'view_item'          => __('Виж запитване', 'uspeh-filter'),
            'search_items'       => __('Търси запитвания', 'uspeh-filter'),
            'not_found'          => __('Няма запитвания', 'uspeh-filter'),
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-email-alt',
        'menu_position'       => 4,
        'supports'            => ['title'],
        'capability_type'     => 'post',
        'capabilities'        => [
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap'        => true,
    ]);
}
add_action('init', 'uspeh_register_inquiry_cpt');

function uspeh_create_inquiry(array $data): int {
    $post_id = wp_insert_post([
        'post_type'   => 'inquiry',
        'post_title'  => sprintf('%s — %s', $data['company'] ?? '', $data['name'] ?? ''),
        'post_status' => 'publish',
    ]);

    if (is_wp_error($post_id)) {
        return 0;
    }

    $fields = [
        '_inquiry_name',
        '_inquiry_company',
        '_inquiry_phone',
        '_inquiry_email',
        '_inquiry_interest',
        '_inquiry_filter_type',
        '_inquiry_product',
        '_inquiry_size_w',
        '_inquiry_size_h',
        '_inquiry_size_d',
        '_inquiry_quantity',
        '_inquiry_filter_class',
        '_inquiry_application',
        '_inquiry_message',
        '_inquiry_source_page',
        '_inquiry_utm_source',
        '_inquiry_utm_medium',
        '_inquiry_utm_campaign',
        '_inquiry_utm_content',
        '_inquiry_utm_term',
        '_inquiry_landing_page',
        '_inquiry_referrer',
        '_inquiry_status',
    ];

    $map = [
        '_inquiry_name'         => 'name',
        '_inquiry_company'      => 'company',
        '_inquiry_phone'        => 'phone',
        '_inquiry_email'        => 'email',
        '_inquiry_interest'     => 'interest',
        '_inquiry_filter_type'  => 'filter_type',
        '_inquiry_product'      => 'product',
        '_inquiry_size_w'       => 'size_w',
        '_inquiry_size_h'       => 'size_h',
        '_inquiry_size_d'       => 'size_d',
        '_inquiry_quantity'     => 'quantity',
        '_inquiry_filter_class' => 'filter_class',
        '_inquiry_application'  => 'application',
        '_inquiry_message'      => 'message',
        '_inquiry_source_page'  => 'source_page',
        '_inquiry_utm_source'   => 'utm_source',
        '_inquiry_utm_medium'   => 'utm_medium',
        '_inquiry_utm_campaign' => 'utm_campaign',
        '_inquiry_utm_content'  => 'utm_content',
        '_inquiry_utm_term'     => 'utm_term',
        '_inquiry_landing_page' => 'landing_page',
        '_inquiry_referrer'     => 'referrer',
    ];

    foreach ($map as $meta_key => $data_key) {
        if (isset($data[$data_key]) && '' !== $data[$data_key]) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($data[$data_key]));
        }
    }

    update_post_meta($post_id, '_inquiry_status', 'new');

    if (!empty($data['files']) && is_array($data['files'])) {
        update_post_meta($post_id, '_inquiry_files', array_map('esc_url_raw', $data['files']));
    }

    return $post_id;
}
