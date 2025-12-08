<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp - Carrito</title>
</head>

<body>
    <!-- Componente de navegación -->
    @include('layouts.navbar')

    <div class="text-center mb-8 bg-[#951327] pt-3 pb-3">
        <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">Mi Carrito</h1>
    </div>

    <livewire:carrito-usuario />
    @stack('script')
</body>

</html>
