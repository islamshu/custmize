@extends('layouts.master')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('Add New Product') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('Products') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Add New') }}</li>
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
                                    <h4 class="card-title">{{ __('Add New Product') }}</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @include('dashboard.inc.alerts')
                                        <form action="{{ route('products.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <!-- Product Type -->

                                            <div class="form-group col-8 ">
                                                <label for="product_type_id">{{ __('Category') }}</label>
                                                <select id="category_id" name="category_id" class="form-control" required>
                                                    <option value="">{{ __('choose') }} {{ __('Category') }}
                                                    </option>
                                                    @foreach ($categories as $cats)
                                                        <option value="{{ $cats->id }}"
                                                            {{ old('category_id') == $cats->id ? 'selected' : '' }}>
                                                            {{ $cats->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-8 ">
                                                <label for="product_type_id">{{ __('Sub Categories') }}</label>
                                                <select id="subcategory_id" name="subcategory_id" class="form-control"
                                                    required>
                                                    <option value="" selected disabled>{{ __('choose') }}
                                                        {{ __('Sub Categories') }}
                                                    </option>

                                                </select>
                                            </div>

                                            <!-- Product Name -->
                                            <div class="form-group col-8">
                                                <label for="name">{{ __('Product Name') }}</label>
                                                <input type="text" id="name" name="name" class="form-control"
                                                    value="{{ old('name') }}"
                                                    placeholder="{{ __('Enter product name') }}" required>
                                            </div>

                                            <div class="form-group col-8">
                                                <label for="name">{{ __('Image') }}</label>
                                                <input type="file" id="image" name="image"
                                                    class="form-control image" required>
                                                <img src="" width="100" height="100" class="image-preview"
                                                    alt="">
                                            </div>
                                            <!-- Description -->
                                            <div class="form-group col-8">
                                                <label for="description">{{ __('Description') }}</label>
                                                <textarea id="description" name="description" class="form-control" rows="4"
                                                    placeholder="{{ __('Enter product description') }}">{{ old('description') }}</textarea>
                                            </div>
                                            <input type="hidden" id="color_type" value="0">

                                            <!-- Fixed Price -->

                                            <!-- Price -->
                                            <div class="form-group col-8">
                                                <label for="price">{{ __('Price') }}</label>
                                                <input type="number" id="price" name="price" class="form-control"
                                                    value="{{ old('price') }}" step="0.01"
                                                    placeholder="{{ __('Enter product price') }}" required>
                                            </div>

                                            <!-- Colors Section (for T-shirt) -->
                                            <div id="colors-section" class="form-group col-8 d-none"
                                                style="border: 1px solid #ddd; padding: 15px;">
                                                <label>{{ __('Colors') }}</label>
                                                <select id="colors" name="colors[]" class="form-control select2"
                                                    multiple>
                                                    @foreach ($colors as $color)
                                                        <option value="{{ $color->id }}"
                                                            {{ collect(old('colors'))->contains($color->id) ? 'selected' : '' }}>
                                                            {{ $color->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="colors-container">

                                                </div>
                                            </div>


                                            <!-- Sizes Section (for T-shirt) -->
                                            <div id="sizes-section" class="form-group col-8 d-none"
                                                style="border: 1px solid #ddd; padding: 15px;">
                                                <label>{{ __('Sizes') }}</label>
                                                <select id="sizes" name="sizes[]" class="form-control select2" multiple>
                                                    @foreach ($sizes as $size)
                                                        <option value="{{ $size->id }}"
                                                            {{ collect(old('sizes'))->contains($size->id) ? 'selected' : '' }}>
                                                            {{ $size->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="sizes-container">
                                                    <!-- This will be filled dynamically if needed -->
                                                </div>
                                            </div>
                                            <div class="form-group col-8 d-none type_product">
                                                <label for="pen_type">{{ __('Type') }}</label>
                                                <select id="type_product" name="type_product" class="form-control">
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
                $('#subcategory_id').empty();
                $('#subcategory_id').append(
                    '<option value="">{{ __('choose') }} {{ __('Sub Categories') }} </option>');
                if (categoryId) {
                    $.ajax({
                        url: '{{ route('get.subcategories', ':category_id') }}'.replace(
                            ':category_id', categoryId),
                        type: "GET",
                        dataType: "json",
                        success: function(data) {



                            $.each(data, function(key, value) {
                                $('#subcategory_id').append('<option  value="' + value
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
                            const subcategorytype = data.subcategorries.attributs;
                            if (subcategorytype.includes('types')) {
                                $('.type_product').removeClass('d-none');
                            } else {
                                $('.type_product').addClass('d-none');

                            }

                            const types = data.types;

                            // Handle types
                            if (types.length > 0) {
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
            let colorsData = {}; // لتخزين بيانات الألوان

            // Handle Colors selection
            $('#colors').on('change', function() {
                const selectedColors = $(this).val();
                const colorsContainer = document.getElementById('colors-container');
                colorsContainer.innerHTML = ''; // Clear previous fields

                if (selectedColors.length > 0) {
                    selectedColors.forEach(function(colorId) {
                        const colorName = document.querySelector(
                            `#colors option[value="${colorId}"]`).text;
                        let colortype = $('#color_type').val();

                        // Use existing data if available
                        const colorData = colorsData[colorId] || {
                            front_image: '',
                            back_image: '',
                            price: ''
                        };

                        let colorFields = '';
                        if (colortype == 2) {
                            colorFields = `
                <div class="color-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
                    <h5>${colorName}</h5>
                    <div class="form-row">
                        <input type="hidden" name="colors[${colorId}][id]" value="${colorId}" class="form-control">

                        <div class="col-md-4">
                            <label>{{ __('Front Image') }}</label>
                            <input type="file" name="colors[${colorId}][front_image]" class="form-control" accept="image/*" onchange="previewImage(this, 'front-preview-${colorId}')">
                            <img id="front-preview-${colorId}" src="${colorData.front_image}" class="mt-2" style="max-width: 100px; display: ${colorData.front_image ? 'block' : 'none'};">
                        </div>
                        <div class="col-md-4">
                            <label>{{ __('Back Image') }}</label>
                            <input type="file" name="colors[${colorId}][back_image]" class="form-control" accept="image/*" onchange="previewImage(this, 'back-preview-${colorId}')">
                            <img id="back-preview-${colorId}" src="${colorData.back_image}" class="mt-2" style="max-width: 100px; display: ${colorData.back_image ? 'block' : 'none'};">
                        </div>
                        <div class="col-md-4">
                            <label>{{ __('Price') }}</label>
                            <input type="number" name="colors[${colorId}][price]" class="form-control" value="${colorData.price}">
                        </div>
                    </div>
                </div>`;
                        } else if (colortype == 1) {
                            colorFields = `
                <div class="color-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
                    <h5>${colorName}</h5>
                    <div class="form-row">
                        <input type="hidden" name="colors[${colorId}][id]" value="${colorId}" class="form-control">

                        <div class="col-md-6">
                            <label>{{ __('Image') }}</label>
                            <input type="file" name="colors[${colorId}][front_image]" class="form-control" accept="image/*" onchange="previewImage(this, 'front-preview-${colorId}')">
                            <img id="front-preview-${colorId}" src="${colorData.front_image}" class="mt-2" style="max-width: 100px; display: ${colorData.front_image ? 'block' : 'none'};">
                        </div>
                        <div class="col-md-6">
                            <label>{{ __('Price') }}</label>
                            <input type="number" name="colors[${colorId}][price]" class="form-control" value="${colorData.price}">
                        </div>
                    </div>
                </div>`;
                        }

                        colorsContainer.insertAdjacentHTML('beforeend', colorFields);
                    });
                }
            });
            $('#colors-container').on('change', 'input', function() {
                const colorId = $(this).closest('.color-group').find('input[name^="colors"]').val();
                const field = $(this).attr('name').split('[')[2].replace(']',
                    ''); // Extract field name (front_image, back_image, price)

                if (field === 'front_image' || field === 'back_image') {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        colorsData[colorId] = colorsData[colorId] || {};
                        colorsData[colorId][field] = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    colorsData[colorId] = colorsData[colorId] || {};
                    colorsData[colorId][field] = $(this).val();
                }
            });

            $('#sizes').on('change', function() {
                const selectedsizes = $(this).val();
                const SizeContainer = document.getElementById('sizes-container');
                SizeContainer.innerHTML = ''; // Clear previous fields

                if (selectedsizes.length > 0) {
                    selectedsizes.forEach(function(sizeId) {
                        const sizeName = document.querySelector(
                            `#sizes option[value="${sizeId}"]`).text;

                        let colorFields = '';
                        colorFields = `
                        <div class="size-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
                            <div class="form-row">
                                <input type="hidden" name="colors[${sizeId}][id]" value="${sizeId}" class="form-control">

                                <div class="col-md-6">
                                <label>{{ __('Size') }}</label>
                                    <input type="text" disable readonly class="form-control" name="sizes[${sizeId}][name]" value="${sizeName}" >
                                </div>
                                <div class="col-md-6">
                                    <label>{{ __('Price') }}</label>
                                    <input type="number" name="sizes[${sizeId}][price]" class="form-control" ">
                                </div>
                                
                            </div>
                        </div>`;


                        SizeContainer.insertAdjacentHTML('beforeend', colorFields);
                    });
                }
            });


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
    </script>
@endsection



@endsection
