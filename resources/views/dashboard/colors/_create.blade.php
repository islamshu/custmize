<div class="modal fade text-left" id="bootstrap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35"
    aria-hidden="true">
    <div class="modal-dialog modal-lg scroll" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel35">{{ __('Add') }} {{ __('Color') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_fast_color" >
                @csrf
                <div class=""></div>
                <div class="modal-body">
                    <fieldset class="form-group floating-label-form-group">
                        <label for="name">{{ __('Color name') }}</label>
                        <input type="text" class="form-control" required  name="name" id="name">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                   
                    <br>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="name_ar">{{ __('Color name in arabic') }}</label>
                        <input type="text" class="form-control" required  name="name_ar" id="name_ar">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                   
                    <br>
                    
                    <fieldset class="form-group floating-label-form-group">
                        <label for="Phone">{{ __('Color Code') }}</label>
                        <input type="color" class="form-control" required  name="code" id="">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                  


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-secondary btn-lg">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
