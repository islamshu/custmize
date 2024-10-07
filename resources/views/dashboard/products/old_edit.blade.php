@extends('layouts.master')

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
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('Products') }}</a></li>
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
                                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT') <!-- Add the PUT method for updating -->

                                        <!-- Product Type -->
                                        <div class="form-group col-8 ">
                                            <label for="product_type_id">{{ __('Product Type') }}</label>
                                            <select id="product_type_id" name="product_type_id" class="form-control" required>
                                                <option value="">{{ __('Select Product Type') }}</option>
                                                @foreach ($productTypes as $type)
                                                    <option value="{{ $type->id }}" {{ $product->product_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Product Name -->
                                        <div class="form-group col-8">
                                            <label for="name">{{ __('Product Name') }}</label>
                                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" placeholder="{{ __('Enter product name') }}" required>
                                        </div>

                                        <!-- Description -->
                                        <div class="form-group col-8">
                                            <label for="description">{{ __('Description') }}</label>
                                            <textarea id="description" name="description" class="form-control" rows="4" placeholder="{{ __('Enter product description') }}">{{ old('description', $product->description) }}</textarea>
                                        </div>

                                        <!-- Fixed Price -->
                                        

                                        <!-- Price -->
                                        <div class="form-group col-8">
                                            <label for="price">{{ __('Price') }}</label>
                                            <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $product->price) }}" step="0.01" placeholder="{{ __('Enter product price') }}" required>
                                        </div>

                                        <!-- Colors Section (for T-shirt) -->
                                        <div id="colors-section" class="form-group col-8 {{ $product->product_type_id == 1 ? '' : 'd-none' }}" style="border: 1px solid #ddd; padding: 15px;">
                                            <label>{{ __('Colors') }}</label>
                                            <select id="colors" name="colors[]" class="form-control select2" multiple>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}" {{ in_array($color->id, $product->colors->pluck('color_id')->toArray()) ? 'selected' : '' }}>{{ $color->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="colors-container">
                                                <!-- Dynamically display the selected colors and images -->
                                                @foreach ($product->colors as $productColor)
                                                    <div class="color-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
                                                        <h5>{{ $productColor->color->name }}</h5>
                                                        <div class="form-row">
                                                            <div class="col-md-4">
                                                                <label>{{ __('Front Image') }}</label>
                                                                <input type="file" name="colors[{{ $productColor->color_id }}][front_image]" class="form-control" accept="image/*">
                                                                @if($productColor->front_image)
                                                                    <img src="{{ asset('uploads/' . $productColor->front_image) }}" class="mt-2" style="max-width: 100px;">
                                                                @endif
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label>{{ __('Back Image') }}</label>
                                                                <input type="file" name="colors[{{ $productColor->color_id }}][back_image]" class="form-control" accept="image/*">
                                                                @if($productColor->back_image)
                                                                    <img src="{{ asset('uploads/' . $productColor->back_image) }}" class="mt-2" style="max-width: 100px;">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Sizes Section (for T-shirt) -->
                                        <div id="sizes-section" class="form-group col-8 {{ $product->product_type_id == 1 ? '' : 'd-none' }}" style="border: 1px solid #ddd; padding: 15px;">
                                            <label>{{ __('Sizes') }}</label>
                                            @php
                                                $array_size = [];
                                            @endphp
                                            @foreach ($product->sizes as $item)
                                                @php
                                                    array_push($array_size, $item->size_id)
                                                @endphp
                                            @endforeach
                                            <select id="sizes" name="sizes[]" class="form-control select2" multiple>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}" {{ in_array($size->id,$array_size) ? 'selected' : '' }}>{{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Pen Specific Fields (for Pen) -->
                                        <div id="pen-fields" class="form-group col-8 {{ $product->product_type_id == 2 ? '' : 'd-none' }}" style="border: 1px solid #ddd; padding: 15px;">
                                            <!-- Pen Image -->
                                            <div class="form-group col-8">
                                                <label for="pen_image">{{ __('Pen Image') }}</label>
                                                <input type="file" id="pen_image" name="pen_image" class="form-control">
                                                @if($product->pen->pen_image)
                                                    <img src="{{ asset('uploads/' . $product->pen->pen_image) }}" class="mt-2" style="max-width: 100px;">
                                                @endif
                                            </div>

                                            <!-- Pen Type -->
                                            <div class="form-group col-8">
                                                <label for="pen_type">{{ __('Pen Type') }}</label>
                                                <select id="pen_type" name="pen_type" class="form-control">
                                                    <option value="plastic" {{ old('pen_type', $product->pen->type) == 'plastic' ? 'selected' : '' }}>{{ __('Plastic') }}</option>
                                                    <option value="stainless" {{ old('pen_type', $product->pen->type) == 'stainless' ? 'selected' : '' }}>{{ __('Stainless') }}</option>
                                                </select>
                                            </div>

                                            <!-- Ink Color -->
                                            <div class="form-group col-8">
                                                <label for="ink_color">{{ __('Ink Color') }}</label>
                                                <input type="color" id="ink_color" name="ink_color" class="form-control" value="{{ old('ink_color', $product->pen->ink_color) }}" placeholder="{{ __('Enter ink color') }}">
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-success">{{ __('Update Product') }}</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const productTypeSelect = document.getElementById('product_type_id');
        const colorsSection = document.getElementById('colors-section');
        const sizesSection = document.getElementById('sizes-section');
        const penFields = document.getElementById('pen-fields');

        // Handle Product Type selection
        productTypeSelect.addEventListener('change', function() {
            const selectedType = productTypeSelect.value;

            if (selectedType === '1') {
                colorsSection.classList.remove('d-none');
                sizesSection.classList.remove('d-none');
                penFields.classList.add('d-none');
            } else if (selectedType === '2') {
                colorsSection.classList.add('d-none');
                sizesSection.classList.add('d-none');
                penFields.classList.remove('d-none');
            } else {
                // Hide all sections if no product type is selected
                colorsSection.classList.add('d-none');
                sizesSection.classList.add('d-none');
                penFields.classList.add('d-none');
            }
        });
        document.getElementById('colors').addEventListener('change', function() {
            const selectedColors = Array.from(this.selectedOptions).map(option => option.value);
            const colorsContainer = document.getElementById('colors-container');
            colorsContainer.innerHTML = ''; // Clear previous fields

            selectedColors.forEach(function(colorId) {
                const colorName = document.querySelector(`#colors option[value="${colorId}"]`).text;
                const colorFields = `
                    <div class="color-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
                        <h5>${colorName}</h5>
                        <div class="form-row">
                                                            <input type="hidden" name="colors[${colorId}][id]" value="${colorId}" class="form-control" ">

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
                colorsContainer.insertAdjacentHTML('beforeend', colorFields);
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
