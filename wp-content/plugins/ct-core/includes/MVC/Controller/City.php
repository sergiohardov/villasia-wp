<?php

namespace CTCore\MVC\Controller;

use CTCore\SYS\Helpers;

class City
{
    public function __construct()
    {
        add_action('init', [$this, 'add_taxonomy']);
        add_filter("manage_edit-city_columns", [$this, 'location_column']);
        add_filter("manage_city_custom_column", [$this, 'location_content'], 10, 3);
    }

    public function add_taxonomy()
    {
        $types = ['owner', 'villa'];
        $labels = [
            'name' => 'Cities',
            'singular_name' => 'City',
            'menu_name' => 'Cities',
            'all_items' => 'All Cities',
            'edit_item' => 'Edit City',
            'view_item' => 'View City',
            'update_item' => 'Update City',
            'add_new_item' => 'Add New City',
            'new_item_name' => 'New City Name',
            'search_items' => 'Search Cities',
            'popular_items' => 'Popular Cities',
            'separate_items_with_commas' => 'Separate cities with commas',
            'add_or_remove_items' => 'Add or remove cities',
            'choose_from_most_used' => 'Choose from the most used cities',
            'not_found' => 'No cities found',
            'no_terms' => 'No cities',
            'items_list_navigation' => 'Cities list navigation',
            'items_list' => 'Cities list',
            'back_to_items' => '← Go to cities',
            'item_link' => 'City Link',
            'item_link_description' => 'A link to a city',
        ];
        $params = [
            'public' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
        ];

        Helpers::add_taxonomy('city', $types, $labels, $params);
    }

    public function location_column($columns)
    {
        $position = array_search('name', array_keys($columns));
        $columns = array_merge(
            array_slice($columns, 0, $position + 1, true),
            ['location_column' => 'Location'],
            array_slice($columns, $position + 1, count($columns) - $position - 1, true)
        );

        return $columns;
    }

    public function location_content($content, $column_name, $term_id)
    {
        if ('location_column' === $column_name) {
            $term = get_term($term_id, 'city');

            $area_id = get_term_meta($term->term_id, 'area', true);
            $country_id = get_term_meta($area_id, 'country', true);

            $area_name = $area_id ? get_term($area_id)->name : '—';
            $country_name = $country_id ? get_term($country_id)->name . ', ' : '';

            $content = '<div class="custom-column-content">' . $country_name . $area_name . '</div>';
        }

        return $content;
    }
}
