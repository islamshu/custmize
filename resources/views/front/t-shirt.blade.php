<!doctype html>
<html>

<head>
    <title>T-Shirt Online Designer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">

    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700&subset=latin,latin-ext'
        rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Pacifico|VT323|Quicksand|Inconsolata' rel='stylesheet'
        type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('shirt_design/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('shirt_design/js/colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('shirt_design/css/style.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <div id="wrap">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-2">
                    <div class="leftLayout" id="leftLayoutContainer">
                        {{-- <div class="btn-group" data-toggle="buttons">
                                <div class="btn typeButton active">
                                    <input type="radio" name="form_shirt_type" value="1" autocomplete="off" checked />
                                    <img src="{{asset('uploads/'. $product->colors[0]->front_image ) }}" /><br/>
                                    <div class="typename">Men</div>
                                </div>
                                <div class="btn typeButton">
                                    <input type="radio" name="form_shirt_type" value="2" autocomplete="off" />
                                    <img src="images/shirts/women_black_front.png" /><br/>
                                </div>
							</div> --}}
                        <div id="div_colors_title">Color</div>
                        <div class="btn-group" data-toggle="buttons" id="div_colors">
                            @foreach ($product->colors as $key => $productColor)
                                <div class="btn colorButton"
                                    style="background-color: {{ $productColor->color->code }};">
                                    <input type="radio" name="form_shirt_color"
                                        @if ($key == 0) checked @endif
                                        value="{{ $productColor->color->id }}" autocomplete="off">
                                </div>
                            @endforeach

                        </div>

                        <div class="btn-toolbar">
                            <div class="add_image btn-group">
                                <iframe id="ifr_upload" name="ifr_upload" height="0" width="0"
                                    frameborder="0"></iframe>
                                <form id="frm_upload" action="" method="post" enctype="multipart/form-data"
                                    target="ifr_upload">
                                    <label class="btn btn-default btn-file">
                                        <i class="fa fa-picture-o"></i>&nbsp;&nbsp;Add image<input type="file"
                                            name="image_upload" accept=".gif,.jpg,.jpeg,.png,.ico">
                                    </label>
                                </form>
                            </div>
                            <div class="add_text btn-group">
                                <button type="button" class="btn btn-default" id="btn_addtext"><i
                                        class="fa fa-font"></i>&nbsp;&nbsp;Add text</button>
                            </div>

                        </div>
                        <div class="message">
                        </div>
                    </div>
                </div>
                <!-- center column -->
                <div class="col-md-8">
                    <div class="centerLayout" id="centerLayoutContainer">
                        <div class="shirt">
                            <img id="img_shirt" src="{{ asset('uploads/' . $product->colors[0]->front_image) }}"
                                alt="Product Image" />
                            <img id="img_shirt_back" style="display: none"
                                src="{{ asset('uploads/' . $product->colors[0]->back_image) }}" alt="Product Image" />

                        </div>
                        <div class="cvtoolbox">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" id="toolbox_centerh"><i
                                        class="fa fa-arrows-h fa-lg"></i></button>
                                <button type="button" class="btn btn-default" id="toolbox_up"><i
                                        class="fa fa-arrow-up"></i></button>
                                <button type="button" class="btn btn-default" id="toolbox_centerv"><i
                                        class="fa fa-arrows-v fa-lg"></i></button>
                                <button type="button" class="btn btn-default" id="toolbox_flipx"><i
                                        class="fa fa-road fa-lg"></i></button>
                                <button type="button" class="btn btn-default" id="toolbox_flipy"><i
                                        class="fa fa-road fa-lg fa-rotate-90"></i></button>
                                <button type="button" class="btn btn-default" id="toolbox_remove"><i
                                        class="fa fa-trash-o fa-lg"></i></button>
                            </div>
                        </div>
                        <div class="cvtoolbox cvtoolbox_2nd">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" id="toolbox_left"><i
                                        class="fa fa-arrow-left"></i></button>
                                <button type="button" class="btn btn-default" id="toolbox_center"><i
                                        class="fa fa-arrows fa-lg"></i></button>
                                <button type="button" class="btn btn-default" id="toolbox_right"><i
                                        class="fa fa-arrow-right"></i></button>
                                <button type="button" class="btn btn-default nobtn">&nbsp;</button>
                                <button type="button" class="btn btn-default nobtn">&nbsp;</button>
                                <button type="button" class="btn btn-default nobtn">&nbsp;</button>
                            </div>
                        </div>
                        <div class="cvtoolbox cvtoolbox_3rd">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" id="toolbox_totop"><i
                                        class="fa fa-step-backward fa-lg fa-rotate-90"></i></button>
                                <button type="button" class="btn btn-default" id="toolbox_down"><i
                                        class="fa fa-arrow-down"></i></button>
                                <button type="button" class="btn btn-default" id="toolbox_tobottom"><i
                                        class="fa fa-step-forward fa-lg fa-rotate-90"></i></button>
                                <button type="button" class="btn btn-default nobtn">&nbsp;</button>
                                <button type="button" class="btn btn-default nobtn">&nbsp;</button>
                                <button type="button" class="btn btn-default nobtn">&nbsp;</button>
                            </div>
                        </div>
                        <div class="cvtoolbox_info">
                            <div><span></span></div>
                        </div>
                        <div id="div_canvas_front" style="margin-top: 155px;">
                            <canvas id="mainCanvas_front" width="260" height="350"
                                class="shirt_canvas"></canvas>
                        </div>
                        <div id="div_canvas_back" style="margin-top: 155px;">
                            <canvas id="mainCanvas_back" width="260" height="350"
                                class="shirt_canvas"></canvas>
                        </div>
                       
                        <div class="btn-group twosides" data-toggle="buttons">
                            <div class="btn active">
                                <input type="radio" name="form_shirt_side" value="front" autocomplete="off"
                                    checked />
                                <div class="sidename"><i class="fa fa-bookmark-o"></i> Front</div>
                            </div>
                            <div class="btn">
                                <input type="radio" name="form_shirt_side" value="back" autocomplete="off" />
                                <div class="sidename"><i class="fa fa-bookmark"></i> Back</div>
                            </div>
                        </div>
                        <div class="div_reviewbtn">
                            <button type="button" class="btn btn-default" data-toggle="modal"
                                data-target="#reviewModal"><i class="fa fa-eye"></i> Preview</button>

                            <div class="dropup">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownDownload"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-save"></i> Download
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownDownload">
                                    <li><a href="#" id="btnDownloadDesign">Design Only</a></li>
                                    <li><a href="#" id="btnDownloadShirt">Design & Shirt</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- right column -->
                <div class="col-md-2">
                    <div class="rightLayout" id="rightLayoutContainer">
                        <div class="texttoolbox">
                        </div>
                        <div class="message">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button id="saveme"> save me</button>
    

    <!-- Preview Modal -->
    <div id="reviewModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <div class="modal-body" class="hight_model" >
                    <div class="row">
                        <div class="col-md-6">
                        <div class="shirtdesign"><img src=""  /></div>
                       </div>
                       <div class="col-md-6">

                        <div class="shirtdesign_back"><img src=""  /></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Album Modal -->


    <script type="text/javascript" src="{{ asset('shirt_design/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('shirt_design/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('shirt_design/js/placeholders.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('shirt_design/js/colorpicker/js/bootstrap-colorpicker.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('shirt_design/js/fabric4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('shirt_design/js/fontfaceobserver.js') }}"></script>
    <script type="text/javascript" src="{{ asset('shirt_design/js/merge-images.js') }}"></script>
    <script type="text/javascript" src="{{ asset('shirt_design/js/main.min.js') }}"></script>
    <script>
        var productId = {{ $product->id }};
    </script>
        

</body>

</html>
