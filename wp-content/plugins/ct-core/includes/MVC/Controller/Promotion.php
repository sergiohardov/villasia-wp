<?php

namespace CTCore\MVC\Controller;

use CTCore\SYS\Helpers;
use CTCore\MVC\Model\Promotion as PromotionModel;
use CTCore\MVC\View\Promotion as PromotionView;
use CTCore\MVC\Model\Rate as RateModel;
use CTCore\MVC\Model\Villa as VillaModel;

class Promotion
{
    private $model;
    private $view;

    private $old_related_id;

    public function __construct()
    {
        $this->model = new PromotionModel();
        $this->view = new PromotionView();

        add_action('init', [$this, 'add_post_type']);
        add_filter('manage_' . CTCORE_POST_TYPE_PROMOTION . '_posts_columns', [$this, 'add_columns']);

        add_filter('acf/load_field/key=field_651eb4fff98ed', [$this, 'set_select_rate']);
        add_filter('acf/prepare_field/key=field_651eb60cf98f4', [$this, 'set_select_offer']);

        add_filter('wp_insert_post_data', [$this, 'pre_save_post'], 99, 2);
        add_action('save_post', [$this, 'save_fields']);
        add_action('delete_post', [$this, 'delete_post'], 10, 2);
        add_action('trashed_post', [$this, 'trash_post'], 10, 2);
        add_action('untrash_post', [$this, 'untrash_post'], 10, 2);
    }

    public function add_post_type()
    {
        $labels = [
            'name' => 'Promotions',
            'singular_name' => 'Promotion',
            'menu_name' => 'Promotions',
            'all_items' => 'All Promotions',
            'edit_item' => 'Edit Promotion',
            'view_item' => 'View Promotion',
            'view_items' => 'View Promotions',
            'add_new_item' => 'Add New Promotion',
            'new_item' => 'New Promotion',
            'parent_item_colon' => 'Parent Promotion:',
            'search_items' => 'Search Promotions',
            'not_found' => 'No promotions found',
            'not_found_in_trash' => 'No promotions found in Trash',
            'archives' => 'Promotion Archives',
            'attributes' => 'Promotion Attributes',
            'insert_into_item' => 'Insert into promotion',
            'uploaded_to_this_item' => 'Uploaded to this promotion',
            'filter_items_list' => 'Filter promotions list',
            'filter_by_date' => 'Filter promotions by date',
            'items_list_navigation' => 'Promotions list navigation',
            'items_list' => 'Promotions list',
            'item_published' => 'Promotion published.',
            'item_published_privately' => 'Promotion published privately.',
            'item_reverted_to_draft' => 'Promotion reverted to draft.',
            'item_scheduled' => 'Promotion scheduled.',
            'item_updated' => 'Promotion updated.',
            'item_link' => 'Promotion Link',
            'item_link_description' => 'A link to a promotion.',
        ];
        $params = [
            'public' => true,
            'exclude_from_search' => false,
            'show_in_rest' => true,
            'menu_position' => 103,
            'menu_icon' => 'dashicons-megaphone',
            'supports' => [
                0 => 'title',
            ],
            'delete_with_user' => false,
        ];

        Helpers::add_post_type(CTCORE_POST_TYPE_PROMOTION, $labels, $params);
    }

    public function add_columns($columns)
    {
        $new_columns = [
            "excluded_period" => __('Excluded Period', CTCORE_LANG_TEXT),
        ];

        $title_key = array_search('title', array_keys($columns));

        if ($title_key !== false) {
            $columns = array_slice($columns, 0, $title_key + 1, true) + $new_columns + array_slice($columns, $title_key + 1, count($columns) - 1, true);
        }

        return $columns;
    }

    public function set_select_rate($field)
    {
        $related_id = $this->model->get_related_id(get_the_ID());
        $result = [];

        if ($related_id) {
            $rates = RateModel::get_rates($related_id);

            // I cant use while loop because ...->the_post() rewrite ctx and function after have wrong post id
            // wp reset postdata - not working
            if ($rates->have_posts()) {
                foreach ($rates->posts as $post_item) {
                    $result[$post_item->ID] = $post_item->post_title;
                }
            }
        }

        $field['choices'] = $result;

        return $field;
    }

    public function set_select_offer($field)
    {
        $related_id = $this->model->get_related_id(get_the_ID());
        $result = [];

        if ($related_id) {
            $promotions = $this->model->get_promotions($related_id);

            // I cant use while loop because ...->the_post() rewrite ctx and function after have wrong post id
            // wp reset postdata - not working
            if ($promotions->have_posts()) {
                foreach ($promotions->posts as $post_item) {
                    if ($post_item->ID === get_the_ID()) continue; // If current promo === promo in list
                    if ($this->check_is_combined($post_item->ID, get_the_ID())) continue; // If current promo use in combined

                    $result[$post_item->ID] = $post_item->post_title;
                }
            }
        }

        $field['choices'] = $result;

        return $field;
    }

    public function check_is_combined($parent_id, $child_id)
    {
        $result = false;
        $child_promotions = $this->model->get_combined_ids($parent_id);

        if (in_array($child_id, $child_promotions)) {
            $result = true;
        }

        return $result;
    }

    public function check_save_combined($post_id)
    {
        $can_combine = $this->model->get_can_combined($post_id);

        if ($can_combine === 'yes') {
            $child_promotions = $this->model->get_combined_ids($post_id);

            $related_id = $this->model->get_related_id($post_id);
            $related_promotions = $this->model->get_promotions($related_id);


            if ($related_promotions->have_posts()) {
                foreach ($related_promotions->posts as $promotion_item) {

                    if ($this->check_is_combined($promotion_item->ID, $post_id)) {

                        $key = array_search($promotion_item->ID, $child_promotions);
                        if ($key !== false)  unset($child_promotions[$key]);
                    }
                }
            }

            $this->model->set_combined_ids($post_id, $child_promotions);
        }
    }

    public function pre_save_post($data, $postarr)
    {
        $this->old_related_id = $this->model->get_related_id(get_the_ID());

        return $data;
    }

    public function save_fields($post_id)
    {
        // NOT CHECK $_POST EMPTY FOR AUTO SAVE WHEN CREATE FROM OWNER OR VILLA

        if (get_post_type($post_id) !== CTCORE_POST_TYPE_PROMOTION || !current_user_can('edit_post', $post_id)) return;

        if (isset($_GET[CTCORE_FIELD_PROMOTION_RELATED_ID])) {
            $this->model->set_related_id($post_id, $_GET[CTCORE_FIELD_PROMOTION_RELATED_ID]);
        }

        $this->check_save_combined($post_id);

        VillaModel::set_has_promotions($this->model->get_related_id($post_id));
        VillaModel::set_has_promotions($this->old_related_id);
    }

    public function delete_post($post_id, $post)
    {
        VillaModel::set_has_promotions($this->model->get_related_id($post_id));
    }

    public function trash_post($post_id, $previous_status)
    {
        VillaModel::set_has_promotions($this->model->get_related_id($post_id));
    }

    public function untrash_post($post_id, $previous_status)
    {
        VillaModel::set_has_promotions($this->model->get_related_id($post_id));
    }
}
