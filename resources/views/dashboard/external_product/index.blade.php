@extends('layouts.master')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        .status-toggle {
            position: relative;
            display: inline-block;
        }

        .status-switch {
            display: none;
        }

        .status-label {
            display: block;
            width: 60px;
            height: 15px;
            background-color: #e74c3c;
            border-radius: 34px;
            position: relative;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .status-label .on,
        .status-label .off {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .status-label .on {
            left: 10px;
            display: none;
        }

        .status-label .off {
            right: 10px;
        }

        .status-switch:checked+.status-label {
            background-color: #2ecc71;
        }

        .status-switch:checked+.status-label .on {
            display: block;
        }

        .status-switch:checked+.status-label .off {
            display: none;
        }

        .status-label:after {
            content: '';
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: white;
            top: 3px;
            left: 1px;
            transition: transform 0.3s;
        }

        .status-switch:checked+.status-label:after {
            transform: translateX(46px);
        }
    </style>
    <style>
        .variant-item {
            background-color: #fff;
            margin-bottom: 8px !important;
        }

        .variant-checkbox {
            cursor: pointer;
        }

        .variant-item:hover {
            background-color: #f9f9f9;
        }

        #variant-list {
            padding-left: 0;
        }
    </style>

    <style>
        #floating-btn-container {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            background-color: white;
            padding: 10px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        #group-import-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('المنتجات الخارجية') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a>
                                </li>

                                <li class="breadcrumb-item active">{{ __('المنتجات الخارجية') }}
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

                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        @include('dashboard.inc.alerts')


                                        <form id="search-form" method="GET">
                                            <div class="row mb-2">
                                                <div class="col-md-4">
                                                    <input type="text" name="q" id="search-input"
                                                        class="form-control" placeholder="ابحث عن منتج...">
                                                </div>
                                            </div>
                                        </form>

                                        <div id="products-table-ajax">
                                            @include('dashboard.external_product.partials.table', [
                                                'products' => $products,
                                            ])
                                        </div>

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

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('.status-switch');

            toggles.forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const productId = this.dataset.id;
                    const isActive = this.checked;

                    // Get the route URL using Laravel's named route
                    const url = "{{ route('external-products.toggle', ':id') }}".replace(':id',
                        productId);

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                is_active: isActive
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                // Revert if request fails
                                toggle.checked = !isActive;
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Optional: Show toast notification
                            Toastify({
                                text: data.message || 'Status updated successfully',
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#4CAF50",
                            }).showToast();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Toastify({
                                text: 'Failed to update status',
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#F44336",
                            }).showToast();
                        });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let searchInput = document.getElementById('search-input');

            // عند الكتابة في خانة البحث
            searchInput.addEventListener('keyup', function() {
                let query = this.value;

                fetch(`{{ route('external-products.index') }}?q=${query}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('products-table-ajax').innerHTML = data;
                        initVariantButtons();

                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                    });
            });

            // أيضًا يدعم التنقل بين الصفحات في البحث
            document.addEventListener('click', function(e) {
                if (e.target.closest('.pagination a')) {
                    e.preventDefault();
                    let url = e.target.closest('a').getAttribute('href');

                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('products-table-ajax').innerHTML = data;
                            initVariantButtons();

                        });
                }
            });
        });
    </script>
    <div class="modal fade" id="variantsModal" tabindex="-1" aria-labelledby="variantsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="variantsModalLabel">تفاصيل المتغيرات</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="إغلاق"></button>
                </div>
                <div class="modal-body" id="variantsModalBody">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="select-all" style="transform: scale(1.4);">
                        <label class="form-check-label fs-5 fw-semibold" for="select-all">
                            تحديد الكل
                        </label>
                    </div>
                </div>


                <ul id="variant-list" class="list-group"></ul>
                <!-- يتم ملء هذه القائمة ديناميكياً -->
                </ul>

                <!-- الفورم -->


            </div>
        </div>
    </div>
    <form id="group-form" method="POST" action="{{ route('external-products.group.import') }}">
        @csrf
        <input type="hidden" name="product_ids" id="selected-ids">

        <div id="floating-btn-container" style="display: none;">
            <button type="submit" class="btn btn-warning" id="group-import-btn" disabled>
                <i class="fa fa-plus"></i> إضافة كمجموعة
            </button>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function initVariantButtons() {
            $('.show-variants-btn').off('click').on('click', function() {
                const variants = $(this).data('variants');
                const productName = $(this).data('productname');

                $('#variantsModalLabel').text(`متغيرات المنتج: ${productName}`);

                if (variants.length > 0) {
                    let html = '';

                    variants.forEach(function(variant) {
                        let color = '-',
                            size = '-';

                        if (Array.isArray(variant.attributes)) {
                            variant.attributes.forEach(attr => {
                                if (attr.startsWith("Color:")) color = attr.replace("Color:", "")
                                    .trim();
                                if (attr.startsWith("Size:")) size = attr.replace("Size:", "")
                                .trim();
                            });
                        }

                        html += `
                    <li class="list-group-item p-3 d-flex align-items-center justify-content-between border mb-2 rounded shadow-sm variant-item">
                        <div class="d-flex align-items-center">
                            <input class="form-check-input me-3 variant-checkbox" type="checkbox" value="${variant.id}" style="transform: scale(1.4);">
                            ${variant.image_url ? `
                                    <img src="${variant.image_url}" class="rounded border me-3" width="100" height="80" alt="صورة">` : `
                                    <div class="bg-light border rounded me-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 50px;">
                                        <small class="text-muted">لا صورة</small>
                                    </div>`}
                            <div style="margin-right:150px !important">
                                <div class="fw-bold fs-6 mb-1">${variant.default_code}</div>
                                <div>
                                    <span class="badge bg-primary me-2">اللون: ${color}</span>
                                    <span class="badge bg-success">المقاس: ${size}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="mb-1"><strong class="text-muted">الكمية:</strong> <span class="text-success fw-bold">${variant.net_available_qty ?? '-'}</span></div>
                            <div><strong class="text-muted">السعر:</strong> <span class="text-primary fw-bold">${variant.price ?? '-'}</span></div>
                        </div>
                    </li>`;
                    });

                    $('#variant-list').html(html);
                } else {
                    $('#variant-list').html('<p class="text-center text-muted">لا توجد متغيرات متاحة.</p>');
                }

                $('#variantsModal').modal('show');
            });
        }

        $(document).ready(function() {
            initVariantButtons(); // <<<<< هنا


            // ========== 1. عند الضغط على زر "عرض المتغيرات" ==========
            $('.show-variants-btn').on('click', function() {
                const variants = $(this).data('variants');
                const productName = $(this).data('productname');

                // تحديث عنوان المودال
                $('#variantsModalLabel').text(`متغيرات المنتج: ${productName}`);

                // بناء محتوى المتغيرات
                if (variants.length > 0) {
                    let html = '';

                    variants.forEach(function(variant) {
                        let color = '-',
                            size = '-';

                        if (Array.isArray(variant.attributes)) {
                            variant.attributes.forEach(attr => {
                                if (attr.startsWith("Color:")) color = attr.replace(
                                    "Color:", "").trim();
                                if (attr.startsWith("Size:")) size = attr.replace("Size:",
                                    "").trim();
                            });
                        }

                        html += `
                        <li class="list-group-item p-3 d-flex align-items-center justify-content-between border mb-2 rounded shadow-sm variant-item">
                            <div class="d-flex align-items-center">
                                <input class="form-check-input me-3 variant-checkbox" type="checkbox" value="${variant.id}" style="transform: scale(1.4);">
                                ${variant.image_url ? `
                                        <img src="${variant.image_url}" class="rounded border me-3" width="100" height="80" alt="صورة">`
                                    : `
                                        <div class="bg-light border rounded me-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 50px;">
                                            <small class="text-muted">لا صورة</small>
                                        </div>`}
                                <div style="margin-right:150px !important">
                                    <div class="fw-bold fs-6 mb-1">${variant.default_code}</div>
                                    <div>
                                        <span class="badge bg-primary me-2">اللون: ${color}</span>
                                        <span class="badge bg-success">المقاس: ${size}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="mb-1"><strong class="text-muted">الكمية:</strong> <span class="text-success fw-bold">${variant.net_available_qty ?? '-'}</span></div>
                                <div><strong class="text-muted">السعر:</strong> <span class="text-primary fw-bold">${variant.price ?? '-'}</span></div>
                            </div>
                        </li>`;
                    });

                    $('#variant-list').html(html);
                } else {
                    $('#variant-list').html('<p class="text-center text-muted">لا توجد متغيرات متاحة.</p>');
                }

                // إظهار المودال
                $('#variantsModal').modal('show');
            });

            // ========== 2. زر "تحديد الكل" ==========
            $(document).on('change', '#select-all', function() {
                $('.variant-checkbox').prop('checked', this.checked).trigger('change');
            });

            // ========== 3. عند تحديد/إلغاء تحديد أي متغير ==========
            $(document).on('change', '.variant-checkbox', function() {
                const selected = $('.variant-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
                $('#selected-ids').val(selected.join(','));
                $('#group-import-btn').prop('disabled', selected.length === 0);
            });

            // ========== 4. إظهار الزر عند فتح المودال وإخفاؤه عند الإغلاق ==========
            $('#variantsModal').on('shown.bs.modal', function() {
                $('#floating-btn-container').fadeIn(); // إظهار الزر
            });

            $('#variantsModal').on('hidden.bs.modal', function() {
                $('#floating-btn-container').fadeOut(); // إخفاء الزر
                $('#variant-list').empty(); // تنظيف المتغيرات
                $('#select-all').prop('checked', false); // إلغاء تحديد الكل
                $('#selected-ids').val('');
                $('#group-import-btn').prop('disabled', true); // تعطيل الزر
            });

            // ========== 5. عرض/إخفاء المتغيرات تحت المنتج (اختياري إذا ما زلت تستخدم هذا الجزء) ==========
            $('.toggle-variants-btn').on('click', function() {
                const target = $(this).data('target');
                $(target).slideToggle();

                // تغيير النص والأيقونة
                let icon = $(this).find('i.fa');
                if ($(target).is(':visible')) {
                    $(this).html('إخفاء المتغيرات <i class="fa fa-angle-up"></i>');
                } else {
                    $(this).html('عرض المتغيرات <i class="fa fa-angle-down"></i>');
                }
            });

        });
    </script>
@endsection
