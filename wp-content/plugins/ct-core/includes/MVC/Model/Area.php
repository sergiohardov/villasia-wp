<?php

namespace CTCore\MVC\Model;

class Area
{
    /**
     * Get country ID
     *
     * @param int|string $term_id
     * @return int|null
     */
    public static function get_country_id($term_id)
    {
        return get_field(CTCORE_FIELD_AREA_COUNTRY_ID, 'term_' . $term_id) ?: null;
    }

    /**
     * Set country ID
     *
     * @param int|string $term_id
     * @param string $value
     * @return bool
     */
    public static function set_country_id($term_id, $value)
    {
        return update_field(CTCORE_FIELD_AREA_COUNTRY_ID, $value, 'term_' . $term_id);
    }
}
