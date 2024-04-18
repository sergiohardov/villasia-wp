<?php

namespace CTCore\API;

class GoogleMaps
{
    const API_URL = 'https://maps.googleapis.com/maps/api/';
    const API_KEY = CTCORE_GOOGLE_MAPS_API;

    // TODO: rewrite on curl request
    public function get_coordinates_address($lat, $lng)
    {
        if ($lat === '' || $lng === '') return null;

        $url = $this::API_URL . "geocode/json?latlng={$lat},{$lng}&key=" . $this::API_KEY;

        $response = file_get_contents($url);

        if ($response === false) {
            return false;
        } else {
            $data = json_decode($response, true);

            if ($data['status'] == 'OK' && isset($data['results'][0]['formatted_address'])) {
                $address = $data['results'][0]['formatted_address'];

                return $address;
            } else {
                return false;
            }
        }
    }

    public function get_place_details($place_id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::API_URL . 'place/details/json?place_id=' . $place_id . '&key=' . self::API_KEY);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['status']) && $data['status'] === 'OK') {
            return $data['result'];
        } else {
            return false;
        }
    }
}
