<?php

namespace CTCore\MVC\View;

use CTCore\SYS\Helpers;
use CTCore\MVC\Model\Villa as VillaModel;
use CTCore\MVC\Model\Promotion as PromotionModel;
use CTCore\MVC\Model\Rate as RateModel;

class Villa
{
    private $model;

    function __construct()
    {
        $this->model = new VillaModel();

        add_action('manage_' . CTCORE_POST_TYPE_VILLA . '_posts_custom_column', [$this, 'render_columns'], 10, 2);
    }

    public function render_columns($column, $post_id)
    {
        if ($column == 'bedroom') {
            $bedrooms = $this->model->get_bedrooms($post_id);
            echo $bedrooms ?: '-';
        }

        if ($column == 'country') {
            $country_id = $this->model->get_country_id($post_id);
            echo $country_id ? get_term($country_id)->name : '-';
        }

        if ($column == 'area') {
            $area_id = $this->model->get_area_id($post_id);
            echo $area_id ? get_term($area_id)->name : '-';
        }

        if ($column == 'city') {
            $city_id = $this->model->get_city_id($post_id);
            echo $city_id ? get_term($city_id)->name : '-';
        }
    }
    public function metabox_price($post)
    {

        function get_current_rates($sync, $villa_id, $owner_id)
        {
            $result = [];

            switch ($sync) {
                case 'no':
                    $rates = RateModel::get_rates($villa_id);
                    break;
                case 'yes':
                    $rates = RateModel::get_rates($owner_id);
                    break;
                default:
                    break;
            }

            if ($rates->have_posts()) {
                foreach ($rates->posts as $post_item) {
                    $result[$post_item->ID] = $post_item->post_title;
                }
            }

            return $result;
        }

        $villa_id = isset($_GET['post']) ? $_GET['post'] : null;
        $current_sync_status = $this->model->get_rates_sync($villa_id);
        $current_rate_id = $this->model->get_rate_card_id($villa_id);
        $villa_owner_id = $this->model->get_owner_id($villa_id);

        $args = [
            'villa_id' => $villa_id,
            'sync' => $current_sync_status,
            'rate_id' => $current_rate_id,
            'rates' => get_current_rates($current_sync_status, $villa_id, $villa_owner_id),
            'seasons' => RateModel::get_periods($current_rate_id),
            'price_list' => $this->model->get_price_list($villa_id),
            'tax_service' => $this->model->get_service_tax($villa_id),
            'tax_rate' => $this->model->get_rate_tax($villa_id)
        ];

        Helpers::render_template('/villa/metabox-price/main', $args);
    }
    public function metabox_conditions($post)
    {
        $villa_id = isset($_GET['post']) ? $_GET['post'] : null;

        $args = [
            'sync' => $this->model->get_conditions_sync($villa_id),
            'data' => $this->model->get_conditions_data($villa_id)
        ];

        Helpers::render_template('/villa/metabox-conditions', $args);
    }
    public function metabox_promotions($post)
    {
        $owner_id = $this->model->get_owner_id($post->ID);
        $owner_promotions = PromotionModel::get_promotions($owner_id);

        $args = [
            'post_id' => $post->ID,
            'owner_promotions' => [],
            'promotions_from_owner' => $this->model->get_promotions_owner($post->ID),
            'promotions_from_villa' => PromotionModel::get_promotions($post->ID),
        ];

        if ($owner_promotions->have_posts()) {
            while ($owner_promotions->have_posts()) {
                $owner_promotions->the_post();
                $args['owner_promotions'][] = [
                    'id' => get_the_ID(),
                    'name' => get_the_title(),
                ];
            }
            wp_reset_postdata();
        }

        Helpers::render_template('/villa/metabox-promotions/main', $args);
    }
    public function metabox_rating($post)
    {
        $villa_id = isset($_GET['post']) ? $_GET['post'] : null;

        $args = [
            'best_choice' => $this->model->get_is_best_choice($villa_id),
            'rating' => $this->model->get_rating($villa_id),
            'reviews' => $this->model->get_reviews($villa_id),
        ];

        Helpers::render_template('/villa/metabox-rating', $args);
    }
    public function metabox_price_night($post)
    {
        $villa_id = isset($_GET['post']) ? $_GET['post'] : null;

        $args = [
            'min_price' => $this->model->get_price_min($villa_id),
            'max_price' => $this->model->get_price_max($villa_id),
        ];

        Helpers::render_template('/villa/metabox-price-night', $args);
    }
    public function page_rating()
    {
        $args['query'] = $this->model->get_villas_no_reviews();

        Helpers::render_template('/villa/page-rating', $args);
    }
}
