<?php
/**
 * One-time WP-CLI helper: seed pages with starter block patterns.
 * Страниците се намират по slug (а не по чупливи ID-та).
 *
 * Usage: wp eval-file wp-content/themes/uspeh-filter/inc/seed-gutenberg-pages.php
 */
if (!defined('ABSPATH')) {
    exit;
}

function uspeh_seed_gutenberg_pages(): void {
    $page_patterns = [
        'nachalo'                   => ['uspeh/page-home'],
        'poiskaj-oferta'            => ['uspeh/page-quote'],
        'individualno-proizvodstvo' => ['uspeh/page-custom-production'],
        'hepa-filtri'               => ['uspeh/page-hepa'],
        'za-nas'                    => ['uspeh/page-about'],
        'proizvodstvo'              => ['uspeh/page-production'],
        'kachestvo'                 => ['uspeh/page-quality'],
        'kontakti'                  => ['uspeh/page-contact'],
        'blagodaria'                => ['uspeh/page-thank-you'],
        'vaprosi'                   => ['uspeh/page-faq'],
        'prilozhenia'               => ['uspeh/page-applications'],
        'referencii'                => ['uspeh/testimonials', 'uspeh/logo-strip', 'uspeh/certifications'],
    ];

    $registry = WP_Block_Patterns_Registry::get_instance();

    foreach ($page_patterns as $slug => $pattern_slugs) {
        $post = get_page_by_path($slug);
        if (!$post instanceof WP_Post) {
            WP_CLI::warning("Page '{$slug}' not found.");
            continue;
        }

        if (has_blocks((string) $post->post_content)) {
            WP_CLI::warning("Skip '{$slug}' {$post->post_title} — has blocks. Clear content first to restore PHP template design.");
            continue;
        }

        $content = '';
        foreach ($pattern_slugs as $pattern_slug) {
            $pattern = $registry->get_registered($pattern_slug);
            if (!is_array($pattern) || empty($pattern['content'])) {
                WP_CLI::warning("Pattern {$pattern_slug} not found.");
                continue 2;
            }
            $content .= $pattern['content'] . "\n\n";
        }

        $result = wp_update_post([
            'ID'           => $post->ID,
            'post_content' => trim($content),
        ], true);

        if (is_wp_error($result)) {
            WP_CLI::warning("Failed '{$slug}': " . $result->get_error_message());
            continue;
        }

        WP_CLI::success("Seeded '{$slug}' {$post->post_title} ← " . implode(' + ', $pattern_slugs));
    }
}

uspeh_seed_gutenberg_pages();
