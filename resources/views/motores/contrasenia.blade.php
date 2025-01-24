<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        /* Estilo para la imagen en la parte superior */
        .header-image {
            width: 100%;
            height: auto;
            display: block;
        }

        .tipo_letra {
            font-family: Arial, sans-serif;
            position: absolute;
        }

        #clinica {
            color: #b1c9e4;
            font-size: 32px;
            font-weight: bold;
            top: 20px;
            /*  Ajusta según lo que necesites */
            left: 10px;
        }

        #subtitulo {
            color: #b1c9e4;
            font-size: 24px;
            font-weight: lighter;
            top: 60px;
            /* Coloca el subtítulo debajo del título */
            left: 10px;
        }

        #subtitulo2 {
            color: #fff;
            font-size: 26px;
            text-decoration: underline;
            top: 130px;
            font-weight: lighter;
            left: 10px;
        }

        .os {
            color: #fff;
            font-size: 36px;
            top: 110px;
            font-weight: bold;
            left: 450px;
        }

        .cliente {
            color: #fff;
            font-size: 16px;
            top: 170px;

            left: 450px;
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

        .table-striped tr:hover {
            background-color: #e9ecef;
            /* Fondo cuando se pasa el ratón por encima */
        }

        .table-striped td:nth-child(odd),
        .table-striped th:nth-child(odd) {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .imagenes {
            display: flex;
            justify-content: space-between;
            /* Distribuye las imágenes uniformemente */
            gap: 10px;
            /* Espacio entre las imágenes */
            width: 100%;
            /* Asegura que el contenedor ocupe el 100% del espacio disponible */
            padding: 10px;
            box-sizing: border-box;
            position: absolute;
            left: 10px;
        }

        .imagenes img {
            width: 23%;
            /* Hace que cada imagen ocupe el 23% del ancho disponible */
            height: auto;
            border-radius: 8px;
            /* Redondeo leve en las esquinas */
            object-fit: cover;
            /* Asegura que las imágenes mantengan la proporción sin deformarse */
            max-height: 200px;
            /* Limita la altura máxima */

            object-fit: contain;
            /* Asegura que la imagen no se distorsione, se ajusta bien dentro del espacio */
            border-radius: 10px;
            /* Opcional: agrega un borde redondeado */
            margin-right: 10px;
        }

        .list-group {
            list-style-type: none;
            padding: 0;
            margin: 0;
            max-width: 400px;
            /* Puedes ajustar este valor */
            border: 1px solid #ddd;
            /* Borde sutil alrededor de la lista */
            border-radius: 0.375rem;
            /* Bordes redondeados */
            background-color: #f8f9fa;
            /* Color de fondo para la lista */
        }

        /* Estilo para cada elemento de la lista */
        .list-group-item {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            /* Separador entre los elementos */
            cursor: pointer;
            /* Hace que los elementos sean clickeables */
            background-color: #ffffff;
            /* Color de fondo para cada item */
            transition: background-color 0.3s ease;
            /* Transición suave para el cambio de color */
        }

        /* Estilo al pasar el mouse por encima de cada item */
        .list-group-item:hover {
            background-color: #e9ecef;
            /* Color de fondo al pasar el mouse */
        }

        /* El último elemento no tiene borde inferior */
        .list-group-item:last-child {
            border-bottom: none;
        }

        /* Opcional: estilo para elementos activos */
        .list-group-item.active {
            background-color: #007bff;
            /* Color de fondo para el elemento activo */
            color: white;
            /* Color del texto para el elemento activo */
        }

        .footer-span {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #ffffff;
            background-color: #1c3759;
            /* Fondo oscuro */
            padding: 5px 10px;
            text-align: center;
            width: 100%;
            white-space: nowrap;
            /* Evita que el texto salte de línea */
            overflow: hidden;
            /* Oculta texto extra si el espacio es demasiado pequeño */
            text-overflow: ellipsis;
            /* Muestra "..." si el texto no cabe */
            box-sizing: border-box;
            position: absolute;
            top: 1330px;
        }

        .footer-span span {
            display: inline-block;
            margin: 0 3px;
            /* Espaciado horizontal entre elementos */
            font-weight: bold;
            color: #b1c9e4;
            /* Azul claro */
        }
    </style>
</head>

<body>
    <img src="{{ public_path('img/prueba3.png') }}" alt="Logo" class="header-image">
    <h1 id="clinica" class="tipo_letra ">CLINICA DE MOTORES ELECTRICOS</h1>
    <h2 id="subtitulo" class="tipo_letra ">ORDEN DE SERVICIO</h2>
    <h3 id="subtitulo2" class="tipo_letra "> RECEPCION DE EQUIPO</h3>
    <h4 class="os tipo_letra">{{ $motor->year }}-{{ $motor->os }}</h4>
    <h5 class="cliente tipo_letra">{{ $motor->cliente->cliente }}</h5>

    <h6 class="titulo tipo_letra" style="top: 160px;">DATOS DEL EQUIPO</h6>

    <table class="table-striped" style="top: 250px;">
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
    <h6 class="titulo tipo_letra" style="top: 430px;">INVENTARIO DE PARTES</h6>
    <table class="table-striped" style="top: 520px;">
        <tr>
            <td>Acople</td>
            <td>{{ $motor->inventario->getItemStatus($motor->inventario->acople) }}</td>
            <td>Caja Conexiones</td>
            <td>{{ $motor->inventario->getItemStatus($motor->inventario->caja_conexiones) }}</td>
            <td>Tapa Caja Conexiones</td>
            <td>{{ $motor->inventario->getItemStatus($motor->inventario->tapa_caja) }}</td>
        </tr>
        <tr>
            <td>Difusor</td>
            <td>{{ $motor->inventario->getItemStatus($motor->inventario->difusor) }}</td>
            <td>Ventilador</td>
            <td>{{ $motor->inventario->getItemStatus($motor->inventario->ventilador) }}</td>
            <td>Bornera</td>
            <td>{{ $motor->inventario->getItemStatus($motor->inventario->bornera) }}</td>
        </tr>
        <tr>
            <td>Cu&ntilde;a</td>
            <td>{{ $motor->inventario->getItemStatus($motor->inventario->cunia) }}</td>
            <td>Graseras</td>
            <td>{{ $motor->inventario->getItemStatus($motor->inventario->graseras) }}</td>
            <td>Cancamo</td>
            <td>{{ $motor->inventario->getItemStatus($motor->inventario->cancamo) }}</td>
        </tr>
        <tr>
            <td>Placa</td>
            <td>{{ $motor->inventario->getItemStatus($motor->inventario->placa) }}</td>
            <td>Capacitor</td>
            <td>{{ $motor->inventario->getItemStatus($motor->inventario->capacitor) }}</td>
            <td>Tornillos Completos</td>
            <td>{{ $motor->inventario->getItemStatus($motor->inventario->tornillos) }}</td>
        </tr>
        <tr>
            <td>Comentarios Inventario</td>
            <td colspan="5">{{ $motor->inventario->comentarios }}</td>
        </tr>
    </table>
    <h6 class="titulo tipo_letra" style="top: 660px;">IMAGENES DE ENTRADA</h6>
    <div class="imagenes" style="top: 750px;">
        @php
            $fotos = $motor->fotos->take(4); // Limita a las primeras 4 imágenes
            $missingImages = 4 - $fotos->count(); // Calcula cuántas imágenes faltan
        @endphp

        @foreach ($fotos as $foto)
            <img src="{{ public_path('storage' . $foto->thumb) }}" alt="Imagen de Entrada">
        @endforeach

        @for ($i = 0; $i < $missingImages; $i++)
            <img src="{{ public_path('img/default-avatar.png') }}" alt="Imagen Predeterminada">
        @endfor
    </div>
    <h6 class="titulo tipo_letra" style="top: 920px;">INFORMACI&Oacute;N DE RECEPCI&Oacute;N</h6>
    <table class="table-striped" style="font-size: 12px;top: 1000px;">
        <tr>
            <td>Cliente:</td>
            <td colspan="2" >{{ $motor->cliente->cliente }}</td>
            <td width="" colspan="2">Fecha de Ingreso:</td>
            <td colspan="">
                {{ \Carbon\Carbon::parse($motor->fecha_ingreso)->locale('es')->isoFormat('dddd D [de] MMMM [del] YYYY') }}
            </td>

        </tr>
        <tr>
            <td width="15%">Contacto</td>
            <td width="20%">{{ $motor->infoMotor->contacto }}</td>
            <td width="15%">Telefono:</td>
            <td width="15%">{{ $motor->infoMotor->telefono }}</td>
            <td width="15%">Correo:</td>
            <td width="20%">{{ $motor->infoMotor->email }}</td>
        </tr>
    </table>
    <table class="table-striped" style="font-size: 12px;top: 1100px;">
        <tr>
            <td>Recibido por:</td>
            <td>{{ $motor->recibido }}</td>
            <td>Nivel de Emergencia</td>
            <td>{{ $motor->infoMotor->emergencia }}</td>
            <td>Empezar a Trabajar</td>
            <td>{{ $motor->infoMotor->cotizar }}</td>
        </tr>
        <tr>
            <td>Facturar a:</td>
            <td colspan="3">{{ $motor->cliente->info_cliente->razon_social }}</td>
            <td>NIT:</td>
            <td>{{ $motor->cliente->info_cliente->nit }}</td>
        </tr>
        <tr>
            <td>Dirección:</td>
            <td colspan="6">{{ $motor->cliente->info_cliente->direccion_fiscal }}</td>
        </tr>
    </table>

    <h6 class="titulo tipo_letra" style="top: 1160px;">Contacto</h6>
    <table class="table-striped" style="top: 1240px;">
        <tr style="height: 50px">
            <td width="25%">Equipo Entregado por:</td>
            <td></td>
            <td width="20%">Firma</td>
            <td width="25%"></td>

        </tr>
    </table>
    <span class="footer-span">
        <span>Clinica de Motores Electricos</span> |
        <span>PBX: 2331-1596</span> |
        <span>23 Ave 28-46 Zona 5, Guatemala C.A</span> |
        <span>info@cmeamir.com</span>
    </span>

</body>

</html>
