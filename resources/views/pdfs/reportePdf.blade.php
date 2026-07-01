<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $isPreliminar ? 'Informe preliminar' : 'Informe final' }} OS {{ $motor->fullos }}</title>
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

    html,
    body {
        margin: 0;
        padding: 0;
        width: 1020px;
    }

    .pdf-sheet {
        position: relative;
        width: 1020px;
        height: 1310px;
        overflow: hidden;
        page-break-after: always;
        background: #ffffff;
    }

    .pdf-frame {
        position: relative;
        top: 20px;
        left: 20px;
        width: 970px;
        height: 1280px;
        border: 3px solid #333;
        box-sizing: border-box;
        overflow: hidden;
    }

    .pdf-blue-bottom {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 25px;
        background: #000044;
    }
</style>

<body>
    @php
        $pageHeight = 1325;
        $pageIndex = 0;

        $pageTop = function () use (&$pageIndex, $pageHeight) {
            $top = $pageIndex === 0 ? 20 : $pageHeight * $pageIndex;
            $pageIndex++;
            return $top;
        };

        $nombreEquipo =
            optional($motor->infoMotor)->nombre_equipo ?: (optional($motor->tipoequipo)->name ?: $motor->id_tipoequipo);

        $fechaIngresoTexto = $motor->fecha_ingreso
            ? \Carbon\Carbon::parse($motor->fecha_ingreso)->format('d/m/Y')
            : 'PENDIENTE';
    @endphp
    <div class="pdf-sheet">
        <div class="pdf-frame">
            <div style="position: relative; width:100%;background:#000044;height:120px;"></div>
            <div style="position: relative; width:100%;background:#550000;height:20px;"></div>
            <div style="position: relative;width:100%;text-align:center">
                <img src="{{ public_path('img/logo.jpg') }}" alt="Logo">
            </div>
            <div style="position: relative;width:100%;text-align:center;">
                <h1 style="position: relative">{{ $tituloInforme }}</h1>

                @if ($isPreliminar)
                    <div style="font-size:22px; color:#550000; font-weight:bold; margin-top:-10px;">
                        DOCUMENTO PRELIMINAR - EQUIPO AÚN NO FINALIZADO
                    </div>
                @endif
                <H2 style="position: relative;top:-15px;color:#550000">
                    {{ $nombreEquipo }}
                </H2>
                <img src="{{ $fotoFinalPath }}" alt="Imagen del equipo"
                    style="position: relative;max-width: 80%; border-radius: 4px;max-height: 450px;">
            </div>
            <div style="position:absolute;width:100%;bottom:50px">
                <img src="{{ public_path('img/ieee.jpg') }}" alt="Logo" class="logo-img" style="left:10px">
                <img src="{{ public_path('img/iec.png') }}" alt="Logo" class="logo-img" style="left:100px">
                <img src="{{ public_path('img/easa.jpg') }}" alt="Logo" class="logo-img" style="left:190px">
                <img src="{{ public_path('img/nema.png') }}" alt="Logo" class="logo-img" style="left:250px">
            </div>
            <div style="position: absolute; width:100%;background:#000044;height:50px;bottom:0px"></div>
            <div class="pdf-blue-bottom"></div>
        </div>
    </div>
    {{-- page 2 --}}
    <div class="pdf-sheet">
        <div class="pdf-frame">
            <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
            <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
            <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                <tr>
                    <td colspan="3" style="font-weight: bold;">{{ $tituloHeader }}</td>
                    <td style="font-weight: bold;">Inicio:</td>
                    <td>{{ $fechaIngresoTexto }}</td>
                    <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}" alt="Logo"
                            style="max-height: 100px"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">CLIENTE:</td>
                    <td colspan="2">{{ $motor->cliente->cliente }}</td>
                    <td style="font-weight: bold;">Fin:</td>
                    <td>{{ $fechaFinTexto }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;width:100px">OS:</td>
                    <td colspan="2">{{ $motor->fullos }}</td>
                    <td style="font-weight: bold;color:#550000" colspan="2">
                        {{ $nombreEquipo }}
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
                                        {{ $nombreEquipo }}
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
                                        <img src="{{ $fotoInicialPath }}" alt="Imagen de Entrada"
                                            style="max-height: 150px; border-radius: 4px;">
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
                                    <img src="{{ $fotoInicialPath }}" alt="Imagen de Entrada"
                                        style="max-width: 100%; border-radius: 4px;max-height: 300px;">
                                    <div style="width: 100%;color:#000033;text-align:center">Imagen Entrada</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div
                                style="border: 1px solid #ddd; border-radius: 4px; max-width: 90%;  padding: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <div style="padding: 5px;">
                                    <img src="{{ $fotoFinalPath }}"
                                        style="max-width: 100%; border-radius: 4px;max-height: 300px;">
                                    <div style="width: 100%;color:#000033;text-align:center">
                                        {{ $isPreliminar ? 'Imagen Actual / Preliminar' : 'Imagen Salida' }}
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

            </div>
            <div style="position: absolute; width:100%;background:#000044;height:25px;bottom:0px"></div>
            <div class="pdf-blue-bottom"></div>
        </div>
    </div>
    {{-- page 3 --}}

    @if ($rodamientos)
        @foreach ($rodamientos as $index => $rodamiento)
            <div class="pdf-sheet">
                <div class="pdf-frame">

                    <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
                    <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
                    <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <td colspan="3" style="font-weight: bold;">{{ $tituloHeader }}</td>
                            <td style="font-weight: bold;">Inicio:</td>
                            <td>{{ $fechaIngresoTexto }}</td>
                            <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}"
                                    alt="Logo" style="max-height: 100px"></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;width:100px">CLIENTE:</td>
                            <td colspan="2">{{ $motor->cliente->cliente }}</td>
                            <td style="font-weight: bold;">Fin:</td>
                            <td>{{ $fechaFinTexto }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;width:100px">OS:</td>
                            <td colspan="2">{{ $motor->fullos }}</td>
                            <td style="font-weight: bold;color:#550000" colspan="2">
                                {{ $nombreEquipo }}
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
                                            <td style="background: #000033;color:#ddd" colspan="8">Datos del
                                                rodamiento
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
                                                        <td> ≈ {{ $rodamiento['medidas']['diametro_resalte'] }} mm
                                                        </td>
                                                        <td>Diámetro del resalte </td>
                                                    </tr>
                                                    @if ($rodamiento['tipo'] == 1)
                                                        <tr>
                                                            <td>D<sub>2</sub></td>
                                                            <td> ≈ {{ $rodamiento['medidas']['diametro_rebaje'] }} mm
                                                            </td>
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
                        <table
                            style="position: relative;width:100%;text-align:center;top:-5px;border-collapse:collapse"
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
                                        <div style="width:100%;background:#000033;color:#ddd;padding:2px">PROCEDIMENTO
                                            DE
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
                                            <td style="color:#ddd;text-align: left;">Máxima Interferencia (ISO 286):
                                            </td>
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
                                            (-)
                                            Interferencia</i></p>
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
                                                $diff =
                                                    $rodamiento['alojamientoInicialMax'] - $rodamiento['cojineteMin'];
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
                                                $diff =
                                                    $rodamiento['alojamientoInicialMin'] - $rodamiento['cojineteMax'];
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
                        <p style="text-align: left;font-size:20px;font-weight:bold;margin-left:8px;margin-top:5px">
                            NOTAS
                            COMPLEMENTARIAS</p>
                        <p style="text-align: left; margin-left:20px;margin-right:20px">
                            <b>Recomendaci&oacute;n Inicial: </b> {{ $rodamiento['rodInicial']['recomendacion'] }} <br>
                            <b>Recomendaci&oacute;n Final: </b> {{ $rodamiento['rod']['recomendacion'] }} <br>

                        </p>
                    </div>

                    <div style="position: absolute; width:100%;background:#000044;height:25px;bottom:0px"></div>
                    <div class="pdf-blue-bottom"></div>
                </div>
            </div>
        @endforeach



        @foreach ($rodamientos as $index => $rodamiento)
            <div class="pdf-sheet">
                <div class="pdf-frame">
                    <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
                    <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
                    <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                        <tr>
                            <td colspan="3" style="font-weight: bold;">{{ $tituloHeader }}</td>
                            <td style="font-weight: bold;">Inicio:</td>
                            <td>{{ $fechaIngresoTexto }}</td>
                            <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}"
                                    alt="Logo" style="max-height: 100px"></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;width:100px">CLIENTE:</td>
                            <td colspan="2">{{ $motor->cliente->cliente }}</td>
                            <td style="font-weight: bold;">Fin:</td>
                            <td>{{ $fechaFinTexto }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;width:100px">OS:</td>
                            <td colspan="2">{{ $motor->fullos }}</td>
                            <td style="font-weight: bold;color:#550000" colspan="2">
                                {{ $nombreEquipo }}
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
                                            <td style="background: #000033;color:#ddd" colspan="8">Datos del
                                                rodamiento
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
                                                        <td> ≈ {{ $rodamiento['medidas']['diametro_resalte'] }} mm
                                                        </td>
                                                        <td>Diámetro del resalte </td>
                                                    </tr>
                                                    @if ($rodamiento['tipo'] == 1)
                                                        <tr>
                                                            <td>D<sub>2</sub></td>
                                                            <td> ≈ {{ $rodamiento['medidas']['diametro_rebaje'] }} mm
                                                            </td>
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
                        <table
                            style="position: relative;width:100%;text-align:center;top:-5px;border-collapse:collapse"
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
                                                MEDIDAS INTERNAS DEL COJINETE @ 25.3 °C </td>
                                        </tr>
                                        <tr>
                                            <td style="background: #333;color:#ddd">A @ 0</td>
                                            <td>{{ number_format($rodamiento['rod']['s'], 3) }}</td>
                                            <td>mm</td>
                                        </tr>
                                        <tr>
                                            <td style="background: #333;color:#ddd">B @ 120</td>
                                            <td>{{ number_format(($rodamiento['rod']['s'] + $rodamiento['rod']['t']) / 2, 3) }}
                                            </td>
                                            <td>mm</td>
                                        </tr>
                                        <tr>
                                            <td style="background: #333;color:#ddd">A @ 240</td>
                                            <td>{{ number_format($rodamiento['rod']['t'], 3) }}</td>
                                            <td>mm</td>
                                        </tr>
                                    </table>
                                    <div style="width:100%;border:2px solid #333;margin-top:20px">
                                        <img src="{{ public_path('img/ejes.png') }}" alt="Logo"
                                            style="max-width: 60%;border">
                                        <div style="width:100%;background:#000033;color:#ddd;padding:2px">PROCEDIMENTO
                                            DE
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
                                            <td colspan="2">{{ $rodamiento['rod']['rodamiento']['eje_ball_tol'] }}
                                                (ISO 286)
                                            </td>

                                        </tr>
                                        <tr>
                                            <td style="color:#ddd;text-align: left;">Máximo Ajuste (ISO 286):</td>
                                            <td>(-) {{ $rodamiento['rod']['rodamiento']['eje_ball_max'] * 1000 }}</td>
                                            <td>μm</td>
                                        </tr>
                                        <tr>
                                            <td style="color:#ddd;text-align: left;">M&iacute;nimo Ajuste (ISO 286):
                                            </td>
                                            <td>(-) {{ $rodamiento['rod']['rodamiento']['eje_ball_min'] * 1000 }}</td>
                                            <td>μm</td>
                                        </tr>

                                    </table>
                                    <p style="text-align: left;margin-top:0px;font-size:12px;"><i>(+)Holgura /
                                            (-)
                                            Interferencia</i></p>
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
                                                Medidas de Ejes @ 25.3 °C</td>
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
                                                $diff =
                                                    $rodamiento['ejeInicialMax'] -
                                                    min($rodamiento['rod']['s'], $rodamiento['rod']['t']);
                                                $color =
                                                    $diff > $rodamiento['rod']['rodamiento']['eje_ball_min'] &&
                                                    $diff < $rodamiento['rod']['rodamiento']['eje_ball_max']
                                                        ? '#00aa00'
                                                        : '#dd0000';
                                            @endphp
                                            <td style="background:{{ $color }}">
                                                {{--  {{ ($diff > 0 ? '(+)' : ($diff < 0 ? '(-)' : '')) . number_format(abs($diff), 0) }} --}}
                                                {{ ($diff > 0 ? '(-)' : ($diff < 0 ? '(+)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                μm
                                            </td>
                                            @php

                                                $diff =
                                                    $rodamiento['ejeFinalMax'] -
                                                    min($rodamiento['rod']['s'], $rodamiento['rod']['t']);
                                                $color =
                                                    $diff > $rodamiento['rod']['rodamiento']['eje_ball_min'] &&
                                                    $diff < $rodamiento['rod']['rodamiento']['eje_ball_max']
                                                        ? '#00aa00'
                                                        : '#dd0000';
                                            @endphp
                                            <td style="background:{{ $color }}">
                                                {{ ($diff > 0 ? '(-)' : ($diff < 0 ? '(+)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                μm
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>TOL MIN:</td>
                                            @php

                                                $diff =
                                                    $rodamiento['ejeInicialMin'] -
                                                    max($rodamiento['rod']['s'], $rodamiento['rod']['t']);
                                                $color =
                                                    $diff > $rodamiento['rod']['rodamiento']['eje_ball_min'] &&
                                                    $diff < $rodamiento['rod']['rodamiento']['eje_ball_max']
                                                        ? '#00aa00'
                                                        : '#dd0000';
                                            @endphp
                                            <td style="background:{{ $color }}">

                                                {{ ($diff > 0 ? '(-)' : ($diff < 0 ? '(+)' : '')) . number_format(abs($diff * 1000), 0) }}
                                                μm
                                            </td>
                                            @php
                                                $diff =
                                                    $rodamiento['ejeFinalMin'] -
                                                    max($rodamiento['rod']['s'], $rodamiento['rod']['t']);
                                                $color =
                                                    $diff > $rodamiento['rod']['rodamiento']['eje_ball_min'] &&
                                                    $diff < $rodamiento['rod']['rodamiento']['eje_ball_max']
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
                        <p style="text-align: left;font-size:20px;font-weight:bold;margin-left:15px;margin-top:5px">
                            NOTAS
                            COMPLEMENTARIAS</p>
                        <p style="text-align: left; margin-left:20px;margin-right:20px">
                            <b>Recomendaci&oacute;n Inicial: </b> {{ $rodamiento['rodInicial']['recomendacion_eje'] }}
                            <br>
                            <b>Recomendaci&oacute;n Final: </b> {{ $rodamiento['rod']['recomendacion_eje'] }} <br>

                        </p>
                    </div>
                    <div style="position: absolute; width:100%;background:#000044;height:25px;bottom:0px"></div>
                    <div class="pdf-blue-bottom"></div>
                </div>
            </div>
        @endforeach
    @endif
    @php
        $fotos = $fotosInforme;
    @endphp

    @for ($i = 0; $i < $fotos->count(); $i += 2)
        <div class="pdf-sheet">
            <div class="pdf-frame">
                <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
                <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
                <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                    <tr>
                        <td colspan="3" style="font-weight: bold;">{{ $tituloHeader }}</td>
                        <td style="font-weight: bold;">Inicio:</td>
                        <td>{{ $fechaIngresoTexto }}</td>
                        <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}"
                                alt="Logo" style="max-height: 100px"></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;width:100px">CLIENTE:</td>
                        <td colspan="2">{{ $motor->cliente->cliente }}</td>
                        <td style="font-weight: bold;">Fin:</td>
                        <td>{{ $fechaFinTexto }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;width:100px">OS:</td>
                        <td colspan="2">{{ $motor->fullos }}</td>
                        <td style="font-weight: bold;color:#550000" colspan="2">
                            {{ $nombreEquipo }}
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
                    <img src="{{ $fotos->get($i)->pdf_path }}" alt="Foto del informe"
                        style="position: relative;max-width: 90%;max-height:400px; border-radius: 4px;margin-top:20px">
                    <table style="width:100%">
                        <tr>
                            <td width="5%"></td>
                            <td style="border:2px solid #333;padding:5px;background:#000033;color:#ddd">
                                {{ $fotos[$i]->titulo }}</td>
                            <td width="5%"></td>
                        </tr>
                    </table>
                    @if ($fotos->get($i + 1))
                        <img src="{{ $fotos->get($i + 1)->pdf_path }}" alt="Foto del informe"
                            style="position: relative;max-width: 90%;max-height:400px; border-radius: 4px;margin-top:20px">

                        <table style="width:100%">
                            <tr>
                                <td width="5%"></td>
                                <td style="border:2px solid #333;padding:5px;background:#000033;color:#ddd">
                                    {{ $fotos->get($i + 1)->titulo }}
                                </td>
                                <td width="5%"></td>
                            </tr>
                        </table>
                    @endif
                </div>
                <div class="pdf-blue-bottom"></div>
            </div>
        </div>
    @endfor



    {{-- page 5 Amperajes --}}
    @if ($hasAmperajes)
        <div class="pdf-sheet">
            <div class="pdf-frame">
                <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
                <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
                <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                    <tr>
                        <td colspan="3" style="font-weight: bold;">{{ $tituloHeader }}</td>
                        <td style="font-weight: bold;">Inicio:</td>
                        <td>{{ $fechaIngresoTexto }}</td>
                        <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}"
                                alt="Logo" style="max-height: 100px"></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;width:100px">CLIENTE:</td>
                        <td colspan="2">{{ $motor->cliente->cliente }}</td>
                        <td style="font-weight: bold;">Fin:</td>
                        <td>{{ $fechaFinTexto }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;width:100px">OS:</td>
                        <td colspan="2">{{ $motor->fullos }}</td>
                        <td style="font-weight: bold;color:#550000" colspan="2">
                            {{ $nombreEquipo }}
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

                    @php
                        $nl = $motor->noLoadTest;

                        // Datos de placa
                        $voltaje_placa = (float) ($nl->voltaje_placa ?? 0);
                        $amperaje_placa = (float) ($nl->amperaje_placa ?? 0);
                        $hz_placa = (float) ($nl->hz_placa ?? 0);
                        $conexion_placa = $nl->conexion_placa ?? '';
                        $rpm_placa = (float) ($nl->rpm_placa ?? 0);
                        $polos = $nl->polos ?? ($motor->infoMotor->polos ?? null);

                        // Datos de prueba
                        $vA = (float) ($nl->volts_prueba_A ?? 0);
                        $vB = (float) ($nl->volts_prueba_B ?? 0);
                        $vC = (float) ($nl->volts_prueba_C ?? 0);

                        $aA = (float) ($nl->amps_prueba_A ?? 0);
                        $aB = (float) ($nl->amps_prueba_B ?? 0);
                        $aC = (float) ($nl->amps_prueba_C ?? 0);

                        $rpm_prueba = (float) ($nl->rpm_prueba ?? 0);
                        $conexion_prueba = $nl->conexion_prueba ?? '';

                        // Factores CT/PT (si no existen, usamos 1)
                        $ct = (float) ($nl->ct ?? 1);
                        $pt = (float) ($nl->pt ?? 1);

                        // Promedios
                        $promV = ($vA + $vB + $vC) / 3;
                        $promA = ($aA + $aB + $aC) / 3;

                        // Desbalances (misma lógica que tu componente Livewire: (max-min)/prom * 100)
                        $desbalanceV = $promV > 0 ? ((max($vA, $vB, $vC) - min($vA, $vB, $vC)) / $promV) * 100 : null;
                        $desbalanceA = $promA > 0 ? ((max($aA, $aB, $aC) - min($aA, $aB, $aC)) / $promA) * 100 : null;

                        // % Carga por fase y promedio (A/placa *100 * ct * pt)
                        $cA = $amperaje_placa > 0 ? ($aA / $amperaje_placa) * 100 * $ct * $pt : null;
                        $cB = $amperaje_placa > 0 ? ($aB / $amperaje_placa) * 100 * $ct * $pt : null;
                        $cC = $amperaje_placa > 0 ? ($aC / $amperaje_placa) * 100 * $ct * $pt : null;
                        $cProm = $amperaje_placa > 0 ? ($promA / $amperaje_placa) * 100 * $ct * $pt : null;

                        // Velocidad (rpm) y % vs placa
                        $velocidadPct = $rpm_placa > 0 ? ($rpm_prueba / $rpm_placa) * 100 : null;

                        // Path de la gráfica

                    @endphp

                    <table style="width:100%; border-collapse:collapse; margin-top:10px;">
                        <tr>
                            <!-- DATOS DE PLACA -->
                            <td style="width:50%; vertical-align:top; padding-right:10px;">
                                <table style="width:100%; border-collapse:collapse; font-size:12px;">
                                    <tr>
                                        <th colspan="2"
                                            style="background:#4a4a4a; color:#fff; padding:8px; text-align:center; border-radius:4px;">
                                            Datos de Placa
                                        </th>
                                    </tr>

                                    <tr>
                                        <td style="padding:10px; border:1px solid #e9eef5;">Voltaje Placa</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ number_format($voltaje_placa, 0) }} VAC</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px; border:1px solid #e9eef5;">Amperaje Placa</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ number_format($amperaje_placa, 1) }} A</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px; border:1px solid #e9eef5;">Hz</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ number_format($hz_placa, 0) }}
                                            Hz</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px; border:1px solid #e9eef5;">Conexión</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ $conexion_placa ?: '—' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px; border:1px solid #e9eef5;">RPM</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ $rpm_placa > 0 ? number_format($rpm_placa, 0) : '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px; border:1px solid #e9eef5;">Polos</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">{{ $polos ?? '—' }}</td>
                                    </tr>
                                </table>
                            </td>

                            <!-- DATOS DE PRUEBA -->
                            <td style="width:50%; vertical-align:top; padding-left:10px;">
                                <table style="width:100%; border-collapse:collapse; font-size:12px;">
                                    <tr>
                                        <th colspan="4"
                                            style="background:#4a4a4a; color:#fff; padding:8px; text-align:center; border-radius:4px;">
                                            Datos de Prueba
                                        </th>
                                    </tr>
                                    <tr style="background:#f3f6fb; font-weight:bold;">
                                        <td style="padding:10px; border:1px solid #e9eef5;">Fase</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">Voltaje</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">Amperaje</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">% Carga</td>
                                    </tr>

                                    <tr>
                                        <td style="padding:10px; border:1px solid #e9eef5;">A</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ number_format($vA, 0) }}
                                            VAC
                                        </td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ number_format($aA, 1) }} A
                                        </td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ $cA !== null ? number_format($cA, 2) . ' %' : '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px; border:1px solid #e9eef5;">B</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ number_format($vB, 0) }}
                                            VAC
                                        </td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ number_format($aB, 1) }} A
                                        </td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ $cB !== null ? number_format($cB, 2) . ' %' : '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px; border:1px solid #e9eef5;">C</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ number_format($vC, 0) }}
                                            VAC
                                        </td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ number_format($aC, 1) }} A
                                        </td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ $cC !== null ? number_format($cC, 2) . ' %' : '—' }}</td>
                                    </tr>

                                    <tr style="font-weight:bold;">
                                        <td style="padding:10px; border:1px solid #e9eef5;">Promedio</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ number_format($promV, 1) }}
                                            VAC</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ number_format($promA, 1) }} A
                                        </td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ $cProm !== null ? number_format($cProm, 2) . ' %' : '—' }}</td>
                                    </tr>

                                    <tr>
                                        <td style="padding:10px; border:1px solid #e9eef5;">Desbalance</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ $desbalanceV !== null ? number_format($desbalanceV, 2) . ' %' : '—' }}
                                        </td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ $desbalanceA !== null ? number_format($desbalanceA, 2) . ' %' : '—' }}
                                        </td>
                                        <td style="padding:10px; border:1px solid #e9eef5;"></td>
                                    </tr>

                                    <tr>
                                        <td style="padding:10px; border:1px solid #e9eef5;">Velocidad</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ $rpm_prueba > 0 ? number_format($rpm_prueba, 0) : '—' }}</td>
                                        <td style="padding:10px; border:1px solid #e9eef5;"></td>
                                        <td style="padding:10px; border:1px solid #e9eef5;">
                                            {{ $velocidadPct !== null ? number_format($velocidadPct, 1) . ' %' : '—' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding:10px; border:1px solid #e9eef5;">Conexión</td>
                                        <td colspan="3" style="padding:10px; border:1px solid #e9eef5;">
                                            {{ $conexion_prueba ?: '—' }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    @if ($noLoadGraphPath)
                        <img src="{{ $noLoadGraphPath }}" style="width:70%; max-height:360px; object-fit:contain;">
                    @else
                        <div style="border:1px solid #999;padding:20px;text-align:center;color:#777;">
                            Gráfica de % carga no guardada.
                        </div>
                    @endif


                </div>
                <div class="pdf-blue-bottom"></div>
            </div>
        </div>
    @endif

    {{-- page 6 --}}
    @if ($hasTemperaturas)
        <div class="pdf-sheet">
            <div class="pdf-frame">
                <div style="position: relative; width:100%;background:#000044;height:25px;"></div>
                <div style="position: relative; width:100%;background:#550000;height:25px;"></div>
                <table class="cajilla" style="width: 100%;border-collapse: collapse;">
                    <tr>
                        <td colspan="3" style="font-weight: bold;">{{ $tituloHeader }}</td>
                        <td style="font-weight: bold;">Inicio:</td>
                        <td>{{ $fechaIngresoTexto }}</td>
                        <td rowspan="4" style="width:200px"> <img src="{{ public_path('img/logo.jpg') }}"
                                alt="Logo" style="max-height: 100px"></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;width:100px">CLIENTE:</td>
                        <td colspan="2">{{ $motor->cliente->cliente }}</td>
                        <td style="font-weight: bold;">Fin:</td>
                        <td>{{ $fechaFinTexto }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;width:100px">OS:</td>
                        <td colspan="2">{{ $motor->fullos }}</td>
                        <td style="font-weight: bold;color:#550000" colspan="2">
                            {{ $nombreEquipo }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;width:100px">Potencia:</td>
                        <td>{{ $motor->potencia }}</td>
                        <td style="font-weight: bold;">RPM:</td>
                        <td colspan="2">{{ $motor->rpm }}</td>
                    </tr>
                </table>
                @php
                    $t71 = $termografias[71] ?? null;
                    $t72 = $termografias[72] ?? null;
                    $t73 = $termografias[73] ?? null;
                @endphp

                <div style="position: relative;width:100%;text-align:center;text-transform: uppercase;">
                    {{-- ======= TEMPERATURAS: GRAFICA + TERMO ======= --}}
                    <table style="width:100%; border-collapse:collapse; margin-top:10px;">
                        <tr>
                            <td style="border:2px solid #333; padding:8px; text-align:center;">
                                <div style="font-size:18px; font-weight:bold; text-transform:uppercase;">
                                    Temperaturas
                                </div>
                            </td>
                        </tr>

                        {{-- GRAFICA TEMPERATURAS --}}
                        <tr>
                            <td style="border:1px solid #777; padding:10px; text-align:center;">
                                @if ($tmpTempChart)
                                    <img src="{{ $tmpTempChart }}"
                                        style="width:100%; max-height:420px; object-fit:contain;">
                                @else
                                    <div style="color:#666; font-size:12px;">
                                        Sin gráfica de temperaturas guardada
                                    </div>
                                @endif
                            </td>
                        </tr>

                        {{-- TERMO --}}
                        <tr>
                            <td style="border:1px solid #777; padding:8px;">
                                <div
                                    style="font-size:14px; font-weight:bold; margin-bottom:6px; text-transform:uppercase;">
                                    Termografías
                                </div>

                                <table style="width:100%; border-collapse:collapse;">
                                    <tr>
                                        {{-- 71 --}}
                                        <td
                                            style="width:33.33%; border:1px solid #777; padding:6px; text-align:center; vertical-align:middle;">
                                            @if (!empty($t71['path']))
                                                <img src="{{ $t71['path'] }}"
                                                    style="max-width:100%; max-height:260px; object-fit:contain;">
                                            @else
                                                <div style="color:#666; font-size:12px;">Sin termografía 1</div>
                                            @endif
                                        </td>

                                        {{-- 72 --}}
                                        <td
                                            style="width:33.33%; border:1px solid #777; padding:6px; text-align:center; vertical-align:middle;">
                                            @if (!empty($t72['path']))
                                                <img src="{{ $t72['path'] }}"
                                                    style="max-width:100%; max-height:260px; object-fit:contain;">
                                            @else
                                                <div style="color:#666; font-size:12px;">Sin termografía 2</div>
                                            @endif
                                        </td>

                                        {{-- 73 --}}
                                        <td
                                            style="width:33.33%; border:1px solid #777; padding:6px; text-align:center; vertical-align:middle;">
                                            @if (!empty($t73['path']))
                                                <img src="{{ $t73['path'] }}"
                                                    style="max-width:100%; max-height:260px; object-fit:contain;">
                                            @else
                                                <div style="color:#666; font-size:12px;">Sin termografía 3</div>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                @if (!empty($motor->temperaturas_comentario))
                                    <div style="margin-top:10px; border:1px solid #777; padding:8px;">
                                        <div style="font-weight:bold; text-transform:uppercase; margin-bottom:4px;">
                                            Comentario (Temperaturas)
                                        </div>
                                        <div style="font-size:12px; white-space:pre-line;">
                                            {{ $motor->temperaturas_comentario }}
                                        </div>
                                    </div>
                                @endif

                            </td>
                        </tr>
                    </table>

                </div>
                <div class="pdf-blue-bottom"></div>
            </div>
        </div>
    @endif





</body>

</html>
