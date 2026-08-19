<?php
declare(strict_types=1);

function uspeh_engine_search_ajax(): void {
    check_ajax_referer('uspeh_engine_search', 'nonce');

    $search      = sanitize_text_field($_POST['search'] ?? '');
    $filter_type = sanitize_text_field($_POST['filter_type'] ?? '');
    $vehicle     = sanitize_text_field($_POST['vehicle_type'] ?? '');
    $make        = sanitize_text_field($_POST['vehicle_make'] ?? '');
    $paged       = absint($_POST['paged'] ?? 1);

    $results = uspeh_search_engine_filters([
        'search'      => $search,
        'filter_type' => $filter_type,
        'vehicle'     => $vehicle,
        'make'        => $make,
        'paged'       => $paged,
    ]);

    ob_start();
    if ($results->have_posts()) {
        while ($results->have_posts()) {
            $results->the_post();
            get_template_part('template-parts/engine-result-card');
        }
        wp_reset_postdata();
    } else {
        echo '<p class="engine-search__no-results">' . esc_html__('Няма намерени резултати. Опитайте с различни критерии или изпратете запитване.', 'uspeh-filter') . '</p>';
    }
    $html = ob_get_clean();

    wp_send_json_success([
        'html'       => $html,
        'found'      => $results->found_posts,
        'max_pages'  => $results->max_num_pages,
    ]);
}
add_action('wp_ajax_uspeh_engine_search', 'uspeh_engine_search_ajax');
add_action('wp_ajax_nopriv_uspeh_engine_search', 'uspeh_engine_search_ajax');

function uspeh_get_vehicle_makes_ajax(): void {
    check_ajax_referer('uspeh_engine_search', 'nonce');

    $vehicle_type = sanitize_text_field($_POST['vehicle_type'] ?? '');

    $args = [
        'taxonomy'   => 'vehicle_make',
        'hide_empty' => true,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ];

    if ($vehicle_type) {
        $filter_ids = get_posts([
            'post_type'      => 'engine_filter',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'tax_query'      => [[
                'taxonomy' => 'vehicle_type',
                'field'    => 'slug',
                'terms'    => $vehicle_type,
            ]],
        ]);

        if (empty($filter_ids)) {
            wp_send_json_success([]);
            return;
        }
        $args['object_ids'] = $filter_ids;
    }

    $terms = get_terms($args);
    $data  = [];
    if (!is_wp_error($terms)) {
        foreach ($terms as $term) {
            $data[] = ['slug' => $term->slug, 'name' => $term->name];
        }
    }

    wp_send_json_success($data);
}
add_action('wp_ajax_uspeh_get_makes', 'uspeh_get_vehicle_makes_ajax');
add_action('wp_ajax_nopriv_uspeh_get_makes', 'uspeh_get_vehicle_makes_ajax');
