<?php

namespace CTCore\SYS;

class Helpers
{
    public static function log($data)
    {
        $timestamp = date("Y-m-d H:i:s");
        $log = $timestamp . " - " . print_r($data, true) . "\n";
        error_log($log, 3, CTCORE_PLUGIN_PATH . "/log_data.log");
        return null;
    }

    public static function render_template($path, $args = [], $echo = true)
    {
        ob_start();

        $template = CTCORE_TEMPLATES_PATH . $path . '.php';

        if (file_exists($template)) {
            extract($args);
            include $template;
        } else {
            _e('Template not found.', 'ct-theme-core');
        }

        $output = ob_get_clean();

        if ($echo) {
            echo $output;
            return null;
        } else {
            return $output;
        }
    }

    public static function add_post_type($post_type, $labels = [], $params = [])
    {
        if (!post_type_exists($post_type)) {
            register_post_type($post_type, array_merge(['labels' => $labels], $params));
        }
    }

    public static function add_taxonomy($id, $types = [], $labels = [], $params = [])
    {
        if (!taxonomy_exists($id)) {
            register_taxonomy($id, $types, array_merge(['labels' => $labels], $params));
        }
    }

    public static function format_percent($num)
    {
        return $num / 100;
    }

    public static function format_price($num)
    {
        return number_format($num, 2, '.', ',');
    }
}
