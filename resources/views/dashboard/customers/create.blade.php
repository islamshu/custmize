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
                                                <h4 class="form-section"><i class="la la-eye"></i> {{ __('Customer Info') }}
                                                </h4>
                                               
                                                <div class="row">
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput1">{{ __('First name') }}</label>
                                                        <span class="danger">*</span>
                                                        <input type="text" required id="userinput1"
                                                            class="form-control border-primary"
                                                            placeholder="{{ __('First name') }}" name="first_name">
                                                            <span class="invalid-feedback">@error('first_name') {{ $message }} @enderror</span>

                                                    </div>
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput2">{{ __('Last name') }}</label>
                                                        <span class="danger">*</span>

                                                        <input type="text" id="userinput2" required
                                                            class="form-control border-primary"
                                                            placeholder="{{ __('Last name') }}" name="last_name">
                                                            <span class="invalid-feedback">@error('last_name') {{ $message }} @enderror</span>

                                                    </div>
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput2">{{ __('DOB') }}</label>
                                                        <input type="date" id="userinput2"
                                                            class="form-control border-primary"
                                                            placeholder="{{ __('DOB') }}" name="DOB">
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput4">{{ __('Password') }}</label>
                                                    <span class="danger">*</span>

                                                    <input type="password" id="userinput4" required
                                                        class="form-control border-primary"
                                                        placeholder="{{ __('Password') }}" name="password">
                                                        <span class="invalid-feedback">@error('last_name') {{ $message }} @enderror</span>


                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput4">{{ __('Confirm Password') }}</label>
                                                    <span class="danger">*</span>

                                                    <input type="password" id="userinput4" required
                                                        class="form-control border-primary"
                                                        placeholder="{{ __('Confirm Password') }}" name="confirm_password">
                                                        <span class="invalid-feedback">@error('last_name') {{ $message }} @enderror</span>

                                                </div>
                                            </div>

                                            <h4 class="form-section"><i class="ft-mail"></i> {{ __('Contact Info') }}</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput3">{{ __('Email') }}</label>
                                                    <span class="danger">*</span>

                                                    <input type="text" id="userinput3" required
                                                        class="form-control border-primary"
                                                        placeholder="{{ __('Email') }}" name="Email">
                                                        <span class="invalid-feedback">@error('last_name') {{ $message }} @enderror</span>

                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput4">{{ __('Phone') }}</label>
                                                    <span class="danger">*</span>

                                                    <input type="text" id="userinput4" required
                                                        class="form-control border-primary"
                                                        placeholder="{{ __('Phone') }}" name="Phone">
                                                        <span class="invalid-feedback">@error('Phone') {{ $message }} @enderror</span>

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
    <script>
        $("#edit_range").change(function() {
            var range = $(this).val() + '.00';
            $('#range_value').text(range);
        });
        $("#send_full_customer").submit(function(event) {
            event.preventDefault();

            $.ajax({
                type: 'POST',
                url: "{{ route('customers.store') }}",
                data: new FormData($('#send_full_customer')[0]),
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        icon: 'success',
                        title: '{{ __('Added Successfuly') }}',
                    }).then((result) => {
                        // refresh the page
                        $("#send_full_customer").trigger('reset');


                    });
                    $('form').find('.is-invalid').removeClass('is-invalid');

                },
                error: function(response) {

                    // If form submission fails, display validation errors in the modal
                    $('.invalid-feedback').empty();
                    $('form').find('.is-invalid').removeClass('is-invalid');
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        var input = $('#send_full_customer').find('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.next('.invalid-feedback').html(messages[0]);
                    });
                }
            });
        });
    </script>
@endsection
