<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <x-pretty-card>
        <h2>Tablero: {{ $board->name }}
        </h2>
        Revisa todos los motores agregados a este tablero
    </x-pretty-card>
    <x-form-card title="Controles">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-2"> <!-- ✅ Flex horizontal y colapsable -->

                    <button class="btn btn-falcon-primary me-1 mb-1" type="button" wire:click="toggleView">
                        @if ($cards)
                            <span class="fas fa-table me-1" data-fa-transform="shrink-3"></span>Vista Lista
                        @else
                            <span class="fas fa-th-large me-1" data-fa-transform="shrink-3"></span>Vista Tarjetas
                        @endif
                    </button>
                    <!-- Botón "Ordenar por" -->
                    <div class="btn-group">
                        <button class="btn dropdown-toggle btn-primary" type="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Ordenar Por {{ $ver }}
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" wire:click="$set('ver', 'Fecha de Creación')">Fecha
                                de Creación</a>
                            <a class="dropdown-item" href="#" wire:click="$set('ver', 'OS (Numero de Orden)')">OS
                                (Numero de Orden)</a>
                            <a class="dropdown-item" href="#" wire:click="$set('ver', 'Cliente')">Cliente</a>
                            <div class="dropdown-divider"></div>
                        </div>
                    </div>

                    <!-- Botón de compartir (Livewire) -->
                    @if (Auth::id() == $board->owner_id)
                        <div>
                            @livewire('boards.share-board', ['board_id' => $board->id], key('share-board-' . $board->id))

                        </div>
                    @endif
                    @if (Auth::id() == $board->owner_id)
                        <button class="btn btn-danger d-flex align-items-center" onclick="deleteTablero()">
                            <i class="fas fa-trash-alt me-2"></i> Eliminar Tablero
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </x-form-card>
    <x-pretty-card class="">
        @if ($cards)
            <div class="row">
                @foreach ($pins as $pin)
                    <div class="col-12 col-sm-6 col-md-4 col-xxl-2" style="">
                        <div class="card overflow-hidden" style="">
                            <div style="text-align:right;" class="px-3 ">
                                @if (Auth::id() == $board->owner_id)
                                    <button style="all: unset;" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Eliminar de tablero" onclick="deletePin({{ $pin->id }})">
                                        <i class="fas fa-trash-alt text-danger hover-effect"
                                            style="transition: transform 0.2s, color 0.2s;"> </i>
                                    </button>
                                @endif
                                <style>
                                    .hover-effect:hover {
                                        color: blue !important;
                                    }
                                </style>
                            </div>
                            @php
                                if ($pin->pinable->fotos && $pin->pinable->fotos->count() > 0) {
                                    $fotoType13 = $pin->pinable->fotos->where('type', 3)->first();
                                } else {
                                    $fotoType13 = null;
                                }
                            @endphp
                            <div class="card-img-top d-flex justify-content-center align-items-center"
                                style="height: 10rem; overflow: hidden;">
                                <a href="{{ route('motores.show', $pin->pinable) }}">
                                    @if ($fotoType13)
                                        <img class="img-fluid" src="{{ asset('storage' . $fotoType13->thumb) }}"
                                            alt="Foto del pin" style="max-height: 10rem; object-fit: cover;" />
                                    @else
                                        <img class="img-fluid" src="{{ asset('img/default-avatar.png') }}"
                                            alt="No hay foto" style="object-fit:contain;max-height: 10rem; " />
                                    @endif
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('motores.show', $pin->pinable) }}">
                                    <h5 class="card-title">{{ $pin->pinable->fullos }}
                                        <x-status-badge status_id="{{ $pin->pinable->status_id }}" />
                                    </h5>
                                </a>
                                <h6>{{ $pin->pinable->cliente->cliente }}</h6>
                                @foreach ($pin->pinable->tecnicos as $tecnico)
                                    <p class="my-1">
                                        <a href="{{ route('motores.index.search', $tecnico->name) }}"> <span><i
                                                    class="far fa-user mx-3"></i>{{ $tecnico->name }} </span></a>
                                    </p>
                                @endforeach
                                <p class="card-text">

                                <table class="table table-sm">
                                    <tbody>

                                        <tr>
                                            <td>HP</td>
                                            <td>{{ $pin->pinable->potencia }}</td>
                                        </tr>
                                        <tr>
                                            <td>RPM</td>
                                            <td>{{ $pin->pinable->rpm }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="mb-3">
                                    <label class="form-label" for="exampleFormControlInput1">Comentario</label>
                                    <input class="form-control" id="exampleFormControlInput1" type="text"
                                        placeholder="Agregue un comentario personal"
                                        wire:model.lazy="comment.{{ $pin->id }}" />
                                </div>
                                <hr>
                                </p>
                                <button class="btn btn-primary btn-sm" onclick="loadCamera({{ $pin->pinable_id }})">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
                <input type="file" id="photoUpload" wire:model="photo" accept="image/*" style="display: none;">
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5%"></th>
                            <th style="width:25%">OS (Numero de Orden)</th>
                            <th style="width:25%">Cliente</th>
                            <th>Comentarios</th>
                            <th style="width:10%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pins as $pin)
                            <tr>
                                <td>
                                    <div class="col-auto">
                                        @php
                                            if ($pin->pinable->fotos && $pin->pinable->fotos->count() > 0) {
                                                $fotoType13 = $pin->pinable->fotos->where('type', 3)->first();
                                            } else {
                                                $fotoType13 = null;
                                            }

                                        @endphp
                                        @if ($fotoType13 && Storage::exists('public' . $fotoType13->thumb))
                                            <div class="avatar avatar-3xl ">
                                                <a href="{{ route('motores.show', $pin->pinable) }}">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage' . $fotoType13->thumb) }}"
                                                        alt="" style="transition: transform 0.3s;"
                                                        onmouseover="this.style.transform='scale(1.9)';"
                                                        onmouseout="this.style.transform='scale(1)';" />
                                                </a>
                                            </div>
                                        @else
                                            <div class="avatar avatar-3xl ">
                                                <img class="rounded-circle" src="{{ asset('img/default-avatar.png') }}"
                                                    alt="No hay foto" />
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                     <a href="{{ route('motores.show', $pin->pinable) }}">
                                        <strong>{{ $pin->pinable->fullos }}</strong>
                                    </a>
                                 
                                   
                                    <br>
                                    <small>{{ $pin->pinable->potencia }} - {{ $pin->pinable->rpm }} RPM

                                        <br>
                                    @foreach ($pin->pinable->tecnicos as $tecnico)
                                        <p class="my-1">
                                            <a href="{{ route('motores.index.search', $tecnico->name) }}"> <span><i
                                                        class="far fa-user mx-3"></i>{{ $tecnico->name }} </span></a>
                                        </p>
                                    @endforeach
                                    </small>
                                </td>
                                <td>{{ $pin->pinable->cliente->cliente }} <br>
                                    <small><strong>Ingreso:</strong> {{ $pin->pinable->created_at->format('d/m/Y') }}</small> <br>
                                 <x-status-badge status_id="{{ $pin->pinable->status_id }}" /></td>
                                <td>
                                    <input class="form-control" id="exampleFormControlInput1" type="text"
                                        placeholder="Agregue un comentario personal"
                                        wire:model.lazy="comment.{{ $pin->id }}" />
                                </td>
                                <td>
                                    @if (Auth::id() == $board->owner_id)
                                        <button class="btn btn-danger btn-sm"
                                            onclick="deletePin({{ $pin->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </x-pretty-card>
    <script>
        loadCamera = function(id) {
            document.querySelector("#photoUpload").click();
            Livewire.emit('cameraLoaded', id);
        }
        document.addEventListener('livewire:load', function() {
            Livewire.on('photoAdded', (os) => {
                Swal.fire({
                    title: "Foto Agregada",
                    text: "Se agrego una foto a la OS: " + os,
                    icon: "success"
                });
            });
        });
        deletePin = function(id) {
            Swal.fire({
                title: "¿Estás seguro de quitar este equipo del tablero?",
                text: "El equipo no se eliminará de la base de datos, solo se quitará del tablero",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Sí, quitalo!",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deletePin', id);
                }
            });
        }
        deleteTablero = function() {
            Swal.fire({
                title: "¿Estás seguro de eliminar este tablero?",
                text: "Todos los equipos serán eliminados del tablero, pero no de la base de datos.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "¡Sí, eliminar!",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('deleteTablero');
                }
            });
        }
        document.addEventListener('livewire:load', function() {
            Livewire.on('boardDeleted', () => {
                Swal.fire({
                    title: "¡Tablero eliminado!",
                    text: "El tablero ha sido eliminado correctamente.",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    window.location.href =
                        "{{ route('motores.index') }}"; // Redirigir a la lista de tableros
                });
            });

            Livewire.on('pinDeleted', () => {
                Swal.fire({
                    title: "¡Equipo eliminado del tablero!",
                    text: "El equipo ha sido eliminado del tablero correctamente.",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                });
            });
        });
    </script>
</div>
