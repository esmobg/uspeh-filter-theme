<?php
declare(strict_types=1);

function uspeh_search_engine_filters(array $params): \WP_Query {
    $args = [
        'post_type'      => 'engine_filter',
        'posts_per_page' => 12,
        'paged'          => $params['paged'] ?? 1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ];

    $tax_query  = [];
    $meta_query = [];

    if (!empty($params['search'])) {
        $search_term = $params['search'];
        $meta_query['relation'] = 'OR';
        $meta_query[] = [
            'key'     => '_catalog_number',
            'value'   => $search_term,
            'compare' => 'LIKE',
        ];
        $meta_query[] = [
            'key'     => '_oem_numbers',
            'value'   => $search_term,
            'compare' => 'LIKE',
        ];
        $meta_query[] = [
            'key'     => '_cross_refs',
            'value'   => $search_term,
            'compare' => 'LIKE',
        ];
    }

    if (!empty($params['filter_type'])) {
        $tax_query[] = [
            'taxonomy' => 'engine_filter_type',
            'field'    => 'slug',
            'terms'    => $params['filter_type'],
        ];
    }

    if (!empty($params['vehicle'])) {
        $tax_query[] = [
            'taxonomy' => 'vehicle_type',
            'field'    => 'slug',
            'terms'    => $params['vehicle'],
        ];
    }

    if (!empty($params['make'])) {
        $tax_query[] = [
            'taxonomy' => 'vehicle_make',
            'field'    => 'slug',
            'terms'    => $params['make'],
        ];
    }

    if (!empty($tax_query)) {
        $tax_query['relation'] = 'AND';
        $args['tax_query']     = $tax_query;
    }
    if (!empty($meta_query)) {
        $args['meta_query'] = $meta_query;
    }

    return new \WP_Query($args);
}
