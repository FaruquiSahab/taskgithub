<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts And Links -->



        <!-- jQuery -->
        <script type="text/javascript" language="javascript" src="{{ asset('jquery/jquery-3.4.1.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('jquery/jquery-ui.css') }}" type="text/css" media="all">
        <!--  -->

        <!-- BootStrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <!--  -->

        <!-- DataTables -->
        <link rel="stylesheet" type="text/css" href="{{ asset('datatables/datatables.min.css') }}">
        <script type="text/javascript"  src="{{ asset('datatables/datatables.min.js') }}"></script>
        <!--  -->
        
        
        <!-- HighCharts -->
        <script type="text/javascript" language="javascript" src="{{ asset('highcharts/code/highcharts.js') }}"></script>
        <script type="text/javascript" language="javascript" src="{{ asset('highcharts/code/modules/exporting.js') }}"></script>
        <script type="text/javascript" language="javascript" src="{{ asset('highcharts/code/modules/export-data.js') }}"></script>
        <!--  -->

        <!-- Toastr -->
        <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}" type="text/css" media="all">
        <script type="text/javascript" language="javascript" src="{{ asset('toastr/toastr.min.js') }}"></script>
        <!--  -->

        <!-- External Javascript-->
        <script type="text/javascript" language="javascript" src="{{ asset('js/home.js') }}"></script>

        <!-- Laravel Javascript Validation -->
        <script type="text/javascript" language="javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
        <!-- Scripts And Links -->

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" type="text/css" href="{{ asset('font-awesome-4.7.0/css/font-awesome.min.css') }}">
        <!-- -->
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- if not sign in -->
                        @if(!Auth::check())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        {{-- when sign in --}}
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{-- if google user display image --}}
                                        @if(Auth::user()->avatar)
                                        <img src="{{ auth()->user()->avatar }}" alt="avatar" width="32" height="32" class="rounded-circle" style="margin-right: 8px;">
                                        @endif
                                    {{-- end --}}
                                    {{-- display user name --}}
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    {{-- end --}}
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ url('/home') }}">
                                            <i class="fa fa-home" aria-hidden="true"></i>
                                            Home
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('users.index') }}">
                                            <i class="fa fa-users" aria-hidden="true"></i>
                                            Profile
                                        </a>
                                    </li>
                                    <li>
                                        {{-- if 2af enabled --}}
                                        @if(Auth::user()->is_auth == 1)
                                            <a href="{{ url('2fa/disable/form') }}">
                                                <i class="fa fa-superpowers" aria-hidden="true"></i>
                                                Disable 2FA
                                            </a>
                                        {{-- if 2af disabled --}}
                                        @elseif(Auth::user()->is_auth == 0)
                                            <a href="{{ url('2fa/enable') }}" >
                                                <i class="fa fa-superpowers" aria-hidden="true"></i>
                                                Enable 2FA
                                            </a>
                                        @endif
                                        {{-- end --}}
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-power-off" aria-hidden="true"></i>
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        {{-- end --}}
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>


</body>
</html>
