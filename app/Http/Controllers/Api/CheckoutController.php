<?php

namespace App\Http\Controllers\Api;

use App\Models\DiscountCode;
use App\Models\ErrorPayment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Shipping;
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
            'cart.orders.*.front_image' => 'required',
            // 'cart.orders.*.back_image' => 'required|url',
            'cart.orders.*.quantity' => 'required|integer|min:1',
            'cart.orders.*.price_without_size_color_price' => 'required|numeric|min:0',
            'cart.orders.*.price_for_size_color_price' => 'required|numeric|min:0',
            'cart.orders.*.full_price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'promocode' => 'nullable|string',
            'shipping' => 'required|boolean',
            'receiver_name' => $request->shipping == 1 ? 'required' : 'nullable',
            'receiver_email' => $request->shipping == 1 ? 'required|email' : 'nullable',
            'receiver_phone' => $request->shipping == 1 ? 'required' : 'nullable',  
            'address' => $request->shipping == 1 ? 'required' : 'nullable',
            'city' => $request->shipping == 1 ? 'required' : 'nullable',
            'postal_code' => $request->shipping == 1 ? 'required' : 'nullable',
            'country' => $request->shipping == 1 ? 'required' : 'nullable',

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
        if ($user->phone == null) {
            return $this->sendError(__('You need to add phone number in your profile first'));
        }
        try {
            DB::beginTransaction();
            // dd($request->shipping);
            $order = Order::create([
                'total_amount' => $total,
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'promo_code' => $promoCode,
                'status' => 'pending',
                'name' => $user->name,
                'phone' => $user->phone,

                'email' => $user->email,
                'client_id' => $user->id,
                'status_id' => 0,
                'shipping' => $request->shipping == null ? 0 : 1,
                'code' => date('Ymd-His') . rand(10, 99),
            ]);
            if ($request->shipping == 1) {
                $shipping = Shipping::create([
                    'order_id' => $order->id,
                    'receiver_name' => $request->receiver_name,
                    'receiver_email' => $request->receiver_email,
                    'receiver_phone' => $request->receiver_phone,

                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country,
                ]);
            }
            // $shipping = Shipping::create($request->all());

//auth
            foreach ($cart['orders'] as $orderData) {
                $frontImage = $orderData['front_image'] ?? null;
                $backImage = $orderData['back_image'] ?? null;
                $rightSideImage = $orderData['right_side_image'] ?? null;
                $leftSideImage = $orderData['left_side_image'] ?? null;

                $logos = $orderData['logos'] ?? [];

                if (!$frontImage) {
                    $this->sendError(__('Front image is missing'));
                }

                $savedImages = $this->saveImagesFromUrls([$frontImage, $backImage,$rightSideImage,$leftSideImage]);
                $savedLogos = $this->saveImagesFromUrls($logos);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_name' => Product::find($orderData['product_id'])->name,
                    'product_id' => $orderData['product_id'],
                    'color_id' => $orderData['color_id'],
                    'size_id' => $orderData['size_id'],
                    'quantity' => $orderData['quantity'],
                    'price_without_size_color' => $orderData['price_without_size_color_price'],
                    'price_for_size_color' => $orderData['price_for_size_color_price'],
                    'full_price' => $orderData['full_price'],
                    'front_image' => $savedImages[0] ?? null,
                    'back_image' => $savedImages[1] ?? null,
                    'right_side_image' => $savedImages[2] ?? null,
                    'left_side_image' => $savedImages[3] ?? null,

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
                'CallBackUrl' => route('payment.success', $order->id),
                'ErrorUrl' =>  route('payment.error', $order->id),
                'Language' => 'ar',
                'CustomerReference' => 'order_' . $order->id,
                'UserDefinedField' => 'CustomData',
            ];

            $response = $this->myFatoorahService->createInvoice($paymentData);

            if (isset($response['Data']['InvoiceURL'])) {

                DB::commit();

                $ress['link'] = $response['Data']['InvoiceURL'];
                return  $this->sendResponse($ress, 'success');
            }
        } catch (\Exception $e) {
            // Rollback Transaction on Error
            DB::rollBack();
            // Log the error for debugging
            $error = new ErrorPayment();
            $error->code =  date('Ymd-His') . rand(10, 99);
            $error->descripton = $e->getMessage();
            $error->full_request = json_encode($request->all());
            $error->save();
            // \Log::error('Order placement failed: ' . $e->getMessage());
            return $this->sendError(__('Payment initiation failed . error code: ' . $error->code));
        }
    }


    public function initiatePayment_guest(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'phone' => 'required',
            'name' => 'required',
            'cart.orders' => 'required|array|min:1',
            'cart.orders.*.front_image' => 'required',
            // 'cart.orders.*.back_image' => 'required|url',
            'cart.orders.*.quantity' => 'required|integer|min:1',
            'cart.orders.*.price_without_size_color_price' => 'required|numeric|min:0',
            'cart.orders.*.price_for_size_color_price' => 'required|numeric|min:0',
            'cart.orders.*.full_price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'promocode' => 'nullable|string',
            'shipping' => 'required|boolean',
            'receiver_name' => $request->shipping == 1 ? 'required' : 'nullable',
            'receiver_email' => $request->shipping == 1 ? 'required|email' : 'nullable',
            'receiver_phone' => $request->shipping == 1 ? 'required' : 'nullable',
            'address' => $request->shipping == 1 ? 'required' : 'nullable',
            'city' => $request->shipping == 1 ? 'required' : 'nullable',
            'postal_code' => $request->shipping == 1 ? 'required' : 'nullable',
            'country' => $request->shipping == 1 ? 'required' : 'nullable',

        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        
        $cart = $request->input('cart');
        $subtotal = $request->input('subtotal');
        $total = $request->input('total_amount');
        $discount = $request->input('discount');
        $promoCode = $request->input('promocode');
       
        try {
            DB::beginTransaction();
            // dd($request->shipping);
            $order = Order::create([
                'total_amount' => $total,
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'promo_code' => $promoCode,
                'status' => 'pending',
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'client_id' =>null,
                'status_id' => 0,
                'shipping' => $request->shipping == null ? 0 : 1,
                'code' => date('Ymd-His') . rand(10, 99),
            ]);
            if ($request->shipping == 1) {
                $shipping = Shipping::create([
                    'order_id' => $order->id,
                    'receiver_name' => $request->receiver_name,
                    'receiver_email' => $request->receiver_email,
                    'receiver_phone' => $request->receiver_phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country,
                ]);
            }
            // $shipping = Shipping::create($request->all());

//guest
            foreach ($cart['orders'] as $orderData) {
                $frontImage = $orderData['front_image'] ?? null;
                $backImage = $orderData['back_image'] ?? null;
                $rightSideImage = $orderData['right_side_image'] ?? null;
                $leftSideImage = $orderData['left_side_image'] ?? null;
                $logos = $orderData['logos'] ?? [];

                if (!$frontImage) {
                    $this->sendError(__('Front image is missing'));
                }

                $savedImages = $this->saveImagesFromUrls([$frontImage, $backImage,$rightSideImage,$leftSideImage]);
                $savedLogos = $this->saveImagesFromUrls($logos);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_name' => Product::find($orderData['product_id'])->name,
                    'product_id' => $orderData['product_id'],
                    'color_id' => $orderData['color_id'],
                    'size_id' => $orderData['size_id'],
                    'quantity' => $orderData['quantity'],
                    'price_without_size_color' => $orderData['price_without_size_color_price'],
                    'price_for_size_color' => $orderData['price_for_size_color_price'],
                    'full_price' => $orderData['full_price'],
                    'front_image' => $savedImages[0] ?? null,
                    'back_image' => $savedImages[1] ?? null,
                    'right_side_image' => $savedImages[2] ?? null,
                    'left_side_image' => $savedImages[3] ?? null,
                    'logos' => json_encode($savedLogos),
                ]);
            }


            $paymentData = [
                'CustomerName' => $request->name,
                'NotificationOption' => 'ALL',
                'InvoiceValue' => $total,
                'DisplayCurrencyIso' => 'SAR',
                'MobileCountryCode' => '+966', // Saudi Arabia country code
                'CustomerMobile' => $request->phone,
                'CustomerEmail' => $request->email,
                'CallBackUrl' => route('payment.success', $order->id),
                'ErrorUrl' =>  route('payment.error', $order->id),
                'Language' => 'ar',
                'CustomerReference' => 'order_' . $order->id,
                'UserDefinedField' => 'CustomData',
            ];

            $response = $this->myFatoorahService->createInvoice($paymentData);

            if (isset($response['Data']['InvoiceURL'])) {

                DB::commit();

                $ress['link'] = $response['Data']['InvoiceURL'];
                return  $this->sendResponse($ress, 'success');
            }
        } catch (\Exception $e) {
            // Rollback Transaction on Error
            DB::rollBack();
            // Log the error for debugging
            $error = new ErrorPayment();
            $error->code =  date('Ymd-His') . rand(10, 99);
            $error->descripton = $e->getMessage();
            $error->full_request = json_encode($request->all());
            $error->save();
            // \Log::error('Order placement failed: ' . $e->getMessage());
            return $this->sendError(__('Payment initiation failed . error code: ' . $error->code));
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
