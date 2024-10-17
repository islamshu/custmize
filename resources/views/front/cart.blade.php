@extends('layouts.frontend')
@section('style')
    <style>
        * {
            direction: ltr !important;
        }

        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-success {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }

        .btn-success:hover {
            background-color: #45a049;
            border-color: #45a049;
        }

        .text-success {
            color: #4CAF50 !important;
        }

        .badge {
            border-radius: 12px;
            padding: 5px 10px;
        }

        .color-option,
        .size-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #ddd;
            display: inline-block;
            cursor: pointer !important;
            margin-right: 5px;
        }

        #check {
            display: flex;
            width: 5%;
            border-radius: 20%;
            justify-content: center
        }

        .product-option {
            display: flex;
            gap: 20px;
            font-family: Arial, Helvetica, sans-serif
        }

        .option {
            display: block;
            align-items: center;
            font-family: Arial, Helvetica, sans-serif
        }

        .color-box {
            position: relative;
            width: 35px;
            height: 35px;
            border-radius: 5px;
            /* background-color: #68dfbe; */
            border: 1px solid #e2e2e2
        }

        .color-box input[type="checkbox"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
        }

        .color-box lable {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 5px;
            /* background-color: #68dfbe; */
        }

        .size-box,
        .material-box {
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #e2e2e2;
            color: #68dfbe;
            font-weight: bold
        }

        .size-box {
            background-color: #f8f8f8;
        }

        .material-box {
            background-color: #f8f8f8;
        }

        .color-option.selected,
        .size-option.selected {
            border-color: #4CAF50;
        }

        .size-option {
            background-color: #fff;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .quantity {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100px;
            justify-content: space-between;
            padding: 5px
        }

        .quantity button:focus {
            outline: none;
        }

        .quantity button {
            border: none;
            background-color: #fff;
            font-size: 20px;
            cursour: pointer;
            color: #888;
            padding: 5px;
        }

        .quantity input {
            width: 30px;
            text-align: center;
            border: none;
            font-size: 16px;
        }

        .quantity input:focus {
            outline: none;
        }
    </style>

    
