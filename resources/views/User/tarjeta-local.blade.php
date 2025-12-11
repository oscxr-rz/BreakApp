<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp - Tarjeta Local</title>
</head>

<body class="pb-20 lg:pb-24">
    @include('layouts.navbar')
    <main>
        <livewire:tarjeta-local-usuario />
    </main>
</body>

</html>
