<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\MyFatoorahService;
use Darryldecode\Cart\Facades\CartFacade as Cart;

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
    if($promoCode != null){
        $discountCode = DiscountCode::where('code', $promoCode)
        ->where('start_at', '<=', now())
        ->where('end_at', '>=', now())
        ->first();
        if (!$discountCode) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired promo code.']);
        }
        $discountValue = $discountCode->discount_value;
        $discountType = $discountCode->discount_type;
        if ($discountType === 'fixed') {
            // Apply fixed discount
            $discountAmount = min($discountValue, $total); // Ensure we don't discount more than the total
            $total = $total - $discountAmount;
        } elseif ($discountType === 'rate') {
            // Apply percentage discount
            $discountAmount = $subtotal * ($discountValue / 100); // Calculate the discount amount based on the percentage
            $total = $total - $discountAmount;

        }

    }
    $order = Order::create([
        'total_amount' => $total + $discountAmount,
        'subtotal' => $subtotal,
        'discount_amount' => $discountAmount,
        'promo_code' => $promoCode,
        'status' => 'pending',
        'name' => $name,
        'email' => $email,
        'code' => date('Ymd-His') . rand(10, 99),
        'order_status'=>'pending',
    ]);
    $guestId = session('guest_id');

    Cart::session($guestId);

    // Get cart content for the guest
    $cartItems = Cart::getContent();    
    foreach ($cartItems as $item) {
        $order->items()->create([
            'product_id' => $item->id,
            'name' => $item->name,
            'price' => $item->price,
            'quantity' => $item->quantity,
            'attributes' => $item->attributes->toArray(), // Convert attributes to array
            'front_image' => $item->front_image,
            'front_design' => $item->front_design,
        ]);
    }
    $data = [
        'CustomerName'       => $name,
        'NotificationOption' => 'ALL',
        'InvoiceValue'       => $total , // قيمة الدفع
        'DisplayCurrencyIso' => 'KWD', // تغيير إلى العملة المطلوبة
        'MobileCountryCode'  => '+965',
        'CustomerMobile'     => '12345678',
        'CustomerEmail'      => $email,
        'CallBackUrl'        => route('payment.callback',$order->id), // رابط النجاح
        'ErrorUrl'           => route('payment.error',$order->id), // رابط الخطأ
        'Language'           => 'en',
        'CustomerReference'  =>$order->code, // مرجع الطلب
    ];

    $response = $this->myFatoorahService->createInvoice($data);
    // التحقق من استجابة MyFatoorah
    if (isset($response['Data']['InvoiceURL'])) {

        return response()->json([
            'success' => true,
            'payment_url' => $response['Data']['InvoiceURL']
        ]);
        // إعادة توجيه المستخدم إلى رابط الدفع
    }else{
        $order->delete();
    }

    // التعامل مع الأخطاء إذا لم يتم العثور على رابط الدفع
    return back()->with('error', 'فشل في إنشاء الدفع. يرجى المحاولة مرة أخرى.');
}


    public function paymentCallback($order_id)
    {
        $order = Order::find($order_id);
        $order->satus = 'success';
        $order->save();
        $cartItems = Cart::getContent();
        
        return view('payment.success'); // Create a success view for successful payments
    }

    public function error($order_id)
    {
        dd($order_id.' '.'error');

        return view('payment.error'); // Create an error view for failed payments
    }
}
