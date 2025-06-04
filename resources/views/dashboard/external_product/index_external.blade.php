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
    width: 2rem;
    height: 1rem;
    pointer-events: none;
    content: "";
    background-color: #adb5bd;
    border-radius: .5rem;
    transition: background-color .15s ease-in-out;
}
.custom-control-label::after {
    position: absolute;
    top: 0;
    left: -2.25rem;
    display: block;
    width: 1rem;
    height: 1rem;
    content: "";
    background-color: #fff;
    border-radius: 50%;
    transition: transform .15s ease-in-out;
}
.custom-control-input:checked ~ .custom-control-label::before {
    background-color: #28a745;
}
.custom-control-input:checked ~ .custom-control-label::after {
    transform: translateX(0.2rem);
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


                                        <table class="table table-striped table-bordered file-export">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>اسم المنتج</th>
                                                    <th>الماركة</th>
                                                    <th>الصورة</th>
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
                                                        <td>{{ $product->colors->count() }}</td>
                                                        <td>
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox"
                                                                    class="custom-control-input toggle-active"
                                                                    id="switch-{{ $product->id }}"
                                                                    data-id="{{ $product->id }}"
                                                                    {{ $product->is_active ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="switch-{{ $product->id }}"></label>
                                                            </div>
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
            $('.toggle-active').change(function() {
                var productId = $(this).data('id');
                var token = '{{ csrf_token() }}';

                $.ajax({
                    url: '{{ route('external-products.toggle-active') }}',
                    type: 'POST',
                    data: {
                        _token: token,
                        id: productId,
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                        } else {
                            toastr.error('حدث خطأ ما');
                        }
                    },
                    error: function() {
                        toastr.error('فشل الاتصال بالخادم');
                    }
                });
            });
        });
    </script>
@endsection
