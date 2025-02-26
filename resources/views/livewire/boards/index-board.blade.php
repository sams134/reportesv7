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
                            @if ($pin->pinable->fotos && $pin->pinable->fotos->count() > 0 && Storage::exists('public' . $pin->pinable->fotos->first()->thumb))
                                <img class="img-fluid" src="{{ asset('storage' . $pin->pinable->fotos->first()->thumb) }}"
                                    alt="Foto del pin" style="max-height: 10rem; object-fit: cover;" />
                            @else
                                <img class="img-fluid" src="{{ asset('img/default-avatar.png') }}" alt="No hay foto" style="object-fit:contain;max-height: 10rem; " />
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $pin->pinable->fullos }} 
                               
                                <x-status-badge status_id="{{ $pin->pinable->status_id }}"  />
                            
                            </h5>
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
                            </p><a class="btn btn-primary btn-sm" href="#!">Go somewhere</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-pretty-card>
</div>
