<?php

namespace CTCore\MVC\Controller;

use CTCore\SYS\Helpers;
use CTCore\MVC\Model\Rate as RateModel;
use CTCore\MVC\View\Rate as RateView;

class Rate
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new RateModel();
        $this->view = new RateView();

        add_action('init', [$this, 'add_post_type']);
        add_filter('manage_' . CTCORE_POST_TYPE_RATE . '_posts_columns', [$this, 'add_columns']);
        add_action('save_post', [$this, 'save_fields']);
    }

    public function add_post_type()
    {
        $labels = [
            'name' => 'Rates',
            'singular_name' => 'Rate',
            'menu_name' => 'Rates',
            'all_items' => 'All Rates',
            'edit_item' => 'Edit Rate',
            'view_item' => 'View Rate',
            'view_items' => 'View Rates',
            'add_new_item' => 'Add New Rate',
            'new_item' => 'New Rate',
            'parent_item_colon' => 'Parent Rate:',
            'search_items' => 'Search Rates',
            'not_found' => 'No rates found',
            'not_found_in_trash' => 'No rates found in Trash',
            'archives' => 'Rate Archives',
            'attributes' => 'Rate Attributes',
            'insert_into_item' => 'Insert into rate',
            'uploaded_to_this_item' => 'Uploaded to this rate',
            'filter_items_list' => 'Filter rates list',
            'filter_by_date' => 'Filter rates by date',
            'items_list_navigation' => 'Rates list navigation',
            'items_list' => 'Rates list',
            'item_published' => 'Rate published.',
            'item_published_privately' => 'Rate published privately.',
            'item_reverted_to_draft' => 'Rate reverted to draft.',
            'item_scheduled' => 'Rate scheduled.',
            'item_updated' => 'Rate updated.',
            'item_link' => 'Rate Link',
            'item_link_description' => 'A link to a rate.',
        ];
        $params = [
            'public' => true,
            'exclude_from_search' => false,
            'show_in_nav_menus' => false,
            'show_in_rest' => true,
            'menu_position' => 102,
            'menu_icon' => 'dashicons-calendar-alt',
            'supports' => [
                0 => 'title',
            ],
            'delete_with_user' => false,
        ];

        Helpers::add_post_type(CTCORE_POST_TYPE_RATE, $labels, $params);
    }

    public function add_columns($columns)
    {
        $new_columns = [
            "valid_until" => __('Valid Until', CTCORE_LANG_TEXT),
        ];

        $title_key = array_search('title', array_keys($columns));

        if ($title_key !== false) {
            $columns = array_slice($columns, 0, $title_key + 1, true) + $new_columns + array_slice($columns, $title_key + 1, count($columns) - 1, true);
        }

        return $columns;
    }

    public function save_fields($post_id)
    {
        // NOT CHECK $_POST EMPTY FOR AUTO SAVE WHEN CREATE FROM OWNER OR VILLA

        if (get_post_type($post_id) !== CTCORE_POST_TYPE_RATE || !current_user_can('edit_post', $post_id)) return;

        if (isset($_GET[CTCORE_FIELD_RATE_RELATED_ID])) {
            $this->model->set_related_id($post_id, $_GET[CTCORE_FIELD_RATE_RELATED_ID]);
        }
    }
}
