<?php

if (!defined("ABSPATH")) die;

/**
 * Plugin Name: CT Core
 * Description: Core plugin for CT Theme.
 * Version:     1.0
 * Text Domain: ct-core
 * Domain Path: /languages
 */

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

use CTCore\SYS\ACF_Settings;
use CTCore\SYS\Ajax;
use CTCore\REST\Import as ImportREST;
use CTCore\REST\Ratings;
use CTCore\CRON\Ical as IcalCron;
use CTCore\MVC\Controller\Currency;
use CTCore\MVC\Controller\Owner;
use CTCore\MVC\Controller\Villa;
use CTCore\MVC\Controller\Promotion;
use CTCore\MVC\Controller\Rate;
use CTCore\MVC\Controller\Area;
use CTCore\MVC\Controller\City;
use CTCore\MVC\Controller\Country;
use CTCore\MVC\Controller\KeyFeature;
use CTCore\MVC\Controller\Search;
use CTCore\MVC\Controller\Wishlist;
use CTCore\MVC\Controller\Import;
use CTCore\MVC\Model\Ical as IcalModel;

if (!class_exists('CTCore')) {
    /**
     * Main CT Core Class.
     * 
     */
    final class CTCore
    {
        public function __construct()
        {
            $this->defines();
            $this->init();
            $this->core();
            $this->functions();
        }

        public function defines()
        {
            /* Paths */
            define('CTCORE_PLUGIN_PATH', plugin_dir_path(__FILE__));
            define('CTCORE_PLUGIN_URL', plugin_dir_url(__FILE__));
            define('CTCORE_TEMPLATES_PATH', CTCORE_PLUGIN_PATH . 'templates/');
            define('CTCORE_ASSETS_URL', CTCORE_PLUGIN_URL . 'assets/');
            define('CTCORE_LOGS_PATH', CTCORE_PLUGIN_PATH . 'logs/');
            define('CTCORE_TEMP_PATH', CTCORE_PLUGIN_PATH . 'temp/');

            /* Others */
            define('CTCORE_REST_API_TOKEN', 'AIzaSyCDhRFczczBuQTL0TcnwVrHybP9JnKOwvY');
            define('CTCORE_GOOGLE_MAPS_API', get_field('api_keys_google_maps', 'options'));
            define('CTCORE_INSTAGRAM_API', get_field('api_keys_instagram', 'options'));
            define('CTCORE_FREE_CURRENCY_API', get_field('api_keys_free_currency', 'options'));
            define('CTCORE_DROPBOX_API_KEY', get_field('api_keys_dropbox_key', 'options'));
            define('CTCORE_DROPBOX_API_SECRET', get_field('api_keys_dropbox_secret', 'options'));
            define('CTCORE_DROPBOX_API_TOKEN', get_field('api_keys_dropbox_token', 'options'));
            define('CTCORE_LANG_TEXT', 'ct-core');
            define('CTCORE_CURRENT_CURRENCY_ID', isset($_COOKIE['villasia_currency']) ? $_COOKIE['villasia_currency'] : 'USD');
            define('CTCORE_ICS_TABLE_NAME', 'wp_ics_bookable_dates');

            /* Post type */
            define('CTCORE_POST_TYPE_OWNER', 'owner');
            define('CTCORE_POST_TYPE_VILLA', 'villa');
            define('CTCORE_POST_TYPE_RATE', 'rate');
            define('CTCORE_POST_TYPE_PROMOTION', 'promotion');

            /* Taxonomy */
            define('CTCORE_TAXONOMY_COUNTRY', 'country');
            define('CTCORE_TAXONOMY_AREA', 'area');
            define('CTCORE_TAXONOMY_CITY', 'city');
            define('CTCORE_TAXONOMY_FEATURE', 'key_feature');

            /* Fields */
            // Other
            define('CTCORE_FIELD_CUSTOM_KEY', 'ctcf');
            define('CTCORE_CURRENCY_LAST_UPDATE', 'currency_last_update');

            // Owner
            define('CTCORE_FIELD_OWNER_LOCATIONS', 'main_locations'); // ACF
            define('CTCORE_FIELD_OWNER_CONDITIONS', 'conditions'); // Custom
            define('CTCORE_FIELD_OWNER_LOCATIONS_SORT', 'locations_sort'); // Custom

            // Area
            define('CTCORE_FIELD_AREA_COUNTRY_ID', 'country'); // ACF

            // City
            define('CTCORE_FIELD_CITY_AREA_ID', 'area'); // ACF

            // Villa
            define('CTCORE_FIELD_VILLA_COUNTRY_ID', 'main_group_country'); // ACF
            define('CTCORE_FIELD_VILLA_AREA_ID', 'main_group_area'); // ACF
            define('CTCORE_FIELD_VILLA_CITY_ID', 'main_group_city'); // ACF
            define('CTCORE_FIELD_VILLA_OWNER_ID', 'main_group_owner'); // ACF
            define('CTCORE_FIELD_VILLA_BEDROOMS', 'main_group_bedrooms'); // ACF
            define('CTCORE_FIELD_VILLA_BATHROOMS', 'main_group_bathrooms'); // ACF
            define('CTCORE_FIELD_VILLA_GUESTS', 'main_group_guests'); // ACF
            define('CTCORE_FIELD_VILLA_ICAL', 'main_group_ical_link'); // ACF
            define('CTCORE_FIELD_VILLA_MAP', 'main_group_map'); // ACF
            define('CTCORE_FIELD_VILLA_PLACE_ID', 'main_group_place_id'); // ACF
            define('CTCORE_FIELD_VILLA_DESCRIPTION', 'text_group_description'); // ACF
            define('CTCORE_FIELD_VILLA_AROUND', 'text_group_around'); // ACF
            define('CTCORE_FIELD_VILLA_CAPACITY', 'capacity_group_capacity'); // ACF
            define('CTCORE_FIELD_VILLA_GALLERY', 'photos_group'); // ACF
            define('CTCORE_FIELD_VILLA_RATING', 'ctcore_villa_rating'); // Custom
            define('CTCORE_FIELD_VILLA_REVIEWS', 'ctcore_villa_reviews'); // Custom
            define('CTCORE_FIELD_VILLA_BEST_CHOICE', 'ctcore_villa_best_choice'); // Custom
            define('CTCORE_FIELD_VILLA_PRICE', 'price_list'); // Custom
            define('CTCORE_FIELD_VILLA_PRICE_MIN', 'price_night_min'); // Custom
            define('CTCORE_FIELD_VILLA_PRICE_MAX', 'price_night_max'); // Custom
            define('CTCORE_FIELD_VILLA_RATE_SYNC', 'villa_rates_sync'); // Custom
            define('CTCORE_FIELD_VILLA_RATE_ID', 'villa_rate_id'); // Custom
            define('CTCORE_FIELD_VILLA_TAX_SERVICE', 'villa_per_season_tax_rate_main_tax'); // Custom
            define('CTCORE_FIELD_VILLA_TAX_RATE', 'villa_per_season_tax_rate_default_tax'); // Custom
            define('CTCORE_FIELD_VILLA_PROMOTIONS_OWNER', 'ctcore_villa_promotions_owner'); // Custom
            define('CTCORE_FIELD_VILLA_HAS_PROMOTIONS', 'ctcore_villa_has_promotions'); // Custom
            define('CTCORE_FIELD_VILLA_CONDITIONS_SYNC', 'ctcore_villa_conditions_sync'); // Custom
            define('CTCORE_FIELD_VILLA_CONDITIONS_DATA', 'ctcore_villa_conditions_data'); // Custom

            // Rate
            define('CTCORE_FIELD_RATE_RELATED_ID', 'ct_related_id'); // ACF
            define('CTCORE_FIELD_RATE_SEASONS', 'rates'); // ACF

            // Promotion
            define('CTCORE_FIELD_PROMOTION_RELATED_ID', 'ctcore_related_id'); // ACF
            define('CTCORE_FIELD_PROMOTION_RATE_ID', 'promotion_rate_card'); // ACF
            define('CTCORE_FIELD_PROMOTION_BOOKABLE_PERIOD', 'promotion_bookable_group'); // ACF
            define('CTCORE_FIELD_PROMOTION_EXCLUDE_PERIOD', 'promotion_excluded_period'); // ACF
            define('CTCORE_FIELD_PROMOTION_APPLY_BEDROOM', 'promotion_apply_bedroom'); // ACF
            define('CTCORE_FIELD_PROMOTION_STAY_LENGHT', 'promotion_stay_lenght'); // ACF
            define('CTCORE_FIELD_PROMOTION_STAY_DATES', 'promotion_stay_dates'); // ACF
            define('CTCORE_FIELD_PROMOTION_DISCOUNT', 'promotion_discount_percent'); // ACF
            define('CTCORE_FIELD_PROMOTION_CAN_COMBINED', 'promotion_can_combined'); // ACF
            define('CTCORE_FIELD_PROMOTION_COMBINED_IDS', 'promotion_offer_promo'); // ACF
        }

        public function init()
        {
            register_activation_hook(__FILE__, [$this, 'activate']);
            register_deactivation_hook(__FILE__, [$this, 'deactivate']);
            add_action('admin_enqueue_scripts', [$this, 'styles']);
            add_action('admin_enqueue_scripts', [$this, 'scripts']);
        }

        public function core()
        {
            // SYS
            new ACF_Settings();
            new Ajax();

            // REST
            new ImportREST();
            new Ratings();

            // CRON
            new IcalCron();

            // MVC
            new Currency();
            new Search();
            new Wishlist();
            new Import();
            new Owner();
            new Villa();
            new Rate();
            new Promotion();
            new Country();
            new Area();
            new City();
            new KeyFeature();
        }

        public function functions()
        {
            require_once dirname(__FILE__) . '/includes/SYS/Functions.php';
        }

        public function styles()
        {
            wp_enqueue_style('ct-core', CTCORE_ASSETS_URL . 'css/style.min.css');
            wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css');
        }

        public function scripts()
        {
            wp_enqueue_script('ct-core', CTCORE_ASSETS_URL . 'js/script.min.js', [], false, true);
        }

        public function activate()
        {
            flush_rewrite_rules();      // Update links
            IcalModel::create_table();  // Create table for ics calendar dates
            IcalCron::cron_activate();
        }

        public function deactivate()
        {
            flush_rewrite_rules();  // Update links
            IcalCron::cron_deactivate();
        }
    }
}


$CTCore = new CTCore();
