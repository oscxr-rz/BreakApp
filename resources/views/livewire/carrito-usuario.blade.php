<div class="w-full min-h-screen bg-linear-to-b from-[#f2cc88]/5 to-white">
    @if (!session('id'))
        <!-- No hay sesión -->
        <div class="flex flex-col items-center justify-center py-20 lg:py-32 px-4">
            <div class="w-32 h-32 lg:w-40 lg:h-40 bg-[#f2cc88]/20 rounded-full flex items-center justify-center mb-6">
                <svg class="w-16 h-16 lg:w-20 lg:h-20 text-[#768e78]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h3 class="text-xl lg:text-2xl font-bold text-[#951327] mb-2">Inicia sesión</h3>
            <p class="text-sm lg:text-base text-[#768e78] text-center mb-6">Inicie sesión para acceder
                al carrito</p>
            <a href="{{ route('login') }}"
                class="bg-[#ea5f3a] hover:bg-[#951327] text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                Iniciar Sesión
            </a>
        </div>
    @elseif (!empty($carrito['productos']))
        <!-- Header del Carrito -->
        <div class="px-4 md:px-6 lg:px-8 py-6 pb-40 lg:pb-6">
            <div class="flex items-center gap-3 mb-6">
                <h1 class="text-2xl lg:text-3xl font-bold text-[#951327]">Carrito</h1>
            </div>

            <!-- Layout de Grid para Desktop -->
            <div class="grid lg:grid-cols-3 gap-6">
                <!-- Columna de Productos (2/3 en desktop) -->
                <div class="lg:col-span-2 space-y-3">
                    @foreach ($carrito['productos'] as $categoria => $productos)
                        @foreach ($productos as $producto)
                            <div
                                class="bg-white rounded-2xl p-4 shadow-sm border border-[#f2cc88]/20 {{ $producto['activoAhora'] === 1 && $producto['disponible'] ? '' : 'opacity-50' }}">
                                <div class="flex gap-4 items-start">
                                    <!-- Imagen del Producto -->
                                    <div class="relative shrink-0">
                                        <div
                                            class="w-20 h-20 bg-linear-to-br from-[#f2cc88]/30 to-[#fcc88a]/20 rounded-xl flex items-center justify-center overflow-hidden">
                                            <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                        @if ($producto['activoAhora'] !== 1 || !$producto['disponible'])
                                            <div
                                                class="absolute inset-0 bg-[#768e78]/70 rounded-xl flex items-center justify-center">
                                                <span class="text-white text-[10px] font-semibold">No disponible</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Info del Producto -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2 mb-2">
                                            <div class="flex-1">
                                                <h3 class="font-bold text-base text-[#951327] mb-1">
                                                    {{ $producto['nombre'] }}
                                                </h3>
                                                <p class="text-xs text-[#768e78] mb-2">{{ $producto['descripcion'] }}
                                                </p>

                                                <!-- Cantidad Disponible -->
                                                @if (isset($producto['cantidad_disponible']))
                                                    @if ($producto['cantidad_disponible'] > 0)
                                                        <span
                                                            class="inline-block text-[10px] font-semibold text-[#768e78] bg-green-100 px-2 py-0.5 rounded-md">
                                                            {{ $producto['cantidad_disponible'] }} disponibles
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-block text-[10px] font-semibold text-white bg-red-500 px-2 py-0.5 rounded-md">
                                                            Agotado
                                                        </span>
                                                    @endif
                                                @endif
                                            </div>

                                            <!-- Botón Eliminar -->
                                            <button wire:click="quitarDelCarrito({{ $producto['id_producto'] }})"
                                                wire:loading.attr="disabled"
                                                class="w-8 h-8 flex items-center justify-center hover:bg-[#e79897]/10 rounded-full transition-colors shrink-0">
                                                <span wire:loading.remove
                                                    wire:target="quitarDelCarrito({{ $producto['id_producto'] }})">
                                                    <svg class="w-4 h-4 text-[#768e78]" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </span>
                                                <span class="hidden" wire:loading.class.remove="hidden"
                                                    wire:target="quitarDelCarrito({{ $producto['id_producto'] }})">
                                                    <svg class="animate-spin w-4 h-4 text-[#768e78]" fill="none"
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

                                        <!-- Precio y Controles -->
                                        <div class="flex items-center justify-between mt-3">
                                            <span
                                                class="font-bold text-lg text-[#951327]">${{ number_format($producto['precio_unitario'], 2) }}</span>

                                            <!-- Controles de Cantidad -->
                                            <div
                                                class="flex items-center gap-3 bg-[#f2cc88]/10 rounded-full px-3 py-1.5">
                                                <!-- Botón Restar -->
                                                <button
                                                    wire:click="eliminarAlCarrito({{ $producto['id_producto'] }}, 1)"
                                                    wire:loading.attr="disabled"
                                                    class="w-6 h-6 flex items-center justify-center hover:bg-white rounded-full transition-colors">
                                                    <span wire:loading.remove
                                                        wire:target="eliminarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                                        <svg class="w-3 h-3 text-[#951327]" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M20 12H4" />
                                                        </svg>
                                                    </span>
                                                    <span class="hidden" wire:loading.class.remove="hidden"
                                                        wire:target="eliminarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                                        <svg class="animate-spin w-3 h-3 text-[#768e78]" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12"
                                                                r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor"
                                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </button>

                                                <!-- Cantidad -->
                                                <span
                                                    class="font-semibold text-[#951327] min-w-6 text-center">{{ $producto['cantidad'] }}</span>

                                                <!-- Botón Sumar -->
                                                <button
                                                    wire:click="agregarAlCarrito({{ $producto['id_producto'] }}, 1)"
                                                    wire:loading.attr="disabled"
                                                    class="w-6 h-6 flex items-center justify-center bg-[#951327] hover:bg-[#ea5f3a] rounded-full transition-colors">
                                                    <span wire:loading.remove
                                                        wire:target="agregarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                                        <svg class="w-3 h-3 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 4v16m8-8H4" />
                                                        </svg>
                                                    </span>
                                                    <span class="hidden" wire:loading.class.remove="hidden"
                                                        wire:target="agregarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                                        <svg class="animate-spin w-3 h-3 text-white" fill="none"
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

                <!-- Columna de Resumen (1/3 en desktop, colapsable en móvil) -->
                <div class="lg:col-span-1" x-data="{ expandido: false }">
                    <!-- Versión Móvil - Colapsable -->
                    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-40" style="bottom: 6.5rem;">
                        <!-- Botón para expandir/contraer -->
                        <button @click="expandido = !expandido"
                            class="w-full bg-linear-to-r from-[#951327] to-[#ea5f3a] text-white py-3 flex items-center justify-between px-5 shadow-lg">
                            <span class="font-bold text-sm">Ver resumen
                                ({{ collect($carrito['productos'])->flatten(1)->where('activoAhora', 1)->sum('cantidad') }}
                                productos)</span>
                            <div class="flex items-center gap-3">
                                <span class="font-bold text-lg">${{ $total }}</span>
                                <svg class="w-5 h-5 transition-transform" :class="expandido ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>

                        <!-- Panel Expandible -->
                        <div x-show="expandido" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-y-full"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform translate-y-full"
                            class="bg-white p-5 shadow-2xl max-h-[50vh] overflow-y-auto"
                            style="box-shadow: 0 -4px 20px rgba(0,0,0,0.1);">

                            <!-- Método de Pago -->
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-[#768e78] mb-2">Método de pago</label>
                                <select wire:model.live="metodo_pago"
                                    class="w-full bg-[#f2cc88]/10 rounded-xl px-4 py-2.5 text-sm border border-[#fcc88a]/30 focus:ring-2 focus:ring-[#ea5f3a] focus:border-transparent transition-all text-[#951327] font-medium">
                                    <option value="EFECTIVO">Efectivo</option>
                                    <option value="SALDO">Tarjeta Local</option>
                                </select>
                                @error('metodo_pago')
                                    <p class="text-xs text-[#e79897] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Hora de Recogida -->
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-[#768e78] mb-2">Hora de recogida</label>
                                <input type="time" wire:model.live="hora_recogida"
                                    class="w-full bg-[#f2cc88]/10 rounded-xl px-4 py-2.5 text-sm border border-[#fcc88a]/30 focus:ring-2 focus:ring-[#ea5f3a] focus:border-transparent transition-all text-[#951327] font-medium">
                                @error('hora_recogida')
                                    <p class="text-xs text-[#e79897] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Saldo Local -->
                            @if ($metodo_pago === 'SALDO')
                                <div class="bg-[#f2cc88]/10 rounded-xl p-3 mb-4">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-[#768e78]">Saldo disponible</span>
                                        <span
                                            class="font-bold text-[#768e78]">${{ number_format($saldoLocal['saldo'], 2) }}</span>
                                    </div>
                                </div>
                            @endif

                            @error('productos')
                                <div class="bg-[#e79897]/10 border border-[#e79897]/30 rounded-xl p-3 mb-4">
                                    <p class="text-xs text-[#e79897]">{{ $message }}</p>
                                </div>
                            @enderror

                            @if ($saldoLocal['saldo'] < $total && $metodo_pago === 'SALDO')
                                <div
                                    class="bg-[#e79897]/10 border border-[#e79897]/30 rounded-xl p-3 mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#e79897] shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-xs text-[#e79897]">Saldo insuficiente</p>
                                </div>
                            @endif

                            <!-- Botón Checkout -->
                            @if ($metodo_pago !== 'SALDO' || $saldoLocal['saldo'] >= $total)
                                <button wire:click="comprarCarrito" wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-not-allowed"
                                    class="w-full bg-linear-to-r from-[#951327] to-[#ea5f3a] hover:from-[#b50001] hover:to-[#951327] text-white px-6 py-3.5 rounded-xl font-bold text-sm transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                    <span wire:loading.remove wire:target="comprarCarrito">Checkout</span>
                                    <span class="hidden" wire:loading.class.remove="hidden"
                                        wire:target="comprarCarrito">
                                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
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

                    <!-- Versión Desktop - Sidebar Normal -->
                    <div class="hidden lg:block sticky top-6">
                        <div
                            class="bg-white rounded-2xl p-5 shadow-lg border border-[#fcc88a]/20 max-h-[calc(100vh-8rem)] overflow-y-auto">
                            <!-- Total de Productos -->
                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-[#f2cc88]/20">
                                <span class="text-sm text-[#768e78]">Total de productos
                                    ({{ collect($carrito['productos'])->flatten(1)->where('activoAhora', 1)->sum('cantidad') }})</span>
                            </div>

                            <!-- Método de Pago -->
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-[#768e78] mb-2">Método de pago</label>
                                <select wire:model.live="metodo_pago"
                                    class="w-full bg-[#f2cc88]/10 rounded-xl px-4 py-2.5 text-sm border border-[#fcc88a]/30 focus:ring-2 focus:ring-[#ea5f3a] focus:border-transparent transition-all text-[#951327] font-medium">
                                    <option value="EFECTIVO">Efectivo</option>
                                    <option value="SALDO">Tarjeta Local</option>
                                </select>
                                @error('metodo_pago')
                                    <p class="text-xs text-[#e79897] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Hora de Recogida -->
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-[#768e78] mb-2">Hora de recogida</label>
                                <input type="time" wire:model.live="hora_recogida"
                                    class="w-full bg-[#f2cc88]/10 rounded-xl px-4 py-2.5 text-sm border border-[#fcc88a]/30 focus:ring-2 focus:ring-[#ea5f3a] focus:border-transparent transition-all text-[#951327] font-medium">
                                @error('hora_recogida')
                                    <p class="text-xs text-[#e79897] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Saldo Local -->
                            @if ($metodo_pago === 'SALDO')
                                <div class="bg-[#f2cc88]/10 rounded-xl p-3 mb-4">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-[#768e78]">Saldo disponible</span>
                                        <span
                                            class="font-bold text-[#768e78]">${{ number_format($saldoLocal['saldo'], 2) }}</span>
                                    </div>
                                </div>
                            @endif

                            @error('productos')
                                <div class="bg-[#e79897]/10 border border-[#e79897]/30 rounded-xl p-3 mb-4">
                                    <p class="text-xs text-[#e79897]">{{ $message }}</p>
                                </div>
                            @enderror

                            @if ($saldoLocal['saldo'] < $total && $metodo_pago === 'SALDO')
                                <div
                                    class="bg-[#e79897]/10 border border-[#e79897]/30 rounded-xl p-3 mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#e79897] shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-xs text-[#e79897]">Saldo insuficiente</p>
                                </div>
                            @endif

                            <!-- Total -->
                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-[#f2cc88]/20">
                                <span class="text-sm font-semibold text-[#768e78]">Total precio
                                    ({{ collect($carrito['productos'])->flatten(1)->where('activoAhora', 1)->count() }})</span>
                                <span class="font-bold text-2xl text-[#951327]">${{ $total }}</span>
                            </div>

                            <!-- Botón Checkout -->
                            @if ($metodo_pago !== 'SALDO' || $saldoLocal['saldo'] >= $total)
                                <button wire:click="comprarCarrito" wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-not-allowed"
                                    class="w-full bg-linear-to-r from-[#951327] to-[#ea5f3a] hover:from-[#b50001] hover:to-[#951327] text-white px-6 py-3.5 rounded-xl font-bold text-sm transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                    <span wire:loading.remove wire:target="comprarCarrito">Checkout</span>
                                    <span class="hidden" wire:loading.class.remove="hidden"
                                        wire:target="comprarCarrito">
                                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </span>
                                    <svg class="w-5 h-5" wire:loading.remove wire:target="comprarCarrito"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Carrito Vacío -->
        <div class="flex flex-col items-center justify-center py-20 lg:py-32 px-4">
            <div class="w-32 h-32 lg:w-40 lg:h-40 bg-[#f2cc88]/20 rounded-full flex items-center justify-center mb-6">
                <svg class="w-16 h-16 lg:w-20 lg:h-20 text-[#768e78]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-xl lg:text-2xl font-bold text-[#951327] mb-2">Tu carrito está vacío</h3>
            <p class="text-sm lg:text-base text-[#768e78] text-center mb-6">Agrega productos desde el menú para
                comenzar tu orden</p>
            <a href="{{ route('index') }}"
                class="bg-[#ea5f3a] hover:bg-[#951327] text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                Ver Menú
            </a>
        </div>
    @endif

    <!-- Toast de Mensajes -->
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
