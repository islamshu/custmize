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
                            <li class="breadcrumb-item"><a href="{{ route('tshirt_index') }}">{{ __('T-shirts') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Add New T-shirt') }}</li>
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
                                <h4 class="card-title">{{ __('Add New T-shirt') }}</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    @include('dashboard.inc.alerts')
                                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Product Type -->
                                        <input type="hidden" name="product_type_id" value="1">


                                        <!-- Product Name -->
                                        <div class="form-group col-8">
                                            <label for="name">{{ __('Product Name') }}</label>
                                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="{{ __('Enter product name') }}" required>
                                        </div>

                                        <!-- Description -->
                                        <div class="form-group col-8">
                                            <label for="description">{{ __('Description') }}</label>
                                            <textarea id="description" name="description" class="form-control" rows="4" placeholder="{{ __('Enter product description') }}">{{ old('description') }}</textarea>
                                        </div>

                                        <!-- Fixed Price -->

                                        <!-- Price -->
                                        <div class="form-group col-8">
                                            <label for="price">{{ __('Price') }}</label>
                                            <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" step="0.01" placeholder="{{ __('Enter product price') }}" required>
                                        </div>

                                        <!-- Colors Section (for T-shirt) -->
                                        <div id="colors-section" class="form-group col-8 " style="border: 1px solid #ddd; padding: 15px;">
                                            <label>{{ __('Colors') }}</label>
                                            <select id="colors" name="colors[]" class="form-control select2" multiple>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}" {{ (collect(old('colors'))->contains($color->id)) ? 'selected' : '' }}>{{ $color->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="colors-container">
                                                <!-- This will be filled dynamically -->
                                                @if(old('colors'))
                                                    @foreach(old('colors') as $colorId)
                                                        <div class="color-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
                                                            <h5>{{ @$colors->where('id', $colorId)->first()->name }}</h5>
                                                            <div class="form-row">
                                                             
                                                                <div class="col-md-4">
                                                                    <label>{{ __('Front Image') }}</label>
                                                                    <input type="file" name="colors[{{ $colorId }}][front_image]" class="form-control" accept="image/*">
                                                                    @if(old("colors.$colorId.front_image"))
                                                                        <img src="{{ asset('storage/products/' . old("colors.$colorId.front_image")) }}" class="mt-2" style="max-width: 100px;">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>{{ __('Back Image') }}</label>
                                                                    <input type="file" name="colors[{{ $colorId }}][back_image]" class="form-control" accept="image/*">
                                                                    @if(old("colors.$colorId.back_image"))
                                                                        <img src="{{ asset('storage/products/' . old("colors.$colorId.back_image")) }}" class="mt-2" style="max-width: 100px;">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Sizes Section (for T-shirt) -->
                                        <div id="sizes-section" class="form-group col-8 " style="border: 1px solid #ddd; padding: 15px;">
                                            <label>{{ __('Sizes') }}</label>
                                            <select id="sizes" name="sizes[]" class="form-control select2" multiple>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}" {{ (collect(old('sizes'))->contains($size->id)) ? 'selected' : '' }}>{{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="sizes-container">
                                                <!-- This will be filled dynamically if needed -->
                                            </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        // تفعيل select2
        $('.select2').select2();

        const productTypeSelect = 1;
        const colorsSection = document.getElementById('colors-section');
        const sizesSection = document.getElementById('sizes-section');
        const penFields = document.getElementById('pen-fields');

        // Function to check if old input is available and display correct fields
        function displayOldData() {
            colorsSection.classList.remove('d-none');
            sizesSection.classList.remove('d-none');
        }

        // Initialize the old data display
        displayOldData();

      

        // Handle Colors selection
        $('#colors').on('change', function() {
            const selectedColors = $(this).val();
            const colorsContainer = document.getElementById('colors-container');
            colorsContainer.innerHTML = ''; // Clear previous fields

            if (selectedColors.length > 0) {
                selectedColors.forEach(function(colorId) {
                    const colorName = document.querySelector(`#colors option[value="${colorId}"]`).text;
                    const selectedType = productTypeSelect.value;

                    let colorFields = '';

                    colorFields = `
                            <div class="color-group mb-3" style="border: 1px solid #ccc; padding: 15px;">
                                <h5>${colorName}</h5>
                                <div class="form-row">
                                    <input type="hidden" name="colors[${colorId}][id]" value="${colorId}" class="form-control">

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
