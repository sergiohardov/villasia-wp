<?php

namespace CTCore\MVC\Controller;

use CTCore\SYS\Helpers;

class KeyFeature
{

    public function __construct()
    {
        add_action('init', [$this, 'add_taxonomy']);
    }

    public function add_taxonomy()
    {
        $types = ['villa'];
        $labels = [
            'name' => 'Key Features',
            'singular_name' => 'Key Feature',
            'menu_name' => 'Key Features',
            'all_items' => 'All Key Features',
            'edit_item' => 'Edit Key Feature',
            'view_item' => 'View Key Feature',
            'update_item' => 'Update Key Feature',
            'add_new_item' => 'Add New Key Feature',
            'new_item_name' => 'New Key Feature Name',
            'search_items' => 'Search Key Features',
            'popular_items' => 'Popular Key Features',
            'separate_items_with_commas' => 'Separate key features with commas',
            'add_or_remove_items' => 'Add or remove key features',
            'choose_from_most_used' => 'Choose from the most used key features',
            'not_found' => 'No key features found',
            'no_terms' => 'No key features',
            'items_list_navigation' => 'Key Features list navigation',
            'items_list' => 'Key Features list',
            'back_to_items' => '← Go to key features',
            'item_link' => 'Key Feature Link',
            'item_link_description' => 'A link to a key feature',
        ];
        $params = [
            'public' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
        ];

        Helpers::add_taxonomy('key_feature', $types, $labels, $params);
    }
}
