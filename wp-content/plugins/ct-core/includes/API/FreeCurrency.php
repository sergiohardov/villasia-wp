<?php

namespace CTCore\API;

class FreeCurrency
{
    const BASE_URL = 'https://api.freecurrencyapi.com/v1/';

    private $api_key;

    public function __construct($api)
    {
        $this->api_key = $api;
    }
    public function status()
    {
        $result = null;

        $params = [
            'apikey' => $this->api_key,
        ];

        $url = $this::BASE_URL . 'status?' . http_build_query($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        return $result;
    }
    public function latest($currencies)
    {
        $result = null;

        $params = [
            'apikey' => $this->api_key,
            'currencies' => implode(',', $currencies)
        ];

        $url = $this::BASE_URL . 'latest?' . http_build_query($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['data'])) {
            $result = $data['data'];
        }

        return $result;
    }
    public function currencies($currencies)
    {
        $result = null;

        $params = [
            'apikey' => $this->api_key,
            'currencies' => implode(',', $currencies)
        ];

        $url = $this::BASE_URL . 'currencies?' . http_build_query($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['data'])) {
            $result = $data['data'];
        }

        return $result;
    }
}
