<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Capturas de Densidad</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .imagen {
            margin-bottom: 20px;
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    @foreach ($images as $image)
        <div>
            <img src="{{ $image }}" class="imagen">
        </div>
    @endforeach
</body>
</html>
