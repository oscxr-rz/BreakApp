<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp - Tarjeta Local</title>
</head>

<body class="bg-gray-50">
    @include('layouts.navbar')
    <livewire:tarjeta-local-usuario />
</body>

</html>
