<?php if (!defined("ABSPATH")) die;

/* Theme: Styles */

/**
 * `WP Action`: Enqueue front styles.
 */
add_action('wp_enqueue_scripts', function () {
    /* Enqueue styles */
    wp_enqueue_style('mainstyle', get_template_directory_uri() . "/assets/css/style.min.css");
});

/**
 * `WP Action`: Enqueue admin styles.
 */
add_action('admin_enqueue_scripts', function () {
    /* Enqueue styles */
    // wp_enqueue_style('adminstyle', get_template_directory_uri() . '/assets/css/adminstyle.min.css');
});
