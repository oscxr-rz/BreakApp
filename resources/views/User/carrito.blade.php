<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp - Carrito</title>
</head>

<body class="pb-20 lg:pb-24">
    @include('layouts.navbar')
    <livewire:carrito-usuario />
    @stack('script')
</body>

</html>
