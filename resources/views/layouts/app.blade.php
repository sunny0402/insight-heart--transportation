<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HeartsOnWheels') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- jquery datepicker -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('template/dist/css/theme.min.css')}}">
    <!-- style for datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css">

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white margin-1rem">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/ihg-logo.svg" class="ihg-logo" />

                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- if user logged in and if user a client -->
                        @if(auth()->check() && auth()->user()->role->name === 'client')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('my.booking')}}">
                                {{ __('My Booking')}}</a>
                        </li>
                        @endif
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link secondary-link" href="{{ route('login') }}">{{ __('LOGIN') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link primary-action-btn" href="{{ route('register') }}">{{ __('BOOK FOR FREE') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if(auth()->check() && auth()->user()->role->name === 'client')
                                <a href="{{url('user-profile')}}" class="dropdown-item">Profile</a>
                                @else
                                <a href="{{url('dashboard')}}" class="dropdown-item">Dashboard</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>






    <!-- jquery datepicker -->
    <script>
        // format date same as in database
        var dateToday = new Date();
        $(function() {
            $("#datepicker").datepicker({
                dateFormat: "yy-mm-dd",
                showButtonPanel: true,
                numberOfMonths: 2,
                minDate: dateToday,
            });
        });
    </script>
    <style type="text/css">
        body {
            background: white;
            font-family: 'Poppins', sans-serif;        
        }


        .ui-corner-all {
            background: red;
            color: #fff
        }

        label.btn {
            padding: 0;
        }

        label.btn input {
            opacity: 0;
            position: absolute;
        }

        label.btn span {
            text-align: center;
            padding: 6px 12px;
            display: block;
            min-width: 80px;
        }

        label.btn input:checked+span {
            background-color: rgb(80, 110, 228);
            color: #fff;
        }

        .hasDatepicker {
            box-shadow: none !important;
            font-size: 1rem;
            border: 1px solid black;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .ig-go-container {
            padding-bottom: 2rem;
        }

        .text-header-three {
            font-weight: 600 !important;
            font-size: 1.5rem !important;
        }


        @media only screen and (max-width: 600px) {
            *, *::before, *::after {
            box-sizing: inherit;
            }
        }
    </style>


</body>

</html>