<div class="min-h-screen bg-gray-50" x-data="{
    mostrarModalAgregar: false,
    stripe: null,
    cardElement: null,
    errorPago: '',
    procesando: false,
    modalEliminar: false,
    tarjetaEliminar: null,

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
        class="bg-[#951327] border-b border-gray-100 px-4 py-4 flex items-center justify-between sticky top-0 z-10 shadow-sm">
        <button onclick="window.history.back()"
            class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/10 transition-colors">
            <svg class="w-6 h-6 text-[#FBE8Da]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <h1 class="text-lg font-semibold text-[#FBE8Da]">Mis Tarjetas</h1>
        <div class="w-10"></div>
    </div>

    @if (!session('id'))
        <!-- Sin sesión -->
        <div class="max-w-md mx-auto pt-20 px-4">
            <div class="bg-white rounded-2xl shadow-sm p-8 text-center border border-gray-100">
                <div class="w-20 h-20 bg-[#FBE8DA] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-[#951327]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Acceso Requerido</h2>
                <p class="text-gray-500 text-sm mb-6">Inicie sesión para gestionar sus tarjetas de pago</p>
                <a href="{{ route('login') }}"
                    class="inline-block w-full py-3 bg-[#951327] text-white rounded-xl font-medium hover:bg-[#B50001] transition-colors">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    @elseif (!empty($tarjetas))
        <!-- Lista de tarjetas -->
        <div class="max-w-2xl mx-auto px-4 py-6 pb-24">
            <!-- Botón agregar tarjeta -->
            <button @click="mostrarModalAgregar = true; $nextTick(() => inicializarStripe())"
                class="w-full mb-6 bg-white hover:bg-gray-50 border-2 border-dashed border-gray-300 hover:border-[#951327] text-gray-700 py-6 rounded-2xl font-medium transition-all flex items-center justify-center gap-3 group shadow-sm">
                <div
                    class="w-11 h-11 rounded-full bg-[#FBE8DA] group-hover:bg-[#951327] flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 text-[#951327] group-hover:text-white transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-base font-medium">Agregar nueva tarjeta</span>
            </button>

            <!-- Tarjetas guardadas -->
            <div class="space-y-4">
                @foreach ($tarjetas as $tarjeta)
                    <div class="group">
                        <!-- Tarjeta visual -->
                        <div
                            class="relative w-full aspect-[1.586/1] rounded-3xl p-8 text-white shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:scale-[1.02] {{ $tarjeta['marca'] === 'Visa'
                                ? 'bg-gradient-to-br from-[#1434CB] to-[#0B1F71]'
                                : ($tarjeta['marca'] === 'MasterCard'
                                    ? 'bg-gradient-to-br from-[#0a0a0a] to-[#1a1a1a]'
                                    : ($tarjeta['marca'] === 'American Express'
                                        ? 'bg-gradient-to-br from-[#006FCF] to-[#00509E]'
                                        : ($tarjeta['marca'] === 'Discover'
                                            ? 'bg-gradient-to-br from-[#FF6000] to-[#E55400]'
                                            : 'bg-gradient-to-br from-[#2D3748] to-[#1A202C]'))) }}">

                            <!-- Patrón sutil de fondo -->
                            <div class="absolute inset-0 opacity-[0.03]">
                                <div
                                    class="absolute top-0 right-0 w-80 h-80 bg-white rounded-full -translate-y-1/3 translate-x-1/3">
                                </div>
                                <div
                                    class="absolute bottom-0 left-0 w-96 h-96 bg-white rounded-full translate-y-1/2 -translate-x-1/2">
                                </div>
                            </div>

                            <!-- Contenido -->
                            <div class="relative h-full flex flex-col justify-between">
                                <!-- Header: Logo y Chip -->
                                <div class="flex justify-between items-start">
                                    <!-- Logo de la marca -->
                                    <div class="flex items-center opacity-95">
                                        @if ($tarjeta['marca'] === 'Visa')
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg"
                                                alt="Visa" class="h-5 w-auto brightness-0 invert">
                                        @elseif($tarjeta['marca'] === 'MasterCard')
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg"
                                                alt="MasterCard" class="h-10 w-auto">
                                        @elseif($tarjeta['marca'] === 'American Express')
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/American_Express_logo_%282018%29.svg"
                                                alt="American Express" class="h-5 w-auto brightness-0 invert">
                                        @elseif($tarjeta['marca'] === 'Discover')
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/57/Discover_Card_logo.svg"
                                                alt="Discover" class="h-5 w-auto">
                                        @else
                                            <svg viewBox="0 0 24 24" class="h-6 w-auto" fill="none"
                                                stroke="currentColor" stroke-width="1.5">
                                                <rect x="2" y="5" width="20" height="14" rx="2" />
                                                <line x1="2" y1="10" x2="22" y2="10" />
                                            </svg>
                                        @endif
                                    </div>

                                    <!-- Chip EMV -->
                                    <div class="relative w-12 h-10 opacity-90">
                                        <div
                                            class="absolute inset-0 rounded-lg shadow-md bg-gradient-to-br from-amber-200 via-amber-300 to-amber-400">
                                        </div>
                                        <div
                                            class="absolute inset-[2px] rounded-md bg-gradient-to-tl from-amber-200 via-amber-300 to-amber-400">
                                        </div>
                                        <div class="absolute inset-[4px] grid grid-cols-3 grid-rows-2 gap-[2px] p-1.5">
                                            <div class="bg-yellow-600/20 rounded-sm"></div>
                                            <div class="bg-yellow-600/20 rounded-sm"></div>
                                            <div class="bg-yellow-600/20 rounded-sm"></div>
                                            <div class="bg-yellow-600/20 rounded-sm"></div>
                                            <div class="bg-yellow-600/20 rounded-sm"></div>
                                            <div class="bg-yellow-600/20 rounded-sm"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Número de tarjeta -->
                                <div class="my-auto">
                                    <p class="text-2xl font-light tracking-[0.3em] font-mono text-white/95">
                                        •••• •••• •••• {{ $tarjeta['ultimos_digitos'] }}
                                    </p>
                                </div>

                                <!-- Footer: Titular y Expiración -->
                                <div class="flex justify-between items-end">
                                    <div class="space-y-1">
                                        <p class="text-[9px] font-medium tracking-wider uppercase opacity-60">Titular
                                        </p>
                                        <p class="text-sm font-medium tracking-wide uppercase opacity-95">
                                            {{ session('nombre', 'Usuario') }}</p>
                                    </div>
                                    <div class="text-right space-y-1">
                                        <p class="text-[9px] font-medium tracking-wider uppercase opacity-60">Válida
                                            hasta</p>
                                        <p class="text-sm font-medium tracking-wider opacity-95">
                                            {{ str_pad($tarjeta['mes_expiracion'], 2, '0', STR_PAD_LEFT) }}/{{ substr($tarjeta['anio_expiracion'], -2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botón eliminar -->
                        <div class="mt-4">
                            <button @click="modalEliminar = true; tarjetaEliminar = {{ $tarjeta['id_tarjeta'] }}"
                                class="w-full py-3.5 bg-white hover:bg-red-50 text-red-600 rounded-2xl font-medium transition-all duration-200 flex items-center justify-center gap-2 border border-red-100 hover:border-red-200 shadow-sm hover:shadow">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span class="text-sm">Eliminar tarjeta</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Sin tarjetas -->
        <div class="max-w-md mx-auto pt-20 px-4">
            <div class="bg-white rounded-2xl shadow-sm p-8 text-center border border-gray-100">
                <div class="w-20 h-20 bg-[#FBE8DA] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-[#951327]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Sin tarjetas guardadas</h2>
                <p class="text-gray-500 text-sm mb-6">Agrega una tarjeta para realizar pagos de forma segura y rápida
                </p>
                <button @click="mostrarModalAgregar = true; $nextTick(() => inicializarStripe())"
                    class="inline-flex items-center justify-center gap-2 w-full py-3 bg-[#951327] text-white rounded-xl font-medium hover:bg-[#B50001] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Agregar tarjeta
                </button>
            </div>
        </div>
    @endif

    <!-- Modal Agregar Tarjeta -->
    <div x-show="mostrarModalAgregar" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-end justify-center" style="display: none;"
        @click.self="mostrarModalAgregar = false; errorPago = ''">

        <div x-show="mostrarModalAgregar" x-transition:enter="transition ease-out duration-400"
            x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full"
            class="bg-white w-full max-w-2xl rounded-t-3xl shadow-2xl overflow-hidden" @click.stop>

            <!-- Header -->
            <div class="px-6 py-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Agregar Tarjeta</h2>
                        <p class="text-sm text-gray-500 mt-1">Información segura y encriptada</p>
                    </div>
                    <button @click="mostrarModalAgregar = false; errorPago = ''"
                        class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Contenido -->
            <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
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
                </div>
            </div>

            <!-- Footer -->
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
                                await $wire.agregarTarjeta(); 
                                
                                cardElement.clear();
                                cardElement.unmount();
                                stripe = null;
                                cardElement = null;
                                
                                mostrarModalAgregar = false; 
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
                        class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>

                    <span x-show="!procesando" class="relative">Agregar Tarjeta</span>
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

    <!-- Modal Confirmar Eliminación -->
    <div x-show="modalEliminar" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
        style="display: none;" @click.self="modalEliminar = false; tarjetaEliminar = null">

        <div x-show="modalEliminar" x-transition:enter="transition ease-out duration-400"
            x-transition:enter-start="scale-95 opacity-0" x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
            class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-md w-full" @click.stop>

            <div class="p-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">¿Eliminar tarjeta?</h3>
                <p class="text-sm text-gray-500 text-center mb-6">Esta acción no se puede deshacer</p>

                <div class="flex gap-3">
                    <button @click="modalEliminar = false; tarjetaEliminar = null"
                        class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-colors">
                        Cancelar
                    </button>
                    <button
                        @click="$wire.ocultarTarjeta(tarjetaEliminar); modalEliminar = false; tarjetaEliminar = null"
                        wire:loading.attr="disabled"
                        class="flex-1 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium transition-colors disabled:opacity-50">
                        <span wire:loading.remove wire:target="ocultarTarjeta">Eliminar</span>
                        <span wire:loading wire:target="ocultarTarjeta">Eliminando...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de Stripe -->
    <script src="https://js.stripe.com/v3/"></script>

    <!-- Toast de Mensajes -->
    <div x-data="{ show: false, tipo: 'exito', mensaje: '' }"
        @mostrar-toast.window="tipo = $event.detail.tipo; mensaje = $event.detail.mensaje; show = true; setTimeout(() => show = false, 3000);"
        x-show="show" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="fixed top-6 right-6 px-6 py-4 rounded-xl shadow-xl z-[9999] transform transition-all duration-300 border"
        :class="tipo === 'exito' ? 'bg-white text-green-700 border-green-200' : 'bg-white text-red-700 border-red-200'"
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
</div>
