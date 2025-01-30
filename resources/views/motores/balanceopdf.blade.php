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
        <p style="font-size: 16px;position:absolute;top:{{ $top1 + $spacing1 }}px;left:110px;font-weight:200;width:400px;">{{$motor->cliente->cliente}} </p>
        <p style="font-size: 16px;position:absolute;top:{{ $top1 + $spacing1 * 2 }}px;left:110px;font-weight:200 ">{{rand(100000,999999)}}</p>
        <p style="font-size: 16px;position:absolute;top:{{ $top1 + $spacing1 * 3 }}px;left:110px;font-weight:200 "> {{ $motor->fecha_ingreso ? \Carbon\Carbon::parse($motor->fecha_ingreso)->format('m/d/Y H:i') : '' }}</p>
        <p style="font-size: 16px;position:absolute;top:{{ $top1 + $spacing1 * 4 }}px;left:110px;font-weight:200;;width:400px ">Comments:</p>
    </div>

    @php
    $top2 = 0;
    @endphp
    <div class="cuadro" style="top:{{  370 }}px;width:900px;height:260px;"></div>
    <div style="width: 900px">
        <p style="font-size: 16px;position:absolute;top:{{ $top2 + 380 }}px;left:15px;font-weight:bold ">Left Radius:</p>
        <p style="font-size: 16px;position:absolute;top:{{ $top2 + 380 }}px;left:670px;font-weight:bold ">Right Radius:</p>
        <img src="{{ public_path('img/rotor.png') }}" alt="Imagen Predeterminada" style="width: 430px; height: 200px;position:absolute;top:{{ $top2 + 390 }}px;left:220px;">
        <p style="font-size: 17px;position:absolute;top:{{ $top2 + 540 }}px;left:15px;font-weight:bold ">Dimension A:</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top2 + 570 }}px;left:15px;font-weight:bold ">Dimension B:</p>

        <p style="font-size: 17px;position:absolute;top:{{ $top2 + 380 }}px;left:130px;font-weight:200;width:170px "> 6.000 in</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top2 + 380 }}px;left:780px;font-weight:200;width:140px ">15.899 in</p>
        
        <p style="font-size: 17px;position:absolute;top:{{ $top2 + 540 }}px;left:130px;font-weight:200;width:170px  ">Dimension A:</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top2 + 570 }}px;left:130px;font-weight:200;width:170px  ">Dimension B:</p>
    </div>

    @php
    $top3 = 20;
    @endphp
    
    <div class="cuadro" style="top:{{ $top3 + 620 }}px;width:900px;height:450px;"></div> {{-- cuadro de parte 5 --}}
    

    <div>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 630 }}px;left:75px;font-weight:bold;width:200px">Balancing Speed:</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 630 }}px;left:620px;font-weight:bold;width:200px">Service Speed:</p>

        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 630 }}px;left:225px;font-weight:200;width:100px">599.0  Rpm</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 630 }}px;left:750px;font-weight:200;width:100px">3600 Rpm</p>

        <p style="font-size: 18px;position:absolute;top:{{ $top3 + 670 }}px;left:300px;font-weight:bold;width:200px">Left:</p>
        <p style="font-size: 18px;position:absolute;top:{{ $top3 + 670 }}px;left:570px;font-weight:bold;width:200px">Right:</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 740 }}px;left:90px;font-weight:bold;width:200px">Initial:</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 830 }}px;left:90px;font-weight:bold;width:200px">Final:</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 935 }}px;left:90px;font-weight:bold;width:200px">Tolerance:</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 935 }}px;left:270px;font-weight:200;width:200px">61.67 g-in</p> {{-- las tolerancias --}}
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 935 }}px;left:560px;font-weight:200;width:200px">61.67 g-in</p>  {{-- las tolerancias --}}

        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 995 }}px;left:90px;font-weight:bold;width:200px">ISO 1940 Grade:</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 995 }}px;left:591px;font-weight:bold;width:200px">Rotor Mass:</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1020 }}px;left:90px;font-weight:bold;width:200px">Key Compensation:</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1020 }}px;left:490px;font-weight:bold;width:250px">Tooling Compensation:</p>
    </div>
    <div class="cuadro" style="top:{{ $top3 + 720 }}px;left:205px;width:260px;height:80px;"></div> {{-- Initial left --}}
    <div class="cuadro" style="top:{{ $top3 + 720 }}px;left:475px;width:260px;height:80px;"></div> {{-- Initial right --}}
    <div class="cuadro" style="top:{{ $top3 + 810 }}px;left:205px;width:260px;height:80px;"></div> {{-- Final left --}}
    <div class="cuadro" style="top:{{ $top3 + 810 }}px;left:475px;width:260px;height:80px;"></div> {{-- Final right --}}

    <div class="cuadro" style="top:{{ $top3 + 670 }}px;left:75px;width:750px;height:240px;"></div> {{-- Cuadro de inicial y final --}}
    <div class="cuadro" style="top:{{ $top3 + 925 }}px;left:75px;width:750px;height:70px;"></div>

    <div>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 720 }}px;left:245px;font-weight:200;width:200px"> 7.860 mil @ 345°</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 740 }}px;left:245px;font-weight:200;width:200px"> 545.592 g-in</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 760 }}px;left:245px;font-weight:200;width:200px"> 19.245 oz-in</p>

        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 720 }}px;left:525px;font-weight:200;width:200px"> 7.860 mil @ 345°</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 740 }}px;left:525px;font-weight:200;width:200px"> 545.592 g-in</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 760 }}px;left:525px;font-weight:200;width:200px"> 19.245 oz-in</p>

        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 810 }}px;left:245px;font-weight:200;width:200px"> 7.860 mil @ 345°</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 830 }}px;left:245px;font-weight:200;width:200px"> 545.592 g-in</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 850 }}px;left:245px;font-weight:200;width:200px"> 19.245 oz-in</p>

        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 810 }}px;left:525px;font-weight:200;width:200px"> 7.860 mil @ 345°</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 830 }}px;left:525px;font-weight:200;width:200px"> 545.592 g-in</p>
        <p style="font-size: 17px;position:absolute;top:{{ $top3 + 850 }}px;left:525px;font-weight:200;width:200px"> 19.245 oz-in</p>

        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 995 }}px;left:260px;font-weight:200;width:200px"> 1.0</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1020 }}px;left:280px;font-weight:200;width:200px"> Off</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 995 }}px;left:720px;font-weight:200;width:200px"> 1,300.00 lb</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1020 }}px;left:720px;font-weight:200;width:200px"> Off</p>

        <div class="cuadro" style="top:{{ $top3 + 1100 }}px;width:900px;height:100px;"></div> {{-- cuadro de parte 6 --}}
        <div class="cuadro" style="top:{{ $top3 + 1220 }}px;width:900px;height:130px;"></div> {{-- cuadro de parte 7 --}}

        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1105 }}px;left:15px;font-weight:bold;width:200px">Operator:</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1140 }}px;left:15px;font-weight:bold;width:200px">Signature:</p>
        <div style="border-bottom: 3px solid #333; position:absolute;top:{{ $top3 + 1175 }}px;left:130px;width:250px;"></div>

        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1105 }}px;left:415px;font-weight:bold;width:200px">Checked By:</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1140 }}px;left:415px;font-weight:bold;width:200px">Signature:</p>
        <div style="border-bottom: 3px solid #333; position:absolute;top:{{ $top3 + 1175 }}px;left:540px;width:250px;"></div>

        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1220 }}px;left:345px;font-weight:bold;width:200px">Balancing Equipment</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1260 }}px;left:15px;font-weight:bold;width:200px">Instrument:</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1290 }}px;left:15px;font-weight:bold;width:200px">Machine:</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1260 }}px;left:585px;font-weight:bold;width:200px">S/N:</p>
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1290 }}px;left:585px;font-weight:bold;width:200px">S/N:</p>

        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1105 }}px;left:135px;font-weight:200;width:200px">Maynor Garcia</p> {{-- operator --}}
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1105 }}px;left:545px;font-weight:200;width:200px">Samuel Mayorga</p> {{-- operator --}}

        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1260 }}px;left:135px;font-weight:200;width:200px">Dynabal D60</p> {{-- operator --}}
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1290 }}px;left:135px;font-weight:200;width:200px">Teco Westinghouse</p> {{-- operator --}}
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1260 }}px;left:635px;font-weight:200;width:200px">74849</p> {{-- operator --}}
        <p style="font-size: 19px;position:absolute;top:{{ $top3 + 1290 }}px;left:635px;font-weight:200;width:200px">9399-DS-12344T</p> {{-- operator --}}

    </div>

    


    {{-- segunda pagina --}}
    @php
    $pagina1 = 1370;
    @endphp
