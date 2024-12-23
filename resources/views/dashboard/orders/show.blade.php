@extends('layouts.master')
@section('style')
<style>
    .bg-light-dark {
    background-color: #bfbfbf !important; /* لون غامق خفيف */
}
</style>
@endsection
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('Order Details') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">{{ __('Orders') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Order Details') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="order-details">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('Order Details') }}</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <!-- General Order Details -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>{{ __('Order Number:') }}</strong> {{ $order->code }}</p>
                                            <p><strong>{{ __('Customer Name:') }}</strong> {{ $order->name }}</p>
                                            <p><strong>{{ __('Email:') }}</strong> {{ $order->email }}</p>
                                            <p><strong>{{ __('Phone:') }}</strong> {{ $order->phone }}</p>

                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>{{ __('Order Date:') }}</strong> {{ $order->created_at->format('d-m-Y') }}</p>
                                            <p><strong>{{ __('Total Amount:') }}</strong> {{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</p>
                                            <p><strong>{{ __('Status:') }}</strong> {{ $order->status }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- Order Items Table -->
                                    <h4>{{ __('Order Items') }}</h4>
                                    <table class="table table-striped table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Product Name') }}</th>
                                                <th>{{ __('Quantity') }}</th>
                                                <th>{{ __('Color') }}</th>
                                                <th>{{ __('Size') }}</th>
                                                <th>{{ __('Price without size or color') }}</th>
                                                <th>{{ __('Price for size or color') }}</th>
                                                <th>{{ __('Total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->details as $key => $item)
                                                <!-- Main Row -->
                                                <tr class="{{ $key % 2 == 1 ? '' : 'bg-light-dark' }}">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->product_name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span 
                                                                style="display: inline-block; width: 20px; height: 20px; background-color: {{ get_color($item->color_id)->code}}; border: 1px solid #ccc; margin-right: 10px;">
                                                            </span>
                                                            {{ get_color($item->color_id)->name}} 
                                                        </div>
                                                    </td>                                                    <td>{{ get_size($item->size_id) }}</td>
                                                    <td>{{ number_format($item->price_without_size_color, 2) }} {{ __('SAR') }}</td>
                                                    <td>{{ number_format($item->price_for_size_color, 2) }} {{ __('SAR') }}</td>
                                                    <td>{{ number_format($item->full_price, 2) }} {{ __('SAR') }}</td>
                                                </tr>
                                                <!-- Row for Images -->
                                                <tr class="{{ $key % 2 == 1 ? '' : 'bg-light-dark' }}">
                                                    <td colspan="8">
                                                        <div class="d-flex flex-wrap">
                                                            @if($item->front_image)
                                                                <div class="p-2">
                                                                    <img src="{{ asset('storage/' . $item->front_image) }}" alt="{{ __('Front View') }}" class="img-fluid img-thumbnail" style="max-width: 150px;">
                                                                    <p class="text-center">{{ __('Front View') }}</p>
                                                                </div>
                                                            @endif
                                                            @if($item->back_image)
                                                                <div class="p-2">
                                                                    <img src="{{ asset('storage/' . $item->back_image) }}" alt="{{ __('Back View') }}" class="img-fluid img-thumbnail" style="max-width: 150px;">
                                                                    <p class="text-center">{{ __('Back View') }}</p>
                                                                </div>
                                                            @endif
                                                            @if($item->right_side_image)
                                                                <div class="p-2">
                                                                    <img src="{{ asset('storage/' . $item->right_side_image) }}" alt="{{ __('Right Side View') }}" class="img-fluid img-thumbnail" style="max-width: 150px;">
                                                                    <p class="text-center">{{ __('Right Side View') }}</p>
                                                                </div>
                                                            @endif
                                                            @if($item->left_side_image)
                                                                <div class="p-2">
                                                                    <img src="{{ asset('storage/' . $item->left_side_image) }}" alt="{{ __('Left Side View') }}" class="img-fluid img-thumbnail" style="max-width: 150px;">
                                                                    <p class="text-center">{{ __('Left Side View') }}</p>
                                                                </div>
                                                            @endif
                                                            @if($item->logos)
                                                                @foreach (json_decode($item->logos) as $logo)
                                                                    @if($logo)
                                                                        <div class="p-2">
                                                                            <img src="{{ asset('storage/' . $logo) }}" alt="{{ __('Logos') }}" class="img-fluid img-thumbnail" style="max-width: 150px;">
                                                                            <p class="text-center">{{ __('Logos') }}</p>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
