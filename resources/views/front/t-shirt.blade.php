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
    <link rel="stylesheet" href="{{ asset('custom/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/css/style.min.css') }}">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" type="text/css" href="{{ asset('custom/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@100;200;300;400;500;600;700&display=swap');


        .ibm-plex-sans-arabic-thin {
            font-family: "IBM Plex Sans Arabic", sans-serif;
            font-weight: 100;
            font-style: normal;
        }

        .ibm-plex-sans-arabic-extralight {
            font-family: "IBM Plex Sans Arabic", sans-serif;
            font-weight: 200;
            font-style: normal;
        }

        .ibm-plex-sans-arabic-light {
            font-family: "IBM Plex Sans Arabic", sans-serif;
            font-weight: 300;
            font-style: normal;
        }

        .ibm-plex-sans-arabic-regular {
            font-family: "IBM Plex Sans Arabic", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .ibm-plex-sans-arabic-medium {
            font-family: "IBM Plex Sans Arabic", sans-serif;
            font-weight: 500;
            font-style: normal;
        }

        .ibm-plex-sans-arabic-semibold {
            font-family: "IBM Plex Sans Arabic", sans-serif;
            font-weight: 600;
            font-style: normal;
        }

        .ibm-plex-sans-arabic-bold {
            font-family: "IBM Plex Sans Arabic", sans-serif;
            font-weight: 700;
            font-style: normal;
        }

        .fs24 {
            font-size: 24px !important;
        }

        .fs28 {
            font-size: 28px !important;
        }

        .fs-16 {
            font-size: 16px !important;
        }

        a {
            text-decoration: unset;

        }

        .main-color {
            color: #6FBC69;
        }



        body {
            font-family: "IBM Plex Sans Arabic", sans-serif !important;
            font-style: normal;
        }


        .main {
            padding-left: 32px;
        }

        .delivery {
            font-size: 16px;
            color: white;
            background: linear-gradient(270deg, #CFDB27 -39.41%, #6FBC69 100%);
            padding: 6px 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .products-iamge img {
            border-radius: 5px;
            border: 1px solid #E9E9EA
        }

        .btns {
            margin-bottom: 60px;
        }

        .Quantity {
            margin-bottom: 10px;
            margin-top: 10px;
            font-size: 16px;
        }

        .btns a {
            padding: 13px 12px;
            border-radius: 14px;
            border: 1px solid #6FBC69;
            color: #6FBC69;
            width: 142px;
            display: inline-block;
            text-align: center;
            line-height: 1;
            font-size: 20px;
            background: #F0F8F0;

        }

        .btns a:first-child {
            background-color: #6FBC69;
            color: #ffffff;
            margin-right: 10px;

        }

        .price {
            padding: 10px;
            background: #F0F8F0;
            border: 2px solid;
            border-image: linear-gradient(270deg, #CFDB27 -39.41%, #6FBC69 100%) 1;
            width: 300px;
            height: 100px;
            /* border-radius: 15px; */
            align-items: center;
            justify-content: space-around;

        }

        .Quantity-input {
            border: 1px solid #e8e8e8;
            width: 140px;
            align-items: center;
            justify-content: space-around;
            border-radius: 15px;
            padding: 10px;
            margin-bottom: 30px;
        }

        .Quantity-input span {
            border: 2px solid #c1c1c1;
            border-radius: 50%;
            padding: 3px;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 18px;
            cursor: pointer;
        }

        .Quantity-input span:last-child {
            border-color: #6FBC69 !important;
        }

        .fa-plus {
            color: #6FBC69;
            font-weight: 300;

        }

        .fa-minus {
            color: #c1c1c1;
            font-weight: 300;
        }

        .Quantity-input h6 {
            font-size: 22px;
            margin-bottom: 0;
        }

        .centerLayout {
            background-color: transparent;
        }

        .twosides .btn {
            border: unset;
            padding: 2px 5px;
            height: 40px;
            width: 85px;
            line-height: 34px;
            border-bottom: 1px solid #eee;
            font-size: 20px;
        }

        .twosides .btn.active {
            background-color: #F0F8F0;
            color: #6FBC69;
            border-bottom: 2px solid #6FBC69;

        }

        .div_reviewbtn {
            position: unset;
            top: unset;
            right: unset;

        }


        .color1 {
            background: #60BCC3;

        }

        .color2 {
            background: #D5C9B7;

        }

        .color3 {
            background: #A97DB3;

        }

        .color4 {
            background: #175AC7;

        }

        .color5 {
            background: #96BBFF;

        }

        .color6 {
            background: #8EE0FF;

        }

        .color7 {
            background: #D9EFFF;

        }


        .btn-check:checked+.btn,
        .btn.active,
        .btn.show,
        .btn:first-child:active,
        :not(.btn-check)+.btn:active {
            box-shadow: unset;
        }

        .product-iamges {
            margin-bottom: 15px;
        }

        .product-iamges .btn {
            border: 2px solid #eee !important;
            border-radius: 10px !important;
            margin-right: 10px !important;
        }

        .btn-group>.btn:last-child:not(:first-child),
        .btn-group>.dropdown-toggle:not(:first-child) {}


        .cvtoolbox .btn {
            padding: 6px;
            width: 48px;
            height: 48px;
            margin: 2px;
            border: 1px solid #a9a9a9;
            border-radius: 8px;
        }

        .btn-text {
            border: 1px solid #c9c9c9;
            text-align: left;
            height: 40px;
            font-size: 16px;
            color: rgb(197, 197, 197);
        }

        .btn-text:hover {
            border: 1px solid #cacaca;
        }

        .btn-text::placeholder {
            font-size: 20px;
            color: #c9c9c9;
        }

        .add_album .btn,
        .add_text .btn {
            width: 100%;
        }

        .text-tool {
            border: 1px solid #c9c9c9;
            border-radius: 5px;
            padding: 5px 12px;
            margin-bottom: 5px;
            font-family: "IBM Plex Sans Arabic", sans-serif;
            font-weight: 600;
            font-style: normal;
            margin-right: 5px;
        }

        select {
            word-wrap: normal;
            width: 100% !important;
            border-radius: 5px;
            border: 1px solid #c9c9c9;
            padding: 6px;
        }


        .size {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            max-width: 60%;

            margin-top: 10px;

        }

        .size span {
            border: 1px solid #c5c5c5;
            border-radius: 8px;
            padding: 8px 15px;
            display: inline-block;
            cursor: pointer;
            margin-right: 5px
        }

        .material {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 40%;
            margin: auto;
            margin-top: 10px;

        }

        .material span {
            border: 1px solid #c5c5c5;
            border-radius: 8px;
            padding: 8px 12px;
            display: inline-block;
            text-transform: capitalize;
            cursor: pointer;
        }

        .size span.active {
            border-color: #6FBC69;
            color: #6FBC69;
            background: #F0F8F0;
        }

        .material span.active {
            border-color: #6FBC69;
            color: #6FBC69;
            background: #F0F8F0;
        }



        .Preview {
            padding: 12px 12px !important;
            border-radius: 14px;
            border: 1px solid #6FBC69;
            color: #6FBC69;
            width: 142px;
            display: inline-block;
            text-align: center;
            line-height: 1;
            font-size: 14px;
            background: #F0F8F0;
        }

        .Preview:hover {
            background: #F0F8F0;
            border: 1px solid #6FBC69;
            color: #6FBC69;
        }

        .Download {
            background-color: #6FBC69;
            color: #ffffff;
            margin-left: 10px;

            padding: 12px 12px !important;
            border-radius: 14px;
            border: 1px solid #6FBC69;
            width: 142px;
            display: inline-block;
            text-align: center;
            line-height: 1;
            font-size: 14px;
        }

        .Download:hover {
            background-color: #6FBC69;
            border: 1px solid #6FBC69;
            color: #ffffff;

        }

        .div_colors_title .btn-group-vertical>.btn,
        .btn-group>.btn {
            flex: unset !important;
        }


        .color {
            margin-top: 7%;
            text-align: center;
        }

        .color-group {
            margin: auto;
            display: flex;
            justify-content: center;
        }

        .btn:active,
        .btn.active {
            border-color: #6FBC69;
            background: #F0F8F0;
        }

        .color span {
            height: 36px;
            width: 36px;
            border-radius: 6px;
            display: block;
            margin: 10px;
            cursor: pointer;
            border: 1px solid #eee;
            border-top-right-radius: 6px !important;
            border-bottom-right-radius: 6px !important;
            border-top-left-radius: 6px !important;
            border-bottom-left-radius: 6px !important;
        }

        .album-wrapper {
            background: #F9F9FA;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 20px;

        }

        .notify img {
            cursor: pointer;
        }

        .album {

            display: block;
            height: 200px;



        }

        .album a {
            display: block;
        }

        .album .album-item div {
            width: 84px;
            height: 84px;
            background-position: 50%;
            background-repeat: no-repeat;
            background-size: contain;
            border: 1px solid #e5e5e5;
            margin: 3px;
            text-align: center;
            border-radius: 12px;
        }

        .save {
            background-color: #6FBC69;
            color: white;
            border-radius: 10px;
            padding: 10px 14px;
            display: inline-block;
            margin-top: 25px;
            cursor: pointer;
        }

        .upload-img {
            text-align: center;
            margin-top: 5px;
            margin-bottom: 15px;

        }

        .upload-img .btn-group .btn {
            border-radius: 12px;
            border: 1px solid #eee !important;
            padding: 8px 15px;
        }

        .upload-img .btn-group .active {
            background-color: #6FBC69;

        }

        .add_image {
            margin-bottom: 0;
        }

        .dropup .dropdown-menu,
        .navbar-fixed-bottom .dropdown .dropdown-menu {
            top: auto;
            bottom: 100%;
            margin-bottom: 1px;
            width: 150px;
            border: none;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
            border-radius: 3px;
        }

        .dropdown-menu>li>a {
            display: block;
            padding: 4px 20px;
            clear: both;
            font-weight: 500;
            line-height: 1.42857143;
            color: #747474;
            white-space: nowrap;
        }


        @media(max-width:970px) {
            .container {
                overflow: scroll;
                width: 1320px;
            }

            .centerLayout div.shirt {
                left: 115%;
                margin-left: auto;
                margin-right: auto;
                max-width: 600px;
                padding: 0 15px;
                position: absolute;
                /* right: -108%; */
                width: 100%;
            }

            .color {
                margin-top: 70px;
            }

            .centerLayout div.shirt {
                top: 29%;
            }
        }

        .serach::placeholder {
            font-size: 16px;
        }

        .serach:focus {
            box-shadow: none;
        }

        .product-iamges::-webkit-scrollbar {
            opacity: 0;
        }
    </style>

</head>

<body>

    <div class="container" id="">
        <div class="nav d-flex align-items-center justify-content-between p-3 mb-4"
            style="border-bottom: 1px solid #ececec;">
            <div class="logo">
                <a href="/"> <img src="{{ asset('uploads/' . get_general_value('website_logo')) }}" width="147"
                        height="47" alt="">
                </a>
            </div>

            <div class="input" style="flex-grow: .7;">
                <input class="form-control" type="text" name="" id="" placeholder="Search here..."
                    style="height: 48px; border-radius: 12px;">
            </div>

            <div class="notify d-flex align-items-center" style="flex-grow: .1;">
                <a href="#"><i class="fa fa-bill"></i></a>
                <img src="{{ asset('frontend/images/phone.png') }}" width="48" height="48" alt=""
                    class="m-2">
                <img src="{{ asset('frontend/images/notify.png') }}" width="48" height="48" alt=""
                    class="m-2">
            </div>

            @auth('client')
                <div class="dropdown">
                    <img src="{{ asset('frontend/images/man_146018.png') }}" width="48" height="48" alt=""
                        class="dropdown-toggle" data-bs-toggle="dropdown" style="cursor: pointer;">

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('client.dashboard') }}">الملف الشخصي</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('client.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                تسجيل الخروج
                            </a>
                            <form id="logout-form" action="{{ route('client.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>

                <div class="ms-2">
                    <span>مرحبا</span>
                    <h4>{{ auth('client')->user()->first_name . ' ' . auth('client')->user()->last_name }}</h4>
                </div>
            @else
                <a href="{{ route('client.login') }}" class="btn btn-secondary">تسجيل الدخول</a>
            @endauth
        </div>

        <div class="main row">
            <div class="col-3  " style="border-right: 1px solid #ececec;">

                <div class="" id="leftLayoutContainer">
                    <h3 class=" ibm-plex-sans-arabic-semibold mb-4" style="font-size: 24px;">{{ $product->name }}</h3>
                    <div class="d-flex align-items-center" style="margin-bottom: 25px;">
                        <img src="{{ asset('custom/images/stars.png') }}" alt="">
                        <h4 class="ibm-plex-sans-arabic-semibold d-inline-block ms-2 mb-0">4.6</h4>
                    </div>
                    <h6 class="ibm-plex-sans-arabic-bold mb-4" style="font-size: 16px;">13 Pieces in stock</h6>
                    <p style="font-size: 16px;" class="mb-4">
                        {{ $product->description }}
                    </p>

                    <p class="fs-16 mb-2 ibm-plex-sans-arabic-medium">Delivery</p>
                    <a href="" class="delivery">4 - 9 october</a>

                    <div class="product-iamges">
                        <h4 class="mb-2">Guiding pictures</h4>


                        <div class="btn-group product-iamges" data-toggle="buttons"
                            style="    height: 135px;
						overflow: hidden;
						overflow-x: scroll;width: 100%;">
                            @foreach (json_decode($product->guidness_pic) as $item)
                                <div class="btn typeButton  m-1">

                                    <img src="{{ asset('uploads/' . $item) }}" width="100"
                                        height="100" /><br />

                                    <!-- <div class="typename">Men</div> -->

                                </div>
                            @endforeach




                        </div>
                    </div>

                </div>

                <h6 class="Quantity">Quantity</h6>
                <div class="d-flex Quantity-input">
                    <span id="decrease">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </span>
                    <h6 id="number">1</h6>
                    <input type="hidden" name="qty" value="1" id="qty">
                    <span id="increase">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="btns">
                    <a href="">Add to cart</a>
                    <a href="">Buy now</a>
                </div>

                <div class="price d-flex">
                    <div class="">
                        <span class="fs-16">Piece Price</span>
                        <h3 class="fs28" id="main_price">$
                            00</h3>
                            <input type="hidden"  id="main_price_input" value="0">
                    </div>

                    <div class="">
                        <span class="fs-16">Total Price</span>
                        <h3 class="fs28" id="total_price">$ 00.00</h3>
                    </div>
                </div>


            </div>

            <div class="col-6">
                <div class="" id="centerLayoutContainer">
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


                        <button id="confirm_side" class="btn btn-warning Preview">اعتماد هذه الواجهة</button>
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

                    <div class="centerLayout">
                        <div class="shirt">
                            <img id="img_shirt" src="{{ asset('uploads/' . $product->colors[0]->front_image) }}"
                                alt="Product Image" />
                            <img id="img_shirt_back" style="display: none"
                                src="{{ asset('uploads/' . $product->colors[0]->back_image) }}"
                                alt="Product Image" />

                        </div>
                        <div id="div_canvas_front" style="margin-top: 155px;">
                            <canvas id="mainCanvas_front" width="260" height="350"
                                class="shirt_canvas"></canvas>
                        </div>
                        <div id="div_canvas_back" style="margin-top: 155px;">
                            <canvas id="mainCanvas_back" width="260" height="350"
                                class="shirt_canvas"></canvas>
                        </div>



                    </div>


                    <div id="div_colors_title" class="color">
                        <h4>Color</h4>
                        <div class="btn-group color-group" data-toggle="buttons" id="div_colors">
                            @foreach ($product->colors as $key => $productColor)
                                <span class="btn colorButton @if ($key == 0) active @endif "
                                    title="{{ $productColor->price }}"
                                    style="background-color: {{ $productColor->color->code }};">
                                    <input title="{{ $productColor->price }}" type="radio" name="form_shirt_color"
                                        data-price="{{ $productColor->price }}"
                                        @if ($key == 0) checked @endif
                                        value="{{ $productColor->color->id }}"
                                        autocomplete="off" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </span>
                            @endforeach


                        </div>

                    </div>
                    {{-- {{ dd($product->sizes ==  '[]') }} --}}
                    <input type="hidden"  id="have_size" value="{{ $product->sizes != '[]' ? 1 : 0 }}">
                    @if ($product->sizes != '[]')
                        <h4 class="text-center mt-2">Size</h4>
                        <div class="size">
                            @foreach ($product->sizes as $key => $size)
                                <span data-price="{{ $size->price }}" data-name="{{ $size->size_name }}"
                                    title="{{ $size->price }}"
                                    @if ($key == 0) class="active" @endif>{{ $size->size_name }}</span>
                            @endforeach

                        </div>

                    @endif
                    @if ($product->type_id != null)
                        <h4 class="text-center mt-4">Material</h4>
                        <div class="material">
                            <span class="active"
                                data-material="{{ App\Models\TypeCategory::find($product->type_id)->name }}">{{ App\Models\TypeCategory::find($product->type_id)->name }}</span>
                        </div>
                    @endif


                </div>
            </div>

            <div class="col-3" style="border-left: 1px solid #ececec;padding-left: 15px;"
                id="centerLayoutContainer">
                <div class="rightLayout" id="rightLayoutContainer">

                    <h4 class="" style="margin-bottom: 25px;">Print Options</h4>

                    <div class="add_text mt-3">
                        <h4>Text</h4>
                        <button type="button" class="btn btn-text btn-default" id="btn_addtext">
                            Add your text</button>
                    </div>

                    <div class="texttoolbox d-block">
                        <div class="" data-toggle="buttons">


                            <label class="btn btn-default text-tool" id="texttoolbox_bold"><input type="checkbox"
                                    autocomplete="off" istool="bold"><i class="fa fa-bold me-1"> </i>Wight</label>

                            <label class="btn btn-default text-tool" id="texttoolbox_italic"><input type="checkbox"
                                    autocomplete="off" istool="italic"><i class="fa fa-italic me-1"></i>Style</label>
                            <label class="btn btn-default text-tool" id="texttoolbox_underline"><input
                                    type="checkbox" autocomplete="off" istool="underline"><i
                                    class="fa fa-underline me-1"></i>
                                Transform</label>


                            <label class="btn btn-default text-tool" id="texttoolbox_strikethrough"><input
                                    type="checkbox" autocomplete="off" istool="strikethrough"><i
                                    class="fa fa-strikethrough me-1"></i> Strikethrough</label>

                            <label class="btn btn-defaul text-toolt text-tool" id="texttoolbox_edit"><input
                                    type="checkbox" autocomplete="off" istool="edit"><i
                                    class="fa fa-pencil-square-o fa-lg me-1"></i>Edit</label>

                            <label class="btn btn-default text-tool colorpicker-component" id="texttoolbox_color">
                                <span class=" add-on "><i
                                        style="background-color: rgb(255, 0, 0);width: 11px;height: 11px;display: inline-block;"
                                        class="me-1"></i>Color
                                </span>
                            </label>
                        </div>
                        <div class=" ">
                        </div>

                        <h4 class="mb-2 mt-4">Font</h4>
                        <div class="input-group">

                            <select id="texttoolbox_font" style="width: calc(100% - 40px);">
                                <option value="Times New Roman">Times New Roman</option>
                                <option value="Pacifico">Pacifico</option>
                                <option value="VT323">VT323</option>
                                <option value="Quicksand">Quicksand</option>
                                <option value="Inconsolata">Inconsolata</option>
                            </select>
                        </div>
                    </div>
                    <div class="message">
                    </div>




                    <h4 class="mt-3 mb-2">Upload your logo</h4>



                    <div class="album-wrapper">
                        <div class="upload-img">
                            <div class="btn-group m-auto">
                                <div class="add_image btn-group">
                                    <iframe id="ifr_upload" name="ifr_upload" height="0" width="0"
                                        frameborder="0"></iframe>
                                    <form id="frm_upload" action="" method="post"
                                        enctype="multipart/form-data" target="ifr_upload">
                                        <label class="btn btn-default btn-file active"
                                            style="    border-top-right-radius: 0;border-bottom-right-radius: 0;width: 55px;">
                                            <img src="{{ asset('custom/images/sticky-note_11737499.png') }}"
                                                width="24" alt=""></i><input type="file"
                                                name="image_upload" accept=".gif,.jpg,.jpeg,.png,.ico">
                                        </label>
                                    </form>
                                </div>
                                <div class="btn">
                                    <!-- <input type="radio" name="form_shirt_side" width="24" height="24" value="" autocomplete="off" /> -->
                                    <img src="{{ asset('custom/images/image_12649310.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="album" id="albumModal">
                            <a href="#" class="album-item">
                                <div style="background-image: url({{ asset('custom/images/logo.png') }})"><img
                                        bgsrc="{{ asset('custom/images/logo.png') }}"
                                        src="{{ asset('custom/images/blank.png') }}" /></div>
                            </a>
                            <a href="#" class="album-item">
                                <div style="background-image: url({{ asset('custom/images/logo.png') }})"><img
                                        bgsrc="{{ asset('custom/images/logo.png') }}"
                                        src="{{ asset('custom/images/blank.png') }}" /></div>
                            </a>
                            <a href="#" class="album-item">
                                <div style="background-image: url({{ asset('custom/images/logo.png') }})"><img
                                        bgsrc="{{ asset('custom/images/logo.png') }}"
                                        src="{{ asset('custom/images/blank.png') }}" /></div>
                            </a>
                            <a href="#" class="album-item">
                                <div style="background-image: url({{ asset('custom/images/logo.png') }})"><img
                                        bgsrc="{{ asset('custom/images/logo.png') }}"
                                        src="{{ asset('custom/images/blank.png') }}" /></div>
                            </a>
                            <a href="#" class="album-item">
                                <div style="background-image: url({{ asset('custom/images/logo.png') }})"><img
                                        bgsrc="{{ asset('custom/images/logo.png') }}"
                                        src="{{ asset('custom/images/blank.png') }}" /></div>
                            </a>
                            <a href="#" class="album-item">
                                <div style="background-image: url({{ asset('custom/images/logo.png') }})"><img
                                        bgsrc="{{ asset('custom/images/logo.png') }}"
                                        src="{{ asset('custom/images/blank.png') }}" /></div>
                            </a>


                        </div>

                    </div>


                    <h4 class="mt-3 mb-3">Image dimensions</h4>

                    <div class="cvtoolbox">
                        <div class="d-flex">
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
                        <div class="d-flex">
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
                        <div class="d-flex">
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

                    <div class="save" style="margin-top: 32px;">Save</div>
                </div>
            </div>
        </div>

    </div>


    <!-- Preview Modal -->
    <div id="reviewModal" class="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <div class="modal-body">
                    <div class="shirt"><img src="" /></div>
                    <div class="shirtdesign"><img src="" /></div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modal Heading</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="product-images"
                        style="display: flex; justify-content: space-between; align-items: center;">
                        <!-- صورة الأمام -->
                        <img id="front-image" src="front_image_url.jpg" alt="Front Image" class="front-image"
                            style="width: 48%; height: auto;" />

                        <!-- صورة الخلف -->
                        <img id="back-image" src="back_image_url.jpg" alt="Back Image" class="back-image"
                            style="width: 48%; height: auto;" />
                    </div>
                    <div id="product-details row" style="text-align: center">
                        <p><strong>Price:</strong> <span id="product-price"></span></p>
                        <p><strong>Size:</strong> <span id="product-size"></span></p>
                        <p><strong>Material:</strong> <span id="product-material"></span></p>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript" src="{{ asset('custom/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('custom/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('custom/js/placeholders.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('custom/js/bootstrap-colorpicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('custom/js/fabric4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('custom/js/fontfaceobserver.js') }}"></script>
    <script type="text/javascript" src="{{ asset('custom/js/merge-images.js') }}"></script>
    <script type="text/javascript" src="{{ asset('custom/js/main.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var productId = {{ $product->id }};
        var price = {{ $product->price }}
        window.onload = function() {
            get_price();

        };

        function loadProductData() {

            $.ajax({
                url: '/peconfirm-order',
                method: 'GET',
                success: function(response) {
                    if (response.code == 404) {
                        Swal.fire({
                            title: response.error,
                            icon: 'error',
                        });
                    } else {

                        // Set the image sources
                        $('#front-image').attr('src', response
                            .front_image); // front_image is the field from the database
                        $('#back-image').attr('src', response
                            .back_image); // back_image is the field from the database

                        // Set product details
                        // $('#product-price').text('20');
                        // $('#product-size').text('sm');
                        // $('#product-material').text('cotton');
                        $('#myModal').modal('show');

                    }
                },
                error: function(i) {
                    console.error();
                }
            });
        }

        function get_price() {
            var havesize = $('#have_size').val();
            let sizePrice = 0;

    if(havesize == 0){
            let sizePrice = 0;
    }else{
        var size = document.querySelector('.size .active');
            let sizePrice = size.getAttribute('data-price');
            let sizeName = size.getAttribute('data-name');
    }
    
            let material = document.querySelector('.material .active');
            let materialname = material.getAttribute('data-material');

            let product_price = {{ $product->price }};
            var color = document.querySelector('input[name=form_shirt_color]:checked'); // Get the selected color ID
            let colorPrice = color.getAttribute('data-price');
            var peaceprice = parseFloat(sizePrice) + parseFloat(colorPrice) + parseFloat(product_price);
            const main_price = document.getElementById('main_price');
            const total_price = document.getElementById('total_price');
            const qty = document.getElementById('qty');


            total_price.textContent = '';
            main_price.textContent = '';
            total_price.textContent = parseFloat(peaceprice * qty.value) + '.00';

            main_price.textContent = parseFloat(peaceprice) + '.00';
            var pp = $('#main_price_input').val(parseFloat(peaceprice) + '.00');

            $('#product-price').text(parseFloat(peaceprice) + '.00');
            if(havesize != 0){

            $('#product-size').text(sizeName);
            }
            $('#product-material').text(materialname);


        }
    </script>


</body>

</html>
