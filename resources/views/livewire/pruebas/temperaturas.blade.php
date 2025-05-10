<div>

    {{-- The best athlete wants his opponent at his best. --}}
    <div class="card mb-3">
        <div class="card-title">Temperaturas</div>
        <div class="card text-center" wire:ignore>
            <h3 class="p-3" id="timerDisplay">{{ $timeFormatted }}</h3>
            <div class="d-flex text-center justify-content-center mb-3">
                <button class="btn btn-success ms-3 mb-1 me-3 px-8" type="button" id="counter">Iniciar</button>
                <button class="btn btn-primary ms-3 mb-1 me-3 px-8" type="button" id="restart">Reiniciar</button>
            </div>

        </div>
        <div class="card-body">
            <div class="row {{ !$isRunning ? 'd-none' : '' }}" id="register_temp_form">
                <div class="col-4 px-1">
                    <label class="form-label" for="exampleFormControlInput1">Temp. Carga</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">°C </span>
                        <input class="form-control" type="number" placeholder="Temp." aria-label="Username"
                            step="0.1" aria-describedby="basic-addon1" wire:model="carga_t" />
                    </div>
                    @error('carga_t')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-4 px-1">
                    <label class="form-label" for="exampleFormControlInput1">Temp. Opuesto</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">°C </span>
                        <input class="form-control" type="number" placeholder="Temp" aria-label="Username"
                            step="0.1" aria-describedby="basic-addon1" wire:model="opuesto_t" />
                    </div>
                    @error('opuesto_t')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-4 px-1">
                    <label class="form-label" for="exampleFormControlInput1">Temp. Estator</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">°C </span>
                        <input class="form-control" type="number" placeholder="Temp." aria-label="Username"
                            step="0.1" aria-describedby="basic-addon1" wire:model="estator_t" />
                    </div>
                    @error('estator_t')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-11">
                    <button class="btn btn-falcon-primary ms-3 mb-1 me-3 w-100" type="button"
                        wire:click="registerTemp()">Registrar
                        Temperatura
                    </button>
                </div>
            </div>
            <div class="row {{ $motor->temps->count() > 0 ? '' : 'd-none' }}">
                <div class="col-12">
                    <div class="table-responsive scrollbar mt-3">
                        <div class="bg-soft-primary text-center"><strong>Temperaturas</strong></div>
                        <table class="table table-striped overflow-hidden">
                            <colgroup>
                                <col class="bg-soft-primary">
                                <col>
                                <col>
                                <col>
                                <col style="width: 30px;">
                            </colgroup>
                            <thead>
                                <tr class="btn-reveal-trigger">
                                    <th scope="col">Tiempo</th>
                                    <th scope="col">Carga</th>
                                    <th scope="col">Opuesto</th>
                                    <th scope="col">Estator</th>
                                    <th class="text-end" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($motor->temps as $key => $temp)
                                    <tr class="btn-reveal-trigger">
                                        <td>{{ $temp->time }}</td>
                                        <td>{{ $temp->carga }}</td>
                                        <td>{{ $temp->opuesto }}</td>
                                        <td>{{ $temp->estator }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-danger me-1 mb-1" type="button"
                                                onclick="deleteTemp({{ $temp->id }})">Borrar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <button class="btn btn-danger me-1 mb-1" type="button" id="deleteTest">Borrar Prueba
                    </button>
                </div>

            </div>


        </div>
    </div>
    <div class="card mb-3" id="graphDiv" wire:ignore>
        <div class="card-body">
            <canvas class="0" id="grafica" width="418px" height="150px"></canvas>
        </div>
        <button class="btn btn-falcon-primary me-1 mb-1" type="button" id="save">Guardar Grafica
        </button>
    </div>

    <script src="{{ asset('vendors/chart/chart.min.js') }}"></script>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('updateGraph', () => {
                console.log('Actualizando gráfico');
                graph();

            });
            document.getElementById('deleteTest').addEventListener('click', function() {
                Swal.fire({
                    title: '¿Estás seguro de que deseas borrar la prueba?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteTest');
                    }
                });
            });
        });
        deleteTemp = function(id) {
            Swal.fire({
                title: '¿Estás seguro de que deseas borrar la temperatura?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteTemp', id);
                }
            });
        }
        const graph = () => {
            // Obtén el contenedor del canvas
            const container = document.getElementById('grafica').parentNode;
            // Elimina el canvas existente
            const oldCanvas = document.getElementById('grafica');
            if (oldCanvas) {
                oldCanvas.remove();
            }
            // Crea un nuevo canvas con el mismo id y atributos
            const newCanvas = document.createElement('canvas');
            newCanvas.id = 'grafica';
            newCanvas.width = 418;
            newCanvas.height = 150;
            container.appendChild(newCanvas);
            document.getElementById('graphDiv').classList.remove('d-none');
            // Ahora, realiza la llamada al backend y crea el gráfico usando el nuevo canvas
            fetch('/api/get-temperatures/' + {{ $motor->id_motor }})
                .then(response => response.json())
                .then(data => {
                    // Define las opciones del gráfico
                    const getOptions = function() {
                        return {
                            type: 'bar',
                            data: {
                                labels: data.time,
                                datasets: [{
                                        type: 'line',
                                        label: 'Carga',
                                        borderColor: '#007bff',
                                        borderWidth: 2,
                                        fill: false,
                                        data: data.carga,
                                        tension: 0.3
                                    },
                                    {
                                        type: 'line',
                                        label: 'Opuesto',
                                        borderColor: '#dc3545',
                                        borderWidth: 2,
                                        fill: false,
                                        data: data.opuesto,
                                        tension: 0.3
                                    },
                                    {
                                        type: 'line',
                                        label: 'Estator',
                                        borderColor: '#000000',
                                        borderWidth: 2,
                                        fill: false,
                                        data: data.estator,
                                        tension: 0.3
                                    }
                                ]
                            },
                            options: {
                                plugins: {

                                },
                                scales: {
                                    x: {
                                        grid: {
                                            color: '#ccc'
                                        }
                                    },
                                    y: {
                                        grid: {
                                            color: '#ccc'
                                        }
                                    }
                                }
                            }
                        };
                    };


                    chartJsInit(newCanvas, getOptions);
                    setTimeout(() => {
                        //document.querySelector('#save').click();
                    }, 300);
                })
                .catch(error => console.error('Error:', error));
            // guardar la imagen en la base de datos       
        };



        var chartJsInit = function(chartEl, config) {
            if (!chartEl) return;
            // Si se usa Chart.getChart y se destruye la instancia previa, aún así
            // con el canvas nuevo no habrá conflicto
            window.myChart = new Chart(chartEl, config());
        };


        document.querySelector('#save').addEventListener('click', saveGraph);

        function saveGraph() {
            var chartCanvas = document.getElementById('grafica');
            var imageData = chartCanvas.toDataURL(
                'image/png'); // Convierte el gráfico en imagen PNG en formato base64
            fetch('/api/save-temperature-chart', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        image: imageData,
                        motor_id: {{ $motor->id_motor }} // Incluye el ID del motor si es necesario
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Imagen guardada:', data);
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Gráfica guardada con éxito.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            let timer;
            let isRunning = false;
            let elapsed = 0; // Tiempo en milisegundos

            const timerDisplay = document.getElementById('timerDisplay');
            const startStopButton = document.getElementById('counter');
            const restartButton = document.getElementById('restart');

            // Función para formatear el tiempo en "HH:MM:SS:ms"
            function formatTime(ms) {
                const hours = Math.floor(ms / 3600000);
                const minutes = Math.floor((ms % 3600000) / 60000);
                const seconds = Math.floor((ms % 60000) / 1000);
                const milliseconds = ms % 1000;
                return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}:${String(milliseconds/10).padStart(2, '0')}`;
            }

            // Función para iniciar el cronómetro: aumenta 500 ms cada 0.5 seg
            function startTimer() {
                /* document.querySelector('#register_temp_form').classList.remove('d-none'); */
                timer = setInterval(() => {
                    elapsed += 100;
                    timerDisplay.textContent = formatTime(elapsed);

                    // Enviar el tiempo al backend cada 0.5 segundos
                    @this.call('updateTime', elapsed);
                    @this.call('start');
                }, 100);
            }

            function stopTimer() {
                /*  document.querySelector('#register_temp_form').classList.add('d-none'); */
                clearInterval(timer);
                @this.call('stop');
            }

            startStopButton.addEventListener('click', function() {
                if (isRunning) {
                    stopTimer();
                    startStopButton.textContent = 'Iniciar';
                    startStopButton.classList.remove('btn-danger');
                    startStopButton.classList.add('btn-success');
                } else {
                    startTimer();
                    startStopButton.textContent = 'Detener';
                    startStopButton.classList.remove('btn-success');
                    startStopButton.classList.add('btn-danger');
                }
                isRunning = !isRunning;
            });
            // Listener para el botón Reiniciar
            restartButton.addEventListener('click', function() {
                // Detener el timer si está corriendo
                if (isRunning) {
                    stopTimer();
                    startStopButton.textContent = 'Iniciar';
                    startStopButton.classList.remove('btn-danger');
                    startStopButton.classList.add('btn-success');
                    isRunning = false;
                }
                // Reiniciar el tiempo
                totalMs = 0;
                timerDisplay.textContent = formatTime(totalMs);
                // Actualizar el backend con 0
                @this.call('updateTime', totalMs);
            });
        });
        let tempCount = {{ $motor->temps->count() }};
        if (tempCount > 0) {
            document.getElementById('graphDiv').classList.remove('d-none');
            graph();
        } else {
            document.getElementById('graphDiv').classList.add('d-none');
        }
    </script>
</div>
