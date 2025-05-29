{{-- resources/views/dashboard/external_product/show.blade.php --}}
@extends('layouts.master')

@section('title', $product['name'])
@section('style')
    <style>
        .price-original {
            text-decoration: line-through;
            color: #888;
        }

        .price-discount {
            font-weight: bold;
            color: #e74c3c;
        }

        .stock-available {
            color: #27ae60;
        }

        .stock-out {
            color: #e74c3c;
        }
    </style>
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('تفاصيل المنتج الخارجي') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('external-products.index') }}">{{ __('المنتجات الخارجية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('تفاصيل المنتج') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $product['name'] }}</h4>
                        <a href="{{ route('external-products.index') }}" class="btn btn-sm btn-primary">
                            <i class="ft-arrow-right"></i> {{ __('العودة للقائمة') }}
                        </a>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                {{-- الصورة الرئيسية --}}
                                <div class="col-md-4 mb-3">
                                    <div class="border rounded p-2 text-center">
                                        <img src="{{ $product['image_url'] }}" class="img-fluid" alt="Product Image">
                                    </div>
                                </div>

                                {{-- تفاصيل المنتج --}}
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody>
                                                <tr>
                                                    <th width="30%">{{ __('كود المنتج') }}</th>
                                                    <td>{{ $product['default_code'] ?? 'غير متوفر' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('الوصف') }}</th>
                                                    <td>{!! nl2br(e($product['description_sale'])) !!}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('اللون') }}</th>
                                                    <td>{{ $product['color'] ?? 'غير محدد' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('قابل للتخصيص') }}</th>
                                                    <td>{{ $product['configurable'] ? 'نعم' : 'لا' }}</td>
                                                </tr>
                                                @if ($product['brand_id'])
                                                    <tr>
                                                        <th>{{ __('العلامة التجارية') }}</th>
                                                        <td>{{ $product['brand_id'][1] }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- التصنيفات والسمات --}}
                            <div class="row mt-2">
                                @if (!empty($product['public_categ_ids']))
                                    <div class="col-md-6">
                                        <h5>{{ __('التصنيفات') }}</h5>
                                        <div class="tags">
                                            @foreach ($product['public_categ_ids'] as $cat)
                                                <span class="badge badge-primary">{{ $cat['name'] }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($product['product_template_attribute_value_ids']))
                                    <div class="col-md-6">
                                        <h5>{{ __('السمات') }}</h5>
                                        <div class="tags">
                                            @foreach ($product['product_template_attribute_value_ids'] as $attr)
                                                <span class="badge badge-info">{{ $attr['display_name'] }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            {{-- قسم المخزون والسعر --}}
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ __('معلومات المخزون') }}</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th width="40%">{{ __('حالة المخزون') }}</th>
                                                            <td>
                                                                <span
                                                                    class="badge {{ $product['stock_status'] == 'متوفر' ? 'badge-success' : 'badge-danger' }}">
                                                                    {{ $product['stock_status'] }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __('الكمية المتاحة') }}</th>
                                                            <td>{{ $product['net_available_qty'] }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ __('معلومات السعر') }}</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th width="40%">{{ __('السعر الأساسي') }}</th>
                                                            <td>{{ number_format($product['price'], 2) }}
                                                                {{ $product['currency'] }}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- الصور الإضافية --}}
                            @if (!empty($product['images'][0]))
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h5>{{ __('صور إضافية') }}</h5>
                                        <div class="row">
                                            @foreach ($product['images'][0] as $img)
                                                <div class="col-md-3 col-6 mb-2">
                                                    <div class="border rounded p-1">
                                                        <img src="{{ $img['image_url'] }}" class="img-fluid"
                                                            alt="Extra Image">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
