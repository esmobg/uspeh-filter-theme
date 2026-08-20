<?php
declare(strict_types=1);

/**
 * Customizer: контроли за изображенията на PHP fallback секциите.
 * Ключовете съответстват на съществуващите get_theme_mod() четения в темплейтите.
 */
function uspeh_customize_register(WP_Customize_Manager $wp_customize): void {
    $wp_customize->add_section('uspeh_section_images', [
        'title'       => __('Изображения на секциите', 'uspeh-filter'),
        'description' => __('Изображения за секциите на началната страница и вътрешните страници (важат, когато страницата не използва Gutenberg блокове).', 'uspeh-filter'),
        'priority'    => 30,
    ]);

    $images = [
        'hero_image'              => __('Начало — Hero изображение', 'uspeh-filter'),
        'direction_hvac_img'      => __('Направление: Предфилтри / HVAC', 'uspeh-filter'),
        'direction_fine_img'      => __('Направление: Фина филтрация', 'uspeh-filter'),
        'direction_hepa_img'      => __('Направление: EPA / HEPA / ULPA', 'uspeh-filter'),
        'direction_industrial_img' => __('Направление: Карбонови / специални', 'uspeh-filter'),
        'catalog_banner_img'      => __('Начало — Каталожен банер', 'uspeh-filter'),
        'production_showcase_img' => __('Начало — Производство', 'uspeh-filter'),
        'hepa_highlight_img'      => __('Начало — HEPA секция', 'uspeh-filter'),
        'engine_teaser_img'       => __('Начало — Двигателни филтри', 'uspeh-filter'),
        'quality_section_img'     => __('Страница „Качество" — изображение', 'uspeh-filter'),
        'production_hero_img'     => __('Страница „Производство" — изображение', 'uspeh-filter'),
        'custom_prod_hero'        => __('Индивидуално производство — изображение', 'uspeh-filter'),
    ];

    foreach ($images as $key => $label) {
        $wp_customize->add_setting($key, [
            'default'           => '',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'esc_url_raw',
        ]);

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $key, [
            'label'   => $label,
            'section' => 'uspeh_section_images',
        ]));
    }
}
add_action('customize_register', 'uspeh_customize_register');
