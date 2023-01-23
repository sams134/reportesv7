<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
   {{--  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet"> --}}
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('js/config.js') }}"></script>
    <!-- Styles -->
   
   {{--  <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet"> --}}
        <link href="{{ asset('vendors/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}"  rel="stylesheet">
        <link href=" {{ asset('vendors/dropzone/dropzone.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
   

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('css')
    @livewireStyles

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/fontawesome.min.js"
    
        integrity="sha512-PoFg70xtc+rAkD9xsjaZwIMkhkgbl1TkoaRrgucfsct7SVy9KvTj5LtECit+ZjQ3ts+7xWzgfHOGzdolfWEgrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
   
    <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>

</head>

<body>

    {{-- <main >
        <x-jet-banner />
        @livewire('navigation-menu')

        <!-- Page Heading -->
        <header class="d-flex py-3 bg-white shadow-sm border-bottom">
            <div class="container">
                {{ $header }}
            </div>
        </header> --}}

    <!-- Page Content -->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var container = document.querySelector('[data-layout]');
                container.classList.remove('container');
                container.classList.add('container-fluid');
            </script>
            {{-- Side Menu --}}

            @livewire('navigation-menu')
            {{-- Side Menu --}}

            <div class="content">
                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse"
                        aria-controls="navbarVerticalCollapse" aria-expanded="false"
                        aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                                class="toggle-line"></span></span></button>
                    <a class="navbar-brand me-1 me-sm-3" href="../../index.html">
                        <div class="d-flex align-items-center"><span class="font-sans-serif">Reportes</span>
                        </div>
                    </a>
                    <ul class="navbar-nav align-items-center d-none d-lg-block">
                        <li class="nav-item">


                          @livewire('search.searchbox')
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">


                        <li class="nav-item dropdown">
                           {{--  @livewire('u-i.profile-dropdown') --}}
                        </li>
                    </ul>
                </nav>
                @if (session()->has('success'))
                    <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
                        <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span>
                        </div>
                        <p class="mb-0 flex-1"> {{ session()->get('success') }}</p>
                        <button class="btn-close" type="button" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                   
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                                <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
                                <p class="mb-0 flex-1">{{$error}}</p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>
                            @endforeach
                     
                @endif
                {{ $slot }}

            </div>
        </div>
    </main>


   

    @stack('modals')

    @livewireScripts
    @stack('livescripts')

    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/rater-js/index.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('vendors/echarts/echarts.min.js') }}"></script>
    <script src="{{asset('vendors/countup/countUp.umd.js')}}"></script>
    
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
    
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
    @yield('js')

    

</body>

</html>
