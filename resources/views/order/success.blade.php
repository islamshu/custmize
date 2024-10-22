@extends('layouts.frontend')

@section('style')
<style>
    .order-summary {
        border: 1px solid #ddd;
        padding: 20px;
        margin-top: 20px;
        border-radius: 10px;
        background-color: #f8f9fa;
    }
    .order-summary h3 {
        margin-bottom: 20px;
        color: #28a745;
    }
    .order-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .order-item:last-child {
        border-bottom: none;
    }
    .order-item img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
    .order-details {
        margin-top: 30px;
    }
    .order-details h4 {
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="order-summary">
        <h3>شكراً لطلبك! تم تقديم طلبك بنجاح.</h3>
        <p>رقم الطلب: {{ $order->code }}</p>
        <p>الاسم: {{ $order->name }}</p>
        <p>البريد الإلكتروني: {{ $order->email }}</p>
        <p>المبلغ الإجمالي: ${{ number_format($order->total_amount, 2) }}</p>
    </div>

    <div class="order-details">
        <h4>تفاصيل الطلب:</h4>
        @foreach ($order->items as $item)
            <div class="order-item">
                <div>
                    <img src="{{ asset('uploads/' . $item->front_image) }}" alt="{{ $item->name }}">
                    <strong>{{ $item->name }}</strong>
                    <p>الكمية: {{ $item->quantity }}</p>
                    <p>السعر: ${{ number_format($item->price, 2) }}</p>
                    <p>اللون: {{ $item->attributes['color'] ?? 'N/A' }}</p>
                    <p>الحجم: {{ $item->attributes['size'] ?? 'N/A' }}</p>
                </div>
                <div>
                    <img src="{{ asset('uploads/' . $item->front_design) }}" alt="تصميم المنتج" width="100">
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
