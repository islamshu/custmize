@extends('layouts.master')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('Customers') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a>
                                </li>

                                <li class="breadcrumb-item "><a
                                        href="{{ route('customers.index') }}">{{ __('Customers') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Add New') }}
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
                                    <h4 class="card-title">{{ __('Add new customer') }}</h4>
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

                                        <form class="form" id="send_full_customer">
                                            @csrf
                                            <div class="form-body">
                                                <h4 class="form-section"><i class="la la-eye"></i> {{ __('Customer Info') }}</h4>
                                        
                                                <div class="row">
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('First name') }} <span class="danger">*</span></label>
                                                        <input type="text" required class="form-control border-primary" name="first_name">
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                        
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('Last name') }} <span class="danger">*</span></label>
                                                        <input type="text" required class="form-control border-primary" name="last_name">
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                        
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('DOB') }}</label>
                                                        <input type="date" class="form-control border-primary" name="DOB">
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                        
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('Gender') }}</label>
                                                        <select class="form-control border-primary" name="gender">
                                                            <option value="male">{{ __('Male') }}</option>
                                                            <option value="female">{{ __('Female') }}</option>
                                                            <option value="other">{{ __('Other') }}</option>
                                                        </select>
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                        
                                                <h4 class="form-section"><i class="ft-lock"></i> {{ __('Security') }}</h4>
                                                <div class="row">
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('Password') }} <span class="danger">*</span></label>
                                                        <input type="password" required class="form-control border-primary" name="password">
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('Confirm Password') }} <span class="danger">*</span></label>
                                                        <input type="password" required class="form-control border-primary" name="confirm_password">
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                        
                                                <h4 class="form-section"><i class="ft-mail"></i> {{ __('Contact Info') }}</h4>
                                                <div class="row">
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('Email') }} <span class="danger">*</span></label>
                                                        <input type="email" required class="form-control border-primary" name="email">
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                        
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('Phone') }} <span class="danger">*</span></label>
                                                        <input type="text" required class="form-control border-primary" name="phone">
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                        
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('State') }}</label>
                                                        <input type="text" class="form-control border-primary" name="state">
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                        
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>{{ __('Country') }}</label>
                                                        <input type="text" class="form-control border-primary" name="country">
                                                        <span class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                        
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="la la-check-square-o"></i> {{ __('Save') }}
                                                    </button>
                                                </div>
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
    <script>
        $("#edit_range").change(function() {
            var range = $(this).val() + '.00';
            $('#range_value').text(range);
        });
        $("#send_full_customer").submit(function(event) {
            $(".invalid-feedback").text("");
            $(".is-invalid").removeClass("is-invalid");

    event.preventDefault();

    $.ajax({
        type: 'POST',
        url: "{{ route('clients.store') }}",
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(response) {
            swal({
                icon: 'success',
                title: '{{ __('Added Successfully') }}',
            }).then(() => {
                $("#send_full_customer").trigger('reset');
            });
        },
        error: function(response) {
            $(".invalid-feedback").text("");
            $(".is-invalid").removeClass("is-invalid");

            if (response.status === 422) {
                var errors = response.responseJSON.errors;
                $.each(errors, function(field, messages) {
                    var input = $('[name="' + field + '"]');
                    input.addClass('is-invalid');
                    input.next('.invalid-feedback').text(messages[0]);
                });
            }
        }
    });
});

    </script>
@endsection
