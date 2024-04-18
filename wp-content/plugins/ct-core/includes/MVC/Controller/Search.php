<?php

namespace CTCore\MVC\Controller;

class Search
{
    private $table_name = CTCORE_ICS_TABLE_NAME;
    
    public function __construct()
    {
        add_action('pre_get_posts', [$this, 'init']);
    }

    public function init($query)
    {
        if (!(!is_admin() && $query->is_main_query() && is_search())) return;
        global $wpdb;

        $destination = isset($_GET['destination']) ? sanitize_text_field($_GET['destination']) : '';
        $check_in = isset($_GET['check_in']) ? sanitize_text_field($_GET['check_in']) : '';
        $check_out = isset($_GET['check_out']) ? sanitize_text_field($_GET['check_out']) : '';
        $bedroom = isset($_GET['bedroom']) ? sanitize_text_field($_GET['bedroom']) : '';
        $price_from = isset($_GET['price_from']) ? sanitize_text_field($_GET['price_from']) : '';
        $price_to = isset($_GET['price_to']) ? sanitize_text_field($_GET['price_to']) : '';
        $promotion = isset($_GET['promotions']) ? sanitize_text_field($_GET['promotions']) : '';
        $theme = isset($_GET['theme']) ? $_GET['theme'] : [];
        $feature = isset($_GET['feature']) ? $_GET['feature'] : [];
        $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

        $villa_ids_in_period = [];
        $tax_query = [];
        $meta_query = [];

        if (!empty($check_in) && !empty($check_out)) {
            $sql_query = $wpdb->get_results("SELECT * FROM $this->table_name WHERE date BETWEEN '$check_in' AND '$check_out'", ARRAY_A);
            $villa_ids_in_period = array_unique(array_column($sql_query, 'id_villa')); // TODO: maybe unique & ids try in sql query
        }
        if (!empty($destination)) {
            $tax_query[] = [
                'relation' => 'OR',
                [
                    'taxonomy' => 'country',
                    'field'    => 'term_id',
                    'terms'    => is_numeric($destination) ? $destination : ct_core_get_location_id_by_name($destination),
                ],
                [
                    'taxonomy' => 'city',
                    'field'    => 'term_id',
                    'terms'    => is_numeric($destination) ? $destination : ct_core_get_location_id_by_name($destination),
                ],
                [
                    'taxonomy' => 'area',
                    'field'    => 'term_id',
                    'terms'    => is_numeric($destination) ? $destination : ct_core_get_location_id_by_name($destination),
                ]
            ];
        }
        if (!empty($bedroom)) {
            $meta_query[] = [
                'key'     => 'main_group_bedrooms',
                'value'   => $bedroom,
                'compare' => '>=',
                'type'    => 'NUMERIC',
            ];
        }
        if (!empty($price_from)) {
            $meta_query[] = [
                'key'     => CTCORE_FIELD_VILLA_PRICE_MIN,
                'value'   => $price_from,
                'compare' => '>=',
                'type'    => 'NUMERIC',
            ];
        }
        if (!empty($price_to)) {
            $meta_query[] = [
                'key'     => CTCORE_FIELD_VILLA_PRICE_MIN,
                'value'   => $price_to,
                'compare' => '<=',
                'type'    => 'NUMERIC',
            ];
        }
        if (!empty($promotion)) {
            if ($promotion === 'on') {
                $meta_query[] = [
                    'key'     => CTCORE_FIELD_VILLA_HAS_PROMOTIONS,
                    'value'   => 1,
                    'compare' => '=',
                    'type'    => 'NUMERIC',
                ];
            }
        }
        if (!empty($theme)) {
            $tax_query[] = [
                'taxonomy' => 'villa_theme',
                'field'    => 'term_id',
                'terms'    => $theme,
                'operator'  => 'AND'
            ];
        }
        if (!empty($feature)) {
            $tax_query[] = [
                'taxonomy' => 'key_feature',
                'field'    => 'term_id',
                'terms'    => $feature,
                'operator'  => 'AND'
            ];
        }

        $meta_query[] = [
            'relation' => 'OR',
            [
                'key' => CTCORE_FIELD_VILLA_PRICE_MIN,
                'compare' => 'EXISTS'
            ],
            [
                'key' => CTCORE_FIELD_VILLA_PRICE_MIN,
                'compare' => 'NOT EXISTS'
            ]
        ];

        $query->set('post__not_in', $villa_ids_in_period);
        $query->set('orderby', 'meta_value_num');
        $query->set('order', $order);

        $query->set('posts_per_page', 12);
        $query->set('post_type', CTCORE_POST_TYPE_VILLA);
        $query->set('tax_query', $tax_query);
        $query->set('meta_query', $meta_query);
    }
}
