<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة تسجيل جديد</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            height: 100%;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .login-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 40px;
            width: 400px;
        }
        .logo {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            font-size: 18px;
            font-weight: normal;
            margin-bottom: 20px;
        }
        .email {
            font-weight: bold;
        }
        
        .homepage-link {
            text-align: center;
            margin-bottom: 30px;
        }
        .homepage-link a {
            color: #3366cc;
            text-decoration: none;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="email"],input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .error-message {
            color: red;
            font-size: 14px;
        }
        .password-container {
            position: relative;
        }
        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }
        .forgot-password a {
            color: #3366cc;
            text-decoration: none;
            font-size: 14px;
        }
        .submit-btn, .register-btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-btn {
            background-color: #56ca24;
            color: white;
            margin-bottom: 15px;
        }
    </style>
    <!-- إضافة ملفات CSS و JavaScript الخاصة بـ Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>
    <div class="container">
        <div class="login-card">
            <div class="logo">
                <img width="200" height="100" src="{{ asset('uploads/'.get_general_value('website_logo')) }}" alt="">
            </div>
            <h2>مرحبًا بك في {{ get_general_value('website_name') }}</h2>
            <div class="homepage-link">
                <a href="{{ route('client.login') }}">هل لديك حساب بالفعل ؟</a>
            </div>
            <form id="registerForm">
                @csrf
                <div class="form-group">
                    <label for="firstname">الاسم الأول </label>
                    <input type="text" name="firstname" id="firstname" required>
                    <span class="error-message" id="firstname-error"></span>
                </div>
                <div class="form-group">
                    <label for="lastname">الاسم الثاني </label>
                    <input type="text" name="lastname" id="lastname" required>
                    <span class="error-message" id="lastname-error"></span>
                </div>
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" required>
                    <span class="error-message" id="email-error"></span>
                </div>
                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" required>
                    </div>
                    <span class="error-message" id="password-error"></span>
                </div>
                <div class="form-group">
                    <label for="confirm-password">تأكيد كلمة المرور  </label>
                    <div class="password-container">
                        <input type="password" name="confirm_password" id="confirm-password" required>
                    </div>
                    <span class="error-message" id="confirm-password-error"></span>
                </div>
                <button type="submit" class="submit-btn btn-success">تسجيل</button>
            </form>
        </div>
    </div>

    <!-- إضافة مكتبة jQuery و Toastr -->
   <!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // إعدادات Toastr الافتراضية (اختياري)
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right", // مكان عرض الرسالة
            "timeOut": "5000", // مدة بقاء الرسالة
        };

        $('#registerForm').on('submit', function (e) {
            e.preventDefault(); // منع الإرسال الافتراضي للنموذج

            // إزالة رسائل الخطأ السابقة
            $('.error-message').text('');

            $.ajax({
                url: "{{ route('client.register.post') }}", // رابط الإرسال إلى السيرفر
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    if (response.success) {
                        // عرض رسالة نجاح باستخدام Toastr
                        toastr.success('تم التسجيل بنجاح!');

                        // إعادة توجيه المستخدم إلى الصفحة الرئيسية أو لوحة التحكم
                        setTimeout(function(){
                    window.location.href = "/"; // إعادة التوجيه إلى الصفحة الرئيسية
                }, 3000); // الانتظار لمدة 3 ثوانٍ قبل إعادة التوجيه
                    }
                },
                error: function (xhr) {
    console.log(xhr.responseJSON); // طباعة استجابة الخادم في وحدة التحكم
    let errors = xhr.responseJSON.errors;
    if (errors) {
        if (errors.firstname) {
            $('#firstname-error').text(errors.firstname[0]);
        }
        if (errors.lastname) {
            $('#lastname-error').text(errors.lastname[0]);
        }
        if (errors.email) {
            $('#email-error').text(errors.email[0]);
        }
        if (errors.password) {
            $('#password-error').text(errors.password[0]);
        }
        if (errors.confirm_password) {
            $('#confirm-password-error').text(errors.confirm_password[0]);
        }
    }
}

            });
        });
    </script>
</body>
</html>
