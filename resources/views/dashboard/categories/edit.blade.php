@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('Edit Main Category') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">{{ __('Categories') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Edit Main Category') }}</li>
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
                                <h4 class="card-title">{{ __('Edit Main Category') }}</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body col-md-6">
                                    @include('dashboard.inc.alerts')
                                    <form action="{{ route('categories.update',$category->id) }}" method="POST" id="categoryForm" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <label for="categoryName">{{ __('Name') }}</label>
                                            <input type="text" name="name" class="form-control" value="{{ $category->name }}" id="categoryName" required>
                                        </div>
                                
                                        <div class="form-group @if($category->parent_id == null) d-none  @endif" >
                                            <label for="parentCategory">{{ __('Parent Category (Optional)') }}</label>
                                            <select name="parent_id" class="form-control" id="parentCategory" @if($category->parent_id != null) required  @endif>
                                                <option value="">-- {{ __('Select Parent Category') }} --</option>
                                                @foreach ($categories as $cats)
                                                    <option value="{{ $cats->id }}" @if($category->parent_id == $cats->id) selected @endif>{{ $cats->name }}</option>
                                                    {{-- @if($category->children)
                                                        @foreach($category->children as $child)
                                                            <option value="{{ $child->id }}">-- {{ $child->name }}</option>
                                                        @endforeach
                                                    @endif --}}
                                                @endforeach
                                            </select>
                                        </div>
                                
                                        <!-- Image Upload Field -->
                                        <div class="form-group">
                                            <label for="categoryImage"> {{ __('Image') }}</label>
                                            <input type="file" name="image" class="form-control image" id="categoryImage">
                                        
                                        <div>
                                            <img src="{{ asset('uploads/'.$category->image) }}" class="image-preview" alt="" width="130">

                                            
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
    // Event listener for dynamically changing options
    $('#parentCategory').on('change', function() {
        let selectedValue = $(this).val();
        if (selectedValue) {
            console.log("Selected Parent ID: " + selectedValue);
        }
    });
});
</script>
@endsection