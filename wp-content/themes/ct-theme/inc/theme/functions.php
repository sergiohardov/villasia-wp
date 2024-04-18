<?php if (!defined("ABSPATH")) die;

/* Theme: Functions */

function villasia_get_owner_conditions($owner_id)
{
    $conditions = get_field('custom_conditions', $owner_id) ?: null;
    return $conditions;
}
function villasia_get_owner_area_conditions($owner_id, $area_id)
{
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'You are not authorized.'));
    }

    $result = null;

    $conditions = get_field('custom_conditions', $owner_id) ?: null;
    $result = $conditions[$area_id] ?: null;

    return $result;
}

function ct_theme_get_format_location($term)
{
    if (!$term) return;
    $term_obj = get_term($term);

    $name = $term_obj->name;

    if ($term_obj->taxonomy === CTCORE_TAXONOMY_AREA) {
        $country = get_field('country', $term_obj);

        return $country ? get_term($country, CTCORE_TAXONOMY_COUNTRY)->name . ', ' . $name : $name;
    }

    if ($term_obj->taxonomy === CTCORE_TAXONOMY_CITY) {
        $area = get_field('area', $term_obj);

        return $area ? get_term($area, CTCORE_TAXONOMY_AREA)->name . ', ' . $name : $name;
    }

    return $name;
}
function ct_theme_get_term_id_by_name($val)
{
    $args = [
        'taxonomy'   => [CTCORE_TAXONOMY_COUNTRY, CTCORE_TAXONOMY_AREA, CTCORE_TAXONOMY_CITY],
        'fields'     => 'ids',
        'hide_empty' => false,
        'name__like' => $val,
        'number'     => 1,
    ];

    $term_query = new WP_Term_Query($args);
    $terms = $term_query->get_terms();

    return $terms ? $terms[0] : '';
}
function ct_theme_get_the_excerpt($post, $maxchar = 140, $ending = '...')
{
    $excerpt = '';

    if (has_blocks(get_the_content())) {
        $blocks = parse_blocks($post->post_content);

        foreach ($blocks as $block) {
            $excerpt .= wp_strip_all_tags(render_block($block));
        }
    } else {
        $excerpt = get_the_excerpt();
    }

    return wp_html_excerpt($excerpt, $maxchar, $ending);
}
function ct_theme_get_instagram_feed()
{
    $result = null;
    $api = CTCORE_INSTAGRAM_API;
    $limit = 8;
    $url = "https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,thumbnail_url,timestamp&access_token={$api}&limit={$limit}";

    if (!CTCORE_INSTAGRAM_API) return $result;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['data'])) {
        $result = $data['data'];
    }

    return $result;
}
function ct_theme_get_format_price($val)
{
    global $ct_currency;

    $result = $ct_currency['mark'] . number_format($val * $ct_currency['value'], 2, '.', ',') . $ct_currency['mark_right'];

    return $result;
}
function ct_theme_get_calc_price_tax($price, $tax)
{
    $result = null;
    $total = intval($price);

    if ($total > 0) {
        if ($tax['tax_service']) {
            $total += $total * ($tax['tax_service'] / 100);
        }

        if ($tax['tax_rate']) {
            $total += $total * ($tax['tax_rate'] / 100);
        }

        $result = ct_theme_get_format_price($total);
    } else {
        $result = __('Price on Request', CTTHEME_LANG_TEXT);
    }

    return $result;
}
function ct_theme_sort_rates($rates)
{
    $result = [];

    if ($rates) {
        foreach ($rates as $season_id => $season) {
            foreach ($season['travels_dates'] as $travel_date) {
                $result[] = [
                    'season_id' => $season_id,
                    'season_name' => $season['season_name'],
                    'minimum_stay' => $season['minimum_stay'],
                    'date_start' => $travel_date['date_start'],
                    'date_end' => $travel_date['date_end'],
                ];
            }
        }

        usort($result, function ($a, $b) {
            return strtotime($a['date_start']) - strtotime($b['date_start']);
        });
    }

    return $result;
}
