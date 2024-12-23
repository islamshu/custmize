@extends('layouts.master')
@section('style')
    <style>
        .color-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }

        .color-card h5 {
            margin-bottom: 10px;
            font-size: 1.2rem;
            color: #333;
        }

        .sizes-container {
            margin-top: 10px;
        }

        .size-group {
            padding: 10px;
            border: 1px dashed #ccc;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .remove-size {
            color: white;
            background-color: red;
            border: none;
            padding: 7px;
            border-radius: 35%;
            cursor: pointer;
            margin-top: 25px;
        }


        .remove-size:hover {
            background-color: darkred;
        }
    </style>
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('Edit Product') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('Products') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Edit Product') }}</li>
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
                                    <h4 class="card-title">{{ __('Edit Product') }}</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @include('dashboard.inc.alerts')

                                        <!-- Update Form -->
                                        <form action="{{ route('products.update', @$product->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT') <!-- Add the PUT method for updating -->

                                            <!-- Product Type -->
                                            <div class="form-group col-8 ">
                                                <label for="product_type_id">{{ __('Category') }}</label>
                                                <select id="category_id" name="category_id" class="form-control" required>
                                                    <option value="">{{ __('choose') }} {{ __('Category') }}
                                                    </option>
                                                    @foreach ($categories as $cats)
                                                        <option value="{{ $cats->id }}"
                                                            {{ $product->category_id == $cats->id ? 'selected' : '' }}>
                                                            {{ $cats->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-8 ">
                                                <label for="product_type_id">{{ __('Sub Categories') }}</label>
                                                <select id="subcategory_id" name="subcategory_id" class="form-control"
                                                    required>
                                                    <option value="">{{ __('choose') }} {{ __('Sub Categories') }}
                                                    </option>
                                                    @foreach (App\Models\SubCategory::where('category_id', $product->category_id)->get() as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $product->subcategory_id == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>


                                            <!-- Product Name -->
                                            <div class="form-group col-8">
                                                <label for="name">{{ __('Product Name') }}</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                    value="{{ old('name', @$product->name) }}"
                                                    placeholder="{{ __('Enter product name') }}" required>
                                            </div>
                                            <div class="form-group col-8">
                                                <label for="name_ar">{{ __('Product Name in arabic') }}</label>
                                                <input type="text" id="name_ar" name="name_ar" class="form-control"
                                                    value="{{ old('name_ar', @$product->name_ar) }}"
                                                    placeholder="{{ __('Enter product name in arabic') }}" required>
                                            </div>
                                            <div class="form-group col-8">
                                                <label for="name">{{ __('3D model') }}</label>
                                                <input type="file" id="file" class="form-control" name="file"
                                                    accept=".glb,.gltf">
                                                <a href="{{ $product->image }}">preview model</a>
                                            </div>

                                            <div class="form-group col-8">
                                                <div class="form-group">
                                                    <label for="images">{{ __('Guidness Image') }}</label>
                                                    <input type="file" name="guidness[]" id="images"
                                                        class="form-control" multiple onchange="previewImages()">
                                                </div>
                                                <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;">

                                                    <!-- عرض الصور القديمة -->
                                                    <div id="existing-images"
                                                        style="display: flex; gap: 10px; flex-wrap: wrap;">
                                                        @foreach (json_decode($product->guidness_pic) as $item)
                                                            <div class="image-container"
                                                                style="position: relative; width: 100px; height: 100px;">
                                                                <img src="{{ asset('storage/' . $item) }}"
                                                                    alt="Uploaded Image"
                                                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                                                <span class="delete-existing"
                                                                    onclick="removeExistingImage('{{ $item }}', this)"
                                                                    style="position: absolute; top: 5px; right: 5px; color: white; background-color: red; border-radius: 50%; cursor: pointer; padding: 5px;">&times;</span>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <!-- عرض معاينة الصور الجديدة -->
                                                    <div id="image-preview"
                                                        style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                                                </div>
                                                <input type="hidden" name="deleted_images" id="deleted_images"
                                                    value="">


                                                <!-- عرض معاينة الصور الجديدة -->
                                                <div id="image-preview"
                                                    style="margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                                                </div>

                                            </div>

                                            <!-- Description -->
                                            <div class="form-group col-8">
                                                <label for="description">{{ __('Description') }}</label>
                                                <textarea id="description" name="description" class="form-control" rows="4"
                                                    placeholder="{{ __('Enter product description') }}">{{ old('description', @$product->description) }}</textarea>
                                            </div>
                                            <div class="form-group col-8">
                                                <label for="description_ar">{{ __('Description in arabic') }}</label>
                                                <textarea id="description_ar" name="description_ar" class="form-control" rows="4"
                                                    placeholder="{{ __('Enter product description in arabic') }}">{{ old('description_ar', @$product->description_ar) }}</textarea>
                                            </div>
                                            <div class="form-group col-8">
                                                <label for="description">{{ __('Delivery date') }}</label>
                                                <input type="number" value="{{ $product->delivery_date }}"
                                                    name="delivery_date" class="form-control">
                                            </div>

                                            <!-- Fixed Price -->


                                            <!-- Price -->
                                            <div class="form-group col-8">
                                                <label for="price">{{ __('Price') }}</label>
                                                <input type="number" id="price" name="price" class="form-control"
                                                    value="{{ old('price', @$product->price) }}" step="0.01"
                                                    placeholder="{{ __('Enter product price') }}" required>
                                            </div>
                                            <div class="form-group col-8">
                                                <label for="min_sale">{{ __('Min product can be sale') }}</label>
                                                <input type="number" id="min_sale" name="min_sale"
                                                    class="form-control"
                                                    value="{{ old('min_sale', @$product->min_sale) }}"
                                                    placeholder="{{ __('Min product can be sale') }}" required>
                                            </div>

                                            <!-- Colors Section (for T-shirt) -->
                                            @php
                                                $attributes = json_decode($product->subcategory->attributs);
                                            @endphp

                                            <div id="colors-section" class="form-group col-12"
                                                style="border: 1px solid #ddd; padding: 15px;">
                                                <label>{{ __('Colors') }}</label>
                                                <select id="colors" name="color_ids[]" class="form-control select2"
                                                    multiple>
                                                    @foreach ($colors as $color)
                                                        <option value="{{ $color->id }}"
                                                            @if ($product->colors->pluck('id')->contains($color->id)) selected @endif>
                                                            {{ $color->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <!-- Container for dynamic color inputs -->
                                                <div id="colors-container" class="mt-3">
                                                    @foreach ($product->colors as $color)
                                                        <div id="color-{{ $color->id }}" class="color-group mb-3"
                                                            style="border: 1px solid #ccc; padding: 15px;">
                                                            <h5>{{ $color->name }}</h5>
                                                            <div class="form-row">
                                                                <!-- Front Image -->
                                                                <div class="col-md-3">
                                                                    <label>{{ __('Front Image') }}</label>
                                                                    <input type="file"
                                                                        name="colors_data[{{ $color->id }}][front_image]"
                                                                        class="form-control"
                                                                        onchange="previewImage(this, 'front-preview-{{ $color->id }}')">
                                                                    <img id="front-preview-{{ $color->id }}"
                                                                        src="{{ asset('storage/' . $color->pivot->front_image) }}"
                                                                        style="margin-top:10px; width:100px; height:100px; object-fit:cover;">
                                                                </div>

                                                                <!-- Back Image -->
                                                                <div class="col-md-3">
                                                                    <label>{{ __('Back Image') }}</label>
                                                                    <input type="file"
                                                                        name="colors_data[{{ $color->id }}][back_image]"
                                                                        class="form-control"
                                                                        onchange="previewImage(this, 'back-preview-{{ $color->id }}')">
                                                                    @if ($color->pivot->back_image)
                                                                        <img id="back-preview-{{ $color->id }}"
                                                                            src="{{ asset('storage/' . $color->pivot->back_image) }}"
                                                                            style="margin-top:10px; width:100px; height:100px; object-fit:cover;">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>{{ __('Right Side Image') }}</label>
                                                                    <input type="file"
                                                                        name="colors_data[{{ $color->id }}][right_side_image]"
                                                                        class="form-control"
                                                                        onchange="previewImage(this, 'right_side_image-preview-{{ $color->id }}')">
                                                                    @if ($color->pivot->back_image)
                                                                        <img id="right_side_image-preview-{{ $color->id }}"
                                                                            src="{{ asset('storage/' . $color->pivot->right_side_image) }}"
                                                                            style="margin-top:10px; width:100px; height:100px; object-fit:cover;">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>{{ __('Left Side Image') }}</label>
                                                                    <input type="file"
                                                                        name="colors_data[{{ $color->id }}][left_side_image]"
                                                                        class="form-control"
                                                                        onchange="previewImage(this, 'left_side_image-preview-{{ $color->id }}')">
                                                                    @if ($color->pivot->back_image)
                                                                        <img id="left_side_image-preview-{{ $color->id }}"
                                                                            src="{{ asset('storage/' . $color->pivot->left_side_image) }}"
                                                                            style="margin-top:10px; width:100px; height:100px; object-fit:cover;">
                                                                    @endif
                                                                </div>

                                                                <!-- Price -->
                                                                <div class="col-md-3">
                                                                    <label>{{ __('Price') }}</label>
                                                                    <input type="number"
                                                                        name="colors_data[{{ $color->id }}][price]"
                                                                        class="form-control"
                                                                        value="{{ $color->pivot->price }}">
                                                                </div>
                                                            </div>

                                                            <!-- Sizes Section -->
                                                            <div class="sizes-container mt-3"
                                                                id="sizes-container-{{ $color->id }}">
                                                                @foreach ($color->sizes($product->id)->get() as $index=> $size)
                                                                <div class="size-group form-row">
                                                                        <div class="col-md-6">
                                                                            <label>{{ __('Size') }}</label>
                                                                            <select
                                                                                name="colors_data[{{ $color->id }}][sizes][{{ $index }}][id]"
                                                                                class="form-control">
                                                                                @foreach ($sizes as $availableSize)
                                                                                    <option
                                                                                        value="{{ $availableSize->id }}"
                                                                                        {{ $size->id == $availableSize->id ? 'selected' : '' }}>
                                                                                        {{ $availableSize->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label>{{ __('Price') }}</label>
                                                                            <input type="number"
                                                                                name="colors_data[{{ $color->id }}][sizes][{{ $index }}][price]"
                                                                                class="form-control"
                                                                                value="{{ $size->pivot->price }}">
                                                                        </div>
                                                                        <div class="col-md-2 d-flex align-items-center">
                                                                            <button type="button"
                                                                                class="btn btn-danger remove-size">&times;</button>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <button type="button"
                                                                class="btn btn-primary btn-sm mt-2 add-size"
                                                                data-color-id="{{ $color->id }}">
                                                                {{ __('Add Size') }}
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div
                                                class="form-group col-8 type_product  {{ in_array('types', $attributes) == true ? '' : 'd-none' }}">
                                                <label for="pen_type">{{ __('Type') }}</label>
                                                @php
                                                    $types = App\Models\CategoryTypes::where(
                                                        'sub_category_id',
                                                        $product->subcategory_id,
                                                    )->get(['type_id']);
                                                    $arr = [];
                                                    foreach ($types as $t) {
                                                        array_push($arr, $t->type_id);
                                                    }
                                                    $typess = App\Models\TypeCategory::whereIn('id', $arr)->get();

                                                @endphp
                                                @foreach ($typess as $item)
                                                @endforeach
                                                <select id="type_product" name="type_product" class="form-control">
                                                    <option value="" disabled>{{ __('choose') }}
                                                    </option>

                                                    @foreach ($typess as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Pen Specific Fields (for Pen) -->


                                            <!-- Submit Button -->
                                            <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
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

@section('script')
    <script>
        $(document).ready(function() {
            $('#category_id').on('change', function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $('#colors-container').empty();
                    $('#colors-section').addClass('d-none');
                    $('#sizes-section').addClass('d-none');
                    $('#sizes').val(null).trigger("change");

                    $('#colors').val(null).trigger("change");
                    $('.type_product').addClass('d-none');
                    $('#type_product').val('');
                    $('#type_product').empty();
                    $('#subcategory_id').empty();


                    $.ajax({
                        url: '{{ route('get.subcategories', ':category_id') }}'.replace(
                            ':category_id', categoryId),
                        type: "GET",
                        dataType: "json",
                        success: function(data) {





                            $('#subcategory_id').append(
                                '<option value="">{{ __('choose') }} {{ __('Sub Categories') }} </option>'
                            );
                            $.each(data, function(key, value) {
                                $('#subcategory_id').append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#subcategory_id').empty();
                    $('#subcategory_id').append(
                        '<option value="">{{ __('choose') }} {{ __('Sub Categories') }} </option>');
                }
            });
            $('#subcategory_id').on('change', function() {
                var subcategoryId = $(this).val();
                $.ajax({
                    url: '{{ route('get_deteitls_subcategories', ':subcategoryId') }}'.replace(
                        ':subcategoryId', subcategoryId),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        // Clear previous selections
                        $('#colors-container').empty();
                        $('#colors').val(null).trigger("change");
                        $('.type_product').addClass('d-none');
                        $('#type_product').val('');
                        $('#type_product').empty();

                        // Check if subcategories and types exist in the response
                        if (data.subcategorries && data.types) {
                            const subcategory = data.subcategorries;
                            const types = data.types;

                            // Handle types
                            if (types.length > 0) {
                                $('.type_product').removeClass('d-none');
                                // Populate type options here if needed
                                // $('#type_product').append(...);
                                $('#type_product').append(
                                    $('<option>', {
                                        value: '',
                                        text: '{{ __('choose') }}',
                                        disabled: true,
                                        selected: true
                                    })
                                );
                                $.each(data.types, function(key, value) {
                                    // Append types to appropriate select element
                                    $('#type_product').append('<option value="' + value
                                        .id + '">' + value.name + '</option>');
                                });
                            } else {
                                $('.type_product').addClass('d-none');
                            }

                            // Handle colors
                            const hasColors1 = subcategory.have_colors1;
                            const hasColors2 = subcategory.have_colors2;
                            const hasTypes = subcategory.have_types;

                            const atts = subcategory.attributs;
                            if (atts.includes('sizes') == true) {
                                $('#sizes-section').removeClass('d-none');
                            } else {
                                $('#sizes-section').addClass('d-none');

                            }
                            if (atts.includes('colors1') || atts.includes('colors2')) {
                                $('#colors-section').removeClass('d-none');
                                if (atts.includes('colors1')) {
                                    $('#color_type').val(1);
                                } else if (atts.includes('colors2')) {
                                    $('#color_type').val(2);
                                }
                            } else {
                                $('#colors-section').addClass('d-none');
                            }

                            // Additional logic for subcategory can be added here
                            // For example, updating subcategory name or other fields
                        } else {
                            console.error('Expected data not found in the response');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX request failed: " + error);
                    }
                });
            });


        });
        document.addEventListener('DOMContentLoaded', function() {
            // تفعيل select2
            $('.select2').select2();

            const productTypeSelect = document.getElementById('product_type_id');
            const colorsSection = document.getElementById('colors-section');
            const sizesSection = document.getElementById('sizes-section');
            const penFields = document.getElementById('pen-fields');

            // Function to check if old input is available and display correct fields
            function displayOldData() {
                const selectedType = "{{ old('product_type_id') }}";

                if (selectedType === '1') {
                    colorsSection.classList.remove('d-none');
                    sizesSection.classList.remove('d-none');
                    penFields.classList.add('d-none');
                } else if (selectedType === '2') {
                    colorsSection.classList.remove('d-none'); // Show colors for pen as well
                    sizesSection.classList.add('d-none');
                    penFields.classList.remove('d-none');
                }
            }

            // Initialize the old data display
            displayOldData();



            // Handle Colors selection
            // $('#colors').on('change', function() {
            //     const selectedColors = $(this).val();
            //     const colorsContainer = document.getElementById('colors-container');
            //     colorsContainer.innerHTML = ''; // Clear previous fields

            //     if (selectedColors.length > 0) {
            //         selectedColors.forEach(function(colorId) {
            //             const colorName = document.querySelector(
            //                 `#colors option[value="${colorId}"]`).text;
            //             var colortype = $('#color_type').val();

            //             let colorFields = '';
            //             if (colortype == 2) {
            //                 colorFields = `
        //                 <div class="color-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
        //                     <h5>${colorName}</h5>
        //                     <div class="form-row">
        //                         <input type="hidden" name="colors[${colorId}][id]" value="${colorId}" class="form-control">

        //                         <div class="col-md-4">
        //                             <label>{{ __('Front Image') }}</label>
        //                             <input type="file" name="colors[${colorId}][front_image]" class="form-control" accept="image/*" onchange="previewImage(this, 'front-preview-${colorId}')">
        //                             <img id="front-preview-${colorId}" class="mt-2" style="max-width: 100px; display: none;">
        //                         </div>
        //                         <div class="col-md-4">
        //                             <label>{{ __('Back Image') }}</label>
        //                             <input type="file" name="colors[${colorId}][back_image]" class="form-control" accept="image/*" onchange="previewImage(this, 'back-preview-${colorId}')">
        //                             <img id="back-preview-${colorId}" class="mt-2" style="max-width: 100px; display: none;">
        //                         </div>
        //                         <div class="col-md-4">
        //                             <label>{{ __('Price') }}</label>
        //                             <input type="number" name="colors[${colorId}][price]" class="form-control" ">
        //                         </div>
        //                     </div>
        //                 </div>`;
            //             } else if (colortype == 1) {
            //                 colorFields = `
        //                 <div class="color-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
        //                     <h5>${colorName}</h5>
        //                     <div class="form-row">
        //                         <input type="hidden" name="colors[${colorId}][id]" value="${colorId}" class="form-control">

        //                         <div class="col-md-6">
        //                             <label>{{ __('Image') }}</label>
        //                             <input type="file" name="colors[${colorId}][front_image]" class="form-control" accept="image/*" onchange="previewImage(this, 'front-preview-${colorId}')">
        //                             <img id="front-preview-${colorId}" class="mt-2" style="max-width: 100px; display: none;">
        //                         </div>
        //                         <div class="col-md-6">
        //                             <label>{{ __('Price') }}</label>
        //                             <input type="number" name="colors[${colorId}][price]" class="form-control" ">
        //                         </div>

        //                     </div>
        //                 </div>`;
            //             }


            //             colorsContainer.insertAdjacentHTML('beforeend', colorFields);
            //         });
            //     }
            // });
            // $('#colors').on('change', function() {
            //     const selectedColors = $(this).val();
            //     const colorsContainer = document.getElementById('colors-container');

            //     // لا تقم بإفراغ الحقول السابقة
            //     // colorsContainer.innerHTML = ''; // لا نقوم بمسح الحقول القديمة هنا

            //     if (selectedColors.length > 0) {
            //         selectedColors.forEach(function(colorId) {
            //             // تحقق مما إذا كان اللون مضافًا مسبقًا
            //             if (!document.getElementById('color-' + colorId)) {
            //                 const colorName = document.querySelector(
            //                     `#colors option[value="${colorId}"]`).text;
            //                 var colortype = $('#color_type').val();

            //                 let colorFields = '';
            //                 if (colortype == 2) {
            //                     colorFields = `
        //         <div id="color-${colorId}" class="color-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
        //             <h5>${colorName}</h5>
        //             <div class="form-row">
        //                 <input type="hidden" name="colors[${colorId}][id]" value="${colorId}" class="form-control">

        //                 <div class="col-md-4">
        //                     <label>{{ __('Front Image') }}</label>
        //                     <input type="file" name="colors[${colorId}][front_image]" class="form-control" accept="image/*">
        //                     <img id="front-preview-${colorId}" class="mt-2" style="max-width: 100px; display: none;">
        //                 </div>
        //                 <div class="col-md-4">
        //                     <label>{{ __('Back Image') }}</label>
        //                     <input type="file" name="colors[${colorId}][back_image]" class="form-control" accept="image/*">
        //                     <img id="back-preview-${colorId}" class="mt-2" style="max-width: 100px; display: none;">
        //                 </div>
        //                 <div class="col-md-4">
        //                     <label>{{ __('Price') }}</label>
        //                     <input type="number" name="colors[${colorId}][price]" class="form-control">
        //                 </div>
        //             </div>
        //         </div>`;
            //                 } else if (colortype == 1) {
            //                     colorFields = `
        //         <div id="color-${colorId}" class="color-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
        //             <h5>${colorName}</h5>
        //             <div class="form-row">
        //                 <input type="hidden" name="colors[${colorId}][id]" value="${colorId}" class="form-control">

        //                 <div class="col-md-4">
        //                     <label>{{ __('Image') }}</label>
        //                     <input type="file" name="colors[${colorId}][front_image]" class="form-control" accept="image/*">
        //                     <img id="front-preview-${colorId}" class="mt-2" style="max-width: 100px; display: none;">
        //                 </div>
        //                 <div class="col-md-4">
        //                     <label>{{ __('Price') }}</label>
        //                     <input type="number" name="colors[${colorId}][price]" class="form-control">
        //                 </div>
        //             </div>
        //         </div>`;
            //                 }

            //                 // أضف اللون الجديد دون حذف الألوان السابقة
            //                 colorsContainer.insertAdjacentHTML('beforeend', colorFields);
            //             }
            //         });
            //     }
            // });
            $('#colors').on('change', function() {
                const selectedColors = $(this).val(); // الألوان المحددة حاليًا
                const colorsContainer = $('#colors-container');

                // إضافة الألوان الجديدة
                if (selectedColors && selectedColors.length > 0) {
                    selectedColors.forEach(function(colorId) {
                        if (!document.getElementById(`color-${colorId}`)) {
                            const colorName = $(`#colors option[value="${colorId}"]`).text();

                            const colorField = `
                        <div id="color-${colorId}" class="color-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
                            <h5>${colorName}</h5>
                            <div class="form-row">
                                <!-- Front Image -->
                                <div class="col-md-3">
                                    <label>{{ __('Front Image') }}</label>
                                    <input type="file" name="colors_data[${colorId}][front_image]" class="form-control" 
                                           onchange="previewImage(this, 'front-preview-${colorId}')">
                                    <img id="front-preview-${colorId}" style="display:none; margin-top:10px; width:100px; height:100px; object-fit:cover;">
                                </div>

                                <!-- Back Image -->
                                <div class="col-md-3">
                                    <label>{{ __('Back Image') }}</label>
                                    <input type="file" name="colors_data[${colorId}][back_image]" class="form-control" 
                                           onchange="previewImage(this, 'back-preview-${colorId}')">
                                    <img id="back-preview-${colorId}" style="display:none; margin-top:10px; width:100px; height:100px; object-fit:cover;">
                                </div>
                                <div class="col-md-3">
                                <label>{{ __('Right Side Image') }}</label>
                                <input type="file" name="colors_data[${colorId}][right_side_image]" 
                                    class="form-control" onchange="previewImage(this, 'right_side_image-preview-${colorId}')">
                                <img id="right_side_image-preview-${colorId}" src="#" 
                                    style="display:none; margin-top:10px; width:100px; height:100px; object-fit:cover; border:1px solid #ddd; border-radius:8px;" />
                            </div>
                            <div class="col-md-3">
                                <label>{{ __('Left Side Image') }}</label>
                                <input type="file" name="colors_data[${colorId}][left_side_image]" 
                                    class="form-control" onchange="previewImage(this, 'left_side_image-preview-${colorId}')">
                                <img id="left_side_image-preview-${colorId}" src="#" 
                                    style="display:none; margin-top:10px; width:100px; height:100px; object-fit:cover; border:1px solid #ddd; border-radius:8px;" />
                            </div>

                                <!-- Price -->
                                <div class="col-md-3">
                                    <label>{{ __('Price') }}</label>
                                    <input type="number" name="colors_data[${colorId}][price]" class="form-control">
                                </div>
                            </div>

                            <!-- Sizes Container -->
                            <div class="sizes-container mt-3" id="sizes-container-${colorId}"></div>
                            <button type="button" class="btn btn-primary btn-sm add-size" data-color-id="${colorId}">
                                {{ __('Add Size') }}
                            </button>
                        </div>
                    `;

                            colorsContainer.append(colorField);
                        }
                    });
                }

                // إزالة الألوان التي لم يتم تحديدها
                $('.color-group').each(function() {
                    const colorId = $(this).attr('id').replace('color-', '');
                    if (!selectedColors.includes(colorId)) {
                        $(this).remove();
                    }
                });
            });
            $(document).on('click', '.remove-size', function() {
                $(this).closest('.size-group').remove();
            });

            // عرض الصور
            window.previewImage = function(input, previewId) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $(`#${previewId}`).attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            };


            // Preview image function
            window.previewImage = function(input, previewId) {
                const file = input.files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(previewId);
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(file);
            };
        });
        let selectedFiles = []; // لتتبع الملفات الجديدة
        let deletedImages = []; // لتتبع الصور المحذوفة

        function previewImages() {
            var previewContainer = document.getElementById('image-preview');
            var files = document.getElementById('images').files;

            // مسح المعاينات السابقة
            previewContainer.innerHTML = "";
            selectedFiles = Array.from(files); // حفظ الملفات المحددة

            selectedFiles.forEach((file, index) => {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var imageContainer = document.createElement('div');
                    imageContainer.style.position = "relative";
                    imageContainer.style.width = "100px";
                    imageContainer.style.height = "100px";
                    imageContainer.style.marginRight = "10px";

                    // إنشاء عنصر الصورة
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = "100%";
                    img.style.height = "100%";
                    img.style.objectFit = "cover";
                    img.style.borderRadius = "8px";

                    // إنشاء زر الحذف (X)
                    var deleteBtn = document.createElement('span');
                    deleteBtn.innerHTML = "&times;";
                    deleteBtn.style.position = "absolute";
                    deleteBtn.style.top = "5px";
                    deleteBtn.style.right = "5px";
                    deleteBtn.style.color = "white";
                    deleteBtn.style.backgroundColor = "red";
                    deleteBtn.style.borderRadius = "50%";
                    deleteBtn.style.cursor = "pointer";
                    deleteBtn.style.padding = "5px";
                    deleteBtn.onclick = function() {
                        removeImage(index); // إزالة الصورة من الملفات المحددة
                    };

                    imageContainer.appendChild(img);
                    imageContainer.appendChild(deleteBtn);
                    previewContainer.appendChild(imageContainer);
                };

                reader.readAsDataURL(file); // تحويل الملف إلى رابط بيانات للمعاينة
            });
        }

        function removeImage(index) {
            selectedFiles.splice(index, 1); // إزالة الملف من مصفوفة الملفات المحددة
            updateFileInput(); // تحديث حقل الإدخال
            previewImages(); // إعادة عرض المعاينات
        }

        function removeExistingImage(imageName, element) {
            if (confirm('Are you sure you want to remove this image?')) {
                // إزالة الصورة من العرض
                element.parentElement.remove(); // إزالة العنصر الحاوي للصورة

                // إضافة اسم الصورة إلى قائمة الصور المحذوفة
                deletedImages.push(imageName);
                document.getElementById('deleted_images').value = JSON.stringify(deletedImages);
            }
        }

        function updateFileInput() {
            var dataTransfer = new DataTransfer();

            selectedFiles.forEach(file => {
                dataTransfer.items.add(file); // إضافة الملفات المتبقية إلى الإدخال
            });

            document.getElementById('images').files = dataTransfer.files; // تحديث حقل الإدخال
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // إضافة حجم جديد
            $(document).on('click', '.add-size', function() {
                const colorId = $(this).data('color-id');
                const sizesContainer = $(`#sizes-container-${colorId}`);
                const sizeIndex = sizesContainer.find('.size-group').length;

                const sizeField = `
            <div class="size-group form-row">
                <div class="col-md-6">
                    <label>{{ __('Size') }}</label>
                    <select name="colors_data[${colorId}][sizes][${sizeIndex}][id]" class="form-control">
                        @foreach ($sizes as $availableSize)
                            <option value="{{ $availableSize->id }}">{{ $availableSize->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label>{{ __('Price') }}</label>
                    <input type="number" name="colors_data[${colorId}][sizes][${sizeIndex}][price]" 
                           class="form-control" value="">
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <button type="button" class="btn btn-danger remove-size">&times;</button>
                </div>
            </div>
        `;

                sizesContainer.append(sizeField);
            });

            // حذف حجم
            $(document).on('click', '.remove-size', function() {
                $(this).closest('.size-group').remove();
            });

            // عرض الصور المرفوعة
            window.previewImage = function(input, previewId) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#' + previewId).attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            };
        });
    </script>
@endsection

@endsection
