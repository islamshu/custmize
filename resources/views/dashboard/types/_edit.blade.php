<div class="modal fade text-left" id="edit_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35"
    aria-hidden="true">
    <div class="modal-dialog modal-lg scroll" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel35">{{ __('Edit Type') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_fast_type" >
                @csrf
                <div class=""></div>
                <input type="hidden" id="edit-id" >


                <div class="modal-body">
                    <fieldset class="form-group floating-label-form-group">
                        <label for="name">{{ __('Size name') }}</label>
                        <input type="text" class="form-control" required  name="name" id="edit-name">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                   
                    <br>
                    
                    <fieldset class="form-group floating-label-form-group">
                        <label for="name">{{ __('name in arabic') }}</label>
                        <input type="text" class="form-control" required  name="name_ar" id="edit-name_ar">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                   
                    <br>
                    
               
                  


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-secondary btn-lg">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>