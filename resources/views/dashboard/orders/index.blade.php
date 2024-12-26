@extends('layouts.master')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<style>
    select.status-select {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    font-size: 14px;
    font-weight: bold;
    transition: background-color 0.3s ease, color 0.3s ease;
}

select.status-select option {
    font-weight: bold;
}

</style>
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ $title }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a>
                                </li>

                                <li class="breadcrumb-item active">{{ $title }}
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
                                        <h4 class="card-title">{{ $title }}</h4>
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
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('Order Number') }}</th>
                                                    <th>{{ __('Customer Name') }}</th>
                                                    <th>{{ __('Total Amount') }}</th>
                                                    <th>{{ __('Order Date') }}</th>
                                                    <th>{{ __('Status') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $key => $order)
                                                    <tr>
                                                        <th>{{ $key + 1 }}</th>
                                                        <th>{{ $order->code }}</th>
                                                        <th>{{ @$order->client->name == null ? 'Guest Order : ' .$order->name : @$order->client->name }}</th>
                                                        <th>{{ number_format($order->total_amount, 2) }}</th>
                                                        <th>{{ $order->created_at->format('d-m-Y') }}</th>
                                                        <th>
                                                            <select class="status-select form-control" data-order-id="{{ $order->id }}">
                                                                @foreach (App\Models\Status::get() as $item)
                                                                    <option value="{{ $item->id }}" @if ($order->status_id == $item->id) selected @endif>
                                                                        {{ $item->name_ar }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            
                                                        </th>
                                                        <th>
                                                            <a class="btn btn-info"
                                                                href="{{ route('orders.show', $order->id) }}"><i
                                                                    class="ft-eye"></i></a>
                                                            
                                                            <form style="display: inline-block"
                                                                action="{{ route('orders.destroy', $order->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-danger delete-confirm"><i
                                                                        class="ft-delete"></i></button>
                                                            </form>
                                                        </th>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('Order Number') }}</th>
                                                    <th>{{ __('Customer Name') }}</th>
                                                    <th>{{ __('Total Amount') }}</th>
                                                    <th>{{ __('Order Date') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </tfoot>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        var updateStatusRoute = "{{ route('orders.update-status', ':orderId') }}";

</script>
<script>
$(document).ready(function () {
    // إعداد قائمة الألوان لكل حالة
    var colors = {
        1: '#ADD8E6', // أزرق فاتح للحالة "تم استلام الطلب"
        2: '#FFA500', // برتقالي للحالة "الطلب قيد التجهيز"
        3: '#90EE90', // أخضر للحالة "الطلب جاهز"
        4: '#A9A9A9'  // رمادي للحالة "تم تسليم الطلب"
    };

    // تطبيق الألوان عند تحميل الصفحة
    $('select.status-select').each(function () {
        var statusId = $(this).val(); // الحصول على ID الحالة الحالية
        applyStatusColor($(this), statusId); // تطبيق اللون بناءً على الحالة
        $(this).data('previous-value', statusId); // حفظ القيمة السابقة للحالة
    });

    // عند تغيير الحالة
    $('select.status-select').on('change', function () {
        var $this = $(this); // العنصر الحالي
        var newStatusId = $this.val(); // القيمة الجديدة
        var orderId = $this.data('order-id'); // رقم الطلب
        var statusName = $this.find('option:selected').text(); // اسم الحالة الجديدة
        var previousValue = $this.data('previous-value'); // القيمة السابقة

        // نافذة التأكيد
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: `هل تريد تغيير حالة الطلب إلى "${statusName}"؟`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم، قم بالتغيير',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                // إذا وافق المستخدم، أرسل طلب AJAX
                var url = updateStatusRoute.replace(':orderId', orderId);

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status_id: newStatusId
                    },
                    success: function (response) {
                        toastr.success(`تم تحديث حالة الطلب إلى ${statusName}`);
                        applyStatusColor($this, newStatusId); // تطبيق اللون الجديد
                        $this.data('previous-value', newStatusId); // تحديث القيمة السابقة
                    },
                    error: function () {
                        toastr.error('حدث خطأ أثناء تحديث الحالة');
                        $this.val(previousValue); // إعادة القيمة السابقة
                        applyStatusColor($this, previousValue); // إعادة اللون السابق
                    }
                });
            } else {
                // إذا تم الإلغاء، إعادة القيمة السابقة
                $this.val(previousValue);
                applyStatusColor($this, previousValue);
            }
        });
    });

    // دالة لتطبيق الألوان بناءً على الحالة
    function applyStatusColor(element, statusId) {
        element.css('background-color', colors[statusId]); // تغيير لون الخلفية
        element.css('color', '#fff'); // تغيير لون النص
    }
});



</script>
    
@endsection
