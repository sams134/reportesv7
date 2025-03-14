<div>
    <style>
        .ajustes td {
            border: 0px solid #444;
            padding: 1px;
        }

        .bearing-data {
            border: 1px solid #444;
        }

        .bearing-data td {

            padding: 1px;
            font-size: 12px;
            text-align: left;
        }

        .bearing-data tr:nth-child(odd) {
            background-color: #a8a9aa;
        }

        .tolerancias td,
        th {
            padding: 3px;
            font-size: 12px;
            text-align: left;
        }
    </style>
    @if (!$allowed_initial)
        <div class="row">
            <div class="col-11 card m-3">
                <h3>Aun no se han completado datos iniciales de rodamientos</h3>
            </div>
        </div>
    @else
        <x-form-card title="Alojamiento Lado de Carga">
            <div class="row">
                <div class="col-3 d-none d-md-block" style="vertical-align: middle">
                    <img src="{{ asset('img/tapas.png') }}" alt="" style="max-width: 100%" class="mt-3">

                    <table class="table table-striped bearing-data mt-2">
                        <tr>
                            <td colspan="2" style="text-align: center;background:#e8e9ea">
                                <h6 style="font-weight: bold">{{ $ajustes[0][0]['designacion'] }} </h6>
                            </td>
                        <tr>
                            <td>Diametro Externo</td>
                            <td> {{ $ajustes[0][0]['rod']['rodamiento']['diametro_externo'] }} mm</td>
                        </tr>
                        <tr>
                            <td>Diametro Interno</td>
                            <td> {{ $ajustes[0][0]['rod']['rodamiento']['diametro_interno'] }} mm</td>
                        </tr>
                    </table>
                    @if ($ajustes[0][0]['designacion'] != $ajustes[1][0]['designacion'])
                        <img src="{{ asset('img/alert.png') }}" alt="" style="max-width: 30px" class="mt-1">
                        <span class="text-danger">Cambio de rodamiento!</span>
                    @endif
                </div>
                <div class="col-12 col-md-9">
                    <x-form-card title="Medidas Iniciales Carga">
                        <div class="table-responsive scrollbar mt-0">
                            <table class="table ajustes">
                                <thead>
                                    <tr>
                                        <th scope="col">Posicion A </th>
                                        <th scope="col">Posicion B</th>
                                        @if ($ajustes[0][0]['rod']['rodamiento']['diametro_externo'] > 140)
                                            <th scope="col">Posicion C</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group "><span class="input-group-text"
                                                    id="basic-addon1">AX</span>
                                                <input class="form-control" type="number" step="0.001"
                                                    placeholder="medida [mm]" aria-label="Username"
                                                    aria-describedby="basic-addon1" wire:model.defer="ajustes.0.0.ax" />

                                            </div>
                                            @error('ajustes.0.0.ax')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <div class="input-group "><span class="input-group-text"
                                                    id="basic-addon1">BX</span>
                                                <input class="form-control" type="number" step="0.001"
                                                    placeholder="medida [mm]" aria-label="Username"
                                                    aria-describedby="basic-addon1" wire:model.defer="ajustes.0.0.bx" />
                                            </div>
                                            @error('ajustes.0.0.bx')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        @if ($ajustes[0][0]['rod']['rodamiento']['diametro_externo'] > 140)
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">CX</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="medida [mm]" aria-label="Username"
                                                        aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.0.0.cx" />
                                                </div>
                                                @error('ajustes.0.0.cx')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group "><span class="input-group-text"
                                                    id="basic-addon1">AY</span>
                                                <input class="form-control" type="number" step="0.001"
                                                    placeholder="medida [mm]" aria-label="Username"
                                                    aria-describedby="basic-addon1" wire:model.defer="ajustes.0.0.ay" />
                                            </div>
                                            @error('ajustes.0.0.ay')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <div class="input-group "><span class="input-group-text"
                                                    id="basic-addon1">BY</span>
                                                <input class="form-control" type="number" step="0.001"
                                                    placeholder="medida [mm]" aria-label="Username"
                                                    aria-describedby="basic-addon1" wire:model.defer="ajustes.0.0.by" />
                                            </div>
                                            @error('ajustes.0.0.by')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        @if ($ajustes[0][0]['rod']['rodamiento']['diametro_externo'] > 140)
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">CY</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="medida [mm]" aria-label="Username"
                                                        aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.0.0.cy" />
                                                </div>
                                                @error('ajustes.0.0.cy')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @if ($ajustes[0][0]['ax'])
                                    <div class="text-center">
                                        <div class="text-start text-primary" style="font-size: 1.2rem;">
                                            @if ($allowed_final && $ajustes[1][0]['rod']['p'])
                                                * Medidas comparadas contra las medidas del rodamiento a instalar
                                            @else
                                                * Medidas comparadas contra las teoricas del rodamiento
                                            @endif
                                            @php
                                                $medida_max =
                                                    $allowed_final && $ajustes[1][0]['rod']['p']
                                                        ? max(
                                                            $ajustes[1][0]['rod']['p'],
                                                            $ajustes[1][0]['rod']['q'],
                                                            $ajustes[1][0]['rod']['r'],
                                                        )
                                                        : $ajustes[0][0]['rod']['rodamiento']['diametro_externo'];
                                                $medida_min =
                                                    $allowed_final && $ajustes[1][0]['rod']['p']
                                                        ? min(
                                                            $ajustes[1][0]['rod']['p'],
                                                            $ajustes[1][0]['rod']['q'],
                                                            $ajustes[1][0]['rod']['r'],
                                                        )
                                                        : $ajustes[0][0]['rod']['rodamiento']['diametro_externo'];
                                            @endphp
                                        </div>

                                        <div class="table-responsive scrollbar">
                                            <table class="table table-hover tolerancias" style="font-size: 12px">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Medida</th>
                                                        <th scope="col">Valor [mm]</th>
                                                        <th scope="col">Medida</th>
                                                        <th scope="col">Valor [mm]</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="hover-actions-trigger">
                                                        <td class="align-middle text-nowrap bg-soft-primary">Medida
                                                            Mayor
                                                        </td>
                                                        <td class="align-middle text-nowrap">
                                                            {{ App\Http\Livewire\Pruebas\Ajustes::findMax($ajustes[0][0]) }}
                                                        </td>
                                                        <td class="align-middle text-nowrap  bg-soft-primary">Medida
                                                            menor
                                                        </td>
                                                        <td class="align-middle text-nowrap">
                                                            {{ App\Http\Livewire\Pruebas\Ajustes::findMin($ajustes[0][0]) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">x̅ media
                                                        </td>
                                                        <td>{{ App\Http\Livewire\Pruebas\Ajustes::findMean($ajustes[0][0]) }}
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">
                                                            <i>D<sub>m</sub> </i> desviacion
                                                        </td>
                                                        <td>{{ App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[0][0]) }}%
                                                            @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[0][0]) > 0.1)
                                                                <img src="{{ asset('img/alert.png') }}"
                                                                    alt="" style="max-width: 15px"
                                                                    class="mt-1">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Medida
                                                            Max.
                                                            Rodamiento</td>
                                                        <td>{{ number_format($medida_max, 3) }}
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Medida
                                                            Min.
                                                            Rodamiento</td>
                                                        <td>{{ number_format($medida_min, 3) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">TOL. EASA
                                                            AR-100</td>
                                                        <td>+(0-{{ number_format($ajustes[0][0]['rod']['rodamiento']['H6'] * 1000, 0) }})
                                                            μm</td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">TOL. ISO
                                                            286
                                                        </td>
                                                        <td>+({{ number_format($ajustes[0][0]['rod']['rodamiento']['probable_min'] * 1000, 0) }}-{{ number_format($ajustes[0][0]['rod']['rodamiento']['probable_max'] * 1000, 0) }})
                                                            μm</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            Minimo (ISO 286)
                                                        </td>
                                                        <td>
                                                            @php
                                                                $diff_min =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMin(
                                                                        $ajustes[0][0],
                                                                    ) - $medida_max;
                                                                $diff_min *= 1000;
                                                            @endphp
                                                            {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min), 0) }}
                                                            μm
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            M&aacute;ximo (ISO 286)
                                                        </td>
                                                        <td>
                                                            @php
                                                                $diff =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMax(
                                                                        $ajustes[0][0],
                                                                    ) - $medida_min;
                                                                $diff *= 1000;
                                                            @endphp
                                                            {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff), 0) }}
                                                            μm
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            Minimo
                                                            (EASA AR-100)</td>
                                                        <td>
                                                            @php
                                                                $diff_min =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMin(
                                                                        $ajustes[0][0],
                                                                    ) -
                                                                    $ajustes[0][0]['rod']['rodamiento'][
                                                                        'diametro_externo'
                                                                    ];
                                                                $diff_min *= 1000;
                                                            @endphp
                                                            {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min), 0) }}
                                                            μm
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            M&aacute;ximo (EASA AR-100)
                                                        </td>
                                                        <td>
                                                            @php
                                                                $diff =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMax(
                                                                        $ajustes[0][0],
                                                                    ) -
                                                                    $ajustes[0][0]['rod']['rodamiento'][
                                                                        'diametro_externo'
                                                                    ];
                                                                $diff *= 1000;
                                                            @endphp
                                                            {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff), 0) }}
                                                            μm
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                <div class="col-6">
                                                    @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[0][0]) > 0.1)
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="mt-1">
                                                            <span class="text-danger">Demasiada Ovalacion</span>
                                                        </p>
                                                    @endif
                                                    @if ($diff_min < 0 || $diff_min < $ajustes[0][0]['rod']['rodamiento']['probable_min'] * 1000)
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="">
                                                            <span class="text-danger">Ajuste demasiado apretado</span>
                                                        </p>
                                                    @endif

                                                    @if (
                                                        (App\Http\Livewire\Pruebas\Ajustes::findMax($ajustes[0][0]) -
                                                            $ajustes[0][0]['rod']['rodamiento']['diametro_externo']) *
                                                            1000 >
                                                            $ajustes[0][0]['rod']['rodamiento']['H6'] * 1000)
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/warning.jpg') }}" alt=""
                                                                style="max-width: 15px" class="">
                                                            <span class="text-danger">Ajuste holgado, no cumple con
                                                                norma
                                                                EASA (AR-100)</span>
                                                        </p>
                                                    @endif
                                                    @if ($diff > $ajustes[0][0]['rod']['rodamiento']['probable_max'] * 1000)
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="mt-1">
                                                            <span class="text-danger">Ajuste demasiado holgado, no
                                                                cumple
                                                                con norma SKF (ISO 286)</span>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h4>Decisi&oacute;n del tornero</h4>
                                                    <select class="form-select" aria-label="Default select example"
                                                        wire:model="options.0.0.id" wire:change="saveMedidas(0,0)">
                                                        <option selected="">Seleccione su Decision</option>
                                                        @foreach ($decisiones->where('cuna_eje', 1) as $decision)
                                                            <option value="{{ $decision->id }}">
                                                                {{ $decision->decision }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    * Medidas tomadas por
                                                    {{ $ajustes[0][0]['rod']['userMedida']['name'] }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-12 text-start">
                                                    <label class="form-label"
                                                        for="exampleFormControlTextarea1">Comentarios del
                                                        tornero</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" style="text-transform: capitalize" rows="2"
                                                        wire:model="options.0.0.decision"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <hr>
                                <div class="text-end">
                                    <button class="btn btn-sm btn-primary"
                                        wire:click="saveMedidas(0,0)">Guardar</button>
                                </div>

                            </div>
                        </div>
                    </x-form-card>
                </div>
            </div>
            @if (!$allowed_final)
                <div class="row">
                    <div class="col-11 card m-3">
                        <h3>Aun no se han completado datos finales de rodamientos</h3>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-3 d-none d-md-block" style="vertical-align: middle;text-align:center">
                        <img src="{{ asset('img/tapas.png') }}" alt="" style="max-width: 100%"
                            class="mt-3">


                        <table class="table table-striped bearing-data mt-2">
                            <tr>
                                <td colspan="2" style="text-align: center;background:#e8e9ea">
                                    <h6 style="font-weight: bold">{{ $ajustes[1][0]['designacion'] }}</h6>
                                </td>
                            <tr>
                                <td>Diametro Externo</td>
                                <td> {{ $ajustes[1][0]['rod']['rodamiento']['diametro_externo'] }} mm</td>
                            </tr>
                            <tr>
                                <td>Diametro Interno</td>
                                <td> {{ $ajustes[1][0]['rod']['rodamiento']['diametro_interno'] }} mm</td>
                            </tr>
                            <tr>
                                <td>Medida a 0°</td>
                                <td> {{ $ajustes[1][0]['rod']['p'] }} mm</td>
                            </tr>
                            <tr>
                                <td>Medida a 120°</td>
                                <td> {{ $ajustes[1][0]['rod']['q'] }} mm</td>
                            </tr>
                            <tr>
                                <td>Medida a 240°</td>
                                <td> {{ $ajustes[1][0]['rod']['r'] }} mm</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 col-md-9">
                        <x-form-card title="Medidas Finales Carga">
                            <div class="table-responsive scrollbar mt-0">

                                <table class="table ajustes">
                                    <thead>
                                        <tr>
                                            <th scope="col">Posicion A</th>
                                            <th scope="col">Posicion B</th>
                                            @if ($ajustes[1][0]['rod']['rodamiento']['diametro_externo'] > 140)
                                                <th scope="col">Posicion C</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">AX</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="medida [mm]" aria-label="Username"
                                                        aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.1.0.ax" />
                                                </div>
                                                <style>
                                                    @media (max-width: 768px) {

                                                        .input-group-text,
                                                        .form-control {
                                                            font-size: 0.6rem;
                                                            padding: 3px;
                                                        }
                                                    }
                                                </style>
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">BX</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="medida [mm]" aria-label="Username"
                                                        aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.1.0.bx" />
                                                </div>
                                                @error('ajustes.1.0.bx')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            @if ($ajustes[1][0]['rod']['rodamiento']['diametro_externo'] > 140)
                                                <td>
                                                    <div class="input-group "><span class="input-group-text"
                                                            id="basic-addon1">CX</span>
                                                        <input class="form-control" type="number" step="0.001"
                                                            placeholder="medida [mm]" aria-label="Username"
                                                            aria-describedby="basic-addon1"
                                                            wire:model.defer="ajustes.1.0.cx" />
                                                    </div>
                                                    @error('ajustes.1.0.cx')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">AY</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="medida [mm]" aria-label="Username"
                                                        aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.1.0.ay" />
                                                </div>
                                                @error('ajustes.1.0.ay')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">BY</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="medida [mm]" aria-label="Username"
                                                        aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.1.0.by" />
                                                </div>
                                                @error('ajustes.1.0.by')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            @if ($ajustes[1][0]['rod']['rodamiento']['diametro_externo'] > 140)
                                                <td>
                                                    <div class="input-group "><span class="input-group-text"
                                                            id="basic-addon1">CY</span>
                                                        <input class="form-control" type="number" step="0.001"
                                                            placeholder="medida [mm]" aria-label="Username"
                                                            aria-describedby="basic-addon1"
                                                            wire:model.defer="ajustes.1.0.cy" />
                                                    </div>
                                                    @error('ajustes.1.0.cy')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                  @if($ajustes[1][0]['ax'])
                                    <div class="text-center">
                                        <div class="text-start text-primary" style="font-size: 1.2rem;">

                                            * Medidas comparadas contra las medidas del rodamiento a instalar

                                            @php
                                                $medida_max = max(
                                                    $ajustes[1][0]['rod']['p'],
                                                    $ajustes[1][0]['rod']['q'],
                                                    $ajustes[1][0]['rod']['r'],
                                                );
                                                $medida_min = min(
                                                    $ajustes[1][0]['rod']['p'],
                                                    $ajustes[1][0]['rod']['q'],
                                                    $ajustes[1][0]['rod']['r'],
                                                );
                                            @endphp
                                        </div>

                                        <div class="table-responsive scrollbar">
                                            <table class="table table-hover tolerancias" style="font-size: 12px">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Medida</th>
                                                        <th scope="col">Valor [mm]</th>
                                                        <th scope="col">Medida</th>
                                                        <th scope="col">Valor [mm]</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="hover-actions-trigger">
                                                        <td class="align-middle text-nowrap bg-soft-primary">Medida
                                                            Mayor
                                                        </td>
                                                        <td class="align-middle text-nowrap">
                                                            {{ App\Http\Livewire\Pruebas\Ajustes::findMax($ajustes[1][0]) }}
                                                        </td>
                                                        <td class="align-middle text-nowrap  bg-soft-primary">Medida
                                                            menor
                                                        </td>
                                                        <td class="align-middle text-nowrap">
                                                            {{ App\Http\Livewire\Pruebas\Ajustes::findMin($ajustes[1][0]) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">x̅ media
                                                        </td>
                                                        <td>{{ App\Http\Livewire\Pruebas\Ajustes::findMean($ajustes[1][0]) }}
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">
                                                            <i>D<sub>m</sub> </i> desviacion
                                                        </td>
                                                        <td>{{ App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[1][0]) }}%
                                                            @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[1][0]) > 0.1)
                                                                <img src="{{ asset('img/alert.png') }}"
                                                                    alt="" style="max-width: 15px"
                                                                    class="mt-1">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Medida
                                                            Max.
                                                            Rodamiento</td>
                                                        <td>{{ number_format($medida_max, 3) }}
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Medida
                                                            Min.
                                                            Rodamiento</td>
                                                        <td>{{ number_format($medida_min, 3) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">TOL. EASA
                                                            AR-100</td>
                                                        <td>+(0-{{ number_format($ajustes[1][0]['rod']['rodamiento']['H6'] * 1000, 0) }})
                                                            μm</td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">TOL. ISO
                                                            286
                                                        </td>
                                                        <td>+({{ number_format($ajustes[1][0]['rod']['rodamiento']['probable_min'] * 1000, 0) }}-{{ number_format($ajustes[1][0]['rod']['rodamiento']['probable_max'] * 1000, 0) }})
                                                            μm</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            Minimo (ISO 286)
                                                        </td>
                                                        <td>
                                                            @php
                                                                $diff_min =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMin(
                                                                        $ajustes[1][0],
                                                                    ) - $medida_max;
                                                                $diff_min *= 1000;
                                                            @endphp
                                                            {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min), 0) }}
                                                            μm
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            M&aacute;ximo (ISO 286)
                                                        </td>
                                                        <td>
                                                            @php
                                                                $diff =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMax(
                                                                        $ajustes[1][0],
                                                                    ) - $medida_min;
                                                                $diff *= 1000;
                                                            @endphp
                                                            {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff), 0) }}
                                                            μm
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            Minimo
                                                            (EASA AR-100)</td>
                                                        <td>
                                                            @php
                                                                $diff_min =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMin(
                                                                        $ajustes[1][0],
                                                                    ) -
                                                                    $ajustes[1][0]['rod']['rodamiento'][
                                                                        'diametro_externo'
                                                                    ];
                                                                $diff_min *= 1000;
                                                            @endphp
                                                            {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min), 0) }}
                                                            μm
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            M&aacute;ximo (EASA AR-100)
                                                        </td>
                                                        <td>
                                                            @php
                                                                $diff =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMax(
                                                                        $ajustes[1][0],
                                                                    ) -
                                                                    $ajustes[1][0]['rod']['rodamiento'][
                                                                        'diametro_externo'
                                                                    ];
                                                                $diff *= 1000;
                                                            @endphp
                                                            {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff), 0) }}
                                                            μm
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                <div class="col-6">
                                                    @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[1][0]) > 0.1)
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="mt-1">
                                                            <span class="text-danger">Demasiada Ovalacion</span>
                                                        </p>
                                                    @endif
                                                    @if ($diff_min < 0 || $diff_min < $ajustes[1][0]['rod']['rodamiento']['probable_min'] * 1000)
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="">
                                                            <span class="text-danger">Ajuste demasiado apretado</span>
                                                        </p>
                                                    @endif

                                                    @if (
                                                        (App\Http\Livewire\Pruebas\Ajustes::findMax($ajustes[1][0]) -
                                                            $ajustes[1][0]['rod']['rodamiento']['diametro_externo']) *
                                                            1000 >
                                                            $ajustes[1][0]['rod']['rodamiento']['H6'] * 1000)
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/warning.jpg') }}" alt=""
                                                                style="max-width: 15px" class="">
                                                            <span class="text-danger">Ajuste holgado, no cumple con
                                                                norma
                                                                EASA (AR-100)</span>
                                                        </p>
                                                    @endif
                                                    @if ($diff > $ajustes[1][0]['rod']['rodamiento']['probable_max'] * 1000)
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="mt-1">
                                                            <span class="text-danger">Ajuste demasiado holgado, no
                                                                cumple
                                                                con norma SKF (ISO 286)</span>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h4>Decisi&oacute;n del tornero</h4>
                                                    <select class="form-select" aria-label="Default select example"
                                                        wire:model="options.1.0.id" wire:change="saveMedidas(1,0)">
                                                        <option selected="">Seleccione su Decision</option>
                                                        @foreach ($decisiones->where('cuna_eje', 1) as $decision)
                                                            <option value="{{ $decision->id }}">
                                                                {{ $decision->decision }}</option>
                                                        @endforeach
                                                    </select>

                                                    @if ($ajustes[1][0]['rod']['userMedida'])
                                                        * Medidas tomadas por
                                                        {{ $ajustes[1][0]['rod']['userMedida']['name'] }}
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-12 text-start">
                                                    <label class="form-label"
                                                        for="exampleFormControlTextarea1">Comentarios del
                                                        tornero</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" style="text-transform: capitalize" rows="2"
                                                        wire:model="options.1.0.decision"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                    <hr>
                                    <div class="text-end">
                                        <button class="btn btn-sm btn-primary"
                                            wire:click="saveMedidas(1,0)">Guardar</button>
                                    </div>

                                </div>
                            </div>
                        </x-form-card>
                    </div>
                </div>
            @endif
        </x-form-card>
        <x-form-card title="Alojamiento Lado Opuesto">
            <div class="row">
                <div class="col-3 d-none d-md-block" style="vertical-align: middle">
                    <img src="{{ asset('img/tapas.png') }}" alt="" style="max-width: 100%" class="mt-3">

                    <table class="table table-striped bearing-data mt-2">
                        <tr>
                            <td colspan="2" style="text-align: center;background:#e8e9ea">
                                <h6 style="font-weight: bold">{{ $ajustes[0][1]['designacion'] }} </h6>
                            </td>
                        <tr>
                            <td>Diametro Externo</td>
                            <td> {{ $ajustes[0][1]['rod']['rodamiento']['diametro_externo'] }} mm</td>
                        </tr>
                        <tr>
                            <td>Diametro Interno</td>
                            <td> {{ $ajustes[0][1]['rod']['rodamiento']['diametro_interno'] }} mm</td>
                        </tr>
                    </table>
                    @if ($ajustes[0][1]['designacion'] != $ajustes[1][1]['designacion'])
                        <img src="{{ asset('img/alert.png') }}" alt="" style="max-width: 30px"
                            class="mt-1">
                        <span class="text-danger">Cambio de rodamiento!</span>
                    @endif
                </div>
                <div class="col-12 col-md-9">
                    <x-form-card title="Medidas Iniciales Opuesto">
                        <div class="table-responsive scrollbar mt-0">
                            <table class="table ajustes">
                                <thead>
                                    <tr>
                                        <th scope="col">Posicion A {{ $ajustes[0][1]['ax'] }}</th>
                                        <th scope="col">Posicion B</th>
                                        @if ($ajustes[0][1]['rod']['rodamiento']['diametro_externo'] > 140)
                                            <th scope="col">Posicion C</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group "><span class="input-group-text"
                                                    id="basic-addon1">AX</span>
                                                <input class="form-control" type="number" step="0.001"
                                                    placeholder="medida [mm]" aria-label="Username"
                                                    aria-describedby="basic-addon1"
                                                    wire:model.defer="ajustes.0.1.ax" />

                                            </div>
                                            @error('ajustes.0.1.ax')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </td>
                                        <td>
                                            <div class="input-group "><span class="input-group-text"
                                                    id="basic-addon1">BX</span>
                                                <input class="form-control" type="number" step="0.001"
                                                    placeholder="medida [mm]" aria-label="Username"
                                                    aria-describedby="basic-addon1"
                                                    wire:model.defer="ajustes.0.1.bx" />
                                            </div>
                                            @error('ajustes.0.1.bx')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        @if ($ajustes[0][1]['rod']['rodamiento']['diametro_externo'] > 140)
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">CX</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="medida [mm]" aria-label="Username"
                                                        aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.0.1.cx" />
                                                </div>
                                                @error('ajustes.0.1.cx')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group "><span class="input-group-text"
                                                    id="basic-addon1">AY</span>
                                                <input class="form-control" type="number" step="0.001"
                                                    placeholder="medida [mm]" aria-label="Username"
                                                    aria-describedby="basic-addon1"
                                                    wire:model.defer="ajustes.0.1.ay" />
                                            </div>
                                            @error('ajustes.0.1.ay')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <div class="input-group "><span class="input-group-text"
                                                    id="basic-addon1">BY</span>
                                                <input class="form-control" type="number" step="0.001"
                                                    placeholder="medida [mm]" aria-label="Username"
                                                    aria-describedby="basic-addon1"
                                                    wire:model.defer="ajustes.0.1.by" />
                                            </div>
                                            @error('ajustes.0.1.by')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </td>
                                        @if ($ajustes[0][1]['rod']['rodamiento']['diametro_externo'] > 140)
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">CY</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="medida [mm]" aria-label="Username"
                                                        aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.0.1.cy" />
                                                </div>
                                                @error('ajustes.0.1.cy')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                 @if ($ajustes[1][0]['ax'])
                                <div class="text-center">
                                    <div class="text-start text-primary" style="font-size: 1.2rem;">
                                        @if ($allowed_final && $ajustes[1][1]['rod']['p'])
                                            * Medidas comparadas contra las medidas del rodamiento a instalar
                                        @else
                                            * Medidas comparadas contra las teoricas del rodamiento
                                        @endif
                                        @php
                                            $medida_max = $allowed_final && $ajustes[1][1]['rod']['p']
                                                ? max(
                                                    $ajustes[1][1]['rod']['p'],
                                                    $ajustes[1][1]['rod']['q'],
                                                    $ajustes[1][1]['rod']['r'],
                                                )
                                                : $ajustes[0][1]['rod']['rodamiento']['diametro_externo'];
                                            $medida_min = $allowed_final && $ajustes[1][1]['rod']['p']
                                                ? min(
                                                    $ajustes[1][1]['rod']['p'],
                                                    $ajustes[1][1]['rod']['q'],
                                                    $ajustes[1][1]['rod']['r'],
                                                )
                                                : $ajustes[0][1]['rod']['rodamiento']['diametro_externo'];
                                        @endphp
                                    </div>

                                    <div class="table-responsive scrollbar">
                                        <table class="table table-hover tolerancias" style="font-size: 12px">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Medida</th>
                                                    <th scope="col">Valor [mm]</th>
                                                    <th scope="col">Medida</th>
                                                    <th scope="col">Valor [mm]</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="hover-actions-trigger">
                                                    <td class="align-middle text-nowrap bg-soft-primary">Medida Mayor
                                                    </td>
                                                    <td class="align-middle text-nowrap">
                                                        {{ App\Http\Livewire\Pruebas\Ajustes::findMax($ajustes[0][1]) }}
                                                    </td>
                                                    <td class="align-middle text-nowrap  bg-soft-primary">Medida menor
                                                    </td>
                                                    <td class="align-middle text-nowrap">
                                                        {{ App\Http\Livewire\Pruebas\Ajustes::findMin($ajustes[0][1]) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-nowrap bg-soft-primary">x̅ media</td>
                                                    <td>{{ App\Http\Livewire\Pruebas\Ajustes::findMean($ajustes[0][1]) }}
                                                    </td>
                                                    <td class="align-middle text-nowrap bg-soft-primary">
                                                        <i>D<sub>m</sub> </i> desviacion
                                                    </td>
                                                    <td>{{ App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[0][1]) }}%
                                                        @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[0][1]) > 0.1)
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="mt-1">
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-nowrap bg-soft-primary">Medida Max.
                                                        Rodamiento</td>
                                                    <td>{{ number_format($medida_max, 3) }}
                                                    </td>
                                                    <td class="align-middle text-nowrap bg-soft-primary">Medida Min.
                                                        Rodamiento</td>
                                                    <td>{{ number_format($medida_min, 3) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-nowrap bg-soft-primary">TOL. EASA
                                                        AR-100</td>
                                                    <td>+(0-{{ number_format($ajustes[0][1]['rod']['rodamiento']['H6'] * 1000, 0) }})
                                                        μm</td>
                                                    <td class="align-middle text-nowrap bg-soft-primary">TOL. ISO 286
                                                    </td>
                                                    <td>+({{ number_format($ajustes[0][1]['rod']['rodamiento']['probable_min'] * 1000, 0) }}-{{ number_format($ajustes[0][1]['rod']['rodamiento']['probable_max'] * 1000, 0) }})
                                                        μm</td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-nowrap bg-soft-primary">Ajuste Minimo
                                                        (ISO 286)
                                                    </td>
                                                    <td>
                                                        @php
                                                            $diff_min =
                                                                App\Http\Livewire\Pruebas\Ajustes::findMin(
                                                                    $ajustes[0][1],
                                                                ) - $medida_max;
                                                            $diff_min *= 1000;
                                                        @endphp
                                                        {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min), 0) }}
                                                        μm
                                                    </td>
                                                    <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                        M&aacute;ximo (ISO 286)
                                                    </td>
                                                    <td>
                                                        @php
                                                            $diff =
                                                                App\Http\Livewire\Pruebas\Ajustes::findMax(
                                                                    $ajustes[0][1],
                                                                ) - $medida_min;
                                                            $diff *= 1000;
                                                        @endphp
                                                        {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff), 0) }}
                                                        μm
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-nowrap bg-soft-primary">Ajuste Minimo
                                                        (EASA AR-100)</td>
                                                    <td>
                                                        @php
                                                            $diff_min =
                                                                App\Http\Livewire\Pruebas\Ajustes::findMin(
                                                                    $ajustes[0][1],
                                                                ) -
                                                                $ajustes[0][1]['rod']['rodamiento']['diametro_externo'];
                                                            $diff_min *= 1000;
                                                        @endphp
                                                        {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min), 0) }}
                                                        μm
                                                    </td>
                                                    <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                        M&aacute;ximo (EASA AR-100)
                                                    </td>
                                                    <td>
                                                        @php
                                                            $diff =
                                                                App\Http\Livewire\Pruebas\Ajustes::findMax(
                                                                    $ajustes[0][1],
                                                                ) -
                                                                $ajustes[0][1]['rod']['rodamiento']['diametro_externo'];
                                                            $diff *= 1000;
                                                        @endphp
                                                        {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff), 0) }}
                                                        μm
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-6">
                                                @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[0][1]) > 0.1)
                                                    <p class="w-100 text-start my-0">
                                                        <img src="{{ asset('img/alert.png') }}" alt=""
                                                            style="max-width: 15px" class="mt-1">
                                                        <span class="text-danger">Demasiada Ovalacion</span>
                                                    </p>
                                                @endif
                                                @if ($diff_min < 0 || $diff_min < $ajustes[0][1]['rod']['rodamiento']['probable_min'] * 1000)
                                                    <p class="w-100 text-start my-0">
                                                        <img src="{{ asset('img/alert.png') }}" alt=""
                                                            style="max-width: 15px" class="">
                                                        <span class="text-danger">Ajuste demasiado apretado</span>
                                                    </p>
                                                @endif

                                                @if (
                                                    (App\Http\Livewire\Pruebas\Ajustes::findMax($ajustes[0][1]) -
                                                        $ajustes[1][1]['rod']['rodamiento']['diametro_externo']) *
                                                        1000 >
                                                        $ajustes[1][1]['rod']['rodamiento']['H6'] * 1000)
                                                    <p class="w-100 text-start my-0">
                                                        <img src="{{ asset('img/warning.jpg') }}" alt=""
                                                            style="max-width: 15px" class="">
                                                        <span class="text-danger">Ajuste holgado, no cumple con norma
                                                            EASA (AR-100)</span>
                                                    </p>
                                                @endif
                                                @if ($diff > $ajustes[0][1]['rod']['rodamiento']['probable_max'] * 1000)
                                                    <p class="w-100 text-start my-0">
                                                        <img src="{{ asset('img/alert.png') }}" alt=""
                                                            style="max-width: 15px" class="mt-1">
                                                        <span class="text-danger">Ajuste demasiado holgado, no cumple
                                                            con norma SKF (ISO 286)</span>
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="col-6 text-start">
                                                <h4>Decisi&oacute;n del tornero</h4>
                                                <select class="form-select" aria-label="Default select example"
                                                    wire:model="options.0.1.id" wire:change="saveMedidas(0,1)">
                                                    <option selected="">Seleccione su Decision</option>
                                                    @foreach ($decisiones->where('cuna_eje', 1) as $decision)
                                                        <option value="{{ $decision->id }}">{{ $decision->decision }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                * Medidas tomadas por {{ $ajustes[0][1]['rod']['userMedida']['name'] }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-12 text-start">
                                                <label class="form-label"
                                                    for="exampleFormControlTextarea1">Comentarios del tornero</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" style="text-transform: capitalize" rows="2"
                                                    wire:model="options.0.1.decision"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <hr>
                                <div class="text-end">
                                    <button class="btn btn-sm btn-primary"
                                        wire:click="saveMedidas(0,1)">Guardar</button>
                                </div>

                            </div>
                        </div>
                    </x-form-card>
                </div>
            </div>
            @if (!$allowed_final)
                <div class="row">
                    <div class="col-11 card m-3">
                        <h3>Aun no se han completado datos finales de rodamientos</h3>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-3 d-none d-md-block" style="vertical-align: middle;text-align:center">
                        <img src="{{ asset('img/tapas.png') }}" alt="" style="max-width: 100%"
                            class="mt-3">


                        <table class="table table-striped bearing-data mt-2">
                            <tr>
                                <td colspan="2" style="text-align: center;background:#e8e9ea">
                                    <h6 style="font-weight: bold">{{ $ajustes[1][1]['designacion'] }}</h6>
                                </td>
                            <tr>
                                <td>Diametro Externo</td>
                                <td> {{ $ajustes[1][1]['rod']['rodamiento']['diametro_externo'] }} mm</td>
                            </tr>
                            <tr>
                                <td>Diametro Interno</td>
                                <td> {{ $ajustes[1][1]['rod']['rodamiento']['diametro_interno'] }} mm</td>
                            </tr>
                            <tr>
                                <td>Medida a 0°</td>
                                <td> {{ $ajustes[1][1]['rod']['p'] }} mm</td>
                            </tr>
                            <tr>
                                <td>Medida a 120°</td>
                                <td> {{ $ajustes[1][1]['rod']['q'] }} mm</td>
                            </tr>
                            <tr>
                                <td>Medida a 240°</td>
                                <td> {{ $ajustes[1][1]['rod']['r'] }} mm</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 col-md-9">
                        <x-form-card title="Medidas Finales Opuesto">
                            <div class="table-responsive scrollbar mt-0">

                                <table class="table ajustes">
                                    <thead>
                                        <tr>
                                            <th scope="col">Posicion A</th>
                                            <th scope="col">Posicion B</th>
                                            @if ($ajustes[1][1]['rod']['rodamiento']['diametro_externo'] > 140)
                                                <th scope="col">Posicion C</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">AX</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="medida [mm]" aria-label="Username"
                                                        aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.1.1.ax" />
                                                </div>
                                                @error('ajustes.1.1.ax') 
                                                          <span class="text-danger">{{ $message }}</span> 
                                                        @enderror
                                                <style>
                                                    @media (max-width: 768px) {

                                                        .input-group-text,
                                                        .form-control {
                                                            font-size: 0.6rem;
                                                            padding: 3px;
                                                        }
                                                    }
                                                </style>
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">BX</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="medida [mm]" aria-label="Username"
                                                        aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.1.1.bx" />
                                                </div>
                                                @error('ajustes.1.1.bx') 
                                                          <span class="text-danger">{{ $message }}</span> 
                                                        @enderror
                                            </td>
                                            @if ($ajustes[1][1]['rod']['rodamiento']['diametro_externo'] > 140)
                                                <td>
                                                    <div class="input-group "><span class="input-group-text"
                                                            id="basic-addon1">CX</span>
                                                        <input class="form-control" type="number" step="0.001"
                                                            placeholder="medida [mm]" aria-label="Username"
                                                            aria-describedby="basic-addon1"
                                                            wire:model.defer="ajustes.1.1.cx" />
                                                    </div>
                                                    @error('ajustes.1.1.cx') 
                                                          <span class="text-danger">{{ $message }}</span> 
                                                        @enderror
                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">AY</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="medida [mm]" aria-label="Username"
                                                        aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.1.1.ay" />
                                                </div>
                                                 @error('ajustes.1.1.ay') 
                                                          <span class="text-danger">{{ $message }}</span> 
                                                        @enderror
                                            </td>
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">BY</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="medida [mm]" aria-label="Username"
                                                        aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.1.1.by" />
                                                </div>
                                                @error('ajustes.1.1.by') 
                                                          <span class="text-danger">{{ $message }}</span> 
                                                        @enderror
                                            </td>
                                            @if ($ajustes[1][1]['rod']['rodamiento']['diametro_externo'] > 140)
                                                <td>
                                                    <div class="input-group "><span class="input-group-text"
                                                            id="basic-addon1">CY</span>
                                                        <input class="form-control" type="number" step="0.001"
                                                            placeholder="medida [mm]" aria-label="Username"
                                                            aria-describedby="basic-addon1"
                                                            wire:model.defer="ajustes.1.1.cy" />
                                                    </div>
                                                    @error('ajustes.1.1.cy') 
                                                          <span class="text-danger">{{ $message }}</span> 
                                                        @enderror
                                                </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    @if ($ajustes[1][1]['ax'])
                                    <div class="text-center">
                                        <div class="text-start text-primary" style="font-size: 1.2rem;">

                                            * Medidas comparadas contra las medidas del rodamiento a instalar

                                            @php
                                                $medida_max = max(
                                                    $ajustes[1][1]['rod']['p'],
                                                    $ajustes[1][1]['rod']['q'],
                                                    $ajustes[1][1]['rod']['r'],
                                                );
                                                $medida_min = min(
                                                    $ajustes[1][1]['rod']['p'],
                                                    $ajustes[1][1]['rod']['q'],
                                                    $ajustes[1][1]['rod']['r'],
                                                );
                                            @endphp
                                        </div>

                                        <div class="table-responsive scrollbar">
                                            <table class="table table-hover tolerancias" style="font-size: 12px">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Medida</th>
                                                        <th scope="col">Valor [mm]</th>
                                                        <th scope="col">Medida</th>
                                                        <th scope="col">Valor [mm]</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="hover-actions-trigger">
                                                        <td class="align-middle text-nowrap bg-soft-primary">Medida
                                                            Mayor
                                                        </td>
                                                        <td class="align-middle text-nowrap">
                                                            {{ App\Http\Livewire\Pruebas\Ajustes::findMax($ajustes[1][1]) }}
                                                        </td>
                                                        <td class="align-middle text-nowrap  bg-soft-primary">Medida
                                                            menor
                                                        </td>
                                                        <td class="align-middle text-nowrap">
                                                            {{ App\Http\Livewire\Pruebas\Ajustes::findMin($ajustes[1][1]) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">x̅ media
                                                        </td>
                                                        <td>{{ App\Http\Livewire\Pruebas\Ajustes::findMean($ajustes[1][1]) }}
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">
                                                            <i>D<sub>m</sub> </i> desviacion
                                                        </td>
                                                        <td>{{ App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[1][1]) }}%
                                                            @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[1][1]) > 0.1)
                                                                <img src="{{ asset('img/alert.png') }}"
                                                                    alt="" style="max-width: 15px"
                                                                    class="mt-1">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Medida
                                                            Max.
                                                            Rodamiento</td>
                                                        <td>{{ number_format($medida_max, 3) }}
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Medida
                                                            Min.
                                                            Rodamiento</td>
                                                        <td>{{ number_format($medida_min, 3) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">TOL. EASA
                                                            AR-100</td>
                                                        <td>+(0-{{ number_format($ajustes[1][1]['rod']['rodamiento']['H6'] * 1000, 0) }})
                                                            μm</td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">TOL. ISO
                                                            286
                                                        </td>
                                                        <td>+({{ number_format($ajustes[1][1]['rod']['rodamiento']['probable_min'] * 1000, 0) }}-{{ number_format($ajustes[1][1]['rod']['rodamiento']['probable_max'] * 1000, 0) }})
                                                            μm</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            Minimo (ISO 286)
                                                        </td>
                                                        <td>
                                                            @php
                                                                $diff_min =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMin(
                                                                        $ajustes[1][1],
                                                                    ) - $medida_max;
                                                                $diff_min *= 1000;
                                                            @endphp
                                                            {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min), 0) }}
                                                            μm
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            M&aacute;ximo (ISO 286)
                                                        </td>
                                                        <td>
                                                            @php
                                                                $diff =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMax(
                                                                        $ajustes[1][1],
                                                                    ) - $medida_min;
                                                                $diff *= 1000;
                                                            @endphp
                                                            {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff), 0) }}
                                                            μm
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            Minimo
                                                            (EASA AR-100)</td>
                                                        <td>
                                                            @php
                                                                $diff_min =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMin(
                                                                        $ajustes[1][1],
                                                                    ) -
                                                                    $ajustes[1][1]['rod']['rodamiento'][
                                                                        'diametro_externo'
                                                                    ];
                                                                $diff_min *= 1000;
                                                            @endphp
                                                            {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min), 0) }}
                                                            μm
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            M&aacute;ximo (EASA AR-100)
                                                        </td>
                                                        <td>
                                                            @php
                                                                $diff =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMax(
                                                                        $ajustes[1][1],
                                                                    ) -
                                                                    $ajustes[1][1]['rod']['rodamiento'][
                                                                        'diametro_externo'
                                                                    ];
                                                                $diff *= 1000;
                                                            @endphp
                                                            {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff), 0) }}
                                                            μm
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                <div class="col-6">
                                                    @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[1][1]) > 0.1)
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="mt-1">
                                                            <span class="text-danger">Demasiada Ovalacion</span>
                                                        </p>
                                                    @endif
                                                    @if ($diff_min < 0 || $diff_min < $ajustes[1][1]['rod']['rodamiento']['probable_min'] * 1000)
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="">
                                                            <span class="text-danger">Ajuste demasiado apretado</span>
                                                        </p>
                                                    @endif

                                                    @if (
                                                        (App\Http\Livewire\Pruebas\Ajustes::findMax($ajustes[1][1]) -
                                                            $ajustes[1][1]['rod']['rodamiento']['diametro_externo']) *
                                                            1000 >
                                                            $ajustes[1][1]['rod']['rodamiento']['H6'] * 1000)
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/warning.jpg') }}" alt=""
                                                                style="max-width: 15px" class="">
                                                            <span class="text-danger">Ajuste holgado, no cumple con
                                                                norma
                                                                EASA (AR-100)</span>
                                                        </p>
                                                    @endif
                                                    @if ($diff > $ajustes[1][1]['rod']['rodamiento']['probable_max'] * 1000)
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="mt-1">
                                                            <span class="text-danger">Ajuste demasiado holgado, no
                                                                cumple
                                                                con norma SKF (ISO 286)</span>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h4>Decisi&oacute;n del tornero</h4>
                                                    <select class="form-select" aria-label="Default select example"
                                                        wire:model="options.1.1.id" wire:change="saveMedidas(1,1)">
                                                        <option selected="">Seleccione su Decision</option>
                                                        @foreach ($decisiones->where('cuna_eje', 1) as $decision)
                                                            <option value="{{ $decision->id }}">
                                                                {{ $decision->decision }}</option>
                                                        @endforeach
                                                    </select>

                                                    @if ($ajustes[1][1]['rod']['userMedida'])
                                                        * Medidas tomadas por
                                                        {{ $ajustes[1][1]['rod']['userMedida']['name'] }}
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-12 text-start">
                                                    <label class="form-label"
                                                        for="exampleFormControlTextarea1">Comentarios del
                                                        tornero</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" style="text-transform: capitalize" rows="2"
                                                        wire:model="options.1.1.decision"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <hr>
                                    <div class="text-end">
                                        <button class="btn btn-sm btn-primary"
                                            wire:click="saveMedidas(1,1)">Guardar</button>
                                    </div>

                                </div>
                            </div>
                        </x-form-card>
                    </div>
                </div>
            @endif
        </x-form-card>
        <div class="">
          <div class="card text-end ">
            <div class="p-3">
              <button class="btn btn-success me-3 mb-1" type="button" wire:click="finalizar()">Finalizar Medidas Alojamientos
              </button>
            </div>
            
          </div>
        </div>
    @endif
    {{-- rodamiento lado opuesto --}}
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('savedMedidas', (title, ) => {
                Swal.fire({
                    title: "Medidas Guardadas",
                    text: title,
                    icon: "success"
                });
            });
            Livewire.on('errorAlojamiento', (error) => {
              Swal.fire({
                title: "Aun no es posible finalizar las medidas",
                text: error,
                icon: "error"
              });
            });
        });
    </script>
</div>
