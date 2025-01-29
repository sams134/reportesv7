<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
@php
$tamañoCirculo = 400; // Tamaño del círculo principal
$spacing = 100; // Espacio entre cada círculo concéntrico
$top = 500; // Margen superior
$left = 50; // Margen izquierdo
@endphp
<style>
    html,
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .cuadro {
        position: absolute;
        border: 3px solid black;
    }
    .polar-diagram {
            position: relative;
            width: {{ $tamañoCirculo }}px;
            height: {{ $tamañoCirculo }}px;
            border-radius: 50%;
            background-color: white;
            border: 1px solid #333;
        }

        /* Círculos concéntricos */
        .circle {
            position: absolute;
            border-radius: 50%;
            border: 1px dashed #333;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        /* Líneas cada 90 grados */
        .line {
            position: absolute;
            width: 100%;
            height: 1px;
            background-color: #333;
            top: 50%;
            left: 50%;
            transform-origin: center;
        }

        /* Generación de líneas cada 90 grados */
        .line1 {
            transform: rotate(0deg);
        }
        .line2 {
            transform: rotate(90deg);
        }
        .line3 {
            transform: rotate(180deg);
        }
        .line4 {
            transform: rotate(270deg);
        }
    
</style>

<body>
    <div class="cuadro" style="top: 0px; left: 50%; width: 480px; height: 80px; margin-left: -240px;text-align:center">
        <span style="font-size: 24px;position:relative;top:15px;font-weight:bold ">BALANCE CERTIFICATE</span>
        <p>
            <span style="font-size: 14px;position:relative;top:5px;font-weight:bold ">
                {{ rand(1000, 9999) }}{{ $motor->year }}{{ $motor->os }}{{ $motor->fecha_ingreso ? \Carbon\Carbon::parse($motor->fecha_ingreso)->format('dmyY') : '' }}
            </span>
        </p>
    </div>
    <div class="cuadro"
        style="top: 90px; left: 50%; width: 440px; height: 100px; margin-left: -220px;text-align:center;background-color: #bbb">
        <P style="font-size: 20px;position:relative;top:-10px;font-weight:bold ">CLINICA DE MOTORES ELECTRICOS</P>
        <P style="font-size: 14px;position:relative;top:-30px;font-weight:bold ">23 AVE 28-46 ZONA 5</P>
        <P style="font-size: 14px;position:relative;top:-40px;font-weight:bold ">GUATEMALA C.A.</P>
        <P style="font-size: 14px;position:relative;top:-50px;font-weight:bold ">(502)2331-1596</P>
        </p>
    </div>
    <div class="cuadro" style="top:205px;width:900px;height:150px;">
   
    </div>
    @php
    $top1 = 210;
    $spacing1 = 22;
    @endphp
    <div style="width: 900px">
        <p style="font-size: 16px;position:absolute;top:{{ $top1 }}px;left:15px;font-weight:bold ">Rotor:</p>
        <p style="font-size: 16px;position:absolute;top:{{ $top1 + $spacing1 }}px;left:15px;font-weight:bold ">Customer:</p>
        <p style="font-size: 16px;position:absolute;top:{{ $top1 + $spacing1 * 2 }}px;left:15px;font-weight:bold ">P.O. Order:</p>
        <p style="font-size: 16px;position:absolute;top:{{ $top1 + $spacing1 * 3 }}px;left:15px;font-weight:bold ">Date:</p>
        <p style="font-size: 16px;position:absolute;top:{{ $top1 + $spacing1 * 4 }}px;left:15px;font-weight:bold ">Comments:</p>

        <p style="font-size: 16px;position:absolute;top:{{ $top1 }}px;left:110px;font-weight:200 ">{{$motor->fulLOs}}</p>
        <p style="font-size: 16px;position:absolute;top:{{ $top1 + $spacing1 }}px;left:110px;font-weight:200 ">{{$motor->cliente->cliente}} </p>
        <p style="font-size: 16px;position:absolute;top:{{ $top1 + $spacing1 * 2 }}px;left:110px;font-weight:200 ">{{rand(100000,999999)}}</p>
        <p style="font-size: 16px;position:absolute;top:{{ $top1 + $spacing1 * 3 }}px;left:110px;font-weight:200 "> {{ $motor->fecha_ingreso ? \Carbon\Carbon::parse($motor->fecha_ingreso)->format('m/d/Y H:i') : '' }}</p>
        <p style="font-size: 16px;position:absolute;top:{{ $top1 + $spacing1 * 4 }}px;left:110px;font-weight:200 ">Comments:</p>
    </div>
    <div class="cuadro" style="top:370px;width:900px;height:240px;"></div>
    <div style="width: 900px">
        <p style="font-size: 16px;position:absolute;top:380px;left:15px;font-weight:bold ">Left Radius:</p>
        <p style="font-size: 16px;position:absolute;top:380px;left:670px;font-weight:bold ">Right Radius:</p>
        <img src="{{ public_path('img/rotor.png') }}" alt="Imagen Predeterminada" style="width: 430px; height: 200px;position:absolute;top:390px;left:220px;">
        <p style="font-size: 16px;position:absolute;top:530px;left:15px;font-weight:bold ">Dimension A:</p>
        <p style="font-size: 16px;position:absolute;top:560px;left:15px;font-weight:bold ">Dimension B:</p>

        <p style="font-size: 16px;position:absolute;top:380px;left:125px;font-weight:200;width:100px "> 6.000 in</p>
        <p style="font-size: 16px;position:absolute;top:380px;left:780px;font-weight:200;width:100px ">15.899 in</p>
        
        <p style="font-size: 16px;position:absolute;top:530px;left:125px;font-weight:200;width:100px  ">Dimension A:</p>
        <p style="font-size: 16px;position:absolute;top:560px;left:125px;font-weight:200;width:100px  ">Dimension B:</p>



    </div>

    <div style="page-break-before: always;"></div>
    <div class="cuadro" style="top:620px;width:900px;height:450px;"></div>
    <div class="cuadro" style="top:1080px;width:900px;height:130px;"></div>
    <div class="cuadro" style="top:1220px;width:900px;height:130px;"></div>

    <div style="page-break-after: always;"></div>


    {{-- segunda pagina --}}
    @php
    $pagina1 = 1350;
    @endphp

<span style="font-size: 26px;position:absolute;top:{{$pagina1+30}}px;left:335px;font-weight:bold ">BALANCE QUALITY</span>
<div class="cuadro"
        style="top: {{$pagina1+80}}px; left: 50%; width: 440px; height: 100px; margin-left: -220px;text-align:center;background-color: #bbb">
        <P style="font-size: 20px;position:relative;top:-10px;font-weight:bold ">CLINICA DE MOTORES ELECTRICOS</P>
        <P style="font-size: 14px;position:relative;top:-30px;font-weight:bold ">23 AVE 28-46 ZONA 5</P>
        <P style="font-size: 14px;position:relative;top:-40px;font-weight:bold ">GUATEMALA C.A.</P>
        <P style="font-size: 14px;position:relative;top:-50px;font-weight:bold ">(502)2331-1596</P>
        </p>
    </div>

 <table style="width: 100%;position:absolute;top:1570px;">
        <tr>
            <td>
                <img src="{{ $imagenBase64 }}" alt="Diagrama Polar" style="width: 450px; height: 450px;border: 1px solid #333;">
            </td>
            <td>
                <img src="{{ $imagenBase64 }}" alt="Diagrama Polar" style="width: 450px; height: 450px;border: 1px solid #333;">
            </td>
        </tr>
    </table> 
    
</body>

</html>
