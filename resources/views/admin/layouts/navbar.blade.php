<!-- Sidebar Component: admin-sidebar.blade.php -->
<div id="sidebarContainer" class="relative">
    <!-- Overlay para móvil -->
    <div id="overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden transition-opacity duration-300"></div>

    <!-- Botón hamburguesa móvil -->
    <button id="menuBtn"
        class="fixed bottom-4 right-4 z-50 lg:hidden p-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-all hover:scale-110 shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed top-0 left-0 h-screen w-[180px] bg-linear-to-b from-blue-600 to-blue-800 transition-transform duration-300 ease-in-out z-40 flex flex-col -translate-x-full lg:translate-x-0">

        <!-- Logo Section Mejorada -->
        <div class="px-4 py-6 mt-4 flex flex-col items-center">
            <!-- Contenedor del logo con efectos -->
            <div class="relative group">
                <!-- Círculo de fondo decorativo -->
                <div
                    class="absolute inset-0 bg-white/10 rounded-2xl blur-xl group-hover:bg-white/20 transition-all duration-300">
                </div>

                <!-- Logo -->
                <div
                    class="relative bg-white rounded-2xl p-3 shadow-xl transform group-hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('storage/logos/3.png') }}" alt="BreakApp Logo"
                        class="w-20 h-20 object-contain rounded-xl">
                </div>
            </div>

            <!-- Texto del logo -->
            <div class="mt-4 text-center">
                <h2 class="text-white font-bold text-lg tracking-wide">BreakApp</h2>
                <p class="text-blue-200 text-xs mt-1">Admin Panel</p>
            </div>
        </div>

        <!-- Divisor decorativo -->
        <div class="mx-4 h-px bg-white/20"></div>

        <!-- Navegacion -->
        <nav class="flex-1 px-3 space-y-2 mt-6 relative">

            <!-- Ordenes -->
            <div class="relative">
                <a href=""
                    class="nav-link relative flex items-center gap-2.5 px-3 py-3 transition-all duration-300 group z-20
                          {{ request()->routeIs('admin.ordenes') ? 'text-blue-600' : 'text-blue-100 hover:bg-blue-700/50 rounded-xl' }}">
                    <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span class="font-medium text-sm relative z-10">Ordenes</span>
                </a>
                @if (request()->routeIs('admin.orders'))
                    <div
                        class="absolute -right-3 top-0 bottom-0 w-[calc(100%+12px)] bg-gray-50 rounded-tl-[40px] rounded-bl-[40px] pointer-events-none">
                    </div>
                @endif
            </div>

            <!-- Categorias -->
            <div class="relative">
                <a href="{{ route('admin.categorias') }}"
                    class="nav-link relative flex items-center gap-2.5 px-3 py-3 transition-all duration-300 group z-20
                          {{ request()->routeIs('admin.categorias') ? 'text-blue-600' : 'text-blue-100 hover:bg-blue-700/50 rounded-xl' }}">
                    <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <span class="font-medium text-sm relative z-10">Categorias</span>
                </a>
                @if (request()->routeIs('admin.categorias'))
                    <div
                        class="absolute -right-3 top-0 bottom-0 w-[calc(100%+12px)] bg-gray-50 rounded-tl-[40px] rounded-bl-[40px] pointer-events-none">
                    </div>
                @endif
            </div>

            <!-- Productos -->
            <div class="relative">
                <a href="{{ route('admin.productos') }}"
                    class="nav-link relative flex items-center gap-2.5 px-3 py-3 transition-all duration-300 group z-20
                          {{ request()->routeIs('admin.productos') ? 'text-blue-600' : 'text-blue-100 hover:bg-blue-700/50 rounded-xl' }}">
                    <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="font-medium text-sm relative z-10">Productos</span>
                </a>
                @if (request()->routeIs('admin.productos'))
                    <div
                        class="absolute -right-3 top-0 bottom-0 w-[calc(100%+12px)] bg-gray-50 rounded-tl-[40px] rounded-bl-[40px] pointer-events-none">
                    </div>
                @endif
            </div>
        </nav>

        <!-- Footer del sidebar -->
        <div class="p-4 mt-auto">
            <div class="bg-blue-700/50 rounded-xl p-3 text-center">
                <p class="text-blue-100 text-xs">Versión 1.0</p>
            </div>
        </div>
    </aside>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle del menú móvil
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if (menuBtn && sidebar && overlay) {
            menuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            });

            overlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });

            // Cerrar menú en móvil al hacer clic en cualquier link
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        sidebar.classList.add('-translate-x-full');
                        overlay.classList.add('hidden');
                    }
                });
            });
        }
    });
</script>
