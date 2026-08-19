<div class="popup-overlay" id="popup-quote">
    <div class="popup">
        <button class="popup__close" data-popup-close aria-label="<?php esc_attr_e('Затвори', 'uspeh-filter'); ?>">&times;</button>
        <h2 class="popup__title"><?php esc_html_e('Поискайте оферта', 'uspeh-filter'); ?></h2>
        <p class="popup__lead"><?php esc_html_e('Попълнете формата и ще се свържем с Вас.', 'uspeh-filter'); ?></p>
        <?php uspeh_render_quote_form(['id_prefix' => 'popup', 'variant' => 'compact']); ?>
    </div>
</div>
