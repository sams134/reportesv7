<div>
    {{-- Because she competes with no one, no one can compete with her. --}}

    <x-form-card title="Datos de Placa">
        <div class="row">
            <div class="col-12 col-lg-6">
                <label for="lado_carga">Escoja Origen de Datos</label>
                <select class="form-select mb-3" aria-label="Default select example" wire:model="data_origin">
                    <option selected="">Escoja Origen</option>
                    <option value="1">Placa</option>
                    <option value="2">Densidades</option>
                </select>
                @error('data_origin')
                    <span class="text-danger">Debe seleccionar el origen de los datos de placa</span>
                @enderror

                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Voltaje</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="{{ $motor->volts }}" wire:model.defer="voltaje_placa" />
                    @error('voltaje_placa')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Amperaje</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="{{ $motor->amps }}" wire:model.defer="amperaje_placa" />
                    @error('amperaje_placa')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <label for="sellos">Escoja Conexion segun voltaje escogido</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault1" type="radio" name="flexRadioDefault"
                            wire:model="conexion_placa" value="1" />
                        <label class="form-check-label" for="flexRadioDefault1">Delta</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault2" type="radio" name="flexRadioDefault"
                            wire:model="conexion_placa" value="2" />
                        <label class="form-check-label" for="flexRadioDefault2">Estrella</label>
                    </div>
                </div>
                @error('conexion_placa')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-12 col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Cantidad de Circuitos en paralelo
                        (externos)</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="Serie=1, Paralelo=2," wire:model="circuitos_placa" />
                    @error('circuitos_placa')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Rpm Placa</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="{{ $motor->rpm }}" wire:model="rpm_placa" />
                    @error('rpm_placa')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Hz Placa</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="{{ $motor->hz }}" wire:model="hz_placa" />
                    @error('hz_placa')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card-footer bg-light d-flex justify-content-end">
            <button type="button" class="btn btn-danger me-2" onclick="deleteTestNameplate()">
                Borrar placa y datos de prueba
            </button>

            <button type="button" class="btn btn-primary" wire:click="saveNameplate">
                @if ($tested)
                    Actualizar datos de placa
                @else
                    Registrar datos de placa
                @endif
            </button>
        </div>
    </x-form-card>

    <x-form-card title="Datos de Prueba">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Volts &phi; 1</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="Voltaje Fase 1 Prueba" wire:model.defer="voltaje_1" />
                    @error('voltaje_1')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Volts &phi; 2</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="Voltaje Fase 2 Prueba" wire:model.defer="voltaje_2" />
                    @error('voltaje_2')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Volts &phi; 3</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="Voltaje Fase 3 Prueba" wire:model.defer="voltaje_3" />
                    @error('voltaje_3')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Amps &phi; 1</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="Amperaje Fase 1 Prueba" wire:model.defer="amperaje_1" />
                    @error('amperaje_1')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Amps &phi; 2</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="Amperaje Fase 2 Prueba" wire:model.defer="amperaje_2" />
                    @error('amperaje_2')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Amps &phi; 3</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="Amperaje Fase 3 Prueba" wire:model.defer="amperaje_3" />
                    @error('amperaje_3')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <label for="sellos">Escoja Conexion Realizada para la prueba</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault3" type="radio"
                            name="flexRadioDefault2" wire:model="conexion_realizada" value="1" />
                        <label class="form-check-label" for="flexRadioDefault3">Delta</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault4" type="radio"
                            name="flexRadioDefault2" wire:model="conexion_realizada" value="2" />
                        <label class="form-check-label" for="flexRadioDefault4">Estrella</label>
                    </div>
                </div>
                @error('conexion_realizada')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Cantidad de Circuitos en paralelo
                        (realizados en la prueba)</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="Serie=1, Paralelo=2," wire:model="circuitos_prueba" />
                    @error('circuitos_prueba')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">RPM</label>
                    <input class="form-control" id="exampleFormControlInput1" type="number" step="1"
                        placeholder="Rpm leidas con tacometro" wire:model="rpm_prueba" />
                    @error('rpm_prueba')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card-footer bg-light d-flex justify-content-end">
            <button type="button" class="btn btn-danger me-2" onclick="deleteTest()">
                Borrar prueba
            </button>

            <button type="button" class="btn btn-primary" wire:click="saveTest">
                @if ($tested)
                    Actualizar prueba en vacio
                @else
                    Registrar prueba en vacio
                @endif
            </button>
        </div>
    </x-form-card>

    {{-- WRAP RESULTADOS: NO LO ELIMINES --}}
    <div id="wrapResultados" class="{{ $tested ? '' : 'd-none' }}">
        <x-form-card title="Resultados de Prueba">
            <h3>Resumen</h3>

            @php $alerts = false; @endphp

            @if ((abs($rpm_prueba - $rpm_placa) / $rpm_placa) * 100 > 5)
                <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                    <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span>
                    </div>
                    <p class="mb-0 flex-1">La velocidad del equipo no es correcta... Revisar conexi&oacute;n y carga.
                    </p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @php $alerts = true; @endphp
            @endif

            @if (($promA / $amperaje_placa) * 100 * $fct * $fpt > $limit_max)
                <div class="alert alert-warning border-2 d-flex align-items-center" role="alert">
                    <div class="bg-warning me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span>
                    </div>
                    <p class="mb-0 flex-1">El amperaje es muy alto, revisar y validar.</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @php $alerts = true; @endphp
            @endif

            @if (($promA / $amperaje_placa) * 100 * $fct * $fpt < $limit_min)
                <div class="alert alert-warning border-2 d-flex align-items-center" role="alert">
                    <div class="bg-warning me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span>
                    </div>
                    <p class="mb-0 flex-1">El amperaje es muy bajo, revisar conexion o cambie relacion de CTs y Pts</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @php $alerts = true; @endphp
            @endif

            @if (($isVoltageBalanced && $inbalance > 5) || (!$isVoltageBalanced && $desbalanceA > 8))
                <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                    <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span>
                    </div>
                    <p class="mb-0 flex-1">Hay un exceso de desbalance en corriente, alterne lineas y considere colocar
                        funcion de balancear con desbalance correcto</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @php $alerts = true; @endphp
            @endif

            @if (!$alerts)
                <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
                    <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span>
                    </div>
                    <p class="mb-0 flex-1">Todo se ve bien...</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12 col-md-6 col-xxl-4">
                    <div
                        style="border: 1px solid #ccc; padding: 0px; border-radius: 5px; text-align: center; background-color: #555;">
                        <h4 style="color: aliceblue" class="mb-0">Datos de
                            {{ $data_origin == 1 ? 'Placa' : 'Densidades' }}</h4>
                    </div>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Voltaje Placa</td>
                                <td>{{ $voltaje_placa }} VAC</td>
                            </tr>
                            <tr>
                                <td>Amperaje Placa</td>
                                <td>{{ $amperaje_placa }} A</td>
                            </tr>
                            <tr>
                                <td>Hz</td>
                                <td>{{ $hz_placa }} Hz</td>
                            </tr>
                            <tr>
                                <td>Conexion</td>
                                <td>{{ $circuitos_placa }} {{ $conexion_placa == 1 ? 'Δ' : 'Y' }}</td>
                            </tr>
                            <tr>
                                <td>RPM</td>
                                <td>{{ $rpm_placa }}</td>
                            </tr>
                            <tr>
                                <td>Polos</td>
                                <td>{{ $polos }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-12 col-md-6 col-xxl-4">
                    <div
                        style="border: 1px solid #ccc; padding: 0px; border-radius: 5px; text-align: center; background-color: #555;">
                        <h4 style="color: aliceblue" class="mb-0">Datos de Prueba</h4>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <th>Fase</th>
                            <th>Voltaje</th>
                            <th>Amperaje</th>
                            <th>% Carga</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A</td>
                                <td>{{ $v1 * $fpt }} VAC</td>
                                <td>{{ $a1 * $fct * $fpt }} A</td>
                                <td>{{ $c1 * $fct * $fpt }} %</td>
                            </tr>
                            <tr>
                                <td>B</td>
                                <td>{{ $v2 * $fpt }} VAC</td>
                                <td>{{ $a2 * $fct * $fpt }} A</td>
                                <td>{{ $c2 * $fct * $fpt }} %</td>
                            </tr>
                            <tr>
                                <td>C</td>
                                <td>{{ $v3 * $fpt }} VAC</td>
                                <td>{{ $a3 * $fct * $fpt }} A</td>
                                <td>{{ $c3 * $fct * $fpt }} %</td>
                            </tr>

                            <tr style="font-weight: bold">
                                <td>Promedio</td>
                                <td>{{ number_format($promV * $fpt, 1) }} VAC</td>
                                <td>{{ number_format($promA * $fct * $fpt, 1) }}</td>
                                <td>{{ number_format(($promA / $amperaje_placa) * 100 * $fct * $fpt, 2) }}%</td>
                            </tr>

                            <tr>
                                <td>Desbalance</td>
                                <td>{{ $isVoltageBalanced ? number_format($inbalance, 2) : number_format($desbalanceV, 2) }}
                                    %</td>
                                <td>{{ $isVoltageBalanced ? number_format($inbalance * 2.1, 2) : number_format($desbalanceA, 2) }}
                                    %</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Velocidad</td>
                                <td colspan="2">{{ $rpm_prueba }}</td>
                                <td>{{ number_format(($rpm_prueba / $rpm_placa) * 100, 1) }}%</td>
                            </tr>

                            <tr>
                                <td>Conexion</td>
                                <td colspan="3">{{ $circ }} {{ $con == 1 ? 'Δ' : 'Y' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-12 col-md-6 col-xxl-4">
                    <div
                        style="border: 1px solid #ccc; padding: 0px; border-radius: 5px; text-align: center; background-color: #555;">
                        <h4 style="color: aliceblue" class="mb-0">% Carga</h4>
                    </div>

                    {{-- wire:ignore para que Livewire no toque el SVG --}}
                    <div wire:ignore id="chartDiv2"
                        data-valor="{{ $tested ? number_format(($promA / $amperaje_placa) * 100 * $fct * $fpt, 1) : '' }}"
                        data-min="{{ $tested ? $limit_min ?? 10 : '' }}"
                        data-max="{{ $tested ? $limit_max ?? 90 : '' }}" style="max-width: 100%; height:300px;">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end my-3">
                <div class="@if (!$usePT) d-none @else d-flex justify-content-end @endif ">
                    <div class="input-group me-2" style="max-width:160px">
                        <button class="input-group-text" style="cursor: pointer;" wire:click="change_forcePT()">
                            @if ($force_pt)
                                <i class="fas fa-lock me-2 text-danger"></i>
                            @else
                                <i class="fas fa-lock-open me-2 text-secondary"></i>
                            @endif
                            PT
                        </button>
                        <input class="form-control" type="number" step="0.1" wire:model="fpt"
                            min="0" />
                    </div>

                    <div class="input-group me-2" style="max-width:160px">
                        <button class="input-group-text" style="cursor: pointer;" wire:click="change_forceCT()">
                            @if ($force_ct)
                                <i class="fas fa-lock me-2 text-danger"></i>
                            @else
                                <i class="fas fa-lock-open me-2 text-secondary"></i>
                            @endif
                            CT
                        </button>
                        <input class="form-control" type="number" step="0.1" wire:model="fct"
                            min="0" />
                    </div>
                </div>

                <div class="input-group me-2" style="max-width:240px">
                    <span class="input-group-text">% Desbalance</span>
                    <input class="form-control" type="number" step="0.1" wire:model="inbalance" min="0"
                        oninput="if(this.value===''){this.value='0';}" />
                </div>

                <button type="button" class="btn {{ $usePT ? 'btn-success' : 'btn-secondary' }} me-2"
                    wire:click="usePTFunc">
                    {{ $usePT ? 'Usando relaciones PT y CT' : 'Usar Relaciones PT y CT' }}
                </button>

                <button type="button" class="btn {{ $isVoltageBalanced ? 'btn-success' : 'btn-secondary' }} me-2"
                    wire:click="balanceData">
                    {{ $isVoltageBalanced ? ' Usando data ' : 'Usar data' }} balanceada
                </button>

                @if (!$motor->fin || auth()->user()->userType == 1)
                    <button type="button" class="btn btn-{{ $recorded ? 'success' : 'primary' }}"
                        wire:click="exportResults">
                        {{ $recorded ? 'Actualizar Resultados' : 'Exportar Resultados' }}
                    </button>
                @else
                    <button type="button" class="btn btn-secondary" disabled>Motor Finalizado</button>
                @endif
            </div>

            <h3>Tabla Referencia Consumo Amperajes en vacio</h3>
            <div class="card col-12 d-flex justify-content-center">
                <table class="table text-center" style="width:60%">
                    <thead>
                        <th class="text-center">#Polos</th>
                        <th class="text-center">% Corriente M&iacute;nima</th>
                        <th class="text-center">% Corriente M&aacute;xima</th>
                    </thead>
                    @foreach ($noLoadAmps as $amps)
                        <tr @if ($amps->poles == $polos) class="bg-soft-primary" @endif>
                            <td>{{ $amps->poles }}</td>
                            <td>{{ $amps->minA }} %</td>
                            <td>{{ $amps->maxA }} %</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </x-form-card>
    </div>

    @push('scripts')
        <script src="https://code.jscharting.com/latest/jscharting.js"></script>
        <script>
            let chart = null;
            window.__pendingGauge = null;

            function safeNumber(n, fallback = 0) {
                n = Number(n);
                return Number.isFinite(n) ? n : fallback;
            }

            function destroyChartIfAny() {
                try {
                    if (chart) chart.destroy();
                } catch (e) {}
                chart = null;
            }

            function initCargaGauge(valor, limitI, limitS) {
                chart = JSC.chart('chartDiv2', {
                    chartArea: {
                        fill: '#f9fafd',
                        gradient: 'none'
                    },
                    debug: false,
                    legend_visible: false,
                    defaultTooltip_enabled: false,
                    xAxis_spacingPercentage: 0.4,
                    yAxis: [{
                        id: 'ax1',
                        defaultTick: {
                            padding: 10,
                            enabled: false
                        },
                        customTicks: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120],
                        line: {
                            width: 10,
                            breaks: {},
                            color: 'smartPalette:pal1'
                        },
                        scale_range: [0, 100]
                    }],
                    defaultSeries: {
                        type: 'gauge column roundcaps',
                        shape: {
                            label: [{
                                    text: '%max' + '%',
                                    align: 'center',
                                    verticalAlign: 'middle',
                                    style_fontSize: 28
                                },
                                {
                                    text: '%name',
                                    style_fontSize: 15,
                                    verticalAlign: 'bottom'
                                }
                            ]
                        }
                    },
                    series: [{
                        name: '%FLA',
                        yAxis: 'ax1',
                        palette: {
                            id: 'pal1',
                            pointValue: '{%yValue}',
                            ranges: [{
                                    value: [0, limitI * .8],
                                    color: '#FF5353'
                                },
                                {
                                    value: [limitI * .81, limitI],
                                    color: '#FFD221'
                                },
                                {
                                    value: [limitI, limitS],
                                    color: '#21D683'
                                },
                                {
                                    value: [limitS, limitS * 1.2],
                                    color: '#FFD221'
                                },
                                {
                                    value: [limitS * 1.2, 100],
                                    color: '#FF5353'
                                }
                            ]
                        },
                        points: [
                            ['x', valor]
                        ]
                    }]
                });
            }

            function drawGaugeWhenReady(valor, limitI, limitS, tries = 0) {
                // si escondés resultados con d-none, lo mostramos aquí
                const wrap = document.getElementById('wrapResultados');
                if (wrap) wrap.classList.remove('d-none');

                const el = document.getElementById('chartDiv2');
                if (!el) {
                    if (tries < 240) return requestAnimationFrame(() => drawGaugeWhenReady(valor, limitI, limitS, tries + 1));
                    return console.warn('❌ chartDiv2 no apareció');
                }

                const visible = el.offsetParent !== null;
                const hasSize = el.clientWidth > 20 && el.clientHeight > 20;
                if (!visible || !hasSize) {
                    if (tries < 240) return requestAnimationFrame(() => drawGaugeWhenReady(valor, limitI, limitS, tries + 1));
                    return console.warn('❌ chartDiv2 sin tamaño', el.clientWidth, el.clientHeight);
                }

                valor = safeNumber(valor);
                limitI = safeNumber(limitI, 10);
                limitS = safeNumber(limitS, 90);

                destroyChartIfAny();
                initCargaGauge(valor, limitI, limitS);
            }

            function initGaugeFromDom() {
                const el = document.getElementById('chartDiv2');
                if (!el) return;

                const valor = el.dataset.valor;
                const min = el.dataset.min;
                const max = el.dataset.max;

                if (valor === '' || min === '' || max === '') return; // aún no hay datos

                // mostrar resultados si están ocultos
                const wrap = document.getElementById('wrapResultados');
                if (wrap) wrap.classList.remove('d-none');

                requestAnimationFrame(() => requestAnimationFrame(() => {
                    drawGaugeWhenReady(valor, min, max);
                }));
            }

            // 1) evento: solo guardar payload
            window.addEventListener('amperajes:drawGauge', (e) => {
                const {
                    valor,
                    min,
                    max
                } = e.detail || {};
                window.__pendingGauge = e.detail;

                // dibuja inmediatamente (esto es lo que te faltaba)
                requestAnimationFrame(() => requestAnimationFrame(() => {
                    drawGaugeWhenReady(valor, min, max);
                }));
                console.log('📩 amperajes:drawGauge llegó', e.detail);

            });


            // 2) hook: cuando Livewire termina de pintar DOM, dibujar
            document.addEventListener('livewire:load', () => {
                Livewire.hook('message.processed', () => {
                    initGaugeFromDom();
                    if (!window.__pendingGauge) return;

                    const {
                        valor,
                        min,
                        max
                    } = window.__pendingGauge;
                    window.__pendingGauge = null;

                    requestAnimationFrame(() => requestAnimationFrame(() => {
                        drawGaugeWhenReady(valor, min, max);
                    }));
                });
            });

            // ✅ Swal éxito
            Livewire.on('noLoadTestSaved', function(type) {
                let messages = {
                    1: "Datos de prueba guardados correctamente",
                    2: "Datos de prueba editados correctamente",
                    3: "Datos de placa guardados correctamente",
                    4: "Datos de placa editados correctamente",
                    5: "Se eliminaron los datos de la prueba"
                };

                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: messages[type] || "Operación realizada correctamente",
                    timer: 3000,
                    showConfirmButton: false
                });
            });

            // ✅ Confirmaciones borrar (porque tu blade los llama con onclick)
            function deleteTestNameplate() {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "Esta acción eliminará los datos de la prueba y datos de placa.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('deleteTestNameplate');
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: 'Los datos fueron eliminados.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            }
            window.deleteTestNameplate = deleteTestNameplate;

            function deleteTest() {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "Esta acción eliminará los datos de la prueba, pero mantendrá los datos de placa.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('deleteTest');
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: 'La prueba fue eliminada.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            }
            window.deleteTest = deleteTest;

            // ✅ Export SVG (si lo estás usando)
            function saveGraphNoLoadViaSVG() {
                const container = document.getElementById('chartDiv2');
                const innerDiv = container?.querySelector('div[id^="JSCharting_"]');
                const svgEl = innerDiv?.getElementsByTagName('svg')[0];

                if (!svgEl) {
                    console.error('❌ SVG no encontrado para exportar');
                    return;
                }

                const svgStr = new XMLSerializer().serializeToString(svgEl);
                const svgBlob = new Blob([svgStr], {
                    type: 'image/svg+xml;charset=utf-8'
                });
                const url = URL.createObjectURL(svgBlob);

                const img = new Image();
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = svgEl.clientWidth;
                    canvas.height = svgEl.clientHeight;
                    canvas.getContext('2d').drawImage(img, 0, 0);
                    URL.revokeObjectURL(url);

                    canvas.toBlob(pngBlob => {
                        const reader = new FileReader();
                        reader.onloadend = () => {
                            fetch('/api/save-no-load-chart', {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify({
                                    image: reader.result,
                                    motor_id: {{ $motor->id_motor }}
                                })
                            }).catch(err => console.error('Fetch error:', err));
                        };
                        reader.readAsDataURL(pngBlob);
                    }, 'image/png');
                };
                img.src = url;
            }

            function waitForSVGThenExport() {
                const container = document.getElementById('chartDiv2');
                if (!container) return;

                const observer = new MutationObserver((mutations, obs) => {
                    const svgEl = container.querySelector('div[id^="JSCharting_"] svg');
                    if (svgEl) {
                        obs.disconnect();
                        saveGraphNoLoadViaSVG();
                    }
                });

                observer.observe(container, {
                    childList: true,
                    subtree: true
                });
            }

            Livewire.on('testExported', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'La prueba fue exportada al informe.',
                    timer: 3000,
                    showConfirmButton: false
                });
                waitForSVGThenExport();
            });
            document.addEventListener('DOMContentLoaded', () => {
                initGaugeFromDom();
            });
        </script>
    @endpush

</div>
