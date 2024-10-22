<?php
namespace App\Services;

use GuzzleHttp\Client;

class PayTabsService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('PAYTABS_BASE_URL');
        $this->client = new Client();
    }

    public function createPayment($amount, $currency, $customerDetails,$orderId)
    {
        $response = $this->client->post($this->baseUrl . '/payment/request', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('PAYTABS_SECRET_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'profile_id' => env('PAYTABS_PROFILE_ID'),
                'tran_type' => 'sale',
                'tran_class' => 'ecom',
                'cart_currency' => $currency,
                'cart_amount' => $amount,
                'customer_details' => $customerDetails,
                'callback' => url('/payment/callback',$orderId),
                'return' => url('/payment/success'),
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function verifyPayment($transactionReference)
    {
        $response = $this->client->post($this->baseUrl . '/payment/query', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('PAYTABS_SECRET_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'tran_ref' => $transactionReference,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
