<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    @if ($ajustes[$initial_final][$carga_opuesto]['ax'])
        <div class="text-start text-primary" style="font-size: 1.2rem;">
            @if ($comparedToReal)
                * Medidas comparadas contra las medidas del rodamiento a instalar
            @else
                * Medidas comparadas contra las teoricas del rodamiento
            @endif
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
                            {{ App\Http\Livewire\Pruebas\Ajustes::findMax($ajustes[$initial_final][$carga_opuesto]) }}
                        </td>
                        <td class="align-middle text-nowrap  bg-soft-primary">Medida
                            menor
                        </td>
                        <td class="align-middle text-nowrap">
                            {{ App\Http\Livewire\Pruebas\Ajustes::findMin($ajustes[$initial_final][$carga_opuesto]) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle text-nowrap bg-soft-primary">x̅ media
                        </td>
                        <td>{{ number_format(App\Http\Livewire\Pruebas\Ajustes::findMean($ajustes[$initial_final][$carga_opuesto]), 4) }}
                        </td>
                        <td class="align-middle text-nowrap bg-soft-primary">
                            <i>D<sub>m</sub> </i> desviacion
                        </td>
                        <td>{{ number_format(App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[$initial_final][$carga_opuesto]), 2) }}%
                            @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[$initial_final][$carga_opuesto]) > 0.1)
                                <img src="{{ asset('img/alert.png') }}" alt="" style="max-width: 15px"
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
                            AR-100  <br> </td>
                        <td>+(0-{{ number_format($ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['H6'] * 1000, 0) }})
                            μm</td>
                        <td class="align-middle text-nowrap bg-soft-primary">TOL. ISO
                            286
                        </td>
                        <td>+({{ number_format($ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['probable_min'] * 1000, 0) }}-{{ number_format($ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['probable_max'] * 1000, 0) }})
                            μm</td>
                    </tr>
                    <tr>
                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste Minimo (ISO 286) </td>
                        @php
                            $diff_min =
                                App\Http\Livewire\Pruebas\Ajustes::findMin($ajustes[$initial_final][$carga_opuesto]) -
                                $medida_max;
                      
                        @endphp
                        <td class="{{$diff_min > $ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['probable_min']?'bg-soft-success':'bg-soft-danger'}}">
                            {{ ($diff_min > 0 ? '(+)' : ($diff_min < 0 ? '(-)' : '')) . number_format(abs($diff_min*1000), 0) }}
                            μm
                        </td>
                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                            M&aacute;ximo (ISO 286)
                        </td>
                        @php
                                $diff =
                                    App\Http\Livewire\Pruebas\Ajustes::findMax(
                                        $ajustes[$initial_final][$carga_opuesto],
                                    ) - $medida_min;
                            @endphp
                        <td class="{{$diff < $ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['probable_max']?'bg-soft-success':'bg-soft-danger'}}">
                           {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff*1000), 0) }} 
                          
                            μm 
                        </td>
                    </tr>
                    <tr>
                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                            Minimo
                            (Solo alojamiento)</td>
                            @php
                                $ediff_min =
                                    App\Http\Livewire\Pruebas\Ajustes::findMin(
                                        $ajustes[$initial_final][$carga_opuesto],
                                    ) -
                                    $ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['diametro_externo'];
                                $ediff_min = round($ediff_min, 4);
                            @endphp
                        <td {{ $ediff_min >= 0 ? 'class=bg-soft-success' : 'class=bg-soft-danger' }}>
                            
                            {{ ($ediff_min > 0 ? '(+)' : ($ediff_min < 0 ? '(-)' : '')) . number_format(abs($ediff_min*1000), 0) }}
                            μm 
                        </td>
                        <td class="align-middle text-nowrap bg-soft-primary">Ajuste
                            M&aacute;ximo (Solo Alojamiento)
                        </td>
                        @php
                                $ediff =
                                    App\Http\Livewire\Pruebas\Ajustes::findMax(
                                        $ajustes[$initial_final][$carga_opuesto],
                                    ) -
                                    $ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['diametro_externo'];
                                $ediff = round($ediff, 4);
                            @endphp
                        <td {{ $ediff <= $ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['H6'] ? 'class=bg-soft-success' : 'class=bg-soft-danger' }}>
                            {{ ($ediff > 0 ? '(+)' : ($ediff < 0 ? '(-)' : '')) . number_format(abs($ediff*1000), 0) }}
                            μm 
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex">
                @if (App\Http\Livewire\Pruebas\Ajustes::findDeviation($ajustes[$initial_final][$carga_opuesto]) > 0.1)
                    <p class="w-100 text-start my-0">
                        <img src="{{ asset('img/alert.png') }}" alt="" style="max-width: 15px" class="mt-1">
                        <span class="text-danger">Demasiada Ovalacion</span>
                    </p>
                @endif
                @if ($diff_min < 0 || $diff_min < $ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['probable_min'])
                    <p class="w-100 text-start my-0">
                        <img src="{{ asset('img/alert.png') }}" alt="" style="max-width: 15px" class="">
                        <span class="text-danger">Ajuste demasiado apretado {{$diff_min}}</span>
                    </p>
                @endif
                @if ($ediff > $ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['H6'])
                    <p class="w-100 text-start my-0">
                        <img src="{{ asset('img/warning.jpg') }}" alt="" style="max-width: 15px"
                            class="">
                        <span class="text-danger">Ajuste holgado, no cumple con
                            EASA (AR-100)</span>
                    </p>
                @endif
                @if ($diff > $ajustes[$initial_final][$carga_opuesto]['rod']['rodamiento']['probable_max'])
                    <p class="w-100 text-start my-0">
                        <img src="{{ asset('img/alert.png') }}" alt="" style="max-width: 15px" class="mt-1">
                        <span class="text-danger">Ajuste demasiado holgado, no
                            cumple
                            con SKF (ISO 286)</span>
                    </p>
                @endif
            </div>

        </div>
    @endif
</div>
