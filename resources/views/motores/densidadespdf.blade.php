<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hoja para Densidades</title>
</head>
<style>
    /* Estilos CSS optimizados */
    .centrado {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        text-align: center;
        font-family: Arial, sans-serif;
    }

    body {
        margin-left: 20px;
       
    }
    #logoHeader {
        max-width: 300px;
        height: auto;
    }

    h1 {
        font-size: 2em;
        font-weight: 300;
        /* Texto más delgado */
        margin-top: -15px;
        color: #333;
    }

    .tabla {
        width: 97%;
        /* Ocupa el 100% del ancho */
        height: auto;

        /* Espaciado debajo del h1 */
        border-collapse: collapse;
        /* Quita los bordes entre celdas */

        /* Borde de la tabla */
        position: absolute;
        top: 190px;
    }

    .tabla td {

        /* Cada columna ocupa el 50% del espacio */
        text-align: left;
        /* Justifica el contenido a la izquierda */
        vertical-align: top;
        /* Alinea el contenido al inicio de la celda */
        font-family: Arial, sans-serif;
        font-size: 1.2em;
        /* Ajustar el tamaño del texto */
        padding: 5px;
        /* Espaciado interno */
        margin-top: -2in;
        padding: 0px;
        line-height: 1.2;
    }

    .tabla td,
    .tabla th {
        padding: 5px;
        /* Ajusta el valor según lo que necesites */
        vertical-align: middle;
        /* Alinea el contenido verticalmente */
    }


    .data-table {
        width: 97%;
        position: absolute;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        text-transform: uppercase;
        color: #333;
    }

    .data-table td {
        padding: 8px;
        /* Ajusta el valor según lo que necesites */
        vertical-align: middle;
        /* Alinea el contenido verticalmente */
        border: 1px solid #777;

    }

    .data-table td:nth-child(odd) {
        background-color: #f2f2f2;
        /* Color de fondo */
    }

    .titulos {
        font-weight: bold;
        position: absolute;
        font-family: Arial, sans-serif;
        font-size: 24px;
        color: #333;
    }

    .no-data-table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        text-transform: uppercase;
        color: #333;
        position: absolute;
    }

    .no-data-table td {
        padding: 8px;
        /* Ajusta el valor según lo que necesites */
        vertical-align: middle;
        /* Alinea el contenido verticalmente */
        border: 1px solid #777;
    }
    .cuadro {
        position: absolute;
        width: 30px;
        height: 25px;
        border: 1px solid #666;
    }
    .no-title {
        font-weight:100;
        font-family: Arial, sans-serif;
        font-size: 20px;
        color: #333;
        position: absolute;
        text-transform: uppercase;
    }
</style>
</head>

