<?php

namespace CTCore\MVC\Controller;

use CTCore\SYS\Helpers;

class Area
{

    public function __construct()
    {
        add_action('init', [$this, 'add_taxonomy']);
        add_filter("manage_edit-area_columns", [$this, 'country_column']);
        add_filter("manage_area_custom_column", [$this, 'country_content'], 10, 3);
    }

    public function add_taxonomy()
    {
        $types = [
            'owner',
            'villa'
        ];
        $labels = [
            'name' => 'Areas',
            'singular_name' => 'Area',
            'menu_name' => 'Areas',
            'all_items' => 'All Areas',
            'edit_item' => 'Edit Area',
            'view_item' => 'View Area',
            'update_item' => 'Update Area',
            'add_new_item' => 'Add New Area',
            'new_item_name' => 'New Area Name',
            'search_items' => 'Search Areas',
            'popular_items' => 'Popular Areas',
            'separate_items_with_commas' => 'Separate areas with commas',
            'add_or_remove_items' => 'Add or remove areas',
            'choose_from_most_used' => 'Choose from the most used areas',
            'not_found' => 'No areas found',
            'no_terms' => 'No areas',
            'items_list_navigation' => 'Areas list navigation',
            'items_list' => 'Areas list',
            'back_to_items' => '← Go to areas',
            'item_link' => 'Area Link',
            'item_link_description' => 'A link to a area',
        ];
        $params = [
            'public' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
        ];

        Helpers::add_taxonomy('area', $types, $labels, $params);
    }

    public function country_column($columns)
    {
        $position = array_search('name', array_keys($columns));
        $columns = array_merge(
            array_slice($columns, 0, $position + 1, true),
            ['country_column' => 'Country'],
            array_slice($columns, $position + 1, count($columns) - $position - 1, true)
        );

        return $columns;
    }

    public function country_content($content, $column_name, $term_id)
    {
        if ('country_column' === $column_name) {
            $term = get_term($term_id, 'area');
            $country_id = get_term_meta($term->term_id, 'country', true);
            $country_name = $country_id ? get_term($country_id)->name : '—';
            $content = '<div class="custom-column-content">' . $country_name . '</div>';
        }

        return $content;
    }
}
