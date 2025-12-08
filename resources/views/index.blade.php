<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>BreakApp</title>
</head>

<body class="bg-white pb-24">
    <!-- Componente de navegación -->
    @include('layouts.navbar')

    <!-- Contenido principal -->
    <div class="max-w-7xl mx-auto">
        <livewire:menu-diario />
    </div>

    <!-- Toast para mensajes -->
    @if (session('mensaje'))
        <div id="toast"
            class="fixed top-5 left-1/2 -translate-x-1/2 bg-slate-700 text-white px-6 py-3 rounded-xl shadow-lg z-1000 text-sm md:text-base animate-slideDown">
            {{ session('mensaje') }}
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast');
                if (toast) {
                    toast.style.transition = 'all 0.3s ease-out';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(-50%) translateY(-20px)';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 3000);
        </script>
    @endif
</body>

</html>
