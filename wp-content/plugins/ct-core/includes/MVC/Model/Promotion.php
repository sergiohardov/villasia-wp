<?php

namespace CTCore\MVC\Model;

use WP_Query;

class Promotion
{
    /**
     * Get promotions query from related id
     *
     * @param int|string $related_id
     * @return object
     */
    public static function get_promotions($related_id)
    {
        $result = null;

        $args = [
            'post_type' => CTCORE_POST_TYPE_PROMOTION,
            'meta_key' => CTCORE_FIELD_PROMOTION_RELATED_ID,
            'meta_value' => $related_id,
            'posts_per_page' => -1,
        ];

        $result = new WP_Query($args);

        return $result;
    }

    /**
     * Get excluded period dates
     *
     * @param int|string $promotion_id
     * @return array
     */
    // TODO: find call func and remove check is array
    public static function get_exclude_period($promotion_id)
    {
        return get_field(CTCORE_FIELD_PROMOTION_EXCLUDE_PERIOD, $promotion_id) ?: [];
    }

    /**
     * Get the id of the linking post type
     *
     * @param int|string $promotion_id
     * @return int|null
     */
    public static function get_related_id($promotion_id)
    {
        return get_field(CTCORE_FIELD_PROMOTION_RELATED_ID, $promotion_id, true) ?: null;
    }

    /**
     * Set the id of the linking post type
     *
     * @param int|string $promotion_id
     * @return bool
     */
    public function set_related_id($promotion_id, $related_id)
    {
        $post_exists = get_post($related_id, [CTCORE_POST_TYPE_OWNER, CTCORE_POST_TYPE_VILLA]);

        if ($post_exists) {
            return update_field(CTCORE_FIELD_PROMOTION_RELATED_ID, $related_id, $promotion_id);
        } else {
            wp_die('Related post not found!');   // TODO: Set message & no save
            return false;
        }
    }

    /**
     * Get the bookable period data
     *
     * @param int|string $promotion_id
     * @return array
     */
    public static function get_bookable_period($promotion_id)
    {
        return get_field(CTCORE_FIELD_PROMOTION_BOOKABLE_PERIOD, $promotion_id) ?: [];
    }

    /**
     * Get the status of applying the promotion to all beds or not
     *
     * @param int|string $promotion_id
     * @return string
     */
    public static function get_apply_bedroom($promotion_id)
    {
        return get_field(CTCORE_FIELD_PROMOTION_APPLY_BEDROOM, $promotion_id) ?: 'no';
    }

    /**
     * Get the minimum number of nights to qualify for the promotion.
     *
     * @param int|string $promotion_id
     * @return string|null
     */
    // TODO: set return value to int
    public static function get_stay_lenght($promotion_id)
    {
        return get_field(CTCORE_FIELD_PROMOTION_STAY_LENGHT, $promotion_id) ?: null;
    }

    /**
     * Get data for stay dates period.
     *
     * @param int|string $promotion_id
     * @return array
     */
    // TODO: find call func and remove check is array
    public static function get_stay_dates($promotion_id)
    {
        return get_field(CTCORE_FIELD_PROMOTION_STAY_DATES, $promotion_id) ?: [];
    }

    /**
     * Get discount percent.
     *
     * @param int|string $promotion_id
     * @return string|null
     */
    // TODO: set return value to int
    public static function get_discount($promotion_id)
    {
        return get_field(CTCORE_FIELD_PROMOTION_DISCOUNT, $promotion_id) ?: null;
    }

    /**
     * Get rate ID.
     *
     * @param int|string $promotion_id
     * @return string|null
     */
    // TODO: set return value to int
    public static function get_rate_id($promotion_id)
    {
        return get_field(CTCORE_FIELD_PROMOTION_RATE_ID, $promotion_id) ?: null;
    }

    /**
     * Get status of promo can combined
     *
     * @param int|string $promotion_id
     * @return string
     */
    // TODO: set return value to bool
    public static function get_can_combined($promotion_id)
    {
        return get_field(CTCORE_FIELD_PROMOTION_CAN_COMBINED, $promotion_id) ?: 'no';
    }

    /**
     * Get id's list of combined promo
     *
     * @param int|string $promotion_id
     * @return array
     */
    public static function get_combined_ids($promotion_id)
    {
        return get_field(CTCORE_FIELD_PROMOTION_COMBINED_IDS, $promotion_id) ?: [];
    }

    /**
     * Set id's list of combined promo
     *
     * @param int|string $promotion_id
     * @param array $value
     * @return bool
     */
    public static function set_combined_ids($promotion_id, $value = [])
    {
        if (!is_array($value)) return false;

        return update_field(CTCORE_FIELD_PROMOTION_COMBINED_IDS, $value, $promotion_id);
    }
}
