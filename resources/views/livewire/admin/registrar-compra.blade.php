<div class="min-h-screen bg-gray-50 pb-32 lg:pb-0">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Capturar Orden</h1>
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
        <div class="max-w-7xl mx-auto px-4 lg:px-6 py-6">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <!-- Lista de productos -->
                <div class="lg:col-span-8 space-y-6">
                    <!-- Barra de Búsqueda -->
                    <div class="relative">
                        <input type="text" placeholder="Buscar productos..." id="buscarInput"
                            class="w-full bg-white rounded-xl px-4 py-3 pl-11 text-sm border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Botones de Categorías -->
                    <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                        <button data-categoria=""
                            class="boton-categoria shrink-0 px-4 py-2 rounded-full bg-blue-600 text-white text-sm font-medium transition-all">
                            Todas
                        </button>
                        @foreach ($productosAgrupados as $categoria => $productos)
                            <button data-categoria="{{ strtolower($categoria) }}"
                                class="boton-categoria shrink-0 px-4 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition-all">
                                {{ $categoria }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Grid de Productos por Categoría -->
                    <div id="contenedorProductos">
                        @foreach ($productosAgrupados as $categoria => $productos)
                            <section class="seccion-categoria mb-8" data-categoria="{{ strtolower($categoria) }}">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="font-bold text-lg text-gray-900">{{ $categoria }}</h2>
                                    <span class="text-sm text-gray-500">{{ count($productos) }}
                                        producto{{ count($productos) !== 1 ? 's' : '' }}</span>
                                </div>

                                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($productos as $producto)
                                        @php
                                            $estaSeleccionado = isset(
                                                $productosSeleccionados[$producto['id_producto']],
                                            );
                                            $cantidadSeleccionada = $estaSeleccionado
                                                ? $productosSeleccionados[$producto['id_producto']]['cantidad']
                                                : 0;
                                        @endphp

                                        <div class="tarjeta-producto bg-white rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300 {{ $estaSeleccionado ? 'ring-2 ring-blue-500' : '' }}"
                                            data-nombre="{{ strtolower($producto['nombre'] ?? '') }}"
                                            data-descripcion="{{ strtolower($producto['descripcion'] ?? '') }}"
                                            data-categoria="{{ strtolower($categoria) }}">

                                            <!-- Imagen -->
                                            <div class="relative">
                                                <img src="{{ $producto['imagen_url'] }}"
                                                    alt="{{ $producto['nombre'] }}"
                                                    class="w-full h-44 lg:h-52 object-cover">

                                                @if ($estaSeleccionado)
                                                    <div
                                                        class="absolute top-3 right-3 bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold shadow-lg">
                                                        {{ $cantidadSeleccionada }}
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Info -->
                                            <div class="p-4">
                                                <h3 class="font-bold text-base mb-1 text-gray-900">
                                                    {{ $producto['nombre'] ?? 'Sin nombre' }}
                                                </h3>
                                                <p class="text-xs text-gray-500 mb-3 line-clamp-2">
                                                    {{ $producto['descripcion'] ?? 'Sin descripción' }}
                                                </p>

                                                <!-- Tiempo y Cantidad -->
                                                <div class="flex items-center justify-between mb-3">
                                                    <div class="flex items-center gap-1.5 text-gray-500">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <span
                                                            class="text-xs">{{ $producto['tiempo_preparacion'] ?? 'N/A' }}</span>
                                                    </div>

                                                    <span
                                                        class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-lg">
                                                        {{ $producto['cantidad_disponible'] ?? 0 }} disp.
                                                    </span>
                                                </div>

                                                <!-- Precio y Botón -->
                                                <div class="flex items-center justify-between gap-2">
                                                    <div>
                                                        <p class="text-xs text-gray-500">Precio</p>
                                                        <p class="font-bold text-xl text-gray-900">
                                                            ${{ number_format($producto['precio'] ?? 0, 2) }}
                                                        </p>
                                                    </div>

                                                    @if ($estaSeleccionado)
                                                        <!-- Controles de cantidad -->
                                                        <div
                                                            class="flex items-center gap-1 bg-blue-50 rounded-lg px-1.5 py-1 border border-blue-200">
                                                            <button
                                                                wire:click="decrementarCantidad({{ $producto['id_producto'] }})"
                                                                wire:loading.attr="disabled"
                                                                class="w-7 h-7 flex items-center justify-center hover:bg-blue-100 rounded transition">
                                                                <svg class="w-4 h-4 text-blue-600" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2.5" d="M20 12H4" />
                                                                </svg>
                                                            </button>

                                                            <span
                                                                class="font-semibold text-blue-600 min-w-6 text-center">
                                                                {{ $cantidadSeleccionada }}
                                                            </span>

                                                            <button
                                                                wire:click="incrementarCantidad({{ $producto['id_producto'] }})"
                                                                wire:loading.attr="disabled"
                                                                class="w-7 h-7 flex items-center justify-center bg-blue-600 hover:bg-blue-700 rounded transition">
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
                                                            wire:click="toggleProducto({{ $producto['id_producto'] }}, '{{ $categoria }}')"
                                                            wire:loading.attr="disabled"
                                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg font-semibold transition-all text-sm shadow-sm disabled:opacity-50 flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                                </path>
                                                            </svg>
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

                    <!-- Sin resultados -->
                    <div id="sinResultados" class="hidden flex-col items-center justify-center py-20">
                        <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No se encontraron productos</h3>
                        <p class="text-sm text-gray-500">Intenta con otra búsqueda o categoría</p>
                    </div>
                </div>

                <!-- Resumen de compra -->
                <div class="lg:col-span-4" x-data="{ expandido: false }">
                    <!-- Desktop - Sidebar sticky -->
                    <div
                        class="hidden lg:block bg-white rounded-2xl p-6 shadow-lg border border-gray-100 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Resumen de Compra</h2>

                        <!-- Campos de cliente y pago -->
                        <div class="space-y-4 mb-6">
                            <!-- Nombre del cliente -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Cliente</label>
                                <input type="text" wire:model.live="nombreCliente"
                                    placeholder="Ingresa el nombre..."
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('nombreCliente')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Monto pagado -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Con cuánto paga</label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-medium">$</span>
                                    <input type="number" step="0.01" wire:model.live="montoPagado"
                                        placeholder="0.00"
                                        class="w-full pl-8 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                @error('montoPagado')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        @if (!empty($productosSeleccionados))
                            <!-- Productos seleccionados -->
                            <div class="space-y-3 mb-6 max-h-64 overflow-y-auto pr-2">
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

                            <!-- Total y cambio -->
                            <div class="border-t border-gray-200 pt-4 mb-4 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">
                                        Subtotal ({{ count($productosSeleccionados) }}
                                        producto{{ count($productosSeleccionados) !== 1 ? 's' : '' }})
                                    </span>
                                    <span
                                        class="text-sm font-medium text-gray-900">${{ number_format($total, 2) }}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-base font-semibold text-gray-900">Total</span>
                                    <span class="text-2xl font-bold text-blue-600">
                                        ${{ number_format($total, 2) }}
                                    </span>
                                </div>

                                @if ($montoPagado > 0)
                                    <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                        <span class="text-base font-semibold text-gray-900">Cambio</span>
                                        <span
                                            class="text-2xl font-bold {{ $cambio >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            ${{ number_format($cambio, 2) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Botones -->
                            <div class="space-y-2">
                                <button wire:click="registrarCompra" wire:loading.attr="disabled"
                                    wire:target="registrarCompra"
                                    class="w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed text-white py-3.5 rounded-xl font-semibold transition-all">
                                    <span wire:loading.remove wire:target="registrarCompra">Registrar Compra</span>
                                    <span wire:loading wire:target="registrarCompra"
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

                                <button wire:click="limpiarFormulario" wire:loading.attr="disabled"
                                    class="w-full bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-colors disabled:opacity-50">
                                    Limpiar Todo
                                </button>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <p class="text-sm text-gray-500 font-medium">No hay productos seleccionados</p>
                                <p class="text-xs text-gray-400 mt-1">Agrega productos para comenzar</p>
                            </div>
                        @endif
                    </div>

                    <!-- Móvil - Resumen fijo abajo -->
                    <div
                        class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-2xl z-30 rounded-t-3xl">
                        <div class="p-4 pb-6">
                            @if (!empty($productosSeleccionados))
                                <button @click="expandido = !expandido"
                                    class="w-full flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-600">Total</span>
                                        <span class="text-xl font-bold text-blue-600">
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

                                <div x-show="expandido" x-transition style="display: none;" class="mb-3">
                                    <!-- Campos móvil -->
                                    <div class="space-y-3 mb-3">
                                        <input type="text" wire:model.live="nombreCliente"
                                            placeholder="Nombre del cliente"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm">

                                        <div class="relative">
                                            <span
                                                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                            <input type="number" step="0.01" wire:model.live="montoPagado"
                                                placeholder="Con cuánto paga"
                                                class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg text-sm">
                                        </div>

                                        @if ($montoPagado > 0)
                                            <div class="flex justify-between items-center p-2 bg-green-50 rounded-lg">
                                                <span class="text-sm font-medium text-gray-700">Cambio:</span>
                                                <span
                                                    class="text-lg font-bold {{ $cambio >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                    ${{ number_format($cambio, 2) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Productos -->
                                    <div class="space-y-2 max-h-48 overflow-y-auto">
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
                                    <button wire:click="registrarCompra" wire:loading.attr="disabled"
                                        wire:target="registrarCompra"
                                        class="w-full bg-gradient-to-r from-green-500 to-emerald-500 hover:shadow-lg text-white py-3.5 rounded-xl font-semibold transition-all disabled:opacity-50">
                                        <span wire:loading.remove wire:target="registrarCompra">Registrar Compra</span>
                                        <span wire:loading wire:target="registrarCompra">Procesando...</span>
                                    </button>
                                    <button wire:click="limpiarFormulario"
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
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No hay menú disponible</h3>
                <p class="text-sm text-gray-500">No hay productos en el menú del día para registrar compras</p>
            </div>
        </div>
    @endif

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function normalizeText(text) {
                    return text.toLowerCase()
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '');
                }

                const buscarInput = document.getElementById('buscarInput');
                const sinResultados = document.getElementById('sinResultados');
                const contenedorProductos = document.getElementById('contenedorProductos');

                function filtrarProductos(terminoBusqueda) {
                    const secciones = document.querySelectorAll('.seccion-categoria');
                    let hayResultados = false;

                    secciones.forEach(seccion => {
                        const productos = seccion.querySelectorAll('.tarjeta-producto');
                        let hayProductosVisibles = false;

                        productos.forEach(producto => {
                            const nombre = normalizeText(producto.dataset.nombre || '');
                            const descripcion = normalizeText(producto.dataset.descripcion || '');
                            const categoriaProducto = normalizeText(producto.dataset.categoria || '');
                            const coincide = !terminoBusqueda || nombre.includes(terminoBusqueda) ||
                                descripcion
                                .includes(terminoBusqueda) || categoriaProducto.includes(
                                    terminoBusqueda);

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

                    if (contenedorProductos) {
                        contenedorProductos.style.display = hayResultados ? 'block' : 'none';
                    }

                    if (sinResultados) {
                        sinResultados.style.display = hayResultados ? 'none' : 'flex';
                    }
                }

                function filtrarPorCategoria(categoria) {
                    document.querySelectorAll('.boton-categoria').forEach(boton => {
                        const categoriaBoton = boton.getAttribute('data-categoria');
                        if (categoriaBoton === categoria) {
                            boton.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
                            boton.classList.add('bg-blue-600', 'text-white');
                        } else {
                            boton.classList.add('bg-gray-100', 'hover:bg-gray-200', 'text-gray-700');
                            boton.classList.remove('bg-blue-600', 'text-white');
                        }
                    });
                    filtrarProductos(categoria);
                }

                if (buscarInput) {
                    buscarInput.addEventListener('input', function(e) {
                        filtrarProductos(normalizeText(e.target.value.trim()));
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
</div>
