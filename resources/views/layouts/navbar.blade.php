<nav
    class="fixed bottom-0 left-0 right-0 w-full bg-linear-to-r from-[#951327]/95 via-[#b50001]/95 to-[#951327]/95 backdrop-blur-xl rounded-t-3xl lg:rounded-t-4xl px-4 lg:px-10 xl:px-12 py-3 lg:py-4 xl:py-5 border-t border-x border-[#fcc88a]/10 z-50">
    <div class="max-w-[1400px] mx-auto flex items-center justify-around gap-1 lg:gap-4">

        <!-- Menú Principal -->
        <a href="{{ route('index') }}"
            class="group flex flex-col lg:flex-row items-center justify-center gap-0.5 lg:gap-2 w-16 h-12 lg:w-auto lg:h-10 xl:h-11 lg:px-4 xl:px-5 rounded-xl lg:rounded-full transition-all duration-300 {{ request()->routeIs('index') ? 'bg-white shadow-lg scale-105' : 'hover:bg-white/10 hover:scale-105' }}">

            @if (request()->routeIs('index'))
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#951327] transition-all duration-300" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-semibold text-[#951327] lg:block hidden transition-all duration-300">Inicio</span>
            @else
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#f2cc88] group-hover:text-white group-hover:scale-110 transition-all duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-medium text-[#f2cc88] group-hover:text-white group-hover:font-semibold lg:block hidden transition-all duration-300">Inicio</span>
            @endif
        </a>

        <!-- Tarjeta Local -->
        <a href="{{ route('tarjeta.local') }}"
            class="group flex flex-col lg:flex-row items-center justify-center gap-0.5 lg:gap-2 w-16 h-12 lg:w-auto lg:h-10 xl:h-11 lg:px-4 xl:px-5 rounded-xl lg:rounded-full transition-all duration-300 {{ request()->routeIs('tarjeta.local') ? 'bg-white shadow-lg scale-105' : 'hover:bg-white/10 hover:scale-105' }}">

            @if (request()->routeIs('tarjeta.local'))
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#951327] transition-all duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <rect x="2" y="6" width="20" height="12" rx="2" />
                    <path d="M2 10h20M7 14h.01M11 14h2" />
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-semibold text-[#951327] lg:block hidden transition-all duration-300">Tarjeta</span>
            @else
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#f2cc88] group-hover:text-white group-hover:scale-110 transition-all duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <rect x="2" y="6" width="20" height="12" rx="2" />
                    <path d="M2 10h20M7 14h.01M11 14h2" />
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-medium text-[#f2cc88] group-hover:text-white group-hover:font-semibold lg:block hidden transition-all duration-300">Tarjeta</span>
            @endif
        </a>

        <!-- Órdenes -->
        <a href="{{ route('ordenes') }}"
            class="group flex flex-col lg:flex-row items-center justify-center gap-0.5 lg:gap-2 w-16 h-12 lg:w-auto lg:h-10 xl:h-11 lg:px-4 xl:px-5 rounded-xl lg:rounded-full transition-all duration-300 {{ request()->routeIs('ordenes') ? 'bg-white shadow-lg scale-105' : 'hover:bg-white/10 hover:scale-105' }}">

            @if (request()->routeIs('ordenes'))
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#951327] transition-all duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    <path d="M9 12h6M9 16h6" />
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-semibold text-[#951327] lg:block hidden transition-all duration-300">Órdenes</span>
            @else
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#f2cc88] group-hover:text-white group-hover:scale-110 transition-all duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    <path d="M9 12h6M9 16h6" />
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-medium text-[#f2cc88] group-hover:text-white group-hover:font-semibold lg:block hidden transition-all duration-300">Órdenes</span>
            @endif
        </a>

        <!-- Perfil -->
        <a href="{{ route('cuenta') }}"
            class="group flex flex-col lg:flex-row items-center justify-center gap-0.5 lg:gap-2 w-16 h-12 lg:w-auto lg:h-10 xl:h-11 lg:px-4 xl:px-5 rounded-xl lg:rounded-full transition-all duration-300 {{ request()->routeIs('cuenta') ? 'bg-white shadow-lg scale-105' : 'hover:bg-white/10 hover:scale-105' }}">

            @if (request()->routeIs('cuenta'))
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#951327] transition-all duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-semibold text-[#951327] lg:block hidden transition-all duration-300">Cuenta</span>
            @else
                <svg class="w-5 h-5 lg:w-5 lg:h-5 xl:w-6 xl:h-6 text-[#f2cc88] group-hover:text-white group-hover:scale-110 transition-all duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span
                    class="text-[9px] lg:text-sm xl:text-base font-medium text-[#f2cc88] group-hover:text-white group-hover:font-semibold lg:block hidden transition-all duration-300">Cuenta</span>
            @endif
        </a>
    </div>
</nav>
