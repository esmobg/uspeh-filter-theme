<?php
declare(strict_types=1);

function uspeh_register_taxonomies(): void {
    register_taxonomy('product_cat', 'product', [
        'labels' => [
            'name'          => __('Продуктови категории', 'uspeh-filter'),
            'singular_name' => __('Категория', 'uspeh-filter'),
            'add_new_item'  => __('Добави категория', 'uspeh-filter'),
            'edit_item'     => __('Редактирай категория', 'uspeh-filter'),
            'search_items'  => __('Търси категории', 'uspeh-filter'),
            'all_items'     => __('Всички категории', 'uspeh-filter'),
        ],
        'hierarchical'  => true,
        'public'        => true,
        'rewrite'       => ['slug' => 'vazdushni-filtri', 'hierarchical' => true, 'with_front' => false],
        'show_in_rest'  => true,
        'show_admin_column' => true,
    ]);

    register_taxonomy('product_tag', 'product', [
        'labels' => [
            'name'          => __('Тагове', 'uspeh-filter'),
            'singular_name' => __('Таг', 'uspeh-filter'),
        ],
        'hierarchical'  => false,
        'public'        => true,
        'rewrite'       => ['slug' => 'product-tag', 'with_front' => false],
        'show_in_rest'  => true,
    ]);

    register_taxonomy('engine_filter_type', 'engine_filter', [
        'labels' => [
            'name'          => __('Тип филтър', 'uspeh-filter'),
            'singular_name' => __('Тип', 'uspeh-filter'),
            'add_new_item'  => __('Добави тип', 'uspeh-filter'),
        ],
        'hierarchical'  => true,
        'public'        => true,
        'rewrite'       => ['slug' => 'dvigatelni-filtri/tip', 'with_front' => false],
        'show_in_rest'  => true,
        'show_admin_column' => true,
    ]);

    register_taxonomy('vehicle_type', 'engine_filter', [
        'labels' => [
            'name'          => __('Тип превозно средство', 'uspeh-filter'),
            'singular_name' => __('Тип ПС', 'uspeh-filter'),
            'add_new_item'  => __('Добави тип ПС', 'uspeh-filter'),
        ],
        'hierarchical'  => true,
        'public'        => true,
        'rewrite'       => ['slug' => 'dvigatelni-filtri/prevozno-sredstvo', 'with_front' => false],
        'show_in_rest'  => true,
        'show_admin_column' => true,
    ]);

    register_taxonomy('vehicle_make', 'engine_filter', [
        'labels' => [
            'name'          => __('Производител (марка)', 'uspeh-filter'),
            'singular_name' => __('Марка', 'uspeh-filter'),
            'add_new_item'  => __('Добави марка', 'uspeh-filter'),
        ],
        'hierarchical'  => false,
        'public'        => true,
        'rewrite'       => ['slug' => 'dvigatelni-filtri/marka', 'with_front' => false],
        'show_in_rest'  => true,
        'show_admin_column' => true,
    ]);

    register_taxonomy('tech_topic', 'tech_article', [
        'labels' => [
            'name'          => __('Теми', 'uspeh-filter'),
            'singular_name' => __('Тема', 'uspeh-filter'),
            'add_new_item'  => __('Добави тема', 'uspeh-filter'),
        ],
        'hierarchical'  => true,
        'public'        => true,
        'rewrite'       => ['slug' => 'technical/tema', 'with_front' => false],
        'show_in_rest'  => true,
    ]);
}
add_action('init', 'uspeh_register_taxonomies');
