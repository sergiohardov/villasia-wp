<?php if (!defined("ABSPATH")) die;

/* Theme: Setup */

/**
 * `WP Action`: Base theme settings
 */
function villasia_setup()
{

    load_theme_textdomain(CTTHEME_LANG_TEXT, get_template_directory() . '/languages');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );
    add_theme_support(
        'custom-background',
        apply_filters(
            'theme_villasia_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'villasia_setup');

/**
 * `WP Action`: Setup global variables
 */
function villasia_globals()
{
    global $ct_currency;

    $ct_currency = [];

    $currency_list = get_field('currency', 'options');

    if (isset($_COOKIE['villasia_currency'])) {
        $ct_currency = $currency_list[array_search($_COOKIE['villasia_currency'], array_column($currency_list, 'id'))];
    } else {
        $ct_currency = $currency_list[array_search('usd', array_column($currency_list, 'id'))];
    }
}
add_action('after_setup_theme', 'villasia_globals');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function villasia_content_width()
{
    $GLOBALS['content_width'] = apply_filters('theme_villasia_content_width', 640);
}
add_action('after_setup_theme', 'villasia_content_width', 0);

/**
 * `WP Action`: Remove
 */
function villasia_disable_gutenberg($current_status, $post_type)
{
    if ($post_type === CTCORE_POST_TYPE_OWNER) return false;
    if ($post_type === CTCORE_POST_TYPE_RATE) return false;
    return $current_status;
}
add_filter('use_block_editor_for_post_type', 'villasia_disable_gutenberg', 10, 2);

/**
 * `WP Filter`: Disable <p> tag in contact form 7
 * 
 */
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Add shortcode in contact form editor.
 * 
 * @return string
 */
if (function_exists('wpcf7_add_form_tag')) {
    function acf_field_contact_info_shortcode()
    {
        $html = '';

        ob_start();
        echo '<h2 class="ct-cf7-title">Additional Information</h2>';
        get_template_part('template-parts/interface/destination');
        get_template_part('template-parts/interface/check');
        get_template_part('template-parts/interface/guests');

        $html = ob_get_clean();

        return $html;
    }
    wpcf7_add_form_tag('cf7_additional', 'acf_field_contact_info_shortcode');

    function acf_field_contact_inquiry_shortcode()
    {
        $html = '';

        ob_start();
        echo '<h2 class="ct-cf7-title">Additional Information</h2>';
        get_template_part('template-parts/interface/check', null, [
            'booked_dates' => isset($_GET['villa_id']) ? ct_core_get_villa_ics_booked_dates($_GET['villa_id']) : [],
        ]);
        get_template_part('template-parts/interface/bedroom');

        $html = ob_get_clean();

        return $html;
    }
    wpcf7_add_form_tag('cf7_additional_inquiry', 'acf_field_contact_inquiry_shortcode');
}
