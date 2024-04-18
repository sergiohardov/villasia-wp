<?php if (!defined("ABSPATH")) die;

/* Theme: Menus */

/**
 * `WP Action`: Register nav menus.
 */
function villasia_register_menus()
{
    register_nav_menus([
        'header'            => __('Header', CTTHEME_LANG_TEXT),
        'footer-1'          => __('Footer 1', CTTHEME_LANG_TEXT),
        'footer-2'          => __('Footer 2', CTTHEME_LANG_TEXT),
        'footer-3'          => __('Footer 3', CTTHEME_LANG_TEXT),
        'footer-contact'    => __('Footer Contact', CTTHEME_LANG_TEXT),
        'footer-policy'     => __('Footer Policy', CTTHEME_LANG_TEXT),
        'social'            => __('Social', CTTHEME_LANG_TEXT),
        'popular-search'    => __('Popular Searches', CTTHEME_LANG_TEXT),
        'holiday-themes'    => __('Holiday Themes', CTTHEME_LANG_TEXT),
    ]);
}

add_action('after_setup_theme', 'villasia_register_menus');


// Icons for contact menu
add_filter('walker_nav_menu_start_el', function ($output, $item, $depth, $args) {

    if ($args->menu->slug === 'contact') {
        $icon = get_field('icon', $item);

        if ($icon) {
            $output = wp_get_attachment_image($icon, 'full') . $output;
        }
    }

    return $output;
}, 10, 4);

// Icons for social menu
add_filter('nav_menu_item_title', function ($title, $menu_item, $args, $depth) {

    if ($args->menu->slug === 'social') {
        $icon = get_field('icon', $menu_item);

        $title = wp_get_attachment_image($icon, 'full');
    }

    return $title;
}, 10, 4);
