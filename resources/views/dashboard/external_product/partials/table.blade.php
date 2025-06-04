<table class="table table-bordered table-striped">
    <thead class="table-dark text-center align-middle">
        <tr>

            <th style="width: 50px;">#</th>
            <th style="width: 110px;">الصورة</th>
            <th style="width: 250px;">الاسم</th>

            <th style="width: 100px;">السعر</th>
            {{-- <th style="width: 90px;">الحالة</th> --}}
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
            <tr class="align-middle text-center">

                <td>{{ $product['parent_id'] }}</td>
                <td>
                    <img src="{{ $product['image_url'] }}" width="100" height="80" alt="صورة المنتج">
                </td>
                <td class="text-start">
                    {{ $product['name'] }}<br>
                    <button type="button" class="btn btn-sm btn-info mt-1 show-variants-btn"
                        data-variants='@json($product['variants'])' data-productname="{{ $product['name'] }}">
                        عرض المتغيرات <i class="fa fa-angle-down"></i>
                    </button>
                </td>

                <td>{{ $product['price'] ?? '-' }}</td>
               
               
            </tr>

            {{-- صف المتغيرات مخفي افتراضياً --}}
            <tr id="variants-{{ $product['id'] }}" class="variants-row" style="display: none;">
                <td colspan="9" class="bg-light p-3">
                    <ul class="list-unstyled mb-0">
                        @foreach ($product['variants'] as $variant)
                            <li>
                                <strong>{{ $variant['default_code'] }}</strong> |
                                {{ $variant['attributes']['size'] ?? '-' }} /
                                {{ $variant['attributes']['color'] ?? '-' }} |
                                الكمية: {{ $variant['net_available_qty'] ?? '-' }} |
                                السعر: {{ $variant['price'] ?? '-' }}
                            </li>
                        @endforeach
                    </ul>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="9" class="text-center">لا توجد منتجات.</td>
            </tr>
        @endforelse
    </tbody>
</table>



<div class="d-flex justify-content-center mt-3">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
<!-- Modal لعرض المتغيرات -->
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
    $(document).ready(function() {
      

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
