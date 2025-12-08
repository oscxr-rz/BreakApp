<nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[600px] md:max-w-[700px] lg:max-w-[900px] xl:max-w-[1100px] bg-slate-700 rounded-t-3xl px-5 py-3 shadow-[0_-4px_20px_rgba(0,0,0,0.15)] z-50">
    <div class="flex items-center justify-around">
        
        <!-- Menú Principal -->
        <a href="{{ route('index') }}" 
           class="group flex flex-col items-center justify-center min-w-[70px] lg:min-w-[90px] px-3 lg:px-4 py-2 rounded-xl transition-all duration-300 {{ request()->routeIs('menu-diario') ? 'text-white bg-white/10' : 'text-slate-400' }} hover:bg-white/5">
            
            @if(request()->routeIs('index'))
                <svg class="w-7 h-7 lg:w-8 lg:h-8 mb-1" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            @else
                <svg class="w-7 h-7 lg:w-8 lg:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            @endif
            
            <span class="text-[11px] lg:text-xs font-medium mt-0.5">Menú</span>
        </a>

        <!-- Carrito -->
        <a href="{{ route('carrito') }}" 
           class="group flex flex-col items-center justify-center min-w-[70px] lg:min-w-[90px] px-3 lg:px-4 py-2 rounded-xl transition-all duration-300 relative {{ request()->routeIs('carrito') ? 'text-white bg-white/10' : 'text-slate-400' }} hover:bg-white/5">
            
            @if(request()->routeIs('carrito'))
                <svg class="w-7 h-7 lg:w-8 lg:h-8 mb-1" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            @else
                <svg class="w-7 h-7 lg:w-8 lg:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            @endif
            
            <span class="text-[11px] lg:text-xs font-medium mt-0.5">Carrito</span>
        </a>

        <!-- Tarjeta Local -->
        <a href="{{ route('tarjeta.local') }}" 
           class="group flex flex-col items-center justify-center min-w-[70px] lg:min-w-[90px] px-3 lg:px-4 py-2 rounded-xl transition-all duration-300 {{ request()->routeIs('tarjeta.local') ? 'text-white bg-white/10' : 'text-slate-400' }} hover:bg-white/5">
            
            @if(request()->routeIs('tarjeta.local'))
                <svg class="w-7 h-7 lg:w-8 lg:h-8 mb-1" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            @else
                <svg class="w-7 h-7 lg:w-8 lg:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            @endif
            
            <span class="text-[11px] lg:text-xs font-medium mt-0.5">Tarjeta</span>
        </a>

        <!-- Órdenes -->
        <a href="{{ route('ordenes') }}" 
           class="group flex flex-col items-center justify-center min-w-[70px] lg:min-w-[90px] px-3 lg:px-4 py-2 rounded-xl transition-all duration-300 {{ request()->routeIs('ordenes') ? 'text-white bg-white/10' : 'text-slate-400' }} hover:bg-white/5">
            
            @if(request()->routeIs('ordenes'))
                <svg class="w-7 h-7 lg:w-8 lg:h-8 mb-1" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            @else
                <svg class="w-7 h-7 lg:w-8 lg:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            @endif
            
            <span class="text-[11px] lg:text-xs font-medium mt-0.5">Órdenes</span>
        </a>

    </div>
</nav>