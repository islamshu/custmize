<div class="modal fade text-left" id="edit_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35"
    aria-hidden="true">
    <div class="modal-dialog modal-lg scroll" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel35">{{ __('Edit Color') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_fast_color" >
                @csrf
                <div class=""></div>
                <input type="hidden" id="edit-id">


                <div class="modal-body">
                    <fieldset class="form-group floating-label-form-group">
                        <label for="name">{{ __('Color name') }}</label>
                        <input type="text" class="form-control" required   name="name" id="edit-name">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                   
                    <br>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="name_ar">{{ __('Color name in arabic') }}</label>
                        <input type="text" class="form-control" required  name="name_ar" id="edit-name-ar">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                    
                    <fieldset class="form-group floating-label-form-group">
                        <label for="Phone">{{ __('Color Code') }}</label>
                        <input type="color" class="form-control" required  name="code" id="edit-code">
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