@endsection
@section('content')
    <h2 class="mb-4 " style="text-align: center">سلة التسوق (<span id="itemCount">{{ $carts->count() }}</span> منتجات)</h2>
    @if ($carts->count() == 0)

    <div style="border: 1px solid #ddd;text-align: center;padding: 50px;">
        <h2>لا يوجد عناصر بالسلة 😒</h2>

    </div>
    @endif
    <!-- Shopping Cart Items -->
    <div class="row">
        <div class="col-lg-1">
        </div>

        <div class="col-lg-7">
            <!-- Item 1 -->
            @if ($carts->count() != 0)
                @foreach ($carts as $item)
                    {{-- {{ dd($item) }} --}}
                    @php
                        $product = App\Models\Product::find($item->id);
                    @endphp

                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="{{ asset('uploads/' . $product->image) }}" class="img-fluid rounded"
                                        alt="CICC premium Hoodi">
                                </div>
                                <div class="col-md-6">
                                    <div class="div">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h5 class="card-title">{{ $product->name }}</h5>

                                            </div>

                                        </div>

                                    </div>
                                    {{-- <p class="card-text mb-1">
                                    <div>
                                    <span class="badge  me-2" style="background: {{ get_color_code($item->attributes->color) }}">اللون: {{ get_color($item->attributes->color) }}</span>
                                    <span id="check"   style=" background: {{ get_color_code($item->attributes->color) }}">/</span>
                                    </div>
                                    <span class="badge bg-secondary">الحجم: {{ $item->attributes->size }}</span>
                                </p>
                                <p class="card-text"><small class="text-muted">المادة: قطن</small></p> --}}
                                    <div class="product-option">
                                        <div class="option">
                                            <span> Color</span>
                                            <div class="color-box"
                                                style="background-color: {{ get_color_code($item->attributes->color) }}">
                                                <input type="checkbox" name="" id="color" checked>
                                                <label for="color"
                                                    style="background-color: {{ get_color_code($item->attributes->color) }}"></label>
                                            </div>
                                        </div>
                                        <div class="option">
                                            <span> Size</span>
                                            <div class="size-box">{{ $item->attributes->size }}
                                            </div>
                                        </div>
                                        <div class="option">
                                            <span> Material</span>
                                            <div class="size-box">Cotton
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group" style="display: block" role="group">
                                        <span> Quantity</span>
                                        {{-- <div class="qtyoption">
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity({{ $item->id }}, -1)">-</button>
                                        <button type="button" class="btn btn-outline-secondary" id="{{ $item->id }}Quantity">2</button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity({{ $item->id }}, 1)">+</button>
                                    </div> --}}
                                        <div class="quantity">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="changeQuantity({{ $item->id }}, -1)">-</button>
                                            <input type="text" value="2" readonly class="quantity"
                                                id="{{ $item->id }}Quantity">
                                            {{-- <button type="button" class="btn btn-outline-secondary" id="{{ $item->id }}Quantity">2</button> --}}
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="changeQuantity({{ $item->id }}, 1)">+</button>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <button type="button" style="    margin-left: 50%;margin-bottom: 10px"
                                        class="btn btn-danger" onclick="removecart({{ $item->id }})"><i
                                            class="fa fa-trash"></i></button>

                                    <div class="d-flex justify-content-between align-items-center">
                                        {{-- <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity({{ $item->id }}, -1)">-</button>
                                        <button type="button" class="btn btn-outline-secondary" id="{{ $item->id }}Quantity">2</button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity({{ $item->id }}, 1)">+</button>
                                    </div> --}}

                                        <div class="delevery" style="margin-left: 50%; ">
                                            <span> Delevery</span>
                                            <div class="delevery-box"
                                                style="margin-top: 10px ; font-family: Arial, Helvetica, sans-serif;color:#68dfbe">
                                                {{ now()->day }} - {{ now()->addDays($product->delivery_date)->day }}
                                                {{ Carbon\Carbon::now()->addDays($product->delivery_date)->format('F') }}
                                            </div>

                                            <p class="h5 mb-0 text-success" style="margin-top: 15px">$<span
                                                    id="{{ $item->id }}Price">62.98</span></p>


                                        </div>
                                        {{-- <p class="h5 mb-0 text-success">$<span id="{{ $item->id }}Price">62.98</span></p>
                                    <button type="button" class="btn btn-danger" onclick="removecart({{ $item->id }})"><i class="fa fa-trash"></i></button> --}}

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>
        @endif




        <!-- Item 2 -->

        {{-- </div> --}}

        <!-- Order Summary -->
        @if ($carts->count() != 0)
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">ملخص الطلب</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>المجموع الفرعي</span>
                                <strong>$<span id="subtotal">67.96</span></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>الشحن</span>
                                <strong>$<span id="shipping">15.00</span></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>الضريبة</span>
                                <strong>$<span id="tax">8.74</span></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>الإجمالي</span>
                                <strong class="text-success">$<span id="total">91.70</span></strong>
                            </li>
                        </ul>
                        <div class="mt-3">
                            <label for="coupon" class="form-label">كود الخصم</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="coupon" placeholder="أدخل كود الخصم">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="applyCoupon()">تطبيق</button>
                            </div>
                        </div>

                        <div class="mt-3">
                            <h6>اختر طريقة الدفع:</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" checked>
                                <label class="form-check-label" for="creditCard">
                                    <i class="bi bi-credit-card me-2"></i>بطاقة الائتمان
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="cashOnDelivery">
                                <label class="form-check-label" for="cashOnDelivery">
                                    <i class="bi bi-cash me-2"></i>الدفع عند الاستلام
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-success w-100 mt-3" onclick="checkout()">ادفع الآن ($<span
                                id="checkoutTotal">91.70</span>)</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('custom/js/jquery.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // const products = {
        //     hoodi: { price: 31.49, quantity: 2 },
        //     mug: { price: 4.98, quantity: 1 }
        // };
        const products = @json($carts->select('price', 'quantity'));



        function changeQuantity(product, change) {

            products[product].quantity = Math.max(0, products[product].quantity + change);
            $.ajax({
                url: '/updateCart', // Your route to fetch the image
                method: 'GET',
                data: {
                    product_id: product,
                    quantity: products[product].quantity
                }, // Send product and color ID
                success: function(response) {
                    console.log(response.message);

                },
                error: function(error) {
                    console.error("Error fetching the color image:", error);
                }
            });
            updateCart();

        }

        function removecart(product) {
            $.ajax({
                url: '/removeCart', // Your route to fetch the image
                method: 'GET',
                data: {
                    productid: product
                }, // Send product and color ID
                success: function(response) {
                    setTimeout(function() {
                        window.location.href =
                            '/carts'; // إعادة توجيه إلى لوحة التحكم أو الصفحة الرئيسية
                    }, 10);
                    console.log(response.message);

                },
                error: function(error) {
                    console.error("Error fetching the color image:", error);
                }
            });
        }

        function updateCart() {
            let subtotal = 0;
            let itemCount = 0;

            for (let [product, details] of Object.entries(products)) {
                const total = details.price * details.quantity;
                var qqy = $('#' + product + 'Quantity');
                qqy.val(details.quantity);
                document.getElementById(`${product}Price`).textContent = total.toFixed(2);
                subtotal += total;
                itemCount += details.quantity;
            }

            const shipping = 15;
            const tax = subtotal * 0.1;
            const total = subtotal + shipping + tax;

            document.getElementById('itemCount').textContent = itemCount;
            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('shipping').textContent = shipping.toFixed(2);
            document.getElementById('tax').textContent = tax.toFixed(2);
            document.getElementById('total').textContent = total.toFixed(2);
            document.getElementById('checkoutTotal').textContent = total.toFixed(2);
        }

        function applyCoupon() {
            const coupon = document.getElementById('coupon').value;
            if (coupon.toLowerCase() === 'discount10') {
                alert('تم تطبيق الخصم: 10%');
                // يمكنك إضافة منطق الخصم هنا
            } else {
                alert('كود الخصم غير صالح');
            }
        }

        function checkout() {
            alert('تم إتمام عملية الشراء بنجاح!');
        }

        // تحديث السلة عند تحميل الصفحة
        updateCart();

        // التبديل بين طرق الشحن
        document.querySelectorAll('input[name="shippingMethod"]').forEach((elem) => {
            elem.addEventListener("change", function(event) {
                const deliveryAddress = document.getElementById('deliveryAddress');
                deliveryAddress.style.display = event.target.id === 'delivery' ? 'block' : 'none';
            });
        });
    </script>
@endsection
