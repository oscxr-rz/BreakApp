<nav
    class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-[400px] md:max-w-[500px] lg:max-w-[600px] bg-black/90 backdrop-blur-lg rounded-full px-6 lg:px-8 py-4 lg:py-5 shadow-[0_8px_30px_rgba(0,0,0,0.4)] z-50">
    <div class="flex items-center justify-around">

        <!-- Menú Principal -->
        <a href="{{ route('index') }}"
            class="group flex items-center justify-center w-11 h-11 lg:w-14 lg:h-14 rounded-full transition-all duration-300 {{ request()->routeIs('index') ? 'bg-white text-black' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">

            @if (request()->routeIs('index'))
                <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            @else
                <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            @endif
        </a>

        <!-- Carrito -->
        <a href="{{ route('carrito') }}"
            class="group flex items-center justify-center w-11 h-11 lg:w-14 lg:h-14 rounded-full transition-all duration-300 {{ request()->routeIs('carrito') ? 'bg-white text-black' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">

            @if (request()->routeIs('carrito'))
                <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            @else
                <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            @endif
        </a>

        <!-- Tarjeta Local -->
        <a href="{{ route('tarjeta.local') }}"
            class="group flex items-center justify-center w-11 h-11 lg:w-14 lg:h-14 rounded-full transition-all duration-300 {{ request()->routeIs('tarjeta.local') ? 'bg-white text-black' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">

            @if (request()->routeIs('tarjeta.local'))
                <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                    </path>
                </svg>
            @else
                <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                    </path>
                </svg>
            @endif
        </a>

        <!-- Órdenes -->
        <a href="{{ route('ordenes') }}"
            class="group flex items-center justify-center w-11 h-11 lg:w-14 lg:h-14 rounded-full transition-all duration-300 {{ request()->routeIs('ordenes') ? 'bg-white text-black' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">

            @if (request()->routeIs('ordenes'))
                <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
            @else
                <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
            @endif
        </a>

    </div>
</nav>
