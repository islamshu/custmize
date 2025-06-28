@extends('layouts.master')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('تعديل المنتجات المستوردة') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('index_external') }}">{{ __('المنتجات المستودة') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('تعديل المنتجات المستوردة') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="validation">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('تعديل المنتجات المستوردة') }}</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body col-md-12">
                                        @include('dashboard.inc.alerts')

                                        <form action="{{ route('external-products.update', $externalProduct->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            {{-- بيانات المنتج --}}
                                            <div class="card mb-4">
                                                <div class="card-header">بيانات المنتج</div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>اسم المنتج</label>
                                                        <input type="text" name="name" class="form-control"
                                                            value="{{ old('name', $externalProduct->name) }}">
                                                    </div>

                                                    <div class="form-group mt-2">
                                                        <label>الوصف</label>
                                                        <textarea name="description_sale" class="form-control">{{ old('description_sale', $externalProduct->description_sale) }}</textarea>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label for="userinput1">{{ __('Image') }}</label>
                                                        <input type="file" id=""
                                                            class="form-control border-primary image"
                                                            placeholder="{{ __('Image') }}" name="image">
                                                        <div class="form-group">
                                                            <img src="{{ asset('storage/' . $externalProduct->image) }}"
                                                                style="width: 100px" class="img-thumbnail image-preview"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label>الماركة</label>
                                                        <input type="text" name="brand" class="form-control"
                                                            value="{{ old('brand', $externalProduct->brand) }}">
                                                    </div>
                                                     <div class="form-group mt-2">
                                                        <label>التصنيف</label>
                                                        <select name="category_id" class="form-control">
                                                            <option value="" >دون تصنيف</option>
                                                            @foreach ($categories as $item)
                                                            <option value="{{$item->id}}" @if($item->id == $externalProduct->subcategory_id) selected @endif>{{$item->name}} </option>
    
                                                            @endforeach
                                                        </select>
                                                       
                                                    </div>
                                                    <div class="alert alert-info">

                                                        السعر يتراوح بين
                                                        <strong>{{ number_format($externalProduct->getMinPrice(), 2) }}
                                                            ريال</strong> و
                                                        <strong>{{ number_format($externalProduct->getMaxPrice(), 2) }}
                                                            ريال</strong>.
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label>سعر البيع</label>
                                                        <input type="number" step="0.1" min="0" required
                                                            name="price" class="form-control"
                                                            value="{{ old('price', $externalProduct->price) }}">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- الألوان والأحجام --}}
                                            <div class="card mb-4">
                                                <div class="card-header d-flex justify-content-between">
                                                    <span>الألوان والأحجام</span>
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        onclick="addColor()">إضافة لون</button>
                                                </div>
                                                <div class="card-body" id="colors-container">
                                                    @foreach ($externalProduct->colors as $colorIndex => $color)
                                                        <div class="border p-3 mb-3 color-block">
                                                            <div class="form-group">
                                                                <label>اسم اللون</label>
                                                                <input type="text"
                                                                    name="colors[{{ $colorIndex }}][name]"
                                                                    class="form-control" value="{{ $color->name }}">
                                                                <input type="hidden"
                                                                    name="colors[{{ $colorIndex }}][id]"
                                                                    value="{{ $color->id }}">
                                                            </div>

                                                            {{-- صور اللون --}}
                                                            <div class="row mt-3">
                                                                <div class="col-md-3">
                                                                    <label>الصورة الأمامية</label>
                                                                    <input type="file"
                                                                        name="colors[{{ $colorIndex }}][front_image]"
                                                                        class="form-control color-image">
                                                                    @if ($color->front_image)
                                                                        <img src="{{ asset('storage/' . $color->front_image) }}"
                                                                            style="width: 100px" class="img-thumbnail mt-2">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>الصورة الخلفية</label>
                                                                    <input type="file"
                                                                        name="colors[{{ $colorIndex }}][back_image]"
                                                                        class="form-control color-image">
                                                                    @if ($color->back_image)
                                                                        <img src="{{ asset('storage/' . $color->back_image) }}"
                                                                            style="width: 100px" class="img-thumbnail mt-2">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>الصورة اليمنى</label>
                                                                    <input type="file"
                                                                        name="colors[{{ $colorIndex }}][right_side_image]"
                                                                        class="form-control color-image">
                                                                    @if ($color->right_side_image)
                                                                        <img src="{{ asset('storage/' . $color->right_side_image) }}"
                                                                            style="width: 100px" class="img-thumbnail mt-2">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>الصورة اليسرى</label>
                                                                    <input type="file"
                                                                        name="colors[{{ $colorIndex }}][left_side_image]"
                                                                        class="form-control color-image">
                                                                    @if ($color->left_side_image)
                                                                        <img src="{{ asset('storage/' . $color->left_side_image) }}"
                                                                            style="width: 100px"
                                                                            class="img-thumbnail mt-2">
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="mt-2">
                                                                <label>الأحجام:</label>
                                                                <div class="sizes-container">
                                                                    @foreach ($color->sizes as $sizeIndex => $size)
                                                                        <div class="input-group mb-1">
                                                                            <input type="text"
                                                                                name="colors[{{ $colorIndex }}][sizes][{{ $sizeIndex }}][name]"
                                                                                class="form-control"
                                                                                value="{{ $size->name }}">
                                                                            <input type="hidden"
                                                                                name="colors[{{ $colorIndex }}][sizes][{{ $sizeIndex }}][id]"
                                                                                value="{{ $size->id }}">
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm"
                                                                                onclick="this.closest('.input-group').remove()">×</button>
                                                                        </div>
                                                                    @endforeach
                                                                </div>

                                                            </div>

                                                            <button type="button" class="btn btn-danger btn-sm mt-3"
                                                                onclick="this.closest('.color-block').remove()">حذف
                                                                اللون</button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                                        </form>
                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
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
