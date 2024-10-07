<div class="modal fade text-left" id="bootstrap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel35">{{ __('Add Fast for') }} {{ __('Employee') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="add_fast_employee">
                @csrf
                <div class=""></div>
                <div class="modal-body">
                    <fieldset class="form-group floating-label-form-group">
                        <label for="Fname">{{ __('First name') }}</label>
                        <input type="text" class="form-control" required name="Fname" id="Fname">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                    <br>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="Lname">{{ __('Last name') }}</label>
                        <input type="text" class="form-control" required name="Lname" id="Lname">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                    <br>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="Email">{{ __('Email') }}</label>
                        <input type="email" class="form-control" required name="Email" id="Email">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="Phone">{{ __('Phone') }}</label>
                        <input type="text" class="form-control" required name="Phone" id="Phone">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="JobName">{{ __('Job Name') }}</label>
                        <input type="text" class="form-control" required name="JobName" id="JobName">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                    
                    <fieldset class="form-group floating-label-form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input type="password" class="form-control" required name="password" id="password">
                        <div class="invalid-feedback">
                        </div>
                    </fieldset>
                    <fieldset class="form-group floating-label-form-group">
                        <label for="confirm-password">{{ __('Confirm Password') }}</label>
                        <input type="password" class="form-control" required name="confirm_password"
                            id="confirm-password">
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
