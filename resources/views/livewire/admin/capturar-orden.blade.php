<div class="min-h-screen bg-gray-50 pb-32 lg:pb-0">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Registrar Compra</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Notificaciones -->
    <div x-data="{ show: false, tipo: 'exito', mensaje: '' }"
        @mostrar-toast.window="
            tipo = $event.detail.tipo;
            mensaje = $event.detail.mensaje;
            show = true;
            setTimeout(() => show = false, 3000);
        "
        x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed top-20 right-6 px-6 py-4 rounded-2xl shadow-xl z-50 max-w-md"
        :class="tipo === 'exito' ? 'bg-linear-to-r from-green-500 to-emerald-500 text-white' :
            'bg-linear-to-r from-red-500 to-pink-500 text-white'"
        style="display: none;">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path x-show="tipo === 'exito'" fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
                <path x-show="tipo === 'error'" fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd" />
            </svg>
            <span class="font-medium text-sm" x-text="mensaje"></span>
        </div>
    </div>

    @if (!empty($productosAgrupados))
        <div class="max-w-7xl mx-auto">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8 lg:px-6 lg:py-8">
                <!-- Lista de productos por categoría -->
                <div class="lg:col-span-8 space-y-6 px-4 py-4 lg:px-0">
                    <!-- Búsqueda -->
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" id="busquedaProductos" placeholder="Buscar productos..."
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- Categorías y productos -->
                    <div id="contenedorCategorias">
                        @foreach ($productosAgrupados as $categoria => $items)
                            <div class="categoria-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6"
                                data-categoria="{{ strtolower($categoria) }}">
                                <!-- Título de categoría -->
                                <div class="bg-linear-to-r from-blue-50 to-cyan-50 px-6 py-4 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900">{{ $categoria }}</h2>
                                    <p class="text-sm text-gray-600">{{ count($items) }}
                                        producto{{ count($items) !== 1 ? 's' : '' }}</p>
                                </div>

                                <!-- Lista de productos -->
                                <div class="divide-y divide-gray-100">
                                    @foreach ($items as $producto)
                                        @php
                                            $estaSeleccionado = isset(
                                                $productosSeleccionados[$producto['id_producto']],
                                            );
                                            $cantidadSeleccionada = $estaSeleccionado
                                                ? $productosSeleccionados[$producto['id_producto']]['cantidad']
                                                : 0;
                                        @endphp

                                        <div class="producto-item p-4 hover:bg-gray-50 transition-colors {{ $estaSeleccionado ? 'bg-blue-50' : '' }}"
                                            data-nombre="{{ strtolower($producto['nombre'] ?? '') }}"
                                            data-descripcion="{{ strtolower($producto['descripcion'] ?? '') }}"
                                            data-id="{{ $producto['id_producto'] }}">
                                            <div class="flex gap-4">
                                                <!-- Imagen -->
                                                <div class="relative shrink-0">
                                                    <img src="{{ $producto['imagen_url'] }}"
                                                        alt="{{ $producto['nombre'] ?? 'Producto' }}"
                                                        class="w-24 h-24 rounded-xl object-cover bg-gray-100">
                                                    @if ($estaSeleccionado)
                                                        <div
                                                            class="absolute -top-2 -right-2 bg-blue-600 text-white rounded-full w-7 h-7 flex items-center justify-center text-xs font-bold shadow-lg">
                                                            {{ $cantidadSeleccionada }}
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Info -->
                                                <div class="flex-1 min-w-0">
                                                    <h3 class="font-semibold text-gray-900 mb-1">
                                                        {{ $producto['nombre'] ?? 'Sin nombre' }}</h3>
                                                    <p class="text-sm text-gray-500 mb-2 line-clamp-2">
                                                        {{ $producto['descripcion'] ?? 'Sin descripción' }}
                                                    </p>

                                                    <div class="flex items-center justify-between gap-4 flex-wrap">
                                                        <span class="text-xl font-bold text-gray-900">
                                                            ${{ number_format($producto['precio'] ?? 0, 2) }}
                                                        </span>

                                                        @if ($estaSeleccionado)
                                                            <!-- Controles de cantidad -->
                                                            <div
                                                                class="flex items-center gap-2 bg-white rounded-xl px-2 py-1.5 border-2 border-blue-500 shadow-sm">
                                                                <button
                                                                    wire:click="decrementarCantidad({{ $producto['id_producto'] }})"
                                                                    wire:loading.attr="disabled"
                                                                    wire:target="decrementarCantidad({{ $producto['id_producto'] }})"
                                                                    class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded-lg transition disabled:opacity-50">
                                                                    <svg class="w-4 h-4 text-gray-700" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2.5"
                                                                            d="M20 12H4" />
                                                                    </svg>
                                                                </button>

                                                                <span
                                                                    class="font-semibold text-gray-900 min-w-8 text-center text-lg">
                                                                    {{ $cantidadSeleccionada }}
                                                                </span>

                                                                <button
                                                                    wire:click="incrementarCantidad({{ $producto['id_producto'] }})"
                                                                    wire:loading.attr="disabled"
                                                                    wire:target="incrementarCantidad({{ $producto['id_producto'] }})"
                                                                    class="w-8 h-8 flex items-center justify-center bg-blue-600 hover:bg-blue-700 rounded-lg transition disabled:opacity-50">
                                                                    <svg class="w-4 h-4 text-white" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2.5"
                                                                            d="M12 4v16m8-8H4" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        @else
                                                            <!-- Botón agregar -->
                                                            <button
                                                                wire:click="toggleProducto({{ $producto['id_producto'] }})"
                                                                wire:loading.attr="disabled"
                                                                wire:target="toggleProducto({{ $producto['id_producto'] }})"
                                                                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-semibold shadow-sm disabled:opacity-50">
                                                                <span wire:loading.remove
                                                                    wire:target="toggleProducto({{ $producto['id_producto'] }})">
                                                                    Agregar
                                                                </span>
                                                                <span wire:loading
                                                                    wire:target="toggleProducto({{ $producto['id_producto'] }})"
                                                                    class="flex items-center gap-2">
                                                                    <svg class="animate-spin w-4 h-4" fill="none"
                                                                        viewBox="0 0 24 24">
                                                                        <circle class="opacity-25" cx="12"
                                                                            cy="12" r="10"
                                                                            stroke="currentColor" stroke-width="4">
                                                                        </circle>
                                                                        <path class="opacity-75" fill="currentColor"
                                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                                        </path>
                                                                    </svg>
                                                                    Agregando...
                                                                </span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Sin resultados -->
                    <div id="sinResultados"
                        class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No se encontraron productos</h3>
                        <p class="text-gray-500">Intenta con otra búsqueda</p>
                    </div>
                </div>

                <!-- Resumen del pedido -->
                <div class="lg:col-span-4" x-data="{ expandido: false }">
                    <!-- Desktop - Sidebar sticky -->
                    <div
                        class="hidden lg:block bg-white rounded-2xl p-6 shadow-lg border border-gray-100 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Resumen del Pedido</h2>

                        @if (!empty($productosSeleccionados))
                            <!-- Productos seleccionados -->
                            <div class="space-y-3 mb-6 max-h-96 overflow-y-auto pr-2">
                                @foreach ($productosSeleccionados as $idProducto => $item)
                                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex-1 pr-2">
                                                <p class="font-medium text-sm text-gray-900">{{ $item['nombre'] }}</p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    {{ $item['cantidad'] }} ×
                                                    ${{ number_format($item['precio_unitario'], 2) }}
                                                </p>
                                            </div>
                                            <button wire:click="quitarProducto({{ $idProducto }})"
                                                class="text-red-500 hover:text-red-700 hover:bg-red-50 p-1 rounded transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-sm font-bold text-gray-900">
                                            ${{ number_format($item['precio_unitario'] * $item['cantidad'], 2) }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>

                            @error('productosSeleccionados')
                                <div class="bg-red-50 border border-red-200 rounded-xl p-3 mb-4">
                                    <p class="text-sm text-red-800">{{ $message }}</p>
                                </div>
                            @enderror

                            <!-- Total -->
                            <div class="border-t border-gray-200 pt-4 mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">
                                        Subtotal ({{ count($productosSeleccionados) }}
                                        producto{{ count($productosSeleccionados) !== 1 ? 's' : '' }})
                                    </span>
                                    <span
                                        class="text-sm font-medium text-gray-900">${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-base font-semibold text-gray-900">Total</span>
                                    <span
                                        class="text-2xl font-bold bg-linear-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                                        ${{ number_format($total, 2) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="space-y-2">
                                <button wire:click="capturarOrden" wire:loading.attr="disabled"
                                    wire:target="capturarOrden"
                                    class="w-full bg-linear-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed text-white py-3.5 rounded-xl font-semibold transition-all">
                                    <span wire:loading.remove wire:target="capturarOrden">Capturar Orden</span>
                                    <span wire:loading wire:target="capturarOrden"
                                        class="flex items-center justify-center gap-2">
                                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Procesando...
                                    </span>
                                </button>

                                <button wire:click="limpiarSeleccion" wire:loading.attr="disabled"
                                    class="w-full bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-colors disabled:opacity-50">
                                    Limpiar Todo
                                </button>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="text-sm text-gray-500 font-medium">No hay productos seleccionados</p>
                                <p class="text-xs text-gray-400 mt-1">Agrega productos para comenzar</p>
                            </div>
                        @endif
                    </div>

                    <!-- Móvil - Resumen fijo abajo -->
                    <div
                        class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-2xl z-30 rounded-t-3xl safe-area-bottom">
                        <div class="p-4 pb-6">
                            @if (!empty($productosSeleccionados))
                                <button @click="expandido = !expandido"
                                    class="w-full flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-600">Total</span>
                                        <span
                                            class="text-xl font-bold bg-linear-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                                            ${{ number_format($total, 2) }}
                                        </span>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-600 transition-transform"
                                        :class="expandido ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="expandido" x-transition style="display: none;">
                                    <div class="space-y-2 mb-3 max-h-60 overflow-y-auto">
                                        @foreach ($productosSeleccionados as $idProducto => $item)
                                            <div
                                                class="bg-gray-50 p-2 rounded-lg text-xs flex justify-between items-center">
                                                <div class="flex-1">
                                                    <p class="font-medium text-gray-900">{{ $item['nombre'] }}</p>
                                                    <p class="text-gray-500">{{ $item['cantidad'] }} ×
                                                        ${{ number_format($item['precio_unitario'], 2) }}</p>
                                                </div>
                                                <span
                                                    class="font-bold text-gray-900">${{ number_format($item['precio_unitario'] * $item['cantidad'], 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <button wire:click="capturarOrden" wire:loading.attr="disabled"
                                        wire:target="capturarOrden"
                                        class="w-full bg-linear-to-r from-green-500 to-emerald-500 hover:shadow-lg text-white py-3.5 rounded-xl font-semibold transition-all disabled:opacity-50">
                                        <span wire:loading.remove wire:target="capturarOrden">Capturar Orden</span>
                                        <span wire:loading wire:target="capturarOrden">Procesando...</span>
                                    </button>
                                    <button wire:click="limpiarSeleccion"
                                        class="w-full bg-gray-200 text-gray-700 py-2.5 rounded-xl font-medium hover:bg-gray-300 transition-colors">
                                        Limpiar
                                    </button>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-sm text-gray-500">No hay productos seleccionados</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Sin productos -->
        <div class="max-w-md mx-auto pt-20 px-4">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-8 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay productos disponibles</h3>
                <p class="text-sm text-gray-500">No hay productos activos para capturar órdenes en este momento</p>
            </div>
        </div>
    @endif

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Función para normalizar texto (eliminar acentos)
                function normalizeText(text) {
                    return text.toLowerCase()
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '');
                }

                const busquedaInput = document.getElementById('busquedaProductos');
                const sinResultados = document.getElementById('sinResultados');
                const contenedorCategorias = document.getElementById('contenedorCategorias');

                if (busquedaInput) {
                    busquedaInput.addEventListener('input', function(e) {
                        const busqueda = normalizeText(e.target.value.trim());
                        const categorias = document.querySelectorAll('.categoria-card');
                        let totalVisibles = 0;

                        categorias.forEach(categoria => {
                            const productos = categoria.querySelectorAll('.producto-item');
                            let productosVisibles = 0;

                            productos.forEach(producto => {
                                const nombre = normalizeText(producto.dataset.nombre || '');
                                const descripcion = normalizeText(producto.dataset
                                    .descripcion || '');

                                if (busqueda === '' || nombre.includes(busqueda) || descripcion
                                    .includes(busqueda)) {
                                    producto.style.display = '';
                                    productosVisibles++;
                                } else {
                                    producto.style.display = 'none';
                                }
                            });

                            if (productosVisibles > 0) {
                                categoria.style.display = '';
                                totalVisibles++;
                            } else {
                                categoria.style.display = 'none';
                            }
                        });

                        // Mostrar/ocultar mensaje de sin resultados
                        if (contenedorCategorias) {
                            contenedorCategorias.style.display = totalVisibles > 0 ? '' : 'none';
                        }

                        if (sinResultados) {
                            sinResultados.classList.toggle('hidden', totalVisibles > 0 || busqueda === '');
                        }
                    });
                }
            });
        </script>
    @endpush
</div>
