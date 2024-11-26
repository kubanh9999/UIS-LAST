<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class InvoiceXpress
{
    protected $client;
    protected $apiKey; // Nếu API yêu cầu khóa truy cập

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8000/zaloApi/api', // Thay đổi địa chỉ API nếu cần
            'timeout'  => 2.0,
        ]);
        // Nếu API yêu cầu khóa truy cập, gán nó ở đây
        $this->apiKey = 'base64:JAuadqWtDTd+bbmfqIaneABChQsy9XDcA1jWVNfoY4Q='; // Thay YOUR_API_KEY bằng khóa thật
    }

    public function getClients()
    {
        try {
            $response = $this->client->get('clients', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey, // Nếu cần
                    'Accept'        => 'application/json',
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            // Xử lý lỗi nếu cần
            return ['error' => $e->getMessage()];
        }
    }

    // Thêm các phương thức khác để tương tác với API
}
