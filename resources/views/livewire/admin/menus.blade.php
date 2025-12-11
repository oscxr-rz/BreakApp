<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Header con búsqueda -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Menús</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ count($menus) }} menú{{ count($menus) !== 1 ? 's' : '' }}
                        registrado{{ count($menus) !== 1 ? 's' : '' }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Botón crear menú -->
                    <button wire:click="abrirModalCrear"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="hidden sm:inline">Nuevo Menú</span>
                    </button>
                </div>
            </div>

            <!-- Barra de búsqueda -->
            <div class="mt-4">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="busquedaMenu" placeholder="Buscar menús por fecha o productos..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>
    </div>

    <!-- Notificaciones -->
    <div x-data="{
        show: false,
        tipo: 'exito',
        mensaje: ''
    }"
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
        class="fixed top-6 right-6 px-6 py-4 rounded-2xl shadow-xl z-50 transform transition-all duration-300"
        :class="tipo === 'exito'
            ?
            'bg-gradient-to-r from-green-500 to-emerald-500 text-white' :
            'bg-gradient-to-r from-red-500 to-pink-500 text-white'"
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

    <!-- Contenido principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (!empty($menus))
            <!-- Menú de Hoy (si existe) -->
            @php
                $hoy = now()->format('Y-m-d');
                $menuHoy = collect($menus)->first(function ($menu) use ($hoy) {
                    return $menu['fecha'] === $hoy;
                });
            @endphp

            @if ($menuHoy)
                <div class="mb-8" id="menu-hoy">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-white/20 p-3 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold">Menú de Hoy</h2>
                                    <p class="text-blue-100 text-sm" x-data
                                        x-text="new Date('{{ $menuHoy['fecha'] }}').toLocaleDateString('es-ES', {
                                        weekday: 'long',
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric'
                                    })">
                                    </p>
                                </div>
                            </div>
                            <button
                                wire:click="abrirModalEditar({{ $menuHoy['id_menu'] }}, '{{ $menuHoy['fecha'] }}', {{ json_encode(collect($menuHoy['productos'])->flatten(1)->map(function ($p) {return ['id_producto' => $p['id_producto'], 'cantidad_disponible' => $p['cantidad_disponible']];})->values()) }})"
                                class="px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition-colors font-medium">
                                Editar Menú
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($menuHoy['productos'] as $categoria => $productos)
                                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                                    <h3 class="font-semibold mb-3 flex items-center gap-2">
                                        <span class="w-2 h-2 bg-white rounded-full"></span>
                                        {{ $categoria }}
                                    </h3>
                                    <ul class="space-y-2">
                                        @foreach ($productos as $producto)
                                            <li class="text-sm text-blue-50 flex justify-between items-center">
                                                <span>{{ $producto['nombre'] }}</span>
                                                <span
                                                    class="bg-white/20 px-2 py-0.5 rounded text-xs">{{ $producto['cantidad_disponible'] }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="mb-8" id="alerta-sin-menu-hoy">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-yellow-800">No hay menú para hoy</h3>
                                <p class="text-sm text-yellow-700 mt-1">Crea un menú para la fecha de hoy</p>
                            </div>
                            <button wire:click="abrirModalCrear"
                                class="ml-auto px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors text-sm font-medium">
                                Crear Menú de Hoy
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Lista de todos los menús -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Todos los Menús</h2>
                <p class="text-sm text-gray-500 mt-1">Gestiona los menús programados</p>
            </div>

            <div class="space-y-4">
                @foreach ($menus as $menu)
                    @php
                        $fechaMenu = \DateTime::createFromFormat('Y-m-d', $menu['fecha']);
                        $fechaHoy = new \DateTime();
                        $esFuturo = $fechaMenu > $fechaHoy;
                        $esHoy = $menu['fecha'] === $hoy;
                    @endphp
                    <div class="menu-card bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow"
                        data-fecha="{{ $menu['fecha'] }}"
                        data-productos="{{ collect($menu['productos'])->flatten(1)->pluck('nombre')->map(function ($n) {return strtolower($n);})->implode('|') }}">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="bg-blue-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900" x-data
                                            x-text="new Date('{{ $menu['fecha'] }}').toLocaleDateString('es-ES', {
                                                weekday: 'long',
                                                year: 'numeric',
                                                month: 'long',
                                                day: 'numeric'
                                            })">
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            @php
                                                $totalProductos = collect($menu['productos'])->flatten(1)->count();
                                            @endphp
                                            {{ $totalProductos }} producto{{ $totalProductos !== 1 ? 's' : '' }}
                                        </p>
                                    </div>
                                    @if ($esHoy)
                                        <span
                                            class="px-2.5 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                            Hoy
                                        </span>
                                    @elseif ($esFuturo)
                                        <span
                                            class="px-2.5 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                            Próximo
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                            Pasado
                                        </span>
                                    @endif
                                </div>

                                <button
                                    wire:click="abrirModalEditar({{ $menu['id_menu'] }}, '{{ $menu['fecha'] }}', {{ json_encode(collect($menu['productos'])->flatten(1)->map(function ($p) {return ['id_producto' => $p['id_producto'], 'cantidad_disponible' => $p['cantidad_disponible']];})->values()) }})"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($menu['productos'] as $categoria => $productos)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <h4 class="font-medium text-gray-900 mb-2 flex items-center gap-2">
                                            <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                                            {{ $categoria }}
                                        </h4>
                                        <ul class="space-y-2">
                                            @foreach ($productos as $producto)
                                                <li class="text-sm text-gray-600 flex justify-between items-center">
                                                    <span>{{ $producto['nombre'] }}</span>
                                                    <span
                                                        class="bg-white px-2 py-0.5 rounded text-xs font-medium">{{ $producto['cantidad_disponible'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Mensaje sin resultados -->
            <div id="sin-resultados"
                class="hidden bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No se encontraron menús</h3>
                <p class="text-gray-500">Intenta con otra búsqueda</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay menús disponibles</h3>
                <p class="text-gray-500 mb-4">Comienza creando tu primer menú del día</p>
                <button wire:click="abrirModalCrear"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nuevo Menú
                </button>
            </div>
        @endif
    </div>

    <!-- Modal Crear Menú -->
    @if ($modalCrearAbierto)
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-4"
            wire:click="cerrarModalCrear">
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col"
                wire:click.stop x-data="{
                    busqueda: '',
                    productosSeleccionados: @entangle('crear_productos').live,
                    productos: {{ json_encode($productos) }},
                    init() {
                        console.log('Total productos disponibles:', this.productos.length);
                        console.log('Productos:', this.productos);
                    }
                }">
                <div class="bg-white border-b border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-gray-900">Nuevo Menú</h3>
                        <button type="button" wire:click="cerrarModalCrear"
                            class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Fecha -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha del Menú</label>
                        <input type="date" wire:model="crear_fecha"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('crear_fecha')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Búsqueda de productos -->
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" x-model="busqueda" placeholder="Buscar productos..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <form wire:submit.prevent="crearMenu" x-data="{ submitting: false }" @submit="submitting = true"
                    class="flex flex-col flex-1 overflow-hidden">
                    <div class="flex-1 overflow-y-auto p-6">
                        <!-- Productos seleccionados -->
                        <div class="mb-6" x-show="productosSeleccionados.length > 0">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">
                                Productos Seleccionados (<span x-text="productosSeleccionados.length"></span>)
                            </h4>
                            <div class="bg-blue-50 rounded-lg p-4 space-y-2">
                                <template x-for="(prod, index) in productosSeleccionados" :key="prod.id_producto">
                                    <div class="flex items-center justify-between bg-white rounded-lg p-3">
                                        <div class="flex-1">
                                            <span class="text-sm font-medium text-gray-900"
                                                x-text="productos.find(p => p.id_producto == prod.id_producto)?.nombre || 'Producto no encontrado'"></span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center gap-2">
                                                <label class="text-xs text-gray-500">Cantidad:</label>
                                                <input type="number" x-model.number="prod.cantidad_disponible"
                                                    min="0"
                                                    class="w-20 px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <button type="button" @click="productosSeleccionados.splice(index, 1)"
                                                class="text-red-600 hover:bg-red-50 p-1 rounded">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            @error('crear_productos')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                            @error('crear_productos.*')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                            @error('crear_productos.*.cantidad_disponible')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Lista de productos disponibles -->
                        <h4 class="text-sm font-medium text-gray-900 mb-3">
                            Productos Disponibles
                            <span class="text-xs text-gray-500"
                                x-text="'(' + productos.filter(p => 
                            busqueda === '' || 
                            p.nombre.toLowerCase().includes(busqueda.toLowerCase()) ||
                            p.descripcion.toLowerCase().includes(busqueda.toLowerCase())
                        ).length + ')'"></span>
                        </h4>
                        <div class="space-y-4">
                            <template
                                x-for="producto in productos.filter(p => 
                            busqueda === '' || 
                            p.nombre.toLowerCase().includes(busqueda.toLowerCase()) ||
                            p.descripcion.toLowerCase().includes(busqueda.toLowerCase())
                        )"
                                :key="producto.id_producto">
                                <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors"
                                    :class="productosSeleccionados.find(p => p.id_producto == producto.id_producto) ?
                                        'ring-2 ring-blue-500' : ''">
                                    <div class="flex items-center gap-4">
                                        <div class="shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-gray-200">
                                            <img :src="producto.imagen_url || '/placeholder.jpg'" :alt="producto.nombre"
                                                class="w-full h-full object-cover"
                                                onerror="this.src='/placeholder.jpg'">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h5 class="font-medium text-gray-900 truncate" x-text="producto.nombre">
                                            </h5>
                                            <p class="text-sm text-gray-600 line-clamp-1"
                                                x-text="producto.descripcion"></p>
                                            <div class="flex items-center gap-3 mt-1">
                                                <span class="text-sm font-semibold text-green-600">
                                                    $<span x-text="parseFloat(producto.precio).toFixed(2)"></span>
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    <span x-text="producto.tiempo_preparacion"></span> min
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            @click="if (!productosSeleccionados.find(p => p.id_producto == producto.id_producto)) {
                                            productosSeleccionados.push({ id_producto: producto.id_producto, cantidad_disponible: 10 })
                                        } else {
                                            productosSeleccionados = productosSeleccionados.filter(p => p.id_producto != producto.id_producto)
                                        }"
                                            class="px-4 py-2 rounded-lg font-medium transition-colors shrink-0"
                                            :class="productosSeleccionados.find(p => p.id_producto == producto.id_producto) ?
                                                'bg-red-100 text-red-700 hover:bg-red-200' :
                                                'bg-blue-600 text-white hover:bg-blue-700'">
                                            <span
                                                x-text="productosSeleccionados.find(p => p.id_producto == producto.id_producto) ? 'Quitar' : 'Agregar'"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="bg-white border-t border-gray-200 p-6">
                        <div class="flex gap-3">
                            <button type="button" wire:click="cerrarModalCrear"
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancelar
                            </button>
                            <button type="submit" :disabled="submitting"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!submitting">Crear Menú</span>
                                <span x-show="submitting" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Creando...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Editar Menú -->
    @if ($modalEditarAbierto)
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-4"
            wire:click="cerrarModalEditar">
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col"
                wire:click.stop x-data="{
                    busqueda: '',
                    productosSeleccionados: @entangle('editar_productos').live,
                    productos: {{ json_encode($productos) }},
                    init() {
                        console.log('Total productos disponibles:', this.productos.length);
                        console.log('Productos seleccionados:', this.productosSeleccionados);
                    }
                }">
                <div class="bg-white border-b border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-gray-900">Editar Menú</h3>
                        <button type="button" wire:click="cerrarModalEditar"
                            class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Fecha -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha del Menú</label>
                        <input type="date" wire:model="editar_fecha"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('editar_fecha')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Búsqueda de productos -->
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" x-model="busqueda" placeholder="Buscar productos..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <form wire:submit.prevent="actualizarMenu" x-data="{ submitting: false }" @submit="submitting = true"
                    class="flex flex-col flex-1 overflow-hidden">
                    <div class="flex-1 overflow-y-auto p-6">
                        <!-- Productos seleccionados -->
                        <div class="mb-6" x-show="productosSeleccionados.length > 0">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">
                                Productos Seleccionados (<span x-text="productosSeleccionados.length"></span>)
                            </h4>
                            <div class="bg-blue-50 rounded-lg p-4 space-y-2">
                                <template x-for="(prod, index) in productosSeleccionados" :key="prod.id_producto">
                                    <div class="flex items-center justify-between bg-white rounded-lg p-3">
                                        <div class="flex-1">
                                            <span class="text-sm font-medium text-gray-900"
                                                x-text="productos.find(p => p.id_producto == prod.id_producto)?.nombre || 'Producto no encontrado'"></span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center gap-2">
                                                <label class="text-xs text-gray-500">Cantidad:</label>
                                                <input type="number" x-model.number="prod.cantidad_disponible"
                                                    min="0"
                                                    class="w-20 px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <button type="button" @click="productosSeleccionados.splice(index, 1)"
                                                class="text-red-600 hover:bg-red-50 p-1 rounded">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            @error('editar_productos')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                            @error('editar_productos.*')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                            @error('editar_productos.*.cantidad_disponible')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Lista de productos disponibles -->
                        <h4 class="text-sm font-medium text-gray-900 mb-3">
                            Productos Disponibles
                            <span class="text-xs text-gray-500"
                                x-text="'(' + productos.filter(p => 
                            busqueda === '' || 
                            p.nombre.toLowerCase().includes(busqueda.toLowerCase()) ||
                            p.descripcion.toLowerCase().includes(busqueda.toLowerCase())
                        ).length + ')'"></span>
                        </h4>
                        <div class="space-y-4">
                            <template
                                x-for="producto in productos.filter(p => 
                            busqueda === '' || 
                            p.nombre.toLowerCase().includes(busqueda.toLowerCase()) ||
                            p.descripcion.toLowerCase().includes(busqueda.toLowerCase())
                        )"
                                :key="producto.id_producto">
                                <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors"
                                    :class="productosSeleccionados.find(p => p.id_producto == producto.id_producto) ?
                                        'ring-2 ring-blue-500' : ''">
                                    <div class="flex items-center gap-4">
                                        <div class="shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-gray-200">
                                            <img :src="producto.imagen_url || '/placeholder.jpg'"
                                                :alt="producto.nombre" class="w-full h-full object-cover"
                                                onerror="this.src='/placeholder.jpg'">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h5 class="font-medium text-gray-900 truncate" x-text="producto.nombre">
                                            </h5>
                                            <p class="text-sm text-gray-600 line-clamp-1"
                                                x-text="producto.descripcion"></p>
                                            <div class="flex items-center gap-3 mt-1">
                                                <span class="text-sm font-semibold text-green-600">
                                                    $<span x-text="parseFloat(producto.precio).toFixed(2)"></span>
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    <span x-text="producto.tiempo_preparacion"></span> min
                                                </span>
                                            </div>
                                        </div>
                                        <button type="button"
                                            @click="if (!productosSeleccionados.find(p => p.id_producto == producto.id_producto)) {
                                            productosSeleccionados.push({ id_producto: producto.id_producto, cantidad_disponible: 10 })
                                        } else {
                                            productosSeleccionados = productosSeleccionados.filter(p => p.id_producto != producto.id_producto)
                                        }"
                                            class="px-4 py-2 rounded-lg font-medium transition-colors shrink-0"
                                            :class="productosSeleccionados.find(p => p.id_producto == producto.id_producto) ?
                                                'bg-red-100 text-red-700 hover:bg-red-200' :
                                                'bg-blue-600 text-white hover:bg-blue-700'">
                                            <span
                                                x-text="productosSeleccionados.find(p => p.id_producto == producto.id_producto) ? 'Quitar' : 'Agregar'"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="bg-white border-t border-gray-200 p-6">
                        <div class="flex gap-3">
                            <button type="button" wire:click="cerrarModalEditar"
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancelar
                            </button>
                            <button type="submit" :disabled="submitting"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!submitting">Guardar Cambios</span>
                                <span x-show="submitting" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Guardando...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @script
        <script>
            Echo.channel('admin')
                .listen('.ActualizarMenu', (e) => {
                    $wire.cargarMenus();
                });
        </script>
    @endscript

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const busquedaInput = document.getElementById('busquedaMenu');
                const sinResultados = document.getElementById('sin-resultados');

                if (busquedaInput) {
                    busquedaInput.addEventListener('input', function(e) {
                        const busqueda = e.target.value.toLowerCase();
                        const cards = document.querySelectorAll('.menu-card');
                        let visibles = 0;

                        cards.forEach(card => {
                            const fecha = card.dataset.fecha;
                            const productos = card.dataset.productos;

                            const fechaObj = new Date(fecha);
                            const fechaFormateada = fechaObj.toLocaleDateString('es-ES', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            }).toLowerCase();

                            if (fechaFormateada.includes(busqueda) ||
                                productos.includes(busqueda) ||
                                fecha.includes(busqueda)) {
                                card.style.display = '';
                                visibles++;
                            } else {
                                card.style.display = 'none';
                            }
                        });

                        if (sinResultados) {
                            if (visibles === 0 && busqueda !== '') {
                                sinResultados.classList.remove('hidden');
                            } else {
                                sinResultados.classList.add('hidden');
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</div>
