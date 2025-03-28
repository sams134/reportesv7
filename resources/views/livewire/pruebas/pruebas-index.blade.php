<div>
    
    <x-pretty-card>
        <div name="header">
            <h2>Pruebas de <a href="{{ route('motores.show', $motor) }}">{{ $motor->fullos }}</a></h2>
        </div>
        <div name="body">
            <div class="row">
                <div class="col-md-12">
                    {{-- The Master doesn't talk, he acts. --}}
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link" id="bearings-tab" data-bs-toggle="tab"
                                href="#tab-bearings" role="tab" aria-controls="tab-bearings"
                                aria-selected="true">Rodamientos</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="fit-tab" data-bs-toggle="tab"
                                href="#tab-fit" role="tab" aria-controls="tab-fit"
                                aria-selected="false">Ajustes Tapaderas</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="shaft-tab" data-bs-toggle="tab"
                                href="#tab-shaft" role="tab" aria-controls="tab-shaft"
                                aria-selected="false">Ajustes Ejes</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="inrush-tab" data-bs-toggle="tab" href="#tab-inrush"
                                role="tab" aria-controls="tab-inrush" aria-selected="false">Curva de Arranque</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="current-tab" data-bs-toggle="tab"
                                href="#tab-current" role="tab" aria-controls="tab-current"
                                aria-selected="false">Amperajes</a></li>
                        <li class="nav-item"><a class="nav-link" id="temperature-tab" data-bs-toggle="tab"
                                href="#tab-temperature" role="tab" aria-controls="tab-temperature"
                                aria-selected="false">Temperaturas</a></li>
                        <li class="nav-item"><a class="nav-link" id="vibration-tab" data-bs-toggle="tab"
                                href="#tab-vibration" role="tab" aria-controls="tab-vibration"
                                aria-selected="false">Vibraciones</a></li>
                        <li class="nav-item"><a class="nav-link active" id="surge-tab" data-bs-toggle="tab" href="#tab-surge"
                                role="tab" aria-controls="tab-surge" aria-selected="false">Surge</a></li>


                    </ul>
                    <div class="tab-content border-x border-bottom p-3" id="myTabContent">
                        <div class="tab-pane fade" id="tab-bearings" role="tabpanel"
                            aria-labelledby="bearings-tab">
                            @livewire('pruebas.bearings', ['motor' => $motor])
                        </div>
                        <div class="tab-pane fade" id="tab-fit" role="tabpanel" aria-labelledby="fit-tab">
                            @livewire('pruebas.ajustes', ['motor' => $motor])
                        </div>
                        <div class="tab-pane fade" id="tab-shaft" role="tabpanel" aria-labelledby="shaft-tab">
                            @livewire('pruebas.shaft', ['motor' => $motor])
                        </div>
                        <div class="tab-pane fade" id="tab-inrush" role="tabpanel" aria-labelledby="inrush-tab">
                            inrush
                        </div>
                        <div class="tab-pane fade" id="tab-current" role="tabpanel" aria-labelledby="current-tab">
                            <a href="{{ route('pruebas.reporte', $motor) }}" class="btn btn-falcon-primary me-1 mb-1"
                                type="button">Crear Informe
                            </a>
                        </div>
                        <div class="tab-pane fade" id="tab-temperature" role="tabpanel"
                            aria-labelledby="temperature-tab">
                            @livewire('pruebas.temperaturas', ['motor' => $motor])
                        </div>
                        <div class="tab-pane fade" id="tab-vibration" role="tabpanel" aria-labelledby="vibration-tab">
                            Vibraciones
                        </div>
                        <div class="tab-pane fade  show active" id="tab-surge" role="tabpanel" aria-labelledby="surge-tab">
                            @livewire('pruebas.itig', ['motor' => $motor])
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </x-pretty-card>
</div>
