<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <x-pretty-card>
        <h2>Listado General de Motores del usuario{{ auth()->user()->name }}
        </h2>
        Revisa todos los motores en el sistema
    </x-pretty-card>
    <x-pretty-card>
        <div class="d-flex">
            <a class="btn btn-outline-primary me-1 mb-1" type="button" href="{{ route('motores.create') }}">
                <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Nuevo Equipo
            </a>
            <div class="d-none d-sm-block">
                @livewire('motors.create-board')
            </div>

            @if ($boards->count() > 0)
                <div class="btn-group d-none d-sm-block">
                    <button class="btn dropdown-toggle mb-2 btn-success" type="button" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Agregar a tablero</button>
                    <div class="dropdown-menu">
                        @foreach ($boards as $board)
                            <a class="dropdown-item" href="#"
                                wire:click.prevent="addToBoard({{ $board->id }})">
                                {{ $board->name }}
                            </a>
                        @endforeach

                    </div>
                </div>
            @endif

            @if (in_array(auth()->user()->userType, [1, 2, 3]))
                <button class="btn btn-falcon-warning ms-2 mb-1 d-none d-sm-block" type="button"
                    wire:click="$emit('forceStatusChange')">
                    <span class="fas fa-exchange-alt me-1" data-fa-transform="shrink-3"></span>Forzar cambio de estado
                </button>
            @endif
        </div>




    </x-pretty-card>
    <div class="card" id="runningProjectTable">
        <div class="card-header">

            <div class="mb-0">
                <label class="form-label" for="basic-form-name">Busqueda de equipos</label>
                <input class="form-control" id="basic-form-name" type="text"
                    placeholder="Ingrese OS, nombre de equipo, cliente o t&eacute;cnico"
                    wire:model.live.debounce.500ms="search" />
            </div>
            <p>
                <a class="btn btn-falcon-default mt-2" data-bs-toggle="collapse" href="#collapseExample" role="button"
                    aria-expanded="false" aria-controls="collapseExample">Ver Busqueda Avanzada</a>

            </p>
            <div wire:ignore.self class="collapse" id="collapseExample">
                <div class="row">
                    <div class="col-xxl-6 col-lg-12">
                        <div class="card h-100">
                            <div class="bg-holder bg-card"
                                style="background-image:url(../assets/img/icons/spot-illustrations/corner-3.png);">
                            </div>
                            <!--/.bg-holder-->

                            <div class="card-header z-index-1">
                                <h5 class="text-primary">Busqueda Avanzada </h5>
                                <h6 class="text-600">Busca equipos por caracteristicas</h6>
                            </div>
                            <div class="card-body z-index-1">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="marca-label">Marca</span>
                                            <input type="text" class="form-control" placeholder="Ingrese la marca"
                                                aria-label="Marca" aria-describedby="marca-label"
                                                wire:model.live.debounce.500ms="s_marca" value="{{ request('marca') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="serie-label">Serie</span>
                                            <input type="text" class="form-control" placeholder="Ingrese la serie"
                                                aria-label="Serie" aria-describedby="serie-label"
                                                wire:model.live.debounce.500ms="s_serie" value="{{ request('serie') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="modelo-label">Modelo</span>
                                            <input type="text" class="form-control" placeholder="Ingrese el modelo"
                                                aria-label="Modelo" aria-describedby="modelo-label"
                                                wire:model.live.debounce.500ms="s_modelo"
                                                value="{{ request('modelo') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="rpm-label">RPM</span>
                                            <input type="text" class="form-control" placeholder="Ingrese las RPM"
                                                aria-label="RPM" aria-describedby="rpm-label"
                                                wire:model.live.debounce.500ms="s_rpm" value="{{ request('rpm') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="potencia-label">Potencia</span>
                                            <input type="text" class="form-control"
                                                placeholder="Ingrese la potencia" aria-label="Potencia"
                                                aria-describedby="potencia-label"
                                                wire:model.live.debounce.500ms="s_potencia">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="volts-label">Volts</span>
                                            <input type="text" class="form-control"
                                                placeholder="Ingrese los volts" aria-label="Volts"
                                                aria-describedby="volts-label"
                                                wire:model.live.debounce.500ms="s_volts">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="amps-label">Amps</span>
                                            <input type="text" class="form-control" placeholder="Ingrese los amps"
                                                aria-label="Amps" aria-describedby="amps-label"
                                                wire:model.live.debounce.500ms="s_amps">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="frame-label">Frame</span>
                                            <input type="text" class="form-control" placeholder="Ingrese el frame"
                                                aria-label="Frame" aria-describedby="frame-label"
                                                wire:model.live.debounce.500ms="s_frame">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="hac-label">HAC</span>
                                            <input type="text" class="form-control" placeholder="Ingrese el HAC"
                                                aria-label="HAC" aria-describedby="hac-label"
                                                wire:model.live.debounce.500ms="s_hac">
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" value="Buscar" class="btn btn-primary"
                                    onclick="console.log('clic en el botón')">
                            </div>


                        </div>

                    </div>
                    <div class="col-xxl-6 col-lg-12">
                        <div class="card h-100">
                            <div class="bg-holder bg-card"
                                style="background-image:url(../assets/img/icons/spot-illustrations/corner-3.png);">
                            </div>
                            <!--/.bg-holder-->

                            <div class="card-header z-index-1">
                                <h5 class="text-primary">Busqueda Avanzada </h5>
                                <h6 class="text-600">Busca equipos por caracteristicas</h6>
                            </div>
                            <div class="card-body z-index-1">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="marca-label">Potencia Mayor a:</span>
                                            <input type="text" class="form-control" placeholder="Ingrese la marca"
                                                aria-label="Marca" aria-describedby="marca-label"
                                                wire:model.live.debounce.500ms="s_pot_mayor"
                                                value="{{ request('marca') }}">
                                        </div>
                                         <div class="input-group mb-3">
                                            <span class="input-group-text" id="marca-label">Potencia Menor a:</span>
                                            <input type="text" class="form-control" placeholder="Ingrese la marca"
                                                aria-label="Marca" aria-describedby="s_pot_menor"
                                                wire:model.live.debounce.500ms="s_pot_menor"
                                                value="{{ request('marca') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>



        <x-pretty-card class="mt-1">

            <button class="btn btn-falcon-primary me-1 mb-1" type="button" wire:click="toggleView">
                @if ($cards)
                    <span class="fas fa-table me-1" data-fa-transform="shrink-3"></span>Vista Lista
                @else
                    <span class="fas fa-th-large me-1" data-fa-transform="shrink-3"></span>Vista Tarjetas
                @endif
            </button>
            <div class="btn-group dropend ">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Ver {{ $ver }}</button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" wire:click="$set('ver', 'Todos')">
                        @if ($ver == 'Todos')
                            <span class="fas fa-check me-1"></span>
                        @endif Todos
                    </a>
                    <a class="dropdown-item" href="#" wire:click="$set('ver', 'Sin asignar')">Sin
                        Asignar</a>
                    <a class="dropdown-item" href="#" wire:click="$set('ver', 'Sin autorizar')">Sin
                        autorizar</a>
                    <a class="dropdown-item" href="#" wire:click="$set('ver', 'Trabajando')">Trabajando</a>
                    <a class="dropdown-item" href="#"
                        wire:click="$set('ver', 'Finalizados en Taller')">Finalizados en Taller</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" wire:click="$set('ver', 'Entregados')">Entregados</a>
                </div>
            </div>

        </x-pretty-card>
        @if (!$cards)


            <div class="card-body p-0">
                <span wire:loading> Loading</span>
                <div class="px-2"> {{ $motores->withQueryString()->links() }}</div>
                <div class="table-responsive scrollbar">

                    <table class="table table-hover table-striped overflow-hidden fs--1" style="font-size: 0.5rem"
                        wire:loading.remove>
                        <thead class="bg-300 text-dark">
                            <tr class="text-800">
                                <th style="width:30px"><input type="checkbox" name="" id=""> </th>
                                <th style="width:1rem"></th>
                                <th class="sort" style="width:13%;cursor: pointer;" wire:click="sortBy('fullos')">
                                    Orden de Servicio
                                    <i
                                        class="fa {{ $sort === 'fullos' ? 'fa-sort-' . ($direction === 'asc' ? 'up' : 'down') : 'fa-sort' }} {{ $sort === 'fullos' ? 'text-success' : '' }}"></i>
                                </th>
                                <th class="sort" style="width:20%;cursor: pointer;"
                                    wire:click="sortBy('id_cliente')">
                                    Cliente
                                    <i
                                        class="fa {{ $sort === 'id_cliente' ? 'fa-sort-' . ($direction === 'asc' ? 'up' : 'down') : 'fa-sort' }} {{ $sort === 'id_cliente' ? 'text-success' : '' }}"></i>
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
                                <th class="sort d-none d-xxl-table-cell" wire:click="sortBy('marca')">
                                    Marca
                                    <i
                                        class="fa {{ $sort === 'marca' ? 'fa-sort-' . ($direction === 'asc' ? 'up' : 'down') : 'fa-sort' }} {{ $sort === 'marca' ? 'text-success' : '' }}"></i>
                                </th>
                                <th class="sort" wire:click="sortBy('status_id')">
                                    Status
                                    <i
                                        class="fa {{ $sort === 'status_id' ? 'fa-sort-' . ($direction === 'asc' ? 'up' : 'down') : 'fa-sort' }} {{ $sort === 'status_id' ? 'text-success' : '' }}"></i>
                                </th>
                                <th class="sort d-none d-lg-table-cell" wire:click="sortBy('created_at')">
                                    Ingreso
                                    <i
                                        class="fa {{ $sort === 'created_at' ? 'fa-sort-' . ($direction === 'asc' ? 'up' : 'down') : 'fa-sort' }} {{ $sort === 'created_at' ? 'text-success' : '' }}"></i>
                                </th>
                                <th>Tecnicos</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($motores as $motor)
                                <tr>

                                    <td style="width:30px"> <input type="checkbox" class="form-check-input"
                                            wire:model.defer="selectedMotors" value="{{ $motor->id_motor }}"></td>
                                    <td>
                                        <div class="col-auto">
                                            @php
                                                if ($motor->fotos && $motor->fotos->count() > 0) {
                                                    $fotoType13 = $motor->fotos->where('type', 3)->first();
                                                } else {
                                                    $fotoType13 = null;
                                                }

                                            @endphp
                                            @if ($fotoType13 && Storage::exists('public' . $fotoType13->thumb))
                                                <div class="avatar avatar-2xl ">
                                                    <a href="{{ route('motores.show', $motor) }}">
                                                        <img class="rounded-circle"
                                                            src="{{ asset('storage' . $fotoType13->thumb) }}"
                                                            alt="" style="transition: transform 0.3s;"
                                                            onmouseover="this.style.transform='scale(1.9)';"
                                                            onmouseout="this.style.transform='scale(1)';" />
                                                    </a>
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
                                    <td>
                                        <div class="d-flex align-items-center position-relative">
                                            {{--   --}}
                                            <div class="flex-1 ms-1">
                                                <h6 class="mb-0 fw-semi-bold"><a class="stretched-link text-900"
                                                        href="{{ route('motores.show', $motor) }}">{{ $motor->fullOs }}</a>
                                                </h6>
                                                @if ($motor->tipoequipo)
                                                    <p class="text-500 fs--2 mb-0">{{ $motor->tipoequipo->name }}</p>
                                                @else
                                                    <p class="text-500 fs--2 mb-0">{{ $motor->id_tipoequipo }}</p>
                                                @endif



                                            </div>
                                        </div>

                                    </td>
                                    <td class="align-middle">{{ $motor->cliente->cliente }}</td>

                                    <td class="align-middle ">{{ $motor->potencia }}</td>
                                    <td class="align-middle text-uppercase d-none d-xl-table-cell">{{ $motor->rpm }}
                                    </td>
                                    <td class="align-middle text-uppercase d-none d-xxl-table-cell">
                                        {{ $motor->marca }}
                                    </td>
                                    <td class="align-middle ">
                                        <button data-bs-toggle="modal" data-bs-target="#error-modal"
                                            class="bg-transparent border-0"
                                            wire:click="loadStatusModal({{ $motor->id_motor }})">
                                            <x-status-badge status_id="{{ $motor->status_id }}"
                                                data-bs-toggle="modal" data-bs-target="#error-modal" />
                                        </button>


                                    </td>
                                    <td class="align-middle d-none d-lg-table-cell">
                                        <div style="d-block">
                                            {{ Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}
                                        </div>

                                        <small>
                                            {{ Carbon\Carbon::parse($motor->fecha_ingreso)->diffForHumans() }}
                                        </small>

                                    </td>
                                    <td>
                                        <!-- Al hacer clic, se emite el evento 'openAsignacionesModal' con el id del motor -->

                                        @foreach ($motor->tecnicos as $tecnico)
                                            <div class="avatar avatar-l">

                                                <img src="{{ asset('storage/' . $tecnico->foto) }}" alt=""
                                                    class="rounded-circle mt-2">

                                            </div>
                                        @endforeach
                                        <div class="avatar avatar-m">
                                            <button class="btn rounded-circle border border-dark p-0"
                                                style="width: 30px; height: 30px;"
                                                wire:click="$emit('openAsignacionesModal', {{ $motor->id_motor }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </td>
                                    <td class="text-end">
                                        <div>
                                            <a class="btn p-0" type="button" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Editar"
                                                href="{{ route('motores.edit', $motor) }}"><span
                                                    class="text-500 fas fa-edit"></span></a>
                                            <button class="btn p-0 ms-2" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Eliminar"
                                                onClick="removeMotor({{ $motor->id_motor }})"><span
                                                    class="text-500 fas fa-trash-alt"></span></button>
                                            <a href="{{ route('motores.downloadPdf', $motor) }}" class="btn p-0 ms-2"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Generar PDF Ingreso"><span
                                                    class="text-500 far fa-file-pdf"></span></a>
                                        </div>
                                    </td>


                                </tr>
                            @endforeach


                        </tbody>
                    </table>

                </div>
            </div>
        @else
            <div class="card-body p-0 row">
                <div class="px-1 card mx-4 mb-2 col-11">
                    {{ $motores->withQueryString()->links() }}
                </div>
                @foreach ($motores as $motor)
                    <div class="col-12 col-sm-6 col-xl-3" wire:loading.remove>
                        <div class="card overflow-hidden" style="margin-bottom: 1rem;">
                            <div class="card-img-top d-flex justify-content-center align-items-center mt-2"
                                style="height: 10rem; overflow: hidden;">
                                <a href="{{ route('motores.show', $motor) }}">
                                    @if ($motor->fotos && $motor->fotos->count() > 0 && Storage::exists('public' . $motor->fotos->first()->thumb))
                                        <img class="img-fluid rounded"
                                            src="{{ asset('storage' . $motor->fotos->first()->thumb) }}"
                                            alt="Foto del pin" style="max-height: 10rem; object-fit: cover;" />
                                    @else
                                        <img class="img-fluid" src="{{ asset('img/default-avatar.png') }}"
                                            alt="No hay foto" style="object-fit:contain;max-height: 10rem; " />
                                    @endif
                                </a>
                            </div>
                            
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('motores.show', $motor) }}">{{ $motor->fullos }}</a>
                                    <x-status-badge status_id="{{ $motor->status_id }}" />
                                </h5>

                        @foreach ($motor->tecnicos as $tecnico)
                            <p class="my-1">
                                <a href="{{ route('motores.index.search', $tecnico->name) }}"> <span><i
                                            class="far fa-user mx-3"></i>{{ $tecnico->name }} </span></a>
                            </p>
                        @endforeach
                                <h6>{{ $motor->cliente->cliente }}</h6>
                                <p class="card-text">
                                <table class="table table-sm">
                                    <tbody>

                                        <tr>
                                            <td>HP</td>
                                            <td>{{ $motor->potencia }}</td>
                                        </tr>
                                        <tr>
                                            <td>RPM</td>
                                            <td>{{ $motor->rpm }}</td>
                                        </tr>
                                        <tr>
                                            <td>Fecha Ingreso</td>
                                            <td>
                                                <div style="d-block">
                                                    {{ Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}
                                                </div>

                                                <small>
                                                    {{ Carbon\Carbon::parse($motor->fecha_ingreso)->diffForHumans() }}
                                                </small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </p>
                                <p class="mt--1">
                                    @foreach ($motor->tecnicos as $tecnico)
                                        <div class="avatar avatar-2xl">

                                            <img src="{{ asset('storage/' . $tecnico->foto) }}" alt=""
                                                class="rounded-circle mt-2">

                                        </div>
                                    @endforeach

                                </p>
                                <hr>
                                <button class="btn btn-primary btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Tomar foto" onclick="loadCamera({{ $motor->id_motor }})">
                                    <i class="fas fa-camera"></i>
                                </button>
                                <button class="btn btn-primary btn ms-2" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Asignar Tecnico"
                                    wire:click="$emit('openAsignacionesModal', {{ $motor->id_motor }})">
                                    <i class="fas fa-user-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
                <input type="file" id="photoUpload" wire:model="photo" accept="image/*" style="display: none;">
            </div>
        @endif

    </div>
    @livewire('motors.asignaciones-modal')
    @livewire('motors.change-status-batch')

    <x-status-modal :statuses="$statuses" :equipo="$equipo" />

    @push('scripts')
        <script src="{{ asset('js/main.js') }}"></script>
    @endpush


</div>
<script>
    loadCamera = function(id) {

        document.querySelector("#photoUpload").click();
        Livewire.emit('cameraLoaded', id);
    }
    document.addEventListener('livewire:load', function() {
        Livewire.on('boardUpdated', (board, cant) => {
            Swal.fire({
                title: "El tablero " + board + " fue actualizado",
                text: "Se agregaron " + cant + " equipos al tablero " + board,
                icon: "success"
            });
        });
        Livewire.on('errorNoMotorsSelected', () => {
            Swal.fire({
                title: "Error",
                text: "Debe seleccionar al menos 1 equipo",
                icon: "error"
            });
        });
        Livewire.on('status-changed', (cantidadMotores) => {
            document.querySelectorAll('.form-check-input').forEach(input => {
                input.checked = false;
            });
        });
        Livewire.on('error', (message) => {
            Swal.fire({
                title: "Error",
                text: message,
                icon: "error"
            });
        });
        Livewire.on('photoAdded', (message) => {
            Swal.fire({
                title: "Excelente",
                text: "Se ha agregado una imagen al la OS: " + message,
                icon: "success"
            });
        });
    });
</script>
