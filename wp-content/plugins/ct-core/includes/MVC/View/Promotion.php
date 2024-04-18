<?php

namespace CTCore\MVC\View;

use CTCore\MVC\Model\Promotion as PromotionModel;

class Promotion
{
    private $model;

    function __construct()
    {
        $this->model = new PromotionModel();

        add_action('manage_' . CTCORE_POST_TYPE_PROMOTION . '_posts_custom_column', [$this, 'render_columns'], 10, 2);
    }

    public function render_columns($column, $post_id)
    {
        if ($column == 'excluded_period') {
            $excluded_period = $this->model->get_exclude_period($post_id);
            echo $excluded_period && $excluded_period['start'] && $excluded_period['end'] ? 'Yes' : 'No';
        }
    }
}
