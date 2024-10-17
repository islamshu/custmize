@extends('layouts.master')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('Clients') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a>
                                </li>

                                <li class="breadcrumb-item active">{{ __('Clients') }}
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
                                        <h4 class="card-title">{{ __('Clients') }}</h4>


                                    </div>

                                    <div class="col-md-" style="margin-right:2%">
                                        
                                       

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
                                        
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <a href="{{ route('customers.create') }}" class="btn btn-info">
                                        {{ __('Add New') }}
                                    </a>
                                    <div class="card-body card-dashboard">
                                        @include('dashboard.inc.alerts')
                                       

                                        <table class="table table-striped table-bordered file-export">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ __('Name') }}</th>
                                                    <th>{{ __('Email') }}</th>
                                                    <th>{{ __('Phone') }}</th>
                                                    <th>{{ __('Order Count') }}</th>
                                                    <th>{{ __('Created at') }}</th>

                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($clients as $key => $item)
                                                    <tr>
                                                        <th>{{ $key + 1 }}</th>
                                                        
                                                        <th>{{ $item->first_name. ' ' .$item->last_name   }}</th>
                                                        <th>{{ $item->email }}</th>
                                                        <th>{{ $item->phone }}</th>
                                                        <th>{{ 5 }}</th>
                                                        <th>{{ $item->created_at->format('d-m-Y') }}</th>


                                                        <th>
                                                           
                                                            <a class="btn btn-info"
                                                                href="{{ route('customers.edit', $item->id) }}"><i
                                                                    class="ft-edit-3"></i></a>
                                                            <form style="display: inline-block"
                                                                action="{{ route('customers.destroy', $item->id) }}"
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
                                                    <th>{{ __('Name') }}</th>
                                                    <th>{{ __('Email') }}</th>
                                                    <th>{{ __('Phone') }}</th>
                                                    <th>{{ __('Order Count') }}</th>
                                                    <th>{{ __('Created at') }}</th>

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
