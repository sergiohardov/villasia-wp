<?php

namespace CTCore\MVC\Controller;

use CTCore\SYS\Helpers;
use CTCore\MVC\Model\Villa as ModelVilla;
use CTCore\MVC\View\Villa as ViewVilla;

class Villa
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new ModelVilla();
        $this->view = new ViewVilla();

        add_action('init', [$this, 'add_post_type']);
        add_filter('manage_' . CTCORE_POST_TYPE_VILLA . '_posts_columns', [$this, 'add_columns']);
        add_action('add_meta_boxes', [$this, 'add_metaboxes']);
        add_action('admin_menu', [$this, 'add_submenu_pages']);

        add_filter('manage_edit-' . CTCORE_POST_TYPE_VILLA . '_sortable_columns', [$this, 'sortable_columns']);
        add_action('pre_get_posts', [$this, 'orderby_columns']);

        add_action('save_post_' . CTCORE_POST_TYPE_VILLA, [$this, 'save_fields']);
        add_action('duplicate_post_post_copy', [$this, 'clone_post'], 10, 4);
    }
    public function add_post_type()
    {
        $labels = [
            'name' => 'Villas',
            'singular_name' => 'Villa',
            'menu_name' => 'Villas',
            'all_items' => 'All Villas',
            'edit_item' => 'Edit Villa',
            'view_item' => 'View Villa',
            'view_items' => 'View Villas',
            'add_new_item' => 'Add New Villa',
            'new_item' => 'New Villa',
            'parent_item_colon' => 'Parent Villa:',
            'search_items' => 'Search Villas',
            'not_found' => 'No villas found',
            'not_found_in_trash' => 'No villas found in Trash',
            'archives' => 'Villa Archives',
            'attributes' => 'Villa Attributes',
            'insert_into_item' => 'Insert into villa',
            'uploaded_to_this_item' => 'Uploaded to this villa',
            'filter_items_list' => 'Filter villas list',
            'filter_by_date' => 'Filter villas by date',
            'items_list_navigation' => 'Villas list navigation',
            'items_list' => 'Villas list',
            'item_published' => 'Villa published.',
            'item_published_privately' => 'Villa published privately.',
            'item_reverted_to_draft' => 'Villa reverted to draft.',
            'item_scheduled' => 'Villa scheduled.',
            'item_updated' => 'Villa updated.',
            'item_link' => 'Villa Link',
            'item_link_description' => 'A link to a villa.',
        ];
        $params = [
            'public' => true,
            'exclude_from_search' => false,
            'show_in_rest' => true,
            'menu_position' => 101,
            'menu_icon' => 'dashicons-admin-home',
            'supports' => [
                0 => 'title',
            ],
            'delete_with_user' => false,
        ];

        Helpers::add_post_type(CTCORE_POST_TYPE_VILLA, $labels, $params);
    }
    public function add_columns($columns)
    {
        $new_columns = [
            "bedroom" => __('Bedrooms', CTCORE_LANG_TEXT),
            "country" => __('Contry', CTCORE_LANG_TEXT),
            "area" => __('Region', CTCORE_LANG_TEXT),
            "city" => __('City', CTCORE_LANG_TEXT),
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
                'slug' => CTCORE_POST_TYPE_VILLA . '_metabox_price',
                'label' => __('Price', CTCORE_LANG_TEXT),
                'template' => [$this->view, 'metabox_price'],
            ],
            [
                'slug' => CTCORE_POST_TYPE_VILLA . '_metabox_conditions',
                'label' => __('Conditions', CTCORE_LANG_TEXT),
                'template' => [$this->view, 'metabox_conditions'],
            ],
            [
                'slug' => CTCORE_POST_TYPE_VILLA . '_metabox_promotions',
                'label' => __('Villa Promotions', CTCORE_LANG_TEXT),
                'template' => [$this->view, 'metabox_promotions'],
            ],
            [
                'slug' => CTCORE_POST_TYPE_VILLA . '_metabox_rating',
                'label' => __('Google Reviews', CTCORE_LANG_TEXT),
                'template' => [$this->view, 'metabox_rating'],
            ],
            [
                'slug' => CTCORE_POST_TYPE_VILLA . '_metabox_price_night',
                'label' => __('Price Night', CTCORE_LANG_TEXT),
                'template' => [$this->view, 'metabox_price_night'],
            ]
        ];

        foreach ($metaboxes as $metabox) {
            add_meta_box(
                $metabox['slug'],
                $metabox['label'],
                $metabox['template'],
                CTCORE_POST_TYPE_VILLA,
                'normal',
                'default'
            );
        }
    }
    public function add_submenu_pages()
    {
        add_submenu_page(
            'edit.php?post_type=' . CTCORE_POST_TYPE_VILLA,
            'Rating Villas',
            'Ratings',
            'manage_options',
            CTCORE_POST_TYPE_VILLA . '_page_rating',
            [$this->view, 'page_rating']
        );
    }
    public function sortable_columns($columns)
    {
        $columns['bedroom'] = 'bedroom';
        $columns['country'] = 'country';
        $columns['area'] = 'area';
        $columns['city'] = 'city';

        return $columns;
    }
    public function orderby_columns($query)
    {
        if (!is_admin() || !$query->is_main_query()) {
            return;
        }

        if ('bedroom' === $query->get('orderby')) {
            $query->set('meta_key', CTCORE_FIELD_VILLA_BEDROOMS);
            $query->set('orderby', 'meta_value_num');
        }

        if ('country' === $query->get('orderby')) {
            $query->set('meta_key', CTCORE_FIELD_VILLA_COUNTRY_ID);
            $query->set('orderby', 'meta_value_num');
        }

        if ('area' === $query->get('orderby')) {
            $query->set('meta_key', CTCORE_FIELD_VILLA_AREA_ID);
            $query->set('orderby', 'meta_value_num');
        }

        if ('city' === $query->get('orderby')) {
            $query->set('meta_key', CTCORE_FIELD_VILLA_CITY_ID);
            $query->set('orderby', 'meta_value_num');
        }
    }
    public function save_fields($post_id)
    {
        if (!current_user_can('edit_post', $post_id) || empty($_POST)) return;

        $rate_sync          = isset($_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_RATE_SYNC]) ? $_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_RATE_SYNC] : null;
        $rate_id            = isset($_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_RATE_ID]) ? $_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_RATE_ID] : null;
        $price_list         = isset($_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_PRICE]) ? $_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_PRICE] : null;
        $tax_service        = isset($_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_TAX_SERVICE]) ? $_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_TAX_SERVICE] : null;
        $tax_rate           = isset($_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_TAX_RATE]) ? $_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_TAX_RATE] : null;
        $conditions_sync    = isset($_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_CONDITIONS_SYNC]) ? $_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_CONDITIONS_SYNC] : null;
        $conditions_data    = isset($_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_CONDITIONS_DATA]) ? $_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_CONDITIONS_DATA] : null;
        $promotions_owner   = isset($_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_PROMOTIONS_OWNER]) ? $_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_PROMOTIONS_OWNER] : [];
        $best_choice        = isset($_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_BEST_CHOICE]) ? $_POST[CTCORE_FIELD_CUSTOM_KEY][CTCORE_FIELD_VILLA_BEST_CHOICE] : null;

        /* Price */
        $this->model->set_rates_sync($post_id, $rate_sync);
        $this->model->set_rate_card_id($post_id, $rate_id);
        $this->model->set_price_list($post_id, $price_list);
        $this->model->set_service_tax($post_id, $tax_service);
        $this->model->set_rate_tax($post_id, $tax_rate);
        $this->model->set_price_min_max($post_id, $price_list, $tax_service, $tax_rate);

        /* Conditions */
        $this->model->set_conditions_sync($post_id, $conditions_sync);
        $this->model->set_conditions_data($post_id, $conditions_data);

        /* Promotions */
        $this->model->set_promotions_owner($post_id, $promotions_owner);
        $this->model->set_has_promotions($post_id);

        /* Other */
        $this->model->set_is_best_choice($post_id, $best_choice); 
    }
    public function clone_post($new_post_id, $old_post_obj, $status, $parent_id)
    {
        $rate_sync = $this->model->get_rates_sync($new_post_id);

        if ($rate_sync === 'no') {
            // Remove prices for copy villa
            $this->model->set_rate_card_id($new_post_id, null);
            $this->model->set_price_list($new_post_id, null);
            $this->model->set_price_min($new_post_id, null);
            $this->model->set_price_max($new_post_id, null);
        }
    }
}
