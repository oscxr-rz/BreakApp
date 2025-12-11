<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Header con búsqueda -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Productos</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        @php
                            $totalProductos = 0;
                            foreach ($productos as $items) {
                                $totalProductos += count($items);
                            }
                        @endphp
                        {{ $totalProductos }} productos encontrados
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Barra de búsqueda -->
                    <div class="relative flex-1 sm:w-80">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" id="busquedaProducto" placeholder="Buscar productos..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Botón crear producto -->
                    <button wire:click="abrirModalCrear"
                        class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="hidden sm:inline">Nuevo Producto</span>
                    </button>
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
            'bg-linear-to-r from-green-500 to-emerald-500 text-white' :
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

    <!-- Contenido principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (!empty($productos))
            @foreach ($productos as $categoria => $items)
                <div class="mb-8">
                    <!-- Título de categoría -->
                    <div class="flex items-center gap-3 mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $categoria }}</h2>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                            {{ count($items) }} producto{{ count($items) !== 1 ? 's' : '' }}
                        </span>
                    </div>

                    <!-- Tabla de productos -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Producto</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                            Descripción</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                            Precio</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden xl:table-cell">
                                            Tiempo</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estado</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($items as $producto)
                                        <tr class="producto-row hover:bg-gray-50 transition-colors"
                                            data-nombre="{{ strtolower($producto['nombre']) }}"
                                            data-descripcion="{{ strtolower($producto['descripcion']) }}"
                                            data-categoria="{{ strtolower($categoria) }}">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="shrink-0 w-12 h-12 rounded-lg overflow-hidden bg-gray-100">
                                                        @if (!empty($producto['imagen']))
                                                            <img src="{{ asset('storage/' . $producto['imagen']) }}"
                                                                alt="{{ $producto['nombre'] }}"
                                                                class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center">
                                                                <svg class="w-6 h-6 text-gray-400" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-900">{{ $producto['nombre'] }}
                                                        </div>
                                                        <div class="text-sm text-gray-500 lg:hidden">
                                                            {{ Str::limit($producto['descripcion'], 50) }}
                                                        </div>
                                                        <div class="md:hidden mt-1 space-y-1">
                                                            <div class="text-sm font-medium text-green-600">
                                                                ${{ number_format($producto['precio'], 2) }}
                                                            </div>
                                                            <div class="flex items-center gap-1 text-xs text-gray-500">
                                                                <svg class="w-3 h-3" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                {{ $producto['tiempo_preparacion'] }} min
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 hidden lg:table-cell max-w-xs">
                                                <div class="line-clamp-2">{{ $producto['descripcion'] }}</div>
                                            </td>
                                            <td class="px-6 py-4 hidden md:table-cell">
                                                <span class="text-sm font-semibold text-green-600">
                                                    ${{ number_format($producto['precio'], 2) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 hidden xl:table-cell">
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ $producto['tiempo_preparacion'] }} min
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($producto['activo'] === 1)
                                                    <span
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                                        <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                                                        Activo
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                                        <span class="w-1.5 h-1.5 bg-gray-600 rounded-full"></span>
                                                        Inactivo
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <button
                                                        wire:click="abrirModalEditar({{ $producto['id_producto'] }}, {{ $producto['id_categoria'] }}, '{{ str_replace("'", "\'", $producto['nombre']) }}', '{{ str_replace("'", "\'", $producto['descripcion']) }}', {{ $producto['precio'] }}, {{ $producto['tiempo_preparacion'] }})"
                                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                        title="Editar">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>

                                                    <div x-data="{ loading: false }"
                                                        wire:key="btn-estado-{{ $producto['id_producto'] }}">
                                                        <button
                                                            @click="loading = true; $wire.cambiarEstado({{ $producto['id_producto'] }}, {{ $producto['activo'] === 1 ? 0 : 1 }}).then(() => loading = false)"
                                                            :disabled="loading"
                                                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                                            title="{{ $producto['activo'] === 1 ? 'Desactivar' : 'Activar' }}">
                                                            <span x-show="!loading">
                                                                @if ($producto['activo'] === 1)
                                                                    <svg class="w-4 h-4 text-red-600" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                                        stroke-width="2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                                    </svg>
                                                                @else
                                                                    <svg class="w-4 h-4 text-green-600" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                                        stroke-width="2">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                @endif
                                                            </span>
                                                            <svg x-show="loading"
                                                                class="w-4 h-4 text-gray-600 animate-spin"
                                                                fill="none" viewBox="0 0 24 24">
                                                                <circle class="opacity-25" cx="12"
                                                                    cy="12" r="10" stroke="currentColor"
                                                                    stroke-width="4"></circle>
                                                                <path class="opacity-75" fill="currentColor"
                                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay productos disponibles</h3>
                <p class="text-gray-500 mb-4">Comienza creando tu primer producto</p>
                <button wire:click="abrirModalCrear"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nuevo Producto
                </button>
            </div>
        @endif
    </div>

    <!-- Modal Crear Producto -->
    @if ($modalCrearAbierto)
        <div class="fixed inset-0 bg-white/30 backdrop-blur-md z-50 flex items-center justify-center p-4"
            wire:click="cerrarModalCrear">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto"
                wire:click.stop>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">Nuevo Producto</h3>
                    <button type="button" wire:click="cerrarModalCrear" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form wire:submit.prevent="crearProducto" x-data="{ submitting: false }" @submit="submitting = true">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                            <select wire:model="crear_idCategoria"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Seleccione una categoría...</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria['id_categoria'] }}">{{ $categoria['nombre'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('crear_idCategoria')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div x-data="{ imagePreview: null }">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen del Producto</label>
                            <div class="flex items-center gap-4">
                                <label
                                    class="flex items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-400 cursor-pointer transition-colors relative overflow-hidden">
                                    <div class="text-center" x-show="!imagePreview">
                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm text-gray-500">Subir imagen</span>
                                        <span class="text-xs text-gray-400 block">JPG, PNG (máx. 4MB)</span>
                                    </div>
                                    <img x-show="imagePreview" :src="imagePreview"
                                        class="absolute inset-0 w-full h-full object-cover">
                                    <input type="file" wire:model="crear_imagen" accept="image/jpeg,image/png"
                                        class="hidden"
                                        @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); }">
                                </label>
                            </div>
                            @error('crear_imagen')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                                <input type="text" wire:model="crear_nombre"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ej: Hamburguesa Clásica">
                                @error('crear_nombre')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Precio ($)</label>
                                <input type="number" step="0.01" wire:model="crear_precio"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="0.00">
                                @error('crear_precio')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                            <textarea wire:model="crear_descripcion" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Describe el producto..."></textarea>
                            @error('crear_descripcion')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tiempo de Preparación
                                    (min)</label>
                                <input type="number" wire:model="crear_tiempoPreparacion"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="15">
                                @error('crear_tiempoPreparacion')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                                <select wire:model="crear_activo"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Seleccione...</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                                @error('crear_activo')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button type="button" wire:click="cerrarModalCrear"
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" :disabled="submitting"
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!submitting">Crear</span>
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
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Editar Producto -->
    @if ($modalEditarAbierto)
        <div class="fixed inset-0 bg-white/30 backdrop-blur-md z-50 flex items-center justify-center p-4"
            wire:click="cerrarModalEditar">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6 max-h-[90vh] overflow-y-auto"
                wire:click.stop>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">Editar Producto</h3>
                    <button type="button" wire:click="cerrarModalEditar" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form wire:submit.prevent="actualizarProducto" x-data="{ submitting: false }" @submit="submitting = true">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                            <select wire:model="editar_idCategoria"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Seleccione una categoría...</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria['id_categoria'] }}">{{ $categoria['nombre'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('editar_idCategoria')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div x-data="{ imagePreview: null }">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen del Producto
                                (opcional)</label>
                            <div class="flex items-center gap-4">
                                <label
                                    class="flex items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-400 cursor-pointer transition-colors relative overflow-hidden">
                                    <div class="text-center" x-show="!imagePreview">
                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm text-gray-500">Cambiar imagen</span>
                                        <span class="text-xs text-gray-400 block">JPG, PNG (máx. 4MB)</span>
                                    </div>
                                    <img x-show="imagePreview" :src="imagePreview"
                                        class="absolute inset-0 w-full h-full object-cover">
                                    <input type="file" wire:model="editar_imagen" accept="image/jpeg,image/png"
                                        class="hidden"
                                        @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => imagePreview = e.target.result; reader.readAsDataURL(file); }">
                                </label>
                            </div>
                            @error('editar_imagen')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                                <input type="text" wire:model="editar_nombre"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('editar_nombre')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Precio ($)</label>
                                <input type="number" step="0.01" wire:model="editar_precio"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('editar_precio')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                            <textarea wire:model="editar_descripcion" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            @error('editar_descripcion')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tiempo de Preparación
                                (min)</label>
                            <input type="number" wire:model="editar_tiempoPreparacion"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('editar_tiempoPreparacion')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button type="button" wire:click="cerrarModalEditar"
                            class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" :disabled="submitting"
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!submitting">Guardar</span>
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
                </form>
            </div>
        </div>
    @endif

    @script
        <script>
            Echo.channel('admin')
                .listen('.ActualizarProducto', (e) => {
                    $wire.cargarProductos();
                });
        </script>
    @endscript

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const busquedaInput = document.getElementById('busquedaProducto');
                if (busquedaInput) {
                    busquedaInput.addEventListener('input', function(e) {
                        const busqueda = e.target.value.toLowerCase();
                        const filas = document.querySelectorAll('.producto-row');

                        filas.forEach(fila => {
                            const nombre = fila.dataset.nombre;
                            const descripcion = fila.dataset.descripcion;
                            const categoria = fila.dataset.categoria;

                            if (nombre.includes(busqueda) || descripcion.includes(busqueda) || categoria
                                .includes(busqueda)) {
                                fila.style.display = '';
                            } else {
                                fila.style.display = 'none';
                            }
                        });
                    });
                }
            });
        </script>
    @endpush
</div>
