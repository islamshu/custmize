@extends('layouts.master')
@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" id="basic-layout-colored-form-control"> {{ __('Add New') }}   </h4>
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
                        <div class="card-content collapse show">
                            <div class="card-body">
                                @include('dashboard.inc.alerts')

                                <form class="form" method="post"
                                    action="{{ route('discountcode.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-body">
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>{{ __('Name') }}  </label>
                                                <input type="string" name="title" class="form-control" required >
                                            </div>
                                        
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label> {{ __('Start at') }}   </label>
                                                <input type="date" name="start_at" class="form-control" required >
                                            </div>
                                            <div class="col-md-6">
                                                <label> {{ __('End at') }}  </label>
                                                <input type="date" name="end_at" class="form-control" required >
                                            </div>                                           
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label> {{ __('Discount Type') }}   </label>
                                                <select name="discount_type" class="form-control" required id="">
                                                    <option value="" selected disabled>{{ __('choose') }}  </option>
                                                    <option value="rate">{{ __('Rate') }}</option>
                                                    <option value="fixed">{{ __('Fixed') }}</option>

                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label> {{ __('Discount Value') }} </label>
                                                <input type="number" name="discount_value" class="form-control" required >
                                            </div>
                                            
                                        </div>
                                        <br>
                                        
                                        <br>
                                      
                                       
                                        <br>
                                        
                                       
                                    </div>
                                   
    
    
                                    <div class="form-actions left">

                                        <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> {{ __('Save') }}
                                    </button>
                                        </button>
                                    </div>
    
    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>
    </div>
    </section>

    </div>
@endsection
