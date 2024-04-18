<?php

/* Theme: ACF */

/**
 * `ACF: Filter` Save fields in json file
 *
 */
function villasia_json_save_point($path)
{
    $path = get_stylesheet_directory() . '/inc/acf-fields';
    return $path;
}
add_filter('acf/settings/save_json', 'villasia_json_save_point');

/**
 * `ACF: Filter` Load fields on json file
 *
 */
function villasia_json_load_point($paths)
{
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/inc/acf-fields';
    return $paths;
}
add_filter('acf/settings/load_json', 'villasia_json_load_point');
