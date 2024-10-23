<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MyFatoorahService;

class PaymentController extends Controller
{
    protected $myFatoorahService;

    public function __construct(MyFatoorahService $myFatoorahService)
    {
        $this->myFatoorahService = $myFatoorahService;
    }

    public function initiatePayment(Request $request)
    {
        $data = [
            'CustomerName'       => 'Test Customer',
            'NotificationOption' => 'ALL',
            'InvoiceValue'       => 100.000, // Payment amount
            'DisplayCurrencyIso' => 'KWD', // Change to your desired currency
            'MobileCountryCode'  => '+965',
            'CustomerMobile'     => '12345678',
            'CustomerEmail'      => 'test@example.com',
            'CallBackUrl'        => url('/payment/success'), // Your success URL
            'ErrorUrl'           => url('/payment/error'), // Your error URL
            'Language'           => 'en',
            'CustomerReference'  => 'order_12345', // Custom reference for your order
        ];

        $response = $this->myFatoorahService->createInvoice($data);

        if (isset($response['Data']['PaymentURL'])) {
            return redirect($response['Data']['PaymentURL']); // Redirect to MyFatoorah Payment URL
        }

        return back()->with('error', 'Payment initiation failed. Please try again.');
    }

    public function paymentSuccess()
    {
        return view('payment.success'); // Create a success view for successful payments
    }

    public function paymentError()
    {
        return view('payment.error'); // Create an error view for failed payments
    }
}
