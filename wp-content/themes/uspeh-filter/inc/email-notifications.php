<?php
declare(strict_types=1);

function uspeh_send_inquiry_notifications(int $post_id, \WP_Post $post, bool $update): void {
    if ($update || 'inquiry' !== $post->post_type) {
        return;
    }

    $name    = get_post_meta($post_id, '_inquiry_name', true);
    $company = get_post_meta($post_id, '_inquiry_company', true);
    $phone   = get_post_meta($post_id, '_inquiry_phone', true);
    $email   = get_post_meta($post_id, '_inquiry_email', true);
    $interest = get_post_meta($post_id, '_inquiry_interest', true);
    $message = get_post_meta($post_id, '_inquiry_message', true);
    $product = get_post_meta($post_id, '_inquiry_product', true);
    $size_w  = get_post_meta($post_id, '_inquiry_size_w', true);
    $size_h  = get_post_meta($post_id, '_inquiry_size_h', true);
    $size_d  = get_post_meta($post_id, '_inquiry_size_d', true);
    $qty     = get_post_meta($post_id, '_inquiry_quantity', true);
    $source  = get_post_meta($post_id, '_inquiry_source_page', true);
    $utm_src = get_post_meta($post_id, '_inquiry_utm_source', true);
    $utm_campaign = get_post_meta($post_id, '_inquiry_utm_campaign', true);

    $admin_email = get_option('uspeh_sales_email', get_option('admin_email'));

    $admin_body = sprintf(
        "Ново запитване от сайта\n\n" .
        "Име: %s\nФирма: %s\nТелефон: %s\nEmail: %s\n" .
        "Интерес: %s\nПродукт: %s\n" .
        "Размер: %s × %s × %s\nКоличество: %s\n\n" .
        "Съобщение:\n%s\n\n" .
        "Страница: %s\nКампания: %s / %s\n\n" .
        "Вижте в админа: %s",
        $name, $company, $phone, $email,
        $interest, $product,
        $size_w, $size_h, $size_d, $qty,
        $message,
        $source, $utm_src, $utm_campaign,
        admin_url('post.php?post=' . $post_id . '&action=edit')
    );

    wp_mail(
        $admin_email,
        sprintf('[Успех Филтър] Ново запитване от %s', $company ?: $name),
        $admin_body,
        ['Content-Type: text/plain; charset=UTF-8']
    );

    if ($email) {
        $client_body = sprintf(
            "Здравейте, %s,\n\n" .
            "Получихме Вашето запитване до Успех Филтър ССБ.\n" .
            "Представител на компанията ще се свърже с Вас възможно най-скоро.\n\n" .
            "За спешни въпроси:\n" .
            "Телефон: 02 926 88 33\n" .
            "Email: info@uspehfilter.com\n\n" .
            "С уважение,\n" .
            "Екипът на Успех Филтър ССБ",
            $name
        );

        wp_mail(
            $email,
            __('Получихме Вашето запитване — Успех Филтър ССБ', 'uspeh-filter'),
            $client_body,
            [
                'Content-Type: text/plain; charset=UTF-8',
                'From: Успех Филтър ССБ <info@uspehfilter.com>',
            ]
        );
    }
}
add_action('wp_insert_post', 'uspeh_send_inquiry_notifications', 10, 3);
