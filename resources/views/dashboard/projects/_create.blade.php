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
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('Products') }}</a></li>
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
                                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Product Type -->
                                        <div class="form-group">
                                            <label for="product_type_id">{{ __('Product Type') }}</label>
                                            <select id="product_type_id" name="product_type_id" class="form-control select2" required>
                                                <option value="">{{ __('Select Product Type') }}</option>
                                                @foreach ($productTypes as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Product Name -->
                                        <div class="form-group">
                                            <label for="name">{{ __('Product Name') }}</label>
                                            <input type="text" id="name" name="name" class="form-control" placeholder="{{ __('Enter product name') }}" required>
                                        </div>

                                        <!-- Description -->
                                        <div class="form-group">
                                            <label for="description">{{ __('Description') }}</label>
                                            <textarea id="description" name="description" class="form-control" rows="4" placeholder="{{ __('Enter product description') }}"></textarea>
                                        </div>

                                        <!-- Fixed Price -->
                                        <div class="form-group">
                                            <label for="fixed_price">{{ __('Fixed Price') }}</label>
                                            <input type="number" id="fixed_price" name="fixed_price" class="form-control" step="0.01" placeholder="{{ __('Enter fixed price') }}" required>
                                        </div>

                                        <!-- Price -->
                                        <div class="form-group">
                                            <label for="price">{{ __('Price') }}</label>
                                            <input type="number" id="price" name="price" class="form-control" step="0.01" placeholder="{{ __('Enter product price') }}" required>
                                        </div>

                                        <!-- Colors Section (for T-shirt) -->
                                        <div id="colors-section" class="form-group d-none" style="border: 1px solid #ddd; padding: 15px;">
                                            <label>{{ __('Colors') }}</label>
                                            <select id="colors" name="colors[]" class="form-control select2" multiple>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="colors-container">
                                                <!-- This will be filled dynamically -->
                                            </div>
                                        </div>

                                        <!-- Sizes Section (for T-shirt) -->
                                        <div id="sizes-section" class="form-group d-none" style="border: 1px solid #ddd; padding: 15px;">
                                            <label>{{ __('Sizes') }}</label>
                                            <select id="sizes" name="sizes[]" class="form-control select2" multiple>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="sizes-container">
                                                <!-- This will be filled dynamically -->
                                            </div>
                                        </div>

                                        <!-- Pen Specific Fields (for Pen) -->
                                        <div id="pen-fields" class="form-group d-none" style="border: 1px solid #ddd; padding: 15px;">
                                            <!-- Pen Image -->
                                            <div class="form-group">
                                                <label for="pen_image">{{ __('Pen Image') }}</label>
                                                <input type="file" id="pen_image" name="pen_image" class="form-control">
                                            </div>

                                            <!-- Pen Type -->
                                            <div class="form-group">
                                                <label for="pen_type">{{ __('Pen Type') }}</label>
                                                <select id="pen_type" name="pen_type" class="form-control select2">
                                                    <option value="plastic">{{ __('Plastic') }}</option>
                                                    <option value="stainless">{{ __('Stainless') }}</option>
                                                </select>
                                            </div>

                                            <!-- Ink Color -->
                                            <div class="form-group">
                                                <label for="ink_color">{{ __('Ink Color') }}</label>
                                                <input type="text" id="ink_color" name="ink_color" class="form-control" placeholder="{{ __('Enter ink color') }}">
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-success">{{ __('Save Product') }}</button>
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
        // Initialize select2 for all selects
        $('.select2').select2();

        const productTypeSelect = $('#product_type_id');
        const colorsSection = $('#colors-section');
        const sizesSection = $('#sizes-section');
        const penFields = $('#pen-fields');

        // Handle Product Type selection
        productTypeSelect.on('change', function() {
            const selectedType = $(this).val();
            
            // If T-shirt selected, show colors and sizes
            if (selectedType === '1') {
                colorsSection.removeClass('d-none');
                sizesSection.removeClass('d-none');
                penFields.addClass('d-none');
            }
            // If Pen selected, show pen fields
            else if (selectedType === '2') {
                colorsSection.addClass('d-none');
                sizesSection.addClass('d-none');
                penFields.removeClass('d-none');
            } else {
                // Hide all sections if no product type is selected
                colorsSection.addClass('d-none');
                sizesSection.addClass('d-none');
                penFields.addClass('d-none');
            }
        });

        // Handle Colors selection
        $('#colors').on('change', function() {
            const selectedColors = $(this).val();
            const colorsContainer = $('#colors-container');
            colorsContainer.empty(); // Clear previous fields

            selectedColors.forEach(function(colorId) {
                const colorName = $('#colors option[value="' + colorId + '"]').text();
                const colorFields = `
                    <div class="color-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
                        <h5>${colorName}</h5>
                        <div class="form-row">
                            <div class="col-md-4">
                                <label>{{ __('Front Image') }}</label>
                                <input type="file" name="colors[${colorId}][front_image]" class="form-control" accept="image/*" onchange="previewImage(this, 'front-preview-${colorId}')">
                                <img id="front-preview-${colorId}" class="mt-2" style="max-width: 100px; display: none;">
                            </div>
                            <div class="col-md-4">
                                <label>{{ __('Back Image') }}</label>
                                <input type="file" name="colors[${colorId}][back_image]" class="form-control" accept="image/*" onchange="previewImage(this, 'back-preview-${colorId}')">
                                <img id="back-preview-${colorId}" class="mt-2" style="max-width: 100px; display: none;">
                            </div>
                        </div>
                    </div>`;
                colorsContainer.append(colorFields);
            });
        });

        // Handle Sizes selection
        $('#sizes').on('change', function() {
            const selectedSizes = $(this).val();
            const sizesContainer = $('#sizes-container');
            sizesContainer.empty(); // Clear previous fields

            selectedSizes.forEach(function(sizeId) {
                const sizeName = $('#sizes option[value="' + sizeId + '"]').text();
                const sizeFields = `
                    <div class="size-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
                        <h5>${sizeName}</h5>
                    </div>`;
                sizesContainer.append(sizeFields);
            });
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