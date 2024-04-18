<?php

namespace CTCore\MVC\Model;

use WP_Query;

class Owner
{
    public static function get_conditions($owner_id)
    {
        return get_field(CTCORE_FIELD_OWNER_CONDITIONS, $owner_id, true) ?: [];
    }

    public function get_locations($owner_id)
    {
        return get_field(CTCORE_FIELD_OWNER_LOCATIONS, $owner_id) ?: [];
    }

    public function get_villas($owner_id)
    {
        $args = [
            'post_type' => CTCORE_POST_TYPE_VILLA,
            'meta_key' => CTCORE_FIELD_VILLA_OWNER_ID,
            'meta_value' => $owner_id,
            'posts_per_page' => -1,
        ];

        $query = new WP_Query($args);

        return $query;
    }

    public function get_locations_sort($owner_id)
    {
        return get_field(CTCORE_FIELD_OWNER_LOCATIONS_SORT, $owner_id) ?: null;
    }

    public function set_locations_sort($owner_id, $locations)
    {
        $result = '';

        if ($locations) {
            $arr = [];

            foreach ($locations as $location) {
                $arr[] = get_term($location)->name;
            }

            sort($arr);

            $result = join(', ', $arr);
        }

        return update_field(CTCORE_FIELD_OWNER_LOCATIONS_SORT, $result, $owner_id);
    }

    public function update_conditions($owner_id, $conditions)
    {
        $result = [];

        $locations = $this->get_locations($owner_id);
        $data = json_decode(html_entity_decode(stripslashes($conditions)), true);

        if ($locations) {
            foreach ($locations as $location) {
                $result[$location] = $data[$location];
            }
        }

        return update_field(CTCORE_FIELD_OWNER_CONDITIONS, $result, $owner_id);
    }
}
