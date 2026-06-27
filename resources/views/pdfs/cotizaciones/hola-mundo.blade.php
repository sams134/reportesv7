<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>PDF Cotización</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            padding: 50px;
            color: #222;
        }

        .contenedor {
            border: 1px solid #ccc;
            padding: 40px;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>hola mundo</h1>

    <p>Cotización ID: {{ $cotizacion->id }}</p>
    <p>Número: {{ $cotizacion->numero }}</p>
    <p>Título: {{ $cotizacion->titulo }}</p>

    <p>
        Portada:
        {{ $usarPortada ? 'Sí' : 'No' }}
    </p>
</body>

</html>