<div>
    <span style="font-size: 26px;position:absolute;top:{{$pagina1+40}}px;left:335px;font-weight:bold ">BALANCE QUALITY</span>
<div class="cuadro"
    style="top: {{$pagina1+90}}px; left: 50%; width: 440px; height: 100px; margin-left: -220px;text-align:center;background-color: #bbb">
    <P style="font-size: 20px;position:relative;top:-10px;font-weight:bold ">CLINICA DE MOTORES ELECTRICOS</P>
    <P style="font-size: 14px;position:relative;top:-30px;font-weight:bold ">23 AVE 28-46 ZONA 5</P>
    <P style="font-size: 14px;position:relative;top:-40px;font-weight:bold ">GUATEMALA C.A.</P>
    <P style="font-size: 14px;position:relative;top:-50px;font-weight:bold ">(502)2331-1596</P>
    </p>
    </div>
    <div class="cuadro" style="top:{{205+$pagina1}}px;width:900px;height:150px;position:absolute"></div>
    <div style="width: 900px">
    <p style="font-size: 16px;position:absolute;top:{{ $pagina1 + $top1 }}px;left:15px;font-weight:bold ">Rotor:</p>
    <p style="font-size: 16px;position:absolute;top:{{ $pagina1 + $top1 + $spacing1 }}px;left:15px;font-weight:bold ">Customer:</p>
    <p style="font-size: 16px;position:absolute;top:{{ $pagina1 + $top1 + $spacing1 * 2 }}px;left:15px;font-weight:bold ">P.O. Order:</p>
    <p style="font-size: 16px;position:absolute;top:{{ $pagina1 + $top1 + $spacing1 * 3 }}px;left:15px;font-weight:bold ">Date:</p>
    <p style="font-size: 16px;position:absolute;top:{{ $pagina1 + $top1 + $spacing1 * 4 }}px;left:15px;font-weight:bold ">Comments:</p>

    <p style="font-size: 16px;position:absolute;top:{{ $pagina1 + $top1 }}px;left:110px;font-weight:200 ">{{$motor->fulLOs}}</p>
    <p style="font-size: 16px;position:absolute;top:{{ $pagina1 + $top1 + $spacing1 }}px;left:110px;font-weight:200;width:400px;">{{$motor->cliente->cliente}} </p>
    <p style="font-size: 16px;position:absolute;top:{{ $pagina1 + $top1 + $spacing1 * 2 }}px;left:110px;font-weight:200 ">{{rand(100000,999999)}}</p>
    <p style="font-size: 16px;position:absolute;top:{{ $pagina1 + $top1 + $spacing1 * 3 }}px;left:110px;font-weight:200 "> {{ $motor->fecha_ingreso ? \Carbon\Carbon::parse($motor->fecha_ingreso)->format('m/d/Y H:i') : '' }}</p>
    <p style="font-size: 16px;position:absolute;top:{{ $pagina1 + $top1 + $spacing1 * 4 }}px;left:110px;font-weight:200;;width:400px ">Comments:</p>
    </div>
    <div>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + 400 }}px;left:15px;font-weight:bold;width:200px">Grade:</p>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + 450 }}px;left:15px;font-weight:bold;width:100px">Rotor Mass:</p>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + 530 }}px;left:15px;font-weight:bold;width:200px">Service Speed:</p>
    <p style="font-size: 20px;position:absolute;top:{{ $pagina1 + 590 }}px;left:15px;font-weight:bold;width:200px">Tolerance:</p>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + 640 }}px;left:95px;font-weight:bold;width:200px">Left:</p>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + 700 }}px;left:95px;font-weight:bold;width:200px">Right:</p>
    <p style="font-size: 20px;position:absolute;top:{{ $pagina1 + 760 }}px;left:15px;font-weight:bold;width:400px">Estimated Trial Weights:</p>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + 800 }}px;left:95px;font-weight:bold;width:200px">Left:</p>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + 860 }}px;left:95px;font-weight:bold;width:200px">Right:</p>
    </div>

    <div class="cuadro" style="top:{{ $pagina1 + $top3 + 1100 }}px;width:900px;height:100px;"></div> {{-- cuadro de parte 6 --}}
    <div class="cuadro" style="top:{{ $pagina1 + $top3 + 1220 }}px;width:900px;height:130px;"></div> {{-- cuadro de parte 7 --}}

    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1105 }}px;left:15px;font-weight:bold;width:200px">Operator:</p>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1140 }}px;left:15px;font-weight:bold;width:200px">Signature:</p>
    <div style="border-bottom: 3px solid #333; position:absolute;top:{{ $pagina1 + $top3 + 1175 }}px;left:130px;width:250px;"></div>

    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1105 }}px;left:415px;font-weight:bold;width:200px">Checked By:</p>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1140 }}px;left:415px;font-weight:bold;width:200px">Signature:</p>
    <div style="border-bottom: 3px solid #333; position:absolute;top:{{ $pagina1 + $top3 + 1175 }}px;left:540px;width:250px;"></div>

    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1220 }}px;left:345px;font-weight:bold;width:200px">Balancing Equipment</p>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1260 }}px;left:15px;font-weight:bold;width:200px">Instrument:</p>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1290 }}px;left:15px;font-weight:bold;width:200px">Machine:</p>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1260 }}px;left:585px;font-weight:bold;width:200px">S/N:</p>
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1290 }}px;left:585px;font-weight:bold;width:200px">S/N:</p>

    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1105 }}px;left:135px;font-weight:200;width:200px">Maynor Garcia</p> {{-- operator --}}
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1105 }}px;left:545px;font-weight:200;width:200px">Samuel Mayorga</p> {{-- operator --}}

    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1260 }}px;left:135px;font-weight:200;width:200px">Dynabal D60</p> {{-- operator --}}
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1290 }}px;left:135px;font-weight:200;width:200px">Teco Westinghouse</p> {{-- operator --}}
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1260 }}px;left:635px;font-weight:200;width:200px">74849</p> {{-- operator --}}
    <p style="font-size: 19px;position:absolute;top:{{ $pagina1 + $top3 + 1290 }}px;left:635px;font-weight:200;width:200px">9399-DS-12344T</p> {{-- operator --}}
</div>

@php
$pagina2 = 1370+1370;
@endphp
    
<div>
    <span style="font-size: 26px;position:absolute;top:{{$pagina2+40}}px;left:335px;font-weight:bold ">POLAR DIAGRAM</span>
    <div class="cuadro"
    style="top: {{$pagina2+90}}px; left: 50%; width: 440px; height: 100px; margin-left: -220px;text-align:center;background-color: #bbb">
        <P style="font-size: 20px;position:relative;top:-10px;font-weight:bold ">CLINICA DE MOTORES ELECTRICOS</P>
        <P style="font-size: 14px;position:relative;top:-30px;font-weight:bold ">23 AVE 28-46 ZONA 5</P>
        <P style="font-size: 14px;position:relative;top:-40px;font-weight:bold ">GUATEMALA C.A.</P>
        <P style="font-size: 14px;position:relative;top:-50px;font-weight:bold ">(502)2331-1596</P>
    
    </div>

    </div>

 <table style="width: 100%;position:absolute;top:3070px;">
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
