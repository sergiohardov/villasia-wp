<?php

namespace CTCore\MVC\Controller;

use CTCore\SYS\Helpers;
use CTCore\MVC\Model\Villa as ModelVilla;
use CTCore\MVC\Model\Rate as ModelRate;
use CTCore\MVC\Model\Promotion as PromotionModel;
use CTCore\MVC\Model\Currency as CurrencyModel;

use DateTime;
use DateInterval;
use DatePeriod;

class Price
{
    // Constants for text messages
    const TEXT_PRICE_REQUEST = 'Price on Request';
    const TEXT_PRICE_FROM = 'From ';
    const TEXT_INCLUSIVE_TAX = 'Inclusive of taxes and service charges';
    const TEXT_NIGHTS = 'Nights';
    const TEXT_CONTACT = '(Contact us for more details)';

    // Class properties
    public $model;
    public $villa_id;
    public $currency;

    public $check_in, $check_out, $bedroom;

    public $price_list, $tax_service, $tax_rate, $rate_id, $has_promo;

    public $nights = 0;

    public $result = [
        'price' => null,
        'old_price' => null,
        'nights' => null,
        'sub' => null,
        'discount' => null
    ];

    /**
     * Constructor method for initializing the Price class.
     *
     * @param int|string $villa_id - The ID of the villa.
     * @param string|null $check_in - Check-in date (optional).
     * @param string|null $check_out - Check-out date (optional).
     * @param int|null $bedroom - Number of bedrooms (optional).
     */
    function __construct($villa_id, $check_in = null, $check_out = null, $bedroom = null)
    {
        $this->model = new ModelVilla();
        $this->villa_id = $villa_id;
        $this->currency = CurrencyModel::get_currency_by_id(CTCORE_CURRENT_CURRENCY_ID);

        $this->check_in = $check_in ? new DateTime($check_in) : null;
        $this->check_out = $check_out ? new DateTime($check_out) : null;
        $this->bedroom = $bedroom ? intval($bedroom) : 0;

        $this->rate_id = $this->model->get_rate_card_id($villa_id);
        $this->price_list = $this->model->get_price_list($villa_id);
        $this->tax_service = $this->model->get_service_tax($villa_id);
        $this->tax_rate = $this->model->get_rate_tax($villa_id);
        $this->has_promo = $this->model->get_has_promotions($villa_id);

        if ($this->check_in && $this->check_out) {
            $this->nights = $this->check_in->diff($this->check_out)->days;
        }
    }

    /**
     * Main class function that returns the result based on different scenarios.
     *
     * @return array - Result array containing pricing details.
     */
    public function get_price()
    {
        // Conditions for use necessary scenario function
        if (!$this->price_list) {
            $this->scenario_fourth();
        } else if ($this->price_list && !$this->check_in && !$this->check_out) {
            $this->scenario_third();
        } else if ($this->price_list && $this->check_in && $this->check_out && !$this->has_promo) {
            $this->scenario_second();
        } else if ($this->price_list && $this->check_in && $this->check_out && $this->has_promo) {
            $this->scenario_first();
        }

        return $this->result;
    }

