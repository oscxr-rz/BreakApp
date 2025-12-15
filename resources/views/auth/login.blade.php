<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/img/logo.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp - Iniciar sesión</title>
</head>

<body class="min-h-screen flex items-center justify-center p-4 pb-20 lg:pb-24">
    @include('layouts.navbar')
    <main>
        <livewire:auth.login />
    </main>
    @stack('script')
</body>

</html>
