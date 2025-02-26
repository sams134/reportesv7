<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Produccion de {{$user->name}}</title>
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
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        width: 100%;
        color: #000044;
    }
    .header-text p {
        margin: 0;
    }
    .table {
        position: relative;
       
        width: 100%;
        font-size: 14px;
        border-collapse: collapse;
    }
    .table th{
       
        padding: 5px;
    }
    .table td{
        padding: 5px;
        border-bottom:1px solid #888;
    }
    .tables-container {
        position: relative;
        top: 320px;
        width: 100%;
    }
   
    </style>
<body>
    <img src="{{ public_path('img/logo.jpg') }}" alt="Logo" class="header-img">
    <div class="header-text">
        <p>CLINICA DE MOTORES ELECTRICOS</p>
        <p>Hoja de Producci&oacute;n</p>
    </div>
    <table style="width:90%;position: absolute;top: 190px;font-size: 20px;font-weight:bold">
        <tr>
            <td style="">Producci&oacute;n del</td>
            <td style="font-size:24px;color:#440000;border-bottom:1px solid #444;">{{ucfirst(\Carbon\Carbon::parse($init)->locale('es')->isoFormat('dddd D [de] MMMM')) }}</td>
            <td style="width:50px;text-align:center">al</td>
            <td style="font-size:24px;color:#440000;border-bottom:1px solid #444;">{{ucfirst(\Carbon\Carbon::parse($final)->locale('es')->isoFormat('dddd D [de] MMMM')) }}</td>
        </tr>
    </table>
    <table style="width:90%;position: absolute;top: 240px;font-size: 20px;font-weight:bold">
        <tr>
            <td style="width:230px">Nombre del Tecnico:</td>
            <td style="font-size:30px;color:#440000;border-bottom:1px solid #444;text-align:center">{{$user->name}}</td>
        </tr>
    </table>
    
    <div class="tables-container">
        <table style=" top: 0px;" class="table">
            <tr>
                <td colspan="7" style="background: #007bff;color:#fff;padding: 5px;border:2px solid #007bff;text-align:center;font-size:18px;font-weight:bold">Equipos Finalizados</td>
            </tr>
        </table>
        <table  style=" top: 0px;" class="table">
            
            <thead style="background: #007bff;color:#fff;padding: 5px;border:2px solid #007bff;border-bottom:3px solid #333">
                <th>OS</th>
                <th>Cliente</th>
                <th>Equipo</th>
                <th>Compartido Con:</th>
                <th>Trabajo Realizado</th>
                <th>Fecha Finalizado</th>
                <th>Bonificacion</th>
            </thead>
            <tbody>
                @foreach ($produccion as $index => $motor)
                                <tr @if($index % 2 == 0) style="background-color: #f2f2f2;" @endif>
                                    <td >{{$motor->fullOS}}</td>
                                    <td style="font-weight: bold">{{$motor->cliente->cliente}}</td>
                                    <td style="font-size:12px;">
                                        @if ($motor->tipoequipo)
                                        <span>{{ $motor->tipoequipo->name }}</span>
                                         @else
                                         <span >{{ $motor->id_tipoequipo }}</span>
                                         @endif
                                        <br> <span >{{$motor->potencia}}</span> 
                                    </td>
                                    <td style="text-align: center;font-size:12px;"> 
    
                                        @if ($motor->asignados->count() > 1)
                                        <ul style="list-style-type:disc;padding:0;margin:15px">
                                            @foreach ($motor->asignados as $asignado)
                                              
                                           <li> {{$asignado->name}} <span class="badge bg-danger">{{ $asignado->pivot->responsabilidad }}%</span></li>
                                               
                                            @endforeach
                                        </ul>
                                        @else   
                                            <span >Nadie</span>
                                        @endif
                                    </td>
                                    <td>{{$motor->tipoTrabajo?$motor->tipoTrabajo->name:""}}</td>
                                    <td>{{ucfirst(\Carbon\Carbon::parse($motor->end)->locale('es')->isoFormat(' D [de] MMMM')) }}</td>
                                    <td style="font-size: 18px">Q.</td>
                                </tr>
                            @endforeach
            </tbody>
        </table>
        <table style="top:40px" class="table">
            <tr>
                <td colspan="7" style="background: #28a745;color:#fff;padding: 5px;border:2px solid #28a745;text-align:center;font-size:18px;font-weight:bold">Horas Extra</td>
            </tr>
        </table>
        <table  style="top:40px" class="table">
            
            <thead style="background: #28a745;color:#fff;padding: 5px;border:2px solid #28a745;border-bottom:3px solid #333">
                <th>OS</th>
                <th>Fecha</th>
                <th>Horas</th>
                <th>Cliente</th>
                <th style="text-align: left;width:200px">Trabajo Realizado</th>
                <th style="text-align: left;width:100px">Autorizado Por:</th>
            </thead>
            <tbody>
                @foreach ($horas_extras as $index => $hora)
                <tr @if($index % 2 == 0) style="background-color: #f2f2f2;" @endif>
                    <td> <span class="fw-bold">{{$hora->motor->fullOS}}</span>
                        <br><span style="font-size: 12px">{{$hora->motor->potencia}}</span> 
                    </td>
                   <td>{{ucfirst(\Carbon\Carbon::parse($hora->init)->locale('es')->isoFormat('D [de] MMMM')) }}</td>
                   <td>{{ number_format($hora->hours, 2) }} horas</td>
                  
                   <td style="text-align: center">{{$hora->motor->cliente->cliente}}</td>
                   <td>{{$hora->descripcion}}</td>
                   <td> @if($hora->autorizado_por == $hora->user->id)
                       <span>Sistema</span>
                   @else
                       <span >{{ $hora->autorizadoPor->name }}</span>
                   @endif</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" style="text-align: right;border-top:2px solid #333">
                    <span style="font-weight: bold">Total Horas: {{ number_format($horas_extras->sum('hours'), 2) }} horas, se acreditan: {{ ceil($horas_extras->sum('hours')) }} horas</span>
                </td>
             </tr>
            </tbody>
        </table>
        <table style="top:60px" class="table">
            <tr>
            <td colspan="7" style="background: #ffc107;color:#fff;padding: 5px;border:2px solid #ffc107;text-align:center;font-size:18px;font-weight:bold">Trabajos sin OS</td>
            </tr>
        </table>
        <table  style="top:60px" class="table">
            
            <thead style="background: #ffc107;color:#fff;padding: 5px;border:2px solid #ffc107;border-bottom:3px solid #333">
            
                <th style="width:170px;text-align: left">Fecha</th>
                <th style="text-align: left">Trabajo realizado</th>
                <th style="width:60px">Bonificaci&oacute;n</th>                
            </thead>
            <tbody>
            @foreach ($other_works as $work)
            <tr @if($index % 2 == 0) style="background-color: #f2f2f2;" @endif>
                    <td>{{ucfirst(\Carbon\Carbon::parse($work->fecha)->locale('es')->isoFormat('dddd D [de] MMMM')) }}</td>
                    <td style="text-transform: capitalize">{{$work->descripcion}}</td>
                    <td>Q. </td>
                </tr>
            @endforeach    
            
            </tbody>
        </table>
    </div>
  
</body>
</html>