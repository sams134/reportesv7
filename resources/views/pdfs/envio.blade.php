<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    .header-img {
        position: absolute;
        top: 10px;
        left: 350px;
        width: 200px;
    }

    .motor-img {
        position: absolute;
        top: 10px;
        left: 0px;
        width: 150px;
    }

    .envio-title {
        position: absolute;
        top: 180px;
        left: 0px;
        width: 100%;
        font-size: 30px;
        font-weight: bold;

        color: #000044;
    }

    .easa-img {
        position: absolute;
        top: 10px;
        right: 0px;
        width: 150px;
    }

    .weg-img {
        position: absolute;
        top: 80px;
        right: 0px;
        width: 120px;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #fff;
        color: #333;
    }

    .header-text {
        position: absolute;
        top: 110px;

        width: 100%;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        width: 100%;
        color: #000044;
    }

    .sub-header {
        position: absolute;
        top: 320px;
        width: 100%;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        width: 100%;
        color: #000044;
        font-style: italic;
    }

    .header-text p {
        margin: 0;
    }

    .table-striped {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border: 1px solid #ddd;



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

    .table-parts {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        border-collapse: collapse;
    }

    .table-parts th,
    .table-parts td {
        padding: 0.5rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        text-align: center;
    }

    .table-parts thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .table-parts tbody+tbody {
        border-top: 2px solid #dee2e6;
    }

    .table-parts .table-sm th,
    .table-parts .table-sm td {
        padding: 0.2rem;
    }

    .table-parts .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-parts .table-bordered th,
    .table-parts .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table-parts .table-bordered thead th,
    .table-parts .table-bordered thead td {
        border-bottom-width: 2px;
    }

    .table-parts .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .table-parts .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.075);
    }
</style>

<body>
    <img src="{{ public_path('img/logo.jpg') }}" alt="Logo" class="header-img">
    <div class="header-text">
        <p>23 Ave. 28-46 Zona 5. 01005 Guatemala C.A.</p>
        <p>Telefonos: (502) 2331-1596 | (502) 2331-1263 | (502) 2331-1254</p>
        <p>info@cmeamir.com</p>
        <p>www.cmeamir.com</p>
    </div>
    <img src="{{ public_path('img/images.jpeg') }}" alt="Logo" class="motor-img">
    <img src="{{ public_path('img/easa.jpg') }}" alt="Logo" class="easa-img">
    <img src="{{ public_path('img/weg.png') }}" alt="Logo" class="weg-img">
</body>
<span class="envio-title">ENVIO: <span style="color:#770000">{{ $motor->fullos }}</span></span>
<table style="width: 45%;text-transform: uppercase;position: absolute;top: 230px;">
    <tr>
        <td style="width:130px;font-size:18px;font-weight:bold">FACTURA No</td>
        <td style="border-bottom:1px solid #000033;">&nbsp;</td>
    </tr>
</table>
<table style="width: 55%;text-transform: uppercase;position: absolute;top: 220px;right:0px;">
    <tr>
        <td style="width:200px;font-size:13px;font-weight:bold;text-align:right;">Clinica de Motores Electricos</td>
        <td style="border:1px solid #000033;">&nbsp;</td>
        <td style="width:200px;font-size:13px;font-weight:bold;text-align:right;">Clinica de Motores Electricos AMIR
        </td>
        <td style="border:1px solid #000033;">&nbsp;</td>
    </tr>
</table>
<table style="width: 90%;text-transform: uppercase;position: absolute;top: 280px;">
    <tr>
        <td style="width:130px;font-size:18px;font-weight:bold">SE&Ntilde;ORES:</td>
        <td style="border-bottom:1px solid #000033;font-size:20px;text-align:center">{{ $motor->cliente->cliente }} /
            Att: {{ $motor->infoMotor->contacto }}</td>
    </tr>
</table>
<span class="sub-header">POR ESTE MEDIO ESTAMOS ENTREGANDOLE EL SIGUIENTE EQUIPO REPARADO BAJO LOS ESTANDARES EASA
    AR-100</span>
<table style="width: 100%;text-transform: uppercase;position: absolute;top: 380px;">
    <tr>
        <td>
            <div
                style="border: 1px solid #ddd; border-radius: 4px; max-width: 250px;  padding: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <div style="padding: 5px;">
                    <img src="{{ public_path('storage' . $motor->fotos->first()->foto) }}" alt="Imagen de Entrada"
                        style="max-width: 100%; border-radius: 4px;max-height: 240px;">
                    <div style="width: 100%;color:#000033;text-align:center">Imagen Entrada</div>
                </div>
            </div>
            <div
                style="border: 1px solid #ddd; border-radius: 4px; max-width: 240px;  padding: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <div style="padding: 5px;">
                    <img src="{{ public_path('storage' . $foto->foto) }}" alt="Imagen de Entrada"
                        style="max-width: 100%; border-radius: 4px;">
                    <div style="width: 100%;color:#000033;text-align:center">Imagen SALIDA</div>
                </div>
            </div>
        </td>
        <td>
            <table class="table-striped" style="margin-right:20px;">
                <tr>
                    <td colspan="4" style="text-align: center;background:#000033;color:#ddd;font-size:24px;">DATOS
                        DEL EQUIPO</td>

                </tr>
                <tr>
                    <td width="20%">Nombre del Equipo</td>
                    <td colspan="3">{{ $motor->infoMotor->nombre_equipo ? $motor->infoMotor->nombre_equipo : '' }}
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
            </table>
        </td>
    </tr>
