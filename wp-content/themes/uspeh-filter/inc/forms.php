<?php
declare(strict_types=1);

function uspeh_render_quote_form(array $args = []): void {
    $args = wp_parse_args($args, [
        'id_prefix' => 'quote',
        'variant'   => 'full',
        'product'   => '',
        'interest'  => '',
        'submit'    => __('ИЗПРАТИ ЗАПИТВАНЕ', 'uspeh-filter'),
    ]);
    get_template_part('template-parts/quote-form', null, $args);
}

function uspeh_handle_quote_submission(): void {
    $redirect_error = wp_get_referer() ?: uspeh_quote_page_url();

    if (!isset($_POST['uspeh_quote_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['uspeh_quote_nonce'])), 'uspeh_quote')) {
        wp_safe_redirect(add_query_arg('quote', 'invalid', $redirect_error));
        exit;
    }

    $honeypot = sanitize_text_field(wp_unslash($_POST['website'] ?? ''));
    if ('' !== $honeypot) {
        wp_safe_redirect(uspeh_thank_you_url());
        exit;
    }

    $name    = sanitize_text_field(wp_unslash($_POST['your-name'] ?? ''));
    $company = sanitize_text_field(wp_unslash($_POST['your-company'] ?? ''));
    $phone   = sanitize_text_field(wp_unslash($_POST['your-phone'] ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['your-email'] ?? ''));
    $gdpr    = isset($_POST['gdpr']);

    if ('' === $name || '' === $company || '' === $phone || '' === $email || !is_email($email) || !$gdpr) {
        wp_safe_redirect(add_query_arg('quote', 'missing', $redirect_error));
        exit;
    }

    $file_urls = uspeh_handle_quote_uploads();

    $data = [
        'name'         => $name,
        'company'      => $company,
        'phone'        => $phone,
        'email'        => $email,
        'interest'     => sanitize_text_field(wp_unslash($_POST['interest'] ?? '')),
        'filter_type'  => sanitize_text_field(wp_unslash($_POST['filter-type'] ?? '')),
        'product'      => sanitize_text_field(wp_unslash($_POST['product'] ?? '')),
        'size_w'       => sanitize_text_field(wp_unslash($_POST['size-w'] ?? '')),
        'size_h'       => sanitize_text_field(wp_unslash($_POST['size-h'] ?? '')),
        'size_d'       => sanitize_text_field(wp_unslash($_POST['size-d'] ?? '')),
        'quantity'     => sanitize_text_field(wp_unslash($_POST['quantity'] ?? '')),
        'filter_class' => sanitize_text_field(wp_unslash($_POST['filter-class'] ?? '')),
        'application'  => sanitize_text_field(wp_unslash($_POST['application'] ?? '')),
        'message'      => sanitize_textarea_field(wp_unslash($_POST['your-message'] ?? '')),
        'source_page'  => esc_url_raw(wp_unslash($_POST['_source_page'] ?? '')),
        'utm_source'   => sanitize_text_field(wp_unslash($_POST['_utm_source'] ?? '')),
        'utm_medium'   => sanitize_text_field(wp_unslash($_POST['_utm_medium'] ?? '')),
        'utm_campaign' => sanitize_text_field(wp_unslash($_POST['_utm_campaign'] ?? '')),
        'utm_content'  => sanitize_text_field(wp_unslash($_POST['_utm_content'] ?? '')),
        'utm_term'     => sanitize_text_field(wp_unslash($_POST['_utm_term'] ?? '')),
        'landing_page' => esc_url_raw(wp_unslash($_POST['_landing_page'] ?? '')),
        'referrer'     => esc_url_raw(wp_unslash($_POST['_referrer'] ?? '')),
        'files'        => $file_urls,
    ];

    $inquiry_id = uspeh_create_inquiry($data);
    if ($inquiry_id < 1) {
        wp_safe_redirect(add_query_arg('quote', 'error', $redirect_error));
        exit;
    }

    wp_safe_redirect(uspeh_thank_you_url());
    exit;
}
add_action('admin_post_uspeh_quote', 'uspeh_handle_quote_submission');
add_action('admin_post_nopriv_uspeh_quote', 'uspeh_handle_quote_submission');

function uspeh_handle_quote_uploads(): array {
    if (empty($_FILES['file-upload']['name'])) {
        return [];
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';

    $files = $_FILES['file-upload'];
    $names = is_array($files['name']) ? $files['name'] : [$files['name']];
    $urls  = [];
    $allowed = [
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'pdf'  => 'application/pdf',
        'xls'  => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ];

    foreach ($names as $index => $name) {
        if ('' === $name) {
            continue;
        }

        $single = [
            'name'     => is_array($files['name']) ? $files['name'][$index] : $files['name'],
            'type'     => is_array($files['type']) ? $files['type'][$index] : $files['type'],
            'tmp_name' => is_array($files['tmp_name']) ? $files['tmp_name'][$index] : $files['tmp_name'],
            'error'    => is_array($files['error']) ? $files['error'][$index] : $files['error'],
            'size'     => is_array($files['size']) ? $files['size'][$index] : $files['size'],
        ];

        if ((int) $single['error'] !== UPLOAD_ERR_OK) {
            continue;
        }

        if ((int) $single['size'] > 10 * 1024 * 1024) {
            continue;
        }

        $uploaded = wp_handle_upload($single, [
            'test_form' => false,
            'mimes'     => $allowed,
        ]);

        if (!isset($uploaded['error']) && !empty($uploaded['url'])) {
            $urls[] = $uploaded['url'];
        }
    }

    return $urls;
}

function uspeh_render_quote_notice(): void {
    $status = isset($_GET['quote']) ? sanitize_key(wp_unslash($_GET['quote'])) : '';
    if ('' === $status) {
        return;
    }

    $messages = [
        'missing' => __('Моля попълнете задължителните полета: фирма, име, телефон, имейл и съгласие.', 'uspeh-filter'),
        'invalid' => __('Сесията изтече. Моля изпратете формата отново.', 'uspeh-filter'),
        'error'   => __('Възникна грешка при изпращане. Обадете се на търговския отдел.', 'uspeh-filter'),
    ];

    if (!isset($messages[$status])) {
        return;
    }

    printf(
        '<div class="form-notice form-notice--error" role="alert">%s</div>',
        esc_html($messages[$status])
    );
}
