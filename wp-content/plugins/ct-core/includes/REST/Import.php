<?php

namespace CTCore\REST;

use CTCore\API\Dropbox;
use CTCore\API\GoogleMaps;
use CTCore\MVC\Model\Area as AreaModel;
use CTCore\MVC\Model\City as CityModel;
use CTCore\MVC\Model\Villa as VillaModel;
use WP_Query;
use WP_REST_Server;

if (!defined("ABSPATH")) die;

class Import
{
    const API_URL       = 'ctcore/import/v1';
    const API_KEY       = CTCORE_REST_API_TOKEN; // TODO: Global options site rest api key

    const PATH_CSV      = CTCORE_TEMP_PATH . "import/csv/";
    const PATH_IMAGES   = CTCORE_TEMP_PATH . "import/images/";

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
        register_rest_route($this::API_URL, 'send_file', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'send_file'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        register_rest_route($this::API_URL, 'get_parsed_data', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_parsed_data'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        register_rest_route($this::API_URL, 'create_country', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'create_country'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        register_rest_route($this::API_URL, 'create_area', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'create_area'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        register_rest_route($this::API_URL, 'create_city', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'create_city'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        register_rest_route($this::API_URL, 'get_post_by_title', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'get_post_by_title'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        register_rest_route($this::API_URL, 'get_dropbox_images', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'get_dropbox_images'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        register_rest_route($this::API_URL, 'clear_images_folder', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => [$this, 'clear_images_folder'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        register_rest_route($this::API_URL, 'download_dropbox_image', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'download_dropbox_image'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        register_rest_route($this::API_URL, 'create_post', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => [$this, 'create_post'],
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

    public function send_file($request)
    {
        $file_params = $request->get_file_params();

        if (!isset($file_params['file']) || empty($file_params['file'])) {
            return rest_ensure_response($this->create_response(false, 'Error: File broken or empty.'));
        }

        if ($file_params['file']['type'] !== 'text/csv') {
            return rest_ensure_response($this->create_response(false, 'Error: File type must be CSV.'));
        }

        if (!file_exists($this::PATH_CSV)) {
            if (!mkdir($this::PATH_CSV, 0777, true)) {
                return rest_ensure_response($this->create_response(false, 'Error: Problem in create folder.'));
            }
        }

        $file = $file_params['file'];
        $filename = basename($file['name']);
        $save_file = move_uploaded_file($file['tmp_name'], $this::PATH_CSV . $filename);

        if ($save_file !== true) {
            return rest_ensure_response($this->create_response(false, 'Error: Problem in save file.'));
        }

        return rest_ensure_response($this->create_response(true, "File saved - $filename.", ['filename' => $filename]));
    }

    public function get_parsed_data($request)
    {
        $params = $request->get_params();

        if (!isset($params['filename']) || empty($params['filename'])) {
            return rest_ensure_response($this->create_response(false, 'Error: Filename must not be empty.'));
        }

        if (!isset($params['separator']) || empty($params['separator'])) {
            return rest_ensure_response($this->create_response(false, 'Error: Separator must not be empty.'));
        }

        $filepath = $this::PATH_CSV . $params['filename'];

        if (!file_exists($filepath)) {
            return rest_ensure_response($this->create_response(false, 'Error: File not found.'));
        }

        $delimiters = [';' => 0, ',' => 0, "\t" => 0, "|" => 0];
        $file = fopen($filepath, 'r');
        $first_line = fgets($file);
        fclose($file);

        foreach ($delimiters as $delimiter => &$count) {
            $count = count(str_getcsv($first_line, $delimiter));
        }

        if (array_search(max($delimiters), $delimiters) !== $params['separator']) {
            return rest_ensure_response($this->create_response(false, 'Error: Not valid separator table. Try another.'));
        }

        $file = fopen($filepath, 'r');
        $row_idx = 0;
        $table_header = [];
        $result = [];

        while (($row = fgetcsv($file, 50000, $params['separator'])) !== FALSE) {
            if ($row_idx === 0) {
                $table_header = $row;
            } else {
                $row_data = [];
                foreach ($table_header as $idx => $header) {
                    $row_data[$header] = $row[$idx];
                }
                $result[] = $row_data;
            }
            $row_idx++;
        }

        fclose($file);

        return rest_ensure_response($this->create_response(true, sprintf("File parse success. Received %s villas.", count($result)), $result));
    }

    public function create_country($request)
    {
        $params = $request->get_params();

        if (!isset($params['country']) || empty($params['country']) || !$params['country']) {
            return rest_ensure_response($this->create_response(false, 'Error: Country must not be empty.'));
        }

        $country_title = $params['country'];

        $term_exist = term_exists($country_title, CTCORE_TAXONOMY_COUNTRY);

        if ($term_exist !== 0 && $term_exist !== null) {
            return rest_ensure_response($this->create_response(true, "Country is exist - $country_title.", ['term_id' => $term_exist['term_id']]));
        }

        $term_create = wp_insert_term($country_title, CTCORE_TAXONOMY_COUNTRY);

        if (is_wp_error($term_create)) {
            return rest_ensure_response($this->create_response(false, 'Error: Problem in create country. Message: ' . $term_create->get_error_message()));
        }

        return rest_ensure_response($this->create_response(true, "Country created - $country_title.", ['term_id' => $term_create['term_id']]));
    }

    public function create_area($request)
    {
        $params = $request->get_params();

        if (!isset($params['area']) || empty($params['area']) || !$params['area']) {
            return rest_ensure_response($this->create_response(false, 'Error: Area must not be empty.'));
        }
        if (!isset($params['country_id']) || empty($params['country_id']) || !$params['country_id']) {
            return rest_ensure_response($this->create_response(false, 'Error: Country ID must not be empty.'));
        }

        $area_title = $params['area'];

        $term_exist = term_exists($area_title, CTCORE_TAXONOMY_AREA);

        if ($term_exist !== 0 && $term_exist !== null) {
            return rest_ensure_response($this->create_response(true, "Area is exist - $area_title.", ['term_id' => $term_exist['term_id']]));
        }

        $term_create = wp_insert_term($area_title, CTCORE_TAXONOMY_AREA);

        if (is_wp_error($term_create)) {
            return rest_ensure_response($this->create_response(false, 'Error: Problem in create area. Message: ' . $term_create->get_error_message()));
        }

        $term_id = $term_create['term_id'];
        AreaModel::set_country_id($term_id, $params['country_id']);

        return rest_ensure_response($this->create_response(true, "Area created - $area_title.", ['term_id' => $term_create['term_id']]));
    }

    public function create_city($request)
    {
        $params = $request->get_params();

        if (!isset($params['city']) || empty($params['city']) || !$params['city']) {
            return rest_ensure_response($this->create_response(false, 'Error: City must not be empty.'));
        }
        if (!isset($params['area_id']) || empty($params['area_id']) || !$params['area_id']) {
            return rest_ensure_response($this->create_response(false, 'Error: Area ID must not be empty.'));
        }

        $city_title = $params['city'];
        $term_exist = term_exists($city_title, CTCORE_TAXONOMY_CITY);

        if ($term_exist !== 0 && $term_exist !== null) {
            return rest_ensure_response($this->create_response(true, "City is exist - $city_title.", ['term_id' => $term_exist['term_id']]));
        }

        $term_create = wp_insert_term($city_title, CTCORE_TAXONOMY_CITY);

        if (is_wp_error($term_create)) {
            return rest_ensure_response($this->create_response(false, 'Error: Problem in create city. Message: ' . $term_create->get_error_message()));
        }

        $term_id = $term_create['term_id'];
        CityModel::set_area_id($term_id, $params['area_id']);

        return rest_ensure_response($this->create_response(true, "City created - $city_title.", ['term_id' => $term_create['term_id']]));
    }

    public function get_post_by_title($request)
    {
        $params = $request->get_params();

        if (!isset($params['title']) || empty($params['title']) || !$params['title']) {
            return rest_ensure_response($this->create_response(false, 'Error: Title must not be empty.'));
        }

        $post_exist = new WP_Query([
            'post_type'              => CTCORE_POST_TYPE_VILLA,
            'title'                  => $params['title'],
            'post_status'            => 'all',
            'posts_per_page'         => 1,
        ]);

        if (!empty($post_exist->post)) {
            return rest_ensure_response($this->create_response(true, 'Post founded - ID: ' . $post_exist->post->ID, ['post_id' => $post_exist->post->ID]));
        } else {
            return rest_ensure_response($this->create_response(true, 'Post not found.', ['post_id' => null]));
        }
    }

    public function get_dropbox_images($request)
    {
        $params = $request->get_params();

        if (!isset($params['link']) || empty($params['link']) || !$params['link']) {
            return rest_ensure_response($this->create_response(false, 'Error: Link must not be empty.'));
        }

        $api = new Dropbox();
        $check_key_secret = $api->check_key_secret();

        if ($check_key_secret === false) {
            return rest_ensure_response($this->create_response(false, 'Error: Check your key & secret dropbox.'));
        }

        $check_token = $api->check_token();

        if ($check_token === false) {
            return rest_ensure_response($this->create_response(false, 'Error: Check your token dropbox.'));
        }

        $shared_link = $params['link'];
        $shared_link_metadata = $api->get_shared_link_metadata($shared_link);

        if (!isset($shared_link_metadata['.tag']) && $shared_link_metadata['.tag'] !== 'folder') {
            return rest_ensure_response($this->create_response(false, 'Error: Shared link not folder.'));
        }

        $metadata = $api->get_metadata($shared_link_metadata['id']);

        if (!isset($metadata['path_lower']) && empty($metadata['path_lower'])) {
            return rest_ensure_response($this->create_response(false, 'Error: Not valid path folder.'));
        }

        $list_folder = $api->list_folder($metadata['path_display']);

        if (!isset($list_folder['entries'])) {
            return rest_ensure_response($this->create_response(false, 'Error: Problem to get data from path.'));
        }

        $list_files = [];

        foreach ($list_folder['entries'] as $item) {
            $list_files[] = $item['path_lower'];
        }

        return rest_ensure_response($this->create_response(true, 'Dropbox files get success.', $list_files));
    }

    public function clear_images_folder($request)
    {
        $path_exist = file_exists($this::PATH_IMAGES);

        if (!$path_exist) {
            return rest_ensure_response($this->create_response(true, 'Folder not exist.'));
        }

        $files = scandir($this::PATH_IMAGES);

        if ($files) {
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $remove_file = unlink($this::PATH_IMAGES . $file);

                if (!$remove_file) {
                    return rest_ensure_response($this->create_response(false, 'Error: Problem to delete file.'));
                }
            }
        }

        $remove_folder = rmdir($this::PATH_IMAGES);

        if (!$remove_folder) {
            return rest_ensure_response($this->create_response(false, 'Error: Problem to delete folder.'));
        }

        return rest_ensure_response($this->create_response(true, 'Images folder deleted.'));
    }

    public function download_dropbox_image($request)
    {
        $params = $request->get_params();

        if (!isset($params['path']) || empty($params['path']) || !$params['path']) {
            return rest_ensure_response($this->create_response(false, 'Error: Path must not be empty.'));
        }

        if (!file_exists($this::PATH_IMAGES)) {
            if (!mkdir($this::PATH_IMAGES, 0777, true)) {
                return rest_ensure_response($this->create_response(false, 'Error: Problem to create temp folder for images.'));
            }
        }

        $api = new Dropbox();

        $check_key_secret = $api->check_key_secret();

        if ($check_key_secret === false) {
            return rest_ensure_response($this->create_response(false, 'Error: Check your key & secret dropbox.'));
        }

        $check_token = $api->check_token();

        if ($check_token === false) {
            return rest_ensure_response($this->create_response(false, 'Error: Check your token dropbox.'));
        }

        $api->download($params['path'], $this::PATH_IMAGES);

        return rest_ensure_response($this->create_response(true, sprintf('Image downloaded - %s.', $params['path'])));
    }

    public function create_post($request)
    {
        $params = $request->get_params();

        if (!isset($params['data']) || empty($params['data']) || !$params['data']) {
            return rest_ensure_response($this->create_response(false, 'Error: Data must not be empty.'));
        }

        $post_data = json_decode($params['data'], true);

        if (!isset($post_data['villa_name']) || empty($post_data['villa_name']) || !$post_data['villa_name']) {
            return rest_ensure_response($this->create_response(false, 'Error: Villa must have title.'));
        }

        if (!isset($post_data['slug']) || empty($post_data['slug']) || !$post_data['slug']) {
            return rest_ensure_response($this->create_response(false, 'Error: Villa must have slug.'));
        }

        $post_id = null;
        $message = null;

        $post_exist = new WP_Query([
            'post_type'              => CTCORE_POST_TYPE_VILLA,
            'title'                  => $post_data['villa_name'],
            'post_status'            => 'all',
            'posts_per_page'         => 1,
        ]);

        if (!empty($post_exist->post)) {
            $post_id = $post_exist->post->ID;
            $message = 'Post updated.';
        } else {
            $create_post = wp_insert_post([
                'post_title'    => $post_data['villa_name'],
                'post_name'     => $post_data['slug'],
                'post_type'     => CTCORE_POST_TYPE_VILLA,
                'post_status'   => 'publish'
            ]);

            if (is_wp_error($create_post)) {
                return rest_ensure_response($this->create_response(false, 'Error: Problem to create post. Message: ' . $create_post->get_error_message()));
            } elseif (is_numeric($create_post)) {
                $post_id = $create_post;
                $message = 'Post created.';
            } else {
                return rest_ensure_response($this->create_response(false, 'Error: Problem to create post.'));
            }
        }

        if (!$post_id) {
            return rest_ensure_response($this->create_response(false, 'Error: Problem to create post.'));
        }

        if (isset($post_data['owners']) && !empty($post_data['owners'])) {
            $owner_exist = new WP_Query([
                'post_type'              => CTCORE_POST_TYPE_OWNER,
                'title'                  => $post_data['owners'],
                'post_status'            => 'all',
                'posts_per_page'         => 1,
            ]);

            if (!empty($owner_exist->post)) {
                VillaModel::set_owner_id($post_id, $owner_exist->post->ID);
            }
        }

        if (isset($post_data['country']) && !empty($post_data['country'])) {
            $country_exist = term_exists($post_data['country'], CTCORE_TAXONOMY_COUNTRY);

            if ($country_exist !== 0 && $country_exist !== null) {
                VillaModel::set_country_id($post_id, $country_exist['term_id']);
            }
        }

        if (isset($post_data['area']) && !empty($post_data['area'])) {
            $area_exist = term_exists($post_data['area'], CTCORE_TAXONOMY_AREA);

            if ($area_exist !== 0 && $area_exist !== null) {
                VillaModel::set_area_id($post_id, $area_exist['term_id']);
            }
        }

        if (isset($post_data['city']) && !empty($post_data['city'])) {
            $city_exist = term_exists($post_data['city'], CTCORE_TAXONOMY_CITY);

            if ($city_exist !== 0 && $city_exist !== null) {
                VillaModel::set_city_id($post_id, $city_exist['term_id']);
            }
        }

        if (isset($post_data['number_of_guests']) && !empty($post_data['number_of_guests'])) {
            VillaModel::set_guests($post_id, $post_data['number_of_guests']);
        }

        if (isset($post_data['number_of_bedrooms']) && !empty($post_data['number_of_bedrooms'])) {
            VillaModel::set_bedrooms($post_id, $post_data['number_of_bedrooms']);
        }

        if (isset($post_data['number_of_bathrooms']) && !empty($post_data['number_of_bathrooms'])) {
            VillaModel::set_bathrooms($post_id, $post_data['number_of_bathrooms']);
        }

        if (isset($post_data['main_description']) && !empty($post_data['main_description'])) {
            VillaModel::set_description($post_id, $post_data['main_description']);
        }

        if (isset($post_data['around_the_villa']) && !empty($post_data['around_the_villa'])) {
            VillaModel::set_around($post_id, $post_data['around_the_villa']);
        }

        if (isset($post_data['capacity']) && !empty($post_data['capacity'])) {
            VillaModel::set_capacity($post_id, $post_data['capacity']);
        }

        if (isset($post_data['gps_coordinates']) && !empty($post_data['gps_coordinates'])) {
            $api = new GoogleMaps();

            $location = explode(', ', $post_data['gps_coordinates']);
            $address = $api->get_coordinates_address($location[0], $location[1]);

            $coordinates = [
                'address' => $address ?: null,
                'lat' => $location[0],
                'lng' => $location[1],
            ];

            VillaModel::set_map($post_id, $coordinates);
        }

        if (isset($post_data['place_id']) && !empty($post_data['place_id'])) {
            VillaModel::set_place_id($post_id, $post_data['place_id']);
        }

        if (isset($post_data['ical_link']) && !empty($post_data['ical_link'])) {
            VillaModel::set_ical_link($post_id, $post_data['ical_link']);
        }

        if (isset($post_data['lien_dropbox']) && !empty($post_data['lien_dropbox'])) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');

            $files = scandir($this::PATH_IMAGES);
            $attachment_ids = [];

            if ($files) {
                foreach ($files as $file) {
                    if ($file === '.' || $file === '..') continue;

                    $file_path = $this::PATH_IMAGES . $file;
                    $attachment_id = media_handle_sideload(['name' => basename($file_path), 'tmp_name' => $file_path], 0);

                    if (is_wp_error($attachment_id)) {
                        // if error
                        // echo $attachment_id->get_error_message();
                        continue;
                    } else {
                        $attachment_ids[] = $attachment_id;
                    }
                }

                VillaModel::set_gallery($post_id, $attachment_ids);
            }
        }

        return rest_ensure_response($this->create_response(true, $message));
    }
}
