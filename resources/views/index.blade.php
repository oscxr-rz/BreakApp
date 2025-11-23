<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp</title>
</head>

<body>
    <nav>
        <ul>
            <li><a href="{{ route('carrito') }}">carrito</a></li>
            <li><a href="{{ route('tarjeta.local') }}">tarjeta local</a></li>
            <li><a href="{{ route('ordenes') }}">ordenes</a></li>
        </ul>
    </nav>
    <livewire:menu-diario />
</body>

</html>
