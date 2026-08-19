<?php
declare(strict_types=1);

/**
 * 301 redirects from old site URLs to new structure.
 * Populated during migration after crawling the old site.
 */
function uspeh_handle_redirects(): void {
    if (is_admin()) {
        return;
    }

    $redirects = [
        '/index.php?lang=1&m=739' => '/vazdushni-filtri/',
        '/index.php?lang=1&m=738' => '/za-nas/',
        '/index.php?lang=2'       => '/en/',
        '/index.php?lang=2&m=739' => '/en/products/',
        '/index.php?lang=2&m=738' => '/en/about/',
    ];

    $request_uri = $_SERVER['REQUEST_URI'] ?? '';

    if (isset($redirects[$request_uri])) {
        wp_redirect(home_url($redirects[$request_uri]), 301);
        exit;
    }
}
add_action('template_redirect', 'uspeh_handle_redirects');
