<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css')}}" rel="stylesheet') }}" rel="stylesheet>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
        <link rel="stylesheet" href="{{ asset('css/user.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/config.js') }}"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>
    </head>
    <body class="">
        <main class="main" id="top">
            <div class="container-fluid">
                <div class="row min-vh-100 bg-100">
                    <div class="col-6 d-none d-lg-block position-relative">
                      <div class="bg-holder" style="background-image:url({{asset('img/generic/_MG_8308.jpg')}});background-position: 50% 20%;">
                      </div>
                      <!--/.bg-holder-->
          
                    </div>
        {{ $slot }}
                </div>
            </div>
        </main>
        <script src="{{asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{asset('vendors/is/is.min.js') }}"></script>
    <script src="{{asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{asset('vendors/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{asset('js/theme.js') }}"></script>
    </body>
</html>