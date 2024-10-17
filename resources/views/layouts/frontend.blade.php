<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ get_general_value('website_name')  }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="apple-touch-icon" href="{{ asset('uploads/' . get_general_value('website_icon')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/' . get_general_value('website_icon')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        
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


    </style>
    @yield('style')
</head>

<body>



    <div class="container" id="">
        {{-- <div class="nav d-flex align-items-center justify-content-between p-3 mb-4" style="border-bottom: 1px solid #ececec;">
            <div class="logo">
              <a href="/"> <img src="{{ asset('uploads/' . get_general_value('website_logo')) }}" width="147" height="47" alt="">
              </a>             </div>
        
            <div class="input" style="flex-grow: .7;">
                <input class="form-control" type="text" name="" id="" placeholder="Search here..." style="height: 48px; border-radius: 12px;">
            </div>
        
            <div class="notify d-flex align-items-center" style="flex-grow: .1;">
                <a href="#"><i class="fa fa-bill"></i></a>
                <img src="{{ asset('frontend/images/phone.png') }}" width="48" height="48" alt="" class="m-2">
                <img src="{{ asset('frontend/images/notify.png') }}" width="48" height="48" alt="" class="m-2">
            </div>
        
            @auth('client')
            <div class="dropdown">
                <img src="{{ asset('frontend/images/man_146018.png') }}" width="48" height="48" alt="" class="dropdown-toggle" data-bs-toggle="dropdown" style="cursor: pointer;">
                
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('client.dashboard') }}">الملف الشخصي</a></li>
                    <li><hr class="dropdown-divider"></li>
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
        </div> --}}
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



    </div>
    @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('script')
</body>

</html>
