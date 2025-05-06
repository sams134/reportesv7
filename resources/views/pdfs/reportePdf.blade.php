<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe final OS {{$motor->fullos}}</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #fff;
        color: #333;
    }

    .logo-img {
        max-height: 80px;
        position: relative;


    }

    .cajilla td {
        border: 2px solid #333;
        font-size: 16px;
        padding: 5px;
        text-transform: uppercase;
    }

    .table-striped {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ddd;
        align-self: center;
    }

    .table-striped th,
    .table-striped td {
        padding: 8px 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        font-size: 14px;
    }

    .table-striped th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .table-striped tr:nth-child(odd) {
        /*    background-color: #f2f2f2; */
        /* Fondo alterno para las filas impares */
    }

    .table-striped tr:hover {
        background-color: #e9ecef;
        /* Fondo cuando se pasa el ratón por encima */
    }

    .table-striped td:nth-child(odd),
    .table-striped th:nth-child(odd) {
        background-color: #e9f2f9;
        font-weight: bold;
    }

    .tt td {
        border: 1px solid #333;
    }

    .border-2 td {
        border: 2px solid #333;

    }

    .border-1 td {
        border: 1px solid #333;

    }

    .rodamiento td {
        font-size: 16px;
        padding: 8px;
        text-align: left;
    }

    .padding-3 td {
        padding: 3px;
    }
</style>

