<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>موقعي الاحترافي</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
</head>
<body>

    <!-- الشريط العلوي -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">موقعي</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">الخدمات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">منتجات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">اتصل بنا</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- سلايدر الصور الرئيسي -->
    <div id="mainSlider" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="slider1.jpg" class="d-block w-100" alt="Slider 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>الرسالة الأولى</h5>
                    <p>محتوى السلايدر الأول.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="slider2.jpg" class="d-block w-100" alt="Slider 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>الرسالة الثانية</h5>
                    <p>محتوى السلايدر الثاني.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="slider3.jpg" class="d-block w-100" alt="Slider 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>الرسالة الثالثة</h5>
                    <p>محتوى السلايدر الثالث.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#mainSlider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">السابق</span>
        </a>
        <a class="carousel-control-next" href="#mainSlider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">التالي</span>
        </a>
    </div>

    <!-- الأقسام -->
    <section class="sections mt-5">
        <div class="container">
            <h2 class="text-center mb-4">أقسام مميزة</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="section1.jpg" class="card-img-top" alt="قسم 1">
                        <div class="card-body">
                            <h5 class="card-title">قسم 1</h5>
                            <p class="card-text">محتوى هذا القسم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="section2.jpg" class="card-img-top" alt="قسم 2">
                        <div class="card-body">
                            <h5 class="card-title">قسم 2</h5>
                            <p class="card-text">محتوى هذا القسم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="section3.jpg" class="card-img-top" alt="قسم 3">
                        <div class="card-body">
                            <h5 class="card-title">قسم 3</h5>
                            <p class="card-text">محتوى هذا القسم.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- سلايدر المنتجات -->
    <section class="products-slider mt-5">
        <div class="container">
            <h2 class="text-center mb-4">منتجات مميزة</h2>
            <div id="productCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="product1.jpg" class="card-img-top" alt="منتج 1">
                                    <div class="card-body">
                                        <h5 class="card-title">منتج 1</h5>
                                        <p class="card-text">وصف المنتج 1.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="product2.jpg" class="card-img-top" alt="منتج 2">
                                    <div class="card-body">
                                        <h5 class="card-title">منتج 2</h5>
                                        <p class="card-text">وصف المنتج 2.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- منتجات إضافية -->
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <!-- منتجات إضافية -->
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">السابق</span>
                </a>
                <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">التالي</span>
                </a>
            </div>
        </div>
    </section>

    <!-- الفوتر -->
    <footer class="bg-dark text-white text-center p-4 mt-5">
        <p>© 2024 جميع الحقوق محفوظة</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
