@extends('layouts.frontend')
@section('style')
    <style>
        #loader {
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            /* Make sure it stays on top of other content */
            display: none;
            /* Hidden by default */
        }

        #couponMessage {
            font-weight: bold;
            margin-top: 10px;
        }

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
    <div id="loader" style="display:none;">
        <img src="https://i.gifer.com/origin/b4/b4d657e7ef262b88eb5f7ac021edda87_w200.gif" alt="Loading..." />
        <!-- Replace with your loader image or animation -->
    </div>

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
                                            <div class="color-box"
                                                style="background-color: {{ get_color_code($item->attributes->color) }}">
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
                                    <button type="button" style="margin-left: 50%;margin-bottom: 10px"
                                        class="btn btn-danger" onclick="removecart({{ $item->id }})"><i
                                            class="fa fa-trash"></i></button>

                                    <div class="delevery" style="margin-left: 50%;">
                                        <span>Delivery</span>
                                        <div class="delevery-box"
                                            style="margin-top: 10px; font-family: Arial, Helvetica, sans-serif;color:#68dfbe">
                                            {{ now()->day }} - {{ now()->addDays($product->delivery_date)->day }}
                                            {{ Carbon\Carbon::now()->addDays($product->delivery_date)->format('F') }}
                                        </div>

                                        <p class="h5 mb-0 text-success" style="margin-top: 15px">$<span
                                                id="{{ $item->id }}Price">{{ $item->price * $item->quantity }}</span>
                                        </p>
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
                                <strong>$<span id="shipping">{{ $shipping }}</span></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tax</span>
                                <strong>$<span id="tax">{{ $tax }}</span></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Discount</span>
                                <strong class="text-danger"><span id="discount" style="display:none;">$0.00</span></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total</span>
                                <strong class="text-success">$<span id="total">{{ $total }}</span></strong>
                            </li>
                        </ul>

                        <!-- Add input fields for name and email -->
                        <div class="form-group mt-3">
                            <label for="customerName">Name</label>
                            <input type="text" class="form-control" id="customerName" placeholder="Enter your name">
                        </div>
                        <div class="form-group mt-3">
                            <label for="customerEmail">Email</label>
                            <input type="email" class="form-control" id="customerEmail" placeholder="Enter your email">
                        </div>

                        <!-- Promo Code Section -->
                        <div class="promo-section mt-3">
                            <label for="coupon" class="form-label">Promo Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="coupon" placeholder="Enter promo code">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="applyCoupon()">Apply</button>
                            </div>
                            <div id="couponMessage" class="mt-2" style="display: none;"></div>
                            <!-- عنصر لعرض الرسالة -->
                        </div>

                        <button class="btn btn-success w-100 mt-3" onclick="checkout()">Checkout Now ($<span
                                id="checkoutTotal">{{ $total }}</span>)</button>
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

        function changeQuantity(product_id, change) {
            $('#coupon').val('');
            const messageElement = document.getElementById('couponMessage');
            messageElement.style.display = 'none';
            const discountElement = document.getElementById('discount'); // Make sure this element exists in your HTML
            discountElement.textContent = ' ';
            let quantityElement = document.getElementById(`${product_id}Quantity`);
            let currentQuantity = parseInt(quantityElement.value);
            let newQuantity = currentQuantity + change;

            if (newQuantity < 1) {
                newQuantity = 1; // Ensure quantity is at least 1
            }

            // Update the quantity input field
            quantityElement.value = newQuantity;

            // Send AJAX request to update the cart
            $.ajax({
                url: '/updateCart', // Your Laravel route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    product_id: product_id,
                    quantity: newQuantity
                },
                success: function(response) {
                    // Update the item total in the UI
                    document.getElementById(`${product_id}Price`).textContent = response.item_total.toFixed(2);

                    // Update overall totals in the UI
                    document.getElementById('subtotal').textContent = response.subtotal.toFixed(2);
                    document.getElementById('shipping').textContent = response.shipping.toFixed(2);
                    document.getElementById('tax').textContent = response.tax.toFixed(2);
                    document.getElementById('total').textContent = response.total.toFixed(2);
                    document.getElementById('checkoutTotal').textContent = response.total.toFixed(2);
                },
                error: function(error) {
                    console.error("Error updating the cart:", error);
                }
            });

        }
        let originalSubtotal = 0;
        let originalShipping = 0;
        let originalTax = 0;
        let originalTotal = 0;

        // Initialize the original values when the document is ready
        $(document).ready(function() {
            originalSubtotal = parseFloat(document.getElementById('subtotal').textContent);
            originalShipping = parseFloat(document.getElementById('shipping').textContent);
            originalTax = parseFloat(document.getElementById('tax').textContent);
            originalTotal = parseFloat(document.getElementById('total').textContent);
        });

        function applyCoupon() {
            const coupon = document.getElementById('coupon').value;

            $.ajax({
                url: '/apply-coupon', // Your route to apply the coupon
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token for security
                    coupon: coupon
                },
                success: function(response) {
                    const messageElement = document.getElementById('couponMessage');
                    messageElement.style.display = 'block'; // Show message element
                    const discountElement = document.getElementById('discount');

                    if (response.success) {
                        messageElement.textContent = response.message; // Show success message
                        messageElement.className = 'text-success'; // Style success message

                        // Update UI with new values
                        document.getElementById('subtotal').textContent = response.subtotal.toFixed(2);
                        document.getElementById('shipping').textContent = response.shipping.toFixed(2);
                        document.getElementById('tax').textContent = response.tax.toFixed(2);
                        document.getElementById('total').textContent = response.total.toFixed(2);
                        document.getElementById('checkoutTotal').textContent = response.total.toFixed(2);

                        // Display the discount amount
                        discountElement.textContent = "$" + response.discount.toFixed(
                            2); // Update discount amount
                        discountElement.style.display = 'block'; // Show the discount element
                    } else {
                        // Restore original values
                        document.getElementById('subtotal').textContent = originalSubtotal.toFixed(2);
                        document.getElementById('shipping').textContent = originalShipping.toFixed(2);
                        document.getElementById('tax').textContent = originalTax.toFixed(2);
                        document.getElementById('total').textContent = originalTotal.toFixed(2);
                        document.getElementById('checkoutTotal').textContent = originalTotal.toFixed(2);

                        messageElement.textContent = response.message; // Show error message
                        messageElement.className = 'text-danger'; // Style error message
                        discountElement.textContent = ''; // Clear discount
                        discountElement.style.display = 'none'; // Hide the discount element
                    }
                },
                error: function(error) {
                    console.error("Error applying coupon:", error);
                    document.getElementById('couponMessage').textContent =
                        'There was an error applying the coupon.';
                    document.getElementById('couponMessage').className = 'text-danger'; // Style error message
                    document.getElementById('couponMessage').style.display = 'block'; // Show the error message

                    // Restore original values in case of an error
                    document.getElementById('subtotal').textContent = originalSubtotal.toFixed(2);
                    document.getElementById('shipping').textContent = originalShipping.toFixed(2);
                    document.getElementById('tax').textContent = originalTax.toFixed(2);
                    document.getElementById('total').textContent = originalTotal.toFixed(2);
                    document.getElementById('checkoutTotal').textContent = originalTotal.toFixed(2);
                }
            });
        }






        function updateCart() {
            let subtotal = 0;
            let itemCount = 0;
            let promocode = $('#coupon').val();

            // Loop through each product in the cart
            for (let [product, quantity] of Object.entries(products)) {
                const price = parseFloat(document.getElementById(`${product}Price`).textContent) / quantity;
                const total = price * quantity;

                // Update UI elements
                document.getElementById(`${product}Price`).textContent = total.toFixed(2);
                document.getElementById(`${product}Quantity`).value = quantity;
                subtotal += total;
                itemCount += quantity;
            }

            const shipping = 15; // Assuming a fixed shipping cost
            const tax = subtotal * 0.1; // Assuming a tax rate of 10%
            const total = subtotal + shipping + tax;

            // Update total values in the UI
            document.getElementById('itemCount').textContent = itemCount;
            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('shipping').textContent = shipping.toFixed(2);
            document.getElementById('tax').textContent = tax.toFixed(2);
            document.getElementById('total').textContent = total.toFixed(2);
            document.getElementById('checkoutTotal').textContent = total.toFixed(2);
        }


        function removecart(product) {
            $.ajax({
                url: '/removeCart',
                method: 'GET',
                data: {
                    productid: product,
                },
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
            // Show message element
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

            const shipping = {{ $shipping }};
            const tax = {{ $tax }};
            const total = subtotal + shipping + tax;

            document.getElementById('itemCount').textContent = itemCount;
            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('shipping').textContent = shipping.toFixed(2);
            document.getElementById('tax').textContent = tax.toFixed(2);
            document.getElementById('total').textContent = total.toFixed(2);
            document.getElementById('checkoutTotal').textContent = total.toFixed(2);
        }



        function checkout() {
            // Collect customer data
            let customerName = document.getElementById('customerName').value;
            let customerEmail = document.getElementById('customerEmail').value;
            let promoCode = document.getElementById('coupon').value; // Get the promo code
            let subtotal = parseFloat(document.getElementById('subtotal').textContent); // Subtotal
            let shipping = parseFloat(document.getElementById('shipping').textContent); // Shipping cost
            let tax = parseFloat(document.getElementById('tax').textContent); // Tax
            let total = parseFloat(document.getElementById('total').textContent); // Total price without discount
            let discountAmount = 0; // Default discount value
            let discountValue = 0;

            // Check if customer name and email are provided
            if (!customerName || !customerEmail) {
                alert('Please provide both your name and email.');
                return;
            }

            // Check if a promo code is applied and calculate the discount

            // No coupon applied, proceed with checkout
            processCheckout(customerName, customerEmail, subtotal, shipping, tax, total, promoCode, 0);

        }

        function processCheckout(customerName, customerEmail, subtotal, shipping, tax, total, promoCode, discountAmount) {
            // Prepare the data to be sent to the server
            const data = {
                _token: '{{ csrf_token() }}',
                name: customerName,
                email: customerEmail,
                subtotal: subtotal,
                shipping: shipping,
                tax: tax,
                total: total,
                promo_code: promoCode, // Include the promo code if applied
            };

            // Send the AJAX request to the server for payment processing
            $.ajax({
                url: '/process-payment', // Define your route for processing payment
                method: 'POST',
                data: data,
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(response) {
                    $('#loader').hide();

                    if (response.success) {
                        $('#loader').hide();

                        // Redirect the user to the payment gateway or success page
                        window.location.href = response.payment_url;

                    } else {
                        alert(response.message); // Show any errors from the server
                    }
                },
                error: function(error) {
                    console.error("Error processing payment:", error);
                    alert('An error occurred during the payment process. Please try again.');
                }
            });
        }


        updateCart();
    </script>
@endsection
