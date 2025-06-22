@extends('layouts.master')
@section('style')
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        .custom-switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }

        .custom-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .custom-control-label::before {
            position: absolute;
            top: 0;
            left: -2.25rem;
            display: block;
            width: 2.5rem;
            height: 1.4rem;
            content: "";
            background-color: #adb5bd;
            border-radius: 1rem;
            transition: background-color 0.3s ease-in-out;
        }

        .custom-control-label::after {
            position: absolute;
            top: 0.1rem;
            left: -2.2rem;
            width: 1.2rem;
            height: 1.2rem;
            background-color: #fff;
            content: "";
            border-radius: 50%;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        /* لما يكون مفعل - الزر الأخضر والرأس تتحرك لليمين */
        .custom-control-input:checked~.custom-control-label::before {
            background-color: #28a745;
            right: -18px !important;
        }

        .custom-control-input:checked~.custom-control-label::after {
            transform: translateX(1.2rem);
        }
    </style>
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('المنتجات المستوردة') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a>
                                </li>

                                <li class="breadcrumb-item active">{{ __('المنتجات المستوردة') }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- DOM - jQuery events table -->

                <!-- Row created callback -->
                <!-- File export table -->
                <section id="file-export">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header row">
                                    <div class="col-md-">
                                        <h4 class="card-title">{{ __('المنتجات المستوردة') }}</h4>


                                    </div>

                                    <div class="col-md-" style="margin-right:2%">



                                    </div>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>

                                        </ul>
                                    </div>
                                    <div class="margin-right">

                                    </div>
                                </div>
                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">
                                        @include('dashboard.inc.alerts')


                                        <table class="table table-striped table-bordered file-export" id="storestable">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>اسم المنتج</th>
                                                    <th>الماركة</th>
                                                    <th>الصورة</th>
                                                    <th>السعر</th>
                                                    <th>عدد الألوان</th>
                                                    <th>يظهر بالموقع ؟</th>
                                                    <th>الإجراءات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($externalProducts as $product)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->brand }}</td>
                                                        <td>
                                                            @if ($product->image)
                                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                                    width="80" class="img-thumbnail">
                                                            @else
                                                                <span class="text-muted">لا توجد صورة</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $product->price ?? 'لا يوجد سعر' }}</td>

                                                        <td>{{ $product->colors->count() }}</td>
                                                        <td>
                                                            @if ($product->price)
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" data-id="{{ $product->id }}"
                                                                        name="is_active" class="js-switch"
                                                                        {{ $product->is_active == 1 ? 'checked' : '' }}>
                                                                @else
                                                                    <span class="badge badge-danger">لا يوجد سعر</span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <a href="{{ route('external-products.edit', $product->id) }}"
                                                                class="btn btn-sm btn-primary">تعديل</a>

                                                            <form
                                                                action="{{ route('external-products.destroy', $product->id) }}"
                                                                method="POST" style="display:inline-block"
                                                                onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger">حذف</button>
                                                            </form>
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
                <!-- File export table -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $("#storestable").on("change", ".js-switch", function() {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let userId = $(this).data('id');
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: '{{ route('external-products.toggle-active') }}',
                    data: {
                        _token: '{{ csrf_token() }}',

                        'is_active': status,
                        'id': userId
                    },
                    success: function(data) {
                        if (response.success) {
                            toastr.success(response.message);
                        }
                    }
                });
            });
        });
    </script>
@endsection
