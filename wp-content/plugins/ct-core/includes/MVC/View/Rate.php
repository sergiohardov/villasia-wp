<?php

namespace CTCore\MVC\View;

use CTCore\MVC\Model\Rate as RateModel;

class Rate
{
    private $model;

    function __construct()
    {
        $this->model = new RateModel();

        add_action('manage_' . CTCORE_POST_TYPE_RATE . '_posts_custom_column', [$this, 'render_columns'], 10, 2);
    }

    public function render_columns($column, $post_id)
    {
        if ($column == 'valid_until') {
            $valid_until = $this->model->get_valid_until_date($post_id);
            echo $valid_until;
        }
    }
}
