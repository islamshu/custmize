<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نجاح العملية</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f6f9;
        }
        .container-box {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            padding: 30px;
            margin-top: 40px;
        }
        .success-title {
            color: #28a745;
        }
        .table img {
            width: 80px;
            height: auto;
            border-radius: 5px;
        }
        .btn-back {
            background-color: #28a745;
            color: white;
            padding: 10px 25px;
            font-size: 16px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-back:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container container-box">
    <div class="text-center mb-4">
        <h1 class="success-title">نجاح العملية</h1>
        <p class="text-muted">تمت العملية بنجاح. شكراً لتعاملكم معنا!</p>
    </div>

    <div class="row g-4">
        @if ($order->shipping == 1)
        <div class="col-md-6">
            <div class="border rounded p-3 bg-light">
                <h5 class="mb-3">بيانات الشحن</h5>
                @php
                    $shipping = \App\Models\Shipping::where('order_id', $order->id)->first();
                @endphp
                @if ($shipping)
                    <p><strong>اسم المستلم:</strong> {{ $shipping->receiver_name }}</p>
                    <p><strong>البريد الإلكتروني:</strong> {{ $shipping->receiver_email }}</p>
                    <p><strong>الهاتف:</strong> {{ $shipping->receiver_phone }}</p>
                    <p><strong>العنوان:</strong> {{ $shipping->address }}</p>
                    <p><strong>المدينة:</strong> {{ $shipping->city }}</p>
                    <p><strong>الرمز البريدي:</strong> {{ $shipping->postal_code }}</p>
                    <p><strong>الدولة:</strong> {{ $shipping->country }}</p>
                    <p><strong>الحالة:</strong> {{ $shipping->status }}</p>
                @else
                    <p class="text-danger">لا توجد بيانات شحن لهذا الطلب.</p>
                @endif
            </div>
        </div>
        @endif

        <div class="col-md-6">
            <div class="border rounded p-3 bg-light">
                <h5 class="mb-3">معلومات الطلب</h5>
                <p><strong>رقم الطلب:</strong> {{ $order->code }}</p>
                <p><strong>الاسم:</strong> {{ $order->name }}</p>
                <p><strong>البريد الإلكتروني:</strong> {{ $order->email }}</p>
                <p><strong>المبلغ الإجمالي:</strong> {{ number_format($order->total_amount, 2) }} ريال</p>
                <p><strong>الخصم:</strong> {{ number_format($order->discount_amount, 2) }} ريال</p>
                <p><strong>المجموع الفرعي:</strong> {{ number_format($order->subtotal, 2) }} ريال</p>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h5 class="mb-3">تفاصيل الطلب</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>الأمامية</th>
                        <th>الخلفية</th>
                        <th>اليمين</th>
                        <th>اليسار</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $url = env('APP_ENV') == 'production' 
                            ? 'http://custmize.digitalgo.net/storage/' 
                            : 'http://127.0.0.1:8000/storage/';
                    @endphp
                    @foreach ($order->details as $detail)
                        <tr>
                            <td>{{ $detail->product_id }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->full_price, 2) }} ريال</td>
                            <td>
                                <img src="{{ isset($detail->front_image) ? asset('storage/'.$detail->front_image) : asset('images/placeholder.png') }}" alt="أمامية">
                            </td>
                            <td>
                                @if($detail->back_image)
                                    <img src="{{ $url.$detail->back_image }}" alt="خلفية">
                                @else
                                    _
                                @endif
                            </td>
                            <td>
                                @if($detail->right_side_image)
                                    <img src="{{ $url.$detail->right_side_image }}" alt="يمين">
                                @else
                                    _
                                @endif
                            </td>
                            <td>
                                @if($detail->left_side_image)
                                    <img src="{{ $url.$detail->left_side_image }}" alt="يسار">
                                @else
                                    _
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ get_general_value('front_url') }}" class="btn-back">العودة إلى الموقع</a>
    </div>

    <div class="text-center mt-3 text-muted">
        <p>إذا كان لديك أي استفسارات، لا تتردد في الاتصال بنا.</p>
    </div>
</div>

</body>
</html>
