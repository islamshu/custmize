<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نجاح العملية</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 20px;
            direction: rtl;
            text-align: right;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .section {
            width: 48%;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: green;
        }
        .order-info, .shipping-info, .order-details {
            margin-bottom: 20px;
        }
        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-details table th, .order-details table td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        .order-details table th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- بيانات الطلب في الجهة اليمنى -->
    <div class="section">
        <div class="header">
            <h1>نجاح العملية</h1>
            <p>تمت العملية بنجاح. شكراً لتعاملكم معنا!</p>
        </div>

        <div class="order-info">
            <h2>معلومات الطلب</h2>
            <p><strong>رقم الطلب:</strong> {{ $order->code }}</p>
            <p><strong>الإسم:</strong> {{ $order->name }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $order->email }}</p>
            <p><strong>المبلغ الإجمالي:</strong> {{ number_format($order->total_amount, 2) }} ريال</p>
            <p><strong>الخصم:</strong> {{ number_format($order->discount_amount, 2) }} ريال</p>
            <p><strong>المجموع الفرعي:</strong> {{ number_format($order->subtotal, 2) }} ريال</p>
        </div>

        <div class="order-details">
            <h2>تفاصيل الطلب</h2>
            <table>
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>الصورة الأمامية</th>
                        <th>الصورة الخلفية</th>
                        <th>الصورة من الجانب اليمين</th>
                        <th>الصورة من الجانب اليسار</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        if(env('APP_ENV') == 'production'){
                            $url = 'http://custmize.digitalgo.net/storage/';
                        }else{
                            $url = 'http://127.0.0.1:8000/storage/';
                        }
                    @endphp
                    @foreach ($order->details as $detail)
                        <tr>
                            <td>{{ $detail->product_id }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->full_price, 2) }} ريال</td>
                            <td>
                                <img 
                                    src="{{ isset($detail->front_image) ? asset('storage/'.$detail->front_image) : asset('images/placeholder.png') }}" 
                                    alt="الصورة الأمامية" 
                                    style="width: 100px; height: auto;"
                                >
                            </td>
                            <td>
                                @if($detail->back_image == null) 
                                    {{'_'}} 
                                @else
                                    <img src=" {{ $url.$detail->back_image }}" alt="الصورة الخلفية" style="width: 100px; height: auto;">
                                @endif
                            </td>
                            <td>
                                @if($detail->right_side_image == null) 
                                    {{'_'}} 
                                @else
                                    <img src=" {{ $url.$detail->right_side_image }}" alt="الصورة الخلفية" style="width: 100px; height: auto;">
                                @endif
                            </td>
                            <td>
                                @if($detail->left_side_image == null) 
                                    {{'_'}} 
                                @else
                                    <img src=" {{ $url.$detail->left_side_image }}" alt="الصورة الخلفية" style="width: 100px; height: auto;">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- بيانات الشحن في الجهة اليسرى -->
    @if ($order->shipping == 1)
        <div class="section">
            <h2>بيانات الشحن</h2>
            @php
                $shipping = \App\Models\Shipping::where('order_id', $order->id)->first();
            @endphp
            @if ($shipping)
                <p><strong>إسم المستلم:</strong> {{ $shipping->receiver_name }}</p>
                <p><strong>العنوان:</strong> {{ $shipping->address }}</p>
                <p><strong>المدينة:</strong> {{ $shipping->city }}</p>
                <p><strong>الرمز البريدي:</strong> {{ $shipping->postal_code }}</p>
                <p><strong>الدولة:</strong> {{ $shipping->country }}</p>
                <p><strong>الحالة:</strong> {{ $shipping->status }}</p>
            @else
                <p>لا توجد بيانات شحن لهذا الطلب.</p>
            @endif
        </div>
    @endif
</div>

</body>
</html>
