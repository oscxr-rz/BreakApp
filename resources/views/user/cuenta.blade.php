<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp - Cuenta</title>
</head>

<body class="pb-20 lg:pb-24">
    @include('layouts.navbar')
    <main>
        <livewire:components.notificacion />
        <livewire:cuenta-usuario />
    </main>
    @stack('script')
</body>

</html>
