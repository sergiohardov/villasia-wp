<?php

namespace CTCore\MVC\View;

use CTCore\SYS\Helpers;
use CTCore\MVC\Model\Currency as ModelCurrency;

class Currency
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelCurrency();
    }

    public function widget_update()
    {
        $args = [
            'month_quota' => $this->model->get_mounth_quota() ?: '-',
            'last_updated' => $this->model->get_last_updated() ?: '-',
        ];

        Helpers::render_template('/currency/widget-update', $args);
    }
}
