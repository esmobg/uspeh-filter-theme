<form class="engine-search" id="engine-search-form">
    <div class="engine-search__row">
        <div class="engine-search__field engine-search__field--wide">
            <label for="engine-search-text"><?php esc_html_e('OEM / каталожен номер', 'uspeh-filter'); ?></label>
            <input type="text" id="engine-search-text" name="search" placeholder="<?php esc_attr_e('Въведете номер...', 'uspeh-filter'); ?>">
        </div>
        <div class="engine-search__field">
            <label for="engine-filter-type"><?php esc_html_e('Тип филтър', 'uspeh-filter'); ?></label>
            <select id="engine-filter-type" name="filter_type">
                <option value=""><?php esc_html_e('Всички', 'uspeh-filter'); ?></option>
                <?php
                $types = get_terms(['taxonomy' => 'engine_filter_type', 'hide_empty' => false]);
                if ($types && !is_wp_error($types)) :
                    foreach ($types as $type) :
                ?>
                    <option value="<?php echo esc_attr($type->slug); ?>"><?php echo esc_html($type->name); ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>
        <div class="engine-search__field">
            <label for="engine-vehicle-type"><?php esc_html_e('Тип ПС', 'uspeh-filter'); ?></label>
            <select id="engine-vehicle-type" name="vehicle_type">
                <option value=""><?php esc_html_e('Всички', 'uspeh-filter'); ?></option>
                <?php
                $vtypes = get_terms(['taxonomy' => 'vehicle_type', 'hide_empty' => false]);
                if ($vtypes && !is_wp_error($vtypes)) :
                    foreach ($vtypes as $vt) :
                ?>
                    <option value="<?php echo esc_attr($vt->slug); ?>"><?php echo esc_html($vt->name); ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>
        <div class="engine-search__field">
            <label for="engine-vehicle-make"><?php esc_html_e('Производител', 'uspeh-filter'); ?></label>
            <select id="engine-vehicle-make" name="vehicle_make" data-placeholder="<?php esc_attr_e('Всички', 'uspeh-filter'); ?>">
                <option value=""><?php esc_html_e('Всички', 'uspeh-filter'); ?></option>
                <?php
                $makes = get_terms(['taxonomy' => 'vehicle_make', 'hide_empty' => false, 'orderby' => 'name']);
                if ($makes && !is_wp_error($makes)) :
                    foreach ($makes as $mk) :
                ?>
                    <option value="<?php echo esc_attr($mk->slug); ?>"><?php echo esc_html($mk->name); ?></option>
                <?php endforeach; endif; ?>
            </select>
        </div>
    </div>
    <div class="engine-search__actions">
        <button type="submit" class="btn btn--accent"><?php esc_html_e('ТЪРСИ', 'uspeh-filter'); ?></button>
        <span id="engine-search-count" class="engine-search__count"></span>
    </div>
</form>

