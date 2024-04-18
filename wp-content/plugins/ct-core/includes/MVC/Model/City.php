<?php

namespace CTCore\MVC\Model;

class City
{
    /**
     * Get area ID
     *
     * @param int|string $term_id
     * @return int|null
     */
    public static function get_area_id($term_id)
    {
        return get_field(CTCORE_FIELD_CITY_AREA_ID, 'term_' . $term_id) ?: null;
    }

    /**
     * Set area ID
     *
     * @param int|string $term_id
     * @param string $value
     * @return bool
     */
    public static function set_area_id($term_id, $value)
    {
        return update_field(CTCORE_FIELD_CITY_AREA_ID, $value, 'term_' . $term_id);
    }
}
