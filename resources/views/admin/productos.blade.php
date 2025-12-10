<!DOCTYPE html>
<html lang="es"  x-data="{ mobileMenu: false }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp - Productos</title>
</head>

<body class="bg-gray-50">
    @include('admin.layouts.navbar')
    <main class="lg:ml-[180px] min-h-screen">
        <livewire:admin.productos />
    </main>
    @livewireScripts
    @stack('script')
</body>

</html>
