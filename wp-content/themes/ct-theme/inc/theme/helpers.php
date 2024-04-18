<?php if (!defined("ABSPATH")) die;

/* Theme: Helpers */

/**
 * Defines
 */
define('CTTHEME_LANG_TEXT', 'ct-theme');

/**
 * Function for debug anything
 *
 * Result for work function you can find on parent folder your theme in file `debug_helper.log`.
 * 
 * @param  mixed $data
 * @return void
 */
function log_debug($data)
{
    $timestamp = date("Y-m-d H:i:s");
    $log = $timestamp . " - " . print_r($data, true) . "\n";
    error_log($log, 3, get_template_directory() . "/debug_helper.log");
}
