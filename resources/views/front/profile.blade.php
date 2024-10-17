@extends('layouts.frontend')

@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
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
            <a href="#">
                <span>🔳</span>
                QR كود
            </a>
        </div>
        <div class="sidebar-item">
            <a href="#">
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
            <a href="#">
                <span>↩️</span>
                المرتجعات
            </a>
        </div>
        <div class="sidebar-item">
            <a href="#">
                <span>🏠</span>
                العناوين
            </a>
        </div>
        <div class="sidebar-item">
            <a href="#">
                <span>💳</span>
                المدفوعات
            </a>
        </div>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="content">
   
        
        <h2>معلومات الحساب</h2>

        <form id="updateProfileForm" class="profile-form">
            @csrf
            <div class="form-group">
                <div class="input-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" value="{{ auth('client')->user()->email }}" readonly>
                </div>
                <div class="input-group">
                    <label for="first_name">الاسم الأول</label>
                    <input type="text" name="first_name" id="first_name" value="{{ auth('client')->user()->first_name }}">
                </div>
            </div>
        
            <div class="form-group">
                <div class="input-group">
                    <label for="last_name">اسم العائلة</label>
                    <input type="text" name="last_name" id="last_name" value="{{ auth('client')->user()->last_name }}">
                </div>
                <div class="input-group">
                    <label for="phone">رقم الهاتف</label>
                    <input type="tel" name="phone" id="phone" value="{{ auth('client')->user()->phone }}" placeholder="أضف الرقم">
                </div>
            </div>
        
            <div class="form-group">
                <div class="input-group">
                    <label for="birthdate">تاريخ الميلاد</label>
                    <input type="date" name="birthdate" id="birthdate" placeholder="dd/mm/yyyy" value="{{ auth('client')->user()->DOB }}">
                </div>
                <div class="input-group">
                    <label>الجنس</label>
                    <div class="gender-options">
                        <div class="gender-option">
                            <input type="radio" id="male" name="gender" value="1" {{ auth('client')->user()->gender == '1' ? 'checked' : '' }}>
                            <label for="male">ذكر</label>
                        </div>
                        <div class="gender-option">
                            <input type="radio" id="female" name="gender" value="2" {{ auth('client')->user()->gender == '2' ? 'checked' : '' }}>
                            <label for="female">أنثى</label>
                        </div>
                    </div>
                </div>
            </div>
        
            <button type="submit" class="save-button">حفظ التعديلات</button>
        </form>
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
