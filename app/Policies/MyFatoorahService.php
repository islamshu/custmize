<?php
namespace App\Services;

use GuzzleHttp\Client;

class MyFatoorahService
{
    protected $client;
    protected $api_key;
    protected $base_url;

    public function __construct()
    {
        $this->api_key = env('MYFATOORAH_API_KEY');
        $this->base_url = 'https://apitest.myfatoorah.com/v2/'; // Use live URL for production
        $this->client = new Client([
            'base_uri' => $this->base_url,
            'headers' => [
                'Authorization' => "Bearer {$this->api_key}",
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    public function createInvoice($data)
    {
        $response = $this->client->post('SendPayment', [
            'json' => $data
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    // You can add more functions here for other MyFatoorah API actions
}