    /**
     * The user has entered their travel dates, the villa has a rate card, and some discounts are available.
     */
    public function scenario_first()
    {
        $total = 0; // Total villa price.
        $total_original = 0; // Total without promotion villa price.
        $nights_data = $this->get_nights_data();
        $promotions_data = $this->get_promotions_data();

        // Create array with seasons ids
        $season_ids = array_column($nights_data, 'season_id');

        // If seasons ids not have days out of any season
        if (!in_array(-1, $season_ids)) {
            /* BEDROOMS */
            // If bedrooms entry or not
            if ($this->bedroom > 0) {
                // Find id in price list which matches entered bedrooms
                $bedroom_price_id = array_search($this->bedroom, array_column($this->price_list, 'bedrooms'));

                // If id finded
                // Else id not find - we cant sum final price
                if ($bedroom_price_id !== false) {
                    // Season prices are appropriate entered bedrooms
                    $bedroom_seasons_prices = $this->price_list[$bedroom_price_id]['seasons'];

                    foreach ($nights_data as $item) {
                        $season_id = $item['season_id'];
                        $days = $item['days'];
                        $price_night = $bedroom_seasons_prices[$season_id] ?: 0;


                        if ($days) {
                            foreach ($days as $day) {
                                $discount_percent = $this->get_discount_percent($day, $promotions_data);

                                if ($discount_percent) {
                                    $total += $price_night - ($price_night * Helpers::format_percent(max($discount_percent)));
                                } else {
                                    $total += $price_night;
                                }

                                $total_original += $price_night;
                            }
                        }
                    }
                }
            } else {
                foreach ($nights_data as $item) {
                    $season = isset($this->price_list[$item['season_id']]) ? $this->price_list[$item['season_id']] : false;
                    $season_prices = $season ? array_filter($season['seasons']) : false;
                    $min = $season_prices ? min($season['seasons']) : 0;

                    $total += $min * count($item['days']);
                }
            }
        }

        /* TAX */
        if ($total > 0) {
            if ($this->tax_service) {
                $total += $total * Helpers::format_percent($this->tax_service);
                $this->result['sub'] = self::TEXT_INCLUSIVE_TAX;
            }
            if ($this->tax_rate) {
                $total += $total * Helpers::format_percent($this->tax_rate);
                $this->result['sub'] = self::TEXT_INCLUSIVE_TAX;
            }
        }

        if ($total_original > 0) {
            if ($this->tax_service) {
                $total_original += $total_original * Helpers::format_percent($this->tax_service);
                $this->result['sub'] = self::TEXT_INCLUSIVE_TAX;
            }
            if ($this->tax_rate) {
                $total_original += $total_original * Helpers::format_percent($this->tax_rate);
                $this->result['sub'] = self::TEXT_INCLUSIVE_TAX;
            }
        }

        /* TOTAL */
        if ($total > 0) {
            if ($total_original > 0  && $total_original > $total) {
                $this->result['old_price'] = $this->currency['mark'] . Helpers::format_price($total_original * $this->currency['value']);
                $this->result['discount'] = round((($total_original - $total) / $total_original) * 100, 1);
            }

            if ($this->nights > 0) {
                $this->result['nights'] = '(' . $this->nights . ' ' . self::TEXT_NIGHTS . ')';
            }

            if ($this->bedroom > 0) {
                $this->result['price'] = $this->currency['mark'] . Helpers::format_price($total * $this->currency['value']) . $this->currency['mark_right'];
            } else {
                $this->result['price'] = self::TEXT_PRICE_FROM . $this->currency['mark'] . Helpers::format_price($total * $this->currency['value']) . $this->currency['mark_right'];
            }
        } else {
            $this->result['price'] = self::TEXT_PRICE_REQUEST;
            $this->result['sub'] = self::TEXT_CONTACT;
        }
    }

