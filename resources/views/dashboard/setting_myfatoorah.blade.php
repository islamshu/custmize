@extends('layouts.master')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('Shopping setting') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a>
                                </li>

                                
                                <li class="breadcrumb-item active">{{ __('MYFATOORAH setting') }}
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
                <section id="validation">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collpase show">
                                    <div class="card-body">
                                           
                                        <form class="form" action="{{ route('add_general') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                              
                                                <div class="row">
                                                  
                                                </div>
                                                <div class="row">
                                                    
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput2">{{ __('API KEY') }}</label>
                                                            <textarea name="general[my_fattora_key]" class="form-control" required id="" cols="30" rows="10">{{get_general_value('my_fattora_key')}}</textarea>
                                                        <div class="invalid-feedback">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput2">{{ __('API URL') }}</label>
                                                        <input type="text" value="{{get_general_value('my_fattora_url')}}" 
                                                            required class="form-control border-primary"
                                                             name="general[my_fattora_url]">
                                                        <div class="invalid-feedback">
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                           


                                            <div class="form-actions right">
                                              
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> {{ __('Save') }}
                                                </button>
                                            </div>
                                        </form>
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
@section('script')

@endsection
