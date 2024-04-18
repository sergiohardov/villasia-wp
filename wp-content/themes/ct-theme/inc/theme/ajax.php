<?php if (!defined("ABSPATH")) die;

/* Theme: Ajax */

add_action('wp_ajax_ct_theme_js_search_get_locations', 'ct_theme_js_search_get_locations');
add_action('wp_ajax_nopriv_ct_theme_js_search_get_locations', 'ct_theme_js_search_get_locations');

function ct_theme_js_search_get_locations()
{
    if (empty($_POST) || !isset($_POST['value'])) {
        wp_send_json_error();
    }
    $search_term = $_POST['value'];
    $result = [];

    $args = array(
        'taxonomy'   => [CTCORE_TAXONOMY_COUNTRY, CTCORE_TAXONOMY_AREA, CTCORE_TAXONOMY_CITY],
        'fields'     => 'all',
        'hide_empty' => false,
        'name__like' => $search_term,
    );

    $term_query = new WP_Term_Query($args);

    $terms = $term_query->get_terms();

    if ($terms) {
        foreach ($terms as $term) {
            $result[] = [
                'id' => $term->term_id,
                'name' => ct_theme_get_format_location($term)
            ];
        }
    }

    wp_send_json_success($result);
}

add_action('wp_ajax_ct_theme_js_search_header', 'ct_theme_js_search_header');
add_action('wp_ajax_nopriv_ct_theme_js_search_header', 'ct_theme_js_search_header');

function ct_theme_js_search_header()
{
    if (empty($_POST) || !isset($_POST['value'])) {
        wp_send_json_error();
    }

    $search_part = $_POST['value'];
    $result = [];

    $args_terms = [
        'taxonomy'   => [CTCORE_TAXONOMY_COUNTRY, CTCORE_TAXONOMY_AREA, CTCORE_TAXONOMY_CITY],
        'fields'     => 'all',
        'hide_empty' => false,
        'name__like' => $search_part,
    ];

    $args_posts = [
        'post_type'      => CTCORE_POST_TYPE_VILLA,
        'posts_per_page' => -1,
        's'              => $search_part,
    ];

    $term_query = new WP_Term_Query($args_terms);
    $post_query = new WP_Query($args_posts);


    $terms = $term_query->get_terms();
    $posts = $post_query->get_posts();

    if ($terms) {
        foreach ($terms as $term_item) {
            $result[] = [
                'id' => $term_item->term_id,
                'name' => ct_theme_get_format_location($term_item),
                'link' => get_term_link($term_item),
                'type' => 'location'
            ];
        }
    }


    if ($posts) {
        foreach ($posts as $post_item) {
            $result[] = [
                'id' => $post_item->ID,
                'name' => $post_item->post_title,
                'link' => $post_item->guid,
                'type' => 'villa'
            ];
        }
    }

    wp_send_json_success($result);
}

add_action('wp_ajax_ct_theme_js_blog_load_more', 'ct_theme_js_blog_load_more');
add_action('wp_ajax_nopriv_ct_theme_js_blog_load_more', 'ct_theme_js_blog_load_more');

function ct_theme_js_blog_load_more()
{
    if (empty($_POST) || !isset($_POST['category']) || !isset($_POST['page'])) {
        wp_send_json_error();
    }

    $result = '';

    $args = [
        'post_type'      => 'post',
        'posts_per_page' => get_option('posts_per_page'),
        'paged'          => $_POST['page'],
    ];

    if ($_POST['category']) {
        $args['category_name'] = $_POST['category'];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {

        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/card/post');
        }
        $result = ob_get_clean();

        wp_reset_postdata();
    }

    wp_send_json_success($result);
}

add_action('wp_ajax_ct_theme_get_booking_details', 'ct_theme_get_booking_details');
add_action('wp_ajax_nopriv_ct_theme_get_booking_details', 'ct_theme_get_booking_details');

function ct_theme_get_booking_details()
{
    $result = null;

    $villa_id = $_POST['villa_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $bedrooms = $_POST['bedrooms'];

    $result = ct_core_get_villa_price($villa_id, $check_in, $check_out, $bedrooms);

    wp_send_json_success($result);
}
