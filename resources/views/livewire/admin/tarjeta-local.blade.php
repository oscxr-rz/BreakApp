<div class="min-h-screen bg-gray-50 pb-8">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Gestión de Tarjetas</h1>
                    <p class="text-sm text-gray-500 mt-1">Consulta y recarga tarjetas locales</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Notificaciones Toast -->
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
        :class="tipo === 'exito' ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' :
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

    <!-- Contenido Principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Sección: Buscar Tarjeta -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Consultar Tarjeta</h2>
                        <p class="text-sm text-gray-500">Ingresa el ID para ver el saldo</p>
                    </div>
                </div>

                <form wire:submit.prevent="cargarTarjeta" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            ID de Tarjeta
                        </label>
                        <input type="number" wire:model="idTarjeta" placeholder="Ej: 12345"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('idTarjeta')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button type="submit" wire:loading.attr="disabled" wire:target="cargarTarjeta"
                        class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-3.5 rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="cargarTarjeta">
                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Buscar Tarjeta
                        </span>
                        <span wire:loading wire:target="cargarTarjeta" class="flex items-center gap-2">
                            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Buscando...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Sección: Información de Tarjeta -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                @if (!empty($tarjetaLocal))
                    <!-- Botón para regresar/limpiar -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Información de Tarjeta</h2>
                                <p class="text-sm text-gray-500">Detalles y saldo actual</p>
                            </div>
                        </div>
                        <button wire:click="limpiar" type="button"
                            class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Limpiar
                        </button>
                    </div>

                    <!-- Card de la Tarjeta -->
                    <div class="bg-white px-6 py-8">
                        <div
                            class="relative w-full max-w-[380px] mx-auto aspect-[1.586/1] bg-gradient-to-br from-[#951327] via-[#b50001] to-[#951327] rounded-3xl shadow-xl p-6 text-white overflow-hidden">

                            <!-- Patrón decorativo -->
                            <div class="absolute inset-0 opacity-10">
                                <div
                                    class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full -translate-y-1/2 translate-x-1/2">
                                </div>
                                <div
                                    class="absolute bottom-0 left-0 w-24 h-24 bg-white rounded-full translate-y-1/2 -translate-x-1/2">
                                </div>
                            </div>

                            <!-- Contenido -->
                            <div class="relative h-full flex flex-col justify-between">
                                <!-- Header -->
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-xs opacity-80 mb-1">Tarjeta Local</p>
                                        <p class="text-lg font-bold">BreakApp</p>
                                    </div>
                                    <div class="w-10 h-10 bg-gradient-to-br from-[#fcc88a] to-[#f2cc88] rounded-lg">
                                    </div>
                                </div>

                                <!-- ID de Tarjeta -->
                                <div>
                                    <p class="text-xl font-bold tracking-wider mb-1">
                                        @php
                                            $idTarjeta = $tarjetaLocal['id_tarjeta_local'] ?? 'XXXXXXXXXXXX';
                                            echo substr($idTarjeta, 0, 4) .
                                                ' ' .
                                                substr($idTarjeta, 4, 4) .
                                                ' ' .
                                                substr($idTarjeta, 8, 4);
                                        @endphp
                                    </p>
                                </div>

                                <!-- Footer -->
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-[10px] opacity-70 mb-1">Titular</p>
                                        <p class="text-sm font-semibold">
                                            {{ $tarjetaLocal['usuario']['nombre'] ?? 'N/A' }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] opacity-70 mb-1">Saldo Disponible</p>
                                        <p class="text-sm font-semibold">
                                            ${{ number_format($tarjetaLocal['saldo'] ?? 0, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de Recarga -->
                    <form wire:submit.prevent="depositar({{ $tarjetaLocal['id_tarjeta_local'] ?? 0 }})"
                        class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Monto a Recargar
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold text-lg">$</span>
                                <input type="number" step="0.01" wire:model="monto" placeholder="0.00"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-lg font-semibold">
                            </div>
                            @error('monto')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button type="submit" wire:loading.attr="disabled" wire:target="depositar"
                            class="w-full bg-blue-600 text-white hover:bg-blue-700 py-3.5 rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="depositar">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Recargar Tarjeta
                            </span>
                            <span wire:loading wire:target="depositar" class="flex items-center gap-2">
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
                    </form>
                @else
                    <!-- Estado Vacío -->
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Sin tarjeta seleccionada</h3>
                        <p class="text-sm text-gray-500 text-center max-w-xs">
                            Ingresa el ID de una tarjeta en el formulario de la izquierda para ver su información
                        </p>
                    </div>
                @endif
            </div>

        </div>

        <!-- Sección de Ayuda -->
        <div class="mt-8 bg-blue-50 border border-blue-100 rounded-2xl p-6">
            <div class="flex gap-4">
                <div class="shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-blue-900 mb-1">¿Cómo funciona?</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Ingresa el ID de la tarjeta que deseas consultar</li>
                        <li>• Verifica el saldo disponible en la tarjeta</li>
                        <li>• Ingresa el monto que deseas recargar</li>
                        <li>• Confirma la recarga para actualizar el saldo</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
