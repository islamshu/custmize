@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('Add New Category') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">{{ __('Categories') }}</a></li>
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
                                <h4 class="card-title">{{ __('Add New Category') }}</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body col-md-6">
                                    @include('dashboard.inc.alerts')
                                    <form action="{{ route('categories.store') }}" method="POST" id="categoryForm" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="categoryName">{{ __('Name') }}</label>
                                            <input type="text" name="name" class="form-control" id="categoryName" required>
                                        </div>
                                
                                        <div class="form-group " >
                                            <label for="parentCategory">{{ __('Parent Category (Optional)') }}</label>
                                            <select name="parent_id" class="form-control" id="parentCategory">
                                                <option value="">-- {{ __('Select Parent Category') }} --</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    
                                                @endforeach
                                            </select>
                                        </div>
                                
                                        <!-- Image Upload Field -->
                                        <div class="form-group">
                                            <label for="categoryImage"> {{ __('Image') }}</label>
                                            <input type="file" name="image" class="form-control image" id="categoryImage">
                                        
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