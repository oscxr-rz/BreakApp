<div class="w-full px-4 md:px-6 lg:px-8 py-6">
    <!-- Header Superior -->
    <header class="mb-4">
        <div class="flex items-center justify-between mb-4">
            <!-- Logo -->
            <div class="flex items-center gap-2 lg:gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-[#951327] rounded-full flex items-center justify-center">
                    <img src="{{ asset('storage/logo.jpg') }}" alt="Logo">
                </div>
                <span class="font-semibold text-lg lg:text-xl text-[#951327]">BreakApp</span>
            </div>

            <!-- Iconos Derecha -->
            <div class="flex items-center gap-2 lg:gap-3">
                <a href="{{ route('carrito') }}"
                    class="relative w-10 h-10 lg:w-11 lg:h-11 flex items-center justify-center hover:bg-[#fcc88a]/20 rounded-full transition-colors">
                    <svg class="w-6 h-6 lg:w-7 lg:h-7 text-[#951327]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </a>
                <!-- Icono de Notificaciones -->
                {{-- <a href="" class="w-10 h-10 lg:w-11 lg:h-11 flex items-center justify-center hover:bg-[#fcc88a]/20 rounded-full transition-colors">
                    <svg class="w-6 h-6 lg:w-7 lg:h-7 text-[#951327]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </a> --}}
            </div>
        </div>

        <!-- Fecha -->
        <div class="flex items-center gap-2 text-sm lg:text-base text-[#768e78] mb-4">
            <span>{{ $menu['fecha']  ?? ''}}</span>
        </div>

        <!-- Barra de Búsqueda -->
        <div class="relative">
            <input type="text" placeholder="Buscar productos..." id="buscarInput"
                class="w-full bg-[#f2cc88]/10 rounded-xl lg:rounded-2xl px-4 py-3 lg:py-3.5 pl-11 lg:pl-12 text-sm lg:text-base border-none focus:ring-2 focus:ring-[#ea5f3a] transition-all">
            <svg class="w-5 h-5 lg:w-6 lg:h-6 absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-[#768e78]"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </header>
    @if (!empty($menu))

        <!-- Sección de Categorías -->
        <section class="mb-6 lg:mb-8">
            <div
                class="flex gap-4 lg:gap-5 overflow-x-auto pb-2 scrollbar-hide -mx-4 px-4 md:-mx-6 md:px-6 lg:-mx-8 lg:px-8">
                <button data-categoria=""
                    class="boton-categoria shrink-0 px-4 py-2 rounded-full bg-[#951327] text-white text-sm lg:text-base font-medium transition-all">Todas</button>
                @foreach ($menu['productos'] as $categoria => $productos)
                    <button data-categoria="{{ strtolower($categoria) }}"
                        class="boton-categoria shrink-0 px-4 py-2 rounded-full bg-[#f2cc88]/30 hover:bg-[#fcc88a]/50 text-[#951327] text-sm lg:text-base font-medium transition-all">{{ $categoria }}</button>
                @endforeach
            </div>
        </section>

        <!-- Grid de Productos -->
        <div id="contenedorProductos">
            @foreach ($menu['productos'] as $categoria => $productos)
                <section class="seccion-categoria mb-8 lg:mb-10" data-categoria="{{ strtolower($categoria) }}">
                    <div class="flex items-center justify-between mb-4 lg:mb-5">
                        <h2 class="font-bold text-lg lg:text-xl text-[#951327]">{{ $categoria }}</h2>
                        <span class="text-sm lg:text-base text-[#768e78]">{{ count($productos) }} productos</span>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
                        @foreach ($productos as $producto)
                            <div class="tarjeta-producto bg-[#f2cc88]/5 rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                                data-nombre="{{ strtolower($producto['nombre']) }}"
                                data-descripcion="{{ strtolower($producto['descripcion']) }}"
                                data-categoria="{{ strtolower($categoria) }}">

                                <!-- Imagen -->
                                <div class="relative">
                                    <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}"
                                        class="w-full h-44 md:h-52 lg:h-64 object-cover">

                                    <!-- Botón Favorito -->
                                    {{-- <button class="absolute top-3 right-3 w-9 h-9 lg:w-10 lg:h-10 bg-white rounded-full flex items-center justify-center shadow-md hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 lg:w-6 lg:h-6 fill-none stroke-[#951327]" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button> --}}
                                </div>

                                <!-- Info -->
                                <div class="p-4 lg:p-5">
                                    <h3 class="font-bold text-base lg:text-lg mb-1 text-[#951327]">
                                        {{ $producto['nombre'] }}
                                    </h3>
                                    <p class="text-xs lg:text-sm text-[#768e78] mb-3 line-clamp-2">
                                        {{ $producto['descripcion'] }}
                                    </p>

                                    <!-- Tiempo y Cantidad Disponible -->
                                    <div class="flex items-center justify-between mb-3">
                                        <!-- Tiempo -->
                                        <div class="flex items-center gap-1.5 text-[#768e78]">
                                            <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span
                                                class="text-xs lg:text-sm">{{ $producto['tiempo_preparacion'] }}</span>
                                        </div>

                                        <!-- Cantidad Disponible -->
                                        <div class="flex items-center gap-1.5">
                                            <span
                                                class="text-xs lg:text-sm font-semibold text-[#768e78] bg-green-100 px-2 py-1 rounded-lg">
                                                {{ $producto['cantidad_disponible'] }} disponibles
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Precio y Botón -->
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="text-xs lg:text-sm text-[#768e78]">Precio</p>
                                            <p class="font-bold text-xl lg:text-2xl text-[#951327]">
                                                ${{ number_format($producto['precio'], 2) }}
                                            </p>
                                        </div>

                                        @if (session('id'))
                                            <button wire:click="agregarAlCarrito({{ $producto['id_producto'] }}, 1)"
                                            wire:loading.attr="disabled"
                                            class="bg-[#ea5f3a] hover:bg-[#951327] disabled:bg-[#768e78] text-white px-3 lg:px-4 py-2.5 lg:py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2 active:scale-95 text-sm lg:text-base shadow-md hover:shadow-lg"
                                            @if ($producto['cantidad_disponible'] <= 0) disabled @endif>
                                            <span wire:loading.remove
                                                wire:target="agregarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                                <svg class="w-5 h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <span wire:loading
                                                wire:target="agregarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                                <svg class="animate-spin w-5 h-5 lg:w-6 lg:h-6" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>

        <!-- Sin Resultados -->
        <div id="sinResultados" class="hidden flex-col items-center justify-center py-20 lg:py-32">
            <div class="w-32 h-32 lg:w-40 lg:h-40 bg-[#f2cc88]/20 rounded-full flex items-center justify-center mb-6">
                <svg class="w-16 h-16 lg:w-20 lg:h-20 text-[#768e78]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl lg:text-2xl font-bold text-[#951327] mb-2">No se encontraron productos</h3>
            <p class="text-sm lg:text-base text-[#768e78]">Intenta con otra búsqueda o categoría</p>
        </div>
    @else
        <!-- Estado Vacío -->
        <div class="flex flex-col items-center justify-center py-20 lg:py-32">
            <div class="w-32 h-32 lg:w-40 lg:h-40 bg-[#f2cc88]/20 rounded-full flex items-center justify-center mb-6">
                <svg class="w-16 h-16 lg:w-20 lg:h-20 text-[#768e78]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </div>
            <h3 class="text-xl lg:text-2xl font-bold text-[#951327] mb-2">No hay menú disponible</h3>
            <p class="text-sm lg:text-base text-[#768e78]">El menú del día aún no está listo. Vuelve pronto.</p>
        </div>
    @endif

    <!-- Mensaje -->
    <div x-data="{
        show: false,
        tipo: 'exito',
        mensaje: ''
    }"
        @mostrar-toast.window="
        tipo = $event.detail.tipo;
        mensaje = $event.detail.mensaje;
        show = true;
        setTimeout(() => show = false, 2000);
     "
        x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        :class="tipo === 'exito' ? 'bg-[#768e78]' : 'bg-[#e79897]'"
        class="fixed top-5 left-1/2 -translate-x-1/2 text-white px-5 py-3 rounded-2xl shadow-xl z-[9999] text-sm font-medium flex items-center gap-2.5 backdrop-blur-sm">

        <!-- Icono dinámico -->
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path x-show="tipo === 'exito'" fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd" />
            <path x-show="tipo === 'error'" fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                clip-rule="evenodd" />
        </svg>

        <span x-text="mensaje"></span>

        <button @click="show = false" class="ml-1 hover:bg-white/20 rounded-full p-1 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    @push('script')
        <script>
            window.filtrarPorCategoria = function(categoria) {
                document.getElementById('buscarInput').value = categoria;
                document.querySelectorAll('.boton-categoria').forEach(boton => {
                    const categoriaBoton = boton.getAttribute('data-categoria');
                    if (categoriaBoton === categoria) {
                        boton.classList.remove('bg-[#f2cc88]/30', 'hover:bg-[#fcc88a]/50', 'text-[#951327]');
                        boton.classList.add('bg-[#951327]', 'text-white');
                    } else {
                        boton.classList.add('bg-[#f2cc88]/30', 'hover:bg-[#fcc88a]/50', 'text-[#951327]');
                        boton.classList.remove('bg-[#951327]', 'text-white');
                    }
                });
                filtrarProductos(categoria);
            };

            window.filtrarProductos = function(terminoBusqueda) {
                const secciones = document.querySelectorAll('.seccion-categoria');
                let hayResultados = false;

                secciones.forEach(seccion => {
                    const productos = seccion.querySelectorAll('.tarjeta-producto');
                    let hayProductosVisibles = false;

                    productos.forEach(producto => {
                        const nombre = producto.getAttribute('data-nombre');
                        const descripcion = producto.getAttribute('data-descripcion');
                        const categoriaProducto = producto.getAttribute('data-categoria');
                        const coincide = !terminoBusqueda || nombre.includes(terminoBusqueda) || descripcion
                            .includes(terminoBusqueda) || categoriaProducto.includes(terminoBusqueda);

                        if (coincide) {
                            producto.style.display = 'block';
                            hayProductosVisibles = true;
                            hayResultados = true;
                        } else {
                            producto.style.display = 'none';
                        }
                    });

                    seccion.style.display = hayProductosVisibles ? 'block' : 'none';
                });

                document.getElementById('sinResultados').style.display = hayResultados ? 'none' : 'flex';
            };

            document.addEventListener('DOMContentLoaded', function() {
                const buscarInput = document.getElementById('buscarInput');
                if (buscarInput) {
                    buscarInput.addEventListener('input', function(e) {
                        filtrarProductos(e.target.value.toLowerCase());
                    });
                }

                document.querySelectorAll('.boton-categoria').forEach(boton => {
                    boton.addEventListener('click', function() {
                        filtrarPorCategoria(this.getAttribute('data-categoria'));
                    });
                });
            });
        </script>
    @endpush

    @script
        <script>
            Echo.channel('menu').listen('ActualizarMenu', (e) => {
                $wire.cargarMenu();
            });
        </script>
    @endscript
</div>
