<?php

namespace CTCore\MVC\Controller;

use CTCore\SYS\Helpers;
use WP_Query;

class Wishlist
{
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'init']);
    }

    public function init()
    {
        global $wishlist_query;
        global $wishlist_ids;

        $wishlist_query = null;
        $wishlist_ids = [-1];

        $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

        if (isset($_COOKIE['villasia_wishlist'])) {
            $str = str_replace('\\', '', $_COOKIE['villasia_wishlist']);
            $arr = json_decode($str);

            if ($arr) {
                $wishlist_ids = $arr;
            }
        }

        $wishlist_query = new WP_Query([
            'post_type' => CTCORE_POST_TYPE_VILLA,
            'post__in' => $wishlist_ids,
            'orderby' => 'meta_value_num',
            'meta_query' => [
                'relation' => 'OR',
                [
                    'key' => CTCORE_FIELD_VILLA_PRICE_MIN,
                    'compare' => 'EXISTS'
                ],
                [
                    'key' => CTCORE_FIELD_VILLA_PRICE_MIN,
                    'compare' => 'NOT EXISTS'
                ]
            ],
            'order' => $order
        ]);
    }
}
