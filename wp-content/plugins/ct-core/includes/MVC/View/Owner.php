<?php

namespace CTCore\MVC\View;

use CTCore\SYS\Helpers;
use CTCore\MVC\Model\Owner as OwnerModel;
use CTCore\MVC\Model\Promotion as PromotionModel;
use CTCore\MVC\Model\Rate as RateModel;

class Owner
{
    private $model;

    function __construct()
    {
        $this->model = new OwnerModel();

        add_action('manage_' . CTCORE_POST_TYPE_OWNER . '_posts_custom_column', [$this, 'render_columns'], 10, 2);
    }

    public function render_columns($column, $post_id)
    {
        if ($column === 'location') {
            $locations_sort = $this->model->get_locations_sort($post_id) ?: '-';
            echo $locations_sort;
        }

        if ($column === 'managed_villas') {
            $owner_villas = $this->model->get_villas($post_id);
            echo $owner_villas->post_count;
        }
    }

    public function render_conditions($post)
    {
        $args['data'] = $this->model->get_conditions($post->ID);

        Helpers::render_template('/owner/metabox-conditions', $args);
    }

    public function render_rates($post)
    {
        $args['data'] = [
            'post_id' => $post->ID,
            'rates' => RateModel::get_rates($post->ID)
        ];

        Helpers::render_template('/owner/metabox-rates', $args);
    }

    public function render_promotions($post)
    {
        $args['data'] = [
            'post_id' => $post->ID,
            'promotions' => PromotionModel::get_promotions($post->ID),
        ];

        Helpers::render_template('/owner/metabox-promotions', $args);
    }

    public function render_villas($post)
    {
        $args['data'] = [
            'villas' => $this->model->get_villas($post->ID)
        ];

        Helpers::render_template('/owner/metabox-villas', $args);
    }
}
