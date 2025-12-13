<div>
    @if (!empty($notificaciones))
        @foreach ($notificaciones as $notificacion)
            <div class="{{ $notificacion['leido'] === 0 ? 'bg-red-500' : '' }}">
                <p>{{ $notificacion['titulo'] }}</p>
                <p>{{ $notificacion['mensaje'] }}</p>
                <p>{{ $notificacion['tipo'] }}</p>
                @if ($notificacion['leido'] === 1)
                    <button wire:click="ocultarNotificacion({{ $notificacion['id_notificacion'] }})" wire:loading.attr="disabled"
                        wire:loading.class="opacity-50"
                        class="w-full mt-2 py-3 bg-red-50 text-red-600 rounded-xl font-medium hover:bg-red-100 transition-colors border border-red-200 text-sm">
                        <span wire:loading.remove wire:target="ocultarNotificacion({{ $notificacion['id_notificacion'] }})">Eliminar
                            orden</span>
                        <span wire:loading wire:target="ocultarNotificacion({{ $notificacion['id_notificacion'] }})">Procesando...</span>
                    </button>
                @endif
            </div>
        @endforeach
    @endif
</div>
