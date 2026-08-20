<?php
declare(strict_types=1);

/**
 * Nav walker, възпроизвеждащ markup-а на uspeh_render_primary_navigation(),
 * така че съществуващите CSS правила и main.js (submenu toggle) работят
 * без промяна и когато е закачено меню от wp-admin.
 */
class Uspeh_Nav_Walker extends Walker_Nav_Menu {

    private int $current_parent_id = 0;

    public function start_lvl(&$output, $depth = 0, $args = null) {
        $submenu_id = 'site-submenu-' . $this->current_parent_id;
        $output    .= '<ul class="sub-menu" id="' . esc_attr($submenu_id) . '">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes      = is_array($item->classes) ? $item->classes : [];
        $has_children = in_array('menu-item-has-children', $classes, true);
        $is_current   = (bool) array_intersect($classes, [
            'current-menu-item',
            'current-menu-parent',
            'current-menu-ancestor',
            'current_page_item',
            'current_page_parent',
            'current_page_ancestor',
        ]);

        $item_classes = [$depth === 0 ? 'site-nav__item' : 'site-nav__sub-item'];
        if ($has_children && $depth === 0) {
            $item_classes[] = 'menu-item-has-children';
        }
        if ($is_current) {
            $item_classes[] = 'is-current';
        }

        $output .= '<li class="' . esc_attr(implode(' ', $item_classes)) . '">';

        $link_class = $depth === 0 ? ' class="site-nav__link"' : '';
        $url        = !empty($item->url) ? $item->url : '#';
        $output    .= '<a href="' . esc_url($url) . '"' . $link_class . '>' . esc_html($item->title) . '</a>';

        if ($has_children && $depth === 0) {
            $this->current_parent_id = (int) $item->ID;
            $submenu_id              = 'site-submenu-' . $this->current_parent_id;
            $output                 .= '<button type="button" class="site-nav__toggle" aria-expanded="false" aria-controls="' . esc_attr($submenu_id) . '">';
            $output                 .= '<span class="screen-reader-text">' . esc_html(sprintf(__('Отвори подменю за %s', 'uspeh-filter'), (string) $item->title)) . '</span>';
            $output                 .= '</button>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }
}

/**
 * Плосък walker за правните линкове във футъра — само <a> елементи,
 * както очаква flex стилът на .site-footer__legal.
 */
class Uspeh_Footer_Legal_Walker extends Walker_Nav_Menu {

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $url     = !empty($item->url) ? $item->url : '#';
        $output .= '<a href="' . esc_url($url) . '">' . esc_html($item->title) . '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {}
}
