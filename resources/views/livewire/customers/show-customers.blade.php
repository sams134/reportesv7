<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <x-page-title>
        <x-slot:title>{{ $cliente->cliente }}</x-slot:title>
        Vea la informacion del cliente.
    </x-page-title>
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="bg-holder d-none d-lg-block bg-card"
                    style="background-image:url(/img/icons/spot-illustrations/corner-2.png);">
                </div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <div class="row">
                        <h3>DATOS DEL CLIENTE</h3>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">Cliente
                                <span>{{ $cliente->cliente }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">Razon
                                Social<span>
                                    {{ $cliente->info_cliente->razon_social }}</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Nit<span>{{ $cliente->info_cliente->nit }}</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">Direccion
                                Fiscal<span>{{ $cliente->info_cliente->direccion_fiscal }}</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">Direccion
                                Planta<span>{{ $cliente->info_cliente->direccion_planta }}</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Ubicacion<span>{{ $cliente->ciudad }},{{ $cliente->pais }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <x-pretty-card>
                <h3>Informacion del Cliente</h3>
                @if ($cliente->info_cliente->comentarios != '')
                    {!! $cliente->info_cliente->comentarios !!}
                @else
                    No hay informacion del cliente
                @endif

            </x-pretty-card>
            <div class="card mb-3">
                <div class="card-body">
                    <button class="btn btn-outline-primary me-1 mb-1" type="button">Agregar Equipo
                    </button>
                    <a class="btn btn-outline-info me-1 mb-1" type="button"
                        href="{{ route('clientes.edit', $cliente) }}">Editar Cliente
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card bg-soft-primary mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h2 class="text-primary fw-bold">{{ $cliente->motors_count }}</h2>
                            <h4 class="text-primary">
                                Equipos Ingresados a reparacion
                            </h4>
                        </div>
                        <div class="col-2">
                            <i class="far fa-folder text-facebook " style="font-size:80px"></i>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card bg-soft-primary mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h2 class="text-primary fw-bold">{{ $cliente->motors_count }}</h2>
                            <h4 class="text-primary">
                                Equipos en proceso
                            </h4>
                        </div>
                        <div class="col-2">
                            <i class="fas fa-wrench text-facebook " style="font-size:80px"></i>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <canvas class="0" id="grafica" width="418px" height="150px"></canvas>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h3>Contactos</h3>
                        @livewire('customers.create-contact', ['id_cliente' => $cliente->id_cliente])

                    </div>

                    <div class="table-responsive scrollbar">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Puesto</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Usuario Sistema</th>
                                    <th scope="col">Herramientas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cliente->contactos as $contacto)
                                    <tr class="hover-actions-trigger">
                                        <td class="align-middle text-nowrap">
                                            {{ $contacto->contacto }}
                                        </td>
                                        <td class="align-middle text-nowrap">{{ $contacto->puesto }}</td>
                                        <td class="w-auto">
                                            {{ $contacto->telefono }}
                                        </td>
                                        <td class="align-middle text-nowrap">{{ $contacto->email }}</td>
                                        <td class="align-middle">
                                            @if ($contacto->user)
                                                <div class="d-flex flex-column">
                                                    <span class="badge bg-success mb-1">
                                                        {{ $contacto->user->username }}
                                                    </span>

                                                    <small class="text-muted">
                                                        Último login:
                                                        @if ($contacto->user->last_login_at)
                                                            {{ $contacto->user->last_login_at->format('d/m/Y h:i A') }}
                                                        @else
                                                            Nunca ha ingresado
                                                        @endif
                                                    </small>
                                                </div>
                                            @else
                                                <button type="button" class="btn btn-falcon-success btn-sm"
                                                    wire:click="openCreateClientUser({{ $contacto->id }})"
                                                    @if (!$contacto->email) disabled @endif>
                                                    <i class="fas fa-user-plus me-1"></i>
                                                    Crear usuario
                                                </button>

                                                @if (!$contacto->email)
                                                    <div>
                                                        <small class="text-danger">
                                                            El contacto necesita email.
                                                        </small>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-inline-flex">
                                                <button class="btn btn-danger me-1 mb-1" type="button"
                                                    onclick="deleteContact({{ $contacto->id }})">
                                                    <i class="far fa-trash-alt me-1"></i>
                                                </button>
                                                @livewire('customers.edit-contact', ['contacto' => $contacto], key($contacto->id))
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h3>Equipos Ingresados</h3>
                    <span wire:loading> Loading</span>
                    <div class="px-2"> {{ $motores->withQueryString()->links() }}</div>
                    <div class="table-responsive scrollbar">
                        <table class="table table-hover table-striped overflow-hidden fs--1" style="font-size: 0.5rem"
                            wire:loading.remove>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th style="width:1rem"></th>
                                    <th class="sort" style="width:13%;cursor: pointer;" wire:click="sortBy('fullos')">
                                        Orden de Servicio
                                        <i
                                            class="fa {{ $sort === 'fullos' ? 'fa-sort-' . ($direction === 'asc' ? 'up' : 'down') : 'fa-sort' }} {{ $sort === 'fullos' ? 'text-success' : '' }}"></i>
                                    </th>
                                    <th class="sort" style="width:11%;cursor: pointer;" wire:click="sortBy('hp')">
                                        Potencia
                                        <i
                                            class="fa {{ $sort === 'hp' ? 'fa-sort-' . ($direction === 'asc' ? 'up' : 'down') : 'fa-sort' }} {{ $sort === 'hp' ? 'text-success' : '' }}"></i>
                                    </th>
                                    <th class="sort d-none d-xl-table-cell" wire:click="sortBy('rpm')">
                                        Rpm
                                        <i
                                            class="fa {{ $sort === 'rpm' ? 'fa-sort-' . ($direction === 'asc' ? 'up' : 'down') : 'fa-sort' }} {{ $sort === 'rpm' ? 'text-success' : '' }}"></i>
                                    </th>
                                    <th class="sort" wire:click="sortBy('status_id')">
                                        Status
                                        <i
                                            class="fa {{ $sort === 'status_id' ? 'fa-sort-' . ($direction === 'asc' ? 'up' : 'down') : 'fa-sort' }} {{ $sort === 'status_id' ? 'text-success' : '' }}"></i>
                                    </th>
                                    <th>Tecnicos</th>
                                    <th scope="col">Fecha Ingreso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($motores as $cont => $motor)
                                    <tr class="hover-actions-trigger">
                                        <td class="align-middle text-nowrap" style="width: 80px">
                                            {{ $cont + 1 }}
                                        </td>
                                        <td>
                                            <div class="col-auto">
                                                @if ($motor->fotos && $motor->fotos->count() > 0 && Storage::exists('public' . $motor->fotos->first()->thumb))
                                                    <div class="avatar avatar-2xl ">
                                                        <img class="rounded-circle"
                                                            src="{{ asset('storage' . $motor->fotos->first()->thumb) }}"
                                                            alt="" style="transition: transform 0.3s;"
                                                            onmouseover="this.style.transform='scale(1.9)';"
                                                            onmouseout="this.style.transform='scale(1)';" />
                                                    </div>
                                                @else
                                                    <div class="avatar avatar-2xl ">
                                                        <img class="rounded-circle"
                                                            src="{{ asset('img/default-avatar.png') }}"
                                                            alt="No hay foto" />
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="align-middle text-nowrap"><a
                                                href="{{ route('motores.show', $motor) }}">
                                                {{ $motor->year }}-{{ $motor->os }}</a>
                                        </td>
                                        <td class="w-auto">{{ $motor->potencia }}</td>
                                        <td class="align-middle text-nowrap">{{ $motor->rpm }}</td>
                                        <td class="align-middle ">
                                            <button data-bs-toggle="modal" data-bs-target="#error-modal"
                                                class="bg-transparent border-0"
                                                wire:click="loadStatusModal({{ $motor->id_motor }})">
                                                <x-status-badge status_id="{{ $motor->status_id }}"
                                                    data-bs-toggle="modal" data-bs-target="#error-modal" />
                                            </button>
                                        </td>
                                        <td>
                                            <!-- Al hacer clic, se emite el evento 'openAsignacionesModal' con el id del motor -->

                                            @foreach ($motor->tecnicos as $tecnico)
                                                <div class="avatar avatar-l">

                                                    <img src="{{ asset('storage/' . $tecnico->foto) }}"
                                                        alt="" class="rounded-circle mt-2">

                                                </div>
                                            @endforeach

                                        </td>
                                        <td class="align-middle text-nowrap">
                                            {{ Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}
                                        </td>

                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <x-status-modal :statuses="$statuses" :equipo="$equipo" />
    </div>

    {{-- Modals --}}
    <div wire:ignore.self class="modal fade" id="createClientUserModal" tabindex="-1"
        aria-labelledby="createClientUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form wire:submit.prevent="createClientUser" class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createClientUserModalLabel">
                        Crear usuario para cliente
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @error('clientUser')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="mb-3">
                        <label class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control @error('clientUsername') is-invalid @enderror"
                            wire:model.defer="clientUsername">

                        @error('clientUsername')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Clave temporal</label>
                        <input type="password" class="form-control @error('clientPassword') is-invalid @enderror"
                            wire:model.defer="clientPassword">

                        @error('clientPassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            Mínimo 6 caracteres.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Revisar clave</label>
                        <input type="password"
                            class="form-control @error('clientPasswordConfirmation') is-invalid @enderror"
                            wire:model.defer="clientPasswordConfirmation">

                        @error('clientPasswordConfirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-falcon-default" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            Crear usuario
                        </span>

                        <span wire:loading>
                            Creando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- modal bienvenida --}}
    <div wire:ignore.self class="modal fade" id="clientUserWelcomeModal" tabindex="-1"
        aria-labelledby="clientUserWelcomeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg overflow-hidden">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="clientUserWelcomeModalLabel">
                        Usuario creado correctamente
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-4xl mx-auto mb-3">
                            <div class="avatar-name rounded-circle bg-soft-success text-success">
                                <span>
                                    <i class="fas fa-user-check"></i>
                                </span>
                            </div>
                        </div>

                        <h3 class="mb-1">
                            Bienvenido al sistema CME
                        </h3>

                        <p class="text-muted mb-0">
                            Se ha creado el acceso temporal para el cliente.
                        </p>
                    </div>

                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <p class="mb-3">
                                Estimado/a <strong>{{ $welcomeName }}</strong>, ya puede ingresar al sistema usando la
                                siguiente información:
                            </p>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label text-muted">URL de acceso</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-link"></i>
                                        </span>
                                        <input type="text" class="form-control" value="{{ $welcomeUrl }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Usuario</label>
                                    <input type="text" class="form-control" value="{{ $welcomeUsername }}"
                                        readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted">Clave temporal</label>
                                    <input type="text" class="form-control" value="{{ $welcomePassword }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="alert alert-info mt-4 mb-0">
                                Al ingresar, podrá cambiar su contraseña y fotografía desde su perfil.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                        Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('vendors/chart/chart.min.js') }}"></script>
    <script>
        var chartLine = function chartLine() {
            var line = document.getElementById('grafica');

            // Llamamos al backend para obtener los datos de motores por año
            fetch('/api/motors-by-year/' +
                    {{ $cliente->id_cliente }}) // Llamada a la ruta donde está el método del controlador
                .then(response => response.json())
                .then(data => {
                    // Actualiza el gráfico con los datos obtenidos
                    var getOptions = function getOptions() {
                        return {
                            type: 'bar',
                            data: {
                                labels: data.years, // Años obtenidos del backend
                                datasets: [{
                                    type: 'line',
                                    label: 'Cantidad de Motores',
                                    borderColor: utils.getColor('primary'),
                                    borderWidth: 2,
                                    fill: false,
                                    data: data.motor_counts, // Cantidad de motores por año
                                    tension: 0.3
                                }]
                            },
                            options: {
                                plugins: {
                                    tooltip: chartJsDefaultTooltip()
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            color: utils.rgbaColor(utils.getGrays().black, 0.1)
                                        }
                                    },
                                    y: {
                                        grid: {
                                            color: utils.rgbaColor(utils.getGrays().black, 0.1)
                                        }
                                    }
                                }
                            }
                        };
                    };

                    chartJsInit(line, getOptions);
                })
                .catch(error => console.error('Error:', error));
        };

        var chartJsInit = function chartJsInit(chartEl, config) {
            if (!chartEl) return;
            var ctx = chartEl.getContext('2d');
            var chart = new window.Chart(ctx, config());
            var themeController = document.body;
            themeController.addEventListener('clickControl', function(_ref14) {
                var control = _ref14.detail.control;

                if (control === 'theme') {
                    chart.destroy();
                    chart = new window.Chart(ctx, config());
                }

                return null;
            });
        };
        var docReady = function docReady(fn) {
            // see if DOM is already available
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', fn);
            } else {
                setTimeout(fn, 1);
            }
        };
        docReady(chartLine);
    </script>
    <script>
        window.addEventListener('open-create-client-user-modal', function() {
            var modalEl = document.getElementById('createClientUserModal');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        });

        window.addEventListener('close-create-client-user-modal', function() {
            var modalEl = document.getElementById('createClientUserModal');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();
        });

        window.addEventListener('open-client-user-welcome-modal', function() {
            var modalEl = document.getElementById('clientUserWelcomeModal');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        });
    </script>
</div>
