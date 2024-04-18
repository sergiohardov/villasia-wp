<?php if (!defined("ABSPATH")) die;

/* Theme: Scripts */

/**
 * `WP Action`: Enqueue scripts.
 */
function villasia_scripts()
{

    // Libs
    wp_enqueue_script('google-maps', 'https://polyfill.io/v3/polyfill.min.js?features=default', [], false, true);

    // Enqueue scripts
    wp_enqueue_script('mainscript', get_template_directory_uri() . "/assets/js/script.min.js", ['google-maps'], false, true);
    wp_localize_script('mainscript', 'ct_theme', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'siteurl' => home_url()
    ]);
}

add_action('wp_enqueue_scripts', 'villasia_scripts');
