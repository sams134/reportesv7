<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Materiales para OS {{$motor->fullOs}}</title>
</head>
<style>
     body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #333;
        }
        .header-title {
            position: absolute;
            top: 30px;
        }
        .header-subtitle {
            position: absolute;
            top: 60px;
            color: #0C5DD1;
        }
        .header-img {
            position: absolute;
            top: 40px;
            left: 700px;
            width: 200px;
        }
        .titulo {
            color: #105cb5;
            font-size: 28px;

            font-weight: bold;
            left: 10px;
        }

        .table-striped {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #ddd;
            position: absolute;

            left: 10px;
        }

        .table-striped th,
        .table-striped td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table-striped th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .table-striped tr:nth-child(odd) {
            /*    background-color: #f2f2f2; */
            /* Fondo alterno para las filas impares */
        }
        .table-striped td:nth-child(odd),
        .table-striped th:nth-child(odd) {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
          
            position: absolute;
            left: 10px;
        }
        .table-data th{
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: #ccc;
        }
        .table-data td {
            padding: 8px 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table-data tr:nth-child(odd) {
              background-color: #f2f2f2; */
        
        }
    </style>
<body>
    <div >
        <h1 class="header-title">SOLICITUD DE MATERIALES</h1>
        <h1 class="header-subtitle">OS: {{$motor->fullOs}}</h1>
        <img src="{{ public_path('img/logo.jpg') }}" alt="Logo" class="header-img">
    </div>
    <table style="width: 100%;text-transform: uppercase;position: absolute;top: 150px;">
        <tr>
            <td width="10%" style="font-weight: bold">Tecnico:</td>
            <td style="border-bottom: 1px solid #222"></td>
            <td style="width: 10%;font-weight: bold;padding-left:20px">Cliente:</td>
            <td style="width:39%;border-bottom: 1px solid #222"></td>
        </tr>
    </table>
    <span style="position: absolute;top:150px;left:200px;width:200px;font-size:20px"> {{$tecnico}}</span>
    <span style="position: absolute;top:150px;left:580px;width:300px;font-size:20px;text-transform:uppercase "> {{$motor->cliente->cliente}}</span>
    
    

    <table class="table-striped" style="top: 180px;">
        <tr>
            <td>Nombre del Equipo</td>
            <td colspan="5">{{ $motor->infoMotor->nombre_equipo?$motor->infoMotor->nombre_equipo:"" }}</td>
        </tr>
        <tr>
            <td>Marca</td>
            <td>{{ $motor->marca }}</td>
            <td>Serie</td>
            <td>{{ $motor->serie }}</td>
            <td>Modelo</td>
            <td>{{ $motor->modelo }}</td>
        </tr>
        <tr>
            <td>Potencia</td>
            <td>{{ $motor->potencia }}</td>
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
            <td>Eficiencia</td>
            <td>{{ $motor->eff }}</td>
        </tr>
        <tr>
            <td>HZ</td>
            <td>{{ $motor->hz }}</td>
            <td>Frame</td>
            <td>{{ $motor->frame }}</td>
            <td>Fases</td>
            <td>{{ $motor->phases }}</td>
        </tr>
        <tr>
            <td colspan="2">Comentarios de Cliente</td>
            <td colspan="4">{{ $motor->comentarios }}</td>
        </tr>
    </table>
    <span style="position: absolute;top:420px;left:0px;width:200px;font-size:24px;text-transform:uppercase;font-weight:bold "> Materiales:</span>
    <table class="table-data" style="top: 440px;">
        <thead>
            <tr>
                <th>#</th>
                <th>Cantidad</th>
                <th>Material</th>
                <th>Presentacion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($motor->materialesPedidos as $key=>$material)
                <tr>
                    <td style="font-size:12px;color:#555">{{ $key+1 }}</td>
                    <td>{{ $material->cantidad }}</td>
                    <td style="text-transform: capitalize">{{ $material->material }}</td>
                    <td style="text-transform: capitalize">{{ $material->presentacion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table style="width: 100%;text-transform: uppercase;position: absolute;top: 1320px;">
        <tr style="border: 1px solid #222">
            <td width="20%" style="font-weight: bold;padding:0px">Autorizado Por:</td>
            <td style="border-bottom: 1px solid #222"></td>
            <td style="width: 10%;font-weight: bold;padding-left:20px">Fecha:</td>
            <td style="width:30%;border-bottom: 1px solid #222"></td>
        </tr>
    </table>
    
    <span style="position: absolute;top:1320px;left:700px;width:150px;font-size:20px;text-transform:uppercase "> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>
</body>
</html>