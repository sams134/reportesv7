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
                                wire:click="loadStatusModal({{ $motor->id_motor }})">
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
                        @if ($motor->ayudantes->count() > 0)
                            <HR>
                            </HR>
                            @foreach ($motor->ayudantes as $ayudante)
                                <p class="my-1">
                                    <a href="{{ route('motores.index.search', $ayudante->name) }}"> <span><i
                                                class="far fa-user mx-3"></i>{{ $ayudante->name }} </span></a>
                                </p>
                            @endforeach
                        @endif
                        <HR>
                        </HR>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a class="btn btn-falcon-danger me-1 mb-1 little-button"
                                href="{{ route('motors.createJob', $motor) }}">
                                <span><i class="fas fa-plus mx-1"></i> Agregar Trabajo a OS </span></a>
                            </a>
                        </li>
                    </div>
                </div>
            </div>
            <style>
                .little-button {
                    font-size: 14px;
                    padding: 0.5rem;
                }
            </style>
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
                                <button class="btn btn-falcon-primary me-1 mb-1 little-button" type="button"
                                    onclick="loadCamera()">
                                    <span><i class="fas fa-camera mx-1"></i> Tomar Foto</span></a>
                                </button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @livewire('admin.horas-extras', ['motor' => $motor])
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a class="btn btn-falcon-primary me-1 mb-1 little-button"
                                    href="{{ route('motores.downloadPdf', $motor) }}">
                                    <span><i class="far fa-file-pdf mx-1"></i> Ver PDF Ingreso </span></a>
                                </a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('motores.downloadPdfDensidades', $motor) }}"
                                    class="btn btn-falcon-primary me-1 mb-1 little-button "
                                    type="button">
                                    <span><i class="far fa-file-pdf mx-1"></i> Hoja Densidades </span></a>
                                </a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <button class="btn btn-falcon-primary me-1 mb-1 little-button" type="button"
                                    wire:click="$emit('openAsignacionesModal', {{ $motor->id_motor }})"
                                    >
                                    <span><i class="fas fa-user-plus mx-1"></i> Asignar a Tecnico </span></a>
                                </button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @livewire('motors.pedido-materiales', ['motor' => $motor])
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('pruebas.index', $motor) }}"
                                    class="btn btn-falcon-primary me-1 mb-1 little-button" type="button">
                                    <span><i class="fas fa-charging-station mx-1"></i>Registrar Pruebas </span></a>
                                </a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('motores.createBalanceo', $motor) }}"
                                    class="btn btn-falcon-primary me-1 mb-1 little-button" type="button">
                                    <span><i class="fas fa-balance-scale mx-1"></i>Balanceo Dinamico </span></a>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <style>
            .table-striped td:nth-child(odd),
            .table-striped th:nth-child(odd) {

                font-weight: bold;
            }

            .table-datos td {
                height: 20px;
                padding: 5px;
                font-size: 12px;
            }
        </style>
        <div class="col-lg-9 col-xs-12">
            <x-pretty-card>
                <h3>Informacion del Equipo</h3>
                <table class="table table-hover table-striped table-bordered table-datos" style="">
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
                <h3>Trabajos Adicionales</h3>
                <div class="row">
                   
                    @if (count($motor->jobs)>0)
                    @foreach ($motor->jobs as $job)
                    <div class="card document-card d-flex flex-column justify-content-between me-1"
                        style="width: 180px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                        <a href="{{route('motors.showJob',$job)}}" >
                           <img src="{{ asset('storage' . $job->images->first()->image) }}" alt="" style="max-width: 100%" class="mt-1 rounded">
                           <p style="font-size:18px;" class="text-center mb-0">{{$job->fullos}}</p>
                        <p style="font-size:12px;color:#666;font-style:italic;" class="text-center">{{$job->jobType->name}}</p>
                        </a>
                    </div>
                @endforeach
                    @else
                       <p>No hay trabajos adicionales generados </p>
                    @endif
                    
                </div>

            </x-pretty-card>
            <x-pretty-card>
                <h3>Inventario de Partes</h3>
                <table class="table table-hover table-striped table-bordered table-datos">
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
            <x-pretty-card>
                <h3>Documentos Cargados</h3>
                <div class="document-gallery" style="display: flex; flex-wrap: wrap; gap: 1rem;" id="documentGallery">
                    <div class="card document-card" id="addDocument"
                        style="width: 200px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; transition: transform 0.3s;">
                        <a>
                            <img src="{{ asset('img/pdfadd.png') }}" alt="Agregar PDF" title="Agregar PDF"
                                style="width: 50%; display: block; margin: 0 auto;">
                        </a>
                        <div class="card-footer"
                            style="padding: 0.5rem; text-align: center; background-color: #f8f9fa;">
                            <a style="text-decoration: none; color: inherit;">
                                Agregar Documento
                            </a>
                        </div>
                    </div>
                    <style>
                        .document-card:hover {
                            transform: scale(1.1);
                        }
                    </style>
                    @foreach ($motor->Documentos as $documento)
                        <div class="card document-card d-flex flex-column justify-content-between"
                            style="width: 180px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                            <a href="{{ asset('storage' . $documento->documento) }}" target="_blank">
                                <img src="{{ asset('img/pdflogo.png') }}" alt="PDF Logo"
                                    style="width: 30%; display: block; margin: 0 auto;">
                            </a>
                            <div class="card-footer d-flex flex-column justify-content-end"
                                style="padding: 0.5rem; text-align: center; background-color: #f8f9fa;">
                                <a href="{{ asset('storage' . $documento->documento) }}" target="_blank"
                                    style="text-decoration: none; color: inherit;font-size:13px">
                                    {{ $documento->titulo }}
                                </a>
                                <p>
                                    <button class="btn btn-danger btn-sm me-1 mb-1" type="button"
                                        onclick="removeDoc({{ $documento->id }})">Eliminar
                                    </button>
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <input type="file" id="documentUpload" wire:model="doc" accept=".pdf"
                        style="display: none;">
                </div>
            </x-pretty-card>
            <x-pretty-card>
                <h3>Fechas Importantes</h3>
                <table class="table table-striped table-datos">
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
                    <tr>
                        <td>Fecha de Finalizaci&oacute;n</td>
                        <td>
                            @if ($motor->fin)
                                <div style="d-block">
                                    {{ Carbon\Carbon::parse($motor->fin)->format('d/m/Y') }}
                                </div>
                                <small>
                                    {{ Carbon\Carbon::parse($motor->fin)->diffForHumans() }}
                                </small>
                            @else
                                <div style="d-block">
                                    @livewire('motors.create-fin', ['motor' => $motor])
                                </div>
                            @endif


                        </td>
                    </tr>
                    <tr>
                        <td>Fecha de Entrega</td>
                        <td>
                            <div style="d-block">
                                <a class="btn btn-falcon-primary me-1 mb-1 @if (!$motor->fin) disabled @endif"
                                    type="button"
                                    @if ($motor->fin) href="{{ route('admin.createEnvio', $motor) }}" @endif
                                    style="font-size:12px">Hacer Envio Final
                                </a>
                            </div>

                        </td>
                    </tr>
                </table>
            </x-pretty-card>
            <x-pretty-card>
                <h3>Bit&aacute;cora</h3>
                    <div class="card">
                        <div class="mb-3 p-3">
                            <label class="form-label" for="exampleFormControlInput1">Ingrese Comentario</label>
                            <div class="d-flex">
                                <input class="form-control me-2" id="exampleFormControlInput1" type="text" placeholder="Comentario" wire:model.defer="comment" 
                                    wire:keydown.enter="saveComment"/>
                                <button class="btn btn-primary" type="button" wire:click="saveComment">Guardar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                      <h6 class="mb-0">Bit&aacute;cora de mensajes</h6>
                    </div>
                    <div class="card-body scrollbar ps-2" style="max-height: 600px; overflow-y: auto;">
                        @foreach ($motor->bitacoras->sortByDesc('created_at') as $bitacoraItem)
                        <div class="row g-3 timeline timeline-primary timeline-past pb-card">
                            <div class="col-auto ps-4 ms-2">
                              <div class="ps-2">
                                <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-envelope"></span></div>
                              </div>
                            </div>
                            <div class="col">
                              <div class="row gx-0 border-bottom pb-card">
                                <div class="col">
                                  <h6 class="text-800 mb-1">{{$bitacoraItem->titulo}}</h5>
                                  <h6 class="text-700 mb-1" style="font-size: 12px; font-style: italic;">{{$bitacoraItem->user->name}} </h6>
                                  <p class="fs--1 text-600 mb-0">{{$bitacoraItem->descripcion}}</p>
                                </div>
                                <div class="col-auto">
                                    <p class="fs--2 text-600 mb-0"> {{ Carbon\Carbon::parse($bitacoraItem->created_at)->format('d/m/Y') }} </p>
                                  <p class="fs--2 text-600 mb-0">{{ Carbon\Carbon::parse($bitacoraItem->created_at)->diffForHumans() }}</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      
                    </div>
                 
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

        .card-gallery {
            height: 300px;
            overflow: hidden;
            padding: 2px;
        }

        /* Estilos para que la imagen tenga 200px de altura, se centre y se ajuste sin distorsión */
        .card-img-top {
            height: 200px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
            /* Mantiene la proporción y muestra letterboxing si es necesario */
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <div class="row">
        <div class="col-12">
            <x-pretty-card>
                <h3>Im&aacute;genes</h3>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex ">
                            <div class="d-flex">
                                <button class="btn btn-success me-1 mb-1" type="button" onclick="loadCamera()">
                                    <span><i class="fas fa-camera mx-1"></i> Agregar Foto</span>
                                </button>
                                <input type="file" id="photoUpload" wire:model="photo" accept="image/*"
                                    style="display: none;">

                            </div>
                            <div class="form-check form-switch mt-1 mx-4">

                                <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox"
                                    wire:model="full_gallery" />
                                <label class="form-check-label" for="flexSwitchCheckDefault">Galer&iacute;a
                                    completa</label>
                            </div>

                        </div>
                    </div>
                </div>
                @if (!$full_gallery)

                    <div class="swiper-container theme-slider"
                        data-swiper='{
                                    "spaceBetween": 10,
                                    "slidesPerView": 4,
                                    "loop": true,
                                    "grabCursor": true,
                                    "centeredSlides": false,
                                    "slideToClickedSlide": true,
                                    "navigation": {
                                        "nextEl": ".swiper-button-next",
                                        "prevEl": ".swiper-button-prev"
                                    }
                                }'>
                        <div class="swiper-wrapper">
                            @foreach ($motor->fotos->sortByDesc('id') as $foto)
                                <div class="swiper-slide">
                                    <img class="slider-img" src="{{ asset('storage' . $foto->foto) }}"
                                        alt="Foto"
                                        ondblclick="openImageModal('{{ asset('storage' . $foto->foto) }}')" />
                                </div>
                            @endforeach
                            @foreach($motor->jobs as $job)
                                @foreach ($job->images as $foto)
                                <div class="swiper-slide">
                                    <img class="slider-img" src="{{ asset('storage' . $foto->image) }}"
                                        alt="Foto"
                                        ondblclick="openImageModal('{{ asset('storage' . $foto->image) }}')" />
                                </div>
                                @endforeach
                            @endforeach
                        </div>
                        <div class="swiper-nav">
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        </div>
                    </div>
                @else
                    <div class="card py-3 px-1 mt-3">
                        <div class="row">
                            @foreach ($motor->fotos->sortByDesc('id') as $foto)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 my-2">
                                    <div class="card card-gallery">
                                        <img class="card-img-top" src="{{ asset('storage' . $foto->foto) }}"
                                            alt="Foto"
                                            ondblclick="openImageModal('{{ asset('storage' . $foto->foto) }}')">
                                        <div class="card-footer">
                                            <p style="font-size: 12px">
                                                <span class="fw-bold">Fecha Foto: </span>
                                                {{ Carbon\Carbon::parse($foto->created_at)->format('d/m/Y') }}
                                            </p>

                                            @if ($foto->user)
                                                <p style="font-size: 12px">
                                                    <span class="fw-bold">Foto Tomada por: </span>
                                                    {{ $foto->user->name }}
                                                </p>
                                            @endif
                                            <p class="card-text">{{ $foto->comentario }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @foreach($motor->jobs as $job)
                                @foreach ($job->images as $foto)
                                     <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 my-2">
                                         <div class="card card-gallery">
                                              <img class="card-img-top" src="{{ asset('storage' . $foto->image) }}"
                                                    alt="Foto"
                                                    ondblclick="openImageModal('{{ asset('storage' . $foto->image) }}')">
                                              <div class="card-footer">
                                                    <p style="font-size: 12px">
                                                     <span class="fw-bold">Fecha Foto: </span>
                                                     {{ Carbon\Carbon::parse($foto->created_at)->format('d/m/Y') }}
                                                    </p>
                                                    @if ($foto->user)
                                                     <p style="font-size: 12px">
                                                          <span class="fw-bold">Foto Tomada por: </span>
                                                          {{ $foto->user->name }}
                                                     </p>
                                                    @endif
                                                    <p class="card-text">{{ $foto->comentario }}</p>
                                              </div>
                                         </div>
                                        </div>    
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-body p-0 text-center" style="background-color: black;">
                                <img id="modalImage" src="" class="img-fluid w-90 h-auto" alt="Preview" />
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
    <div class="row">
        <div class="col-12">
            <x-pretty-card>
                <div class="d-flex">
                    <h3>Materiales</h3>
                </div>

                @livewire('motors.show-pedido', ['motor' => $motor])
                <div class="d-flex me-1 my-3">
                    <a class="btn btn-falcon-danger me-1 mb-1 little-button" type="button"
                        href="{{ route('motores.downloadPdfMateriales', $motor) }}" target="_blank">
                        <i class="far fa-file-pdf mx-1"></i> Imprimir PDF
                    </a>
                    @livewire('motors.pedido-materiales', ['motor' => $motor])
                </div>

            </x-pretty-card>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <x-pretty-card>
                <div class="d-flex">
                    <h3>Horas Extra</h3>
                </div>
                <div class="table-responsive scrollbar" style="max-height: 350px; overflow: auto;">
                    <span wire:loading> Loading</span>
                    <table class="table mb-0 minitabla table-hover table-striped" style="font-size: 12px;"
                        wire:loading.class="opacity-50">
                        <thead class="text-black bg-200">
                            <tr>

                                <th class="align-middle" width="10%">Horas</th>
                                <th class="align-middle" width="10%">Fecha</th>
                                <th class="align-middle">Usuario</th>
                                <th class="align-middle" width="40%">Descripcion</th>
                                <th class="align-middle" width="15%">Autorizado Por:</th>
                            </tr>
                        </thead>
                        <tbody id="bulk-select-body">
                            @foreach ($motor->horasExtras as $hora)
                                <tr>
                                    <td class="align-middle">{{ number_format($hora->hours, 1) }}</td>
                                    <td class="align-middle">
                                        Inicio:
                                        {{ ucfirst(\Carbon\Carbon::parse($hora->init)->locale('es')->isoFormat('dddd D [de] MMMM h:mm A')) }}
                                        <br>Final:
                                        {{ ucfirst(\Carbon\Carbon::parse($hora->final)->locale('es')->isoFormat('dddd D [de] MMMM h:mm A')) }}
                                    </td>
                                    <td class="align-middle">{{ $hora->user->name }}</td>
                                    <td class="align-middle">{{ $hora->descripcion }}</td>
                                    <td class="align-middle">
                                        @if ($hora->autorizado_por == $hora->user->id)
                                            <span>Sistema</span>
                                        @else
                                            <span>{{ $hora->autorizadoPor->name }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-soft-primary">

                                <td colspan="5" class="fw-bold text-xl text-center" style="font-size: 16px"> Total
                                    de Horas Extra: {{ number_format(ceil($motor->horasExtras->sum('hours')), 0) }}
                                    horas</td>
                            </tr>

                        </tbody>
                    </table>


                </div>


            </x-pretty-card>
        </div>
    </div>
    @livewire('motors.asignaciones-modal')
    <x-status-modal :statuses="$statuses" :equipo="$motor" />
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        const documentBtn = document.querySelector('#addDocument');

        if (documentBtn)
            documentBtn.addEventListener('click', function() {
                document.querySelector("#documentUpload").click();
            });



        function removeDoc(id) {
            console.log(id);
            Swal.fire({
                title: 'Seguro que desea eliminar este documento?',
                text: "Este cambio no puede ser revertido",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Borrarlo',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('removeDoc', id);
                }
            })
        }
        window.addEventListener('photoAdded', event => {
            Swal.fire({
            title: event.detail.message || 'Imagen agregada con éxito',
            icon: 'success',
            confirmButtonText: 'Aceptar'
            });
        });
        window.addEventListener('init-swiper', event => {
            console.log('Evento "init-swiper" recibido. Reinicializando Swiper...');
            document.querySelectorAll('.swiper-container.theme-slider').forEach(container => {
                let config = {};
                try {
                    config = JSON.parse(container.getAttribute('data-swiper'));
                } catch (e) {
                    console.error("Error parseando data-swiper:", e);
                }
                new Swiper(container, config);
            });
        });
        loadCamera = function() {
            document.querySelector("#photoUpload").click();
        }

        function finalizar(id) {
            Swal.fire({
                title: 'Seguro que desea finalizar la orden de servicio?',
                text: "Al finalizar podra cobrar el equipo, pero no podra realizar mas cambios",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Finalizar',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('finalizar', id);
                }
            })
        }
       
    </script>
</div>
