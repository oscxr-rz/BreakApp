<div class="min-h-screen bg-gray-50">
    @if (!session('id'))
        <!-- Sin sesión -->
        <div class="max-w-md mx-auto pt-20 px-4">
            <div class="bg-white rounded-3xl shadow-sm p-8 text-center">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Inicia sesión</h2>
                <p class="text-gray-500 text-sm mb-6">Necesitas iniciar sesión para ver tu carrito</p>
                <a href="{{ route('login') }}"
                    class="inline-block bg-gradient-to-r from-blue-500 to-cyan-500 hover:shadow-lg text-white px-6 py-3 rounded-xl font-medium transition-all">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    @elseif (!empty($carrito['productos']))
        <!-- Carrito con productos -->
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div
                class="bg-white border-b border-gray-100 px-4 py-4 flex items-center justify-between sticky top-0 z-20">
                <button onclick="window.history.back()"
                    class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-900">Mi Carrito</h1>
                <div class="w-10"></div>
            </div>

            <div class="lg:grid lg:grid-cols-12 lg:gap-8 lg:px-6 lg:py-8">
                <!-- Lista de productos -->
                <div class="lg:col-span-8 space-y-3 px-4 py-4 lg:px-0">
                    @foreach ($carrito['productos'] as $categoria => $productos)
                        @foreach ($productos as $producto)
                            <div
                                class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 {{ $producto['activoAhora'] === 1 && $producto['disponible'] ? '' : 'opacity-60' }}">
                                <div class="flex gap-4">
                                    <!-- Imagen -->
                                    <div class="relative shrink-0">
                                        <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}"
                                            class="w-24 h-24 rounded-xl object-cover">
                                        @if ($producto['activoAhora'] !== 1 || !$producto['disponible'])
                                            <div
                                                class="absolute inset-0 bg-black/60 rounded-xl flex items-center justify-center">
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
                                                <p class="text-sm text-gray-500 mb-2 line-clamp-2">
                                                    {{ $producto['descripcion'] }}</p>

                                                @if (isset($producto['cantidad_disponible']))
                                                    @if ($producto['cantidad_disponible'] > 0)
                                                        <span
                                                            class="inline-block text-xs text-green-700 bg-green-50 px-2 py-1 rounded-lg font-medium">
                                                            {{ $producto['cantidad_disponible'] }} disponibles
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-block text-xs text-white bg-red-500 px-2 py-1 rounded-lg font-medium">
                                                            Agotado
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>

                                            <!-- Botón eliminar -->
                                            <button wire:click="quitarDelCarrito({{ $producto['id_producto'] }})"
                                                wire:loading.attr="disabled"
                                                class="text-gray-400 hover:text-red-600 transition p-1 rounded-full hover:bg-red-50">
                                                <span wire:loading.remove
                                                    wire:target="quitarDelCarrito({{ $producto['id_producto'] }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </span>
                                                <span class="hidden" wire:loading.class.remove="hidden"
                                                    wire:target="quitarDelCarrito({{ $producto['id_producto'] }})">
                                                    <svg class="animate-spin w-5 h-5" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                            stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>

                                        <!-- Precio y cantidad -->
                                        <div class="flex items-center justify-between mt-4">
                                            <span
                                                class="text-xl font-bold text-gray-900">${{ number_format($producto['precio_unitario'], 2) }}</span>

                                            <!-- Controles cantidad -->
                                            <div
                                                class="flex items-center gap-3 bg-gray-50 rounded-xl px-3 py-2 border border-gray-200">
                                                <button
                                                    wire:click="eliminarAlCarrito({{ $producto['id_producto'] }}, 1)"
                                                    wire:loading.attr="disabled"
                                                    class="w-8 h-8 flex items-center justify-center hover:bg-white rounded-lg transition">
                                                    <span wire:loading.remove
                                                        wire:target="eliminarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                                        <svg class="w-4 h-4 text-gray-700" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M20 12H4" />
                                                        </svg>
                                                    </span>
                                                    <span class="hidden" wire:loading.class.remove="hidden"
                                                        wire:target="eliminarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                                        <svg class="animate-spin w-4 h-4" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12"
                                                                r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor"
                                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </button>

                                                <span
                                                    class="font-semibold text-gray-900 min-w-8 text-center">{{ $producto['cantidad'] }}</span>

                                                <button
                                                    wire:click="agregarAlCarrito({{ $producto['id_producto'] }}, 1)"
                                                    wire:loading.attr="disabled"
                                                    class="w-8 h-8 flex items-center justify-center bg-gradient-to-r from-blue-500 to-cyan-500 hover:shadow-md rounded-lg transition">
                                                    <span wire:loading.remove
                                                        wire:target="agregarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                                        <svg class="w-4 h-4 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </span>
                                                    <span class="hidden" wire:loading.class.remove="hidden"
                                                        wire:target="agregarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                                        <svg class="animate-spin w-4 h-4 text-white" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12"
                                                                r="10" stroke="currentColor" stroke-width="4">
                                                            </circle>
                                                            <path class="opacity-75" fill="currentColor"
                                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                            </path>
                                                        </svg>
                                                    </span>
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
                <div class="lg:col-span-4" x-data="{ expandido: false }">
                    <!-- Desktop - Sidebar sticky -->
                    <div
                        class="hidden lg:block bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Resumen del Pedido</h2>

                        <!-- Método de pago -->
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-500 mb-2">Método de pago</label>
                            <select wire:model.live="metodo_pago"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-gray-50">
                                <option value="EFECTIVO">Efectivo</option>
                                <option value="SALDO">Tarjeta Local</option>
                            </select>
                            @error('metodo_pago')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hora de recogida -->
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-500 mb-2">Hora de recogida</label>
                            <input type="time" wire:model.live="hora_recogida"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-gray-50">
                            @error('hora_recogida')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Saldo disponible -->
                        @if ($metodo_pago === 'SALDO')
                            <div
                                class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-4 mb-4 border border-blue-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-blue-900 font-medium">Saldo disponible</span>
                                    <span
                                        class="text-lg text-blue-900 font-bold">${{ number_format($saldoLocal['saldo'], 2) }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Alerta saldo insuficiente -->
                        @if ($saldoLocal['saldo'] < $total && $metodo_pago === 'SALDO')
                            <div
                                class="bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-xl p-4 mb-4 flex items-start gap-3">
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

                        <!-- Errores de productos -->
                        @error('productos')
                            <div class="bg-red-50 border border-red-200 rounded-xl p-3 mb-4">
                                <p class="text-sm text-red-800">{{ $message }}</p>
                            </div>
                        @enderror

                        <!-- Total -->
                        <div class="border-t border-gray-100 pt-4 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-500">Subtotal
                                    ({{ collect($carrito['productos'])->flatten(1)->where('activoAhora', 1)->sum('cantidad') }}
                                    productos)</span>
                                <span class="text-sm font-medium text-gray-900">${{ $total }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-base font-semibold text-gray-900">Total</span>
                                <span
                                    class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">${{ $total }}</span>
                            </div>
                        </div>

                        <!-- Botón checkout -->
                        @if ($metodo_pago !== 'SALDO' || $saldoLocal['saldo'] >= $total)
                            <button wire:click="comprarCarrito" wire:loading.attr="disabled"
                                class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 hover:shadow-lg disabled:opacity-50 text-white py-3.5 rounded-xl font-semibold transition-all flex items-center justify-center gap-2">
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
                                class="w-full bg-gray-200 text-gray-500 py-3.5 rounded-xl font-semibold cursor-not-allowed">
                                Saldo insuficiente
                            </button>
                        @endif
                    </div>

                    <!-- Móvil - Resumen fijo abajo -->
                    <div
                        class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-2xl z-30 rounded-t-3xl">
                        <div class="p-4 pb-20 lg:pb-24">
                            <!-- Header colapsable -->
                            <button @click="expandido = !expandido"
                                class="w-full flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-600">Total</span>
                                    <span
                                        class="text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">${{ $total }}</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-600 transition-transform"
                                    :class="expandido ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Panel expandible -->
                            <div x-show="expandido" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform translate-y-4" style="display: none;">

                                <!-- Método de pago -->
                                <div class="mb-3">
                                    <select wire:model.live="metodo_pago"
                                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm bg-gray-50">
                                        <option value="EFECTIVO">Efectivo</option>
                                        <option value="SALDO">Tarjeta Local</option>
                                    </select>
                                    @error('metodo_pago')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Hora de recogida -->
                                <div class="mb-3">
                                    <input type="time" wire:model.live="hora_recogida"
                                        placeholder="Hora de recogida"
                                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm bg-gray-50">
                                    @error('hora_recogida')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Saldo disponible móvil -->
                                @if ($metodo_pago === 'SALDO')
                                    <div
                                        class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-3 mb-3 border border-blue-100">
                                        <div class="flex justify-between text-xs">
                                            <span class="text-blue-900 font-medium">Saldo disponible</span>
                                            <span
                                                class="text-blue-900 font-bold">${{ number_format($saldoLocal['saldo'], 2) }}</span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Alerta saldo insuficiente móvil -->
                                @if ($saldoLocal['saldo'] < $total && $metodo_pago === 'SALDO')
                                    <div class="bg-red-50 rounded-xl p-3 mb-3 border border-red-200">
                                        <p class="text-xs text-red-800 font-medium">Faltan
                                            ${{ number_format($total - $saldoLocal['saldo'], 2) }}</p>
                                    </div>
                                @endif

                                <!-- Error productos móvil -->
                                @error('productos')
                                    <div class="bg-red-50 rounded-xl p-2 mb-3">
                                        <p class="text-xs text-red-800">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>

                            <!-- Botón checkout móvil -->
                            @if ($metodo_pago !== 'SALDO' || $saldoLocal['saldo'] >= $total)
                                <button wire:click="comprarCarrito" wire:loading.attr="disabled"
                                    class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 hover:shadow-lg text-white py-3.5 rounded-xl font-semibold transition-all">
                                    <span wire:loading.remove wire:target="comprarCarrito">Finalizar compra</span>
                                    <span wire:loading wire:target="comprarCarrito">Procesando...</span>
                                </button>
                            @else
                                <button disabled
                                    class="w-full bg-gray-200 text-gray-500 py-3.5 rounded-xl font-semibold">
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
        <div class="max-w-md mx-auto pt-20 px-4">
            <div class="bg-white rounded-3xl shadow-sm p-8 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tu carrito está vacío</h3>
                <p class="text-sm text-gray-500 mb-6">Explora el menú y agrega tus productos favoritos</p>
                <a href="{{ route('index') }}"
                    class="inline-block bg-gradient-to-r from-blue-500 to-cyan-500 hover:shadow-lg text-white px-6 py-3 rounded-xl font-semibold transition-all">
                    Explorar Menú
                </a>
            </div>
        </div>
    @endif

    <!-- Toast de Mensajes Flotantes -->
    <div x-data="{ show: false, tipo: 'exito', mensaje: '' }"
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
        class="fixed top-6 right-6 px-6 py-4 rounded-2xl shadow-xl z-[9999] text-sm font-medium flex items-center gap-3"
        :class="tipo === 'exito' ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' :
            'bg-gradient-to-r from-red-500 to-pink-500 text-white'"
        style="display: none;">

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
</div>
