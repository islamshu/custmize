@extends('layouts.master')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('Employees') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a>
                                </li>

                                <li class="breadcrumb-item active">{{ __('Employees') }}
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
                                    <h4 class="card-title">{{ __('Employees') }}</h4>

                                  </div>
                                  
                                    <div class="col-md-" style="margin-right:2%">
                                      <button type="button" class="btn btn-dark  " data-toggle="modal"
                                          data-target="#bootstrap">
                                          {{ __('Fast Add') }}
                                      </button>
                                      <a href="{{ route('employees.create') }}" class="btn btn-info">
                                        {{ __('Add New') }}
                                    </a>
                                      
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
                                    <div class="margin-right">
                                        <button type="button" class="btn btn-success  " data-toggle="modal"
                                        data-target="#extra_modal_emp">
                                        {{ __('Add extra feed') }}
                                    </button>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        @include('dashboard.inc.alerts')
                                       

                                        @include('dashboard.employee.modal')
                                        <table class="table table-striped table-bordered file-export">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('Image') }}</th>
                                                    <th>{{ __('First name') }}</th>
                                                    <th>{{ __('Last name') }}</th>
                                                    <th>{{ __('Email') }}</th>
                                                    <th>{{ __('Job Name') }}</th>
                                                    @foreach (App\Models\Extra::where('table','employee')->where('show_in_table','yes')->get() as $item)
                                                    <th>{{ __(str_replace('_',' ',$item->name)) }}</th>
                                                    @endforeach
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($emps as $key => $item)
                                                    <tr>
                                                        <th>{{ $key + 1 }}</th>
                                                        <th> <img src="{{ asset('uploads/' . $item->image) }}" width="70"
                                                                height="70"></th>
                                                        <th>{{ $item->firstName }}</th>
                                                        <th>{{ $item->LastName }}</th>
                                                        <th>{{ $item->email }}</th>
                                                        <th>{{ $item->JobName }}</th>
                                                        @php
                                                        $extra = json_decode($item->extra);
                                                        
                                                    @endphp
                                                    @foreach (App\Models\Extra::where('table', 'employee')->where('show_in_table', 'yes')->get() as $ex)
                                                        @php
                                                            $name = $ex->name;
                                                        @endphp

                                                        <th>{{ @$extra->$name }}</th>
                                                    @endforeach
                                                        <th>
                                                            <a class="btn btn-success"
                                                            href="{{ route('employees.show', $item->id) }}"><i
                                                                class="ft-eye"></i></a>
                                                            <a class="btn btn-info"
                                                                href="{{ route('employees.edit', $item->id) }}"><i
                                                                    class="ft-edit-3"></i></a>
                                                            <form style="display: inline-block"
                                                                action="{{ route('employees.destroy', $item->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-danger delete-confirm "><i
                                                                        class="ft-delete"></i></button>
                                                            </form>
                                                        </th>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('Image') }}</th>
                                                    <th>{{ __('First name') }}</th>
                                                    <th>{{ __('Last name') }}</th>
                                                    <th>{{ __('Email') }}</th>
                                                    <th>{{ __('Job Name') }}</th>
                                                    @foreach (App\Models\Extra::where('table','employee')->where('show_in_table','yes')->get() as $item)
                                                    <th>{{ __(str_replace('_',' ',$item->name)) }}</th>
                                                    @endforeach
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
    @include('dashboard.employee._extra')
@endsection
