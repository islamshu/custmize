@extends('layouts.frontend')

@section('style')
<style>
/* الشريط المائل */
/* شريط تتبع الطلب الثابت في الأعلى */
/* تصميم البطاقة */
.order-tracking-card {
    border: 2px solid #28a745;
    border-radius: 10px;
    padding: 20px;
    background-color: #f8f9fa;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.order-tracking-card h4 {
    color: #28a745;
    font-family: 'Cairo', sans-serif;
}

.track-btn-card {
    display: inline-block;
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    margin-top: 10px;
    transition: background-color 0.3s;
}

.track-btn-card:hover {
    background-color: #fff;
    color: #28a745;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}


</style>
@endsection

@section('content')
<div class="container">
    <div class="order-summary text-center">
        <!-- الشريط المائل -->
        
    
        <h3><i class="fas fa-check-circle"></i> شكراً لطلبك! تم تقديم طلبك بنجاح.</h3>
        <div class="order-tracking-card">
            <h4>يرجى حفظ رقم الطلب لتتبع الطلب</h4>
            <p>رقم الطلب: {{ $order->code }}#</p>
            <a href="#" class="track-btn-card">تتبع الطلب</a>
            <p><strong>الاسم:</strong> {{ $order->name }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $order->email }}</p>
            <p><strong>المبلغ:</strong> ${{ number_format($order->total_amount, 2) }}</p>
            <p><strong>قيمة الخصم:</strong> ${{ number_format($order->discount_amount, 2) }}</p>
            <p><strong>المبلغ الإجمالي:</strong> ${{ number_format($order->total_amount - $order->discount_amount, 2) }}</p>
           
        </div>
        {{-- <p><strong>رقم الطلب:</strong> {{ $order->code }}#</p> --}}
       
    </div>
    <div class="order-details">
        <h4><i class="fas fa-list"></i> تفاصيل الطلب:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>اللون</th>
                    <th>الحجم</th>
                    <th>تصميم المنتج</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($order->items as $item)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img width="100" height="100" src="{{ asset('storage/uploads/' . $item->front_image) }}" alt="{{ $item->name }}">
                        </div>
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->attributes['color'] ?? 'N/A' }}</td>
                    <td>{{ $item->attributes['size'] ?? 'N/A' }}</td>
                    <td class="product-design">
                        <img width="100" height="100" src="{{ asset('storage/uploads/' . $item->front_design) }}" alt="تصميم المنتج">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
