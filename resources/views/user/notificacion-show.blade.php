<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BreakApp - Notificación</title>
</head>

<body class="pb-20 lg:pb-24">
    @include('layouts.navbar')
    <main>
        <div>
            <livewire:notificacion-show :id="$id" />
        </div>
    </main>
    @stack('script')
    @livewireScripts
</body>

</html>
