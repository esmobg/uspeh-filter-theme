<?php
declare(strict_types=1);

/**
 * UTM parameters are captured client-side by utm-capture.js and injected
 * into form hidden fields. This file provides server-side helpers.
 */

function uspeh_get_utm_params(): array {
    $params = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'];
    $result = [];
    foreach ($params as $param) {
        $result[$param] = isset($_GET[$param]) ? sanitize_text_field($_GET[$param]) : '';
    }
    return $result;
}

function uspeh_render_utm_hidden_fields(): void {
    $params = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'landing_page', 'referrer'];
    foreach ($params as $param) {
        printf(
            '<input type="hidden" name="_%s" value="" class="uspeh-utm-field" data-utm="%s">',
            esc_attr($param),
            esc_attr($param)
        );
    }
    printf(
        '<input type="hidden" name="_source_page" value="%s">',
        esc_attr(isset($_SERVER['REQUEST_URI']) ? home_url($_SERVER['REQUEST_URI']) : '')
    );
}
