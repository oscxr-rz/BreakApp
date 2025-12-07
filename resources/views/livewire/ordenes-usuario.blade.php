<div>
    @if (!empty($ordenes))
        <h1>Ordenes</h1>
        @if (session('mensaje'))
            <p>{{ session('mensaje') }}</p>
        @endif
        @error('error')
            {{ $message }}
        @enderror
        @foreach ($ordenes as $orden)
            <p>{{ $orden['id_orden'] }}</p>
            <p>{{ $orden['estado'] }}</p>
            <p>{{ $orden['total'] }}</p>
            <p>{{ $orden['metodo_pago'] }}</p>
            <p>{{ $orden['pagado'] === 1 ? 'PAGADO' : 'PAGO PENDIENTE' }}</p>
            <img src="{{ $orden['imagen_url'] }}" alt="orden_{{ $orden['id_orden'] }}">
            <p>{{ $orden['hora_recogida'] }}</p>
            @foreach ($orden['productos'] as $producto)
                <p>{{ $producto['nombre'] }}</p>
                <p>{{ $producto['descripcion'] }}</p>
                <p>{{ $producto['precio'] }}</p>
                <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}">
                <p>{{ $producto['cantidad'] }}</p>
                <p>{{ $producto['notas'] }}</p>
            @endforeach
            @if ($orden['estado'] === 'ENTREGADO')
                <button wire:click="ocultarOrden({{ $orden['id_orden'] }})" wire:loading.attr="disabled">
                    <span class="block" wire:loading.class="hidden" wire:target="ocultarOrden({{ $orden['id_orden'] }})">
                        🗑️
                    </span>
                    <span class="hidden" wire:loading.class.remove="hidden"
                        wire:target="ocultarOrden({{ $orden['id_orden'] }})">
                        Procesando...
                    </span>
                </button>
            @endif
        @endforeach
    @elseif (!session('idUsuario'))
        <p>Inicie sesion para ver las ordenes realizadas</p>
    @else
        <p>No hay ordenes aún</p>
    @endif
    @script
        <script>
            Echo.private('usuario.{{ $id }}')
                .listen('ActualizarOrden', (e) => {
                    $wire.cargarOrdenes();
                })
        </script>
    @endscript
</div>
