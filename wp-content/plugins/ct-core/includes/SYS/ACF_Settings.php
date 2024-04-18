<?php

namespace CTCore\SYS;

if (!defined("ABSPATH")) die;

class ACF_Settings
{
    function __construct()
    {
        add_action('acf/init', [$this, 'register_map_api_key']);
        add_action('acf/init', [$this, 'add_settings_pages']);
    }

    public function register_map_api_key()
    {
        acf_update_setting('google_api_key', CTCORE_GOOGLE_MAPS_API);
    }

    public function add_settings_pages()
    {
        acf_add_options_page([
            'page_title'    => 'Settings: Currency',
            'menu_title'    => 'Currency',
            'menu_slug'     => 'ct-core-currency',
            'capability'    => 'edit_posts',
            'redirect'      => false,
            'icon_url'      => 'dashicons-money-alt',
            'position'      => '104'
        ]);

        acf_add_options_page([
            'page_title'    => 'Settings: Global',
            'menu_title'    => 'Global',
            'menu_slug'     => 'theme-settings-global',
            'capability'    => 'edit_posts',
            'redirect'      => false,
            'position'      => '105'
        ]);
    }
}
