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
                                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">{{ __('Orders') }}</a>
                                </li>
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
                                                <p><strong>{{ __('Order Date:') }}</strong>
                                                    {{ $order->created_at->format('d-m-Y') }}</p>
                                                <p><strong>{{ __('Total Amount:') }}</strong>
                                                    {{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</p>
                                                <p><strong>{{ __('Status:') }}</strong>
                                                    {{ get_order_status($order->status_id) }}</p>
                                            </div>

                                            <!-- Shipping Information -->
                                            @if ($order->shipping == 1)
                                                <div class="col-md-6">
                                                    <h4>{{ __('Shipping Information') }}</h4>
                                                    @php
                                                        $shipping = \App\Models\Shipping::where(
                                                            'order_id',
                                                            $order->id,
                                                        )->first();
                                                    @endphp
                                                    @if ($shipping)
                                                        <p><strong>{{ __('Receiver Name:') }}</strong>
                                                            {{ $shipping->receiver_name }}</p>
                                                        <p><strong>{{ __('Receiver Email:') }}</strong>
                                                            {{ $shipping->receiver_email }}</p>
                                                        <p><strong>{{ __('Receiver Phone:') }}</strong>
                                                            {{ $shipping->receiver_phone }}</p>

                                                        <p><strong>{{ __('Address:') }}</strong> {{ $shipping->address }}
                                                        </p>
                                                        <p><strong>{{ __('City:') }}</strong> {{ $shipping->city }}</p>
                                                        <p><strong>{{ __('Postal Code:') }}</strong>
                                                            {{ $shipping->postal_code }}</p>
                                                        <p><strong>{{ __('Country:') }}</strong> {{ $shipping->country }}
                                                        </p>
                                                        <p><strong>{{ __('Shipping Status:') }}</strong>
                                                            {{ $shipping->status }}</p>
                                                    @else
                                                        <p>{{ __('No shipping information available for this order.') }}
                                                        </p>
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
                                                                    style="display: inline-block; width: 20px; height: 20px; background-color: {{ get_color($item->color_id)->code }}; border: 1px solid #ccc; margin-right: 10px;">
                                                                </span>
                                                                {{ get_color($item->color_id)->name }}
                                                            </div>
                                                        </td>
                                                        <td>{{ get_size($item->size_id) }}</td>
                                                        <td>{{ number_format($item->price_without_size_color, 2) }}
                                                            {{ __('SAR') }}</td>
                                                        <td>{{ number_format($item->price_for_size_color, 2) }}
                                                            {{ __('SAR') }}</td>
                                                        <td>{{ number_format($item->full_price, 2) }} {{ __('SAR') }}
                                                        </td>
                                                    </tr>

                                                    <!-- Row for Images -->
                                                    <tr class="{{ $key % 2 == 1 ? '' : 'bg-light-dark' }}">
                                                        <td colspan="8">
                                                            <div class="d-flex flex-wrap">
                                                                @php
                                                                    $dummy_image = asset('images/dummy.png');
                                                                    dd( $item->productImages['front_images']['url']);
                                                                    $images = [
                                                                        'front' => [
                                                                            'src' => $item->front_image,
                                                                            'alt' => __('Front View'),
                                                                            'all' =>
                                                                                $item->productImages->front_images ??
                                                                                [],
                                                                        ],
                                                                        'back' => [
                                                                            'src' => $item->back_image,
                                                                            'alt' => __('Back View'),
                                                                            'all' =>
                                                                                $item->productImages->back_images ?? [],
                                                                        ],
                                                                        'right' => [
                                                                            'src' => $item->right_side_image,
                                                                            'alt' => __('Right Side View'),
                                                                            'all' =>
                                                                                $item->productImages
                                                                                    ->right_side_images ?? [],
                                                                        ],
                                                                        'left' => [
                                                                            'src' => $item->left_side_image,
                                                                            'alt' => __('Left Side View'),
                                                                            'all' =>
                                                                                $item->productImages
                                                                                    ->left_side_images ?? [],
                                                                        ],
                                                                    ];
                                                                @endphp

                                                                @foreach ($images as $type => $img)
                                                                    @php
                                                                        $img_src = $img['src']
                                                                            ? asset('storage/' . $img['src'])
                                                                            : $dummy_image;
                                                                        $modal_id = "imageModal{$key}_{$type}";
                                                                    @endphp
                                                                    <div class="p-2">
                                                                        <a href="#" data-toggle="modal"
                                                                            data-target="#{{ $modal_id }}">
                                                                            <img src="{{ $img_src }}"
                                                                                alt="{{ $img['alt'] }}"
                                                                                class="img-fluid img-thumbnail"
                                                                                style="max-width: 150px;">
                                                                        </a>
                                                                        <p class="text-center">{{ $img['alt'] }}</p>
                                                                    </div>

                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="{{ $modal_id }}"
                                                                        tabindex="-1" role="dialog"
                                                                        aria-labelledby="{{ $modal_id }}Label"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog modal-lg" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">
                                                                                        {{ $img['alt'] }}</h5>
                                                                                    <button type="button" class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body text-center">
                                                                                    <img id="mainImage{{ $key }}_{{ $type }}"
                                                                                        src="{{ $img_src }}"
                                                                                        class="img-fluid"
                                                                                        style="max-width: 100%;">
                                                                                    <hr>
                                                                                    <div
                                                                                        class="d-flex justify-content-center">
                                                                                        @foreach ($img['all'] as $thumb_index => $thumb)
                                                                                            @php
                                                                                                $thumb_src = asset(
                                                                                                    'storage/' . $thumb,
                                                                                                );
                                                                                            @endphp
                                                                                            <img src="{{ $thumb_src }}"
                                                                                                class="img-thumbnail mx-2"
                                                                                                style="width: 75px; cursor: pointer;"
                                                                                                onclick="document.getElementById('mainImage{{ $key }}_{{ $type }}').src='{{ $thumb_src }}'">
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
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
