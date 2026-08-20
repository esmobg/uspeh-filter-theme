<?php
/**
 * One-time WP-CLI helper: seed pages with starter block patterns.
 *
 * Usage: wp eval-file wp-content/themes/uspeh-filter/inc/seed-gutenberg-pages.php
 */
if (!defined('ABSPATH')) {
    exit;
}

function uspeh_seed_gutenberg_pages(): void {
    $page_patterns = [
        11 => 'uspeh/page-home',
        12 => 'uspeh/page-quote',
        13 => 'uspeh/page-custom-production',
        14 => 'uspeh/page-hepa',
        15 => 'uspeh/page-about',
        16 => 'uspeh/page-production',
        17 => 'uspeh/page-quality',
        18 => 'uspeh/page-contact',
        19 => 'uspeh/page-thank-you',
    ];

    $registry = WP_Block_Patterns_Registry::get_instance();

    foreach ($page_patterns as $page_id => $pattern_slug) {
        $post = get_post($page_id);
        if (!$post instanceof WP_Post) {
            WP_CLI::warning("Page {$page_id} not found.");
            continue;
        }

        if (has_blocks((string) $post->post_content)) {
            WP_CLI::warning("Skip #{$page_id} {$post->post_title} — has blocks. Clear content first to restore PHP template design.");
            continue;
        }

        $pattern = $registry->get_registered($pattern_slug);
        if (!is_array($pattern) || empty($pattern['content'])) {
            WP_CLI::warning("Pattern {$pattern_slug} not found.");
            continue;
        }

        $result = wp_update_post([
            'ID'           => $page_id,
            'post_content' => $pattern['content'],
        ], true);

        if (is_wp_error($result)) {
            WP_CLI::warning("Failed #{$page_id}: " . $result->get_error_message());
            continue;
        }

        WP_CLI::success("Seeded #{$page_id} {$post->post_title} ← {$pattern_slug}");
    }
}

uspeh_seed_gutenberg_pages();
