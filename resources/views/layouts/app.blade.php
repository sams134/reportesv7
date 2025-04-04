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
    @stack('css')
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
                    <ul class="navbar-nav align-items-center d-none d-lg-block" style="width:600px">
                        <li class="nav-item">
                          @livewire('search.searchbox')
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                        <li class="nav-item">
                          <div class="theme-control-toggle fa-icon-wait px-2">
                            <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="theme" value="dark" />
                            <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to light theme"><span class="fas fa-sun fs-0"></span></label>
                            <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to dark theme"><span class="fas fa-moon fs-0"></span></label>
                          </div>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link px-0 notification-indicator notification-indicator-warning notification-indicator-fill fa-icon-wait" href="../app/e-commerce/shopping-cart.html"><span class="fas fa-shopping-cart" data-fa-transform="shrink-7" style="font-size: 33px;"></span><span class="notification-indicator-number">1</span></a>
          
                        </li>
                        {{-- <li class="nav-item dropdown">
                          <a class="nav-link notification-indicator notification-indicator-primary px-0 fa-icon-wait" id="navbarDropdownNotification" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-bell" data-fa-transform="shrink-6" style="font-size: 33px;"></span></a>
                          <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification" aria-labelledby="navbarDropdownNotification">
                            <div class="card card-notification shadow-none">
                              <div class="card-header">
                                <div class="row justify-content-between align-items-center">
                                  <div class="col-auto">
                                    <h6 class="card-header-title mb-0">Notifications</h6>
                                  </div>
                                  <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div>
                                </div>
                              </div>
                              <div class="scrollbar-overlay" style="max-height:19rem">
                                <div class="list-group list-group-flush fw-normal fs--1">
                                  <div class="list-group-title border-bottom">NEW</div>
                                  <div class="list-group-item">
                                    <a class="notification notification-flush notification-unread" href="#!">
                                      <div class="notification-avatar">
                                        <div class="avatar avatar-2xl me-3">
                                          <img class="rounded-circle" src="../assets/img/team/1-thumb.png" alt="" />
          
                                        </div>
                                      </div>
                                      <div class="notification-body">
                                        <p class="mb-1"><strong>Emma Watson</strong> replied to your comment : "Hello world 😍"</p>
                                        <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">💬</span>Just now</span>
          
                                      </div>
                                    </a>
          
                                  </div>
                                  <div class="list-group-item">
                                    <a class="notification notification-flush notification-unread" href="#!">
                                      <div class="notification-avatar">
                                        <div class="avatar avatar-2xl me-3">
                                          <div class="avatar-name rounded-circle"><span>AB</span></div>
                                        </div>
                                      </div>
                                      <div class="notification-body">
                                        <p class="mb-1"><strong>Albert Brooks</strong> reacted to <strong>Mia Khalifa's</strong> status</p>
                                        <span class="notification-time"><span class="me-2 fab fa-gratipay text-danger"></span>9hr</span>
          
                                      </div>
                                    </a>
          
                                  </div>
                                  <div class="list-group-title border-bottom">EARLIER</div>
                                  <div class="list-group-item">
                                    <a class="notification notification-flush" href="#!">
                                      <div class="notification-avatar">
                                        <div class="avatar avatar-2xl me-3">
                                          <img class="rounded-circle" src="../assets/img/icons/weather-sm.jpg" alt="" />
          
                                        </div>
                                      </div>
                                      <div class="notification-body">
                                        <p class="mb-1">The forecast today shows a low of 20&#8451; in California. See today's weather.</p>
                                        <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">🌤️</span>1d</span>
          
                                      </div>
                                    </a>
          
                                  </div>
                                  <div class="list-group-item">
                                    <a class="border-bottom-0 notification-unread  notification notification-flush" href="#!">
                                      <div class="notification-avatar">
                                        <div class="avatar avatar-xl me-3">
                                          <img class="rounded-circle" src="../assets/img/logos/oxford.png" alt="" />
          
                                        </div>
                                      </div>
                                      <div class="notification-body">
                                        <p class="mb-1"><strong>University of Oxford</strong> created an event : "Causal Inference Hilary 2019"</p>
                                        <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">✌️</span>1w</span>
          
                                      </div>
                                    </a>
          
                                  </div>
                                  <div class="list-group-item">
                                    <a class="border-bottom-0 notification notification-flush" href="#!">
                                      <div class="notification-avatar">
                                        <div class="avatar avatar-xl me-3">
                                          <img class="rounded-circle" src="../assets/img/team/10.jpg" alt="" />
          
                                        </div>
                                      </div>
                                      <div class="notification-body">
                                        <p class="mb-1"><strong>James Cameron</strong> invited to join the group: United Nations International Children's Fund</p>
                                        <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">🙋‍</span>2d</span>
          
                                      </div>
                                    </a>
          
                                  </div>
                                </div>
                              </div>
                              <div class="card-footer text-center border-top"><a class="card-link d-block" href="../app/social/notifications.html">View all</a></div>
                            </div>
                          </div>
          
                        </li> --}}
                        <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-xl">
                              <img class="rounded-circle" src="{{asset('storage/' .Auth::user()->foto )}}" alt="{{ Auth::user()->name }}" />
          
                            </div>
                          </a>
                          <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                            <div class="bg-white dark__bg-1000 rounded-2 py-2">
                             
                              
                              <a class="dropdown-item" href="{{route('profile.show')}}">Perfil de Usuario</a>
                              <a class="dropdown-item" href="#!">Feedback</a>
          
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="#">Configuraciones</a>
                              <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesi&oacute;n</a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            </div>
                          </div>
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
