<?php
declare(strict_types=1);

$prefix   = $args['id_prefix'] ?? 'quote';
$variant  = $args['variant'] ?? 'full';
$product  = $args['product'] ?? '';
$interest = $args['interest'] ?? '';
$submit   = $args['submit'] ?? __('ИЗПРАТИ ЗАПИТВАНЕ', 'uspeh-filter');
$is_full  = 'full' === $variant;
?>

<form class="quote-form quote-form--<?php echo esc_attr($variant); ?>" method="post" enctype="multipart/form-data" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <input type="hidden" name="action" value="uspeh_quote">
    <?php wp_nonce_field('uspeh_quote', 'uspeh_quote_nonce'); ?>
    <div class="form-honeypot" aria-hidden="true" hidden>
        <label for="<?php echo esc_attr($prefix); ?>-website"><?php esc_html_e('Уебсайт', 'uspeh-filter'); ?></label>
        <input type="text" id="<?php echo esc_attr($prefix); ?>-website" name="website" tabindex="-1" autocomplete="off">
    </div>

    <?php if ($is_full) : ?>
    <div class="form-group">
        <label for="<?php echo esc_attr($prefix); ?>-interest"><?php esc_html_e('Интересувам се от', 'uspeh-filter'); ?></label>
        <select id="<?php echo esc_attr($prefix); ?>-interest" name="interest">
            <option value=""><?php esc_html_e('Изберете...', 'uspeh-filter'); ?></option>
            <?php
            $interests = [
                'ventilacionen'     => __('Вентилационен филтър', 'uspeh-filter'),
                'hepa'              => 'HEPA',
                'predfiltar'        => __('Предфилтър', 'uspeh-filter'),
                'fin'               => __('Фин филтър', 'uspeh-filter'),
                'karbonov'          => __('Карбонов филтър', 'uspeh-filter'),
                'dvigatelen'        => __('Двигателен филтър', 'uspeh-filter'),
                'filtarna-materia'  => __('Филтърна материя', 'uspeh-filter'),
                'prahova-kamera'    => __('Филтър за прахова камера', 'uspeh-filter'),
                'individualno'      => __('Индивидуално производство', 'uspeh-filter'),
                'drugo'             => __('Друго', 'uspeh-filter'),
            ];
            foreach ($interests as $value => $label) :
                ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($interest, $value); ?>><?php echo esc_html($label); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="<?php echo esc_attr($prefix); ?>-type"><?php esc_html_e('Тип на филтъра', 'uspeh-filter'); ?></label>
        <select id="<?php echo esc_attr($prefix); ?>-type" name="filter-type">
            <option value="ne-znam"><?php esc_html_e('Не знам', 'uspeh-filter'); ?></option>
            <option value="panelen"><?php esc_html_e('Панелен', 'uspeh-filter'); ?></option>
            <option value="dzhoben"><?php esc_html_e('Джобен', 'uspeh-filter'); ?></option>
            <option value="hepa">HEPA</option>
            <option value="karbonov"><?php esc_html_e('Карбонов', 'uspeh-filter'); ?></option>
            <option value="dvigatelen"><?php esc_html_e('Двигателен', 'uspeh-filter'); ?></option>
            <option value="industrialen"><?php esc_html_e('Индустриален', 'uspeh-filter'); ?></option>
            <option value="drug"><?php esc_html_e('Друг', 'uspeh-filter'); ?></option>
        </select>
    </div>
    <?php endif; ?>

    <div class="form-group">
        <p class="form-group__label" id="dims-label-<?php echo esc_attr($prefix); ?>"><?php esc_html_e('Размери (mm)', 'uspeh-filter'); ?></p>
        <div class="quote-form__dims" role="group" aria-labelledby="dims-label-<?php echo esc_attr($prefix); ?>">
            <input type="text" name="size-w" inputmode="numeric" placeholder="<?php esc_attr_e('Ширина', 'uspeh-filter'); ?>" aria-label="<?php esc_attr_e('Ширина', 'uspeh-filter'); ?>">
            <span class="quote-form__dims-sep" aria-hidden="true">&times;</span>
            <input type="text" name="size-h" inputmode="numeric" placeholder="<?php esc_attr_e('Височина', 'uspeh-filter'); ?>" aria-label="<?php esc_attr_e('Височина', 'uspeh-filter'); ?>">
            <span class="quote-form__dims-sep" aria-hidden="true">&times;</span>
            <input type="text" name="size-d" inputmode="numeric" placeholder="<?php esc_attr_e('Дебелина', 'uspeh-filter'); ?>" aria-label="<?php esc_attr_e('Дебелина', 'uspeh-filter'); ?>">
        </div>
    </div>

    <?php if ($is_full) : ?>
    <div class="form-row">
        <div class="form-group">
            <label for="<?php echo esc_attr($prefix); ?>-qty"><?php esc_html_e('Количество', 'uspeh-filter'); ?></label>
            <input type="text" id="<?php echo esc_attr($prefix); ?>-qty" name="quantity" inputmode="numeric">
        </div>
        <div class="form-group">
            <label for="<?php echo esc_attr($prefix); ?>-class"><?php esc_html_e('Клас на филтрация', 'uspeh-filter'); ?></label>
            <input type="text" id="<?php echo esc_attr($prefix); ?>-class" name="filter-class" placeholder="G4, F7, H13...">
        </div>
    </div>

    <div class="form-group">
        <label for="<?php echo esc_attr($prefix); ?>-app"><?php esc_html_e('Приложение', 'uspeh-filter'); ?></label>
        <input type="text" id="<?php echo esc_attr($prefix); ?>-app" name="application" placeholder="<?php esc_attr_e('Климатична камера, чисто помещение...', 'uspeh-filter'); ?>">
    </div>
    <?php endif; ?>

    <div class="form-row">
        <div class="form-group">
            <label for="<?php echo esc_attr($prefix); ?>-company"><?php esc_html_e('Фирма', 'uspeh-filter'); ?> *</label>
            <input type="text" id="<?php echo esc_attr($prefix); ?>-company" name="your-company" required>
        </div>
        <div class="form-group">
            <label for="<?php echo esc_attr($prefix); ?>-name"><?php esc_html_e('Име', 'uspeh-filter'); ?> *</label>
            <input type="text" id="<?php echo esc_attr($prefix); ?>-name" name="your-name" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="<?php echo esc_attr($prefix); ?>-phone"><?php esc_html_e('Телефон', 'uspeh-filter'); ?> *</label>
            <input type="tel" id="<?php echo esc_attr($prefix); ?>-phone" name="your-phone" required>
        </div>
        <div class="form-group">
            <label for="<?php echo esc_attr($prefix); ?>-email"><?php esc_html_e('Имейл', 'uspeh-filter'); ?> *</label>
            <input type="email" id="<?php echo esc_attr($prefix); ?>-email" name="your-email" required>
        </div>
    </div>

    <div class="form-group">
        <label for="<?php echo esc_attr($prefix); ?>-message"><?php esc_html_e('Съобщение', 'uspeh-filter'); ?></label>
        <textarea id="<?php echo esc_attr($prefix); ?>-message" name="your-message" rows="<?php echo $is_full ? '4' : '3'; ?>"></textarea>
    </div>

    <div class="form-group">
        <div class="file-upload">
            <input type="file" id="<?php echo esc_attr($prefix); ?>-file" name="file-upload<?php echo 'full' === $variant ? '[]' : ''; ?>" accept=".jpg,.jpeg,.png,.pdf,.xls,.xlsx" <?php echo $is_full ? 'multiple' : ''; ?> aria-label="<?php esc_attr_e('Качете файл', 'uspeh-filter'); ?>">
            <p class="file-upload__text"><?php esc_html_e('Качете снимка, чертеж или спецификация (JPG, PNG, PDF, XLS)', 'uspeh-filter'); ?></p>
            <div class="file-upload__preview"></div>
        </div>
    </div>

    <div class="form-group">
        <label class="form-checkbox">
            <input type="checkbox" name="gdpr" required>
            <?php esc_html_e('Съгласен/а съм предоставените данни да бъдат използвани за обработка на моето запитване.', 'uspeh-filter'); ?>
        </label>
    </div>

    <input type="hidden" name="product" value="<?php echo esc_attr($product); ?>">
    <?php uspeh_render_utm_hidden_fields(); ?>

    <button type="submit" class="btn btn--accent btn--large btn--block"><?php echo esc_html($submit); ?></button>
</form>
