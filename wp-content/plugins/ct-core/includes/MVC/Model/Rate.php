<?php

namespace CTCore\MVC\Model;

use DateTime;
use WP_Query;

class Rate
{
    /* GET */
    public static function get_rates($related_id)
    {
        $args = [
            'post_type' => CTCORE_POST_TYPE_RATE,
            'meta_key' => CTCORE_FIELD_RATE_RELATED_ID,
            'meta_value' => $related_id,
            'posts_per_page' => -1,
        ];

        $query = new WP_Query($args);

        return $query;
    }
    public static function get_periods($rate_id)
    {
        return get_field(CTCORE_FIELD_RATE_SEASONS, $rate_id) ?: [];
    }
    public static function get_valid_until_date($rate_id)
    {
        $result = null;
        $periods = self::get_periods($rate_id);
        $travel_dates = array_column($periods, 'travels_dates');
        $end_dates = [];

        if ($travel_dates) {
            foreach ($travel_dates as $date) {
                array_push($end_dates, ...array_column($date, 'date_end'));
            }
        }

        if ($end_dates) {
            $end_dates = array_map(function ($date) {
                return new DateTime($date);
            }, $end_dates);

            $latest_date = max($end_dates);

            $result = $latest_date->format('d-M-Y');
        }

        return $result;
    }
    public function get_related_id($rate_id)
    {
        return get_field(CTCORE_FIELD_RATE_RELATED_ID, $rate_id, true) ?: null;
    }


    /* SET */
    public function set_related_id($rate_id, $related_id)
    {
        $post_exists = get_post($related_id, [CTCORE_POST_TYPE_OWNER, CTCORE_POST_TYPE_VILLA]);

        if ($post_exists) {
            return update_field(CTCORE_FIELD_RATE_RELATED_ID, $related_id, $rate_id);
        } else {
            wp_die('Related post not found!'); // TODO: Set message & no save
            return false;
        }
    }
}
