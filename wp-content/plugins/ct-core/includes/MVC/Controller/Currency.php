<?php

namespace CTCore\MVC\Controller;

use CTCore\MVC\View\Currency as ViewCurrency;

class Currency
{
    private $view;

    public function __construct()
    {
        $this->view = new ViewCurrency();

        add_action('wp_dashboard_setup', [$this, 'add_widgets']);
    }

    public function add_widgets()
    {
        wp_add_dashboard_widget(
            CTCORE_FIELD_CUSTOM_KEY . '_currency_widget',
            __('Update Currencies', CTCORE_LANG_TEXT),
            [$this->view, 'widget_update']
        );
    }
}
