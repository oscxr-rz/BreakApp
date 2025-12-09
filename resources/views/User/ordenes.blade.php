<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp - Órdenes</title>
</head>

<body>
    @include('layouts.navbar')

    <!-- Header -->
    <div class="text-center mb-8 bg-[#951327] p-8 shadow-lg">
        <h1 class="text-3xl font-bold text-white mb-2">Mis Órdenes</h1>
        <p class="text-white/90">Historial de pedidos</p>
    </div>
    <livewire:ordenes-usuario />
    @stack('script')
</body>

</html>
