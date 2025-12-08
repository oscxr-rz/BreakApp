<div class="min-h-screen bg-gray-50 pt-4 pb-48">
    @if (!session('id'))
        <!-- Sin sesión -->
        <div class="flex flex-col items-center justify-center py-20 px-4">
            <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Inicia sesión</h3>
            <p class="text-sm text-gray-600 mb-6">Necesitas iniciar sesión para ver tu carrito</p>
            <a href="{{ route('login') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                Iniciar Sesión
            </a>
        </div>
    @elseif (!empty($carrito['productos']))
        <!-- Carrito con productos -->
        <div class="max-w-7xl mx-auto px-4 py-6">

            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <!-- Lista de productos -->
                <div class="lg:col-span-8 space-y-4 mb-6 lg:mb-0">
                    @foreach ($carrito['productos'] as $categoria => $productos)
                        @foreach ($productos as $producto)
                            <div
                                class="bg-white rounded-xl p-4 shadow-sm {{ $producto['activoAhora'] === 1 && $producto['disponible'] ? '' : 'opacity-60' }}">
                                <div class="flex gap-4">
                                    <!-- Imagen -->
                                    <div class="relative shrink-0">
                                        <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}"
                                            class="w-24 h-24 rounded-lg object-cover">
                                        @if ($producto['activoAhora'] !== 1 || !$producto['disponible'])
                                            <div
                                                class="absolute inset-0 bg-black/60 rounded-lg flex items-center justify-center">
                                                <span class="text-white text-xs font-medium">No disponible</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Info -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-3 mb-2">
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-gray-900 mb-1">{{ $producto['nombre'] }}
                                                </h3>
                                                <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                                                    {{ $producto['descripcion'] }}</p>

                                                @if (isset($producto['cantidad_disponible']))
                                                    @if ($producto['cantidad_disponible'] > 0)
                                                        <span
                                                            class="inline-block text-xs text-green-700 bg-green-50 px-2 py-1 rounded-md">
                                                            {{ $producto['cantidad_disponible'] }} disponibles
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-block text-xs text-white bg-red-500 px-2 py-1 rounded-md">
                                                            Agotado
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>

                                            <!-- Botón eliminar -->
                                            <button wire:click="quitarDelCarrito({{ $producto['id_producto'] }})"
                                                class="text-gray-400 hover:text-red-600 transition p-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Precio y cantidad -->
                                        <div class="flex items-center justify-between mt-4">
                                            <span
                                                class="text-xl font-bold text-gray-900">${{ number_format($producto['precio_unitario'], 2) }}</span>

                                            <!-- Controles cantidad -->
                                            <div class="flex items-center gap-3 bg-gray-100 rounded-lg px-3 py-2">
                                                <button
                                                    wire:click="eliminarAlCarrito({{ $producto['id_producto'] }}, 1)"
                                                    class="w-8 h-8 flex items-center justify-center hover:bg-white rounded-md transition">
                                                    <svg class="w-4 h-4 text-gray-700" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                </button>

                                                <span
                                                    class="font-semibold text-gray-900 min-w-8 text-center">{{ $producto['cantidad'] }}</span>

                                                <button
                                                    wire:click="agregarAlCarrito({{ $producto['id_producto'] }}, 1)"
                                                    class="w-8 h-8 flex items-center justify-center bg-blue-600 hover:bg-blue-700 rounded-md transition">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>

                <!-- Resumen del pedido -->
                <div class="lg:col-span-4">
                    <!-- Desktop - Sidebar sticky -->
                    <div class="hidden lg:block bg-white rounded-xl p-6 shadow-sm sticky top-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Resumen</h2>

                        <!-- Método de pago -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Método de pago</label>
                            <select wire:model.live="metodo_pago"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="EFECTIVO">Efectivo</option>
                                <option value="SALDO">Tarjeta Local</option>
                            </select>
                        </div>

                        <!-- Hora de recogida -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hora de recogida</label>
                            <input type="time" wire:model.live="hora_recogida"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>

                        <!-- Saldo disponible -->
                        @if ($metodo_pago === 'SALDO')
                            <div class="bg-blue-50 rounded-lg p-3 mb-4">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-blue-900 font-medium">Saldo disponible</span>
                                    <span
                                        class="text-blue-900 font-bold">${{ number_format($saldoLocal['saldo'], 2) }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Alerta saldo insuficiente -->
                        @if ($saldoLocal['saldo'] < $total && $metodo_pago === 'SALDO')
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4 flex items-start gap-2">
                                <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-red-800">Saldo insuficiente</p>
                                    <p class="text-xs text-red-700 mt-0.5">Necesitas
                                        ${{ number_format($total - $saldoLocal['saldo'], 2) }} más</p>
                                </div>
                            </div>
                        @endif

                        <!-- Errores -->
                        @error('productos')
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                                <p class="text-sm text-red-800">{{ $message }}</p>
                            </div>
                        @enderror

                        <!-- Total -->
                        <div class="border-t border-gray-200 pt-4 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Subtotal
                                    ({{ collect($carrito['productos'])->flatten(1)->where('activoAhora', 1)->sum('cantidad') }}
                                    productos)</span>
                                <span class="text-sm font-medium text-gray-900">${{ $total }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-base font-semibold text-gray-900">Total</span>
                                <span class="text-2xl font-bold text-blue-600">${{ $total }}</span>
                            </div>
                        </div>

                        <!-- Botón checkout -->
                        @if ($metodo_pago !== 'SALDO' || $saldoLocal['saldo'] >= $total)
                            <button wire:click="comprarCarrito" wire:loading.attr="disabled"
                                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 text-white py-3.5 rounded-lg font-semibold transition flex items-center justify-center gap-2 shadow-sm">
                                <span wire:loading.remove wire:target="comprarCarrito">Finalizar compra</span>
                                <span wire:loading wire:target="comprarCarrito" class="flex items-center gap-2">
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
                        @else
                            <button disabled
                                class="w-full bg-gray-300 text-gray-500 py-3.5 rounded-lg font-semibold cursor-not-allowed">
                                Saldo insuficiente
                            </button>
                        @endif
                    </div>

                    <!-- Móvil - Resumen fijo abajo -->
                    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t shadow-2xl z-30">
                        <div class="p-4 pb-24">
                            <!-- Header colapsable -->
                            <button onclick="toggleResumen()" class="w-full flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-600">Total</span>
                                    <span class="text-xl font-bold text-blue-600">${{ $total }}</span>
                                </div>
                                <svg id="chevron-icon" class="w-5 h-5 text-gray-600 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Panel expandible -->
                            <div id="resumen-panel" class="hidden">
                                <!-- Método de pago -->
                                <div class="mb-3">
                                    <select wire:model.live="metodo_pago"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                        <option value="EFECTIVO">Efectivo</option>
                                        <option value="SALDO">Tarjeta Local</option>
                                    </select>
                                </div>

                                <!-- Hora de recogida -->
                                <div class="mb-3">
                                    <input type="time" wire:model.live="hora_recogida"
                                        placeholder="Hora de recogida"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                </div>

                                <!-- Saldo disponible -->
                                @if ($metodo_pago === 'SALDO')
                                    <div class="bg-blue-50 rounded-lg p-2 mb-3">
                                        <div class="flex justify-between text-xs">
                                            <span class="text-blue-900">Saldo disponible</span>
                                            <span
                                                class="text-blue-900 font-bold">${{ number_format($saldoLocal['saldo'], 2) }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($saldoLocal['saldo'] < $total && $metodo_pago === 'SALDO')
                                    <div class="bg-red-50 rounded-lg p-2 mb-3">
                                        <p class="text-xs text-red-800">Faltan
                                            ${{ number_format($total - $saldoLocal['saldo'], 2) }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Botón checkout -->
                            @if ($metodo_pago !== 'SALDO' || $saldoLocal['saldo'] >= $total)
                                <button wire:click="comprarCarrito" wire:loading.attr="disabled"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition">
                                    <span wire:loading.remove>Finalizar compra</span>
                                    <span wire:loading>Procesando...</span>
                                </button>
                            @else
                                <button disabled
                                    class="w-full bg-gray-300 text-gray-500 py-3 rounded-lg font-semibold">
                                    Saldo insuficiente
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Carrito vacío -->
        <div class="flex flex-col items-center justify-center py-20 px-4">
            <svg class="w-24 h-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tu carrito está vacío</h3>
            <p class="text-sm text-gray-600 mb-6">Explora el menú y agrega tus productos favoritos</p>
            <a href="{{ route('index') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition shadow-sm">
                Explorar Menú
            </a>
        </div>
    @endif
</div>
