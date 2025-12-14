<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp - Notificaciones</title>
</head>

<body>
    @include('layouts.navbar')

    <main>
        <div class="max-w-7xl mx-auto">
            <livewire:notificaciones-usuario />
        </div>
    </main>
    @stack('script')
    @livewireScripts
</body>

</html>
