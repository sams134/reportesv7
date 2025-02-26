<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
    <script>
        var navbarStyle = localStorage.getItem("navbarStyle");


        document.querySelector('.navbar-vertical').classList.add(`navbar-vibrant`);
    </script>
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">

            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
                data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span
                        class="toggle-line"></span></span></button>

        </div><a class="navbar-brand" href="{{ route('dashboard') }}">
            <div class="d-flex align-items-center py-3"><span class="font-sans-serif">CME-AMIR</span>
            </div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                <li class="nav-item">
                    <!-- parent pages--><a class="nav-link dropdown-indicator" href="#dashboard" role="button"
                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="dashboard">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-chart-pie"></span></span><span
                                class="nav-link-text ps-1">Dashboard</span>
                        </div>
                    </a>
                    <ul class="nav collapse false" id="dashboard">
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}" aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Warroom</span>
                                </div>
                            </a>
                            <!-- more inner pages-->
                        </li>

                    </ul>
                </li>

                @php
                    $user = Auth::user();
                @endphp

                @if(in_array($user->userType, [\App\Models\User::DEVELOPER, \App\Models\User::OFICINA, \App\Models\User::ADMIN]))
                    <li class="nav-item">
                        <!-- label-->
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <div class="col-auto navbar-vertical-label">Clientes
                            </div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider" />
                            </div>
                        </div>
                        <!-- parent pages--><a class="nav-link" href="{{ route('clientes.index') }}" role="button"
                            aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        class="fas fa-users"></span></span><span class="nav-link-text ps-1">Clientes</span>
                            </div>
                        </a>
                        <!-- parent pages--><a class="nav-link" href="#" role="button" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        class="fas fa-user-plus"></span></span><span class="nav-link-text ps-1">Agregar
                                    Clientes</span>
                            </div>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <!-- label-->
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Motores 
                        </div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                    <!-- parent pages--><a class="nav-link" href="{{ route('motores.index') }}" role="button"
                        aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-cogs"></span></span><span class="nav-link-text ps-1">Ver
                                Motores</span>
                        </div>
                    </a>
                    @if(in_array($user->userType, [\App\Models\User::DEVELOPER, \App\Models\User::OFICINA, \App\Models\User::ADMIN, \App\Models\User::PRUEBAS]))
                    <!-- parent pages--><a class="nav-link" href="{{ route('motores.create') }}" role="button"
                        aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-plus-circle"></span></span><span class="nav-link-text ps-1">Agregar
                                nuevo equipo</span>
                        </div>
                    </a>
                    @endif
                </li>
                @livewire('boards.boards-navigation')
                @if(in_array($user->userType, [\App\Models\User::DEVELOPER, \App\Models\User::OFICINA, \App\Models\User::ADMIN, \App\Models\User::PRUEBAS,\App\Models\User::TORNOS]))
                <li class="nav-item">
                  <!-- label-->
                  <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                      <div class="col-auto navbar-vertical-label">Metalizado en fr&iacute;o
                      </div>
                      <div class="col ps-0">
                          <hr class="mb-0 navbar-vertical-divider" />
                      </div>
                  </div>
                  <!-- parent pages--><a class="nav-link" href="{{ route('metalizados.index') }}" role="button"
                      aria-expanded="false">
                      <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                  class="fas fa-users"></span></span><span class="nav-link-text ps-1">Ver Metalizados</span>
                      </div>
                  </a>
                  <!-- parent pages--><a class="nav-link" href="#" role="button" aria-expanded="false">
                      <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                  class="fas fa-user-plus"></span></span><span class="nav-link-text ps-1">Agregar Metalizado</span>
                      </div>
                  </a>
              </li>
              @endif
                <li class="nav-item">
                    <!-- label-->
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Calculos
                        </div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                     <!-- parent pages--><a class="nav-link dropdown-indicator" href="#user" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="user">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calculator"></span></span><span class="nav-link-text ps-1">Calculos Importantes</span>
                        </div>
                      </a>
                      <ul class="nav collapse false" id="user">
                        <li class="nav-item"><a class="nav-link" href="{{route('calculos.ajustes')}}" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Ajustes en tapaderas y ejes</span>
                            </div>
                          </a>
                          <!-- more inner pages-->
                        </li>
                        <li class="nav-item"><a class="nav-link" href="../pages/user/settings.html" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Uso de C3/C4</span>
                            </div>
                          </a>
                          <!-- more inner pages-->
                        </li>
                        <li class="nav-item"><a class="nav-link" href="../pages/user/settings.html" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Calibre Cable de Salida</span>
                            </div>
                          </a>
                          <!-- more inner pages-->
                        </li>
                        <li class="nav-item"><a class="nav-link" href="../pages/user/settings.html" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Conexiones</span>
                            </div>
                          </a>
                          <!-- more inner pages-->
                        </li>
                      </ul>

                </li>

                <li class="nav-item">
                    <!-- label-->
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">CME-AMIR
                        </div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                    <!-- parent pages--><a class="nav-link" href="{{route('admin.produccion')}}" 
                        role="button" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fas fa-rocket"></span></span><span class="nav-link-text ps-1">Produccion y Horas</span>
                        </div>
                    </a>
                  
                    <!-- parent pages--><a class="nav-link" href="../../../documentation/gulp.html" role="button"
                        aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    class="fab fa-gulp"></span></span><span class="nav-link-text ps-1">Solicitar Viaticos</span>
                        </div>
                    </a>

                </li>

                
                <li class="nav-item">
                    <!-- label-->
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Cuenta
                        </div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                    <!-- parent pages-->
                    <a class="nav-link" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-horse"></span></span>
                            <span class="nav-link-text ps-1">Cerrar Sesi&oacute;n</span>
                        </div>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>



                </li>
            </ul>
            <div class="settings mb-3">
                <div class="card alert p-0 shadow-none" role="alert">
                    <div class="btn-close-falcon-container">
                        <div class="btn-close-falcon" aria-label="Close" data-bs-dismiss="alert"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>
