<?php
declare(strict_types=1);

function uspeh_register_product_cpt(): void {
    register_post_type('product', [
        'labels' => [
            'name'               => __('Продукти', 'uspeh-filter'),
            'singular_name'      => __('Продукт', 'uspeh-filter'),
            'add_new'            => __('Добави продукт', 'uspeh-filter'),
            'add_new_item'       => __('Добави нов продукт', 'uspeh-filter'),
            'edit_item'          => __('Редактирай продукт', 'uspeh-filter'),
            'view_item'          => __('Виж продукт', 'uspeh-filter'),
            'search_items'       => __('Търси продукти', 'uspeh-filter'),
            'not_found'          => __('Няма намерени продукти', 'uspeh-filter'),
            'not_found_in_trash' => __('Няма продукти в кошчето', 'uspeh-filter'),
            'all_items'          => __('Всички продукти', 'uspeh-filter'),
        ],
        'public'             => true,
        'has_archive'        => 'vazdushni-filtri',
        'rewrite'            => ['slug' => 'products', 'with_front' => false],
        'menu_icon'          => 'dashicons-filter',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
        'show_in_rest'       => true,
        'menu_position'      => 5,
    ]);

    register_post_type('engine_filter', [
        'labels' => [
            'name'               => __('Двигателни филтри', 'uspeh-filter'),
            'singular_name'      => __('Двигателен филтър', 'uspeh-filter'),
            'add_new'            => __('Добави филтър', 'uspeh-filter'),
            'add_new_item'       => __('Добави двигателен филтър', 'uspeh-filter'),
            'edit_item'          => __('Редактирай двигателен филтър', 'uspeh-filter'),
            'view_item'          => __('Виж двигателен филтър', 'uspeh-filter'),
            'search_items'       => __('Търси двигателни филтри', 'uspeh-filter'),
            'not_found'          => __('Няма намерени двигателни филтри', 'uspeh-filter'),
            'all_items'          => __('Всички двигателни филтри', 'uspeh-filter'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'dvigatelni-filtri', 'with_front' => false],
        'menu_icon'          => 'dashicons-car',
        'supports'           => ['title', 'editor', 'thumbnail', 'revisions'],
        'show_in_rest'       => true,
        'menu_position'      => 6,
    ]);

    register_post_type('application', [
        'labels' => [
            'name'               => __('Приложения', 'uspeh-filter'),
            'singular_name'      => __('Приложение', 'uspeh-filter'),
            'add_new'            => __('Добави приложение', 'uspeh-filter'),
            'add_new_item'       => __('Добави ново приложение', 'uspeh-filter'),
            'edit_item'          => __('Редактирай приложение', 'uspeh-filter'),
            'view_item'          => __('Виж приложение', 'uspeh-filter'),
            'all_items'          => __('Всички приложения', 'uspeh-filter'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'prilozhenia', 'with_front' => false],
        'menu_icon'          => 'dashicons-building',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
        'show_in_rest'       => true,
        'menu_position'      => 7,
    ]);

    register_post_type('tech_article', [
        'labels' => [
            'name'               => __('Технически център', 'uspeh-filter'),
            'singular_name'      => __('Техническа статия', 'uspeh-filter'),
            'add_new'            => __('Добави статия', 'uspeh-filter'),
            'add_new_item'       => __('Добави техническа статия', 'uspeh-filter'),
            'edit_item'          => __('Редактирай статия', 'uspeh-filter'),
            'view_item'          => __('Виж статия', 'uspeh-filter'),
            'all_items'          => __('Всички статии', 'uspeh-filter'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'technical', 'with_front' => false],
        'menu_icon'          => 'dashicons-book-alt',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
        'show_in_rest'       => true,
        'menu_position'      => 8,
    ]);
}
add_action('init', 'uspeh_register_product_cpt');
