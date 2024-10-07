@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('Add New') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('subcategories.index') }}">{{ __('Sub Categories') }}</a></li>
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
                                <h4 class="card-title">{{ __('Add New') }}</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body col-md-6">
                                    @include('dashboard.inc.alerts')
                                    <form action="{{ route('subcategories.store') }}" method="POST" id="categoryForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="categoryName">{{ __('Name') }}</label>
                                            <input type="text" name="name" class="form-control" id="categoryName" required>
                                        </div>
                                
                                        <div class="form-group " >
                                            <label for="parentCategory">{{ __('Category') }}</label>
                                            <select name="category_id" required class="form-control" id="parentCategory">
                                                <option value="">-- {{ __('Select Category') }} --</option>
                                                @foreach ($subs as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group " >
                                            <label for="parentCategory">{{ __('Product Attributes') }}</label>
                                            <select name="attriputs[]" multiple class="form-control select2"  id="types">
                                                <option value="">{{ __('choose') }}</option>
                                                    <option value="sizes">{{ __('Sizes') }}</option>
                                                    <option value="colors1">{{ __('Colors with front image') }}</option>
                                                    <option value="colors2">{{ __('Colors with front and back image') }}</option>

                                                    <option value="types">{{ __('Types') }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group d-none test " >
                                            <label for="parentCategory">{{ __('Types') }}</label>
                                            <input type="hidden" name="have_types" value="0" id="have_types">
                                            <input type="hidden" name="have_one_image" value="0" id="have_one_image">
                                            <input type="hidden" name="have_two_image" value="0" id="have_two_image">

                                            <select name="types[]" multiple class="form-control select2"  id="">
                                                <option value="" disabled>{{ __('choose') }}</option>
                                                @foreach ($types as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                                    
                                            </select>
                                        </div>

                                
                                        <!-- Image Upload Field -->
                                        <div class="form-group">
                                            <label for="categoryImage"> {{ __('Image') }}</label>
                                            <input type="file" required name="image" class="form-control image" id="categoryImage">
                                        
                                        <div>
                                            <img src="" class="image-preview" alt="" width="130">

                                            
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
$(document).ready(function() {
    $('.select2').select2();

    // Event listener for dynamically changing options
    $('#types').on('change', function() {
        let selectedValue = $(this).val();
        const hasColors1 = selectedValue && selectedValue.includes('colors1');
        const hasColors2 = selectedValue && selectedValue.includes('colors2');
        $('#have_one_image').val(0);
        $('#have_two_image').val(0);


        if (hasColors1 && hasColors2) {
            // إذا تم اختيار كلا الخيارين، قم بإلغاء اختيار colors2
            const newValues = selectedValue.filter(value => value !== 'colors2');
            $(this).val(newValues).trigger('change');
            alert("يمكنك اختيار إما 'الألوان 1' أو 'الألوان 2' فقط!");
        }
        
        if (selectedValue && selectedValue.includes('types')) {
            $('#have_types').val(1);
            $('.test').removeClass('d-none'); // Use removeClass instead of classList
        }else{
            $('#have_types').val(0);
            $('.test').addClass('d-none'); // Add d-none class to hide
        }
        if (hasColors1) {
            $('#have_one_image').val(1);
            $('#have_two_image').val(0);

        } 
        if (hasColors2) {
            $('#have_two_image').val(1);
            $('#have_one_image').val(0);

        }
    
    });
});
</script>
@endsection