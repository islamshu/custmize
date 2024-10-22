<?php

namespace App\Services;

use GuzzleHttp\Client;

class MyFatoorahService
{
    protected $client;
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('MYFATOORAH_API_KEY');
        $this->apiUrl = env('MYFATOORAH_API_URL');
    }

    public function initiatePayment($invoiceAmount, $customerName, $customerEmail, $callbackUrl)
    {
        try {
            $response = $this->client->post($this->apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'InvoiceAmount' => $invoiceAmount,
                    'CustomerName' => $customerName,
                    'CustomerEmail' => $customerEmail,
                    'CallBackUrl' => $callbackUrl,
                    'ErrorUrl' => $callbackUrl, // Error callback URL
                    'Language' => 'ar', // يمكن استخدام 'ar' للغة العربية
                    'DisplayCurrencyIso' => 'KWD',
                    'MobileCountryCode' => '+965',
                    'CustomerMobile' => '12345678',
                    'PaymentMethod' => '2', // يمكن تحديد وسيلة الدفع
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
