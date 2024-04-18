<?php

namespace CTCore\REST;

use CTCore\API\GoogleMaps;
use CTCore\MVC\Model\Villa;
use WP_Query;
use WP_REST_Server;

if (!defined("ABSPATH")) die;

class Ratings
{
    const API_URL       = 'ctcore/ratings/v1';
    const API_KEY       = CTCORE_REST_API_TOKEN; // TODO: Global options site rest api key

    function __construct()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    private function create_response($status, $message = null, $data = null)
    {
        $response = [];

        $response['success'] = $status;

        if ($message) $response['message'] = $message;
        if ($data) $response['data'] = $data;

        return $response;
    }

    public function register_routes()
    {
        register_rest_route($this::API_URL, 'get_villa_ids', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_villa_ids'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        register_rest_route($this::API_URL, 'get_villa_place_id', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_villa_place_id'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        register_rest_route($this::API_URL, 'get_villa_place_details', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_villa_place_details'],
            'permission_callback' => [$this, 'check_permission']
        ]);


        register_rest_route($this::API_URL, 'set_villa_rating', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'set_villa_rating'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        register_rest_route($this::API_URL, 'set_villa_reviews', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'set_villa_reviews'],
            'permission_callback' => [$this, 'check_permission']
        ]);
    }

    public function check_permission($request)
    {
        $params = $request->get_params();

        if (!isset($params['api_key']) || empty($params['api_key']) || $params['api_key'] !== $this::API_KEY) {
            return false;
        }

        return true;
    }

    public function get_villa_ids($request)
    {
        $result = [];

        $query = new WP_Query([
            'post_type' => CTCORE_POST_TYPE_VILLA,
            'posts_per_page' => -1,
        ]);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $result[] = get_the_ID();
            }

            wp_reset_postdata();
        }

        return rest_ensure_response($this->create_response(true, sprintf("Data received. Have %s villas!", $query->post_count), $result));
    }

    public function get_villa_place_id($request)
    {
        $params = $request->get_params();

        if (!isset($params['villa_id']) || empty($params['villa_id']) || !$params['villa_id']) {
            return rest_ensure_response($this->create_response(false, 'Error: Villa id must not be empty.'));
        }

        $result = null;

        $place_id = Villa::get_place_id($params['villa_id']);

        if ($place_id) {
            $result = $place_id;
        } else {
            $map_data = Villa::get_map($params['villa_id']);

            if ($map_data && isset($map_data['place_id'])) {
                $result = $map_data['place_id'] ?: null;
            }
        }

        if ($result === null) {
            return rest_ensure_response($this->create_response(true, "Place id not found.", ['place_id' => null]));
        }

        return rest_ensure_response($this->create_response(true, "Place id founded.", ['place_id' => $result]));
    }

    public function get_villa_place_details($request)
    {
        $params = $request->get_params();

        if (!isset($params['place_id']) || empty($params['place_id']) || !$params['place_id']) {
            return rest_ensure_response($this->create_response(false, 'Error: Place id must not be empty.'));
        }

        $api = new GoogleMaps();
        $data = $api->get_place_details($params['place_id']);

        return rest_ensure_response($this->create_response(true, "Place data recived.", ['place_data' => $data]));
    }

    public function set_villa_rating($request)
    {
        $params = $request->get_params();

        if (!isset($params['villa_id']) || empty($params['villa_id']) || !$params['villa_id']) {
            return rest_ensure_response($this->create_response(false, 'Error: Villa id must not be empty.'));
        }

        if (!isset($params['rating']) || empty($params['rating']) || !$params['rating']) {
            return rest_ensure_response($this->create_response(false, 'Error: Rating must not be empty.'));
        }

        Villa::set_rating($params['villa_id'], $params['rating']);

        return rest_ensure_response($this->create_response(true, "Villa rating updated."));
    }

    public function set_villa_reviews($request)
    {
        $params = $request->get_params();

        if (!isset($params['villa_id']) || empty($params['villa_id']) || !$params['villa_id']) {
            return rest_ensure_response($this->create_response(false, 'Error: Villa id must not be empty.'));
        }

        if (!isset($params['reviews']) || empty($params['reviews']) || !$params['reviews']) {
            return rest_ensure_response($this->create_response(false, 'Error: Reviews must not be empty.'));
        }

        Villa::set_reviews($params['villa_id'], json_decode($params['reviews'], true));

        return rest_ensure_response($this->create_response(true, "Villa reviews updated."));
    }
}
