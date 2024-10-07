@extends('layouts.master')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('Projects') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a>
                                </li>

                                <li class="breadcrumb-item active">{{ __('Projects') }}
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
                                    <h4 class="card-title">{{ __('Projects') }}</h4>

                                  </div>
                                  
                                    <div class="col-md-" style="margin-right:2%">
                                      <button type="button" class="btn btn-dark  " data-toggle="modal"
                                          data-target="#bootstrap">
                                          {{ __('Add New') }}
                                      </button>
                                      
                                      
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
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        @include('dashboard.inc.alerts')
                                       

                                        @include('dashboard.projects._create')
                                        <table class="table table-striped table-bordered file-export">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th >{{ __('Client Info') }}</th>
                                                    <th>{{ __('Start at') }}</th>
                                                    <th>{{ __('End at') }}</th>
                                                    {{-- <th>{{ __('Status') }}</th> --}}
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($projects as $key => $item)
                                                    <tr>
                                                        <th>{{ $key + 1 }}</th>
                                                        <th> <a href="{{ route('clients.show',$item->client->id) }}">{{ $item->client->name }}</a></th>
                                                        <th>{{ $item->start_at }}</th>
                                                        <th>{{ $item->end_at }}</th>
                                              
                                                        <th>
                                                            <a class="btn btn-success"
                                                            href="{{ route('projects.show', $item->id) }}"><i
                                                                class="ft-eye"></i></a>
                                                            <a class="btn btn-info"
                                                                href="{{ route('projects.edit', $item->id) }}"><i
                                                                    class="ft-edit-3"></i></a>
                                                            <form style="display: inline-block"
                                                                action="{{ route('projects.destroy', $item->id) }}"
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
                                                    <th >{{ __('Client Info') }}</th>
                                                    <th>{{ __('Start at') }}</th>
                                                    <th>{{ __('End at') }}</th>
                                                    {{-- <th>{{ __('Status') }}</th> --}}
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
