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

                                <li class="breadcrumb-item "><a
                                        href="{{ route('employees.index') }}">{{ __('Employees') }}</a>
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
                                    <h4 class="card-title">{{ __('Add new employee') }}</h4>
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

                                        <form class="form" id="send_full_employee">
                                            @csrf
                                            <div class="form-body">
                                                <h4 class="form-section"><i class="la la-eye"></i> {{ __('Employee Info') }}
                                                </h4>
                                                <div class="row">
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput1">{{ __('Image') }}</label>
                                                        <input type="file" id=""
                                                            class="form-control border-primary image"
                                                            placeholder="{{ __('First name') }}" name="image">
                                                        <div class="form-group">
                                                            <img src="{{ asset('uploads/employess/defultUser.png') }}"
                                                                style="width: 100px" class="img-thumbnail image-preview"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput1">{{ __('First name') }}</label>
                                                        <span class="danger">*</span>
                                                        <input type="text" required id="userinput1"
                                                            class="form-control border-primary"
                                                            placeholder="{{ __('First name') }}" name="firstName">
                                                        <div class="invalid-feedback">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput2">{{ __('Last name') }}</label>
                                                        <span class="danger">*</span>

                                                        <input type="text" id="userinput2" required
                                                            class="form-control border-primary"
                                                            placeholder="{{ __('Last name') }}" name="LastName">
                                                        <div class="invalid-feedback">
                                                        </div>
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
                                                    <div class="invalid-feedback">
                                                    </div>

                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput4">{{ __('Confirm Password') }}</label>
                                                    <span class="danger">*</span>

                                                    <input type="password" id="userinput4" required
                                                        class="form-control border-primary"
                                                        placeholder="{{ __('Confirm Password') }}" name="confirm_password">
                                                    <div class="invalid-feedback">
                                                    </div>
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
                                                    <div class="invalid-feedback">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput4">{{ __('Phone') }}</label>
                                                    <span class="danger">*</span>

                                                    <input type="text" id="userinput4" required
                                                        class="form-control border-primary"
                                                        placeholder="{{ __('Phone') }}" name="Phone">
                                                    <div class="invalid-feedback">
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="form-section"><i class="ft-mail"></i> {{ __('Job Info') }}</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput3">{{ __('Job Name') }}</label>
                                                    <span class="danger">*</span>

                                                    <input type="text" id="userinput3" required
                                                        class="form-control border-primary"
                                                        placeholder="{{ __('Job Name') }}" name="JobName">
                                                    <div class="invalid-feedback">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                  <label for="userinput4">{{ __('Salary') }}</label>
                                                  <input type="range" step="5" min="100" max="2000"
                                                      id="edit_range" 
                                                      class="form-control border-primary" value="100.00"
                                                      placeholder="{{ __('Salary') }}" name="sallary">
                                                  <span id="range_value">100</span>

                                              </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput4">{{ __('Dgree') }}</label>
                                                    <select name="dgree" class="form-control" id="">
                                                        <option value="" selected disabled>{{ __('choose') }}
                                                        </option>
                                                        <option value="dobloma">{{ __('Dobloma') }}</option>
                                                        <option value="bachelor">{{ __('Bachelor') }}</option>
                                                        <option value="master">{{ __('Master') }}</option>

                                                    </select>

                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput4">{{ __('Name of Dgree') }}</label>
                                                    <input type="text" id="userinput4"
                                                        class="form-control border-primary"
                                                        placeholder="{{ __('Name of Dgree') }}" name="name_of_dgree">
                                                </div>
                                            </div>
                                            @if (App\Models\Extra::where('table', 'client')->count() > 0)
                                            <h4 class="form-section"><i class="ft-mail"></i> {{ __('Extra') }}</h4>
                                            <div class="row">

                                               
                                                @foreach (App\Models\Extra::where('table', 'employee')->get() as $item)
                                                    @php
                                                        $name = @$item->name;
                                                    @endphp

                                                    <div class="form-group col-md-6 mb-2">
                                                        <label
                                                            for="userinput4">{{ __(str_replace('_', ' ', $item->name)) }}</label>
                                                        @if ($item->type != 'textarea')
                                                            <input
                                                                @if ($item->type != 'number') type="text" @else  type="number" @endif
                                                                value=""
                                                                class="form-control border-primary"
                                                                @if ($item->required_or_not == 'required') required @endif
                                                                placeholder="{{ __(str_replace('_', ' ', $item->name)) }}"
                                                                name="extra[{{ $item->name }}]">
                                                        @else
                                                            <textarea @if ($item->required_or_not == 'required') required @endif name="extra[{{ $item->name }}]" class="form-control"
                                                                placeholder="{{ __(str_replace('_', ' ', $item->name)) }}">{{ @$extra->$name }}</textarea>
                                                        @endif


                                                    </div>
                                                @endforeach
                                            </div>
                                            @endif

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
        $("#send_full_employee").submit(function(event) {
            event.preventDefault();

            $.ajax({
                type: 'POST',
                url: "{{ route('employees.store') }}",
                data: new FormData($('#send_full_employee')[0]),
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        icon: 'success',
                        title: '{{ __('Added Successfuly') }}',
                    }).then((result) => {
                        // refresh the page
                        $("#send_full_employee").trigger('reset');

                    });
                    $('form').find('.is-invalid').removeClass('is-invalid');

                },
                error: function(response) {

                    // If form submission fails, display validation errors in the modal
                    $('.invalid-feedback').empty();
                    $('form').find('.is-invalid').removeClass('is-invalid');
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        var input = $('#send_full_employee').find('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.next('.invalid-feedback').html(messages[0]);
                    });
                }
            });
        });
    </script>
@endsection