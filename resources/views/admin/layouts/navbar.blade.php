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

        <!-- Logo Section Compacto -->
        <div class="px-4 py-5 flex items-center gap-3">
            <!-- Logo pequeño -->
            <div class="relative group flex-shrink-0">
                <div class="bg-white rounded-lg p-1.5 shadow-lg">
                    <img src="{{ asset('storage/logos/3.png') }}" alt="BreakApp Logo"
                        class="w-10 h-10 object-contain">
                </div>
            </div>

            <!-- Texto del logo -->
            <div class="flex-1 min-w-0">
                <h2 class="text-white font-bold text-base tracking-wide truncate">BreakApp</h2>
            </div>
        </div>

        <!-- Divisor decorativo -->
        <div class="mx-4 h-px bg-white/20"></div>

        <!-- Navegacion -->
        <nav class="flex-1 px-3 space-y-2 mt-6 relative">

            <!-- Ordenes - Dropdown -->
            <div class="relative">
                <button id="ordenesDropdown"
                    class="nav-link w-full relative flex items-center justify-between gap-2.5 px-3 py-3 transition-all duration-300 group z-20
                          {{ request()->routeIs('admin.ordenes*') ? 'text-blue-600' : 'text-blue-100 hover:bg-blue-700/50 rounded-xl' }}">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                        <span class="font-medium text-sm relative z-10">Ordenes</span>
                    </div>
                    <svg id="ordenesChevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('admin.ordenes*') ? 'rotate-180' : '' }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Submenu Dropdown -->
                <div id="ordenesSubmenu" 
                     class="overflow-hidden transition-all duration-300 {{ request()->routeIs('admin.ordenes*') ? 'max-h-40' : 'max-h-0' }}">
                    <div class="ml-6 mt-1 space-y-1">
                        <a href="{{ route('admin.ordenes') }}"
                            class="flex items-center gap-2 px-3 py-2 text-sm transition-all duration-200 rounded-lg
                                   {{ request()->routeIs('admin.ordenes.panel') ? 'text-blue-600 bg-white/10' : 'text-blue-100 hover:bg-blue-700/30' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                      d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                            </svg>
                            <span>Panel de Ordenes</span>
                        </a>
                        <a href="{{ route('admin.ordenes') }}"
                            class="flex items-center gap-2 px-3 py-2 text-sm transition-all duration-200 rounded-lg
                                   {{ request()->routeIs('admin.ordenes.capturar') ? 'text-blue-600 bg-white/10' : 'text-blue-100 hover:bg-blue-700/30' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                      d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Capturar Orden</span>
                        </a>
                    </div>
                </div>

                @if (request()->routeIs('admin.ordenes*'))
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

            <!-- Menús -->
            <div class="relative">
                <a href="{{ route('admin.menus') }}"
                    class="nav-link relative flex items-center gap-2.5 px-3 py-3 transition-all duration-300 group z-20
                          {{ request()->routeIs('admin.menus') ? 'text-blue-600' : 'text-blue-100 hover:bg-blue-700/50 rounded-xl' }}">
                    <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <span class="font-medium text-sm relative z-10">Menús</span>
                </a>
                @if (request()->routeIs('admin.menus'))
                    <div
                        class="absolute -right-3 top-0 bottom-0 w-[calc(100%+12px)] bg-gray-50 rounded-tl-[40px] rounded-bl-[40px] pointer-events-none">
                    </div>
                @endif
            </div>

        </nav>

        <!-- Footer del sidebar -->
        <div class="p-4 border-t border-white/10">
            <div class="bg-blue-700/40 rounded-xl p-3 text-center backdrop-blur-sm">
                <p class="text-blue-100 text-xs font-medium">Versión 1.0.0</p>
            </div>
        </div>
    </aside>
</div>

@push('script')
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
                    link.addEventListener('click', (e) => {
                        // No cerrar si es el dropdown de órdenes
                        if (link.id === 'ordenesDropdown') {
                            return;
                        }
                        if (window.innerWidth < 1024) {
                            sidebar.classList.add('-translate-x-full');
                            overlay.classList.add('hidden');
                        }
                    });
                });
            }

            // Toggle del dropdown de Ordenes
            const ordenesDropdown = document.getElementById('ordenesDropdown');
            const ordenesSubmenu = document.getElementById('ordenesSubmenu');
            const ordenesChevron = document.getElementById('ordenesChevron');

            if (ordenesDropdown && ordenesSubmenu && ordenesChevron) {
                ordenesDropdown.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    // Toggle submenu
                    const isOpen = ordenesSubmenu.classList.contains('max-h-40');
                    
                    if (isOpen) {
                        ordenesSubmenu.classList.remove('max-h-40');
                        ordenesSubmenu.classList.add('max-h-0');
                        ordenesChevron.classList.remove('rotate-180');
                    } else {
                        ordenesSubmenu.classList.remove('max-h-0');
                        ordenesSubmenu.classList.add('max-h-40');
                        ordenesChevron.classList.add('rotate-180');
                    }
                });
            }
        });
    </script>
@endpush
