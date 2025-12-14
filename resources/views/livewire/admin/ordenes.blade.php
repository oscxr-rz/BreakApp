<div class="h-screen bg-gray-50 flex flex-col overflow-hidden">
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
        x-transition:leave-end="opacity-0 translate-y-2" class="fixed top-6 right-6 px-6 py-4 rounded-lg shadow-lg z-50"
        :class="tipo === 'exito' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'" style="display: none;">
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

    @if (!empty($ordenes))
        <!-- Header fijo -->
        <div class="shrink-0 px-4 sm:px-6 py-4 bg-white border-b border-gray-200">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Panel de Órdenes</h1>
            <p class="text-gray-600 text-sm mt-1">{{ count($ordenes) }} orden(es) activa(s)</p>
        </div>

        <!-- Desktop: scroll horizontal -->
        <div class="hidden lg:flex flex-1 overflow-x-auto overflow-y-hidden px-6 py-4 snap-x snap-mandatory scroll-smooth"
            x-data="{
                init() { this.handleScroll() }, handleScroll() {
                    const container = this.$el;
                    const cards = container.querySelectorAll('.orden-card');
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.style.transform = 'scale(1)';
                                entry.target.style.opacity = '1';
                            } else {
                                entry.target.style.transform = 'scale(0.85)';
                                entry.target.style.opacity = '0.5';
                            }
                        });
                    }, { root: container, threshold: [0, 0.5, 1] });
                    cards.forEach(card => observer.observe(card));
                }
            }" x-init="init()">
            <div class="inline-flex gap-4 h-full">
                @foreach ($ordenes as $orden)
                    <div class="orden-card shrink-0 w-[calc(33.333vw-2rem)] bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-full snap-center transition-all duration-500 ease-out"
                        style="transform: scale(0.85); opacity: 0.5;">
                        <!-- Header de la orden -->
                        <div class="shrink-0 bg-linear-to-r from-blue-500 to-blue-600 text-white p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-lg font-bold">Orden #{{ $orden['id_orden'] }}</span>
                                <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-medium">
                                    {{ $orden['estado'] }}
                                </span>
                            </div>
                            <div class="text-sm opacity-90 space-y-1">
                                <p>{{ $orden['usuario'] }}</p>
                                <p>Recogida: {{ $orden['hora_recogida'] }}</p>
                            </div>
                        </div>

                        <!-- Info de pago -->
                        <div class="shrink-0 p-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500">Total</p>
                                    <p class="text-xl font-bold text-gray-800">${{ number_format($orden['total'], 2) }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">{{ $orden['metodo_pago'] }}</p>
                                    <p
                                        class="text-sm font-medium {{ $orden['pagado'] === 1 ? 'text-green-600' : 'text-orange-600' }}">
                                        {{ $orden['pagado'] === 1 ? 'Pagado' : 'Pago pendiente' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Productos con scroll interno -->
                        <div class="flex-1 overflow-y-auto p-4">
                            <div class="space-y-3">
                                @foreach ($orden['productos'] as $producto)
                                    <div class="flex gap-3 p-2 bg-gray-50 rounded-lg">
                                        <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}"
                                            class="w-16 h-16 object-cover rounded-md shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-sm text-gray-800">{{ $producto['nombre'] }}</p>
                                            <p class="text-xs text-gray-600 mt-1">
                                                Cantidad: {{ $producto['cantidad'] }} ×
                                                ${{ number_format($producto['precio'], 2) }}
                                            </p>
                                            @if (!empty($producto['notas']))
                                                <p class="text-xs text-gray-500 mt-1 italic">{{ $producto['notas'] }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Botón de acción -->
                        <div class="shrink-0 p-4 bg-white border-t border-gray-200">
                            <button x-data="{ loading: false }"
                                @click="loading = true; $wire.cambiarEstado({{ $orden['id_orden'] }}, '{{ $orden['estado'] === 'PENDIENTE' ? 'PREPARANDO' : 'LISTO' }}').then(() => loading = false)"
                                :disabled="loading"
                                class="w-full py-3 rounded-lg font-medium transition-all duration-200 text-sm flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed {{ $orden['estado'] === 'PENDIENTE' ? 'bg-orange-500 hover:bg-orange-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }}">

                                <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $orden['estado'] === 'PENDIENTE' ? 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                                </svg>

                                <svg x-show="loading" x-cloak class="animate-spin h-5 w-5" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>

                                <span>{{ $orden['estado'] === 'PENDIENTE' ? 'Preparando' : 'Listo' }}</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Mobile/Tablet: scroll vertical -->
        <div class="lg:hidden flex-1 overflow-y-auto px-4 py-4 snap-y snap-mandatory scroll-smooth"
            x-data="{
                init() { this.handleScroll() }, handleScroll() {
                    const container = this.$el;
                    const cards = container.querySelectorAll('.orden-card-mobile');
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.style.transform = 'scale(1)';
                                entry.target.style.opacity = '1';
                            } else {
                                entry.target.style.transform = 'scale(0.9)';
                                entry.target.style.opacity = '0.6';
                            }
                        });
                    }, { root: container, threshold: [0, 0.5, 1] });
                    cards.forEach(card => observer.observe(card));
                }
            }" x-init="init()">
            <div class="space-y-4">
                @foreach ($ordenes as $orden)
                    <div class="orden-card-mobile bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden snap-center transition-all duration-500 ease-out"
                        style="transform: scale(0.9); opacity: 0.6;">
                        <!-- Header de la orden -->
                        <div class="bg-linear-to-r from-blue-500 to-blue-600 text-white p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-lg font-bold">Orden #{{ $orden['id_orden'] }}</span>
                                <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-medium">
                                    {{ $orden['estado'] }}
                                </span>
                            </div>
                            <div class="text-sm opacity-90 space-y-1">
                                <p>{{ $orden['usuario'] }}</p>
                                <p>Recogida: {{ $orden['hora_recogida'] }}</p>
                            </div>
                        </div>

                        <!-- Info de pago -->
                        <div class="p-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500">Total</p>
                                    <p class="text-xl font-bold text-gray-800">
                                        ${{ number_format($orden['total'], 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">{{ $orden['metodo_pago'] }}</p>
                                    <p
                                        class="text-sm font-medium {{ $orden['pagado'] === 1 ? 'text-green-600' : 'text-orange-600' }}">
                                        {{ $orden['pagado'] === 1 ? 'Pagado' : 'Pago pendiente' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Productos -->
                        <div class="p-4">
                            <div class="space-y-3">
                                @foreach ($orden['productos'] as $producto)
                                    <div class="flex gap-3 p-2 bg-gray-50 rounded-lg">
                                        <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}"
                                            class="w-16 h-16 object-cover rounded-md shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-sm text-gray-800">{{ $producto['nombre'] }}</p>
                                            <p class="text-xs text-gray-600 mt-1">
                                                Cantidad: {{ $producto['cantidad'] }} ×
                                                ${{ number_format($producto['precio'], 2) }}
                                            </p>
                                            @if (!empty($producto['notas']))
                                                <p class="text-xs text-gray-500 mt-1 italic">{{ $producto['notas'] }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Botón de acción -->
                        <div class="p-4 bg-white border-t border-gray-200">
                            <button
                                wire:click="cambiarEstado({{ $orden['id_orden'] }}, '{{ $orden['estado'] === 'PENDIENTE' ? 'PREPARANDO' : 'LISTO' }}')"
                                wire:loading.attr="disabled"
                                wire:target="cambiarEstado({{ $orden['id_orden'] }}, '{{ $orden['estado'] === 'PENDIENTE' ? 'PREPARANDO' : 'LISTO' }}')"
                                class="w-full py-3 rounded-lg font-medium transition-all duration-200 text-sm flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed {{ $orden['estado'] === 'PENDIENTE' ? 'bg-orange-500 hover:bg-orange-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }}">

                                @if ($orden['estado'] === 'PENDIENTE')
                                    <svg wire:loading.remove
                                        wire:target="cambiarEstado({{ $orden['id_orden'] }}, 'PREPARANDO')"
                                        class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <svg wire:loading
                                        wire:target="cambiarEstado({{ $orden['id_orden'] }}, 'PREPARANDO')"
                                        class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <span>Preparando</span>
                                @else
                                    <svg wire:loading.remove
                                        wire:target="cambiarEstado({{ $orden['id_orden'] }}, 'LISTO')"
                                        class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <svg wire:loading wire:target="cambiarEstado({{ $orden['id_orden'] }}, 'LISTO')"
                                        class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <span>Listo</span>
                                @endif
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Estado vacío -->
        <div class="flex-1 flex flex-col items-center justify-center text-center px-6">
            <svg class="w-24 h-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No hay órdenes activas</h3>
            <p class="text-gray-500 text-sm">Las nuevas órdenes aparecerán aquí automáticamente</p>
        </div>
    @endif

    @script
        <script>
            Echo.channel('admin')
                .listen('.ActualizarOrdenes', (e) => {
                    $wire.cargarOrdenes();
                });
        </script>
    @endscript
</div>
