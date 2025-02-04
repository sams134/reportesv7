<div>
    <x-page-title>
        <x-slot:title>Ficha Tecnica de la OS {{ $motor->fullOs }}</x-slot:title>
        Vea la informacion del equipo.
    </x-page-title>
    <div class="row">
        <div class="col-lg-3 col-xs-12">
            <div class="card mb-3">
                <div class="bg-holder d-none d-lg-block bg-card"
                    style="background-image:url(/img/icons/spot-illustrations/corner-2.png);">
                </div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <div class="row">
                        @if ($motor->fotos && $motor->fotos->count() > 0 && Storage::exists('public' . $motor->fotos->first()->thumb))
                            <img class="img-thumbnail" src="{{ asset('storage' . $motor->fotos->first()->thumb) }}"
                                alt="" />
                        @else
                            <img class="img-thumbnail" src="{{ asset('img/default-avatar.png') }}" alt="No hay foto" />
                        @endif
                        <h2>{{ $motor->fullOs }}</h2>
                        <span>{{ $motor->cliente->cliente }}</span>
                        <p>
                            <button data-bs-toggle="modal" data-bs-target="#error-modal" class="bg-transparent border-0"
                                wire:click="loadStatusModal({{ $motor }})">
                                <x-status-badge status_id="{{ $motor->status_id }}" data-bs-toggle="modal"
                                    data-bs-target="#error-modal" />
                            </button>
                        </p>

                        @foreach ($motor->tecnicos as $tecnico)
                            <p class="my-1">
                                <a href="{{ route('motores.index.search', $tecnico->name) }}"> <span><i
                                            class="far fa-user mx-3"></i>{{ $tecnico->name }} </span></a>
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="bg-holder d-none d-lg-block bg-card"
                    style="background-image:url(/img/icons/spot-illustrations/corner-2.png);">
                </div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <div class="row">
                        <h3>Herramientas</h3>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <button class="btn btn-falcon-primary me-1 mb-1" type="button">
                                    <span><i class="fas fa-camera mx-1"></i> Tomar Foto</span></a>
                                </button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <button class="btn btn-falcon-primary me-1 mb-1" type="button">
                                    <span><i class="far fa-file-pdf mx-1"></i> Ver PDF Ingreso </span></a>
                                </button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{route('motores.downloadPdfDensidades',$motor)}}" class="btn btn-falcon-primary me-1 mb-1" type="button">
                                    <span><i class="far fa-file-pdf mx-1"></i> Hoja Densidades </span></a>
                                </a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <button class="btn btn-falcon-primary me-1 mb-1" type="button">
                                    <span><i class="fas fa-user-plus mx-1"></i> Asignar a Tecnico </span></a>
                                </button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <button class="btn btn-falcon-primary me-1 mb-1" type="button">
                                    <span><i class="far fa-list-alt mx-1"></i> Pedir Materiales </span></a>
                                </button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <button class="btn btn-falcon-primary me-1 mb-1" type="button">
                                    <span><i class="fas fa-charging-station mx-1"></i>Registrar Pruebas </span></a>
                                </button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{route('motores.createBalanceo',$motor)}}" class="btn btn-falcon-primary me-1 mb-1" type="button">
                                    <span><i class="fas fa-balance-scale mx-1"></i>Balanceo Dinamico </span></a>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <x-pretty-card>
                <h3>Fechas Importantes</h3>
                <table class="table table-striped">
                    <colgroup>
                        <col class="bg-soft-primary" />
                        <col />

                    </colgroup>
                    <tr>
                        <td>Fecha de Ingreso</td>
                        <td>
                            <div style="d-block">
                                {{ Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}
                            </div>

                            <small>
                                {{ Carbon\Carbon::parse($motor->fecha_ingreso)->diffForHumans() }}
                            </small>
                        </td>
                    </tr>
                </table>
            </x-pretty-card>
        </div>
        <style>
            .table-striped td:nth-child(odd),
            .table-striped th:nth-child(odd) {

                font-weight: bold;
            }
        </style>
        <div class="col-lg-9 col-xs-12">
            <x-pretty-card>
                <h3>Informacion del Equipo</h3>
                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <td>Nombre del Equipo</td>
                        <td colspan="5">
                            {{ $motor->infoMotor->nombre_equipo ? $motor->infoMotor->nombre_equipo : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="">Marca</td>
                        <td>{{ $motor->marca }}</td>
                        <td>Serie</td>
                        <td>{{ $motor->serie }}</td>
                        <td>Modelo</td>
                        <td>{{ $motor->modelo }}</td>
                    </tr>
                    <tr>
                        <td>Potencia</td>
                        <td>{{ $motor->potencia }}</td>
                        <td>Volts</td>
                        <td>{{ $motor->volts }}</td>
                        <td>Amps</td>
                        <td>{{ $motor->amps }}</td>
                    </tr>
                    <tr>
                        <td>RPM</td>
                        <td>{{ $motor->rpm }}</td>
                        <td>Factor Potencia</td>
                        <td>{{ $motor->pf }}</td>
                        <td>Eficiencia</td>
                        <td>{{ $motor->eff }}</td>
                    </tr>
                    <tr>
                        <td>HZ</td>
                        <td>{{ $motor->hz }}</td>
                        <td>Frame</td>
                        <td>{{ $motor->frame }}</td>
                        <td>Fases</td>
                        <td>{{ $motor->phases }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Comentarios de Cliente</td>
                        <td colspan="4">{{ $motor->comentarios }}</td>
                    </tr>
                </table>
            </x-pretty-card>
            <x-pretty-card>
                <h3>Inventario de Partes</h3>
                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <td>Acople</td>
                        <td>{{ $motor->inventario->getItemStatus($motor->inventario->acople) }}</td>
                        <td>Caja Conexiones</td>
                        <td>{{ $motor->inventario->getItemStatus($motor->inventario->caja_conexiones) }}</td>
                        <td>Tapa Caja Conexiones</td>
                        <td>{{ $motor->inventario->getItemStatus($motor->inventario->tapa_caja) }}</td>
                    </tr>
                    <tr>
                        <td>Difusor</td>
                        <td>{{ $motor->inventario->getItemStatus($motor->inventario->difusor) }}</td>
                        <td>Ventilador</td>
                        <td>{{ $motor->inventario->getItemStatus($motor->inventario->ventilador) }}</td>
                        <td>Bornera</td>
                        <td>{{ $motor->inventario->getItemStatus($motor->inventario->bornera) }}</td>
                    </tr>
                    <tr>
                        <td>Cu&ntilde;a</td>
                        <td>{{ $motor->inventario->getItemStatus($motor->inventario->cunia) }}</td>
                        <td>Graseras</td>
                        <td>{{ $motor->inventario->getItemStatus($motor->inventario->graseras) }}</td>
                        <td>Cancamo</td>
                        <td>{{ $motor->inventario->getItemStatus($motor->inventario->cancamo) }}</td>
                    </tr>
                    <tr>
                        <td>Placa</td>
                        <td>{{ $motor->inventario->getItemStatus($motor->inventario->placa) }}</td>
                        <td>Capacitor</td>
                        <td>{{ $motor->inventario->getItemStatus($motor->inventario->capacitor) }}</td>
                        <td>Tornillos Completos</td>
                        <td>{{ $motor->inventario->getItemStatus($motor->inventario->tornillos) }}</td>
                    </tr>
                    <tr>
                        <td>Comentarios Inventario</td>
                        <td colspan="5">{{ $motor->inventario->comentarios }}</td>
                    </tr>
                </table>
            </x-pretty-card>
        </div>
    </div>
    <style>
        .slider-img {
            height: 300px;
            /* Ajusta la altura según lo necesario */
            width: 100%;
            /* Asegura que ocupe todo el ancho del contenedor */
            object-fit: cover;
            /* Rellena el contenedor manteniendo el aspecto */
            border-radius: 5px;
            /* Opcional: para bordes redondeados */
        }
    </style>
    <div class="row">
        <div class="col-12">
            <x-pretty-card>
                <h3>Imagenes</h3>
                <div class="swiper-container theme-slider"
                    data-swiper='{
        "spaceBetween": 10,
        "slidesPerView": 4,
        "loop": true,
        "grabCursor": true,
        "centeredSlides": false,
        "slideToClickedSlide": true
    }'>
                    <div class="swiper-wrapper">
                        @foreach ($motor->fotos as $foto)
                            <div class="swiper-slide">
                                <img class="slider-img" src="{{ asset('storage' . $foto->foto) }}"
                                    alt="Foto"
                                    ondblclick="openImageModal('{{ asset('storage' . $foto->foto) }}')" />
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-nav">
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"></div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-body p-0 text-center" style="background-color: black;">
                                <img id="modalImage" src="" class="img-fluid w-100 h-auto" alt="Preview" />
                                <button type="button"
                                    class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </x-pretty-card>
        </div>
    </div>
    <x-status-modal :statuses="$statuses" :equipo="$motor" />
    <script src="{{ asset('js/main.js') }}"></script>
</div>
