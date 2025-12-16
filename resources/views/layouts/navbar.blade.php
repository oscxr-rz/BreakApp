<nav
    class="fixed bottom-0 left-0 right-0 w-full bg-white backdrop-blur-xl rounded-t-3xl lg:rounded-t-4xl px-4 lg:px-10 xl:px-12 py-3 lg:py-4 xl:py-5 border-t border-x border-gray-400 z-40">
    <div class="max-w-[1400px] mx-auto flex items-center justify-around gap-1 lg:gap-4">

        <!-- Menú Principal -->
        <a href="{{ route('index') }}"
            class="group relative flex flex-col lg:flex-row items-center justify-center gap-1 lg:gap-2 w-20 h-14 lg:w-auto lg:h-12 xl:h-13 lg:px-5 xl:px-6 transition-all duration-300">

            <!-- Barra indicadora superior -->
            <div
                class="absolute -top-3 lg:-top-4 xl:-top-5 left-1/2 -translate-x-1/2 h-1 rounded-full transition-all duration-300 {{ request()->routeIs('index') ? 'w-12 lg:w-16 bg-linear-to-r from-red-500 to-red-600' : 'w-0 bg-transparent' }}">
            </div>

            <svg class="w-6 h-6 lg:w-6 lg:h-6 xl:w-7 xl:h-7 transition-all duration-300 {{ request()->routeIs('index') ? 'text-red-500' : 'text-gray-400' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>

            <span
                class="text-[10px] lg:text-xs xl:text-sm font-medium transition-all duration-300 {{ request()->routeIs('index') ? 'text-red-500' : 'text-gray-500' }}">
                Inicio
            </span>
        </a>

        <!-- Tarjeta Local -->
        <a href="{{ route('tarjeta.local') }}"
            class="group relative flex flex-col lg:flex-row items-center justify-center gap-1 lg:gap-2 w-20 h-14 lg:w-auto lg:h-12 xl:h-13 lg:px-5 xl:px-6 transition-all duration-300">

            <!-- Barra indicadora superior -->
            <div
                class="absolute -top-3 lg:-top-4 xl:-top-5 left-1/2 -translate-x-1/2 h-1 rounded-full transition-all duration-300 {{ request()->routeIs('tarjeta.local') ? 'w-12 lg:w-16 bg-linear-to-r from-red-500 to-red-600' : 'w-0 bg-transparent' }}">
            </div>

            <svg class="w-6 h-6 lg:w-6 lg:h-6 xl:w-7 xl:h-7 transition-all duration-300 {{ request()->routeIs('tarjeta.local') ? 'text-red-500' : 'text-gray-400' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <rect x="2" y="6" width="20" height="12" rx="2" />
                <path d="M2 10h20M7 14h.01M11 14h2" />
            </svg>

            <span
                class="text-[10px] lg:text-xs xl:text-sm font-medium transition-all duration-300 {{ request()->routeIs('tarjeta.local') ? 'text-red-500' : 'text-gray-500' }}">
                Tarjeta
            </span>
        </a>

        <!-- Ordenes -->
        <a href="{{ route('ordenes') }}"
            class="group relative flex flex-col lg:flex-row items-center justify-center gap-1 lg:gap-2 w-20 h-14 lg:w-auto lg:h-12 xl:h-13 lg:px-5 xl:px-6 transition-all duration-300">

            <!-- Barra indicadora superior -->
            <div
                class="absolute -top-3 lg:-top-4 xl:-top-5 left-1/2 -translate-x-1/2 h-1 rounded-full transition-all duration-300 {{ request()->routeIs('ordenes') ? 'w-12 lg:w-16 bg-linear-to-r from-red-500 to-red-600' : 'w-0 bg-transparent' }}">
            </div>

            <svg class="w-6 h-6 lg:w-6 lg:h-6 xl:w-7 xl:h-7 transition-all duration-300 {{ request()->routeIs('ordenes') ? 'text-red-500' : 'text-gray-400' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                <path d="M9 12h6M9 16h6" />
            </svg>

            <span
                class="text-[10px] lg:text-xs xl:text-sm font-medium transition-all duration-300 {{ request()->routeIs('ordenes') ? 'text-red-500' : 'text-gray-500' }}">
                Ordenes
            </span>
        </a>

        <!-- Perfil -->
        <a href="{{ route('cuenta') }}"
            class="group relative flex flex-col lg:flex-row items-center justify-center gap-1 lg:gap-2 w-20 h-14 lg:w-auto lg:h-12 xl:h-13 lg:px-5 xl:px-6 transition-all duration-300">

            <!-- Barra indicadora superior -->
            <div
                class="absolute -top-3 lg:-top-4 xl:-top-5 left-1/2 -translate-x-1/2 h-1 rounded-full transition-all duration-300 {{ request()->routeIs('cuenta') ? 'w-12 lg:w-16 bg-linear-to-r from-red-500 to-red-600' : 'w-0 bg-transparent' }}">
            </div>

            <svg class="w-6 h-6 lg:w-6 lg:h-6 xl:w-7 xl:h-7 transition-all duration-300 {{ request()->routeIs('cuenta') ? 'text-red-500' : 'text-gray-400' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>

            <span
                class="text-[10px] lg:text-xs xl:text-sm font-medium transition-all duration-300 {{ request()->routeIs('cuenta') ? 'text-red-500' : 'text-gray-500' }}">
                Cuenta
            </span>
        </a>
    </div>
</nav>
