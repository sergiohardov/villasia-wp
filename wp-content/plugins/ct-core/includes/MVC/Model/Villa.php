<?php

namespace CTCore\MVC\Model;

use CTCore\SYS\Helpers;
use CTCore\MVC\Model\Promotion as PromotionModel;
use WP_Query;

class Villa
{
    /* [MAIN] */

    /**
     * Get country ID
     *
     * @param int|string $post_id
     * @return int|null
     */
    public function get_country_id($post_id)
    {
        return get_field(CTCORE_FIELD_VILLA_COUNTRY_ID, $post_id) ?: null;
    }

    /**
     * Set country ID
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_country_id($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_COUNTRY_ID, $value, $post_id);
    }

    /**
     * Get area ID
     *
     * @param int|string $post_id
     * @return int|null
     */
    public static function get_area_id($post_id)
    {
        return get_field(CTCORE_FIELD_VILLA_AREA_ID, $post_id) ?: null;
    }

    /**
     * Set area ID
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_area_id($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_AREA_ID, $value, $post_id);
    }

    /**
     * Get city ID
     *
     * @param int|string $post_id
     * @return int|null
     */
    public function get_city_id($post_id)
    {
        return get_field(CTCORE_FIELD_VILLA_CITY_ID, $post_id) ?: null;
    }

    /**
     * Set city ID
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_city_id($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_CITY_ID, $value, $post_id);
    }

    /**
     * Get owner ID
     *
     * @param int|string $post_id
     * @return int|null
     */
    public function get_owner_id($post_id)
    {
        return get_field(CTCORE_FIELD_VILLA_OWNER_ID, $post_id) ?: null;
    }

    /**
     * Set owner ID
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_owner_id($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_OWNER_ID, $value, $post_id);
    }

    /**
     * Get bedrooms value
     *
     * @param int|string $post_id
     * @return string|null
     */
    // TODO: Refactor return value to int|null
    public function get_bedrooms($post_id)
    {
        return get_field(CTCORE_FIELD_VILLA_BEDROOMS, $post_id) ?: null;
    }

