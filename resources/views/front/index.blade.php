@extends('layouts.frontend')
@section('style')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        .circle-container {
            width: 95%;
            height: 450px;
            max-width: 1000px;
            position: relative;
            margin: auto;
        }

        .profile-item {
            position: absolute;
            transition: all 0.5s ease;
        }

        .profile-circle {
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
            transition: all 0.5s ease;
        }

        .profile-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* border: 4px solid #d3d8db; */
            /* سمك ولون البوردر */
            border-radius: 50%;
            /* جعل البوردر دائري تماماً */
            padding: 5px;
            /* مسافة بين الصورة والحد */
        }

        .customize-link {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 120px;
            white-space: nowrap;
            display: none;
            text-decoration: none;
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
        }

        .active .customize-link {
            top: 102%;
            display: block;
        }

        .nav-arrow {
            position: absolute;
            bottom: -40px;
            /* وضع الأسهم في الأسفل */
            font-size: 24px;
            color: #6c757d;
            cursor: pointer;
            z-index: 20;
        }

        .nav-arrow.left {
            left: 0%;
        }

        /* تعديل المواقع ليتوسطا الشاشة */
        .nav-arrow.right {
            right: 0%;
        }

        .favorite-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #ccc;
            /* اللون الافتراضي للأيقونة */
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .favorite-icon.favorited {
            color: #e74c3c;
            /* اللون الأحمر عند إضافة المنتج إلى المفضلة */
        }

        .favorite-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            color: #ccc;
            /* اللون الافتراضي للقلب */
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .favorite-icon:hover {
            color: #ff4757;
            /* لون القلب عند تمرير الماوس */
        }

        .favorite-icon.favorited {
            color: white;
            /* يصبح أبيض عند النقر */
            background-color: #e74c3c;
            /* إضافة خلفية حمراء للقلب */
            border-radius: 50%;
            padding: 5px;
        }



        /* Responsive adjustments */
        @media (max-width: 768px) {
            .circle-container {
                height: 400px;
            }

            .profile-circle {
                width: 80px;
                height: 80px;
            }

            .profile-item.active .profile-circle {
                width: 350px;
                /* حجم العنصر النشط */
                height: 350px;
                transform: translate(-50%, -50%) scale(1.2);
                /* تكبير العنصر النشط */
                z-index: 10;
                /* ضمان ظهور العنصر النشط في الأعلى */
                border: 6px solid rgba(66, 183, 126, 0.3);
                /* إضافة إطار دائري شفاف */
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
                /* إضافة ظل أسفل العنصر */
            }

            .profile-item.active img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                /* للتأكد أن الصورة تظهر كاملة */
                border-radius: 50%;
                /* التأكد من أن الصورة دائرية تماماً */
            }

            .nav-arrow {
                font-size: 24px;
                color: #6c757d;
                cursor: pointer;
                z-index: 20;
            }

            .nav-arrow.left {
                left: 0;
            }

            .nav-arrow.right {
                right: 0;
            }

            /* للتأكد أن العنصر النشط يستجيب بشكل جيد على الشاشات الأصغر */
            @media (max-width: 768px) {
                .profile-item.active .profile-circle {
                    width: 300px;
                    height: 300px;
                }
            }

            @media (max-width: 576px) {
                .profile-item.active .profile-circle {
                    width: 250px;
                    height: 250px;
                }
            }
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="circle-container">
                <!-- Profile items -->
                @foreach ($products as $key => $item)
                    <div class="profile-item {{ $key + 1 == 7 ? 'active' : '' }}">
                        <div class="profile-circle">
                            <img src="{{ asset('uploads/' . $item->image) }}" alt="Profile 1" title="{{ $key }}">
                        </div>
                        <a href="{{ route('showProduct', $item->slug) }}" class="customize-link">تخصيص</a>
                        @if (auth('client')->user())
                            <i class="fas fa-heart favorite-icon {{ $item->favorites->isNotEmpty() ? 'favorited' : '' }}"
                                data-id="{{ $item->id }}"></i>
                        @endif

                    </div>
                @endforeach

                <div class="nav-arrow left"><i class="fas fa-chevron-left"></i></div>
                <div class="nav-arrow right"><i class="fas fa-chevron-right"></i></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.circle-container');
    const centerX = container.offsetWidth / 2;
    const centerY = container.offsetHeight / 2;
    const items = container.querySelectorAll('.profile-item');
    const numItems = items.length; // عد العناصر الفعلية
    const visibleItems = 8; // عرض 8 منتجات فقط
    let activeIndex = Math.min(Math.floor(visibleItems / 2), numItems - 1); // العنصر النشط يبدأ في المنتصف أو العنصر الأخير إذا كان العدد أقل من 8
    let currentStartIndex = 0; // المتتبع لأول عنصر يظهر في المجموعة
    let autoRotateInterval;

    // دالة لتحديث العناصر
    function updateItems() {
        const radiusX = centerX * 1.1;
        const radiusY = centerY * 0.7;

        items.forEach((item, index) => {
            // إخفاء جميع العناصر أولاً
            item.style.display = 'none';

            // فقط العناصر التي تقع ضمن حدود 8 منتجات مرئية
            if (index >= currentStartIndex && index < currentStartIndex + visibleItems) {
                const visibleIndex = index - currentStartIndex;
                const angle = (visibleIndex - activeIndex + visibleItems) % visibleItems * (2 * Math.PI / visibleItems) + Math.PI / 2;
                const x = centerX + radiusX * Math.cos(angle);
                const y = centerY + radiusY * Math.sin(angle);

                item.style.left = `${x}px`;
                item.style.top = `${y}px`;

                // إظهار العنصر
                item.style.display = 'block';

                const distanceFromActive = Math.min(Math.abs(visibleIndex - activeIndex), visibleItems - Math.abs(visibleIndex - activeIndex));

                let size;
                if (distanceFromActive === 0) {
                    size = 290;
                } else if (distanceFromActive === 1) {
                    size = 200;
                } else {
                    size = Math.max(260 - (distanceFromActive * 60), 50);
                }

                const profileCircle = item.querySelector('.profile-circle');
                profileCircle.style.width = `${size}px`;
                profileCircle.style.height = `${size}px`;

                if (visibleIndex === activeIndex) {
                    item.style.transform = `translate(-50%, -50%) scale(1.2)`;
                    item.classList.add('active');
                    /* item.querySelector('.favorite-icon').style.display = 'block'; // عرض أيقونة القلب فقط للعنصر النشط */
                } else {
                    item.style.transform = `translate(-50%, -50%) scale(1)`;
                    item.classList.remove('active');
                    /* item.querySelector('.favorite-icon').style.display = 'none'; // إخفاء أيقونة القلب لبقية العناصر */
                }
            }
        });

        const activeItem = container.querySelector('.profile-item.active');
        activeItem.addEventListener('mouseover', stopAutoRotate);
        activeItem.addEventListener('mouseout', startAutoRotate);
    }

    // دالة لتدوير العناصر
    function rotateItems(direction) {
        activeIndex = (activeIndex - direction + visibleItems) % visibleItems;

        if (direction === -1 && currentStartIndex + visibleItems < numItems) {
            currentStartIndex++;
        } else if (direction === 1 && currentStartIndex > 0) {
            currentStartIndex--;
        }

        updateItems();
    }

    // جعل العنصر الذي تم النقر عليه نشطًا
    items.forEach((item, index) => {
        item.addEventListener('click', function() {
            activeIndex = (index - currentStartIndex) % visibleItems;
            updateItems();
        });
    });

    // بدء التدوير التلقائي
    function startAutoRotate() {
        autoRotateInterval = setInterval(() => {
            rotateItems(-1);
        }, 5000);
    }

    // إيقاف التدوير التلقائي
    function stopAutoRotate() {
        clearInterval(autoRotateInterval);
    }

    startAutoRotate();

    // التحكم بالأسهم للتدوير اليدوي
    document.querySelector('.nav-arrow.left').addEventListener('click', () => rotateItems(1)); // لتدوير للأمام
    document.querySelector('.nav-arrow.right').addEventListener('click', () => rotateItems(-1)); // لتدوير للخلف

    // التحديث الأول للعناصر
    updateItems();
});



        document.addEventListener('DOMContentLoaded', function() {
            const favoriteIcons = document.querySelectorAll('.favorite-icon');
            /* alert(is_auth); */

            favoriteIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    const isFavorited = this.classList.contains('favorited');
                    // إرسال طلب Ajax لإضافة أو حذف المنتج من المفضلة
                    fetch(`/favorite/${productId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // حماية ضد CSRF
                            },
                            body: JSON.stringify({
                                favorite: !isFavorited
                            })
                        })
                        .then(response => response.json())
                        .then(data => {

                            if (data.success) {
                                // تغيير لون القلب بعد النقر
                                this.classList.toggle('favorited');

                                // عرض رسالة SweetAlert بناءً على الحالة
                                if (this.classList.contains('favorited')) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'تمت الإضافة بنجاح',
                                        text: 'تمت إضافة المنتج إلى قائمتك المفضلة!',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'تم الحذف بنجاح',
                                        text: 'تمت إزالة المنتج من قائمتك المفضلة!',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                }
                            } else {
                                console.error('Failed to update favorite status.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>
@endsection
