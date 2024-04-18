<?php

namespace CTCore\MVC\Controller;

use CTCore\SYS\Helpers;

class Country
{

    public function __construct()
    {
        add_action('init', [$this, 'add_taxonomy']);
    }

    public function add_taxonomy()
    {
        $types = [
            'owner',
            'villa'
        ];
        $labels = [
            'name' => 'Countries',
            'singular_name' => 'Country',
            'menu_name' => 'Countries',
            'all_items' => 'All Countries',
            'edit_item' => 'Edit Country',
            'view_item' => 'View Country',
            'update_item' => 'Update Country',
            'add_new_item' => 'Add New Country',
            'new_item_name' => 'New Country Name',
            'search_items' => 'Search Countries',
            'popular_items' => 'Popular Countries',
            'separate_items_with_commas' => 'Separate countries with commas',
            'add_or_remove_items' => 'Add or remove countries',
            'choose_from_most_used' => 'Choose from the most used countries',
            'not_found' => 'No countries found',
            'no_terms' => 'No countries',
            'items_list_navigation' => 'Countries list navigation',
            'items_list' => 'Countries list',
            'back_to_items' => '← Go to countries',
            'item_link' => 'Country Link',
            'item_link_description' => 'A link to a country',
        ];
        $params = [
            'public' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
        ];

        Helpers::add_taxonomy('country', $types, $labels, $params);
    }
}
