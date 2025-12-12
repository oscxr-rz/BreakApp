<div>
    @if (!empty($ordenes))

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
        @foreach ($ordenes as $orden)
            <p>{{ $orden['id_orden'] }}</p>
            <p>{{ $orden['usuario'] }}</p>
            <p>{{ $orden['usuario'] }}</p>
            <p>{{ $orden['estado'] }}</p>
            <p>{{ $orden['total'] }}</p>
            <p>{{ $orden['metodo_pago'] }}</p>
            <p>{{ $orden['pagado'] === 1 ? 'pagado' : 'pago pendiente' }}</p>
            <p>{{ $orden['hora_recogida'] }}</p>
            @foreach ($orden['productos'] as $producto)
                <p>{{ $producto['nombre'] }}</p>
                <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}">
                <p>{{ $producto['precio'] }}</p>
                <p>{{ $producto['cantidad'] }}</p>
                <p>{{ $producto['notas'] }}</p>
            @endforeach
            <button
                wire:click="cambiarEstado({{ $orden['id_orden'] }}, {{ $orden['estado'] === 'PENDIENTE' ? 'PREPARANDO' : 'LISTO' }})"
                wire:loading.attr="disabled" wire:loading.class="opacity-50"
                class="w-full mt-2 py-3 bg-red-50 text-red-600 rounded-xl font-medium hover:bg-red-100 transition-colors border border-red-200 text-sm">
                <span wire:loading.remove
                    wire:target="cambiarEstado({{ $orden['id_orden'] }}, {{ $orden['estado'] === 'PENDIENTE' ? 'PREPARANDO' : 'LISTO' }})">{{ $orden['estado'] === 'PENDIENTE' ? 'PREPARANDO' : 'LISTO' }}
                </span>
                <span wire:loading
                    wire:target="cambiarEstado({{ $orden['id_orden'] }}, {{ $orden['estado'] === 'PENDIENTE' ? 'PREPARANDO' : 'LISTO' }})">Procesando...</span>
            </button>
        @endforeach
    @else
        <p>
            no hay ordenes aún
        </p>
    @endif
</div>
