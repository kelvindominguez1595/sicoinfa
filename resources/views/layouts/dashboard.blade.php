<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SICOINFA') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    @yield('css')
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
</head>
<body class="disable-select">
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light shadow-lg  bg-body mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{asset('images/logoFerreteria.png')}}" class="img-fluid" width="30px" height="30px" id="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                @include('layouts.nav')
            </div>
        </div>
    </nav>
    <p></p>
    <main class="container-fluid mt-5 pt-5">
        @yield('content')
    </main>

    <!-- Scripts -->
    <!-- Optional JavaScript; choose one of the two! -->
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/alertas.js') }}" ></script>
    <script src="{{ asset('js/toastr_notifications.js') }}" ></script>
    <script src="{{ asset('js/sweetalert/sweetalert.js') }}"></script>
    <script src="{{ asset('js/loadingoverlay.min.js') }}"></script>
    <script>

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>


    @yield('js')
</body>
</html>
