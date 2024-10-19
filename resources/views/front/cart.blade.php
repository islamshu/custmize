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
            border: 1px solid #e2e2e2;
        }

        .color-box input[type="checkbox"] {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
        }

        .size-box,
        .material-box {
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #e2e2e2;
            color: #68dfbe;
            font-weight: bold;
        }

        .size-box {
            background-color: #f8f8f8;
        }

        .quantity {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100px;
            justify-content: space-between;
            padding: 5px;
        }

        .quantity button:focus {
            outline: none;
        }

        .quantity button {
            border: none;
            background-color: #fff;
            font-size: 20px;
            cursor: pointer;
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

        /* Promo Code Section */
        .promo-section {
            margin-top: 20px;
            text-align: center;
        }

        .promo-section input[type="text"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 60%;
            max-width: 300px;
            margin-right: 10px;
            font-size: 16px;
        }

        .promo-section button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .promo-section button:hover {
            background-color: #45a049;
        }

        /* Order Summary */
        .card-body {
            font-family: Arial, sans-serif;
        }

        .card-title {
            font-weight: bold;
            font-size: 20px;
        }

        .list-group-item {
            font-size: 16px;
            border: none;
        }

        .list-group-item span {
            font-weight: bold;
        }

        .text-success {
            font-size: 18px;
            font-weight: bold;
        }

        h5.card-title {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }

        input[type="text"]::placeholder {
            color: #aaa;
            font-size: 14px;
        }

        /* Apply a smooth hover effect for the checkout button */
        .btn-success:hover {
            background-color: #45a049;
            border-color: #45a049;
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        /* Add a little animation to the entire cart card */
        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection

@section('content')
    <h2 class="mb-4" style="text-align: center">Shopping Cart (<span id="itemCount">{{ $carts->count() }}</span> Items)</h2>

    @if ($carts->count() == 0)
        <div style="border: 1px solid #ddd;text-align: center;padding: 50px;">
            <h2>Your cart is empty 😒</h2>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            @if ($carts->count() != 0)
                @foreach ($carts as $item)
                    @php
                        $product = App\Models\Product::find($item->id);
                    @endphp
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="{{ asset('uploads/' . $product->image) }}" class="img-fluid rounded"
                                        alt="Product Image">
                                </div>
                                <div class="col-md-6">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <div class="product-option">
                                        <div class="option">
                                            <span>Color</span>
                                            <div class="color-box" style="background-color: {{ get_color_code($item->attributes->color) }}">
                                                <input type="checkbox" checked>
                                            </div>
                                        </div>
                                        <div class="option">
                                            <span>Size</span>
                                            <div class="size-box">{{ $item->attributes->size }}</div>
                                        </div>
                                        <div class="option">
                                            <span>Material</span>
                                            <div class="size-box">Cotton</div>
                                        </div>
                                    </div>

                                    <div class="btn-group" style="display: block" role="group">
                                        <span>Quantity</span>
                                        <div class="quantity">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="changeQuantity({{ $item->id }}, -1)">-</button>
                                            <input type="text" value="{{ $item->quantity }}" readonly
                                                id="{{ $item->id }}Quantity">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="changeQuantity({{ $item->id }}, 1)">+</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <button type="button" style="margin-left: 50%;margin-bottom: 10px" class="btn btn-danger"
                                        onclick="removecart({{ $item->id }})"><i class="fa fa-trash"></i></button>

                                    <div class="delevery" style="margin-left: 50%;">
                                        <span>Delivery</span>
                                        <div class="delevery-box"
                                            style="margin-top: 10px; font-family: Arial, Helvetica, sans-serif;color:#68dfbe">
                                            {{ now()->day }} - {{ now()->addDays($product->delivery_date)->day }}
                                            {{ Carbon\Carbon::now()->addDays($product->delivery_date)->format('F') }}
                                        </div>

                                        <p class="h5 mb-0 text-success" style="margin-top: 15px">$<span
                                                id="{{ $item->id }}Price">{{ $item->price * $item->quantity }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @if ($carts->count() != 0)
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Order Summary</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal</span>
                                <strong>$<span id="subtotal">{{ $subtotal }}</span></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Shipping</span>
                                <strong>$<span id="shipping">15.00</span></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tax</span>
                                <strong>$<span id="tax">{{ $tax }}</span></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total</span>
                                <strong class="text-success">$<span id="total">{{ $total }}</span></strong>
                            </li>
                        </ul>
                        

                        <!-- Promo Code Section -->
                        <div class="promo-section">
                            <label for="coupon" class="form-label">Promo Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="coupon" placeholder="Enter promo code">
                                <button class="btn btn-outline-secondary" type="button" onclick="applyCoupon()">Apply</button>
                            </div>
                        </div>

                        <button class="btn btn-success w-100 mt-3" onclick="checkout()">Checkout Now ($<span id="checkoutTotal">{{ $total }}</span>)</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('custom/js/jquery.min.js') }}"></script>
    <script>
        const products = @json($carts->pluck('quantity', 'id'));

        function changeQuantity(product, change) {
            products[product] = Math.max(0, products[product] + change);
            $.ajax({
                url: '/updateCart',
                method: 'GET',
                data: {
                    product_id: product,
                    quantity: products[product]
                },
                success: function(response) {
                    console.log(response.message);
                },
                error: function(error) {
                    console.error("Error updating quantity:", error);
                }
            });
            updateCart();
        }

        function removecart(product) {
            $.ajax({
                url: '/removeCart',
                method: 'GET',
                data: { productid: product },
                success: function(response) {
                    setTimeout(function() {
                        window.location.href = '/carts';
                    }, 10);
                },
                error: function(error) {
                    console.error("Error removing item:", error);
                }
            });
        }

        function updateCart() {
            let subtotal = 0;
            let itemCount = 0;

            for (let [product, quantity] of Object.entries(products)) {
                const price = parseFloat(document.getElementById(`${product}Price`).textContent) / quantity;
                const total = price * quantity;

                document.getElementById(`${product}Price`).textContent = total.toFixed(2);
                document.getElementById(`${product}Quantity`).value = quantity;
                subtotal += total;
                itemCount += quantity;
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
            const coupon = document.getElementById('coupon').value.toUpperCase();
            const promoCodes = {
                'DISCOUNT10': 0.1,  // 10% discount
                'FREESHIP': 0  // Free shipping
            };

            if (promoCodes.hasOwnProperty(coupon)) {
                let subtotal = parseFloat(document.getElementById('subtotal').textContent);
                let discount = 0;

                if (promoCodes[coupon] > 0) {
                    discount = subtotal * promoCodes[coupon];
                    alert(`Promo applied: ${promoCodes[coupon] * 100}% off`);
                } else if (coupon === 'FREESHIP') {
                    document.getElementById('shipping').textContent = '0.00';
                    alert('Free shipping applied!');
                }

                subtotal -= discount;
                const tax = subtotal * 0.1;
                const shipping = parseFloat(document.getElementById('shipping').textContent);
                const total = subtotal + shipping + tax;

                document.getElementById('subtotal').textContent = subtotal.toFixed(2);
                document.getElementById('tax').textContent = tax.toFixed(2);
                document.getElementById('total').textContent = total.toFixed(2);
                document.getElementById('checkoutTotal').textContent = total.toFixed(2);
            } else {
                alert('Invalid promo code!');
            }
        }

        function checkout() {
            alert('Checkout Successful!');
        }

        updateCart();
    </script>
@endsection
