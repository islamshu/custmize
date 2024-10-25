@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('Edit Subcategory') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('subcategories.index') }}">{{ __('Sub Categories') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Edit Subcategory') }}</li>
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
                                <h4 class="card-title">{{ __('Edit Subcategory') }}</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body col-md-6">
                                    @include('dashboard.inc.alerts')
                                    <form action="{{ route('subcategories.update',$sub->id) }}" method="POST" id="categoryForm" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <label for="categoryName">{{ __('Name') }}</label>
                                            <input type="text" name="name" value="{{ $sub->name }}" class="form-control" id="categoryName" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="categoryName_ar">{{ __('Name in arabic') }}</label>
                                            <input type="text" name="name_ar" value="{{ $sub->name_ar }}" class="form-control" id="categoryName_ar" required>
                                        </div>
                                        
                                
                                        <div class="form-group " >
                                            <label for="parentCategory">{{ __('Category') }}</label>
                                            <select name="category_id" class="form-control" id="parentCategory">
                                                <option value="">-- {{ __('Select Category') }} --</option>
                                                @foreach ($subs as $category)
                                                    <option value="{{ $category->id }}" @if($sub->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group " >
                                            <label for="parentCategory">{{ __('Product Attributes') }}</label>
                                            @php
                                                $arr = json_decode($sub->attributs);
                                            @endphp
                                            <select name="attriputs[]" multiple class="form-control select2"  id="types">
                                                <option value="">{{ __('choose') }}</option>
                                                    <option value="sizes" @if(in_array('sizes',$arr)) selected @endif>{{ __('Sizes') }}</option>
                                                    <option value="colors1"@if(in_array('colors1',$arr)) selected @endif>{{ __('Colors with front image') }}</option>
                                                    <option value="colors2"@if(in_array('colors2',$arr)) selected @endif>{{ __('Colors with front and back image') }}</option>
                                                    <option value="types"@if(in_array('types',$arr)) selected @endif>{{ __('Types') }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group @if(!in_array('types',$arr))  d-none @endif test " >
                                            <label for="parentCategory">{{ __('Types') }}</label>
                                            <input type="hidden" name="have_types" value="{{ $sub->have_types }}" id="have_types">
                                            <input type="hidden" name="have_one_image" value="{{ $sub->have_one_image }}" id="have_one_image">
                                            <input type="hidden" name="have_two_image" value="{{ $sub->have_two_image }}" id="have_two_image">
                                            @php
                                                $tt = $sub->types()->get(['type_id'])->toArray();
                                                $are = [];
                                                foreach ($tt as $key => $value) {
                                                    array_push($are,$value['type_id']);
                                                }
                                            @endphp
                                            <select name="types[]" multiple class="form-control select2"  id="">
                                                <option value="" disabled>{{ __('choose') }}</option>
                                                @foreach ($types as $item)
                                                    <option value="{{ $item->id }}" @if(in_array($item->id,$are)) selected @endif>{{ $item->name }}</option>
                                                @endforeach
                                                    
                                            </select>
                                        </div>

                                
                                        <!-- Image Upload Field -->
                                        <div class="form-group">
                                            <label for="categoryImage"> {{ __('Image') }}</label>
                                            <input type="file" name="image" class="form-control image" id="categoryImage">
                                        
                                        <div>
                                            <img src="{{ asset('uploads/'.$sub->image) }}" class="image-preview" alt="" width="130">

                                            
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