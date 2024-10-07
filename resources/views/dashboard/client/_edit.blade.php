<form id="edit_fast_client">
    @csrf
    @method('post')
    <input type="hidden" id="client_id_show" value="{{ $client->id }}">
    <input type="hidden" value="{{ route('show_client_post', $client->id) }}" id="url_route">
    <div class="modal-body">
        <fieldset class="form-group floating-label-form-group">
            <label for="Fname">{{ __('Name') }}</label>
            <input type="text" class="form-control" value="{{ $client->name }}" required name="name"
                id="Fname">
            <div class="invalid-feedback">
            </div>
        </fieldset>

        <fieldset class="form-group floating-label-form-group">
            <label for="Email">{{ __('Email') }}</label>
            <input type="email" class="form-control" value="{{ $client->email }}" required name="email"
                id="Email">
            <div class="invalid-feedback">
            </div>
        </fieldset>
        <fieldset class="form-group floating-label-form-group">
            <label for="Phone">{{ __('Phone') }}</label>
            <input type="text" class="form-control" required value="{{ $client->phone }}" name="phone"
                id="Phone">
            <div class="invalid-feedback">
            </div>
        </fieldset>
        <fieldset class="form-group floating-label-form-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="password" class="form-control" name="password" id="password">
            <div class="invalid-feedback">
            </div>
        </fieldset>
        <fieldset class="form-group floating-label-form-group">
            <label for="confirm-password">{{ __('Confirm Password') }}</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm-password">
            <div class="invalid-feedback">
            </div>
        </fieldset>

        <fieldset class="form-group floating-label-form-group">
            <label for="Phone">{{ __('Company Name') }}</label>
            <input type="text" class="form-control" required value="{{ $client->company_name }}" name="company_name"
                id="Phone">
            <div class="invalid-feedback">
            </div>
        </fieldset>
        <fieldset class="form-group floating-label-form-group">
            <label for="Phone">{{ __('Commical register') }}</label>
            <input type="text" class="form-control" required value="{{ $client->comm_register }}"
                name="comm_register" id="Phone">
            <div class="invalid-feedback">
            </div>
        </fieldset>

        @if (App\Models\Extra::where('table', 'client')->count() > 0)

            @php
                $extra = json_decode($client->extra);
            @endphp
            @foreach (App\Models\Extra::where('table', 'client')->get() as $item)
                @php
                    $name = @$item->name;
                @endphp

                <fieldset class="form-group floating-label-form-group">

                    <label for="userinput4">{{ __(str_replace('_', ' ', $item->name)) }}</label>
                    @if ($item->type != 'textarea')
                        <input @if ($item->type != 'number') type="text" @else  type="number" @endif
                            value="{{ @$extra->$name }}" class="form-control border-primary"
                            @if ($item->required_or_not == 'required') required @endif
                            placeholder="{{ __(str_replace('_', ' ', $item->name)) }}"
                            name="extra[{{ $item->name }}]">
                    @else
                        <textarea @if ($item->required_or_not == 'required') required @endif name="extra[{{ $item->name }}]" class="form-control"
                            placeholder="{{ __(str_replace('_', ' ', $item->name)) }}">{{ @$extra->$name }}</textarea>
                    @endif
                </fieldset>
            @endforeach
        @endif






    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-outline-secondary btn-lg">{{ __('Save') }}</button>
    </div>
</form>
<script>
    $("#edit_fast_client").submit(function(event) {
        event.preventDefault();
        url = $('#url_route').val();

        $.ajax({
            type: 'post',
            url: url,
            data: new FormData($('#edit_fast_client')[0]),
            processData: false,
            contentType: false,
            success: function(response) {
                swal({
                    icon: 'success',
                    title: '{{ __('Edit Successfuly') }}',
                })
                $('form').find('.is-invalid').removeClass('is-invalid');
                $('#userinput1').val(response.client.name)
                $('#userinput2').val(response.client.email)
                $('#userinput3').val(response.client.email)
                $('#userinput4').val(response.client.phone)
                $('#userinput5').val(response.client.company_name)
                $('#userinput6').val(response.client.comm_register)
                location.reload();

                $('#clossee').click();
                


            },
            error: function(response) {

                // If form submission fails, display validation errors in the modal
                $('.invalid-feedback').empty();
                $('form').find('.is-invalid').removeClass('is-invalid');
                var errors = response.responseJSON.errors;
                $.each(errors, function(field, messages) {
                    var input = $('#edit_fast_client').find('[name="' + field + '"]');
                    input.addClass('is-invalid');
                    input.next('.invalid-feedback').html(messages[0]);
                });
            }
        });
    });
</script>
