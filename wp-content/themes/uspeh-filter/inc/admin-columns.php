<?php
declare(strict_types=1);

function uspeh_inquiry_columns(array $columns): array {
    $new = [];
    $new['cb']       = $columns['cb'];
    $new['title']    = $columns['title'];
    $new['company']  = __('Фирма', 'uspeh-filter');
    $new['phone']    = __('Телефон', 'uspeh-filter');
    $new['interest'] = __('Интерес', 'uspeh-filter');
    $new['status']   = __('Статус', 'uspeh-filter');
    $new['date']     = $columns['date'];
    return $new;
}
add_filter('manage_inquiry_posts_columns', 'uspeh_inquiry_columns');

function uspeh_inquiry_column_data(string $column, int $post_id): void {
    switch ($column) {
        case 'company':
            echo esc_html(get_post_meta($post_id, '_inquiry_company', true));
            break;
        case 'phone':
            echo esc_html(get_post_meta($post_id, '_inquiry_phone', true));
            break;
        case 'interest':
            echo esc_html(get_post_meta($post_id, '_inquiry_interest', true));
            break;
        case 'status':
            $status = get_post_meta($post_id, '_inquiry_status', true) ?: 'new';
            $labels = [
                'new'        => __('Ново', 'uspeh-filter'),
                'processing' => __('В обработка', 'uspeh-filter'),
                'completed'  => __('Завършено', 'uspeh-filter'),
                'cancelled'  => __('Отказано', 'uspeh-filter'),
            ];
            echo '<span class="uspeh-status uspeh-status--' . esc_attr($status) . '">';
            echo esc_html($labels[$status] ?? $status);
            echo '</span>';
            break;
        default:
            $exhaustiveCheck = $column;
            break;
    }
}
add_action('manage_inquiry_posts_custom_column', 'uspeh_inquiry_column_data', 10, 2);

function uspeh_inquiry_sortable_columns(array $columns): array {
    $columns['company'] = 'company';
    $columns['status']  = 'status';
    return $columns;
}
add_filter('manage_edit-inquiry_sortable_columns', 'uspeh_inquiry_sortable_columns');

function uspeh_engine_filter_columns(array $columns): array {
    $new = [];
    $new['cb']             = $columns['cb'];
    $new['title']          = $columns['title'];
    $new['catalog_number'] = __('Каталожен номер', 'uspeh-filter');
    $new['taxonomy-engine_filter_type'] = __('Тип', 'uspeh-filter');
    $new['taxonomy-vehicle_make']       = __('Марка', 'uspeh-filter');
    $new['date']           = $columns['date'];
    return $new;
}
add_filter('manage_engine_filter_posts_columns', 'uspeh_engine_filter_columns');

function uspeh_engine_filter_column_data(string $column, int $post_id): void {
    switch ($column) {
        case 'catalog_number':
            echo esc_html(get_post_meta($post_id, '_catalog_number', true));
            break;
        default:
            break;
    }
}
add_action('manage_engine_filter_posts_custom_column', 'uspeh_engine_filter_column_data', 10, 2);
