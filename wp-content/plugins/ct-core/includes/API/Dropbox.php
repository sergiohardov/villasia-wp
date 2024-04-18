<?php

namespace CTCore\API;

use Exception;

class Dropbox
{
    const KEY           = CTCORE_DROPBOX_API_KEY;
    const SECRET        = CTCORE_DROPBOX_API_SECRET;
    const TOKEN         = CTCORE_DROPBOX_API_TOKEN;

    const URL_API       = 'https://api.dropboxapi.com/2/';
    const URL_CONTENT   = 'https://content.dropboxapi.com/2/';

    private function get_base_auth(): string
    {
        return base64_encode(self::KEY . ':' . self::SECRET);
    }

    private function check_response(array $result): bool
    {
        return isset($result['result']) && $result['result'] === 'success';
    }

    private function send_request(string $url, array $data, string $auth_header): array
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $auth_header,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($data),
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true) ?: [];
    }

    public function check_key_secret(): bool
    {
        $auth_header = 'Basic ' . $this->get_base_auth();
        $result = $this->send_request(self::URL_API . 'check/app', ['query' => 'success'], $auth_header);

        return $this->check_response($result);
    }

    public function check_token(): bool
    {
        $auth_header = 'Bearer ' . self::TOKEN;
        $result = $this->send_request(self::URL_API . 'check/user', ['query' => 'success'], $auth_header);

        return $this->check_response($result);
    }

    public function get_shared_link_metadata(string $link, array $options = []): array
    {
        $auth_header = 'Basic ' . $this->get_base_auth();
        return $this->send_request(self::URL_API . 'sharing/get_shared_link_metadata', array_merge(['url' => $link], $options), $auth_header);
    }

    public function get_metadata(string $path, array $options = []): array
    {
        $auth_header = 'Bearer ' . self::TOKEN;
        return $this->send_request(self::URL_API . 'files/get_metadata', array_merge(["path" => $path], $options), $auth_header);
    }

    public function list_folder(string $path, array $options = []): array
    {
        $auth_header = 'Bearer ' . self::TOKEN;
        return $this->send_request(self::URL_API . 'files/list_folder', array_merge(['path' => $path, 'recursive' => false], $options), $auth_header);
    }

    // TODO: optimize this method
    public function download(string $path_from, string $path_to): bool
    {
        $meta = $this->get_metadata($path_from);
        if ($meta['.tag'] !== 'file') {
            return false;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => self::URL_CONTENT . 'files/download',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . self::TOKEN,
                'Dropbox-API-Arg: ' . json_encode(['path' => $path_from]),
            ],
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            throw new Exception('Failed to download file from Dropbox, HTTP status code: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE));
        }

        $put_file = file_put_contents($path_to . $meta['name'], $response);
        curl_close($ch);

        return $put_file ? true : false;
    }
}
