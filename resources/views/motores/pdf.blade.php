<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraseña de Ingreso a Reparación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }
        .images {
            display: flex;
            gap: 10px;
        }
        .images img {
            width: 100%;
            max-width: 150px;
            border: 1px solid #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="logo.png" alt="Logo de la Empresa">
            <h1>Contraseña de Ingreso a Reparación</h1>
        </header>

        <div class="section">
            <div class="section-title">Información del Cliente</div>
            <p><strong>Nombre Cliente:</strong> ______________________</p>
            <p><strong>A quien se factura:</strong> ______________________</p>
            <p><strong>NIT:</strong> ______________________</p>
            <p><strong>Dirección:</strong> ______________________</p>
        </div>

        <div class="section">
            <div class="section-title">Detalles del Trabajo</div>
            <p><strong>Fecha de Ingreso:</strong> ______________________</p>
            <p><strong>Número de Trabajo (OS):</strong> ______________________</p>
            <p><strong>Trabajos a realizar:</strong></p>
            <p>_________________________________________________________________________</p>
        </div>

        <div class="section">
            <div class="section-title">Datos del Equipo</div>
            <table>
                <tr>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>No Serie</th>
                    <th>Modelo</th>
                    <th>Potencia</th>
                    <th>Voltaje</th>
                    <th>Amperaje</th>
                    <th>RPM</th>
                </tr>
                <tr>
                    <td>__________</td>
                    <td>__________</td>
                    <td>__________</td>
                    <td>__________</td>
                    <td>__________</td>
                    <td>__________</td>
                    <td>__________</td>
                    <td>__________</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Imágenes de Entrada</div>
            <div class="images">
                <img src="image1.png" alt="Imagen 1">
                <img src="image2.png" alt="Imagen 2">
                <img src="image3.png" alt="Imagen 3">
                <img src="image4.png" alt="Imagen 4">
            </div>
        </div>

        <div class="section">
            <div class="section-title">Inventario de Partes</div>
            <table>
                <tr>
                    <th>Parte</th>
                    <th>Cantidad</th>
                </tr>
                <tr>
                    <td>_________________</td>
                    <td>_________________</td>
                </tr>
                <tr>
                    <td>_________________</td>
                    <td>_________________</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
