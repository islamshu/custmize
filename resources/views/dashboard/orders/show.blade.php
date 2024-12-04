@extends('layouts.master')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('Order Details') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">{{ __('Orders') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Order Details') }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Order Details Section -->
                <section id="order-details">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('Order Details') }}</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>{{ __('Order Number:') }}</strong> {{ $order->code }}</p>
                                                <p><strong>{{ __('Customer Name:') }}</strong> {{ $order->client->name }}</p>
                                                <p><strong>{{ __('Email:') }}</strong> {{ $order->email }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>{{ __('Order Date:') }}</strong> {{ $order->created_at->format('d-m-Y') }}</p>
                                                <p><strong>{{ __('Total Amount:') }}</strong> {{ number_format($order->total_amount, 2) }} {{ __('SAR') }}</p>
                                                <p><strong>{{ __('Status:') }}</strong> {{ $order->status }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <h4>{{ __('Order Items') }}</h4>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('Product Name') }}</th>
                                                    <th>{{ __('Quantity') }}</th>
                                                    <th>{{ __('Price without size or color') }}</th>
                                                    <th>{{ __('Price for size or color') }}</th>
                                                    <th>{{ __('Total') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->details as $key => $item)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $item->product_name }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ number_format($item->price_without_size_color, 2) }} {{ __('SAR') }}</td>
                                                        <td>{{ number_format($item->price_for_size_color, 2) }} {{ __('SAR') }}</td>
=
                                                        <td>{{ number_format($item->full_price, 2) }} {{ __('SAR') }}</td>
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
