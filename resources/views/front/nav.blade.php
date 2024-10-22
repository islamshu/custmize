<div class="top-nav d-flex align-items-center justify-content-between">


    <div class="btn-group twosides me-4" data-toggle="buttons">
        <div class="btn active">
            <input type="radio" name="form_shirt_side" value="front" autocomplete="off"
                checked />
            <div class="sidename"> Front</div>
        </div>
        @if (@$product->colors[0]->back_image != null)
            <div class="btn">
                <input type="radio" name="form_shirt_side" value="back"
                    autocomplete="off" />
                <div class="sidename" style="color: #939393;"> Back</div>
            </div>
        @endif
    </div>


    {{-- <button id="confirm_side" class="btn btn-warning Preview">اعتماد هذه الواجهة</button> --}}
    <div class="div_reviewbtn d-flex">
        <button type="button" class="btn btn-default Preview" {{-- data-toggle="modal"
            data-target="#reviewModal" --}}
            onclick="loadProductData()"><i class="fa fa-eye"></i> Preview</button>
        <div class="dropup">
            <button class="btn btn-default dropdown-toggle Download" type="button"
                id="dropdownDownload" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fa fa-save"></i> Download
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownDownload">
                <li><a href="#" id="btnDownloadDesign">Design Only</a></li>
                <li><a href="#" id="btnDownloadShirt">Design & Shirt</a></li>
            </ul>
        </div>
    </div>

</div>