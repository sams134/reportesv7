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
                                        <td class="align-middle text-nowrap">{{ $motor->year }}-{{ $motor->os }}
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
    
                                                    <img src="{{ asset('storage/' . $tecnico->foto) }}" alt=""
                                                        class="rounded-circle mt-2">
    
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
</div>
