<?php

namespace CTCore\MVC\Model;

use CTCore\API\FreeCurrency;

class Currency
{
    /* GET */
    public function get_mounth_quota()
    {
        $result = null;
        $FreeCurrency = new FreeCurrency(CTCORE_FREE_CURRENCY_API);
        $status = $FreeCurrency->status();

        if ($status && isset($status['quotas']) && isset($status['quotas']['month'])) {
            $result =  $status['quotas']['month']['remaining'];
        }

        return $result;
    }
    public function get_last_updated()
    {
        return get_option(CTCORE_CURRENCY_LAST_UPDATE) ?: null;
    }
    public static function get_currencies()
    {
        return get_field('currency', 'options');
    }
    public static function get_currency_by_id($currency_id)
    {
        $result = null;
        $currencies = self::get_currencies();

        if ($currencies) {
            $search = array_search($currency_id, array_column($currencies, 'id'));
            $result = $currencies[$search];
        }

        return $result;
    }

    /* SET */
    public static function set_last_updated($value)
    {
        return update_option(CTCORE_CURRENCY_LAST_UPDATE, $value);
    }
}
