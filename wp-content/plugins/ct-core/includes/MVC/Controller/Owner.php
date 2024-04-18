<?php

namespace CTCore\MVC\Controller;

use CTCore\SYS\Helpers;
use CTCore\MVC\Model\Owner as OwnerModel;
use CTCore\MVC\View\Owner as OwnerView;

class Owner
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new OwnerModel();
        $this->view = new OwnerView();

        add_action('init', [$this, 'add_post_type']);
        add_action('add_meta_boxes', [$this, 'add_metaboxes']);
        add_filter('manage_' . CTCORE_POST_TYPE_OWNER . '_posts_columns', [$this, 'add_columns']);

        add_filter('manage_edit-' . CTCORE_POST_TYPE_OWNER . '_sortable_columns', [$this, 'sortable_columns']);
        add_action('pre_get_posts', [$this, 'orderby_columns']);
        // add_filter('posts_orderby', [$this, 'orderby_sql_columns'], 10, 2); // TODO: When enable this hook on page rate/promotion broke related id field

        add_action('save_post', [$this, 'save_fields']);
        add_action('acf/save_post', [$this, 'acf_save_fields']);
    }

    public function add_post_type()
    {
        $labels = [
            'name' => 'Owners',
            'singular_name' => 'Owner',
            'menu_name' => 'Owners',
            'all_items' => 'All Owners',
            'edit_item' => 'Edit Owner',
            'view_item' => 'View Owner',
            'view_items' => 'View Owners',
            'add_new_item' => 'Add New Owner',
            'new_item' => 'New Owner',
            'parent_item_colon' => 'Parent Owner:',
            'search_items' => 'Search Owners',
            'not_found' => 'No owners found',
            'not_found_in_trash' => 'No owners found in Trash',
            'archives' => 'Owner Archives',
            'attributes' => 'Owner Attributes',
            'insert_into_item' => 'Insert into owner',
            'uploaded_to_this_item' => 'Uploaded to this owner',
            'filter_items_list' => 'Filter owners list',
            'filter_by_date' => 'Filter owners by date',
            'items_list_navigation' => 'Owners list navigation',
            'items_list' => 'Owners list',
            'item_published' => 'Owner published.',
            'item_published_privately' => 'Owner published privately.',
            'item_reverted_to_draft' => 'Owner reverted to draft.',
            'item_scheduled' => 'Owner scheduled.',
            'item_updated' => 'Owner updated.',
            'item_link' => 'Owner Link',
            'item_link_description' => 'A link to a owner.',
        ];
        $params = [
            'public' => true,
            'exclude_from_search' => false,
            'show_in_rest' => true,
            'menu_position' => 100,
            'menu_icon' => 'dashicons-admin-users',
            'supports' => [
                0 => 'title',
            ],
            'delete_with_user' => false,
        ];

        Helpers::add_post_type(CTCORE_POST_TYPE_OWNER, $labels, $params);
    }

    public function add_columns($columns)
    {
        $new_columns = [
            "location" => __('Location', CTCORE_LANG_TEXT),
            "managed_villas" =>  __('Managed Villas', CTCORE_LANG_TEXT),
        ];

        $title_key = array_search('title', array_keys($columns));

        if ($title_key !== false) {
            $columns = array_slice($columns, 0, $title_key + 1, true) + $new_columns + array_slice($columns, $title_key + 1, count($columns) - 1, true);
        }

        return $columns;
    }

    public function add_metaboxes()
    {
        $metaboxes = [
            [
                'slug' => CTCORE_POST_TYPE_OWNER . '_conditions',
                'label' => __('Conditions', CTCORE_LANG_TEXT),
                'template' => [$this->view, 'render_conditions'],
            ],
            [
                'slug' => CTCORE_POST_TYPE_OWNER . '_rates',
                'label' => __('Rates', CTCORE_LANG_TEXT),
                'template' => [$this->view, 'render_rates'],
            ],
            [
                'slug' => CTCORE_POST_TYPE_OWNER . '_promotions',
                'label' => __('Promotions', CTCORE_LANG_TEXT),
                'template' => [$this->view, 'render_promotions'],
            ],
            [
                'slug' => CTCORE_POST_TYPE_OWNER . '_villas',
                'label' => __('Villas', CTCORE_LANG_TEXT),
                'template' => [$this->view, 'render_villas'],
            ]
        ];

        foreach ($metaboxes as $metabox) {
            add_meta_box(
                $metabox['slug'],
                $metabox['label'],
                $metabox['template'],
                CTCORE_POST_TYPE_OWNER,
                'normal',
                'default'
            );
        }
    }

    public function sortable_columns($columns)
    {
        $columns['location'] = 'location';
        $columns['managed_villas'] = 'managed_villas';

        return $columns;
    }

    public function orderby_columns($query)
    {
        if (!is_admin() || !$query->is_main_query()) {
            return;
        }

        if ('location' === $query->get('orderby')) {
            $query->set('meta_key', CTCORE_FIELD_OWNER_LOCATIONS_SORT);
            $query->set('orderby', 'meta_value');
        }
    }

    public function orderby_sql_columns($orderby, $query)
    {
        if (!is_admin() || !$query->is_main_query()) {
            return;
        }

        global $wpdb;

        if ($query->get('post_type') == CTCORE_POST_TYPE_OWNER && $query->get('orderby') == 'managed_villas') {
            $orderby = "(SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_key = '" . CTCORE_FIELD_VILLA_OWNER_ID . "' AND meta_value = {$wpdb->posts}.ID) " . $query->get('order');
        }

        return $orderby;
    }

    public function save_fields($post_id)
    {
        if (get_post_type($post_id) !== CTCORE_POST_TYPE_OWNER || !current_user_can('edit_post', $post_id) || empty($_POST)) return;

        if (isset($_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_OWNER_CONDITIONS])) {
            $this->model->update_conditions($post_id, $_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_OWNER_CONDITIONS]);
        }
    }

    public function acf_save_fields($post_id)
    {
        if (get_post_type($post_id) !== CTCORE_POST_TYPE_OWNER || !current_user_can('edit_post', $post_id) || empty($_POST)) return;

        $this->model->set_locations_sort($post_id, get_field(CTCORE_FIELD_OWNER_LOCATIONS, $post_id));
    }
}
