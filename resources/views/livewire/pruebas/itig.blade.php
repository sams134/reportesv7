<div>
    <x-form-card title="Cargar Folder de Pruebas">
        <div class="row">
            <div class="col-3">
                <button class="btn btn-outline-primary me-1 mb-1" type="button"
                    onclick="document.getElementById('folderInput').click();">
                    <i class="fas fa-folder" style="height:50px"></i><br>
                    Cargar Folder
                </button>
                <!-- Input para seleccionar archivos -->
                <input type="file" id="folderInput" class="d-none" wire:model="folder" multiple>
            </div>
        </div>

        <!-- Listado (opcional) de archivos seleccionados -->
        <div>
            <h5>Archivos seleccionados:</h5>
            <ul>
                @if ($folder)
                    @foreach ($folder as $file)
                        <li>{{ $file->getClientOriginalName() }}</li>
                    @endforeach
                @endif
            </ul>
        </div>

        <!-- Contenedor para las gráficas: se crea un canvas por cada fecha -->
        <div id="chartsContainer">
            @if (isset($pruebas))
                @foreach ($pruebas as $fecha => $datasets)
                    <div style="margin-top:30px;">
                        <h3>Prueba del {{ $fecha }}</h3>
                        <canvas id="chart-{{ $fecha }}"></canvas>
                    </div>
                @endforeach
            @endif
        </div>
        <div>
            <h5>Datos de pruebas:</h5>
            <pre>{{ json_encode($pruebas, JSON_PRETTY_PRINT) }}</pre>
        </div>
    </x-form-card>
    <script src="{{ asset('vendors/chart/chart.min.js') }}"></script>
    <script>
        // Escuchar el evento emitido por Livewire para renderizar las gráficas
        document.addEventListener('livewire:load', function() {
            Livewire.on('renderCharts', (pruebas) => {
                // Obtiene el array de pruebas pasado desde PHP
                console.log('Evento renderCharts recibido', pruebas);


                // Por cada fecha en pruebas, crea una gráfica
                for (const fecha in pruebas) {
                    if (pruebas.hasOwnProperty(fecha)) {
                        const datasets = pruebas[fecha];

                        // Asumimos que cada dataset (clave '1', '2' y '3') es un arreglo con valores numéricos.
                        // Para el eje x, generamos etiquetas basadas en el número de elementos del primer dataset.
                        const dataLength = datasets['1'].length;
                        const labels = Array.from({
                            length: dataLength
                        }, (_, i) => i + 1);

                        // Configuramos los tres datasets con colores: rojo, azul y verde
                        const chartData = {
                            labels: labels,
                            datasets: [{
                                    label: 'Dataset 1',
                                    data: datasets['1'],
                                    borderColor: 'red',
                                    backgroundColor: 'rgba(255, 0, 0, 0.2)',
                                    fill: false,
                                },
                                {
                                    label: 'Dataset 2',
                                    data: datasets['2'],
                                    borderColor: 'blue',
                                    backgroundColor: 'rgba(0, 0, 255, 0.2)',
                                    fill: false,
                                },
                                {
                                    label: 'Dataset 3',
                                    data: datasets['3'],
                                    borderColor: 'green',
                                    backgroundColor: 'rgba(0, 255, 0, 0.2)',
                                    fill: false,
                                }
                            ]
                        };

                        // Obtiene el contexto del canvas correspondiente a la fecha actual
                        const ctx = document.getElementById('chart-' + fecha).getContext('2d');

                        // Crea la gráfica de línea
                        new Chart(ctx, {
                            type: 'line',
                            data: chartData,
                            options: {
                                elements: {
                                    point: {
                                        radius: 0 // Esto deshabilita los puntos
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                }
            });
            Livewire.on('renderMegger', (pruebas) => {
                console.log('Evento renderMegger recibido', pruebas);
                for (const fecha in pruebas) {
                    if (pruebas.hasOwnProperty(fecha)) {
                        const datasets = pruebas[fecha];
                    }
                }
            });
        });
    </script>

</div>
