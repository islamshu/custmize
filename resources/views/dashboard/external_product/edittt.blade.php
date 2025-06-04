@extends('layouts.master')
@section('title', 'تعديل منتج خارجي')

@section('content')
    <div class="container">
        <h3 class="mb-4">تعديل منتج خارجي</h3>

     
    </div>
@endsection

@section('script')
    <script>
        let colorIndex = {{ count($externalProduct->colors) }};

        function addColor() {
            const container = document.getElementById('colors-container');
            const html = `
            <div class="border p-3 mb-3 color-block">
                <div class="form-group">
                    <label>اسم اللون</label>
                    <input type="text" name="colors[${colorIndex}][name]" class="form-control">
                </div>

                {{-- صور اللون الجديد --}}
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label>الصورة الأمامية</label>
                        <input type="file" name="colors[${colorIndex}][front_image]" class="form-control color-image">
                    </div>
                    <div class="col-md-3">
                        <label>الصورة الخلفية</label>
                        <input type="file" name="colors[${colorIndex}][back_image]" class="form-control color-image">
                    </div>
                    <div class="col-md-3">
                        <label>الصورة اليمنى</label>
                        <input type="file" name="colors[${colorIndex}][right_side_image]" class="form-control color-image">
                    </div>
                    <div class="col-md-3">
                        <label>الصورة اليسرى</label>
                        <input type="file" name="colors[${colorIndex}][left_side_image]" class="form-control color-image">
                    </div>
                </div>

                <div class="mt-2">
                    <label>الأحجام:</label>
                    <div class="sizes-container"></div>
                </div>
                <button type="button" class="btn btn-danger btn-sm mt-3" onclick="this.closest('.color-block').remove()">حذف اللون</button>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', html);
            colorIndex++;
        }

        function addSize(button) {
            const sizesContainer = button.previousElementSibling;
            const index = sizesContainer.querySelectorAll('.input-group').length;
            const colorBlock = button.closest('.color-block');
            const colorIdx = Array.from(document.querySelectorAll('.color-block')).indexOf(colorBlock);
            const html = `
            <div class="input-group mb-1">
                <input type="text" name="colors[${colorIdx}][sizes][${index}][name]" class="form-control">
                <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.input-group').remove()">×</button>
            </div>
        `;
            sizesContainer.insertAdjacentHTML('beforeend', html);
        }

        // عرض معاينة الصور عند اختيارها
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('color-image')) {
                    const input = e.target;
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // إنشاء عنصر صورة جديد إذا لم يكن موجوداً
                            if (!input.nextElementSibling || !input.nextElementSibling.tagName ===
                                'IMG') {
                                const img = document.createElement('img');
                                img.style.width = '100px';
                                img.classList.add('img-thumbnail', 'mt-2');
                                input.parentNode.appendChild(img);
                            }
                            input.nextElementSibling.src = e.target.result;
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            });
        });
    </script>
@endsection
