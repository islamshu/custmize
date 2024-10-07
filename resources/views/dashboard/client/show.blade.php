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

                                <li class="breadcrumb-item "><a
                                        href="{{ route('clients.index') }}">{{ __('Clients') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Show Client') }}
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
                
                <section id="validation" >
                 

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('Show Client') }}</h4>
                                    
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <button class="btn btn-warning " id="edit_btn_client">{{ __('Edit Client') }}</button>

                                    </div>

                                </div>
                                

                                <div class="card-content collpase show show_emp ">
                                    <div class="card-body">
                                       
                                            <div class="form-body">
                                                <h4 class="form-section"><i class="la la-eye"></i> {{ __('Client Info') }}
                                                </h4>
                                                <div class="row">
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput1">{{ __('Image') }}</label>
                                                        <input type="file" id=""
                                                            class="form-control border-primary image"
                                                            placeholder="{{ __('First name') }}" name="image">
                                                        <div class="form-group">
                                                            <img src="{{ asset('uploads/' . $client->image) }}"
                                                                style="width: 100px" class="img-thumbnail image-preview"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput1">{{ __('Name') }}</label>
                                                        <span class="danger">*</span>
                                                        <input type="text" readonly value="{{ $client->name }}" required
                                                            id="userinput1" class="form-control border-primary"
                                                            placeholder="{{ __('name') }}" name="firstName">
                                                        <div class="invalid-feedback">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label for="userinput2">{{ __('Email') }}</label>
                                                        <span class="danger">*</span>

                                                        <input type="text" readonly value="{{ $client->email }}" id="userinput2"
                                                            required class="form-control border-primary"
                                                            placeholder="{{ __('Email') }}" name="LastName">
                                                        <div class="invalid-feedback">
                                                        </div>
                                                    </div>
                                                   
                                                </div>


                                            </div>

                                            <h4 class="form-section"><i class="ft-mail"></i> {{ __('Contact Info') }}
                                            </h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput3">{{ __('Email') }}</label>
                                                    <span class="danger">*</span>

                                                    <input type="text" readonly value="{{ $client->email }}" id="userinput3"
                                                        required class="form-control border-primary"
                                                        placeholder="{{ __('Email') }}" name="Email">
                                                    <div class="invalid-feedback">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput4">{{ __('Phone') }}</label>
                                                    <span class="danger">*</span>

                                                    <input type="text" readonly value="{{ $client->phone }}" id="userinput4"
                                                        required class="form-control border-primary"
                                                        placeholder="{{ __('Phone') }}" name="Phone">
                                                    <div class="invalid-feedback">
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="form-section"><i class="ft-mail"></i> {{ __('Company Info') }}
                                            </h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput3">{{ __('Company Name') }}</label>

                                                    <input type="text" id="userinput5"
                                                        class="form-control border-primary"
                                                        placeholder="{{ __('Company Name') }}" readonly value="{{ $client->company_name }}" name="company_name">
                                                    <div class="invalid-feedback">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="userinput6">{{ __('Commical register') }}</label>
                                                    <input type="text" class="form-control border-primary" readonly value="{{ $client->comm_register }}"
                                                        placeholder="{{ __('Commical register') }}" id="userinput6" name="comm_register">

                                                </div>

                                            </div>
                                            @if (App\Models\Extra::where('table', 'client')->count() > 0)
                                                <h4 class="form-section"><i class="ft-mail"></i> {{ __('Extra') }}</h4>
                                                <div class="row">

                                                    @php
                                                        $extra = json_decode($client->extra);
                                                    @endphp
                                                    @foreach (App\Models\Extra::where('table', 'client')->get() as $item)
                                                        @php
                                                            $name = @$item->name;
                                                        @endphp

                                                        <div class="form-group col-md-6 mb-2">
                                                            <label
                                                                for="userinput">{{ __(str_replace('_', ' ', $item->name)) }}</label>
                                                            @if ($item->type != 'textarea')
                                                                <input
                                                                    @if ($item->type != 'number') type="text" @else  type="number" @endif
                                                                    value="{{ @$extra->$name }}" disabled
                                                                    class="form-control border-primary"
                                                                    @if ($item->required_or_not == 'required') required @endif
                                                                    placeholder="{{ __(str_replace('_', ' ', $item->name)) }}"
                                                                    name="extra[{{ $item->name }}]">
                                                            @else
                                                                <textarea @if ($item->required_or_not == 'required') required @endif name="extra[{{ $item->name }}]" class="form-control"
                                                                    placeholder="{{ __(str_replace('_', ' ', $item->name)) }}" disabled>{{ @$extra->$name }}</textarea>
                                                            @endif


                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            
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
    <div class="modal fase" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">   >
    <div class="modal-dialog" role="document">
        <div class="modal-content modal_client">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel35">{{ __('Client Info') }}</h3>
                <button type="button" id="clossee" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="addToCart-modal-body">

           </div>
    </div>
</div>
@endsection
@section('script')
    <script>
       
        $("#edit_full_employee").submit(function(event) {
            event.preventDefault();
            url = $('#url_route').val();

            $.ajax({
                type: 'post',
                url: url,
                data: new FormData($('#edit_full_employee')[0]),
                processData: false,
                contentType: false,
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
                        var input = $('#edit_full_employee').find('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.next('.invalid-feedback').html(messages[0]);
                    });
                }
            });
        });
        $('#edit_btn_client').click(function() {
            $('#staticBackdrop').modal();
            $.ajax({
                type: 'post',
                url: "{{ route('showClientModal') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': "{{ $client->id }}"
                },


                success: function(data) {

                    $('#addToCart-modal-body').html(data);


                }
            });
        });
    </script>
@endsection
