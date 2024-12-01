@extends('layouts.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> {{ __('Promo Codes') }} </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                                 <br>
                                <a href="{{ route('banners.create') }}" class="btn btn-success">   {{ __('Add New') }} </a>
                            </div>

                            <div class="card-content collapse show">

                                <div class="card-body card-dashboard">
                                    @include('dashboard.inc.alerts')

                                    <br>

                                    <br>
                                    <table class="table table-striped table-bordered file-export">


                                        <br>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Image') }} </th>
                                                <th>{{ __('URL') }}   </th>
                                               
                                                <th>{{ __('Action') }}   </th>

                                            </tr>
                                        </thead>
                                        <tbody id="stores">
                                            @foreach ($banners as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>

                                                    <td><img src="{{ asset('uploads/'.$item->image) }}" width="80" height="80" alt=""></td>
                                                    <td><a target="_blank" href="{{ $item->url }}">{{ $item->url }}</a> </td>
                                              

                                                    <td>

                                                        <a href="{{ route('banners.edit',$item->id) }}" class="btn btn-primary"><i class="la la-edit"></i>  </a>

                                                        <form style="display: inline"
                                                            action="{{ route('banners.destroy', $item->id) }}"
                                                            method="post">
                                                            @method('delete') @csrf
                                                            <button type="submit" class="btn btn-danger delete-confirm"><i
                                                                    class="la la-trash"></i></button>
                                                        </form>
                                                    </td>



                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

    </div>
@endsection
@section('script')

@endsection