<body>
    <div class="centrado">
        <img src="{{ public_path('img/logobw.png') }}" alt="Logo" id="logoHeader">
        <h1>HOJA DE DATOS DE MOTOR</h1>
    </div>
    <table class="tabla">
        <tr>
            <td width="45%">
                <span style="font-weight:bold"> ORDEN DE SERVICIO: </span>
                <span style="font-weight: bold;color:#660000;font-size:24px">{{ $motor->fulLOs }}</span>
            </td>
            <td width="55%">
                <span style="font-weight: bold;">CLIENTE: </span>
                <span> {{ $motor->cliente->cliente }}</span>
            </td>
        </tr>
        <tr>
            <td style="display: flex; align-items: center;">
                <span style="font-weight: bold;">TECNICO: </span>
                <span
                    style="flex-grow: 1; font-weight: bold; text-transform: uppercase; border-bottom: 1px solid #333; display: inline-block; padding-bottom: 2px;">
                    {{ $tecnico }}
                </span>
            </td>
            <td>
                <span style="font-weight: bold;">MARCA: </span>
                <span>{{ $motor->marca }}</span>
            </td>
        </tr>
    </table>
    <table class="data-table" style="top: 270px;">
        <tr>
            <td width="20%">
                <span style="font-weight:100;padding:10px">CAUSA DE FALLO: </span>
            </td>
            <td>
                &nbsp;
            </td>
        </tr>
    </table>
    <table class="data-table" style="top: 310px;">
        <tr>
            <td width="15%">
                <span style="font-weight:100;padding:10px">Potencia: </span>
            </td>
            <td width="15%">{{ $motor->potencia }}</td>
            <td width="15%">
                <span style="font-weight:100;padding:10px">RPM: </span>
            </td>
            <td width="15%">{{ $motor->rpm }}</td>
            <td width="15%">
                <span style="font-weight:100;padding:10px">Hz: </span>
            </td>
            <td width="15%">{{ $motor->hz }}</td>
        </tr>
        <tr>
            <td width="15%">
                <span style="font-weight:100;padding:10px">Polos: </span>
            </td>
            <td width="15%"></td>
            <td width="15%">
                <span style="font-weight:100;padding:10px">Ranuras: </span>
            </td>
            <td width="15%"></td>
            <td width="15%">
                <span style="font-weight:100;padding:10px">Fases: </span>
            </td>
            <td width="15%">{{ $motor->phases }}</td>

        </tr>
    </table>

    <table class="data-table" style="top: 385px;">
        <tr>
            <td width="20%">
                <span style="font-weight:100;padding:10px">Voltajes: </span>
            </td>
            <td width="30%"></td>
            <td width="20%">
                <span style="font-weight:100;padding:10px">Amperajes: </span>
            </td>
            <td width="30%"></td>

        </tr>
        <tr>
            <td>
                <span style="font-weight:100;padding:10px">Conexion: </span>
            </td>
            <td></td>
            <td>
                <span style="font-weight:100;padding:10px">Circuitos: </span>
            </td>
            <td></td>

        </tr>
    </table>



    <table class="data-table" style="top: 480px;width:45%">
        <tr>
            <td width="45%">Largo Nucleo:</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="45%">Diametro Nucleo:</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="45%">Back Iron:</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="45%">Ancho Diente:</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td width="45%">Prof. ranura:</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <img src="{{ public_path('img/motorbw.png') }}" alt="Logo"
        style="position: absolute; top: 470px; left: 500px; width: 430px;">

    @if ($motor->phases == 1)
        <span class="titulos" style="top:680px;"> BOBINADO MARCHA</span>
        <span class="titulos" style="top:680px;left:480px"> BOBINADO ARRANQUE</span>
    @else
        <span class="titulos" style="top:680px;"> BOBINADO TRIFASICO</span>
    @endif

    <table class="data-table" style="top: 715px;width:47%">
        <tr>
            <td width="20%">
                <span style="font-weight:100;padding:10px">Bobinas x grupo: </span>
            </td>
            <td width="30%"></td>

        </tr>
        <tr>
            <td>
                <span style="font-weight:100;padding:10px">grupos: </span>
            </td>
            <td></td>
        </tr>
    </table>
    @if ($motor->phases == 1)
    <table class="data-table" style="top:715px;width:47%;left:480px">
        <tr>
            <td width="20%">
                <span style="font-weight:100;padding:10px">Bobinas x grupo: </span>
            </td>
            <td width="30%"></td>

        </tr>
        <tr>
            <td>
                <span style="font-weight:100;padding:10px">grupos: </span>
            </td>
            <td></td>
        </tr>
    </table>
    @endif
    @php
        $phases = $motor->phases==3?1:2;

    @endphp

    @for ($i = 0; $i < $phases; $i++)
        <span class="titulos" style="top:810px;font-size:20px;left:{{ $i * 480 + 20 }}px">CALIBRES:</span>
        <span class="titulos" style="top:840px;font-size:20px;left:{{ $i * 480 + 20 }}px">HILOS:</span>

        <table class="no-data-table" style="top: 800px;width: 35%;left:{{ $i * 480 + 140 }}px">
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <span class="titulos" style="top:890px;font-size:20px;left:{{ $i * 480 + 20 }}px">PASO 1-:</span>
        <span class="titulos" style="top:920px;font-size:20px;left:{{ $i * 480 + 20 }}px">VUELTAS:</span>
        <table class="no-data-table" style="top: 880px;width: 35%;left:{{ $i * 480 + 140 }}px">
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    @endfor

    <table class="data-table" style="top: 970px;">
        <tr>
            <td width="12%">
                <span style="font-weight:100;padding:10px"># puntas: </span>
            </td>
            <td width="12%"></td>
            <td width="18%">
                <span style="font-weight:100;padding:10px">largo puntas:</span>
            </td>
            <td width="15%"></td>
            <td width="18%">
                <span style="font-weight:100;padding:10px">Calibre puntas:</span>
            </td>
            <td width="15%"></td>
        </tr>
        <tr>
            <td colspan="4">
                <span style="font-weight:100;padding:10px">puntas (simples,dobles,triples, etc.): </span>
            </td>
            <td colspan="2"></td>
        </tr>
    </table>


    <div class="cuadro" style="top: 1050px;left: 20px;">
    </div>
    <span class="no-title" style="top: 1050px;left: 60px;">alambre clase f</span>

    <div class="cuadro" style="top: 1080px;left: 20px;">
    </div>
    <span class="no-title" style="top: 1080px;left: 60px;">alambre ultrashield</span>

    <div class="cuadro" style="top: 1050px;left: 330px;">
    </div>
    <span class="no-title" style="top: 1050px;left: 366px;">bobinado original</span>

    <div class="cuadro" style="top: 1080px;left: 330px;">
    </div>
    <span class="no-title" style="top: 1080px;left: 370px;">ya rebobinado</span>
    
    <div class="cuadro" style="top: 1050px;left: 630px;">
    </div>
    <span class="no-title" style="top: 1050px;left: 670px;">secuencia abc</span>

    <div class="cuadro" style="top: 1080px;left: 630px;">
    </div>
    <span class="no-title" style="top: 1080px;left: 670px;">secuencia acb</span>

    <span class="titulos" style="top:1130px;font-size:20px;">MONTAJE*:</span>
    <table class="no-data-table" style="top: 1120px;width: 50%;LEFT:140px">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <span style="position: absolute;top: 1160px;font-size:12px;left:140px">*Si hay diferentes vueltas por bobina</span>
    <table class="data-table" style="top:1120px;left:660px;width:31%">
        <tr>
            <td width="40%">OS Vieja*</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <span style="position: absolute;top: 1160px;font-size:12px;left:650px">*Si el equipo se rebobin&oacute; antes o hay otro igual</span>
    <span class="titulos" style="top:1175px;font-size:20px;">DIAGRAMA:</span>
    <div class="cuadro" style="top: 1205px;width: 990px;height: 105px;border: 1px solid #777;">

    </div>

</body>
</body>

</html>
