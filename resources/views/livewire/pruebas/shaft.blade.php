<div>
    {{-- Stop trying to control. --}}
    @if (!$allowed_initial)
        <div class="row">
            <div class="col-11 card m-3">
                <h3>Aun no se han completado datos iniciales de rodamientos</h3>
            </div>
        </div>
    @else
        <x-form-card title="Eje Lado de Carga">
            {{-- Iniciales Carga --}}
            <div class="row">
                <div class="col-3 d-none d-md-block" style="vertical-align: middle">
                    <img src="{{ asset('img/ejes.png') }}" alt="" style="max-width: 100%" class="mt-3">

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

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group "><span class="input-group-text"
                                                    id="basic-addon1">Pos 1 (externa)</span>
                                                <input class="form-control" type="number" step="0.001"
                                                    placeholder="{{ $ajustes[0][0]['rod']['rodamiento']['diametro_interno'] }}"
                                                    aria-label="Username" aria-describedby="basic-addon1"
                                                    wire:model.defer="ajustes.0.0.e1" />

                                            </div>
                                            @error('ajustes.0.0.e1')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group "><span class="input-group-text"
                                                    id="basic-addon1">Pos 2
                                                    {{ $ajustes[0][0]['rod']['rodamiento']['diametro_interno'] > 76 ? '(Medio)' : '(Interno)' }}</span>
                                                <input class="form-control" type="number" step="0.001"
                                                    placeholder="{{ $ajustes[0][0]['rod']['rodamiento']['diametro_interno'] }}"
                                                    aria-label="Username" aria-describedby="basic-addon1"
                                                    wire:model.defer="ajustes.0.0.e2" />

                                            </div>
                                            @error('ajustes.0.0.e2')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    @if ($ajustes[0][0]['rod']['rodamiento']['diametro_interno'] > 76)
                                        <tr>
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">Pos 3 (Interno)</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="{{ $ajustes[0][0]['rod']['rodamiento']['diametro_interno'] }}"
                                                        aria-label="Username" aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.0.0.e3" />

                                                </div>
                                                @error('ajustes.0.0.e3')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @if ($ajustes[0][0]['e1'])
                                    <div class="text-center">
                                        <div class="text-start text-primary" style="font-size: 1.2rem;">
                                            @if ($allowed_final && $ajustes[1][0]['rod']['p'])
                                                * Medidas comparadas contra las medidas del rodamiento a instalar
                                            @else
                                                * Medidas comparadas contra las teoricas del rodamiento
                                            @endif
                                            @php
                                                $medida_max =
                                                    $allowed_final && $ajustes[1][0]['rod']['s']
                                                        ? max($ajustes[1][0]['rod']['s'], $ajustes[1][0]['rod']['t'])
                                                        : $ajustes[0][0]['rod']['rodamiento']['diametro_interno'];
                                                $medida_min =
                                                    $allowed_final && $ajustes[1][0]['rod']['s']
                                                        ? min($ajustes[1][0]['rod']['s'], $ajustes[1][0]['rod']['t'])
                                                        : $ajustes[0][0]['rod']['rodamiento']['diametro_interno'];
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
                                                        <td>{{ number_format(App\Http\Livewire\Pruebas\Ajustes::findMean($ajustes[0][0]), 4) }}
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">
                                                            <i>D<sub>m</sub> </i> desviacion
                                                        </td>
                                                        <td>{{ App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[0][0]) }}%
                                                            @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[0][0]) > 0.1)
                                                                <img src="{{ asset('img/alert.png') }}" alt=""
                                                                    style="max-width: 15px" class="mt-1">
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
                                                        <td class="align-middle text-nowrap bg-soft-primary">Regimen
                                                            Tolerancia</td>
                                                        <td>{{ $ajustes[0][0]['rod']['rodamiento']['eje_ball_tol'] }}
                                                        </td>
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Tolerancia
                                                        </td>
                                                        <td>{{ number_format($ajustes[0][0]['rod']['rodamiento']['eje_ball_min'] * 1000, 0) }}μm
                                                            a
                                                            {{ number_format($ajustes[0][0]['rod']['rodamiento']['eje_ball_max'] * 1000, 0) }}μm
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            Minimo (ISO 286)
                                                        </td>
                                                        @php
                                                            $diff_min =
                                                                App\Http\Livewire\Pruebas\Ajustes::findMin(
                                                                    $ajustes[0][0],
                                                                ) - $medida_max;

                                                        @endphp
                                                        <td
                                                            class="{{ $diff_min > $ajustes[0][0]['rod']['rodamiento']['eje_ball_min'] &&
                                                            $diff_min < $ajustes[0][0]['rod']['rodamiento']['eje_ball_max']
                                                                ? 'bg-soft-success'
                                                                : 'bg-soft-danger' }}">
                                                            {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min * 1000), 0) }}
                                                            μm
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            M&aacute;ximo (ISO 286)
                                                        </td>
                                                        @php
                                                            $diff =
                                                                App\Http\Livewire\Pruebas\Ajustes::findMax(
                                                                    $ajustes[0][0],
                                                                ) - $medida_min;

                                                        @endphp
                                                        <td
                                                            class="{{ $diff > $ajustes[0][0]['rod']['rodamiento']['eje_ball_min'] &&
                                                            $diff < $ajustes[0][0]['rod']['rodamiento']['eje_ball_max']
                                                                ? 'bg-soft-success'
                                                                : 'bg-soft-danger' }}">

                                                            {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff * 1000), 0) }}
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
                                                            <span class="text-danger">Demasiada Conicidad
                                                                (Re-ajustar)</span>
                                                        </p>
                                                    @endif

                                                    @if (
                                                        $diff_min + 0.01 > $ajustes[0][0]['rod']['rodamiento']['eje_ball_min'] &&
                                                            $diff_min + 0.0 < $ajustes[0][0]['rod']['rodamiento']['eje_ball_min']
                                                    )
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/warning.jpg') }}" alt=""
                                                                style="max-width: 15px" class="">
                                                            <span class="text-danger">Ajuste Holgado (Se sugiere
                                                                pegamento)</span>
                                                        </p>
                                                    @endif
                                                    @if ($diff_min + 0.01 < $ajustes[0][0]['rod']['rodamiento']['eje_ball_min'])
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="">
                                                            <span class="text-danger">Ajuste demasiado Holagado (Se
                                                                sugiere metalizar)</span>
                                                        </p>
                                                    @endif
                                                    @if ($diff > $ajustes[0][0]['rod']['rodamiento']['eje_ball_max'])
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="">
                                                            <span class="text-danger">Ajuste demasiado Apretado (Se
                                                                sugiere lijar)</span>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h4>Decisi&oacute;n del tornero</h4>
                                                    <select class="form-select" aria-label="Default select example"
                                                        wire:model="options.0.0.id" wire:change="saveMedidas(0,0)">
                                                        <option selected="">Seleccione su Decision</option>
                                                        @foreach ($decisiones->where('cuna_eje', 2) as $decision)
                                                            <option value="{{ $decision->id }}">
                                                                {{ $decision->decision }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    * Medidas tomadas por
                                                    {{ $ajustes[0][0]['rod']['userMedidaEje']['name'] }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-12 text-start">
                                                    <label class="form-label"
                                                        for="exampleFormControlTextarea1">Comentarios del
                                                        tornero</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" style="text-transform: capitalize" rows="2"
                                                        wire:model.defer="options.0.0.decision"></textarea>
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
            {{-- Finales Carga --}}
            @if (!$allowed_final)
                <div class="row">
                    <div class="col-11 card m-3">
                        <h3>Aun no se han completado datos finales de rodamientos</h3>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-3 d-none d-md-block" style="vertical-align: middle">
                        <img src="{{ asset('img/ejes.png') }}" alt="" style="max-width: 100%"
                            class="mt-3">

                        <table class="table table-striped bearing-data mt-2">
                            <tr>
                                <td colspan="2" style="text-align: center;background:#e8e9ea">
                                    <h6 style="font-weight: bold">{{ $ajustes[1][0]['designacion'] }} </h6>
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
                                <td> {{ $ajustes[1][0]['rod']['s'] }} mm</td>
                            </tr>
                            <tr>
                                <td>Medida a 120°</td>
                                <td> {{ $ajustes[1][0]['rod']['t'] }} mm</td>
                            </tr>
                        </table>
                        @if ($ajustes[0][0]['designacion'] != $ajustes[1][0]['designacion'])
                            <img src="{{ asset('img/alert.png') }}" alt="" style="max-width: 30px"
                                class="mt-1">
                            <span class="text-danger">Cambio de rodamiento!</span>
                        @endif
                    </div>
                    <div class="col-12 col-md-9">
                        <x-form-card title="Medidas Finales Carga">
                            <div class="table-responsive scrollbar mt-0">
                                <table class="table ajustes">
                                    <thead>
                                        <tr>
                                            <th scope="col">Posicion A </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">Pos 1 (externa)</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="{{ $ajustes[1][0]['rod']['rodamiento']['diametro_interno'] }}"
                                                        aria-label="Username" aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.1.0.e1" />

                                                </div>
                                                @error('ajustes.1.0.e1')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">Pos 2
                                                        {{ $ajustes[1][0]['rod']['rodamiento']['diametro_interno'] > 76 ? '(Medio)' : '(Interno)' }}</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="{{ $ajustes[1][0]['rod']['rodamiento']['diametro_interno'] }}"
                                                        aria-label="Username" aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.1.0.e2" />

                                                </div>
                                                @error('ajustes.1.0.e2')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                        </tr>
                                        @if ($ajustes[1][0]['rod']['rodamiento']['diametro_interno'] > 76)
                                            <tr>
                                                <td>
                                                    <div class="input-group "><span class="input-group-text"
                                                            id="basic-addon1">Pos 3 (Interno)</span>
                                                        <input class="form-control" type="number" step="0.001"
                                                            placeholder="{{ $ajustes[1][0]['rod']['rodamiento']['diametro_interno'] }}"
                                                            aria-label="Username" aria-describedby="basic-addon1"
                                                            wire:model.defer="ajustes.1.0.e3" />

                                                    </div>
                                                    @error('ajustes.1.0.e3')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    @if ($ajustes[1][0]['e1'])
                                        <div class="text-center">
                                            <div class="text-start text-primary" style="font-size: 1.2rem;">
                                                @if ($allowed_final && $ajustes[1][0]['rod']['s'])
                                                    * Medidas comparadas contra las medidas del rodamiento a instalar
                                                @else
                                                    * Medidas comparadas contra las teoricas del rodamiento
                                                @endif
                                                @php
                                                    $medida_max = max(
                                                        $ajustes[1][0]['rod']['s'],
                                                        $ajustes[1][0]['rod']['t'],
                                                    );
                                                    $medida_min = min(
                                                        $ajustes[1][0]['rod']['s'],
                                                        $ajustes[1][0]['rod']['t'],
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
                                                            <td class="align-middle text-nowrap  bg-soft-primary">
                                                                Medida
                                                                menor
                                                            </td>
                                                            <td class="align-middle text-nowrap">
                                                                {{ App\Http\Livewire\Pruebas\Ajustes::findMin($ajustes[1][0]) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle text-nowrap bg-soft-primary">x̅
                                                                media
                                                            </td>
                                                            <td>{{ number_format(App\Http\Livewire\Pruebas\Ajustes::findMean($ajustes[1][0]), 4) }}
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
                                                            <td class="align-middle text-nowrap bg-soft-primary">
                                                                Regimen Tolerancia</td>
                                                            <td>{{ $ajustes[1][0]['rod']['rodamiento']['eje_ball_tol'] }}
                                                            </td>
                                                            </td>
                                                            <td class="align-middle text-nowrap bg-soft-primary">
                                                                Tolerancia</td>
                                                            <td>{{ number_format($ajustes[1][0]['rod']['rodamiento']['eje_ball_min'] * 1000, 0) }}μm
                                                                a
                                                                {{ number_format($ajustes[1][0]['rod']['rodamiento']['eje_ball_max'] * 1000, 0) }}μm
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                                Minimo (ISO 286)
                                                            </td>
                                                            @php
                                                                $diff_min =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMin(
                                                                        $ajustes[1][0],
                                                                    ) - $medida_max;

                                                            @endphp
                                                            <td
                                                                class="{{ $diff_min > $ajustes[1][0]['rod']['rodamiento']['eje_ball_min'] &&
                                                                $diff_min < $ajustes[1][0]['rod']['rodamiento']['eje_ball_max']
                                                                    ? 'bg-soft-success'
                                                                    : 'bg-soft-danger' }}">
                                                                {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min * 1000), 0) }}
                                                                μm
                                                            </td>
                                                            <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                                M&aacute;ximo (ISO 286)
                                                            </td>
                                                            @php
                                                                $diff =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMax(
                                                                        $ajustes[1][0],
                                                                    ) - $medida_min;

                                                            @endphp
                                                            <td
                                                                class="{{ $diff > $ajustes[1][0]['rod']['rodamiento']['eje_ball_min'] &&
                                                                $diff < $ajustes[1][0]['rod']['rodamiento']['eje_ball_max']
                                                                    ? 'bg-soft-success'
                                                                    : 'bg-soft-danger' }}">

                                                                {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                                μm
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="row">
                                                    <div class="col-6">
                                                        @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[1][0]) > 0.1)
                                                            <p class="w-100 text-start my-0">
                                                                <img src="{{ asset('img/alert.png') }}"
                                                                    alt="" style="max-width: 15px"
                                                                    class="mt-1">
                                                                <span class="text-danger">Demasiada Conicidad
                                                                    (Re-ajustar)</span>
                                                            </p>
                                                        @endif

                                                        @if (
                                                            $diff_min + 0.01 > $ajustes[1][0]['rod']['rodamiento']['eje_ball_min'] &&
                                                                $diff_min + 0.0 < $ajustes[1][0]['rod']['rodamiento']['eje_ball_min']
                                                        )
                                                            <p class="w-100 text-start my-0">
                                                                <img src="{{ asset('img/warning.jpg') }}"
                                                                    alt="" style="max-width: 15px"
                                                                    class="">
                                                                <span class="text-danger">Ajuste Holgado (Se sugiere
                                                                    pegamento)</span>
                                                            </p>
                                                        @endif
                                                        @if ($diff_min + 0.01 < $ajustes[1][0]['rod']['rodamiento']['eje_ball_min'])
                                                            <p class="w-100 text-start my-0">
                                                                <img src="{{ asset('img/alert.png') }}"
                                                                    alt="" style="max-width: 15px"
                                                                    class="">
                                                                <span class="text-danger">Ajuste demasiado Holagado (Se
                                                                    sugiere metalizar)</span>
                                                            </p>
                                                        @endif
                                                        @if ($diff > $ajustes[1][0]['rod']['rodamiento']['eje_ball_max'])
                                                            <p class="w-100 text-start my-0">
                                                                <img src="{{ asset('img/alert.png') }}"
                                                                    alt="" style="max-width: 15px"
                                                                    class="">
                                                                <span class="text-danger">Ajuste demasiado Apretado (Se
                                                                    sugiere lijar)</span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="col-6 text-start">
                                                        <h4>Decisi&oacute;n del tornero</h4>
                                                        <select class="form-select"
                                                            aria-label="Default select example"
                                                            wire:model="options.1.0.id"
                                                            wire:change="saveMedidas(1,0)">
                                                            <option selected="">Seleccione su Decision</option>
                                                            @foreach ($decisiones->where('cuna_eje', 2) as $decision)
                                                                <option value="{{ $decision->id }}">
                                                                    {{ $decision->decision }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        * Medidas tomadas por
                                                        {{ $ajustes[1][0]['rod']['userMedidaEje']['name'] }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="mb-3 col-12 text-start">
                                                        <label class="form-label"
                                                            for="exampleFormControlTextarea1">Comentarios del
                                                            tornero</label>
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" style="text-transform: capitalize" rows="2"
                                                            wire:model.defer="options.1.0.decision"></textarea>
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
        <x-form-card title="Eje Lado de Opuesto a Carga">
            {{-- Iniciales lado opuesto --}}
            <div class="row">
                <div class="col-3 d-none d-md-block" style="vertical-align: middle">
                    <img src="{{ asset('img/ejes.png') }}" alt="" style="max-width: 100%" class="mt-3">

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
                    <x-form-card title="Medidas Iniciales Lado Opuesto a Carga">
                        <div class="table-responsive scrollbar mt-0">
                            <table class="table ajustes">
                                <thead>
                                    <tr>
                                        <th scope="col">Posicion A </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group "><span class="input-group-text"
                                                    id="basic-addon1">Pos 1 (externa)</span>
                                                <input class="form-control" type="number" step="0.001"
                                                    placeholder="{{ $ajustes[0][1]['rod']['rodamiento']['diametro_interno'] }}"
                                                    aria-label="Username" aria-describedby="basic-addon1"
                                                    wire:model.defer="ajustes.0.1.e1" />

                                            </div>
                                            @error('ajustes.0.1.e1')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group "><span class="input-group-text"
                                                    id="basic-addon1">Pos 2
                                                    {{ $ajustes[0][1]['rod']['rodamiento']['diametro_interno'] > 76 ? '(Medio)' : '(Interno)' }}</span>
                                                <input class="form-control" type="number" step="0.001"
                                                    placeholder="{{ $ajustes[0][1]['rod']['rodamiento']['diametro_interno'] }}"
                                                    aria-label="Username" aria-describedby="basic-addon1"
                                                    wire:model.defer="ajustes.0.1.e2" />

                                            </div>
                                            @error('ajustes.0.1.e2')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    @if ($ajustes[0][1]['rod']['rodamiento']['diametro_interno'] > 76)
                                        <tr>
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">Pos 3 (Interno)</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="{{ $ajustes[0][1]['rod']['rodamiento']['diametro_interno'] }}"
                                                        aria-label="Username" aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.0.1.e3" />

                                                </div>
                                                @error('ajustes.0.1.e3')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @if ($ajustes[0][1]['e1'])
                                    <div class="text-center">
                                        <div class="text-start text-primary" style="font-size: 1.2rem;">
                                            @if ($allowed_final && $ajustes[1][1]['rod']['p'])
                                                * Medidas comparadas contra las medidas del rodamiento a instalar
                                            @else
                                                * Medidas comparadas contra las teoricas del rodamiento
                                            @endif
                                            @php
                                                $medida_max =
                                                    $allowed_final && $ajustes[1][1]['rod']['s']
                                                        ? max($ajustes[1][1]['rod']['s'], $ajustes[1][1]['rod']['t'])
                                                        : $ajustes[0][1]['rod']['rodamiento']['diametro_interno'];
                                                $medida_min =
                                                    $allowed_final && $ajustes[1][1]['rod']['s']
                                                        ? min($ajustes[1][1]['rod']['s'], $ajustes[1][1]['rod']['t'])
                                                        : $ajustes[0][1]['rod']['rodamiento']['diametro_interno'];
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
                                                            {{ App\Http\Livewire\Pruebas\Ajustes::findMax($ajustes[0][1]) }}
                                                        </td>
                                                        <td class="align-middle text-nowrap  bg-soft-primary">Medida
                                                            menor
                                                        </td>
                                                        <td class="align-middle text-nowrap">
                                                            {{ App\Http\Livewire\Pruebas\Ajustes::findMin($ajustes[0][1]) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">x̅ media
                                                        </td>
                                                        <td>{{ number_format(App\Http\Livewire\Pruebas\Ajustes::findMean($ajustes[0][1]), 4) }}
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">
                                                            <i>D<sub>m</sub> </i> desviacion
                                                        </td>
                                                        <td>{{ App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[0][1]) }}%
                                                            @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[0][1]) > 0.1)
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
                                                        <td class="align-middle text-nowrap bg-soft-primary">Regimen
                                                            Tolerancia</td>
                                                        <td>{{ $ajustes[0][1]['rod']['rodamiento']['eje_ball_tol'] }}
                                                        </td>
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Tolerancia
                                                        </td>
                                                        <td>{{ number_format($ajustes[0][1]['rod']['rodamiento']['eje_ball_min'] * 1000, 0) }}μm
                                                            a
                                                            {{ number_format($ajustes[0][1]['rod']['rodamiento']['eje_ball_max'] * 1000, 0) }}μm
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            Minimo (ISO 286)
                                                        </td>
                                                        @php
                                                            $diff_min =
                                                                App\Http\Livewire\Pruebas\Ajustes::findMin(
                                                                    $ajustes[0][1],
                                                                ) - $medida_max;

                                                        @endphp
                                                        <td
                                                            class="{{ $diff_min > $ajustes[0][1]['rod']['rodamiento']['eje_ball_min'] &&
                                                            $diff_min < $ajustes[0][1]['rod']['rodamiento']['eje_ball_max']
                                                                ? 'bg-soft-success'
                                                                : 'bg-soft-danger' }}">
                                                            {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min * 1000), 0) }}
                                                            μm
                                                        </td>
                                                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                            M&aacute;ximo (ISO 286)
                                                        </td>
                                                        @php
                                                            $diff =
                                                                App\Http\Livewire\Pruebas\Ajustes::findMax(
                                                                    $ajustes[0][1],
                                                                ) - $medida_min;

                                                        @endphp
                                                        <td
                                                            class="{{ $diff > $ajustes[0][1]['rod']['rodamiento']['eje_ball_min'] &&
                                                            $diff < $ajustes[0][1]['rod']['rodamiento']['eje_ball_max']
                                                                ? 'bg-soft-success'
                                                                : 'bg-soft-danger' }}">

                                                            {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff * 1000), 0) }}
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
                                                            <span class="text-danger">Demasiada Conicidad
                                                                (Re-ajustar)</span>
                                                        </p>
                                                    @endif

                                                    @if (
                                                        $diff_min + 0.01 > $ajustes[0][1]['rod']['rodamiento']['eje_ball_min'] &&
                                                            $diff_min + 0.0 < $ajustes[0][1]['rod']['rodamiento']['eje_ball_min']
                                                    )
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/warning.jpg') }}" alt=""
                                                                style="max-width: 15px" class="">
                                                            <span class="text-danger">Ajuste Holgado (Se sugiere
                                                                pegamento)</span>
                                                        </p>
                                                    @endif
                                                    @if ($diff_min + 0.01 < $ajustes[0][1]['rod']['rodamiento']['eje_ball_min'])
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="">
                                                            <span class="text-danger">Ajuste demasiado Holagado (Se
                                                                sugiere metalizar)</span>
                                                        </p>
                                                    @endif
                                                    @if ($diff > $ajustes[0][1]['rod']['rodamiento']['eje_ball_max'])
                                                        <p class="w-100 text-start my-0">
                                                            <img src="{{ asset('img/alert.png') }}" alt=""
                                                                style="max-width: 15px" class="">
                                                            <span class="text-danger">Ajuste demasiado Apretado (Se
                                                                sugiere lijar)</span>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h4>Decisi&oacute;n del tornero</h4>
                                                    <select class="form-select" aria-label="Default select example"
                                                        wire:model="options.0.1.id" wire:change="saveMedidas(0,1)">
                                                        <option selected="">Seleccione su Decision</option>
                                                        @foreach ($decisiones->where('cuna_eje', 2) as $decision)
                                                            <option value="{{ $decision->id }}">
                                                                {{ $decision->decision }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    * Medidas tomadas por
                                                    {{ $ajustes[0][1]['rod']['userMedidaEje']['name'] }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-3 col-12 text-start">
                                                    <label class="form-label"
                                                        for="exampleFormControlTextarea1">Comentarios del
                                                        tornero</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" style="text-transform: capitalize" rows="2"
                                                        wire:model.defer="options.0.1.decision"></textarea>
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
            {{-- Finales lado opuesto --}}
            @if (!$allowed_final)
                <div class="row">
                    <div class="col-11 card m-3">
                        <h3>Aun no se han completado datos finales de rodamientos</h3>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-3 d-none d-md-block" style="vertical-align: middle">
                        <img src="{{ asset('img/ejes.png') }}" alt="" style="max-width: 100%"
                            class="mt-3">

                        <table class="table table-striped bearing-data mt-2">
                            <tr>
                                <td colspan="2" style="text-align: center;background:#e8e9ea">
                                    <h6 style="font-weight: bold">{{ $ajustes[1][1]['designacion'] }} </h6>
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
                                <td> {{ $ajustes[1][1]['rod']['s'] }} mm</td>
                            </tr>
                            <tr>
                                <td>Medida a 120°</td>
                                <td> {{ $ajustes[1][1]['rod']['t'] }} mm</td>
                            </tr>
                        </table>
                        @if ($ajustes[0][1]['designacion'] != $ajustes[1][1]['designacion'])
                            <img src="{{ asset('img/alert.png') }}" alt="" style="max-width: 30px"
                                class="mt-1">
                            <span class="text-danger">Cambio de rodamiento!</span>
                        @endif
                    </div>
                    <div class="col-12 col-md-9">
                        <x-form-card title="Medidas Finales Lado Opuesto a Carga">
                            <div class="table-responsive scrollbar mt-0">
                                <table class="table ajustes">
                                    <thead>
                                        <tr>
                                            <th scope="col">Posicion A </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">Pos 1 (externa)</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="{{ $ajustes[1][1]['rod']['rodamiento']['diametro_interno'] }}"
                                                        aria-label="Username" aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.1.1.e1" />

                                                </div>
                                                @error('ajustes.1.0.e1')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="input-group "><span class="input-group-text"
                                                        id="basic-addon1">Pos 2
                                                        {{ $ajustes[1][1]['rod']['rodamiento']['diametro_interno'] > 76 ? '(Medio)' : '(Interno)' }}</span>
                                                    <input class="form-control" type="number" step="0.001"
                                                        placeholder="{{ $ajustes[1][1]['rod']['rodamiento']['diametro_interno'] }}"
                                                        aria-label="Username" aria-describedby="basic-addon1"
                                                        wire:model.defer="ajustes.1.1.e2" />

                                                </div>
                                                @error('ajustes.1.0.e2')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </td>
                                        </tr>
                                        @if ($ajustes[1][1]['rod']['rodamiento']['diametro_interno'] > 76)
                                            <tr>
                                                <td>
                                                    <div class="input-group "><span class="input-group-text"
                                                            id="basic-addon1">Pos 3 (Interno)</span>
                                                        <input class="form-control" type="number" step="0.001"
                                                            placeholder="{{ $ajustes[1][1]['rod']['rodamiento']['diametro_interno'] }}"
                                                            aria-label="Username" aria-describedby="basic-addon1"
                                                            wire:model.defer="ajustes.1.1.e3" />

                                                    </div>
                                                    @error('ajustes.1.0.e3')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    @if ($ajustes[1][1]['e1'])
                                        <div class="text-center">
                                            <div class="text-start text-primary" style="font-size: 1.2rem;">
                                                @if ($allowed_final && $ajustes[1][1]['rod']['s'])
                                                    * Medidas comparadas contra las medidas del rodamiento a instalar
                                                @else
                                                    * Medidas comparadas contra las teoricas del rodamiento
                                                @endif
                                                @php
                                                    $medida_max = max(
                                                        $ajustes[1][1]['rod']['s'],
                                                        $ajustes[1][1]['rod']['t'],
                                                    );
                                                    $medida_min = min(
                                                        $ajustes[1][1]['rod']['s'],
                                                        $ajustes[1][1]['rod']['t'],
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
                                                            <td class="align-middle text-nowrap  bg-soft-primary">
                                                                Medida
                                                                menor
                                                            </td>
                                                            <td class="align-middle text-nowrap">
                                                                {{ App\Http\Livewire\Pruebas\Ajustes::findMin($ajustes[1][1]) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle text-nowrap bg-soft-primary">x̅
                                                                media
                                                            </td>
                                                            <td>{{ number_format(App\Http\Livewire\Pruebas\Ajustes::findMean($ajustes[1][1]), 4) }}
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
                                                            <td class="align-middle text-nowrap bg-soft-primary">
                                                                Regimen Tolerancia</td>
                                                            <td>{{ $ajustes[1][1]['rod']['rodamiento']['eje_ball_tol'] }}
                                                            </td>
                                                            </td>
                                                            <td class="align-middle text-nowrap bg-soft-primary">
                                                                Tolerancia</td>
                                                            <td>{{ number_format($ajustes[1][1]['rod']['rodamiento']['eje_ball_min'] * 1000, 0) }}μm
                                                                a
                                                                {{ number_format($ajustes[1][1]['rod']['rodamiento']['eje_ball_max'] * 1000, 0) }}μm
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                                Minimo (ISO 286)
                                                            </td>
                                                            @php
                                                                $diff_min =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMin(
                                                                        $ajustes[1][1],
                                                                    ) - $medida_max;

                                                            @endphp
                                                            <td
                                                                class="{{ $diff_min > $ajustes[1][1]['rod']['rodamiento']['eje_ball_min'] &&
                                                                $diff_min < $ajustes[1][1]['rod']['rodamiento']['eje_ball_max']
                                                                    ? 'bg-soft-success'
                                                                    : 'bg-soft-danger' }}">
                                                                {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min * 1000), 0) }}
                                                                μm
                                                            </td>
                                                            <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                                                                M&aacute;ximo (ISO 286)
                                                            </td>
                                                            @php
                                                                $diff =
                                                                    App\Http\Livewire\Pruebas\Ajustes::findMax(
                                                                        $ajustes[1][1],
                                                                    ) - $medida_min;

                                                            @endphp
                                                            <td
                                                                class="{{ $diff > $ajustes[1][1]['rod']['rodamiento']['eje_ball_min'] &&
                                                                $diff < $ajustes[1][1]['rod']['rodamiento']['eje_ball_max']
                                                                    ? 'bg-soft-success'
                                                                    : 'bg-soft-danger' }}">

                                                                {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                                μm
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="row">
                                                    <div class="col-6">
                                                        @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[1][1]) > 0.1)
                                                            <p class="w-100 text-start my-0">
                                                                <img src="{{ asset('img/alert.png') }}"
                                                                    alt="" style="max-width: 15px"
                                                                    class="mt-1">
                                                                <span class="text-danger">Demasiada Conicidad
                                                                    (Re-ajustar)</span>
                                                            </p>
                                                        @endif

                                                        @if (
                                                            $diff_min + 0.01 > $ajustes[1][1]['rod']['rodamiento']['eje_ball_min'] &&
                                                                $diff_min + 0.0 < $ajustes[1][1]['rod']['rodamiento']['eje_ball_min']
                                                        )
                                                            <p class="w-100 text-start my-0">
                                                                <img src="{{ asset('img/warning.jpg') }}"
                                                                    alt="" style="max-width: 15px"
                                                                    class="">
                                                                <span class="text-danger">Ajuste Holgado (Se sugiere
                                                                    pegamento)</span>
                                                            </p>
                                                        @endif
                                                        @if ($diff_min + 0.01 < $ajustes[1][1]['rod']['rodamiento']['eje_ball_min'])
                                                            <p class="w-100 text-start my-0">
                                                                <img src="{{ asset('img/alert.png') }}"
                                                                    alt="" style="max-width: 15px"
                                                                    class="">
                                                                <span class="text-danger">Ajuste demasiado Holagado (Se
                                                                    sugiere metalizar)</span>
                                                            </p>
                                                        @endif
                                                        @if ($diff > $ajustes[1][1]['rod']['rodamiento']['eje_ball_max'])
                                                            <p class="w-100 text-start my-0">
                                                                <img src="{{ asset('img/alert.png') }}"
                                                                    alt="" style="max-width: 15px"
                                                                    class="">
                                                                <span class="text-danger">Ajuste demasiado Apretado (Se
                                                                    sugiere lijar)</span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="col-6 text-start">
                                                        <h4>Decisi&oacute;n del tornero</h4>
                                                        <select class="form-select"
                                                            aria-label="Default select example"
                                                            wire:model="options.1.1.id"
                                                            wire:change="saveMedidas(1,1)">
                                                            <option selected="">Seleccione su Decision</option>
                                                            @foreach ($decisiones->where('cuna_eje', 2) as $decision)
                                                                <option value="{{ $decision->id }}">
                                                                    {{ $decision->decision }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        * Medidas tomadas por
                                                        {{ $ajustes[1][1]['rod']['userMedidaEje']['name'] }}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="mb-3 col-12 text-start">
                                                        <label class="form-label"
                                                            for="exampleFormControlTextarea1">Comentarios del
                                                            tornero</label>
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" style="text-transform: capitalize" rows="2"
                                                            wire:model.defer="options.1.1.decision"></textarea>
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

    @endif
</div>
