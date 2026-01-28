<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Densidades</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 18px;
        }

        .header2 {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo {
            width: 180px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
        }

        .meta {
            margin-top: 10px;
            font-size: 12px;
        }

        .grid {
            margin-top: 18px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .box {
            border: 1px solid #777;
            padding: 8px;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .box2 {
            border: 1px solid #777;
            padding: 8px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .box2 img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .footer {
            margin-top: 18px;
            font-size: 11px;
            color: #444;
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

        .table-striped tr:hover {
            background-color: #e9ecef;
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
</head>

<body>
    @php
        $page1 = 0;

    @endphp
    <div style="position: absolute;top:{{ $page1 + 0 }}px;width:95%;height:1280px;border:3px solid #333">
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
                <td style="font-weight: bold;color:#550000" colspan="2">
                    {{ $motor->infoMotor->nombre_equipo ? $motor->infoMotor->nombre_equipo : ($motor->tipoequipo->name? $motor->tipoequipo->name : 'N/A') }}
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
            <h1>Densidades</h1>
            <div class="meta" style="text-align: left;left:20px;">
                <div><b>OS:</b> {{ $motor->fulLOs }}</div>
                <div><b>Cliente:</b> {{ $motor->cliente->cliente ?? '' }}</div>
                <div><b>Técnico:</b> {{ $tecnico }}</div>
                <div><b>Fecha:</b> {{ now()->format('d/m/Y H:i') }}</div>
            </div>
            <div class="grid" style="left:20px;text-align:left">
                <div class="box">
                    @if (isset($images[0]))
                        <img src="{{  $images[0] }}" alt="Densidad 1" style="max-width:900px">
                      
                    @else
                        <span>Sin imagen 1</span>
                    @endif
                </div>
                <div class="box2">
                    @if (isset($images[1]))
                        <img src="{{ $images[1] }}" alt="Densidad 2">
                    @else
                        <span>Sin imagen 2</span>
                    @endif
                </div>
            </div>

        </div>
    </div>


    {{-- <div class="header2">
        <img class="logo" src="file://{{ public_path('img/logobw.png') }}" alt="Logo">
        <div>
            <div class="title">DENSIDADES</div>
            <div class="meta">
                <div><b>OS:</b> {{ $motor->fulLOs }}</div>
                <div><b>Cliente:</b> {{ $motor->cliente->cliente ?? '' }}</div>
                <div><b>Técnico:</b> {{ $tecnico }}</div>
                <div><b>Fecha:</b> {{ now()->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    <div class="grid">
        <div class="box">
            @if (isset($images[0]))
                <img src="file://{{ $images[0] }}" alt="Densidad 1">
            @else
                <span>Sin imagen 1</span>
            @endif
        </div>
        <div class="box">
            @if (isset($images[1]))
                <img src="file://{{ $images[1] }}" alt="Densidad 2">
            @else
                <span>Sin imagen 2</span>
            @endif
        </div>
    </div>

    <div class="footer">
        Generado desde Sistema Interno Clinica de Motores Electricos &copy;2025.
    </div> --}}
</body>

</html>
