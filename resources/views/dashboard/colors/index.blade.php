@extends('layouts.master')
@section('style')
{{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}

@endsection
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">{{ __('Colors') }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a>
                            </li>

                            <li class="breadcrumb-item active">{{ __('Colors') }}
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
                                <h4 class="card-title">{{ __('Colors') }}</h4>

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
                                   

                                    @include('dashboard.colors._create')
                                    <table class="table table-striped table-bordered file-export">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th >{{ __('name') }}</th>
                                                <th >{{ __('Name in arabic') }}</th>

                                                <th>{{ __('code') }}</th>
                                                {{-- <th>{{ __('Status') }}</th> --}}
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($colors as $key => $item)
                                                <tr>
                                                    <th>{{ $key + 1 }}</th>
                                                    <th>{{ $item->name  }}</th>
                                                    <th>{{ $item->name_ar  }}</th>

                                                    <td>
                                                        <!-- عرض المربع مع اللون -->
                                                        <div style="width: 20px; height: 20px; background-color: {{ $item->code }}; display: inline-block; border: 1px solid #000;"></div>
                                                        <!-- عرض الكود بجانب المربع -->
                                                    </td>                                          
                                                    <th>
                                                        
                                                        <button class="btn btn-primary edit-btn" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-name_ar="{{ $item->name_ar }}"  data-code="{{ $item->code }}"  data-toggle="modal"
                                                            data-target="#edit_model">{{ __('Edit Color') }}</button>

                                                        <form style="display: inline-block"
                                                            action="{{ route('colors.destroy', $item->id) }}"
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
                                                <th >{{ __('name') }}</th>
                                                <th >{{ __('Name in arabic') }}</th>

                                                <th>{{ __('code') }}</th>
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

@include('dashboard.colors._edit')

@endsection
@section('script')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
     $('.edit-btn').on('click', function() {
            $('#edit-id').val($(this).data('id'));
            $('#edit-name').val($(this).data('name'));
            $('#edit-name-ar').val($(this).data('name_ar'));

            $('#edit-code').val($(this).data('code'));
        });
    $("#edit_fast_color").submit(function(event) {
       event.preventDefault();
       let id = $('#edit-id').val();
       let url = '{{ route("colors.update", ":id") }}';
        url = url.replace(':id', id);

       $.ajax({
           type: 'PUT',
           url: url,
           data: {
                name: $('#edit-name').val(),
                name_ar: $('#edit-name-ar').val(),

                code: $('#edit-code').val(),
                _token: '{{ csrf_token() }}' // Alternatively, you can use the setup
            },          
        
           success: function(response) {
               swal({
                   icon: 'success',
                   title: '{{ __('Edit Successfuly') }}',
               }).then((result) => {
                   // refresh the page
                   location.reload();
               });
           },
           error: function(response) {

               // If form submission fails, display validation errors in the modal
               $('.invalid-feedback').empty();
               $('form').find('.is-invalid').removeClass('is-invalid');
               var errors = response.responseJSON.errors;
               $.each(errors, function(field, messages) {
                   var input = $('#add_fast_project').find('[name="' + field + '"]');
                   var inputt = $('#add_fast_project').find('[data-tags-input-name="' + field + '"]');

                   input.addClass('is-invalid');
                   input.next('.invalid-feedback').html(messages[0]);
                   inputt.addClass('is-invalid');
                   inputt.next('.invalid-feedback').html(messages[0]);
               });
           }
       });
   });
   $("#add_fast_color").submit(function(event) {
       event.preventDefault();
       let url = '{{ route("colors.store") }}';

       $.ajax({
           type: 'POST',
           url: url,
           data: new FormData($('#add_fast_color')[0]),
            processData: false,
            contentType: false,        
        
           success: function(response) {
               swal({
                   icon: 'success',
                   title: '{{ __('Added Successfuly') }}',
               }).then((result) => {
                   // refresh the page
                   location.reload();
               });
           },
           error: function(response) {

               // If form submission fails, display validation errors in the modal
               $('.invalid-feedback').empty();
               $('form').find('.is-invalid').removeClass('is-invalid');
               var errors = response.responseJSON.errors;
               $.each(errors, function(field, messages) {
                   var input = $('#add_fast_project').find('[name="' + field + '"]');
                   var inputt = $('#add_fast_project').find('[data-tags-input-name="' + field + '"]');

                   input.addClass('is-invalid');
                   input.next('.invalid-feedback').html(messages[0]);
                   inputt.addClass('is-invalid');
                   inputt.next('.invalid-feedback').html(messages[0]);
               });
           }
       });
   });
</script>
@endsection