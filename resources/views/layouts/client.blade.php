@extends('layouts.frontend')

@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<title>{{ get_general_value('website_title') }}</title>
<style>
    /* Custom Pagination Style */
.pagination {
    margin: 0;
}

.pagination li a {
    color: #007bff;
    padding: 8px 16px;
    text-decoration: none;
    border-radius: 5px;
}

.pagination li a:hover {
    background-color: #007bff;
    color: white;
}

.pagination .active span {
    background-color: #007bff;
    color: white;
    border: none;
}

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
    }

    body {
        background-color: #f0f2f5;
        color: #333;
    }

    .main-content {
        display: flex;
        padding: 20px;
        background-color: #fff;
        margin-top: 10px;
    }

    .sidebar {
        width: 250px;
        background-color: #fff;
        color: #333;
        border-radius: 10px;
        padding: 20px;
    }

    .sidebar h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .sidebar p {
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .sidebar button {
        background-color: #56ca24;
        color: #333;
        border: none;
        padding: 10px;
        width: 100%;
        margin-bottom: 20px;
        cursor: pointer;
        border-radius: 5px;
    }

    .sidebar-item {
        margin-bottom: 20px;
    }

    .sidebar-item a {
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: center;
        font-size: 1rem;
    }

    .sidebar-item a span {
        margin-right: 10px;
    }

    .sidebar-item a:hover {
        color: #56ca24;
    }

    .content {
        flex-grow: 1;
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        margin-left: 20px;
    }

    .welcome-box {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .progress-bar {
        background-color: #e0e0e0;
        border-radius: 5px;
        height: 10px;
        margin-top: 10px;
    }

    .progress {
        background-color: #4caf50;
        height: 100%;
        border-radius: 5px;
        width: 40%;
    }

    .promo-box {
        background-color: #56ca24;
        color: #333;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        text-align: center;
        font-weight: bold;
    }

    h2 {
        margin-bottom: 20px;
        font-size: 1.4rem;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .form-group .input-group {
        width: 48%;
    }

    .form-group label {
        font-size: 1rem;
        color: #333;
        margin-bottom: 5px;
        display: block;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        color: #333;
        background-color: #fff;
    }

    .form-group input[readonly] {
        background-color: #f9f9f9;
    }

    .form-group small {
        font-size: 0.9rem;
        color: #777;
        display: block;
        margin-top: 5px;
    }

    .gender-options {
        display: flex;
        gap: 10px;
        width: 100%;
    }

    .gender-option {
        flex: 1;
        position: relative;
    }

    .gender-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .gender-option label {
        display: block;
        text-align: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .gender-option input[type="radio"]:checked + label {
        background-color: #56ca24;
        border-color: #56ca24;
        color: #333;
    }

    .gender-option:hover label {
        background-color: #f0f0f0;
    }
    .save-button {
        background-color: #56ca24;
        color: #333;
        padding: 12px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        font-size: 1.2rem;
        width: 100%;
        font-weight: bold;
    }

    .save-button:hover {
        background-color: #289604;
    }

    @media (max-width: 768px) {
        .main-content {
            flex-direction: column;
        }

        .sidebar {
            width: 100%;
            margin-bottom: 20px;
        }

        .content {
            margin-left: 0;
        }

        .form-group .input-group {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="main-content">
    <!-- الشريط الجانبي -->
    <div class="sidebar">
        <h2>مرحباً {{ auth('client')->user()->first_name }}!</h2>
        <p>{{ auth('client')->user()->email }}</p>
        <button disabled>{{ '              ' }}   </button>

        
        <div class="sidebar-item">
            <a href="{{ route('client.wishlist') }}">
                <span>❤️</span>
                قائمة المفضلة
            </a>
        </div>
        <div class="sidebar-item">
            <a href="#">
                <span>📦</span>
                الطلبات
            </a>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('client.dashboard') }}">
                <span>👨‍🦱</span>
                الملف الشخصي
            </a>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('client.dashboard') }}">
                <span>🚪</span>
                تسجيل الخروج 
            </a>
        </div>
        
       
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="content">
   
        @yield('content_client')
    </div>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $('#updateProfileForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Send AJAX request to the server to update profile
        $.ajax({
            url: "{{ route('client.profile.update') }}", // Adjust the route accordingly
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    toastr.success('تم تحديث البيانات بنجاح');
                    setTimeout(function(){
                    window.location.href = "/client/dashboard"; // إعادة التوجيه إلى الصفحة الرئيسية
                }, 3000); // الانتظار لمدة 3 ثوانٍ قبل إعادة التوجيه
                    
                } else {
                    toastr.error('حدث خطأ أثناء التحديث. حاول مرة أخرى.');
                }
            },
            error: function(xhr) {
                // Handle validation errors
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, error) {
                        toastr.error(error[0]); // Display validation errors using Toastr
                    });
                } else {
                    toastr.error('حدث خطأ غير متوقع.');
                }
            }
        });
    });
</script>

@endsection
