<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Tu Código QR para la Visita!</title>
</head>
<body>
    <h2>¡Hola!</h2>
    <p>Adjunto encontrarás el código QR generado para tu visita.</p>

    <div>
        <img src="{{ $message->embed(public_path($qrImagePath)) }}" alt="Código QR">
    </div>

    <p>Gracias,<br>{{ config('app.name') }}</p>
</body>
</html>
