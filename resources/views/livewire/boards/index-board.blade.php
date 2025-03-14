<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <x-pretty-card>
        <h2>Tablero: {{ $board->name }}
        </h2>
        Revisa todos los motores agregados a este tablero
    </x-pretty-card>
    <x-pretty-card>
        <div class="row">
            @foreach ($board->pins as $pin)
                <div class="col-12 col-sm-6 col-xl-2">
                    <div class="card overflow-hidden" style="">
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
    </script>
</div>