</table>
<table style="width: 100%;text-transform: uppercase;position: absolute;top: 740px;">
    <tr>
        <td width="33%" style="padding: 10px;">
            <table class="table-striped" style="margin-right:20p;">
                <tr>
                    <td colspan="4"
                        style="text-align: center;background:#fff;color:#000044;font-size:24px;border:1px solid #fff">
                        Fechas Importantes</td>

                </tr>
                <tr>
                    <td width="20%" style="font-size:12px">Fecha Ingreso</td>
                    <td colspan="3" style="font-size:12px">
                        {{ \Carbon\Carbon::parse($motor->fecha_ingreso)->locale('es')->isoFormat('dddd D [de] MMMM [del] YYYY') }}
                    </td>
                </tr>

                <tr>
                    <td width="20%" style="font-size:12px">Fecha Finalizaci&oacute;n</td>
                    <td colspan="3" style="font-size:12px">
                        {{ \Carbon\Carbon::parse($motor->fecha_ingreso)->locale('es')->isoFormat('dddd D [de] MMMM [del] YYYY') }}
                    </td>
                </tr>
                <tr>
                    <td width="20%" style="font-size:12px">Fecha Entrega</td>
                    <td colspan="3" style="font-size:12px">
                        {{ \Carbon\Carbon::parse($motor->fecha_ingreso)->locale('es')->isoFormat('dddd D [de] MMMM [del] YYYY') }}
                    </td>
                </tr>
            </table>
        </td>
        <td width="66%" style="vertical-align: top; padding-top: 40px;">
            <table class="table-parts" style="margin-left:20px;">
                <tr>
                    <td colspan="4"
                        style="text-align: center;background:#fff;color:#000044;font-size:24px;border:1px solid #fff; vertical-align: top; padding-top: 0;font-weight:bold">
                        Adicionales Devueltos</td>

                </tr>
                <th width="15%">Item #</th>
                <th>Parte</th>
                @foreach ($motor->envioFinal->enviosAdicionales as $key=>$item)
                    <tr>
                        <td style="font-size:16px">{{$key+1}}</td>
                        <td colspan="3" style="font-size:16px">{{$item->parte}}</td>
                    </tr>
                @endforeach



            </table>
        </td>
    </tr>
</table>
<table class="table-striped" style="position:absolute;top:990px">
    <tr>
        <td colspan="4" style="text-align: center;background:#000033;color:#ddd;font-size:20px;padding:5px">DATOS DEL
            PILOTO</td>
    </tr>
    <tr>
        <td width="20%">Nombre del Piloto:</td>
        <td>{{ $motor->envioFinal->nombre_piloto }}</td>
        <td width="20%">Licencia/Dpi:</td>
        <td>{{ $motor->envioFinal->dpi_piloto }}</td>
    </tr>
    <tr>
        <td>Vehiculo:</td>
        <td>{{ $motor->envioFinal->tipo_vehiculo }}</td>
        <td>Placa:</td>
        <td>{{ $motor->envioFinal->placa_vehiculo }}</td>
    </tr>
</table>
<table class="table-striped" style="position:absolute;top:1100px">
    <tr>
        <td style="text-align: center;background:#000033;color:#ddd;font-size:20px;padding:5px">COMENTARIOS</td>
    </tr>
    <tr>
        <td style="height:40px;background:#fff">{{ $motor->envioFinal->comentarios }}</td>

    </tr>
</table>
<div style="width:100%;text-align:center;position:absolute;top:1220px">
    <p style="font-size:24px;font-weight:bold">Guatemala,
        {{ \Carbon\Carbon::parse($motor->fin)->locale('es')->isoFormat('dddd D [de] MMMM [del] YYYY') }}</p>
</div>
<table style="width:100%;position:absolute;top:1320px">
    <td style="border-top:2px solid #000033;text-align:center;width:33%;font-size:16px;color:#000033">
        Firma: CLIENTE
    </td>
    <td style="text-align:left;width:33%"></td>
    <td style="border-top:2px solid #000033;text-align:center;width:33%">
        Firma: CLINICA DE MOTORES ELECTRICOS
    </td>
</table>

</html>
