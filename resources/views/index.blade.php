<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp</title>
</head>

<body class="bg-white pb-20 lg:pb-24">
    @include('layouts.navbar')

    <main>
        <div class="max-w-7xl mx-auto">
            <livewire:menu-diario />
        </div>
    </main>

    @stack('script')
</body>

</html>
