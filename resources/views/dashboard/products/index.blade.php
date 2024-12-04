<!-- في ملف: resources/views/products/index.blade.php -->

@extends('layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ $title }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a>
                            </li>

                            <li class="breadcrumb-item active">{{ $title }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <!-- DOM - jQuery events table -->

            <!-- Row created callback -->
            <!-- File export table -->
            <section id="file-export">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header row">
                              <div class="col-md-">
                                <h4 class="card-title">{{ $title }}</h4>

                              </div>
                              
                            
                                  
                                  
                           
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">{{ __('Add New') }}</a>

                                </div>
                                <div class="col-md-3">

                                </div>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    @include('dashboard.inc.alerts')
                                   

                                    <table class="table table-striped table-bordered file-export">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('3D model') }}</th>

                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Price') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $key => $product)
                                                
                                            <tr>
                                                <td>{{ $key +1 }}</td>
                                                <td>
                                                    <a href="{{$product->image}}" target="_blank" class="btn btn-info">{{__('Click to dawanlod')}}</a>
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category->name }} / {{ $product->subcategory->name }} </td>
                                                <td>{{ $product->price }}</td>
                                                <td>
                                                    {{-- <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a> --}}
                                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">{{ __('Edit Product') }}</a>
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete Product') }}</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Image') }}</th>

                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Price') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- File export table -->
        </div>
    </div>
</div>
@endsection
