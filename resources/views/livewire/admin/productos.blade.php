<div>
    @if (!empty($productos))
        @if (session('mensaje'))
            <p>{{ session('mensaje') }}</p>
        @endif
        @error('error')
            {{ $message }}
        @enderror
        @foreach ($productos as $categoria => $items)
            <h2>
                {{ $categoria }}
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Tiempo de preparación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $producto)
                        <tr class="categoria-row" data-nombre="{{ strtolower($producto['nombre']) }}"
                            data-descripcion="{{ strtolower($producto['descripcion']) }}">
                            <td>{{ $producto['nombre'] }}</td>
                            <td>{{ $producto['descripcion'] }}</td>
                            <td>{{ $producto['precio'] }}</td>
                            <td>{{ $producto['tiempo_preparacion'] }}</td>
                            <td>
                                {{ $producto['activo'] === 1 ? 'Activo' : 'Inactivo' }}
                            </td>
                            <td>
                                <button>Editar</button>
                                <button
                                    wire:click="cambiarEstado({{ $producto['id_producto'] }}, {{ $producto['activo'] === 1 ? 0 : 1 }})"
                                    wire:loading.attr="disabled">
                                    <span class="block" wire:loading.class="hidden"
                                        wire:target="cambiarEstado({{ $producto['id_producto'] }}, {{ $producto['activo'] === 1 ? 0 : 1 }})">
                                        {{ $producto['activo'] === 1 ? 'Desactivar' : 'Activar' }}
                                    </span>
                                    <span class="hidden" wire:loading.class.remove="hidden"
                                        wire:target="cambiarEstado({{ $producto['id_producto'] }}, {{ $producto['activo'] === 1 ? 0 : 1 }})">
                                        Procesando...
                                    </span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @else
        <p>No hay productos disponibles</p>
    @endif
    @script
        <script>
            Echo.channel('admin')
                .listen('.ActualizarProducto', (e) => {
                    $wire.cargarProductos();
                })
        </script>
    @endscript
</div>
