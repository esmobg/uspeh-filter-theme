<?php
declare(strict_types=1);

function uspeh_output_schema(): void {
    $schemas = [];

    $schemas[] = [
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        'name'     => 'Успех Филтър ССБ',
        'url'      => home_url('/'),
        'logo'     => USPEH_URI . '/assets/images/logo.png',
        'address'  => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'бул. Европа 138',
            'addressLocality' => 'София',
            'postalCode'      => '1360',
            'addressCountry'  => 'BG',
        ],
        'telephone'   => '+359 2 926 88 33',
        'email'       => 'info@uspehfilter.com',
        'foundingDate' => '1982',
        'description' => 'Български производител на професионални филтри за вентилация, климатизация, HEPA, двигатели и индустриални приложения.',
    ];

    if (is_front_page()) {
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type'    => 'LocalBusiness',
            'name'     => 'Успех Филтър ССБ',
            'address'  => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => 'бул. Европа 138',
                'addressLocality' => 'София',
                'postalCode'      => '1360',
                'addressCountry'  => 'BG',
            ],
            'telephone' => '+359 2 926 88 33',
            'openingHours' => 'Mo-Fr 08:00-17:00',
        ];
    }

    if (is_singular('product')) {
        $post_id = get_the_ID();
        $specs   = get_post_meta($post_id, '_specs', true) ?: [];
        $schema  = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Product',
            'name'        => get_the_title(),
            'description' => get_the_excerpt(),
            'url'         => get_permalink(),
            'manufacturer' => [
                '@type' => 'Organization',
                'name'  => 'Успех Филтър ССБ',
            ],
        ];
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url($post_id, 'product-gallery');
        }
        $schemas[] = $schema;

        $faqs = get_post_meta($post_id, '_faq', true) ?: [];
        if (!empty($faqs)) {
            $faq_schema = [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => [],
            ];
            foreach ($faqs as $faq) {
                $faq_schema['mainEntity'][] = [
                    '@type' => 'Question',
                    'name'  => $faq['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => $faq['a'],
                    ],
                ];
            }
            $schemas[] = $faq_schema;
        }
    }

    $breadcrumbs = uspeh_get_breadcrumbs();
    if (!empty($breadcrumbs)) {
        $bc_schema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [],
        ];
        foreach ($breadcrumbs as $i => $crumb) {
            $bc_schema['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $crumb['name'],
                'item'     => $crumb['url'],
            ];
        }
        $schemas[] = $bc_schema;
    }

    foreach ($schemas as $schema) {
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
}
add_action('wp_head', 'uspeh_output_schema', 5);
