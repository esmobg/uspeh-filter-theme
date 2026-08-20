<?php
declare(strict_types=1);

/**
 * Block styles — варианти на core блокове, съответстващи на дизайн системата.
 * Стиловете живеят в assets/css/main.css (фронтенд) и assets/css/editor.css (редактор).
 */

function uspeh_register_block_styles(): void {
    register_block_style('core/button', [
        'name'  => 'cta',
        'label' => __('CTA (червен градиент)', 'uspeh-filter'),
    ]);

    register_block_style('core/group', [
        'name'  => 'section-alt',
        'label' => __('Секция — сива', 'uspeh-filter'),
    ]);

    register_block_style('core/group', [
        'name'  => 'section-dark',
        'label' => __('Секция — тъмна', 'uspeh-filter'),
    ]);
}
add_action('init', 'uspeh_register_block_styles');
