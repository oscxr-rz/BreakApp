<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp - Admin</title>
</head>

<body>
    @include('admin.layouts.navbar')
    <main class="lg:ml-[180px] min-h-screen">
        <livewire:admin.dashboard />
    </main>
    @livewireScripts
    @stack('script')
</body>

</html>