    /**
     * The user has entered their travel dates, the villa has a rate card, but no discounts are available.
     */
    public function scenario_second()
    {
        $total = 0; // Total villa price.
        $price_exact = false; // False or true depends on whether the bedrooms were chosen or not. 
        $nights_data = $this->get_nights_data();

        /* BEDROOMS */
        // If bedrooms entry or not
        if ($this->bedroom > 0) {
            // Find id in price list which matches entered bedrooms
            $price_item_id = array_search($this->bedroom, array_column($this->price_list, 'bedrooms'));

            // If id finded
            // Else id not find - we cant sum final price
            if ($price_item_id !== false) {
                // Season prices are appropriate entered bedrooms
                $bedroom_seasons_prices = $this->price_list[$price_item_id]['seasons'];

                foreach ($nights_data as $item) {
                    // If nigts of check-in check-out not cross with season - we cant sum final price
                    // Else nights of check-in check-out crossed with season - sum the final price
                    if ($item['season_id'] === -1) {
                        $total = 0;
                        break;
                    } else {
                        // Clear price of entered bedrooms & season
                        $season_price = $bedroom_seasons_prices[$item['season_id']];

                        // If season price exist - all done
                        // Else season price not exist - we cant sum final price
                        if ($season_price) {
                            $price_exact = true;
                            $total += $bedroom_seasons_prices[$item['season_id']] * count($item['days']);
                        } else {
                            $total = 0;
                            break;
                        }
                    }
                }
            } else {
                $total = 0;
            }
        } else {
            $price_exact = false;
            $seasons_prices = array_column($this->price_list, 'seasons');  // Collect all seasons - prices

            foreach ($nights_data as $item) {
                // If nights of check-in check-out not cross with season - we cant sum final price
                // Else nights of check-in check-out crossed with season - sum the final price
                if ($item['season_id'] === -1) {
                    $total = 0;
                    break;
                } else {
                    // Filter empty fields
                    $prices = array_filter(array_column($seasons_prices, $item['season_id']));

                    // If we have season prices arr - find min price & sum
                    // Else season prices empty or not have - we cant sum final price
                    if ($prices) {
                        $min = min($prices) ?: 0;
                        $total += $min * count($item['days']);
                    } else {
                        $total = 0;
                        break;
                    }
                }
            }
        }

        /* TAX */
        if ($total > 0) {
            if ($this->tax_service) {
                $total += $total * Helpers::format_percent($this->tax_service);
                $this->result['sub'] = self::TEXT_INCLUSIVE_TAX;
            }
            if ($this->tax_rate) {
                $total += $total * Helpers::format_percent($this->tax_rate);
                $this->result['sub'] = self::TEXT_INCLUSIVE_TAX;
            }
        }

        /* TOTAL */
        if ($total > 0) {

            if ($this->nights > 0) {
                $this->result['nights'] = '(' . $this->nights . ' ' . self::TEXT_NIGHTS . ')';
            }

            if ($price_exact) {
                $this->result['price'] = $this->currency['mark'] . Helpers::format_price($total * $this->currency['value']) . $this->currency['mark_right'];
            } else {
                $this->result['price'] = self::TEXT_PRICE_FROM . $this->currency['mark'] . Helpers::format_price($total * $this->currency['value']) . $this->currency['mark_right'];
            }
        } else {
            $this->result['price'] = self::TEXT_PRICE_REQUEST;
            $this->result['sub'] = self::TEXT_CONTACT;
        }
    }

    /**
     * The user provided no travel dates and the villa has a rate card (whatever if there are some applicable discounts).
     */
    public function scenario_third()
    {
        $total = 0;
        $all_prices = [];

        /* BEDROOMS */
        // If bedrooms entry or not
        if ($this->bedroom > 0) {
            $price_list_bedroom_id = array_search($this->bedroom, array_column($this->price_list, 'bedrooms'));

            // Get prices for select bedrooms
            if ($price_list_bedroom_id !== false) {
                $all_prices = $this->price_list[$price_list_bedroom_id]['seasons'];
            }
        } else {
            // Get all prices
            foreach ($this->price_list as $item) {
                if (isset($item['seasons'])) {
                    array_push($all_prices, ...$item['seasons']);
                }
            }
        }

        // Get minimum price
        if (array_filter($all_prices)) {
            $total = min(array_filter($all_prices)) ?: 0;
        }

        /* TAX */
        if ($total > 0) {
            if ($this->tax_service) {
                $total += $total * Helpers::format_percent($this->tax_service);
                $this->result['sub'] = self::TEXT_INCLUSIVE_TAX;
            }
            if ($this->tax_rate) {
                $total += $total * Helpers::format_percent($this->tax_rate);
                $this->result['sub'] = self::TEXT_INCLUSIVE_TAX;
            }
        }

        /* TOTAL */
        if ($total > 0) {
            $this->result['price'] = self::TEXT_PRICE_FROM . $this->currency['mark'] . Helpers::format_price($total * $this->currency['value']) . $this->currency['mark_right'];
        } else {
            $this->result['price'] = self::TEXT_PRICE_REQUEST;
            $this->result['sub'] = self::TEXT_CONTACT;
        }
    }

    /**
     * The villa rates are available upon request (no rate card).
     */
    public function scenario_fourth()
    {
        /* TOTAL */
        $this->result['price'] = self::TEXT_PRICE_REQUEST;
        $this->result['sub'] = self::TEXT_CONTACT;
    }

