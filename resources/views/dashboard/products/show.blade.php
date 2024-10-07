@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('Product Details') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('products.index') }}">{{ __('Products') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('Product Details') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Product Details -->
            <section id="product-details">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ __('Product Details') }}</h4>
                            </div>
                            <div class="card-content collpase show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5>{{ __('Name') }}:</h5>
                                            <p>{{ $product->name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>{{ __('Price') }}:</h5>
                                            <p>{{ $product->price }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>{{ __('Description') }}:</h5>
                                            <p>{{ $product->description }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>{{ __('Colors') }}:</h5>
                                            @foreach ($product->colors as $color)
                                                <div class="mb-2">
                                                    <strong>{{ $color->name }}</strong><br>
                                                    <img src="{{ asset('storage/' . $color->front_image) }}" width="50" height="50" alt="Front Image">
                                                    @if ($color->back_image)
                                                        <img src="{{ asset('storage/' . $color->back_image) }}" width="50" height="50" alt="Back Image">
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>{{ __('Sizes') }}:</h5>
                                            @foreach ($product->sizes as $size)
                                                <div class="mb-2">
                                                    <strong>{{ $size->name }}:</strong> {{ $size->price }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">{{ __('Edit') }}</a>
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary">{{ __('Back to List') }}</a>
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
