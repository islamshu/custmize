<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use App\Models\Order;
use App\Services\MyFatoorahService;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    
    protected $myFatoorahService;

    public function __construct(MyFatoorahService $myFatoorahService)
    {
        $this->myFatoorahService = $myFatoorahService;
    }

    public function initiatePayment(Request $request)
    {
        $customerDetails = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => '0097333344556',
            'street1' => 'Street Address',
            'city' => 'City',
            'country' => 'BHR',
        ];
        $name = $request->input('name');
        $email = $request->input('email');
        $subtotal = $request->input('subtotal');
        $total = $request->input('total');
        $discount = $request->input('discount');
        $promoCode = $request->input('promo_code');

        $order = Order::create([
            'total_amount' => $total,
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'promo_code' => $promoCode,
            'status' => 'pending',
            'name' => $name,
            'email' => $email,
            'code' => date('Ymd-His') . rand(10, 99)
        ]);
        $data = [
            'CustomerName' => 'CustomerName',
            'NotificationOption' => 'ALL',
            'InvoiceValue' => 10.000,
            'DisplayCurrencyIso' => 'KWD',
            'MobileCountryCode' => '+965',
            'CustomerMobile' => '12345678',
            'CustomerEmail' => 'test@test.com',
            'CallBackUrl' => url('/payment/success',$order->id),
            'ErrorUrl' => url('/payment/error'),
            'Language' => 'en',
            'CustomerReference' => 'order_12345',
            'UserDefinedField' => 'CustomData',
        ];

        $response = $this->myFatoorahService->createInvoice($data);
        
        // Handle response (redirect to payment URL)
        return redirect($response['Data']['PaymentURL']);
    }  

    public function initiatePaymentt(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $subtotal = $request->input('subtotal');
        $total = $request->input('total');
        $discount = $request->input('discount');
        $promoCode = $request->input('promo_code');

        // إنشاء الطلب
        $order = Order::create([
            'total_amount' => $total,
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'promo_code' => $promoCode,
            'status' => 'pending',
            'name' => $name,
            'email' => $email,
            'code' => date('Ymd-His') . rand(10, 99)
        ]);
    
        $client = new \GuzzleHttp\Client();
        $response = $client->post(env('MYFATOORAH_API_URL'), [
            'headers' => [
                'Authorization' => 'Bearer ' . env('MYFATOORAH_API_KEY'),  // تأكد من وجود كلمة "Bearer" قبل المفتاح
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'InvoiceAmount' => (float)$total,
                'CustomerName' => $name,
                'CustomerEmail' => $email,
                'MobileCountryCode' => '+965',  // تعديل حسب الدولة
                'CustomerMobile' => '12345678', // رقم هاتف صحيح
                'CallBackUrl' => route('payment.callback', $order->id),
                'ErrorUrl' => route('payment.error'),
                'Language' => 'en',
                'NotificationOption' => 'Lnk',  // خيارات الإشعارات
            ],
        ]);
        dd($response);
        

        
    }
    


    public function paymentCallback(Request $request,$order_id)
    {
        dd($order_id);
        $paymentId = $request->paymentId;

        // التحقق من حالة الدفع باستخدام الـ paymentId
        $response = $this->myfatoorah->paymentStatus($paymentId, 'PaymentId');

        if ($response['IsSuccess']) {
            // الدفع ناجح، يمكنك معالجة الطلب
            return view('payment.success');
        } else {
            // فشل الدفع
            return view('payment.error', ['message' => $response['Message']]);
        }
    }
    public function error(){
        dd('error');
    }
}

