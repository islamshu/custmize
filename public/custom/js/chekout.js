function checkout() {
    $.ajax({
        url: '/check-cart', // The route to check the cart
        method: 'GET',
        success: function(response) {
            console.log('islam'); // Log the response to inspect it

            // Check if the response contains the specific message
            if (response.message === 'Session key is required.') {
                // Call saveDesignAutomatically when the session key is required
                saveDesignAutomatically();

                // Show the message in an alert or SweetAlert
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else if (response.cartEmpty) {
                // Handle other cart empty scenarios
                Swal.fire({
                    title: 'Error',
                    text: response.message ? response.message : 'Your cart is empty.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } else {
                // Redirect to the cart page if items exist
                window.location.href = '/carts';
            }
        },
        error: function(xhr) {
            console.log('islam sh'); // Log the response to inspect it
            saveDesignAutomatically();

            // Show the error message if it exists
            Swal.fire({
                title: 'Error',
                text: xhr.responseText ? xhr.responseText : 'An unknown error occurred.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}



function checkout_buy() {
    $.ajax({
        url: '/check-cart', // The route you will create to check the cart
        method: 'GET',
        success: function(response) {
            if (response.cartEmpty) {
                saveDesignAutomatically();

                Swal.fire({
                    title: 'لا يوجد واجهة معتمدة',
                    icon: 'error',
                    confirmButtonText: 'حسناً'
                });
            } else {
                // Redirect to cart page if items exist
                Swal.fire({
                    title: 'تم اضافة المنتج الى السلة',
                    icon: 'success',
                    confirmButtonText: 'حسناً'
                });
            }
        },
        error: function(e) {
            alert(e.cartEmpty);
            if (e.cartEmpty) {
                Swal.fire({
                    title: 'لا يوجد واجهة معتمدة',
                    icon: 'error',
                    confirmButtonText: 'حسناً'
                });
            }
            Swal.fire({
                title: 'حدث خطأ!',
                icon: 'error',
                confirmButtonText: 'حسناً'
            });
        }
    });
}