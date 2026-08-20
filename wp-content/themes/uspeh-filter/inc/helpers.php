<?php
declare(strict_types=1);

function uspeh_get_breadcrumbs(): array {
    $crumbs = [];
    $crumbs[] = ['name' => __('Начало', 'uspeh-filter'), 'url' => home_url('/')];

    if (is_singular('product')) {
        $terms = get_the_terms(get_the_ID(), 'product_cat');
        if ($terms && !is_wp_error($terms)) {
            $term = $terms[0];
            if ($term->parent) {
                $parent = get_term($term->parent, 'product_cat');
                $crumbs[] = ['name' => $parent->name, 'url' => get_term_link($parent)];
            }
            $crumbs[] = ['name' => $term->name, 'url' => get_term_link($term)];
        }
        $crumbs[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_singular('engine_filter')) {
        $crumbs[] = ['name' => __('Двигателни филтри', 'uspeh-filter'), 'url' => get_post_type_archive_link('engine_filter')];
        $crumbs[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_tax('product_cat')) {
        $term = get_queried_object();
        if ($term->parent) {
            $parent = get_term($term->parent, 'product_cat');
            $crumbs[] = ['name' => $parent->name, 'url' => get_term_link($parent)];
        }
        $crumbs[] = ['name' => $term->name, 'url' => get_term_link($term)];
    } elseif (is_post_type_archive('product')) {
        $crumbs[] = ['name' => __('Продукти', 'uspeh-filter'), 'url' => get_post_type_archive_link('product')];
    } elseif (is_post_type_archive('engine_filter')) {
        $crumbs[] = ['name' => __('Двигателни филтри', 'uspeh-filter'), 'url' => get_post_type_archive_link('engine_filter')];
    } elseif (is_singular()) {
        $crumbs[] = ['name' => get_the_title(), 'url' => get_permalink()];
    } elseif (is_archive()) {
        $crumbs[] = ['name' => get_the_archive_title(), 'url' => ''];
    }

    return $crumbs;
}

function uspeh_render_breadcrumbs(): void {
    if (is_front_page()) {
        return;
    }
    $crumbs = uspeh_get_breadcrumbs();
    if (count($crumbs) < 2) {
        return;
    }
    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__('Навигация', 'uspeh-filter') . '">';
    echo '<div class="container">';
    $last = count($crumbs) - 1;
    foreach ($crumbs as $i => $crumb) {
        if ($i === $last) {
            echo '<span class="breadcrumbs__current" aria-current="page">' . esc_html($crumb['name']) . '</span>';
        } else {
            echo '<a href="' . esc_url($crumb['url']) . '" class="breadcrumbs__link">' . esc_html($crumb['name']) . '</a>';
            echo '<span class="breadcrumbs__sep" aria-hidden="true"> / </span>';
        }
    }
    echo '</div>';
    echo '</nav>';
}

function uspeh_get_phone(string $type = 'sales'): string {
    $phones = [
        'manager' => '+359 886 100 095',
        'sales'   => '+359 2 926 88 33',
        'sales2'  => '+359 877 899 285',
    ];
    return $phones[$type] ?? $phones['sales'];
}

function uspeh_phone_link(string $phone): string {
    return 'tel:' . preg_replace('/[^+\d]/', '', $phone);
}

function uspeh_get_email(): string {
    return 'info@uspehfilter.com';
}

function uspeh_get_address(): string {
    return __('гр. София, бул. Европа 138, ПК 1360', 'uspeh-filter');
}

function uspeh_theme_image(string $filename): string {
    $path = USPEH_DIR . '/assets/images/' . $filename;
    if (is_readable($path)) {
        return USPEH_URI . '/assets/images/' . $filename;
    }
    return '';
}

function uspeh_application_url(string $slug): string {
    $post = get_page_by_path($slug, OBJECT, 'application');
    if ($post instanceof WP_Post) {
        return get_permalink($post);
    }

    return home_url('/prilozhenia/' . $slug . '/');
}

/**
 * Render optional Gutenberg blocks below the themed template layout.
 * Does not replace PHP sections — only outputs extra editable content.
 */
function uspeh_render_gutenberg_page_content(bool $wrap_in_section = true): bool {
    if (!is_singular('page')) {
        return false;
    }

    $post = get_queried_object();
    if (!$post instanceof WP_Post) {
        return false;
    }

    $content = (string) $post->post_content;
    if ($content === '' || !has_blocks($content)) {
        return false;
    }

    if ($wrap_in_section) {
        echo '<section class="section page-blocks"><div class="container entry-content">';
    }

    echo apply_filters('the_content', $content);

    if ($wrap_in_section) {
        echo '</div></section>';
    }

    return true;
}

function uspeh_quote_page_url(): string {
    return home_url('/poiskaj-oferta/');
}

function uspeh_thank_you_url(): string {
    return home_url('/blagodaria/');
}

function uspeh_get_primary_navigation(): array {
    $engine_archive = get_post_type_archive_link('engine_filter');

    return [
        [
            'title' => __('Начало', 'uspeh-filter'),
            'url'   => home_url('/'),
        ],
        [
            'title'    => __('Продукти и услуги', 'uspeh-filter'),
            'url'      => home_url('/vazdushni-filtri/'),
            'children' => [
                [
                    'title' => __('Предфилтри', 'uspeh-filter'),
                    'url'   => home_url('/vazdushni-filtri/predfiltri/'),
                ],
                [
                    'title' => __('Фини филтри', 'uspeh-filter'),
                    'url'   => home_url('/vazdushni-filtri/fini-filtri/'),
                ],
                [
                    'title' => __('EPA, HEPA, ULPA', 'uspeh-filter'),
                    'url'   => home_url('/hepa-filtri/'),
                ],
                [
                    'title' => __('Карбонови филтри', 'uspeh-filter'),
                    'url'   => home_url('/vazdushni-filtri/karbonovi/'),
                ],
                [
                    'title' => __('Индивидуално производство', 'uspeh-filter'),
                    'url'   => home_url('/individualno-proizvodstvo/'),
                ],
            ],
        ],
        [
            'title' => __('HEPA филтри', 'uspeh-filter'),
            'url'   => home_url('/hepa-filtri/'),
        ],
        [
            'title' => __('Двигателни филтри', 'uspeh-filter'),
            'url'   => $engine_archive ?: home_url('/dvigatelni-filtri/'),
        ],
        [
            'title'    => __('Компания', 'uspeh-filter'),
            'url'      => home_url('/za-nas/'),
            'children' => [
                [
                    'title' => __('За нас', 'uspeh-filter'),
                    'url'   => home_url('/za-nas/'),
                ],
                [
                    'title' => __('Производство', 'uspeh-filter'),
                    'url'   => home_url('/proizvodstvo/'),
                ],
                [
                    'title' => __('Качество', 'uspeh-filter'),
                    'url'   => home_url('/kachestvo/'),
                ],
                [
                    'title' => __('Поискай оферта', 'uspeh-filter'),
                    'url'   => uspeh_quote_page_url(),
                ],
            ],
        ],
        [
            'title' => __('Контакти', 'uspeh-filter'),
            'url'   => home_url('/kontakti/'),
        ],
    ];
}

function uspeh_is_current_url(string $url): bool {
    $request_uri  = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '/';
    $current_path = untrailingslashit((string) wp_parse_url(home_url($request_uri), PHP_URL_PATH));
    $item_path    = untrailingslashit((string) wp_parse_url($url, PHP_URL_PATH));

    if ('' === $current_path) {
        $current_path = '/';
    }

    if ('' === $item_path) {
        $item_path = '/';
    }

    return $current_path === $item_path;
}

function uspeh_nav_item_is_active(array $item): bool {
    if (!empty($item['url']) && uspeh_is_current_url((string) $item['url'])) {
        return true;
    }

    if (!empty($item['children']) && is_array($item['children'])) {
        foreach ($item['children'] as $child) {
            if (is_array($child) && uspeh_nav_item_is_active($child)) {
                return true;
            }
        }
    }

    return false;
}

function uspeh_render_primary_navigation(): void {
    $items = uspeh_get_primary_navigation();

    echo '<ul class="site-nav__list">';

    foreach ($items as $index => $item) {
        $has_children = !empty($item['children']) && is_array($item['children']);
        $is_active    = uspeh_nav_item_is_active($item);
        $item_classes = ['site-nav__item'];

        if ($has_children) {
            $item_classes[] = 'menu-item-has-children';
        }

        if ($is_active) {
            $item_classes[] = 'is-current';
        }

        echo '<li class="' . esc_attr(implode(' ', $item_classes)) . '">';
        echo '<a href="' . esc_url((string) $item['url']) . '" class="site-nav__link">' . esc_html((string) $item['title']) . '</a>';

        if ($has_children) {
            $submenu_id = 'site-submenu-' . $index;
            echo '<button type="button" class="site-nav__toggle" aria-expanded="false" aria-controls="' . esc_attr($submenu_id) . '">';
            echo '<span class="screen-reader-text">' . esc_html(sprintf(__('Отвори подменю за %s', 'uspeh-filter'), (string) $item['title'])) . '</span>';
            echo '</button>';
            echo '<ul class="sub-menu" id="' . esc_attr($submenu_id) . '">';

            foreach ($item['children'] as $child) {
                if (!is_array($child)) {
                    continue;
                }

                $child_classes = ['site-nav__sub-item'];
                if (uspeh_nav_item_is_active($child)) {
                    $child_classes[] = 'is-current';
                }

                echo '<li class="' . esc_attr(implode(' ', $child_classes)) . '">';
                echo '<a href="' . esc_url((string) $child['url']) . '">' . esc_html((string) $child['title']) . '</a>';
                echo '</li>';
            }

            echo '</ul>';
        }

        echo '</li>';
    }

    echo '</ul>';
}