<body>
    @php
        $page1 = 20;
        $page2 = 1325;
        $page3 = 1325;
        $page4 = 1321;
        $pageCount = 2;
    @endphp
    <div style="position: absolute;top:{{ $page1 + 0 }}px;left:20px;width:95%;height:1280px;border:3px solid #333">
        <div style="position: relative; width:100%;background:#000044;height:120px;"></div>
        <div style="position: relative; width:100%;background:#550000;height:20px;"></div>
        <div style="position: relative;width:100%;text-align:center">
            <img src="{{ public_path('img/logo.jpg') }}" alt="Logo">
        </div>
        <div style="position: relative;width:100%;text-align:center;">
            <h1 style="position: relative">REPORTE TECNICO DE REPARACION</h1>
            <H2 style="position: relative;top:-15px;color:#550000">
                {{ $motor->infoMotor->nombre_equipo ? $motor->infoMotor->nombre_equipo : ($motor->tipoequipo?$motor->tipoequipo->name:$motor->id_tipoequipo) }}
            </H2>
            <img src="{{ public_path('storage' . $foto_final->foto) }}" alt="Imagen de Entrada"
                style="position: relative;max-width: 80%; border-radius: 4px;max-height: 450px;">
        </div>
        <div style="position:absolute;width:100%;bottom:50px">
            <img src="{{ public_path('img/ieee.jpg') }}" alt="Logo" class="logo-img" style="left:10px">
            <img src="{{ public_path('img/iec.png') }}" alt="Logo" class="logo-img" style="left:100px">
            <img src="{{ public_path('img/easa.jpg') }}" alt="Logo" class="logo-img" style="left:190px">
            <img src="{{ public_path('img/nema.png') }}" alt="Logo" class="logo-img" style="left:250px">
        </div>
        <div style="position: absolute; width:100%;background:#000044;height:50px;bottom:0px"></div>
    </div>
        {{-- page 2 --}}
        <div style="position: absolute;top:{{ $page2 + 0 }}px;width:95%;left:20px;height:1280px;border:3px solid #333">
            <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
            <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
            <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                <tr>
                    <td colspan="3" style="font-weight: bold;">INFORME TECNICO DE MANTENIMIENTO</td>
                    <td style="font-weight: bold;">Inicio:</td>
                    <td>{{ \Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}</td>
                    <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}" alt="Logo"
                            style="max-height: 100px"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">CLIENTE:</td>
                    <td colspan="2">{{ $motor->cliente->cliente }}</td>
                    <td style="font-weight: bold;">Fin:</td>
                    <td>{{ \Carbon\Carbon::parse($motor->fin)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">OS:</td>
                    <td colspan="2">{{ $motor->fullos }}</td>
                    <td style="font-weight: bold;color:#550000" colspan="2">{{ $motor->infoMotor->nombre_equipo ? $motor->infoMotor->nombre_equipo : ($motor->tipoequipo?$motor->tipoequipo->name:$motor->id_tipoequipo) }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">Potencia:</td>
                    <td>{{ $motor->potencia }}</td>
                    <td style="font-weight: bold;">RPM:</td>
                    <td colspan="2">{{ $motor->rpm }}</td>
                </tr>
            </table>
            <div style="position: relative;width:100%;text-align:center;text-transform: uppercase;">
                <h1>Datos de placa</h1>
                <table style="width: 100%;border-collapse: collapse;">
                    <tr>
                        <td style="width:10%"></td>
                        <td>
                            <table class="table-striped" style="">
                                <colgroup>
                                    <col style="width:20%">
                                    <col style="width:30%">
                                    <col style="width:20%">
                                    <col style="width:30%">
                                </colgroup>
                                <tr>
                                    <td colspan="4"
                                        style="text-align: center;background:#000033;color:#ddd;font-size:24px;">DATOS
                                        DEL EQUIPO</td>

                                </tr>
                                <tr>
                                    <td colspan="2">Nombre del Equipo</td>
                                    <td colspan="2">
                                        {{ $motor->infoMotor->nombre_equipo ? $motor->infoMotor->nombre_equipo : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Marca</td>
                                    <td>{{ $motor->marca }}</td>
                                    <td width="20%">Serie</td>
                                    <td>{{ $motor->serie }}</td>
                                </tr>
                                <tr>
                                    <td>Modelo</td>
                                    <td>{{ $motor->modelo }}</td>
                                    <td>Potencia</td>
                                    <td>{{ $motor->potencia }}</td>
                                </tr>
                                <tr>

                                    <td>Volts</td>
                                    <td>{{ $motor->volts }}</td>
                                    <td>Amps</td>
                                    <td>{{ $motor->amps }}</td>
                                </tr>
                                <tr>
                                    <td>RPM</td>
                                    <td>{{ $motor->rpm }}</td>
                                    <td>Factor Potencia</td>
                                    <td>{{ $motor->pf }}</td>

                                </tr>
                                <tr>
                                    <td>Eficiencia</td>
                                    <td>{{ $motor->eff }}</td>
                                    <td>HZ</td>
                                    <td>{{ $motor->hz }}</td>
                                </tr>
                                <tr>

                                    <td>Frame</td>
                                    <td>{{ $motor->frame }}</td>
                                    <td>Fases</td>
                                    <td>{{ $motor->phases }}</td>
                                </tr>
                                <tr>
                                    <td colspan="1">Comentarios de Cliente</td>
                                    <td colspan="3">{{ $motor->comentarios }}</td>
                                </tr>
                                <tr>
                                    <td>Placa</td>
                                    <td colspan="3" style="text-align: center;">
                                        <img src="{{ public_path('storage' . $motor->fotos->first()->foto) }}"
                                            alt="Imagen de Entrada" style="max-height: 150px; border-radius: 4px;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:10%"></td>
                    </tr>
                </table>
                <table style="width: 100%;border-collapse: collapse;position:relative;top:100px;" class="tt">
                    <tr>
                        <td>
                            <div
                                style="border: 1px solid #ddd; border-radius: 4px; max-width: 90%;  padding: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <div style="padding: 5px;">
                                    <img src="{{ public_path('storage' . $motor->fotos->first()->foto) }}"
                                        alt="Imagen de Entrada"
                                        style="max-width: 100%; border-radius: 4px;max-height: 300px;">
                                    <div style="width: 100%;color:#000033;text-align:center">Imagen Entrada</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div
                                style="border: 1px solid #ddd; border-radius: 4px; max-width: 90%;  padding: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <div style="padding: 5px;">
                                    <img src="{{ public_path('storage' . $foto_final->foto) }}" alt="Imagen de Entrada"
                                        style="max-width: 100%; border-radius: 4px;max-height: 300px;">
                                    <div style="width: 100%;color:#000033;text-align:center">Imagen Salida</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

            </div>
            <div style="position: absolute; width:100%;background:#000044;height:25px;bottom:0px"></div>
        </div>
        {{-- page 3 --}}
        @php
        $rodamientos = null;
             if ($motor->ajustes->count() == 4){
            for ($i = 1; $i < 4; $i += 2) {
                $rod = $motor->ajustes
                    ->where('carga_opuesto', intdiv($i, 2))
                    ->where('initial_final', $i % 2)
                    ->first();
                $rodInicial = $motor->ajustes
                    ->where('carga_opuesto', intdiv($i, 2))
                    ->where('initial_final', 0)
                    ->first();
                $cojineteMax = max($rod->p, $rod->q, $rod->r);
                $cojineteMin = min($rod->p, $rod->q, $rod->r);
                $alojamientoInicialMax = max(
                    $rodInicial->ax,
                    $rodInicial->ay,
                    $rodInicial->bx,
                    $rodInicial->by,
                    $rodInicial->cx,
                    $rodInicial->cy,
                );
                $alojamientoInicialMin = min(
                    $rodInicial->ax,
                    $rodInicial->ay,
                    $rodInicial->bx,
                    $rodInicial->by,
                    $rodInicial->cx,
                    $rodInicial->cy,
                );
                $alojamientoFinalMax = max($rod->ax, $rod->ay, $rod->bx, $rod->by, $rod->cx, $rod->cy);
                $alojamientoFinalMin = min($rod->ax, $rod->ay, $rod->bx, $rod->by, $rod->cx, $rod->cy);
                $rodamientos[] = [
                    'codigo' => $rod->rodamiento->designacion,
                    'juego_radial' => $rod->juego_radial == 1 ? 'Ninguno' : ($rod->juego_radial == 2 ? 'C3' : 'C4'),
                    'marca' => $rod->rodamientoMarca->name,
                    'sellos' => $rod->sellos == 1 ? 'Ninguno' : ($rod->juego_radial == 2 ? 'Metal (ZZ)' : 'Hule (2RS)'),
                    'jaula' => $rod->jaula == 1 ? 'Metal' : ($rod->juego_radial == 2 ? 'Bronce' : 'Poliamida'),
                    'grasa' => $rod->grasa->name,
                    'img' =>
                        $rod->rodamiento->tipo == 1 ? public_path('img/bolas.png') : public_path('img/rodillos.png'),
                    'tipo' => $rod->rodamiento->tipo,
                    'medidas' => $rod->rodamiento,
                    'title' => $rod->carga_opuesto == 0 ? 'Lado de Carga' : 'Lado Opuesto',
                    'rod' => $rod,
                    'rodInicial' => $rodInicial,
                    'cojineteMax' => $cojineteMax,
                    'cojineteMin' => $cojineteMin,
                    'alojamientoInicialMax' => $alojamientoInicialMax,
                    'alojamientoInicialMin' => $alojamientoInicialMin,
                    'alojamientoFinalMax' => $alojamientoFinalMax,
                    'alojamientoFinalMin' => $alojamientoFinalMin,
                ];
            }
        }
        @endphp
        @if ($rodamientos)
            @foreach ($rodamientos as $index => $rodamiento)
                <div
                    style="position: absolute;top:{{ $page2 * (2 + $index) + 0 }}px;width:95%;left:20px;height:1280px;border:3px solid #333">
                    <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
                    <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
                    <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <td colspan="3" style="font-weight: bold;">INFORME TECNICO DE MANTENIMIENTO</td>
                            <td style="font-weight: bold;">Inicio:</td>
                            <td>{{ \Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}</td>
                            <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}"
                                    alt="Logo" style="max-height: 100px"></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;width:100px">CLIENTE:</td>
                            <td colspan="2">{{ $motor->cliente->cliente }}</td>
                            <td style="font-weight: bold;">Fin:</td>
                            <td>{{ \Carbon\Carbon::parse($motor->fin)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;width:100px">OS:</td>
                            <td colspan="2">{{ $motor->fullos }}</td>
                            <td style="font-weight: bold;color:#550000" colspan="2">{{ $motor->infoMotor->nombre_equipo ? $motor->infoMotor->nombre_equipo : ($motor->tipoequipo?$motor->tipoequipo->name:$motor->id_tipoequipo) }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;width:100px">Potencia:</td>
                            <td>{{ $motor->potencia }}</td>
                            <td style="font-weight: bold;">RPM:</td>
                            <td colspan="2">{{ $motor->rpm }}</td>
                        </tr>
                    </table>
                    <div style="position: relative;width:100%;text-align:center;text-transform: uppercase;">
                        <h1>Alojamiento {{ $rodamiento['title'] }}</h1>
                        <table style="width:100%;position: relative;top:-15px" class="">
                            <tr>
                                <td style="width:2%"></td>
                                <td>
                                    <table style="width: 100%;border-collapse: collapse;" class="border-2">
                                        <colgroup>
                                            <col style="width:100px">
                                            <col style="width:100px">
                                            <col style="width:100px">
                                            <col style="width:100px">
                                            <col style="width:100px">
                                            <col style="width:100px">
                                            <col style="width:100px">
                                            <col style="width:100px">
                                        </colgroup>
                                        <tr>
                                            <td style="background: #000033;color:#ddd" colspan="8">Datos del rodamiento
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold">Codigo</td>
                                            <td colspan="2"> {{ $rodamiento['codigo'] }}</td>
                                            <td style="background: #000033;color:#ddd"></td>
                                            <td colspan="2" style="font-weight: bold">Juego Radial</td>
                                            <td colspan="2">{{ $rodamiento['juego_radial'] }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold">Marca</td>
                                            <td colspan="2"> {{ $rodamiento['marca'] }}</td>
                                            <td style="background: #000033;color:#ddd"></td>
                                            <td colspan="2" style="font-weight: bold">Sellos</td>
                                            <td colspan="2">{{ $rodamiento['sellos'] }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold">Jaula</td>
                                            <td colspan="2"> {{ $rodamiento['jaula'] }}</td>
                                            <td style="background: #000033;color:#ddd"></td>
                                            <td colspan="2" style="font-weight: bold">Grasa a Utilizar</td>
                                            <td colspan="2">{{ $rodamiento['grasa'] }}</td>
                                        </tr>

                                    </table>
                                </td>
                                <td style="width:2%"></td>
                            </tr>
                        </table>
                        <table style="position: relative;width:100%;text-align:center;top:-15px">
                            <tr>
                                <td width="2%"></td>
                                <td style="border: 2px solid #333;">
                                    <table style="width: 100%;border-collapse: collapse;text-transform:none"
                                        class="rodamiento">
                                        <tr>
                                            <td width="38%" style="text-align: left;margin-left:20px">
                                                <img src="{{ $rodamiento['img'] }}" alt=""
                                                    style="max-width: {{ $rodamiento['tipo'] == 2 ? '300' : '200' }}px">
                                            </td>
                                            <td style="vertical-align: top">
                                                <table style="width: 100%;border-collapse: collapse;">
                                                    <tr>
                                                        <td colspan="3" style="border-bottom: 2px solid #555">
                                                            <span style="font-size: 24px">Dimensiones</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>d</td>
                                                        <td> {{ $rodamiento['medidas']['diametro_interno'] }} mm </td>
                                                        <td> Diámetro del agujero</td>
                                                    </tr>
                                                    <tr>
                                                        <td>D</td>
                                                        <td> {{ $rodamiento['medidas']['diametro_externo'] }} mm </td>
                                                        <td> Diámetro exterior</td>
                                                    </tr>
                                                    <tr>
                                                        <td>B</td>
                                                        <td> {{ $rodamiento['medidas']['ancho'] }} mm </td>
                                                        <td>Ancho </td>
                                                    </tr>
                                                    <tr>
                                                        <td>d<sub>1</sub></td>
                                                        <td> ≈ {{ $rodamiento['medidas']['diametro_resalte'] }} mm </td>
                                                        <td>Diámetro del resalte </td>
                                                    </tr>
                                                    @if ($rodamiento['tipo'] == 1)
                                                        <tr>
                                                            <td>D<sub>2</sub></td>
                                                            <td> ≈ {{ $rodamiento['medidas']['diametro_rebaje'] }} mm </td>
                                                            <td>Diámetro del rebaje </td>
                                                        </tr>
                                                    @endif
                                                    @if ($rodamiento['tipo'] == 2)
                                                        <tr>
                                                            <td>F</td>
                                                            <td> min {{ $rodamiento['medidas']['F'] }} mm </td>
                                                            <td>Diámetro del camino de rodadura del aro interior </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td>r<sub>1,2</sub></td>
                                                        <td> min {{ $rodamiento['medidas']['chaflan'] }} mm </td>
                                                        <td>Dimensión del chaflán </td>
                                                    </tr>
                                                    @if ($rodamiento['tipo'] == 2)
                                                        <tr>
                                                            <td>r<sub>3,4</sub></td>
                                                            <td> min {{ $rodamiento['medidas']['r3_4'] }} mm </td>
                                                            <td>Dimensión del chaflán </td>
                                                        </tr>
                                                        <tr>
                                                            <td>s<sub></sub></td>
                                                            <td> min {{ $rodamiento['medidas']['s'] }} mm </td>
                                                            <td>Desplazamiento axial admisible</td>
                                                        </tr>
                                                    @endif

                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="2%"></td>
                            </tr>
                        </table>
                        <table style="position: relative;width:100%;text-align:center;top:-5px;border-collapse:collapse"
                            class="">
                            <colgroup>
                                <col width="2%">
                                <col width="38%">
                                <col width="8%">
                                <col width="50%">
                                <col width="2%">
                            </colgroup>
                            <tr>
                                <td></td>
                                <td>
                                    <table style="width:100%;border-collapse:collapse;text-transform:none"
                                        class="border-1 padding-3">
                                        <tr>
                                            <td colspan="3"
                                                style="background: #000033;color:#ddd;font-size:13px;font-weight:bold;padding:5px">
                                                MEDIDAS REALES DEL COJINETE @ 25.3 °C </td>
                                        </tr>
                                        <tr>
                                            <td style="background: #333;color:#ddd">A @ 0</td>
                                            <td>{{ $rodamiento['rod']['p'] }}</td>
                                            <td>mm</td>
                                        </tr>
                                        <tr>
                                            <td style="background: #333;color:#ddd">B @ 120</td>
                                            <td>{{ $rodamiento['rod']['q'] }}</td>
                                            <td>mm</td>
                                        </tr>
                                        <tr>
                                            <td style="background: #333;color:#ddd">A @ 240</td>
                                            <td>{{ $rodamiento['rod']['r'] }}</td>
                                            <td>mm</td>
                                        </tr>
                                    </table>
                                    <div style="width:100%;border:2px solid #333;margin-top:20px">
                                        <img src="{{ public_path('img/tapas.png') }}" alt="Logo"
                                            style="max-width: 99%;border">
                                        <div style="width:100%;background:#000033;color:#ddd;padding:2px">PROCEDIMENTO DE
                                            MEDIDAS</div>
                                    </div>

                                </td>
                                <td></td>
                                <td style="vertical-align: top">
                                    <table style="width:100%;border-collapse:collapse;text-transform:none"
                                        class="border-1">
                                        <colgroup>
                                            <col style="width:65%;background:#333;color:#ddd">
                                            <col style="width:20%">
                                            <col>
                                        </colgroup>
                                        <tr>
                                            <td colspan="3"
                                                style="background: #000033;color:#ddd;font-size:15px;font-weight:bold;padding:5px">
                                                Tolerancia Recomendada</td>
                                        </tr>
                                        <tr>
                                            <td style="color:#ddd;text-align: left;">Regimen de Tolerancia: </td>
                                            <td colspan="2">H6 (ISO 286)</td>

                                        </tr>
                                        <tr>
                                            <td style="color:#ddd;text-align: left;">Máxima Holgura (ISO 286):</td>
                                            <td>(+) {{ $rodamiento['rod']['rodamiento']['probable_max'] * 1000 }}</td>
                                            <td>μm</td>
                                        </tr>
                                        <tr>
                                            <td style="color:#ddd;text-align: left;">Máxima Interferencia (ISO 286):</td>
                                            <td>(+) {{ $rodamiento['rod']['rodamiento']['probable_min'] * 1000 }}</td>
                                            <td>μm</td>
                                        </tr>
                                        <tr>
                                            <td style="color:#ddd;text-align: left;">EASA AR-100:</td>
                                            <td>(+) [0-{{ $rodamiento['rod']['rodamiento']['H6'] * 1000 }}]</td>
                                            <td>μm</td>
                                        </tr>
                                    </table>
                                    <p style="text-align: left;margin-top:0px;font-size:12px;"><i>(+)Holgura /
                                        (-)Interferencia</i></p>
                                    <table
                                        style="width:100%;border-collapse:collapse;text-transform:none;margin-top:15px;font-weight:800"
                                        class="border-1 padding-3">
                                        <colgroup>
                                            <col style="width:20%">
                                            <col style="width:40%;">
                                            <col style="width:40%">
                                        </colgroup>
                                        <tr>
                                            <td colspan="3"
                                                style="background: #000033;color:#ddd;font-size:15px;font-weight:bold;padding:5px">
                                                Medidas de Alojamientos @ 25.3 °C</td>
                                        </tr>
                                        <tr>
                                            <td>PUNTO</td>
                                            <td>INICIAL [mm]</td>
                                            <td>FINAL [mm]</td>
                                        </tr>
                                        <tr>
                                            <td>AX</td>
                                            <td>{{ number_format($rodamiento['rodInicial']['ax'], 4) }}</td>
                                            <td>{{ number_format($rodamiento['rod']['ax'], 4) }}</td>
                                        </tr>
                                        <tr>
                                            <td>AY</td>
                                            <td>{{ number_format($rodamiento['rodInicial']['ay'], 4) }}</td>
                                            <td>{{ number_format($rodamiento['rod']['ay'], 4) }}</td>
                                        </tr>
                                        <tr>
                                            <td>BX</td>
                                            <td>{{ number_format($rodamiento['rodInicial']['bx'], 4) }}</td>
                                            <td>{{ number_format($rodamiento['rod']['bx'], 4) }}</td>
                                        </tr>
                                        <tr>
                                            <td>BY</td>
                                            <td>{{ number_format($rodamiento['rodInicial']['by'], 4) }}</td>
                                            <td>{{ number_format($rodamiento['rod']['by'], 4) }}</td>
                                        </tr>
                                        <tr>
                                            <td>CX</td>
                                            <td>{{ number_format($rodamiento['rodInicial']['cx'], 4) }}</td>
                                            <td>{{ number_format($rodamiento['rod']['cx'], 4) }}</td>
                                        </tr>
                                        <tr>
                                            <td>CY</td>
                                            <td>{{ number_format($rodamiento['rodInicial']['cy'], 4) }}</td>
                                            <td>{{ number_format($rodamiento['rod']['cy'], 4) }}</td>
                                        </tr>
                                        <tr>
                                            <td>TOL MAX:</td>
                                            @php
                                                $diff = $rodamiento['alojamientoInicialMax'] - $rodamiento['cojineteMin'];
                                                $color =
                                                    $diff > $rodamiento['rod']['rodamiento']['probable_min'] &&
                                                    $diff < $rodamiento['rod']['rodamiento']['probable_max']
                                                        ? '#00aa00'
                                                        : '#dd0000';
                                            @endphp
                                            <td style="background:{{ $color }}">
                                                {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                μm
                                            </td>
                                            @php
                                                $diff = $rodamiento['alojamientoFinalMax'] - $rodamiento['cojineteMin'];
                                                $color =
                                                    $diff > $rodamiento['rod']['rodamiento']['probable_min'] &&
                                                    $diff < $rodamiento['rod']['rodamiento']['probable_max']
                                                        ? '#00aa00'
                                                        : '#dd0000';
                                            @endphp
                                            <td style="background:{{ $color }}">
                                                {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                μm
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>TOL MIN:</td>
                                            @php
                                                $diff = $rodamiento['alojamientoInicialMin'] - $rodamiento['cojineteMax'];
                                                $color =
                                                    $diff > $rodamiento['rod']['rodamiento']['probable_min'] &&
                                                    $diff < $rodamiento['rod']['rodamiento']['probable_max']
                                                        ? '#00aa00'
                                                        : '#dd0000';
                                            @endphp
                                            <td style="background:{{ $color }}">

                                                {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                μm
                                            </td>
                                            @php
                                                $diff = $rodamiento['alojamientoFinalMin'] - $rodamiento['cojineteMax'];
                                                $color =
                                                    $diff > $rodamiento['rod']['rodamiento']['probable_min'] &&
                                                    $diff < $rodamiento['rod']['rodamiento']['probable_max']
                                                        ? '#00aa00'
                                                        : '#dd0000';
                                            @endphp
                                            <td style="background:{{ $color }}">

                                                {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                μm

                                            </td>
                                        </tr>

                                    </table>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                        <p style="text-align: left;font-size:20px;font-weight:bold;margin-left:8px;margin-top:5px">NOTAS COMPLEMENTARIAS</p>

                    </div>
                    <div style="position: absolute; width:100%;background:#000044;height:25px;bottom:0px"></div>
                </div>
            @endforeach
        

            
            @foreach ($rodamientos as $index => $rodamiento)
                <div
                    style="position: absolute;top:{{ $page3 * (4 + $index) + 0 }}px;left:20px;width:95%;height:1280px;border:3px solid #333">
                    <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
                    <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
                    <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <td colspan="3" style="font-weight: bold;">INFORME TECNICO DE MANTENIMIENTO</td>
                            <td style="font-weight: bold;">Inicio:</td>
                            <td>{{ \Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}</td>
                            <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}"
                                    alt="Logo" style="max-height: 100px"></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;width:100px">CLIENTE:</td>
                            <td colspan="2">{{ $motor->cliente->cliente }}</td>
                            <td style="font-weight: bold;">Fin:</td>
                            <td>{{ \Carbon\Carbon::parse($motor->fin)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;width:100px">OS:</td>
                            <td colspan="2">{{ $motor->fullos }}</td>
                            <td style="font-weight: bold;color:#550000" colspan="2">{{ $motor->infoMotor->nombre_equipo ? $motor->infoMotor->nombre_equipo : ($motor->tipoequipo?$motor->tipoequipo->name:$motor->id_tipoequipo) }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;width:100px">Potencia:</td>
                            <td>{{ $motor->potencia }}</td>
                            <td style="font-weight: bold;">RPM:</td>
                            <td colspan="2">{{ $motor->rpm }}</td>
                        </tr>
                    </table>
                    <div style="position: relative;width:100%;text-align:center;text-transform: uppercase;">
                        <h1>Eje {{ $rodamiento['title'] }}</h1>
                        <table style="width:100%;position: relative;top:-15px" class="">
                            <tr>
                                <td style="width:2%"></td>
                                <td>
                                    <table style="width: 100%;border-collapse: collapse;" class="border-2">
                                        <colgroup>
                                            <col style="width:100px">
                                            <col style="width:100px">
                                            <col style="width:100px">
                                            <col style="width:100px">
                                            <col style="width:100px">
                                            <col style="width:100px">
                                            <col style="width:100px">
                                            <col style="width:100px">
                                        </colgroup>
                                        <tr>
                                            <td style="background: #000033;color:#ddd" colspan="8">Datos del rodamiento
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold">Codigo</td>
                                            <td colspan="2"> {{ $rodamiento['codigo'] }}</td>
                                            <td style="background: #000033;color:#ddd"></td>
                                            <td colspan="2" style="font-weight: bold">Juego Radial</td>
                                            <td colspan="2">{{ $rodamiento['juego_radial'] }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold">Marca</td>
                                            <td colspan="2"> {{ $rodamiento['marca'] }}</td>
                                            <td style="background: #000033;color:#ddd"></td>
                                            <td colspan="2" style="font-weight: bold">Sellos</td>
                                            <td colspan="2">{{ $rodamiento['sellos'] }}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold">Jaula</td>
                                            <td colspan="2"> {{ $rodamiento['jaula'] }}</td>
                                            <td style="background: #000033;color:#ddd"></td>
                                            <td colspan="2" style="font-weight: bold">Grasa a Utilizar</td>
                                            <td colspan="2">{{ $rodamiento['grasa'] }}</td>
                                        </tr>

                                    </table>
                                </td>
                                <td style="width:2%"></td>
                            </tr>
                        </table>
                        <table style="position: relative;width:100%;text-align:center;top:-15px">
                            <tr>
                                <td width="2%"></td>
                                <td style="border: 2px solid #333;">
                                    <table style="width: 100%;border-collapse: collapse;text-transform:none"
                                        class="rodamiento">
                                        <tr>
                                            <td width="38%" style="text-align: left;margin-left:20px">
                                                <img src="{{ $rodamiento['img'] }}" alt=""
                                                    style="max-width: {{ $rodamiento['tipo'] == 2 ? '300' : '200' }}px">
                                            </td>
                                            <td style="vertical-align: top">
                                                <table style="width: 100%;border-collapse: collapse;">
                                                    <tr>
                                                        <td colspan="3" style="border-bottom: 2px solid #555">
                                                            <span style="font-size: 24px">Dimensiones</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>d</td>
                                                        <td> {{ $rodamiento['medidas']['diametro_interno'] }} mm </td>
                                                        <td> Diámetro del agujero</td>
                                                    </tr>
                                                    <tr>
                                                        <td>D</td>
                                                        <td> {{ $rodamiento['medidas']['diametro_externo'] }} mm </td>
                                                        <td> Diámetro exterior</td>
                                                    </tr>
                                                    <tr>
                                                        <td>B</td>
                                                        <td> {{ $rodamiento['medidas']['ancho'] }} mm </td>
                                                        <td>Ancho </td>
                                                    </tr>
                                                    <tr>
                                                        <td>d<sub>1</sub></td>
                                                        <td> ≈ {{ $rodamiento['medidas']['diametro_resalte'] }} mm </td>
                                                        <td>Diámetro del resalte </td>
                                                    </tr>
                                                    @if ($rodamiento['tipo'] == 1)
                                                        <tr>
                                                            <td>D<sub>2</sub></td>
                                                            <td> ≈ {{ $rodamiento['medidas']['diametro_rebaje'] }} mm </td>
                                                            <td>Diámetro del rebaje </td>
                                                        </tr>
                                                    @endif
                                                    @if ($rodamiento['tipo'] == 2)
                                                        <tr>
                                                            <td>F</td>
                                                            <td> min {{ $rodamiento['medidas']['F'] }} mm </td>
                                                            <td>Diámetro del camino de rodadura del aro interior </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <td>r<sub>1,2</sub></td>
                                                        <td> min {{ $rodamiento['medidas']['chaflan'] }} mm </td>
                                                        <td>Dimensión del chaflán </td>
                                                    </tr>
                                                    @if ($rodamiento['tipo'] == 2)
                                                        <tr>
                                                            <td>r<sub>3,4</sub></td>
                                                            <td> min {{ $rodamiento['medidas']['r3_4'] }} mm </td>
                                                            <td>Dimensión del chaflán </td>
                                                        </tr>
                                                        <tr>
                                                            <td>s<sub></sub></td>
                                                            <td> min {{ $rodamiento['medidas']['s'] }} mm </td>
                                                            <td>Desplazamiento axial admisible</td>
                                                        </tr>
                                                    @endif

                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="2%"></td>
                            </tr>
                        </table>
                        <table style="position: relative;width:100%;text-align:center;top:-5px;border-collapse:collapse"
                            class="">
                            <colgroup>
                                <col width="2%">
                                <col width="38%">
                                <col width="8%">
                                <col width="50%">
                                <col width="2%">
                            </colgroup>
                            <tr>
                                <td></td>
                                <td>
                                    <table style="width:100%;border-collapse:collapse;text-transform:none"
                                        class="border-1 padding-3">
                                        <tr>
                                            <td colspan="3"
                                                style="background: #000033;color:#ddd;font-size:13px;font-weight:bold;padding:5px">
                                                MEDIDAS EXTERNAS DEL COJINETE @ 25.3 °C </td>
                                        </tr>
                                        <tr>
                                            <td style="background: #333;color:#ddd">A @ 0</td>
                                            <td>{{ number_format($rodamiento['rod']['s'],3) }}</td>
                                            <td>mm</td>
                                        </tr>
                                        <tr>
                                            <td style="background: #333;color:#ddd">B @ 120</td>
                                            <td>{{ number_format(($rodamiento['rod']['s']+ $rodamiento['rod']['t'])/2,3)}}</td>
                                            <td>mm</td>
                                        </tr>
                                        <tr>
                                            <td style="background: #333;color:#ddd">A @ 240</td>
                                            <td>{{ number_format($rodamiento['rod']['t'],3) }}</td>
                                            <td>mm</td>
                                        </tr>
                                    </table>
                                    <div style="width:100%;border:2px solid #333;margin-top:20px">
                                        <img src="{{ public_path('img/ejes.png') }}" alt="Logo"
                                            style="max-width: 60%;border">
                                        <div style="width:100%;background:#000033;color:#ddd;padding:2px">PROCEDIMENTO DE
                                            MEDIDAS</div>
                                    </div>

                                </td>
                                <td></td>
                                <td style="vertical-align: top">
                                    <table style="width:100%;border-collapse:collapse;text-transform:none"
                                        class="border-1">
                                        <colgroup>
                                            <col style="width:65%;background:#333;color:#ddd">
                                            <col style="width:20%">
                                            <col>
                                        </colgroup>
                                        <tr>
                                            <td colspan="3"
                                                style="background: #000033;color:#ddd;font-size:15px;font-weight:bold;padding:5px">
                                                Tolerancia Recomendada</td>
                                        </tr>
                                        <tr>
                                            <td style="color:#ddd;text-align: left;">Regimen de Tolerancia: </td>
                                            <td colspan="2">{{$rodamiento['rod']['rodamiento']['eje_ball_tol']}} (ISO 286)</td>

                                        </tr>
                                        <tr>
                                            <td style="color:#ddd;text-align: left;">Máximo Ajuste (ISO 286):</td>
                                            <td>(-) {{ $rodamiento['rod']['rodamiento']['eje_ball_max'] * 1000 }}</td>
                                            <td>μm</td>
                                        </tr>
                                        <tr>
                                            <td style="color:#ddd;text-align: left;">M&iacute;nimo Ajuste (ISO 286):</td>
                                            <td>(-) {{ $rodamiento['rod']['rodamiento']['eje_ball_min'] * 1000 }}</td>
                                            <td>μm</td>
                                        </tr>
                                    
                                    </table>
                                    <p style="text-align: left;margin-top:0px;font-size:12px;"><i>(+)Holgura /
                                        (-)Interferencia</i></p>
                                    <table
                                        style="width:100%;border-collapse:collapse;text-transform:none;margin-top:15px;font-weight:800"
                                        class="border-1 padding-3">
                                        <colgroup>
                                            <col style="width:20%">
                                            <col style="width:40%;">
                                            <col style="width:40%">
                                        </colgroup>
                                        <tr>
                                            <td colspan="3"
                                                style="background: #000033;color:#ddd;font-size:15px;font-weight:bold;padding:5px">
                                                Medidas de Alojamientos @ 25.3 °C</td>
                                        </tr>
                                        <tr>
                                            <td>PUNTO</td>
                                            <td>INICIAL [mm]</td>
                                            <td>FINAL [mm]</td>
                                        </tr>
                                        <tr>
                                            <td>Punto 1</td>
                                            <td>{{ number_format($rodamiento['rodInicial']['e1'], 4) }}</td>
                                            <td>{{ number_format($rodamiento['rod']['e1'], 4) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Punto 2</td>
                                            <td>{{ number_format($rodamiento['rodInicial']['e2'], 4) }}</td>
                                            <td>{{ number_format($rodamiento['rod']['e2'], 4) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Punto 3</td>
                                            <td>{{ number_format($rodamiento['rodInicial']['e3'], 4) }}</td>
                                            <td>{{ number_format($rodamiento['rod']['e3'], 4) }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>TOL MAX:</td>
                                            @php
                                                $diff = $rodamiento['alojamientoInicialMax'] - $rodamiento['cojineteMin'];
                                                $color =
                                                    $diff > $rodamiento['rod']['rodamiento']['probable_min'] &&
                                                    $diff < $rodamiento['rod']['rodamiento']['probable_max']
                                                        ? '#00aa00'
                                                        : '#dd0000';
                                            @endphp
                                            <td style="background:{{ $color }}">
                                                {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                μm
                                            </td>
                                            @php
                                                $diff = $rodamiento['alojamientoFinalMax'] - $rodamiento['cojineteMin'];
                                                $color =
                                                    $diff > $rodamiento['rod']['rodamiento']['probable_min'] &&
                                                    $diff < $rodamiento['rod']['rodamiento']['probable_max']
                                                        ? '#00aa00'
                                                        : '#dd0000';
                                            @endphp
                                            <td style="background:{{ $color }}">
                                                {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                μm
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>TOL MIN:</td>
                                            @php
                                                $diff = $rodamiento['alojamientoInicialMin'] - $rodamiento['cojineteMax'];
                                                $color =
                                                    $diff > $rodamiento['rod']['rodamiento']['probable_min'] &&
                                                    $diff < $rodamiento['rod']['rodamiento']['probable_max']
                                                        ? '#00aa00'
                                                        : '#dd0000';
                                            @endphp
                                            <td style="background:{{ $color }}">

                                                {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                μm
                                            </td>
                                            @php
                                                $diff = $rodamiento['alojamientoFinalMin'] - $rodamiento['cojineteMax'];
                                                $color =
                                                    $diff > $rodamiento['rod']['rodamiento']['probable_min'] &&
                                                    $diff < $rodamiento['rod']['rodamiento']['probable_max']
                                                        ? '#00aa00'
                                                        : '#dd0000';
                                            @endphp
                                            <td style="background:{{ $color }}">

                                                {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                μm

                                            </td>
                                        </tr>

                                    </table>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                        <p style="text-align: left;font-size:20px;font-weight:bold;margin-left:15px;margin-top:5px">NOTAS COMPLEMENTARIAS</p>
                    </div>
                    <div style="position: absolute; width:100%;background:#000044;height:25px;bottom:0px"></div>
                </div>
            @endforeach
        @endif
        @php
           $fotos = $motor->fotos->where('addToReport', 1)->values();
        $pageCount = 6;
        @endphp

        @for($i=0;$i<$fotos->count();$i++)
        
        <div style="position: absolute;top:{{ $page4 * ($pageCount + ( intdiv($i,2))) + 0 }}px;left:20px;width:95%;height:1280px;border:3px solid #333">
            <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
            <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
            <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                <tr>
                    <td colspan="3" style="font-weight: bold;">INFORME TECNICO DE MANTENIMIENTO</td>
                    <td style="font-weight: bold;">Inicio:</td>
                    <td>{{ \Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}</td>
                    <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}"
                            alt="Logo" style="max-height: 100px"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">CLIENTE:</td>
                    <td colspan="2">{{ $motor->cliente->cliente }}</td>
                    <td style="font-weight: bold;">Fin:</td>
                    <td>{{ \Carbon\Carbon::parse($motor->fin)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">OS:</td>
                    <td colspan="2">{{ $motor->fullos }}</td>
                    <td style="font-weight: bold;color:#550000" colspan="2">{{ $motor->infoMotor->nombre_equipo ? $motor->infoMotor->nombre_equipo : ($motor->tipoequipo?$motor->tipoequipo->name:$motor->id_tipoequipo) }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">Potencia:</td>
                    <td>{{ $motor->potencia }}</td>
                    <td style="font-weight: bold;">RPM:</td>
                    <td colspan="2">{{ $motor->rpm }}</td>
                </tr>
            </table>
            <div style="position: relative;width:100%;text-align:center;text-transform: uppercase;">
                <h1>Fotografias </h1>
                <img src="{{ public_path('storage' . $fotos[$i]->foto) }}" alt="Imagen de Entrada"
                style="position: relative;max-width: 90%;max-height:400px; border-radius: 4px;margin-top:20px">
                <table style="width:100%">
                    <tr>
                        <td width="5%"></td>
                        <td style="border:2px solid #333;padding:5px;background:#000033;color:#ddd">Comentario</td>
                        <td width="5%"></td>
                    </tr>
                </table>
                @if($i+1 < $fotos->count())
                <img src="{{ public_path('storage' . $fotos[++$i]->foto) }}" alt="Imagen de Entrada"
                style="position: relative;max-width: 90%;max-height:400px; border-radius: 4px;margin-top:20px">
                <table style="width:100%">
                    <tr>
                        <td width="5%"></td>
                        <td style="border:2px solid #333;padding:5px;background:#000033;color:#ddd">Comentario</td>
                        <td width="5%"></td>
                    </tr>
                </table>
                @endif
            </div>
        </div>
            
        @endfor
     
        @php
        $multi = ($pageCount + ( intdiv($fotos->count()-1,2)));
        $page5 = $page4 * ($multi  + 1);
        $page6 = $page4 * ($multi  + 2);
        $page7 = $page4 * ($multi  + 3);

        @endphp
        <div style="position: absolute;top:{{ $page5}}px;left:20px;width:95%;height:1280px;border:3px solid #333">
            <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
            <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
            <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                <tr>
                    <td colspan="3" style="font-weight: bold;">INFORME TECNICO DE MANTENIMIENTO</td>
                    <td style="font-weight: bold;">Inicio:</td>
                    <td>{{ \Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}</td>
                    <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}"
                            alt="Logo" style="max-height: 100px"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">CLIENTE:</td>
                    <td colspan="2">{{ $motor->cliente->cliente }}</td>
                    <td style="font-weight: bold;">Fin:</td>
                    <td>{{ \Carbon\Carbon::parse($motor->fin)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">OS:</td>
                    <td colspan="2">{{ $motor->fullos }}</td>
                    <td style="font-weight: bold;color:#550000" colspan="2">{{ $motor->infoMotor->nombre_equipo ? $motor->infoMotor->nombre_equipo : ($motor->tipoequipo?$motor->tipoequipo->name:$motor->id_tipoequipo) }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">Potencia:</td>
                    <td>{{ $motor->potencia }}</td>
                    <td style="font-weight: bold;">RPM:</td>
                    <td colspan="2">{{ $motor->rpm }}</td>
                </tr>
            </table>
            <div style="position: relative;width:100%;text-align:center;text-transform: uppercase;">
                <h1>Temperaturas</h1>
                <img src="data:image/png;base64,{{ base64_encode($motor->temperaturas) }}" alt="Temperaturas"
                    style="position: relative;max-width: 90%;max-height:400px; border-radius: 4px;margin-top:20px">
            </div>
        </div>
        {{-- page 6 Amperajes --}}
        <div style="position: absolute;top:{{ $page6}}px;left:20px;width:95%;height:1280px;border:3px solid #333">
            <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
            <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
            <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                <tr>
                    <td colspan="3" style="font-weight: bold;">INFORME TECNICO DE MANTENIMIENTO</td>
                    <td style="font-weight: bold;">Inicio:</td>
                    <td>{{ \Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}</td>
                    <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}"
                            alt="Logo" style="max-height: 100px"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">CLIENTE:</td>
                    <td colspan="2">{{ $motor->cliente->cliente }}</td>
                    <td style="font-weight: bold;">Fin:</td>
                    <td>{{ \Carbon\Carbon::parse($motor->fin)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">OS:</td>
                    <td colspan="2">{{ $motor->fullos }}</td>
                    <td style="font-weight: bold;color:#550000" colspan="2">{{ $motor->infoMotor->nombre_equipo ? $motor->infoMotor->nombre_equipo : ($motor->tipoequipo?$motor->tipoequipo->name:$motor->id_tipoequipo) }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">Potencia:</td>
                    <td>{{ $motor->potencia }}</td>
                    <td style="font-weight: bold;">RPM:</td>
                    <td colspan="2">{{ $motor->rpm }}</td>
                </tr>
            </table>
            <div style="position: relative;width:100%;text-align:center;text-transform: uppercase;">
                <h1>Amperajes</h1>
                <img src="data:image/png;base64,{{ base64_encode($motor->noLoadTest->graph_fl) }}" alt="Temperaturas"
                    style="position: relative;max-width: 90%;max-height:400px; border-radius: 4px;margin-top:20px">
            </div>
        </div>
        <div style="position: absolute;top:{{ $page7}}px;left:20px;width:95%;height:1280px;border:3px solid #333">
            <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
            <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
            <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                <tr>
                    <td colspan="3" style="font-weight: bold;">INFORME TECNICO DE MANTENIMIENTO</td>
                    <td style="font-weight: bold;">Inicio:</td>
                    <td>{{ \Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}</td>
                    <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}"
                            alt="Logo" style="max-height: 100px"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">CLIENTE:</td>
                    <td colspan="2">{{ $motor->cliente->cliente }}</td>
                    <td style="font-weight: bold;">Fin:</td>
                    <td>{{ \Carbon\Carbon::parse($motor->fin)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">OS:</td>
                    <td colspan="2">{{ $motor->fullos }}</td>
                    <td style="font-weight: bold;color:#550000" colspan="2">{{ $motor->infoMotor->nombre_equipo ? $motor->infoMotor->nombre_equipo : ($motor->tipoequipo?$motor->tipoequipo->name:$motor->id_tipoequipo) }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">Potencia:</td>
                    <td>{{ $motor->potencia }}</td>
                    <td style="font-weight: bold;">RPM:</td>
                    <td colspan="2">{{ $motor->rpm }}</td>
                </tr>
            </table>
            <div style="position: relative;width:100%;text-align:center;text-transform: uppercase;">
                <h1>Temperaturas</h1>
                <img src="data:image/png;base64,{{ base64_encode($motor->temperaturas) }}" alt="Temperaturas"
                    style="position: relative;max-width: 90%;max-height:400px; border-radius: 4px;margin-top:20px">
            </div>
        </div>

      

        {{--  @for ($i = 3; $i < 11; $i++)
            <div style="position: absolute;top:{{ $page2 * $i + 0 }}px;width:100%;height:1327px;border:3px solid #333">
                <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
                <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
                <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                    <tr>
                        <td colspan="3" style="font-weight: bold;">INFORME TECNICO DE MANTENIMIENTO</td>
                        <td style="font-weight: bold;">Inicio:</td>
                        <td>{{ \Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y') }}</td>
                        <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}"
                                alt="Logo" style="max-height: 100px"></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;width:100px">CLIENTE:</td>
                        <td colspan="2">{{ $motor->cliente->cliente }}</td>
                        <td style="font-weight: bold;">Fin:</td>
                        <td>{{ \Carbon\Carbon::parse($motor->fin)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;width:100px">OS:</td>
                        <td colspan="2">{{ $motor->fullos }}</td>
                        <td style="font-weight: bold;color:#550000" colspan="2">{{ $motor->tipoequipo->name }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;width:100px">Potencia:</td>
                        <td>{{ $motor->potencia }}</td>
                        <td style="font-weight: bold;">RPM:</td>
                        <td colspan="2">{{ $motor->rpm }}</td>
                    </tr>
                </table>
            </div>
        @endfor --}}


</body>

</html>
