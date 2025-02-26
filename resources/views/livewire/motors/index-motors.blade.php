<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <x-pretty-card>
        <h2>Listado General de Motores del usuario {{ auth()->user()->name }}
        </h2>
        Revisa todos los motores en el sistema
    </x-pretty-card>
    <x-pretty-card>
        <div class="d-flex">
            <a class="btn btn-outline-primary me-1 mb-1" type="button" href="{{ route('motores.create') }}">
                <span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Nuevo Equipo
            </a>
            @livewire('motors.create-board')
            @if ($boards->count() > 0)
                <div class="btn-group">
                    <button class="btn dropdown-toggle mb-2 btn-success" type="button" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Agregar a tablero</button>
                    <div class="dropdown-menu">
                        @foreach ($boards as $board)
                        <a class="dropdown-item" href="#" wire:click.prevent="addToBoard({{ $board->id }})">
                            {{ $board->name }}
                        </a>
                        @endforeach

                    </div>
                </div>
            @endif
        </div>

    </x-pretty-card>
    <div class="card" id="runningProjectTable" data-list='{"valueNames":["projects","worked","time","date"]}'>
        <div class="card-header">

            <div class="mb-0">
                <label class="form-label" for="basic-form-name">Busqueda de equipos</label>
                <input class="form-control" id="basic-form-name" type="text"
                    placeholder="Ingrese OS, nombre de equipo, cliente o t&eacute;cnico" wire:model="search" />
            </div>
            {{$search}}
        </div>

       
            <x-pretty-card class="mt-1" >
                    
                    <button class="btn btn-falcon-primary me-1 mb-1" type="button" wire:click="toggleView">
                        @if ($cards)
                            <span class="fas fa-table me-1" data-fa-transform="shrink-3"></span>Vista Lista
                        @else
                            <span class="fas fa-th-large me-1" data-fa-transform="shrink-3"></span>Vista Tarjetas
                        @endif
                    </button>
                    <div class="btn-group dropend ">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ver {{$ver}}</button>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Todos</a>
                        <a class="dropdown-item" href="#">Sin autorizar</a>
                        <a class="dropdown-item" href="#">Trabajando</a>
                        <a class="dropdown-item" href="#">Finalizados</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                    </div>
            
            </x-pretty-card>
        @if (!$cards)
            
        
        <div class="card-body p-0">
            <span wire:loading> Loading</span>
            <div class="px-2"> {{ $motores->links('pagination::bootstrap-5') }}</div>
            <div class="table-responsive scrollbar">
            <table class="table table-hover table-striped overflow-hidden fs--1" wire:loading.remove>
                <thead class="bg-300 text-dark">
                <tr class="text-800">
                    <th style="width:30px"><input type="checkbox" name="" id=""> </th>
                    <th style="width:1rem"></th>
                    <th class="sort" style="width:15%;cursor: pointer;" wire:click="sortBy('fullos')">
                    Orden de Servicio
                    <i
                        class="fa {{ $sort === 'fullos' ? 'fa-sort-' . ($direction === 'asc' ? 'up' : 'down') : 'fa-sort' }} {{ $sort === 'fullos' ? 'text-success' : '' }}"></i>
                    </th>
                    <th class="sort" wire:click="sortBy('id_cliente')">
                    Cliente
                    <i
                        class="fa {{ $sort === 'id_cliente' ? 'fa-sort-' . ($direction === 'asc' ? 'up' : 'down') : 'fa-sort' }} {{ $sort === 'id_cliente' ? 'text-success' : '' }}"></i>
                    </th>
                    <th class="sort" wire:click="sortBy('hp')">
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
                       
                    <td style="width:30px"> <input type="checkbox" class="form-check-input" wire:model.defer="selectedMotors" value="{{ $motor->id_motor }}"></td>
                    <td>
                        <div class="col-auto">
                        @if ($motor->fotos && $motor->fotos->count() > 0 && Storage::exists('public' . $motor->fotos->first()->thumb))
                            <div class="avatar avatar-xl status-offline">
                            <img class="rounded-circle"
                                src="{{ asset('storage' . $motor->fotos->first()->thumb) }}"
                                alt="" />
                            </div>
                        @else
                            <div class="avatar avatar-2xl status-offline">
                            <img class="rounded-circle" src="{{ asset('img/default-avatar.png') }}"
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
                    <td class="align-middle text-uppercase d-none d-xl-table-cell">{{ $motor->rpm }}</td>
                    <td class="align-middle text-uppercase d-none d-xxl-table-cell">{{ $motor->marca }}
                    </td>
                    <td class="align-middle ">
                        <button data-bs-toggle="modal" data-bs-target="#error-modal"
                        class="bg-transparent border-0"
                        wire:click="loadStatusModal({{ $motor }})">
                        <x-status-badge status_id="{{ $motor->status_id }}" data-bs-toggle="modal"
                            data-bs-target="#error-modal" />
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
                        <div class="avatar avatar-xl">

                            <img src="{{ asset($tecnico->foto) }}" alt=""
                            class="rounded-circle mt-2">

                        </div>
                        @endforeach
                        <div class="avatar avatar-xl">
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
                        <button class="btn p-0 ms-2" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Eliminar" onClick="removeMotor({{ $motor->id_motor }})"><span
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
                {{ $motores->links('pagination::bootstrap-5') }}
            </div>
            @foreach ($motores as $motor)
                <div class="col-12 col-sm-6 col-xl-3" wire:loading.remove>
                    <div class="card overflow-hidden" style="margin-bottom: 1rem;">
                        <div class="card-img-top d-flex justify-content-center align-items-center" style="height: 10rem; overflow: hidden;">
                            @if ($motor->fotos && $motor->fotos->count() > 0 && Storage::exists('public' . $motor->fotos->first()->thumb))
                                <img class="img-fluid" src="{{ asset('storage' . $motor->fotos->first()->thumb) }}"
                                    alt="Foto del pin" style="max-height: 10rem; object-fit: cover;" />
                            @else
                                <img class="img-fluid" src="{{ asset('img/default-avatar.png') }}" alt="No hay foto" style="object-fit:contain;max-height: 10rem; " />
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('motores.show', $motor) }}">{{ $motor->fullos }}</a>
                                <x-status-badge status_id="{{ $motor->status_id }}"  />
                            </h5>
                            <h6>{{$motor->cliente->cliente}}</h6>
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
                                    </tbody>
    
                                </table>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

          </div>
        @endif

    </div>
    @livewire('motors.asignaciones-modal')


    <x-status-modal :statuses="$statuses" :equipo="$equipo" />

    @push('scripts')
        <script src="{{ asset('js/main.js') }}"></script>
    @endpush


</div>
<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('boardUpdated', (board, cant) => {
            Swal.fire({
                title: "El tablero " + board + " fue actualizado",
                text: "Se agregaron " + cant + " equipos al tablero " + board,
                icon: "success"
            });
        });
    });
</script>
