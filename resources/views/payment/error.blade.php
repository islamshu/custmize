<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ في العملية</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 20px;
            direction: rtl;
            text-align: right;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            text-align: center;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h1 {
            color: red;
        }
        .message {
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: red;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>خطأ في العملية</h1>
        <p>حدث خطأ أثناء معالجة طلبك. نأسف للإزعاج.</p>
    </div>

    <div class="message">
        <p>يرجى المحاولة مرة أخرى لاحقاً أو التواصل معنا للحصول على المساعدة.</p>
    </div>

    <a href="{{ url('/') }}" class="btn">الرجوع إلى الصفحة الرئيسية</a>
</div>

</body>
</html>
