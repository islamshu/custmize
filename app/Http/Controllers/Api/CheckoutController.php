<?php

namespace App\Http\Controllers\Api;

use App\Models\DiscountCode;
use App\Models\ErrorPayment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Services\MyFatoorahService;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use GuzzleHttp\Client;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends BaseController
{

    protected $myFatoorahService;

    public function __construct(MyFatoorahService $myFatoorahService)
    {
        $this->myFatoorahService = $myFatoorahService;
    }

    public function initiatePayment(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'cart.orders' => 'required|array|min:1',
            'cart.orders.*.front_image' => 'required|url',
            // 'cart.orders.*.back_image' => 'required|url',
            'cart.orders.*.quantity' => 'required|integer|min:1',
            'cart.orders.*.price_without_size_color_price' => 'required|numeric|min:0',
            'cart.orders.*.price_for_size_color_price' => 'required|numeric|min:0',
            'cart.orders.*.full_price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'promocode' => 'nullable|string',
        ]);
    
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }
    
        $user = auth('api')->user();
        if (!$user) {
           return $this->sendError(__('User not authenticated'));
        }
    
        $cart = $request->input('cart');
        $subtotal = $request->input('subtotal');
        $total = $request->input('total_amount');
        $discount = $request->input('discount');
        $promoCode = $request->input('promocode');
        if( $user->phone == null){
            return $this->sendError(__('You need to add phone number in your profile first'));
        }
        try {
            DB::beginTransaction();

        $order = Order::create([
            'total_amount' => $total,
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'promo_code' => $promoCode,
            'status' => 'pending',
            'name' => $user->name,
            'email' => $user->email,
            'code' => date('Ymd-His') . rand(10, 99),
        ]);
    
        foreach ($cart['orders'] as $orderData) {
            $frontImage = $orderData['front_image'] ?? null;
            $backImage = $orderData['back_image'] ?? null;
            $logos = $orderData['logos'] ?? [];
    
            if (!$frontImage ) {
                $this->sendError(__('Front image is missing'));
            }
    
            $savedImages = $this->saveImagesFromUrls([$frontImage, $backImage]);
            $savedLogos = $this->saveImagesFromUrls($logos);
    
            OrderDetail::create([
                'order_id' => $order->id,
                'product_name'=>Product::find($orderData['product_id'])->name,
                'product_id' => $orderData['product_id'],
                'quantity' => $orderData['quantity'],
                'price_without_size_color' => $orderData['price_without_size_color_price'],
                'price_for_size_color' => $orderData['price_for_size_color_price'],
                'full_price' => $orderData['full_price'],
                'front_image' => $savedImages[0] ?? null,
                'back_image' => $savedImages[1] ?? null,
                'logos' => json_encode($savedLogos),
            ]);
        }
       
    
        $paymentData = [
            'CustomerName' => $user->name,
            'NotificationOption' => 'ALL',
            'InvoiceValue' => $total,
            'DisplayCurrencyIso' => 'SAR',
            'MobileCountryCode' => '+966', // Saudi Arabia country code
            'CustomerMobile' => $user->phone,
            'CustomerEmail' => $user->email,
            'CallBackUrl' => route('payment.success',$order->id),
            'ErrorUrl' =>  route('payment.error'),
            'Language' => 'ar',
            'CustomerReference' => 'order_' . $order->id,
            'UserDefinedField' => 'CustomData',
        ];
    
        $response = $this->myFatoorahService->createInvoice($paymentData);
        
        if (isset($response['Data']['InvoiceURL'])) {

            DB::commit();

            $ress['link'] = $response['Data']['InvoiceURL'];
          return  $this->sendResponse($ress,'success');
        }

    } catch (\Exception $e) {
        // Rollback Transaction on Error
        DB::rollBack();

        // Log the error for debugging
        $error = new ErrorPayment();
        $error->code =  date('Ymd-His') . rand(10, 99);
        $error->descripton = $e->getMessage();
        $error->full_request = json_encode($request->cart);
        $error->save();
        // \Log::error('Order placement failed: ' . $e->getMessage());
        return $this->sendError(__('Payment initiation failed . error code: '.$error->code));

    }
    
    }
    




    public function paymentCallback(Request $request, $order_id)
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
    public function error()
    {
        dd('error');
    }
    public function saveImagesFromUrls($imageUrls, $folder = 'images/products')
    {
        $savedImages = [];

        foreach ($imageUrls as $imageUrl) {
            try {
                // Fetch the image using Guzzle
                $client = new Client();
                $response = $client->get($imageUrl);

                // Get the original filename or create a unique one
                $originalFilename = basename($imageUrl);
                $filename = Str::random(10) . '_' . $originalFilename;

                // Determine storage path
                $filePath = $folder . '/' . $filename;

                // Save the image in the specified directory
                Storage::disk('public')->put($filePath, $response->getBody());

                // Add the saved path to the result
                $savedImages[] = $filePath;
            } catch (\Exception $e) {
                // Handle the error (e.g., log it or continue)
                continue;
            }
        }

        return $savedImages;
    }
}
