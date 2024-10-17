<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة تسجيل الدخول</title>
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
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .password-container {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
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
        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #4285f4;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .language-toggle {
            text-align: center;
            margin-top: 20px;
        }
        .language-toggle button {
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <div class="logo">نون</div>
            <h2>مرحبًا، يبدو أنك مسجل الدخول بالفعل باسم<br><span class="email">islamshu12@gmail.com</span></h2>
            <div class="homepage-link">
                <a href="#">هل ترغب في الانتقال إلى الصفحة الرئيسية؟</a>
            </div>
            <form>
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <div class="password-container">
                        <input type="password" id="password" required>
                    </div>
                </div>
                <div class="forgot-password">
                    <a href="#">نسيت كلمة المرور؟</a>
                </div>
                <button type="submit" class="submit-btn">تسجيل الدخول</button>
            </form>
        </div>
    </div>
    <div class="language-toggle">
        <button onclick="toggleLanguage()">العربية</button>
    </div>

    <script>
        

        function toggleLanguage() {
            // This function would handle language toggle in a real application
            console.log('تم النقر على زر تغيير اللغة');
        }
    </script>
</body>
</html>