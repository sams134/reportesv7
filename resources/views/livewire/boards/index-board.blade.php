<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <x-pretty-card>
        <h2>Tablero: {{ $board->name }}
        </h2>
        Revisa todos los motores agregados a este tablero
    </x-pretty-card>
    <x-form-card  title="Controles">
        <div class="d-flex align-items-center gap-3 mb-2">
            <div class="btn-group">
                <button class="btn dropdown-toggle btn-primary" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ordenar Por {{$ver}}
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" wire:click="$set('ver', 'Fecha de Creación')">Fecha de Creación</a>
                    <a class="dropdown-item" href="#" wire:click="$set('ver', 'OS (Numero de Orden)')">OS (Numero de Orden)</a>
                    <a class="dropdown-item" href="#" wire:click="$set('ver', 'Cliente')">Cliente</a>
                    <div class="dropdown-divider"></div>
                </div>
            </div>
            {{-- share board component --}}

            @if (Auth::id() == $board->owner_id)
                @livewire('boards.share-board', ['board' => $board])
            @endif
        </div>
    </x-form-card>
    <x-pretty-card>
        <div class="row">
            @foreach ($pins as $pin)
                <div class="col-12 col-sm-6 col-md-4 col-xxl-2" style="">
                    <div class="card overflow-hidden" style="">
                        <div style="text-align:right;" class="px-3 ">
                            <button style="all: unset;" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar de tablero" onclick="deletePin({{ $pin->id }})">
                                <i class="fas fa-trash-alt text-danger hover-effect" style="transition: transform 0.2s, color 0.2s;"> </i>
                            </button>
                            <style>
                                .hover-effect:hover {
                                    color: blue !important;
                                    
                                }
                            </style>
                            
                        </div>
                        <style>
                            
                        </style>
                        <div class="card-img-top d-flex justify-content-center align-items-center" style="height: 10rem; overflow: hidden;">
                            <a href="{{route('motores.show',$pin->pinable)}}">
                            @if ($pin->pinable->fotos && $pin->pinable->fotos->count() > 0 && Storage::exists('public' . $pin->pinable->fotos->first()->thumb))
                                <img class="img-fluid" src="{{ asset('storage' . $pin->pinable->fotos->first()->thumb) }}"
                                    alt="Foto del pin" style="max-height: 10rem; object-fit: cover;" />
                            @else
                                <img class="img-fluid" src="{{ asset('img/default-avatar.png') }}" alt="No hay foto" style="object-fit:contain;max-height: 10rem; " />
                            @endif
                            </a>
                        </div>
                        <div class="card-body">
                          
                            <a href="{{route('motores.show',$pin->pinable)}}"><h5 class="card-title">{{ $pin->pinable->fullos }} 
                               
                                <x-status-badge status_id="{{ $pin->pinable->status_id }}"  />
                            
                            </h5></a>
                            <h6>{{$pin->pinable->cliente->cliente}}</h6>
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
                                <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="Agregue un comentario personal" wire:model.lazy="comment.{{$pin->id}}" />
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
            <input type="file" id="photoUpload" wire:model="photo" accept="image/*"
            style="display: none;">
        </div>
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
    </script>
</div>

