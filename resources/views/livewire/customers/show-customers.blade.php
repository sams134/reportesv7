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
                    <div class="table-responsive scrollbar">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Os</th>
                                    <th scope="col">Potencia</th>
                                    <th scope="col">Rpm</th>
                                    <th scope="col">Fecha Ingreso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cliente->motors as $cont => $motor)
                                    <tr class="hover-actions-trigger">
                                        <td class="align-middle text-nowrap" style="width: 80px">
                                            {{ $cont + 1 }}
                                        </td>
                                        <td class="align-middle text-nowrap">{{ $motor->year }}-{{ $motor->os }}
                                        </td>
                                        <td class="w-auto">{{ $motor->potencia }}</td>
                                        <td class="align-middle text-nowrap">{{ $motor->rpm }}</td>
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
