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