    /**
     * Helper function to retrieve nights/periods data based on check-in and check-out dates.
     *
     * @return array - Array containing nights/periods data.
     */
    public function get_nights_data()
    {
        // TODO: Optimaze this func get_nights_data & get_season_by_day becouse more loops for all villas, any idea up this logic out of class

        $result = [];
        $seasons = ModelRate::get_periods($this->rate_id);
        $period = new DatePeriod($this->check_in, DateInterval::createFromDateString('1 day'), $this->check_out);

        $in_season = [];
        $out_season = [];

        foreach ($period as $day) {
            $season_id = $this->get_season_by_day($day, $seasons);

            if ($season_id !== -1) {
                $in_season[$season_id]['season_id'] = $season_id;
                $in_season[$season_id]['days'][] = $day;
            } else {
                $out_season[] = $day;
            }
        }

        foreach ($in_season as $value) {
            $season_id = $value['season_id'];
            $minimum_stay = $seasons[$season_id]['minimum_stay'];

            if (count($value['days']) >= $minimum_stay) {
                $result[] = $value;
            } else {
                array_push($out_season, ...$value['days']);
            }
        }

        if ($out_season) {
            $result[] = [
                'season_id' => -1,
                'days' => $out_season
            ];
        }

        return $result;
    }

    /**
     * Helper function to retrieve the season ID based on a given day and seasons data.
     *
     * @param DateTime $day - The day for which the season ID needs to be determined.
     * @param array $seasons - Array containing seasons data.
     * @return int - The season ID.
     */
    public function get_season_by_day($day, $seasons)
    {
        $result = -1;

        if ($seasons) {
            foreach ($seasons as $id => $season) {
                foreach ($season['travels_dates'] as $travel_date) {
                    $start = new DateTime($travel_date['date_start']);
                    $end = new DateTime($travel_date['date_end']);

                    if ($day >= $start && $day <= $end) {
                        $result = $id;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Helper function to retrieve promotions data for the given villa.
     *
     * @return array - Array containing promotions data.
     */
    public function get_promotions_data()
    {
        $result = [];

        $promotions = $this->model->get_promotions_id_list($this->villa_id);
        $child_promotions = [];

        if ($promotions) {
            foreach ($promotions as $promotion_id) {
                $result[$promotion_id] = $this->get_promotion_fields($promotion_id);

                if ($result[$promotion_id]['child_promotion']) {
                    foreach ($result[$promotion_id]['child_promotion'] as $child_id => $child_data) {
                        $child_promotions[] = $child_id;
                    }
                }
            }
        }

        if ($child_promotions) {
            foreach ($child_promotions as $child_promotion) {
                unset($result[$child_promotion]);
            }
        }

        return $result;
    }

    /**
     * Helper recursive function to get promotion data.
     *
     * @param int|string $promotion_id - ID of promotion.
     * @return array - Array of all promotions data.
     */
    public function get_promotion_fields($promotion_id)
    {
        $promotion_data = [
            'apply_bedrooms' => PromotionModel::get_apply_bedroom($promotion_id),
            'stay_dates' => PromotionModel::get_stay_dates($promotion_id),
            'excluded_period' => PromotionModel::get_exclude_period($promotion_id),
            'lenght_of_stay' => PromotionModel::get_stay_lenght($promotion_id),
            'discount' => PromotionModel::get_discount($promotion_id),
            'bookable_period' => PromotionModel::get_bookable_period($promotion_id),
            'child_promotion' => []
        ];

        $can_comine = PromotionModel::get_can_combined($promotion_id);

        if ($can_comine === 'yes') {
            $combine_ids = PromotionModel::get_combined_ids($promotion_id);

            if ($combine_ids) {
                foreach ($combine_ids as $combine_id) {
                    $promotion_data['child_promotion'][$combine_id] = $this->get_promotion_fields($combine_id);
                }
            }
        }

        return $promotion_data;
    }

    /**
     * Helper function to get an array of discount percentage for a specific day based on promotions data.
     *
     * @param DateTime $day - The day for which you want to receive the discount percentage.
     * @param array $promotions - Array containing promotions data.
     * @return array - The discount percentage array.
     */
    public function get_discount_percent($day, $promotions)
    {
        $all_discount = [];

        if ($promotions) {
            foreach ($promotions as $promotion) {

                // 1. If the promotion has apply bedrooms no and $is_max_bedrooms = false - then we cut it off
                if ($promotion['apply_bedrooms'] === 'no' && $this->check_is_max_bedrooms() === false) continue;

                // 2.1 If the user’s days are less than the minimum value, then we cut off
                if ($this->nights < $promotion['lenght_of_stay']) continue;

                // 2.2 If the current day is not included in the bookable period, then we cut it off
                if ($this->check_is_day_in_bookable_period($promotion['bookable_period']) === false) continue;

                // 2.3 If the current day is not included in the stay dates, then cut off
                if ($this->check_is_period_in_stay_dates($promotion['stay_dates']) === false) continue;

                // 2.4 If the current day falls into the excluded period, then we cut it off
                if ($this->check_is_day_in_excluded_period($promotion['excluded_period'], $day) === true) continue;

                // 3. If the promotion does not have combined promotions, get a discount and write it to $all_discount; 4. Otherwise, we go through all the combined promotions and get the data as in steps 1,2,3
                if ($promotion['child_promotion']) {
                    $parent_discount = $promotion['discount'];
                    $child_discounts = $this->get_discount_percent($day, $promotion['child_promotion']);

                    $all_discount[] = array_sum($child_discounts) + $parent_discount;
                } else {
                    $all_discount[] = $promotion['discount'];
                }
            }
        }

        return $all_discount;
    }

    public function check_is_max_bedrooms()
    {
        $result = false;

        $max_bedroom_count = max(array_filter(array_column($this->price_list, 'bedrooms'))) ?: -1;

        if ($this->bedroom === intval($max_bedroom_count)) {
            $result = true;
        }

        return $result;
    }
    public function check_is_day_in_bookable_period($bookable_period)
    {
        $date_now = new DateTime('now');
        $result = false;

        if ($bookable_period['type'] === 'period') {
            $start = $bookable_period['period']['start'] ? new DateTime($bookable_period['period']['start']) : null;
            $end = $bookable_period['period']['end'] ? new DateTime($bookable_period['period']['end']) : null;

            if ($start && $end) {
                if ($start <= $date_now && $date_now <= $end) {
                    $result = true;
                }
            }
        } else if ($bookable_period['type'] === 'days') {
            $advance = $bookable_period['days']['advance'] ?: null;
            $before = $bookable_period['days']['before'] ?: null;

            if ($advance && $before) {
                $diff = $date_now->diff($this->check_in)->days;
                $end = $date_now->add(new DateInterval('P' . $before . 'D')); // TODO: Need clear date 00:00:00

                if ($diff >= $advance && $this->check_in <= $end) {
                    $result = true;
                }
            } else if ($advance) {
                $diff = $date_now->diff($this->check_in)->days;

                if ($diff >= $advance) {
                    $result = true;
                }
            } else if ($before) {
                $end = $date_now->add(new DateInterval('P' . $before . 'D')); // TODO: Need clear date 00:00:00

                if ($this->check_in <= $end) {
                    $result = true;
                }
            }
        }

        return $result;
    }
    public function check_is_period_in_stay_dates($stay_dates)
    {
        $result = false;

        if ($stay_dates['start'] && $stay_dates['end']) {
            $start = new DateTime($stay_dates['start']);
            $end = new DateTime($stay_dates['end']);

            if ($start <= $this->check_in && $this->check_in <= $end && $start <= $this->check_out && $this->check_out <= $end) {
                $result = true;
            }
        }

        return $result;
    }
    public function check_is_day_in_excluded_period($exclude_period, $day)
    {
        $result = false;

        $exclude_date_start = $exclude_period['start'] ? new DateTime($exclude_period['start']) : null;
        $exclude_date_end = $exclude_period['end'] ? new DateTime($exclude_period['end']) : null;

        if ($exclude_date_start && $exclude_date_end) {
            if ($exclude_date_start <= $day && $day <= $exclude_date_end) {
                $result = true;
            }
        }

        return $result;
    }
}
