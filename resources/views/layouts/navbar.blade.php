<nav
    class="fixed bottom-2 left-1/2 -translate-x-1/2 w-[92%] max-w-[380px] md:max-w-[500px] lg:max-w-[700px] xl:max-w-[800px] bg-linear-to-r from-[#951327]/95 via-[#b50001]/95 to-[#951327]/95 backdrop-blur-xl rounded-full px-4 lg:px-10 xl:px-12 py-2.5 lg:py-3 xl:py-4 shadow-[0_10px_40px_rgba(149,19,39,0.35)] border border-[#fcc88a]/10 z-50">
    <div class="flex items-center justify-around gap-1 lg:gap-4">

        <!-- Menú Principal -->
        <a href="{{ route('index') }}"
            class="group flex flex-col lg:flex-row items-center justify-center gap-0.5 lg:gap-2 w-16 h-12 lg:w-auto lg:h-10 xl:h-11 lg:px-4 xl:px-5 rounded-xl lg:rounded-full transition-all duration-300 {{ request()->routeIs('index') ? 'bg-white shadow-lg scale-105' : 'hover:bg-white/10' }}">

            @if (request()->routeIs('index'))
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#951327]" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-semibold text-[#951327] lg:block hidden">Inicio</span>
            @else
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#f2cc88] group-hover:text-white transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-medium text-[#f2cc88] group-hover:text-white transition-colors lg:block hidden">Inicio</span>
            @endif
        </a>

        <!-- Tarjeta Local -->
        <a href="{{ route('tarjeta.local') }}"
            class="group flex flex-col lg:flex-row items-center justify-center gap-0.5 lg:gap-2 w-16 h-12 lg:w-auto lg:h-10 xl:h-11 lg:px-4 xl:px-5 rounded-xl lg:rounded-full transition-all duration-300 {{ request()->routeIs('tarjeta.local') ? 'bg-white shadow-lg scale-105' : 'hover:bg-white/10' }}">

            @if (request()->routeIs('tarjeta.local'))
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#951327]" fill="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                    </path>
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-semibold text-[#951327] lg:block hidden">Tarjeta</span>
            @else
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#f2cc88] group-hover:text-white transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                    </path>
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-medium text-[#f2cc88] group-hover:text-white transition-colors lg:block hidden">Tarjeta</span>
            @endif
        </a>

        <!-- Órdenes -->
        <a href="{{ route('ordenes') }}"
            class="group flex flex-col lg:flex-row items-center justify-center gap-0.5 lg:gap-2 w-16 h-12 lg:w-auto lg:h-10 xl:h-11 lg:px-4 xl:px-5 rounded-xl lg:rounded-full transition-all duration-300 {{ request()->routeIs('ordenes') ? 'bg-white shadow-lg scale-105' : 'hover:bg-white/10' }}">

            @if (request()->routeIs('ordenes'))
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#951327]" fill="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-semibold text-[#951327] lg:block hidden">Órdenes</span>
            @else
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#f2cc88] group-hover:text-white transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-medium text-[#f2cc88] group-hover:text-white transition-colors lg:block hidden">Órdenes</span>
            @endif
        </a>

        <!-- Perfil -->
        <a href="{{ route('cuenta') }}"
            class="group flex flex-col lg:flex-row items-center justify-center gap-0.5 lg:gap-2 w-16 h-12 lg:w-auto lg:h-10 xl:h-11 lg:px-4 xl:px-5 rounded-xl lg:rounded-full transition-all duration-300 {{ request()->routeIs('cuenta') ? 'bg-white shadow-lg scale-105' : 'hover:bg-white/10' }}">

            @if (request()->routeIs('cuenta'))
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#951327]" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-semibold text-[#951327] lg:block hidden">Cuenta</span>
            @else
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#f2cc88] group-hover:text-white transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-medium text-[#f2cc88] group-hover:text-white transition-colors lg:block hidden">Cuenta</span>
            @endif
        </a>
    </div>
</nav>
