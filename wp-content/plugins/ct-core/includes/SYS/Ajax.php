<?php

namespace CTCore\SYS;

use CTCore\API\FreeCurrency;
use CTCore\SYS\Helpers;
use CTCore\MVC\Model\Rate as RateModel;
use CTCore\MVC\Model\Promotion as PromotionModel;
use CTCore\MVC\Model\Owner as OwnerModel;
use CTCore\MVC\Model\Villa as VillaModel;
use CTCore\MVC\Model\Currency as CurrencyModel;

use WP_Query;
use DateTime;
use stdClass;

if (!defined("ABSPATH")) die;

class Ajax
{
    function __construct()
    {
        add_action('wp_ajax_ct_core_js_get_rates_list', [$this, 'ct_core_js_get_rates_list']);
        add_action('wp_ajax_ct_core_js_get_html_price_repeater', [$this, 'ct_core_js_get_html_price_repeater']);
        add_action('wp_ajax_ct_core_js_get_promotions_list', [$this, 'ct_core_js_get_promotions_list']);
        add_action('wp_ajax_ct_core_js_get_owner_area_conditions', [$this, 'ct_core_js_get_owner_area_conditions']);
        add_action('wp_ajax_ct_core_js_update_currency_values', [$this, 'ct_core_js_update_currency_values']);
    }

    /* GET */
    public function ct_core_js_get_rates_list()
    {
        $related_id = isset($_POST['related_id']) ? $_POST['related_id'] : null;
        $result = null;

        if ($related_id) {
            $rates = RateModel::get_rates($related_id);

            if ($rates->have_posts()) {
                while ($rates->have_posts()) {
                    $rates->the_post();
                    $post_id = get_the_ID();
                    $result[$post_id] = get_the_title();
                }
                wp_reset_postdata();
            }

            wp_send_json_success($result);
        } else {
            wp_send_json_error();
        }
    }
    public function ct_core_js_get_html_price_repeater()
    {
        $rate_id = isset($_POST['rate_id']) ? $_POST['rate_id'] : null;

        $args = [
            'rate_id' => null,
            'seasons' => null,
        ];

        if ($rate_id && get_post_type($rate_id) === CTCORE_POST_TYPE_RATE) {
            $args['rate_id'] = $rate_id;
            $args['seasons'] = RateModel::get_periods($rate_id);
        }

        $html = Helpers::render_template('/villa/metabox-price/repeater', $args, false);
        wp_send_json_success($html);
    }
    public function ct_core_js_get_promotions_list()
    {
        $related_id = isset($_POST['related_id']) ? $_POST['related_id'] : null;
        $result = new stdClass();

        if ($related_id) {
            $promotions = PromotionModel::get_promotions($related_id);

            if ($promotions->have_posts()) {
                while ($promotions->have_posts()) {
                    $promotions->the_post();
                    $post_id = get_the_ID();
                    $result->$post_id = get_the_title();
                }
                wp_reset_postdata();
            }

            wp_send_json_success($result);
        } else {
            wp_send_json_error();
        }
    }
    public function ct_core_js_get_owner_area_conditions()
    {
        if (empty($_POST) || !isset($_POST['owner_id']) || !isset($_POST['area_id']))  wp_send_json_error();

        $owner_id = $_POST['owner_id'];
        $area_id = $_POST['area_id'];

        $conditions = OwnerModel::get_conditions($owner_id);
        $result = $conditions[$area_id] ?: null;

        wp_send_json_success($result);
    }

    /* UPDATE */
    public function ct_core_js_update_currency_values()
    {
        $now = new DateTime('now');
        $currencies = get_field('currency', 'options');
        $ids_list = array_column($currencies, 'id');

        if (have_rows('currency', 'options')) {
            $FreeCurrency = new FreeCurrency(CTCORE_FREE_CURRENCY_API);
            $currency_data = $FreeCurrency->latest($ids_list);

            while (have_rows('currency', 'options')) {
                the_row();

                $currency_id = get_sub_field('id');

                if (isset($currency_data[$currency_id])) {
                    update_sub_field('field_659b2b4293bdf', $currency_data[$currency_id]);
                }
            }

            CurrencyModel::set_last_updated($now->format('d-m-Y'));
        }


        wp_send_json_success();
    }
}
