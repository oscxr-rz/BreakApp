<div class="min-h-screen bg-gray-50" x-data="{
    mostrarModalPago: false,
    mostrarModalNuevaTarjeta: false,
    stripe: null,
    cardElement: null,
    errorPago: '',
    procesando: false,
    tarjetaSeleccionada: null,

    inicializarStripe() {
        if (!this.stripe) {
            this.stripe = Stripe('{{ env('STRIPE_KEY') }}');
            const elements = this.stripe.elements();
            this.cardElement = elements.create('card', {
                style: {
                    base: {
                        fontSize: '15px',
                        color: '#1a1a1a',
                        fontFamily: '-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif',
                        '::placeholder': { color: '#a0a0a0' },
                        iconColor: '#951327'
                    },
                    invalid: {
                        color: '#ef4444',
                        iconColor: '#ef4444'
                    }
                }
            });
            this.cardElement.mount('#card-element-stripe');
            this.cardElement.on('change', (e) => {
                this.errorPago = e.error ? e.error.message : '';
            });
        }
    }
}">
    <!-- Header -->
    <div
        class="bg-[#951327] border-b border-gray-100 px-4 py-4 flex items-center justify-between sticky top-0 z-20 shadow-sm">
        <button onclick="window.history.back()"
            class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/10 transition-colors">
            <svg class="w-6 h-6 text-[#FBE8Da]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <h1 class="text-lg font-semibold text-[#FBE8Da]">Mi Carrito</h1>
        <div class="w-10"></div>
    </div>

    @if (!session('id'))
        <!-- Sin sesión -->
        <div class="max-w-md mx-auto pt-20 px-4">
            <div class="bg-white rounded-2xl shadow-sm p-8 text-center border border-gray-100">
                <div class="w-20 h-20 bg-[#FBE8DA] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-[#951327]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Inicie sesión</h2>
                <p class="text-gray-500 text-sm mb-6">Necesita iniciar sesión para ver su carrito</p>
                <a href="{{ route('login') }}"
                    class="inline-block w-full py-3 bg-[#951327] text-white rounded-xl font-medium hover:bg-[#B50001] transition-colors">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    @elseif (!empty($carrito['productos']))
        <!-- Carrito con productos -->
        <div class="max-w-7xl mx-auto pb-32 lg:pb-8">
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
                                                    class="w-8 h-8 flex items-center justify-center bg-[#951327] hover:bg-[#B50001] hover:shadow-md rounded-lg transition">
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
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#951327] focus:border-[#951327] transition bg-gray-50">
                                <option value="EFECTIVO">Efectivo</option>
                                <option value="SALDO">Tarjeta Local</option>
                                <option value="TARJETA">Tarjeta de Crédito/Débito</option>
                            </select>
                            @error('metodo_pago')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hora de recogida -->
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-500 mb-2">Hora de recogida</label>
                            <input type="time" wire:model.live="hora_recogida"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#951327] focus:border-[#951327] transition bg-gray-50"
                                placeholder="Hora de recogida">
                            @error('hora_recogida')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Saldo disponible -->
                        @if ($metodo_pago === 'SALDO')
                            <div class="bg-[#FBE8DA] rounded-xl p-4 mb-4 border border-[#FCC88A]">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-[#951327] font-medium">Saldo disponible</span>
                                    <span
                                        class="text-lg text-[#951327] font-bold">${{ number_format($saldoLocal['saldo'], 2) }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Alerta saldo insuficiente -->
                        @if ($saldoLocal['saldo'] < $total && $metodo_pago === 'SALDO')
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 flex items-start gap-3">
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
                                <span class="text-2xl font-bold text-[#951327]">${{ $total }}</span>
                            </div>
                        </div>

                        <!-- Botón checkout -->
                        @if ($metodo_pago === 'TARJETA')
                            <button @click="mostrarModalPago = true"
                                class="w-full bg-[#951327] hover:bg-[#B50001] hover:shadow-xl text-white py-3.5 rounded-xl font-semibold transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Pagar con Tarjeta
                            </button>
                        @elseif ($metodo_pago !== 'SALDO' || $saldoLocal['saldo'] >= $total)
                            <button wire:click="comprarCarrito" wire:loading.attr="disabled"
                                class="w-full bg-[#951327] hover:bg-[#B50001] hover:shadow-lg disabled:opacity-50 text-white py-3.5 rounded-xl font-semibold transition-all flex items-center justify-center gap-2">
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

                    <!-- Móvil - Resumen fijo abajo MEJORADO -->
                    <div
                        class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-2xl z-30">
                        <div class="p-4 pb-20">
                            <!-- Header siempre visible con indicador visual -->
                            <button @click="expandido = !expandido" class="w-full mb-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-[#FBE8DA] rounded-full flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-[#951327]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-xs text-gray-500">Total a pagar</p>
                                            <p class="text-xl font-bold text-[#951327]">${{ $total }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-500 font-medium"
                                            x-text="expandido ? 'Ocultar' : 'Ver detalles'"></span>
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-600 transition-transform duration-300"
                                                :class="expandido ? 'rotate-180' : ''" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Indicador visual de opciones -->
                                <div x-show="!expandido" class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $metodo_pago === 'EFECTIVO' ? 'Efectivo' : ($metodo_pago === 'SALDO' ? 'Tarjeta Local' : 'Tarjeta') }}</span>
                                    @if ($hora_recogida)
                                        <span class="mx-1">•</span>
                                        <span>{{ $hora_recogida }}</span>
                                    @endif
                                </div>
                            </button>

                            <!-- Panel expandible MEJORADO -->
                            <div x-show="expandido" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-96"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 max-h-96"
                                x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden"
                                style="display: none;">

                                <div class="space-y-3 mb-4 pt-3 border-t border-gray-100">
                                    <!-- Método de pago con icono -->
                                    <div>
                                        <label class="flex items-center gap-2 text-xs font-medium text-gray-700 mb-2">
                                            <svg class="w-4 h-4 text-[#951327]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            Método de pago
                                        </label>
                                        <select wire:model.live="metodo_pago"
                                            class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm bg-gray-50 focus:ring-2 focus:ring-[#951327] focus:border-[#951327]">
                                            <option value="EFECTIVO">Efectivo</option>
                                            <option value="SALDO">Tarjeta Local</option>
                                            <option value="TARJETA">Tarjeta de Crédito/Débito</option>
                                        </select>
                                        @error('metodo_pago')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Hora de recogida con icono -->
                                    <div>
                                        <label class="flex items-center gap-2 text-xs font-medium text-gray-700 mb-2">
                                            <svg class="w-4 h-4 text-[#951327]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Hora de recogida
                                        </label>
                                        <input type="time" wire:model.live="hora_recogida"
                                            placeholder="Hora de recogida"
                                            class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm bg-gray-50 focus:ring-2 focus:ring-[#951327] focus:border-[#951327]">
                                        @error('hora_recogida')
                                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Saldo disponible móvil -->
                                    @if ($metodo_pago === 'SALDO')
                                        <div class="bg-[#FBE8DA] rounded-xl p-3 border border-[#FCC88A]">
                                            <div class="flex justify-between items-center">
                                                <span class="text-xs text-[#951327] font-medium">Saldo
                                                    disponible</span>
                                                <span
                                                    class="text-base text-[#951327] font-bold">${{ number_format($saldoLocal['saldo'], 2) }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Alerta saldo insuficiente móvil -->
                                    @if ($saldoLocal['saldo'] < $total && $metodo_pago === 'SALDO')
                                        <div
                                            class="bg-red-50 rounded-xl p-3 border border-red-200 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-red-600 shrink-0" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-xs text-red-800 font-medium">Faltan
                                                ${{ number_format($total - $saldoLocal['saldo'], 2) }}</p>
                                        </div>
                                    @endif

                                    <!-- Error productos móvil -->
                                    @error('productos')
                                        <div class="bg-red-50 rounded-xl p-2">
                                            <p class="text-xs text-red-800">{{ $message }}</p>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Botón checkout móvil -->
                            @if ($metodo_pago === 'TARJETA')
                                <button @click="mostrarModalPago = true"
                                    class="w-full bg-[#951327] hover:bg-[#B50001] active:scale-95 text-white py-4 rounded-xl font-semibold transition-all flex items-center justify-center gap-2 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Pagar con Tarjeta
                                </button>
                            @elseif ($metodo_pago !== 'SALDO' || $saldoLocal['saldo'] >= $total)
                                <button wire:click="comprarCarrito" wire:loading.attr="disabled"
                                    class="w-full bg-[#951327] hover:bg-[#B50001] active:scale-95 text-white py-4 rounded-xl font-semibold transition-all shadow-lg">
                                    <span wire:loading.remove wire:target="comprarCarrito">Finalizar compra</span>
                                    <span wire:loading wire:target="comprarCarrito">Procesando...</span>
                                </button>
                            @else
                                <button disabled
                                    class="w-full bg-gray-200 text-gray-500 py-4 rounded-xl font-semibold">
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
            <div class="bg-white rounded-2xl shadow-sm p-8 text-center border border-gray-100">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tu carrito está vacío</h3>
                <p class="text-sm text-gray-500 mb-6">Explora el menú y agrega tus productos favoritos</p>
                <a href="{{ route('index') }}"
                    class="inline-block bg-[#951327] hover:bg-[#B50001] hover:shadow-lg text-white px-6 py-3 rounded-xl font-semibold transition-all">
                    Explorar Menú
                </a>
            </div>
        </div>
    @endif

    <!-- Modal de Selección de Tarjetas -->
    <div x-show="mostrarModalPago" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-end lg:items-center justify-center"
        style="display: none;" @click.self="mostrarModalPago = false; tarjetaSeleccionada = null">

        <div x-show="mostrarModalPago" x-transition:enter="transition ease-out duration-400"
            x-transition:enter-start="translate-y-full lg:scale-95 lg:translate-y-0 opacity-0"
            x-transition:enter-end="translate-y-0 lg:scale-100 opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-y-0 lg:scale-100 opacity-100"
            x-transition:leave-end="translate-y-full lg:scale-95 lg:translate-y-0 opacity-0"
            class="bg-white w-full lg:max-w-2xl rounded-t-3xl lg:rounded-3xl shadow-2xl overflow-hidden max-h-[90vh] flex flex-col"
            @click.stop>

            <!-- Header -->
            <div class="px-6 py-6 border-b border-gray-100 shrink-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Pago con Tarjeta</h2>
                        <p class="text-sm text-gray-500 mt-1">Selecciona tu método de pago</p>
                    </div>
                    <button @click="mostrarModalPago = false; tarjetaSeleccionada = null"
                        class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Contenido -->
            <div class="px-6 py-6 overflow-y-auto flex-1">
                <!-- Monto a pagar -->
                <div class="bg-linear-to-br from-[#951327] to-[#B50001] rounded-2xl p-6 text-white text-center mb-6">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-90 mb-2">
                        Total a Pagar
                    </div>
                    <div class="text-4xl sm:text-5xl font-bold tracking-tight">
                        ${{ $total }}
                    </div>
                </div>

                <!-- Tarjetas guardadas -->
                @if (!empty($tarjetas))
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Tarjetas guardadas</h3>
                        <div class="space-y-3">
                            @foreach ($tarjetas as $tarjeta)
                                <button
                                    @click="tarjetaSeleccionada = {{ $tarjeta['id_tarjeta'] }}; $wire.set('idTarjeta', {{ $tarjeta['id_tarjeta'] }}); $wire.set('tokenStripe', null);"
                                    :class="tarjetaSeleccionada === {{ $tarjeta['id_tarjeta'] }} ?
                                        'border-[#951327] bg-[#FBE8DA]' : 'border-gray-200 hover:border-gray-300'"
                                    class="w-full border-2 rounded-xl p-4 transition-all text-left relative group">

                                    <!-- Checkmark -->
                                    <div x-show="tarjetaSeleccionada === {{ $tarjeta['id_tarjeta'] }}"
                                        class="absolute top-3 right-3 w-6 h-6 bg-[#951327] rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <!-- Logo de la tarjeta -->
                                        <div
                                            class="shrink-0 w-12 h-12 bg-linear-to-br {{ $tarjeta['marca'] === 'Visa'
                                                ? 'from-[#1434CB] to-[#0B1F71]'
                                                : ($tarjeta['marca'] === 'MasterCard'
                                                    ? 'from-[#0a0a0a] to-[#1a1a1a]'
                                                    : ($tarjeta['marca'] === 'American Express'
                                                        ? 'from-[#006FCF] to-[#00509E]'
                                                        : ($tarjeta['marca'] === 'Discover'
                                                            ? 'from-[#FF6000] to-[#E55400]'
                                                            : 'from-[#2D3748] to-[#1A202C]'))) }} rounded-lg flex items-center justify-center p-2">
                                            @if ($tarjeta['marca'] === 'Visa')
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg"
                                                    alt="Visa" class="w-full h-auto brightness-0 invert">
                                            @elseif($tarjeta['marca'] === 'MasterCard')
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg"
                                                    alt="MasterCard" class="w-full h-auto">
                                            @elseif($tarjeta['marca'] === 'American Express')
                                                <img src="https://www.aexp-static.com/cdaas/one/statics/axp-static-assets/1.8.0/package/dist/img/logos/dls-logo-bluebox-solid.svg"
                                                    alt="American Express" class="w-full h-auto">
                                            @else
                                                <svg viewBox="0 0 24 24" class="w-full h-auto" fill="none"
                                                    stroke="white" stroke-width="1.5">
                                                    <rect x="2" y="5" width="20" height="14" rx="2" />
                                                    <line x1="2" y1="10" x2="22"
                                                        y2="10" />
                                                </svg>
                                            @endif
                                        </div>

                                        <!-- Info de la tarjeta -->
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-gray-900 mb-1">{{ $tarjeta['marca'] }}
                                            </div>
                                            <div class="text-sm text-gray-600 font-mono">••••
                                                {{ $tarjeta['ultimos_digitos'] }}</div>
                                            <div class="text-xs text-gray-500 mt-1">Expira:
                                                {{ str_pad($tarjeta['mes_expiracion'], 2, '0', STR_PAD_LEFT) }}/{{ substr($tarjeta['anio_expiracion'], -2) }}
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Opción de nueva tarjeta -->
                <div>
                    <button
                        @click="mostrarModalPago = false; $nextTick(() => { mostrarModalNuevaTarjeta = true; $nextTick(() => inicializarStripe()); });"
                        class="w-full border-2 border-dashed border-gray-300 hover:border-[#951327] hover:bg-[#FBE8DA] rounded-xl p-4 transition-all text-left">

                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 bg-[#FBE8DA] rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-[#951327]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Usar otra tarjeta</div>
                                <div class="text-sm text-gray-500">Ingresa los datos de una nueva tarjeta</div>
                            </div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50 shrink-0">
                <button
                    @click="async () => { 
                        if (!tarjetaSeleccionada) {
                            errorPago = 'Por favor selecciona una tarjeta';
                            return;
                        }
                        procesando = true;
                        try {
                            await $wire.comprarCarrito();
                            mostrarModalPago = false;
                            tarjetaSeleccionada = null;
                            procesando = false;
                        } catch (err) {
                            errorPago = 'Error al procesar el pago';
                            procesando = false;
                        }
                    }"
                    :disabled="procesando || !tarjetaSeleccionada"
                    class="w-full bg-[#951327] hover:bg-[#B50001] hover:shadow-xl text-white py-4 rounded-xl font-semibold transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed relative overflow-hidden group">

                    <span
                        class="absolute inset-0 w-full h-full bg-linear-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>

                    <span x-show="!procesando" class="relative">
                        Confirmar Pago - ${{ $total }}
                    </span>
                    <span x-show="procesando" class="flex items-center justify-center gap-2 relative">
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Procesando...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para Ingresar Nueva Tarjeta -->
    <div x-show="mostrarModalNuevaTarjeta" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-end lg:items-center justify-center"
        style="display: none;"
        @click.self="mostrarModalNuevaTarjeta = false; errorPago = ''; if(cardElement) { cardElement.clear(); cardElement.unmount(); cardElement = null; stripe = null; }">

        <div x-show="mostrarModalNuevaTarjeta" x-transition:enter="transition ease-out duration-400"
            x-transition:enter-start="translate-y-full lg:scale-95 lg:translate-y-0 opacity-0"
            x-transition:enter-end="translate-y-0 lg:scale-100 opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-y-0 lg:scale-100 opacity-100"
            x-transition:leave-end="translate-y-full lg:scale-95 lg:translate-y-0 opacity-0"
            class="bg-white w-full lg:max-w-2xl rounded-t-3xl lg:rounded-3xl shadow-2xl overflow-hidden" @click.stop>

            <!-- Header del Modal -->
            <div class="px-6 py-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Nueva Tarjeta</h2>
                        <p class="text-sm text-gray-500 mt-1">Información segura y encriptada</p>
                    </div>
                    <button
                        @click="mostrarModalNuevaTarjeta = false; errorPago = ''; if(cardElement) { cardElement.clear(); cardElement.unmount(); cardElement = null; stripe = null; }"
                        class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Contenido del Modal -->
            <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
                <!-- Monto a pagar -->
                <div class="bg-linear-to-br from-[#951327] to-[#B50001] rounded-2xl p-6 text-white text-center mb-6">
                    <div class="text-xs font-medium uppercase tracking-wider opacity-90 mb-2">
                        Total a Pagar
                    </div>
                    <div class="text-4xl sm:text-5xl font-bold tracking-tight">
                        ${{ $total }}
                    </div>
                </div>

                <!-- Formulario de tarjeta -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Información de la Tarjeta
                        </label>
                        <div id="card-element-stripe"
                            class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4 transition-all duration-300 hover:border-gray-300 focus-within:border-[#951327] hover:bg-white">
                        </div>

                        <!-- Mensajes de error -->
                        <div x-show="errorPago" x-transition
                            class="mt-3 bg-red-50 border border-red-200 rounded-xl p-3 flex items-start gap-2">
                            <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-red-800 font-medium" x-text="errorPago"></p>
                        </div>
                    </div>

                    <!-- Checkbox para guardar tarjeta -->
                    <div class="bg-[#FBE8DA] border border-[#FCC88A] rounded-xl p-4">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="guardarTarjeta"
                                class="mt-0.5 w-5 h-5 text-[#951327] border-[#951327] rounded focus:ring-[#951327] focus:ring-offset-0 cursor-pointer">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-4 h-4 text-[#951327]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span class="text-sm font-semibold text-[#951327]">Guardar esta tarjeta</span>
                                </div>
                                <p class="text-xs text-[#78350f]">
                                    Guarda tu tarjeta de forma segura para futuras compras más rápidas
                                </p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Footer del Modal -->
            <div class="px-6 py-5 border-t border-gray-100 bg-gray-50">
                <button
                    @click="async () => { 
                        if (!stripe || !cardElement) { 
                            errorPago = 'Error: Sistema de pagos no inicializado'; 
                            return; 
                        } 
                        errorPago = ''; 
                        procesando = true; 
                        try { 
                            const { token, error } = await stripe.createToken(cardElement); 
                            if (error) { 
                                errorPago = error.message; 
                                procesando = false; 
                            } else { 
                                $wire.set('tokenStripe', token.id);
                                $wire.set('idTarjeta', null);
                                
                                // Si el usuario marcó guardar tarjeta, generar un segundo token
                                if ($wire.guardarTarjeta) {
                                    const { token: tokenGuardar, error: errorGuardar } = await stripe.createToken(cardElement);
                                    if (errorGuardar) {
                                        errorPago = 'Error al preparar guardar tarjeta: ' + errorGuardar.message;
                                        procesando = false;
                                        return;
                                    }
                                    $wire.set('tokenGuardar', tokenGuardar.id);
                                }
                                
                                await $wire.comprarCarrito();
                                
                                if(cardElement) {
                                    cardElement.clear();
                                    cardElement.unmount();
                                    cardElement = null;
                                    stripe = null;
                                }
                                
                                mostrarModalNuevaTarjeta = false;
                                procesando = false; 
                            } 
                        } catch (err) { 
                            errorPago = 'Error al procesar la tarjeta'; 
                            procesando = false; 
                        }
                    }"
                    :disabled="procesando"
                    class="w-full bg-[#951327] hover:bg-[#B50001] hover:shadow-xl text-white py-4 rounded-xl font-semibold transition-all duration-300 disabled:opacity-60 disabled:cursor-not-allowed relative overflow-hidden group">

                    <span
                        class="absolute inset-0 w-full h-full bg-linear-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>

                    <span x-show="!procesando" class="relative">
                        Confirmar Pago - ${{ $total }}
                    </span>
                    <span x-show="procesando" class="flex items-center justify-center gap-2 relative">
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Procesando...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Script de Stripe -->
    <script src="https://js.stripe.com/v3/"></script>

    <!-- Toast de Mensajes -->
    <div x-data="{
        toasts: [],
    
        addToast(tipo, mensaje) {
            const id = Date.now();
            this.toasts.push({ id, tipo, mensaje, show: true });
    
            setTimeout(() => {
                const index = this.toasts.findIndex(t => t.id === id);
                if (index !== -1) {
                    this.toasts[index].show = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 300);
                }
            }, 3000);
        }
    }" @mostrar-toast.window="addToast($event.detail.tipo, $event.detail.mensaje)"
        @mostrar-toast-delayed.window="setTimeout(() => addToast($event.detail.tipo, $event.detail.mensaje), $event.detail.delay || 0)"
        class="fixed top-6 right-6 z-[9999] space-y-3 max-w-md pointer-events-none">

        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                class="px-6 py-4 rounded-xl shadow-xl text-sm font-medium flex items-center gap-3 border pointer-events-auto"
                :class="toast.tipo === 'exito' ? 'bg-white text-green-700 border-green-200' :
                    'bg-white text-red-700 border-red-200'">

                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path x-show="toast.tipo === 'exito'" fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                    <path x-show="toast.tipo === 'error'" fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>

                <span x-text="toast.mensaje" class="flex-1"></span>

                <button @click="toast.show = false"
                    class="ml-1 hover:bg-gray-100 rounded-full p-1 transition-colors shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </template>
    </div>
</div>
