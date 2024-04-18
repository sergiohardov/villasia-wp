<?php

use CTCore\MVC\Controller\Ical;
use CTCore\MVC\Controller\Price as PriceController;
use CTCore\MVC\Model\Ical as ModelIcal;
use CTCore\MVC\Model\Villa as VillaModel;

function ct_core_get_villa_price($post = 0, $check_in, $check_out, $bedroom)
{
    $post = get_post($post);
    $post_id = isset($post->ID) ? $post->ID : 0;

    $instance = new PriceController($post_id, $check_in, $check_out, $bedroom);

    return $instance->get_price();
}

function ct_core_get_villa_has_promotion($count = 10)
{
    $result = null;

    $args = [
        'post_type'      => CTCORE_POST_TYPE_VILLA,
        'posts_per_page' => $count,
        'meta_query'     => [
            [
                'key'   => CTCORE_FIELD_VILLA_HAS_PROMOTIONS,
                'value' => 1,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ]
        ]
    ];

    $result = new WP_Query($args);

    return $result;
}

function ct_core_villa_is_best_choice($post = 0)
{
    $post = get_post($post);
    $post_id = isset($post->ID) ? $post->ID : 0;

    $result = VillaModel::get_is_best_choice($post_id) ? true : false;

    return $result;
}

function ct_core_get_location_id_by_name($val)
{
    $args = [
        'taxonomy'   => [CTCORE_TAXONOMY_COUNTRY, CTCORE_TAXONOMY_AREA, CTCORE_TAXONOMY_CITY],
        'fields'     => 'ids',
        'hide_empty' => false,
        'name__like' => $val,
        'number'     => 1,
    ];

    $term_query = new WP_Term_Query($args);
    $terms = $term_query->get_terms();

    return $terms ? $terms[0] : '';
}

function ct_core_get_villas_global_price_night_min()
{
    global $wpdb;
    $post_type = CTCORE_POST_TYPE_VILLA;
    $meta_key = CTCORE_FIELD_VILLA_PRICE_MIN;

    $result = $wpdb->get_row(
        "SELECT 
            (SELECT MIN(FLOOR(CAST(meta_value AS DECIMAL(10,2)))) FROM $wpdb->postmeta WHERE meta_key = '$meta_key' AND post_id IN (SELECT ID FROM $wpdb->posts WHERE post_type = '$post_type')) as min_price,
            (SELECT MAX(CEILING(CAST(meta_value AS DECIMAL(10,2)))) FROM $wpdb->postmeta WHERE meta_key = '$meta_key' AND post_id IN (SELECT ID FROM $wpdb->posts WHERE post_type = '$post_type')) as max_price",
        ARRAY_A
    );

    return $result;
}

function ct_core_update_villa_ics_dates($post_id, $link)
{
    $ical = new Ical();
    $ical->update_dates($post_id, $link);
}

function ct_core_get_villa_ics_booked_dates($post_id)
{
    return ModelIcal::get_dates($post_id);
}

// function ct_core_get_villas_global_price_night()
// {
//     global $wpdb;
//     $post_type_villa = CTCORE_POST_TYPE_VILLA;
//     $meta_key_min = CTCORE_FIELD_VILLA_PRICE_MIN;
//     $meta_key_max = CTCORE_FIELD_VILLA_PRICE_MAX;

//     $result = $wpdb->get_row(
//         "SELECT 
//         (SELECT MIN(CAST(meta_value AS DECIMAL(10))) FROM $wpdb->postmeta WHERE meta_key = '$meta_key_min' AND post_id IN (SELECT ID FROM $wpdb->posts WHERE post_type = '$post_type_villa')) as min_price,
//         (SELECT MAX(CAST(meta_value AS DECIMAL(10))) FROM $wpdb->postmeta WHERE meta_key = '$meta_key_max' AND post_id IN (SELECT ID FROM $wpdb->posts WHERE post_type = '$post_type_villa')) as max_price",
//         ARRAY_A
//     );

//     return $result;
// }