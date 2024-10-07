<div class="modal fade text-left" id="extra_modal_emp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel35">{{ __('Add extra feed') }} </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form" action="{{ route('add_extra') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type_name" value="employee" id="">

                <div id="car_parent">



                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>{{ __('Feed name') }} :</label>
                                    <input type="text"
                                        class="form-control form-control-solid form-control-lg name_ar_offer"
                                        id="name_ar_offer" name="addmore[0][name]"  />

                                </div>
                            </div>
                         
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <label>{{ __('required or not') }} :</label>
                                    
                                        <select name="addmore[0][required_or_not]"  class="form-control form-control-solid form-control-lg" id="name_en">
                                            <option value="" disabled>{{ __('choose') }}</option>
                                            <option value="required">{{ __('required') }}</option>
                                            <option value="not_required">{{ __('not required') }}</option>
                                        </select>

                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>{{ __('Show in table') }} :</label>
                                    
                                        <select name="addmore[0][show_in_table]"  class="form-control form-control-solid form-control-lg" id="name_en">
                                            <option value="" disabled>{{ __('choose') }}</option>
                                            <option value="yes">{{ __('Yes') }}</option>
                                            <option value="no">{{ __('No') }}</option>
                                        </select>

                                </div>
                            </div>
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <label>{{ __('Type') }}</label>
                                    <select name="addmore[0][type]"  class="form-control form-control-solid form-control-lg" id="name_en">
                                        <option value="" disabled>{{ __('choose') }}</option>
                                        <option value="text">{{ __('text') }}</option>
                                        <option value="number">{{ __('number') }}</option>
                                        <option value="textarea">{{ __('textarea') }}</option>
                                    </select>
                              

                                </div>
                              
                            </div>
                            <div class="col-xl-2">
                                <div class="form-group mt-3">
                            <button type="button" name="add"
                            class="btn btn-success add_row for-more ml">{{ __('Add more') }}</button>
                                </div>
                            </div>
                        </div>





                    </div>

                    <div id="extra">
                        <input type="hidden" value="{{ App\Models\Extra::where('table','employee')->count() }}"  id="count_tt">
                        @foreach (App\Models\Extra::where('table','employee')->get() as $key=> $item)

                            <div class="card-body class{{$key +1}}" >
                                <div class="row">
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label>{{ __('Feed name') }} :</label>
                                        <input type="text"
                                            class="form-control form-control-solid form-control-lg name_ar_offer"
                                            id="name_ar_offer" value="{{ str_replace('_', ' ', $item->name) }}" name="addmore[{{$key +1}}][name]" 
                                            />
                                        
                                    </div>
                                </div>
            
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label>{{ __('required or not') }} :</label>
                                        <select name="addmore[{{$key +1}}][required_or_not]"  class="form-control form-control-solid form-control-lg" id="name_en">
                                                        <option value="" disabled>{{ __('choose') }}</option>
                                                        <option value="required" @if($item->required_or_not == 'required') selected @endif>{{ __('required') }}</option>
                                                        <option value="not_required" @if($item->required_or_not == 'not_required') selected @endif>{{ __('not required') }}</option>
                                                    </select>
                                        
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                            <div class="form-group">
                                                <label>{{ __('Show in table') }} :</label>
                                                
                                                    <select name="addmore[{{$key +1}}][show_in_table]"  class="form-control form-control-solid form-control-lg" id="name_en">
                                                        <option value="" disabled>{{ __('choose') }}</option>
                                                        <option value="yes" @if($item->show_in_table == 'yes') selected @endif>{{ __('Yes') }}</option>
                                                        <option value="no" @if($item->show_in_table == 'no') selected @endif>{{ __('No') }}</option>
                                                    </select>
            
                                            </div>
                                        </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label>{{ __('Type') }}</label>
                                        <select name="addmore[{{$key +1}}][type]"  class="form-control form-control-solid form-control-lg" id="name_en">
                                                    <option value="" disabled>{{ __('choose') }}</option>
                                                    <option value="text" @if($item->type == 'text') selected @endif>{{ __('text') }}</option>
                                                    <option value="number" @if($item->type == 'number') selected @endif>{{ __('number') }}</option>
                                                    <option value="textarea" @if($item->type == 'textarea') selected @endif>{{ __('textarea') }}</option>
                                                </select>
                                        
                                    </div>
                                </div>
                                <div class="col-xl-2 mt-3">
                                    <div class="form-groub">
                                        <button type="button" onclick="remove_button_event('{{$key +1}}')" class="remove_button btn btn-danger remove[{{$key +1}}] " title="Remove field">{{ __('Remove') }}</button>
                                    </div>
                                </div>
                            </div>
            
            
            
                            </div>



                            @endforeach
                        </div>
                    <br>

                
                    <div class="form-actions left">

                        <button type="submit" class="btn btn-primary">
                            <i class="la la-check-square-o"></i> {{ __('حفظ') }}
                        </button>
                    </div>
                </div>





            </form>
        </div>
    </div>
</div>

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        var i = $('#count_tt').val() +1;
        $('.add_row').on('click', function() {
            addRow();
        });

        function addRow() {
            ++i;
            const sum = i + 1;



            let form = `
                <span class="test class` + i + `">
                <div class="card-body" >
                    <div class="row">
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label>{{ __('Feed name') }} :</label>
                            <input type="text"
                                class="form-control form-control-solid form-control-lg name_ar_offer"
                                id="name_ar_offer" name="addmore[` + i + `][name]" required
                                />
                            
                        </div>
                    </div>

                    <div class="col-xl-2">
                        <div class="form-group">
                            <label>{{ __('required or not') }} :</label>
                            <select name="addmore[` + i + `][required_or_not]" required class="form-control form-control-solid form-control-lg" id="name_en">
                                            <option value="" disabled>{{ __('choose') }}</option>
                                            <option value="required">{{ __('required') }}</option>
                                            <option value="not_required">{{ __('not required') }}</option>
                                        </select>
                            
                        </div>
                    </div>
                    <div class="col-xl-3">
                                <div class="form-group">
                                    <label>{{ __('Show in table') }} :</label>
                                    
                                        <select name="addmore[` + i + `][show_in_table]" required class="form-control form-control-solid form-control-lg" id="name_en">
                                            <option value="" disabled>{{ __('choose') }}</option>
                                            <option value="yes">{{ __('Yes') }}</option>
                                            <option value="no">{{ __('No') }}</option>
                                        </select>

                                </div>
                            </div>
                    <div class="col-xl-2">
                        <div class="form-group">
                            <label>{{ __('Type') }}</label>
                            <select name="addmore[` + i + `][type]" required class="form-control form-control-solid form-control-lg" id="name_en">
                                        <option value="" disabled>{{ __('choose') }}</option>
                                        <option value="text">{{ __('text') }}</option>
                                        <option value="number">{{ __('number') }}</option>
                                        <option value="textarea">{{ __('textarea') }}</option>
                                    </select>
                            
                        </div>
                    </div>
                    <div class="col-xl-2 mt-3">
                        <div class="form-groub">
                            <button type="button" onclick="remove_button_event('` + i + `')" class="remove_button btn btn-danger remove[` + i + `] " title="Remove field">{{ __('Remove') }}</button>
                        </div>
                    </div>
                </div>



                </div>
                </span>
                `;
            $('#extra').append(form);
            var wrapper = $('#extra');
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();


                $(this).parent('span').remove();

            });

            // $(wrapper1).on('click', '.remove_button_old', function (e) {
            //     alert('d');
            //         e.preventDefault();
            // $(this).parent('span').remove();

            // });
        }
        var wrapper1 = $('#partent');
        $(wrapper1).on('click', '.remove_button_old', function(e) {
            e.preventDefault();
            $(this).parent('span').remove();
        });
        
    });
    function remove_button_event(id){
        $('.class'+id).remove();
        }
</script>
@endsection
