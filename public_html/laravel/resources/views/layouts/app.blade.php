<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $template = App\Models\Template::where('id','<>','~')->first();
    @endphp
    <title>{{$template->nama}}</title>
    <link href="{{ asset('layout/skydash/images/faviconrb.png') }}" rel="icon">

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('image/global/logo.png') }}" class="logo-login" alt=""> Santriku
                </a>
            </div>
        </nav>
        
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Global JS -->
    <script src="{{ asset('js/global.js') }}"></script>
    <!-- jQuery -->
    <!-- <script src="{{ asset('layout/adminlte3/plugins/jquery/jquery.min.js') }}"></script> -->

</body>
</html>
