<?php if (!defined("ABSPATH")) die;

/* Theme: Sidebars */

/**
 * `WP Action`: Register sidebars.
 */
function villasia_widgets_init()
{
    register_sidebar([
        'name'          => __('Sidebar', CTTHEME_LANG_TEXT),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', CTTHEME_LANG_TEXT),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);
}

add_action('widgets_init', 'villasia_widgets_init');
