<div>
    <x-page-title>
        <x-slot:title>Ficha Tecnica del trabajo adicional {{ $job->fullOs }}</x-slot:title>
        Este trabajo pertenece a la OS <a href="{{ route('motores.show', $motor) }}"> {{ $motor->fullos }}</a>
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
                        @if ($job->images && $job->images->count() > 0 && Storage::exists('public' . $job->images->first()->image))
                            <img class="img-thumbnail" src="{{ asset('storage' . $job->images->first()->image) }}"
                                alt="" />
                        @else
                            <img class="img-thumbnail" src="{{ asset('img/default-avatar.png') }}" alt="No hay foto" />
                        @endif
                        <h3>{{ $job->fullOs }}</h3>
                        <a href="{{ route('motores.show', $motor) }}">
                            <h5>{{ $motor->fullos }}</h5>
                        </a>
                        <span>{{ $motor->cliente->cliente }}</span>
                        @if ($job->finished)
                            <span class="badge badge-soft-success">Trabajo Finalizado</span>
                        @else
                        <span class="badge badge-soft-danger">Trabajo en Proceso</span>
                        @endif
                        
                        @foreach ($job->usersAssigned as $tecnico)
                            <p class="my-1">
                                <a href="{{ route('motores.index.search', $tecnico->name) }}"> <span><i
                                            class="far fa-user mx-3"></i>{{ $tecnico->name }} </span></a>
                            </p>
                        @endforeach
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
                               {{--  @livewire('admin.horas-extras', ['motor' => $motor]) --}}
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <button class="btn btn-falcon-primary me-1 mb-1 little-button" type="button"
                                    wire:click="$emit('openAsignacionesJobModal', {{$job->id }})"
                                    @if ($motor->fin) disabled @endif>
                                    <span><i class="fas fa-user-plus mx-1"></i> Asignar a Tecnico </span></a>
                                </button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @livewire('motors.pedido-materiales', ['motor' => $motor])
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
               
                <h3>Informacion del Trabajo Adicional</h3>
                <table class="table table-hover table-striped table-bordered " style="">
                    <tr>
                        <td width="20%">Tipo de Trabajo</td>
                        <td colspan="5">
                            {{ $job->jobType->name }}
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">{{ $job->jobType->campo1 }}</td>
                        <td colspan="5">
                            {{ $job->value_campo1 }}
                        </td>
                    </tr>
                    @if ($job->jobType->campo2)
                        <tr>
                            <td>{{ $job->jobType->campo2 }}</td>
                            <td colspan="5">
                                {{ $job->value_campo2 }}
                            </td>
                        </tr>
                    @endif

                </table>
            </x-pretty-card>
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
                <h3>Fechas Importantes</h3>
                <table class="table table-striped table-datos">
                    <colgroup>
                        <col class="bg-soft-primary" />
                        <col />

                    </colgroup>
                    <tr>
                        <td>Fecha de Creaci&oacute;n de Trabajo</td>
                        <td>
                            <div style="d-block">
                                {{ Carbon\Carbon::parse($job->created_at)->format('d/m/Y') }}
                            </div>

                            <small>
                                {{ Carbon\Carbon::parse($job->created_at)->diffForHumans() }}
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td>Fecha de Finalizaci&oacute;n</td>
                        <td>
                            @if ($job->finished)
                                <div style="d-block">
                                    {{ Carbon\Carbon::parse($job->finished)->format('d/m/Y') }}
                                </div>
                                <small>
                                    {{ Carbon\Carbon::parse($job->finished)->diffForHumans() }}
                                </small>
                            @else
                                <div style="d-block">
                                    <button class="btn btn-falcon-primary me-1 mb-1" type="button" style="font-size:12px" onclick="finalizarJob()">
                                        Finalizar
                                    </button>
                                </div>
                            @endif
                        </td>
                    </tr>
                </table>
            </x-pretty-card>
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
                    height: 350px;
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
                            @foreach ($job->images->sortByDesc('id') as $foto)
                                <div class="swiper-slide">
                                    <img class="slider-img" src="{{ asset('storage' . $foto->image) }}" alt="Foto"
                                        ondblclick="openImageModal('{{ asset('storage' . $foto->image) }}')" />
                                </div>
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
                            @foreach ($job->images->sortByDesc('id') as $foto)
                                <div class="col-12 col-sm-6 col-lg-4 col-xl-4  col-xxl-3 my-2">
                                    <div class="card card-gallery">
                                        <img class="card-img-top" src="{{ asset('storage' . $foto->image) }}"
                                            alt="Foto"
                                            ondblclick="openImageModal('{{ asset('storage' . $foto->image) }}')">
                                        <div class="card-footer">
                                            <p class="card-text">{{ $foto->comentario }}</p>
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

                                        </div>
                                    </div>
                                </div>
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
    @livewire('motors.asignaciones-job-modal',['job' => $job])
    <script>
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
        finalizarJob = function() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres finalizar el trabajo?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, finalizar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('finalizarJob');
                    Swal.fire(
                        'Finalizado!',
                        'El trabajo ha sido finalizado.',
                        'success'
                    )
                }
            })
        }
    </script>
</div>
