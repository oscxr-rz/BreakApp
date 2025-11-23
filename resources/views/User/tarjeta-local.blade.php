<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BreakApp - Tarjeta Local</title>
</head>

<body>
    @if (!empty($tarjetaLocal))
        <p>Saldo disponible: {{ $tarjetaLocal['saldo'] }}</p>
    @elseif (!session('idUsuario'))
        <p>Inicie sesion o cree una cuenta para acceder a los datos de su tarjeta</p>
    @else
        <p>No exite ninguna tarjeta</p>
    @endif
</body>

</html>
