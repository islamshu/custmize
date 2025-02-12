@extends('layouts.master')
@section('style')
<style>
    .bg-light-dark {
        background-color: #bfbfbf !important;
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
                                        <!-- Order Information -->
                                        <div class="col-md-6">
                                            <h4>{{ __('Order Information') }}</h4>
                                            <p><strong>{{ __('Order Number:') }}</strong> {{ $order->code }}</p>
                                            <p><strong>{{ __('Customer Name:') }}</strong> {{ $order->name }}</p>
                                            <p><strong>{{ __('Email:') }}</strong> {{ $order->email }}</p>
                                            <p><strong>{{ __('Phone:') }}</strong> {{ $order->phone }}</p>
                                            <p><strong>{{ __('Order Date:') }}</strong> {{ $order->created_at->format('d-m-Y') }}</p>
                                            <p><strong>{{ __('Total Amount:') }}</strong> {{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</p>
                                            <p><strong>{{ __('Status:') }}</strong> {{ get_order_status($order->status_id) }}</p>
                                        </div>
                                        
                                        <!-- Shipping Information -->
                                        @if ($order->shipping == 1)
                                            <div class="col-md-6">
                                                <h4>{{ __('Shipping Information') }}</h4>
                                                @php
                                                    $shipping = \App\Models\Shipping::where('order_id', $order->id)->first();
                                                @endphp
                                                @if ($shipping)
                                                    <p><strong>{{ __('Receiver Name:') }}</strong> {{ $shipping->receiver_name }}</p>
                                                    <p><strong>{{ __('Receiver Email:') }}</strong> {{ $shipping->receiver_email }}</p>
                                                    <p><strong>{{ __('Receiver Phone:') }}</strong> {{ $shipping->receiver_phone }}</p>

                                                    <p><strong>{{ __('Address:') }}</strong> {{ $shipping->address }}</p>
                                                    <p><strong>{{ __('City:') }}</strong> {{ $shipping->city }}</p>
                                                    <p><strong>{{ __('Postal Code:') }}</strong> {{ $shipping->postal_code }}</p>
                                                    <p><strong>{{ __('Country:') }}</strong> {{ $shipping->country }}</p>
                                                    <p><strong>{{ __('Shipping Status:') }}</strong> {{ $shipping->status }}</p>
                                                @else
                                                    <p>{{ __('No shipping information available for this order.') }}</p>
                                                @endif
                                            </div>
                                        @endif
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
                                                    </td>
                                                    <td>{{ get_size($item->size_id) }}</td>
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
                                                                    <!-- Image with modal trigger -->
                                                                    <img src="{{ asset('storage/' . $item->front_image) }}" alt="{{ __('Front View') }}" class="img-fluid img-thumbnail" style="max-width: 150px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal{{ $item->id }}Front">
                                                                    <p class="text-center">{{ __('Front View') }}</p>
                                                                    <!-- Dummy images -->
                                                                    <div class="d-flex justify-content-center mt-2">
                                                                        <img src="https://via.placeholder.com/50" alt="Dummy 1" class="img-thumbnail mx-1" style="max-width: 50px;">
                                                                        <img src="https://via.placeholder.com/50" alt="Dummy 2" class="img-thumbnail mx-1" style="max-width: 50px;">
                                                                    </div>
                                                                </div>
                                                                <!-- Modal for front image -->
                                                                <div class="modal fade" id="imageModal{{ $item->id }}Front" tabindex="-1" aria-labelledby="imageModalLabel{{ $item->id }}Front" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="imageModalLabel{{ $item->id }}Front">{{ __('Front View') }}</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body text-center">
                                                                                <img src="{{ asset('storage/' . $item->front_image) }}" alt="{{ __('Front View') }}" class="img-fluid">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if($item->back_image)
                                                                <div class="p-2">
                                                                    <!-- Image with modal trigger -->
                                                                    <img src="{{ asset('storage/' . $item->back_image) }}" alt="{{ __('Back View') }}" class="img-fluid img-thumbnail" style="max-width: 150px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal{{ $item->id }}Back">
                                                                    <p class="text-center">{{ __('Back View') }}</p>
                                                                    <!-- Dummy images -->
                                                                    <div class="d-flex justify-content-center mt-2">
                                                                        <img src="https://via.placeholder.com/50" alt="Dummy 1" class="img-thumbnail mx-1" style="max-width: 50px;">
                                                                        <img src="https://via.placeholder.com/50" alt="Dummy 2" class="img-thumbnail mx-1" style="max-width: 50px;">
                                                                    </div>
                                                                </div>
                                                                <!-- Modal for back image -->
                                                                <div class="modal fade" id="imageModal{{ $item->id }}Back" tabindex="-1" aria-labelledby="imageModalLabel{{ $item->id }}Back" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="imageModalLabel{{ $item->id }}Back">{{ __('Back View') }}</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body text-center">
                                                                                <img src="{{ asset('storage/' . $item->back_image) }}" alt="{{ __('Back View') }}" class="img-fluid">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <!-- Repeat the same structure for right_side_image, left_side_image, and logos -->
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