    /**
     * Set bedrooms value
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_bedrooms($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_BEDROOMS, $value, $post_id);
    }

    /**
     * Set bathrooms value
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_bathrooms($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_BATHROOMS, $value, $post_id);
    }

    /**
     * Set guests value
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_guests($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_GUESTS, $value, $post_id);
    }

    /**
     * Get map data
     *
     * @param int|string $villa_id
     * @return array|null
     */
    public static function get_map($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_MAP, $villa_id) ?: null;
    }

    /**
     * Set map data
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_map($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_MAP, $value, $post_id);
    }

    /**
     * Get ical link
     *
     * @param int|string $post_id
     * @return string|null
     */
    // TODO: Refactor return value to int|null
    public static function get_ical_link($post_id)
    {
        return get_field(CTCORE_FIELD_VILLA_ICAL, $post_id) ?: null;
    }

    /**
     * Set ical link
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_ical_link($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_ICAL, $value, $post_id);
    }

    /**
     * Get place ID value
     *
     * @param int|string $post_id
     * @return string|null
     */
    public static function get_place_id($post_id)
    {
        return get_field(CTCORE_FIELD_VILLA_PLACE_ID, $post_id) ?: null;
    }

    /**
     * Set place ID value
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_place_id($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_PLACE_ID, $value, $post_id);
    }

    /**
     * Set text description
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_description($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_DESCRIPTION, $value, $post_id);
    }

    /**
     * Set text around villa
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_around($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_AROUND, $value, $post_id);
    }

    /**
     * Set text capacity
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_capacity($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_CAPACITY, $value, $post_id);
    }

    /**
     * Set gallery images
     *
     * @param int|string $post_id
     * @param string $value
     * @return bool
     */
    public static function set_gallery($post_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_GALLERY, $value, $post_id);
    }

    /* [Price] */

    /**
     * Get sync rate status with owner
     *
     * @param int|string $villa_id
     * @return string
     */
    // TODO: Refactor return value to boolean
    public static function get_rates_sync($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_RATE_SYNC, $villa_id) ?: 'no';
    }

    /**
     * Set sync rate status with owner
     *
     * @param int|string $villa_id
     * @param string $value
     * @return bool
     */
    public function set_rates_sync($villa_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_RATE_SYNC, $value, $villa_id);
    }

    /**
     * Get rate card ID
     *
     * @param int|string $villa_id
     * @return string|null
     */
    // TODO: Refactor return value to int|null
    public function get_rate_card_id($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_RATE_ID, $villa_id) ?: null;
    }

    /**
     * Set rate card ID
     *
     * @param int|string $villa_id
     * @param string $value
     * @return bool
     */
    public function set_rate_card_id($villa_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_RATE_ID, $value, $villa_id);
    }

    /**
     * Get table of prices
     *
     * @param int|string $villa_id
     * @return array|null
     */
    public function get_price_list($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_PRICE, $villa_id) ?: null;
    }

    /**
     * Set table of prices
     *
     * @param int|string $villa_id
     * @param array $data
     * @return bool
     */
    public function set_price_list($villa_id, $data)
    {
        return update_field(CTCORE_FIELD_VILLA_PRICE, $data, $villa_id);
    }

    /**
     * Get minimum price
     *
     * @param int|string $villa_id
     * @return string|null
     */
    // TODO: Refactor return value to int|null
    public function get_price_min($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_PRICE_MIN, $villa_id) ?: null;
    }

    /**
     * Set minimum price
     *
     * @param int|string $villa_id
     * @param string $value
     * @return bool
     */
    public function set_price_min($villa_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_PRICE_MIN, $value, $villa_id);
    }

    /**
     * Get maximum price
     *
     * @param int|string $villa_id
     * @return string|null
     */
    // TODO: Refactor return value to int|null
    public function get_price_max($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_PRICE_MAX, $villa_id) ?: null;
    }

    /**
     * Set maximum price
     *
     * @param int|string $villa_id
     * @param string $value
     * @return bool
     */
    public function set_price_max($villa_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_PRICE_MAX, $value, $villa_id);
    }

    /**
     * Set minimum & maximum price from villa price list 
     *
     * @param int|string $villa_id
     * @param array $price_list
     * @param string $tax_service
     * @param string $tax_rate
     * @return void
     */
    public function set_price_min_max($villa_id, $price_list, $tax_service, $tax_rate)
    {
        $min_price = null;
        $max_price = null;

        if ($price_list) {
            $prices = array_reduce($price_list, function ($acc, $item) {
                if (isset($item['seasons'])) {
                    return array_merge($acc, array_filter($item['seasons']));
                } else {
                    return $acc;
                }
            }, []);

            $min_price = $prices ? min($prices) : null;
            $max_price = $prices ? max($prices) : null;
        }

        if ($min_price) {
            if ($tax_service) {
                $min_price = $min_price * (Helpers::format_percent($tax_service) + 1);
            }

            if ($tax_rate) {
                $min_price = $min_price * (Helpers::format_percent($tax_rate) + 1);
            }
        }

        if ($max_price) {
            if ($tax_service) {
                $max_price = $max_price * (Helpers::format_percent($tax_service) + 1);
            }

            if ($tax_rate) {
                $max_price = $max_price * (Helpers::format_percent($tax_rate) + 1);
            }
        }

        $this->set_price_min($villa_id, $min_price);
        $this->set_price_max($villa_id, $max_price);

        return;
    }

    /**
     * Get tax of service
     *
     * @param int|string $villa_id
     * @return string|null
     */
    // TODO: Refactor return value to int|null
    public function get_service_tax($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_TAX_SERVICE, $villa_id) ?: null;
    }

    /**
     * Set tax of service
     *
     * @param int|string $villa_id
     * @param string $value
     * @return bool
     */
    public function set_service_tax($villa_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_TAX_SERVICE, $value, $villa_id);
    }

    /**
     * Get tax of rate
     *
     * @param int|string $villa_id
     * @return string|null
     */
    // TODO: Refactor return value to int|null
    public function get_rate_tax($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_TAX_RATE, $villa_id) ?: null;
    }

    /**
     * Set tax of rate
     *
     * @param int|string $villa_id
     * @param string $value
     * @return bool
     */
    public function set_rate_tax($villa_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_TAX_RATE, $value, $villa_id);
    }

    /* [Conditions] */

    /**
     * Get sync status with owner for conditions
     *
     * @param int|string $villa_id
     * @return string
     */
    // TODO: Refactor return value to boolean
    public static function get_conditions_sync($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_CONDITIONS_SYNC, $villa_id) ?: 'no';
    }

    /**
     * Set sync status with owner for conditions
     *
     * @param int|string $villa_id
     * @param string $villa_id
     * @return bool
     */
    public function set_conditions_sync($villa_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_CONDITIONS_SYNC, $value, $villa_id);
    }

    /**
     * Get conditions data
     *
     * @param int|string $villa_id
     * @return array
     */
    public function get_conditions_data($villa_id)
    {
        $data = [
            'rental' => '',
            'reservation' => '',
            'cancellation' => ''
        ];

        return get_field(CTCORE_FIELD_VILLA_CONDITIONS_DATA, $villa_id) ?: $data;
    }

    /**
     * Set conditions data
     *
     * @param int|string $villa_id
     * @param string (json) $conditions
     * @return bool
     */
    public function set_conditions_data($villa_id, $conditions)
    {
        $data = json_decode(html_entity_decode(stripslashes($conditions)), true);

        return update_field(CTCORE_FIELD_VILLA_CONDITIONS_DATA, $data, $villa_id);
    }

    /* [Promotions] */

    /**
     * Get list id's promotions which sync by owner
     * 
     * @param int|string $villa_id
     * @return array
     */
    public static function get_promotions_owner($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_PROMOTIONS_OWNER, $villa_id) ?: [];
    }

    /**
     * Set list id's promotions which sync by owner
     * 
     * @param int|string $villa_id
     * @param array $value
     * @return bool
     */
    public function set_promotions_owner($villa_id, $value)
    {
        $result = [];

        if ($value) {
            $result = [...array_filter($value)];
            $result = array_unique($result);
        }

        return update_field(CTCORE_FIELD_VILLA_PROMOTIONS_OWNER, $result, $villa_id);
    }

    /**
     * Get all promotions ids in array list
     * 
     * @param int|string $villa_id
     * @return array
     */
    public function get_promotions_id_list($villa_id)
    {
        $promotion_ids = [];

        $promotions_from_owner = $this->get_promotions_owner($villa_id);
        $promotions_from_villa = PromotionModel::get_promotions($villa_id);

        array_push($promotion_ids, ...$promotions_from_owner);

        if ($promotions_from_villa->have_posts()) {
            while ($promotions_from_villa->have_posts()) {
                $promotions_from_villa->the_post();
                $promotion_ids[] = get_the_ID();
            }

            wp_reset_postdata();
        }

        return $promotion_ids;
    }

    /**
     * Get status of villa have promotions or not
     * 
     * @param int|string $villa_id
     * @return string|null
     */
    // TODO: Refactor return value to boolean
    public function get_has_promotions($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_HAS_PROMOTIONS, $villa_id) ?: null;
    }

    /**
     * Set status of villa have promotions or not
     * 
     * @param int|string $villa_id
     * @return bool
     */
    // TODO: After add set_promotions_owner, need testing
    public static function set_has_promotions($villa_id)
    {
        if (get_post_type($villa_id) !== CTCORE_POST_TYPE_VILLA) return false;

        $result = 0;

        $promotions_from_owner = self::get_promotions_owner($villa_id);
        $promotions_from_villa = PromotionModel::get_promotions($villa_id);

        if ($promotions_from_owner || $promotions_from_villa->have_posts()) {
            $result = 1;
        }

        return update_field(CTCORE_FIELD_VILLA_HAS_PROMOTIONS, $result, $villa_id);
    }

    /* [Google Reviews] */

    /**
     * Get villa best choice status
     * 
     * @param int|string $villa_id
     * @return null|string 
     */
    public static function get_is_best_choice($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_BEST_CHOICE, $villa_id) ?: null;
    }

    /**
     * Set villa best choice status
     * 
     * @param int|string $villa_id
     * @param null|string $value
     * @return bool
     */
    public static function set_is_best_choice($villa_id, $value)
    {
        $result = null;

        if ($value === 'on') {
            $rating = self::get_rating($villa_id);

            if ($rating && floatval($rating) > 4.2) {
                $result = true;
            }
        }

        return update_field(CTCORE_FIELD_VILLA_BEST_CHOICE, $result, $villa_id);
    }

    /**
     * Get google rating value
     * 
     * @param int|string $villa_id
     * @return string|null
     */
    // TODO: Refactor return value to int|null
    public static function get_rating($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_RATING, $villa_id) ?: null;
    }

    /**
     * Set google rating value
     * 
     * @param int|string $villa_id
     * @param string $value
     * @return bool
     */
    public static function set_rating($villa_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_RATING, $value, $villa_id);
    }

    /**
     * Get google reviews
     * 
     * @param int|string $villa_id
     * @return array|null
     */
    public function get_reviews($villa_id)
    {
        return get_field(CTCORE_FIELD_VILLA_REVIEWS, $villa_id) ?: null;
    }

    /**
     * Set google reviews
     * 
     * @param int|string $villa_id
     * @param array $value
     * @return bool
     */
    public static function set_reviews($villa_id, $value)
    {
        return update_field(CTCORE_FIELD_VILLA_REVIEWS, $value, $villa_id);
    }

    /**
     * Get query villas with no reviews
     * 
     * @return object WP_Query
     */
    public function get_villas_no_reviews()
    {
        $args = [
            'post_type'      => CTCORE_POST_TYPE_VILLA,
            'posts_per_page' => -1,
            'meta_query'     => [
                'relation' => 'OR',
                [
                    'key'     => CTCORE_FIELD_VILLA_RATING,
                    'value'   => '',
                    'compare' => '==',
                ],
                [
                    'key'     => CTCORE_FIELD_VILLA_RATING,
                    'compare' => 'NOT EXISTS',
                ],
                [
                    'key'     => CTCORE_FIELD_VILLA_REVIEWS,
                    'value'   => '',
                    'compare' => '==',
                ],
                [
                    'key'     => CTCORE_FIELD_VILLA_REVIEWS,
                    'compare' => 'NOT EXISTS',
                ],
            ]
        ];

        $query = new WP_Query($args);

        return $query;
    }
}
