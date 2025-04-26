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
        position: relative;
        top: 220px;
        width: 100%;
        font-size: 30px;
        font-weight: bold;
        text-align: center;
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
    .datos-coti {
        margin-top:5px;
        font-size: 14px;
        color: #000000;
        width: 100%;
        border-collapse: collapse;
    }
    .datos-coti p {
        margin-bottom: 3px;
        margin-top: 1px;
    }
    .datos-coti td {
    
    }
    .datos-cliente {
        font-size: 12px;
        color: #444;
        font-style: italic;
    }
    .coti{
        margin-top:5px;
        font-size: 14px;
        color: #000000;
        width: 100%;
        border-collapse: collapse;
    }
    .coti th {
        padding: 10px;
        font-size: 14px;
        color: #fff;
    }
    .coti td {
        padding: 10px;
        text-align: right;
        font-size: 14px;
        color: #000000;
        vertical-align: top;
        border-bottom: 1px solid #ddd;
        
    }
    .mi-celda-pre {
        text-align: left;
        font-size: 14px;
        color: #000000;
        vertical-align: top;
        border-bottom: 1px solid #ddd;
        white-space: pre-wrap;
  line-height: 1.2;
  padding: .2em;
    }
    </style>
<body>
    <img src="{{ public_path('img/logo.jpg') }}" alt="Logo" class="header-img">
    <div class="header-text">
        <p>23 Ave. 28-46 Zona 5. 01005 Guatemala C.A.</p>
        <p>Telefonos: (502) 2331-1596 | (502) 2331-1263 | (502) 2331-1254</p>
        <p>info@cmeamir.com</p>
        <p>Razon Social: AMIR S.A.</p>
        <p>Nit: 778261-6</p>
    </div>
    <img src="{{ public_path('img/images.jpeg') }}" alt="Logo" class="motor-img">
    <img src="{{ public_path('img/easa.jpg') }}" alt="Logo" class="easa-img">
    <img src="{{ public_path('img/weg.png') }}" alt="Logo" class="weg-img">
    <div class="envio-title">
        <p>OFERTA PRESUPUESTARIA</p>
        <hr>
    </div>
    <div style="position: absolute; top: 280px; width: 100%; ">
       <table class="datos-coti">
        <colgroup>
            <td style="width:40%"></td>
            <td style="width:20%"></td>
            <td style="width:40%"></td>
        </colgroup>
        <tr>
            <td>
                <p style="color:#333;">DIRIGIDA A:</p>
                <p style="font-weight: bold;color:#000;font-size:16px">TECNIFIBRAS, S.A.</p>
                <p>Cristian Castañeda</p>
               
                <div class="datos-cliente">
                    <p>13 calle 12-50 Lomas Del Norte Zona 17</p>
                    <p >Ciudad</p>
                    <p>Guatemala</p>
                    <p>5496-6149</p>
                    <p>auxiliar.mantenimiento@tecnifibras.com</p>
                </div>
               
            </td>
            <td></td>
            <td style="text-align: right;">
                <p>Estimate Number: 1715</p>
                <p>Estimate Date: April 21, 2025</p>
                <p>Valid Until: May 21, 2025</p>
                <p>Estimate Total (GTQ): Q15,355.00</p>
            </td>
        </tr>
       </table>
    </div>
    <div style="position: absolute; top: 450px; width: 100%; ">
        <table class="coti">
         <thead style="background-color: #000044; color: white;">
            <th style="text-align: left;width:50%">Items</th>
            <th style="text-align: right;width:10%">Cantidad</th>
            <th style="text-align: right;width:20%">Precio</th>
            <th style="text-align: right;width:20%">Total</th>
         </thead>
         <tbody>
            @for ($i = 0; $i < 10; $i++)
            <tr>
                <td style="text-align: left; line-height: 1.2">
                    {!! nl2br(e($data)) !!}
                </td>
                <td style="text-align: center;"> 1</td>
                <td>Q11,200.00</td>
                <td>Q11,200.00</td>
            </tr>
            @endfor
            
         </tbody>
        </table>
    
</body>
</html>

{{-- 
Rebobinado del estator a motor de 18.5 Kw - 3550
Rpm
Rebobinado del estator, consistente en:

- Rebobinado bajo normas estándares EASA AR-
100

- Extracción de alambre con horno de pirólisis
controlada.
- Rebobinado con alambre GP-MR200, Clase F.
- Colocación de cable de salida.
- Aislamientos Nomex.
- Barnizado VOI.

--}}