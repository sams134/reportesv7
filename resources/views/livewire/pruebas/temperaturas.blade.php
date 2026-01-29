<div>

    {{-- The best athlete wants his opponent at his best. --}}
    <div class="card mb-3">
        <div class="card-title">Temperaturas</div>
        <div class="card text-center" wire:ignore>
            <h3 class="p-3" id="timerDisplay">{{ $timeFormatted }}</h3>
            <div class="d-flex text-center justify-content-center mb-3">
                <button class="btn btn-success ms-3 mb-1 me-3 px-8" type="button" id="counter">Iniciar</button>
                <button class="btn btn-primary ms-3 mb-1 me-3 px-8" type="button" id="restart">Reiniciar</button>
                <button class="btn btn-secondary ms-3 mb-1 me-3 px-8" type="button" wire:click="toggleManualMode">
                    Ingreso manual
                </button>
            </div>

        </div>
        <div class="card-body">
            <div class="row {{ !$isRunning && !$manualMode ? 'd-none' : '' }}" id="register_temp_form">
                @if ($manualMode)
                    <div class="row">
                        <div class="col-4 px-1">
                            <label class="form-label">Segundos</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">s</span>
                                <input class="form-control" type="number" min="0"
                                    placeholder="Ej: 60, 900, 1832" wire:model="manual_seconds" />
                            </div>
                            @error('manual_seconds')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>
                @endif

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
                    @if (!$manualMode)
                        <button class="btn btn-falcon-primary ms-3 mb-1 me-3 w-100" type="button"
                            wire:click="registerTemp()">Registrar
                            Temperatura
                        </button>
                    @else
                        <button class="btn btn-falcon-primary ms-3 mb-1 me-3 w-100" type="button"
                            wire:click="registerTempManual">
                            Registrar Temperatura (Manual)
                        </button>
                    @endif
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
                                        <td>{{ $temp->carga }} &deg;C</td>
                                        <td>{{ $temp->opuesto }} &deg;C</td>
                                        <td>{{ $temp->estator }} &deg;C</td>
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
        <div id="chartSaveStatus" class="mt-2 text-muted" style="font-size:12px;"></div>

        <div id="chartPreviewWrap" class="mt-2 d-none" style="max-width:520px;">
            <div class="text-muted" style="font-size:12px; margin-bottom:6px;">Vista previa (última guardada)</div>
            <img id="chartPreviewImg" src="" style="width:100%; border:1px solid #ddd; border-radius:6px;">
        </div>
    </div>

    <div class="card mb-3">
        <x-form-card title="Termografía (pegar desde clipboard)">

            <style>
                .clipboard-box {
                    border: 2px dashed #6c757d;
                    padding: 10px;
                    border-radius: 10px;
                    cursor: pointer;
                    background-color: #f8f9fa;
                    height: 260px;
                    /* un poco más alto */
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                }

                .thermo-footer {
                    margin-top: 6px;
                    text-align: center;
                }

                .preview-wrapper {
                    width: 100%;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    overflow: hidden;
                }

                .img-preview {
                    max-width: 100%;
                    max-height: 100%;
                    object-fit: contain;
                    border-radius: 6px;
                }
            </style>

            @php
                $slots = [
                    1 => ['type' => 71, 'label' => 'Termografía 1', 'saved' => $thermo71, 'uploadProp' => 'thermo1'],
                    2 => ['type' => 72, 'label' => 'Termografía 2', 'saved' => $thermo72, 'uploadProp' => 'thermo2'],
                    3 => ['type' => 73, 'label' => 'Termografía 3', 'saved' => $thermo73, 'uploadProp' => 'thermo3'],
                ];
            @endphp

            <div class="row g-3">
                @foreach ($slots as $i => $s)
                    <div class="col-md-4">
                        <div class="clipboard-box text-center paste-zone-thermo" data-index="{{ $i }}"
                            contenteditable="true">

                            @if ($s['saved'])
                                <div class="preview-wrapper">
                                    <img src="{{ asset('storage' . $s['saved']->foto) }}" class="img-preview" />
                                </div>

                                <div class="thermo-footer">
                                    <button class="btn btn-sm btn-outline-danger px-3" type="button"
                                        wire:click="deleteThermoByType({{ $s['type'] }})">
                                        <i class="fas fa-trash-alt me-1"></i> Eliminar
                                    </button>
                                </div>
                            @else
                                @php $prop = $s['uploadProp']; @endphp

                                @if ($$prop)
                                    <div class="preview-wrapper">
                                        <img src="{{ $$prop->temporaryUrl() }}" class="img-preview" />
                                    </div>
                                @else
                                    <i class="fas fa-paste fa-2x mb-2 text-muted"></i>
                                    <p class="mb-0"><strong>{{ $s['label'] }}</strong></p>
                                    <small class="text-muted">Clic aquí y Ctrl + V</small>
                                @endif
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>


            <div class="mt-3 d-flex gap-2">
                <button class="btn btn-primary" type="button" wire:click="saveThermography">
                    <i class="fas fa-save"></i> Guardar imágenes
                </button>
            </div>

            <hr class="my-3">

            <div class="card mb-3">
                <div class="card-body">
                    <label class="form-label"><strong>Comentario (Temperaturas)</strong></label>
                    <textarea class="form-control" rows="3"
                        placeholder="Ej: La temperatura incrementó de forma estable, con aumento notable después de 15 min..."
                        wire:model.defer="temp_comment"></textarea>

                    <div class="mt-2">
                        <button class="btn btn-secondary" type="button" wire:click="saveTempComment">
                            Guardar comentario
                        </button>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('livewire:load', function() {
                    function bindThermoZones() {
                        document.querySelectorAll('.paste-zone-thermo').forEach(zone => {
                            if (zone.dataset.bound === "1") return;
                            zone.dataset.bound = "1";

                            zone.addEventListener('click', () => zone.focus());

                            zone.addEventListener('paste', function(e) {
                                const items = (e.clipboardData || e.originalEvent.clipboardData).items;

                                for (const item of items) {
                                    if (item.type.includes('image')) {
                                        const file = item.getAsFile();
                                        const idx = zone.dataset.index;

                                        if (idx === "1") @this.upload('thermo1', file, () => {});
                                        if (idx === "2") @this.upload('thermo2', file, () => {});
                                        if (idx === "3") @this.upload('thermo3', file, () => {});

                                        e.preventDefault();
                                        return;
                                    }
                                }
                            });
                        });
                    }

                    bindThermoZones();
                    Livewire.hook('message.processed', () => bindThermoZones());
                });
            </script>

        </x-form-card>
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
                                        borderColor: '#0070C0',
                                        borderWidth: 2,
                                        fill: false,
                                        data: data.carga,
                                        tension: 0.2
                                    },
                                    {
                                        type: 'line',
                                        label: 'Opuesto',
                                        borderColor: '#C00000',
                                        borderWidth: 2,
                                        fill: false,
                                        data: data.opuesto,
                                        tension: 0.2
                                    },
                                    {
                                        type: 'line',
                                        label: 'Estator',
                                        borderColor: '#4B4B4B',
                                        borderWidth: 2,
                                        fill: false,
                                        data: data.estator,
                                        tension: 0.2
                                    },
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Registro de Temperaturas en operación',
                                        font: {
                                            size: 20,
                                            weight: 'bold'
                                        }
                                    },
                                    legend: {
                                        display: true,
                                        position: 'top'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const label = context.dataset.label || '';
                                                const value = context.parsed.y;
                                                return `${label}: ${value} °C`;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Tiempo',

                                        },
                                        grid: {
                                            color: '#ccc'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Temperatura (°C)'
                                        },
                                        ticks: {
                                            callback: function(value) {
                                                return value + ' °C';
                                            }
                                        },
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

        async function saveGraph() {
            const btn = document.querySelector('#save');
            const status = document.getElementById('chartSaveStatus');
            const previewWrap = document.getElementById('chartPreviewWrap');
            const previewImg = document.getElementById('chartPreviewImg');

            try {
                // si no hay chart, no guardes
                if (!window.myChart) {
                    Swal.fire({
                        title: 'Sin gráfica',
                        text: 'Primero genera la gráfica antes de guardar.',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                // UI: deshabilitar y mostrar estado
                btn.disabled = true;
                status.textContent = 'Guardando gráfica...';

                // Asegurar que el chart terminó de dibujar
                // (muy importante porque tú recreas canvas y chart)
                await new Promise(requestAnimationFrame);

                // Mejor que toDataURL: usa la función propia de Chart.js (más confiable)
                const imageData = window.myChart.toBase64Image(); // PNG base64

                const resp = await fetch('/api/save-temperature-chart', {
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
                        motor_id: {{ $motor->id_motor }}
                    })
                });

                // Manejo fino de errores HTTP
                if (!resp.ok) {
                    const text = await resp.text().catch(() => '');
                    throw new Error(`HTTP ${resp.status} ${resp.statusText} ${text}`);
                }

                const data = await resp.json();

                // Preview desde BLOB endpoint (no depende de data.url)
                const url = '/api/temperature-chart/{{ $motor->id_motor }}?t=' + Date.now();
                previewImg.src = url;
                previewWrap.classList.remove('d-none');

                status.textContent = 'Gráfica guardada correctamente.';

                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Gráfica guardada con éxito.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });

                // Preview
                if (data.url) {
                    previewImg.src = data.url + '?t=' + Date.now(); // cache-bust
                    previewWrap.classList.remove('d-none');
                }

            } catch (err) {
                console.error('Error guardando gráfica:', err);
                status.textContent = 'Error al guardar la gráfica.';

                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo guardar la gráfica. Revisa consola o inténtalo de nuevo.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });

            } finally {
                btn.disabled = false;
            }
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
