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
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: green;
        }
        .order-info, .order-details {
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
                </tr>
            </thead>
            <tbody>
                @php
                    if(env('APP_ENV') == 'production'){
                        $url = 'http://custmize.digitalgo.net/storage/images/';
                    }else{
                        $url = 'http://127.0.0.1:8000/storage/images/';

                    }
                @endphp
                @foreach ($order->details as $detail)
                    <tr>
                        <td>{{ $detail->product_id }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->full_price, 2) }} ريال</td>
                        <td>    <img src="{{ $url.$detail->front_image }}" alt="الصورة الأمامية" style="width: 100px; height: auto;"></td>
                        <td>@if($detail->back_image == null) {{'_'}} @else<img src="{{ $url. $detail->back_image)}}" alt="الصورة الخلفية" style="width: 100px; height: auto;">@endif</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>إذا كان لديك أي استفسارات، لا تتردد في الاتصال بنا.</p>
    </div>
</div>

</body>
</html>
