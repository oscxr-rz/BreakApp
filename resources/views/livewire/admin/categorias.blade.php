<div>

    <h2>Categorías</h2>

    @if (!empty($categorias))

        @if (session('mensaje'))
            <p>{{ session('mensaje') }}</p>
        @endif
        @error('error')
            {{ $message }}
        @enderror
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $categoria)
                    <tr class="categoria-row" data-nombre="{{ strtolower($categoria['nombre']) }}"
                        data-descripcion="{{ strtolower($categoria['descripcion']) }}">
                        <td>{{ $categoria['nombre'] }}</td>
                        <td>{{ $categoria['descripcion'] }}</td>
                        <td>
                            {{ $categoria['activo'] === 1 ? 'Activa' : 'Inactiva' }}
                        </td>
                        <td>
                            <button>Editar</button>
                            <button
                                wire:click="cambiarEstado({{ $categoria['id_categoria'] }}, {{ $categoria['activo'] === 1 ? 0 : 1 }})"
                                wire:loading.attr="disabled">
                                <span class="block" wire:loading.class="hidden"
                                    wire:target="cambiarEstado({{ $categoria['id_categoria'] }}, {{ $categoria['activo'] === 1 ? 0 : 1 }})">
                                    {{ $categoria['activo'] === 1 ? 'Desactivar' : 'Activar' }}
                                </span>
                                <span class="hidden" wire:loading.class.remove="hidden"
                                    wire:target="cambiarEstado({{ $categoria['id_categoria'] }}, {{ $categoria['activo'] === 1 ? 0 : 1 }})">
                                    Procesando...
                                </span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div>
            <h1>Crear categoría</h1>
            <form wire:submit.prevent="crearCategoria">
                <input type="text" wire:model.live="nombre">
                @error('nombre')
                    <span>{{ $message }}</span>
                @enderror

                <input type="text" wire:model.live="descripcion">
                @error('descripcion')
                    <span>{{ $message }}</span>
                @enderror

                <select wire:model.live="activo">
                    <option value="null">Elija una opción...</option>
                    <option value="1">Activa</option>
                    <option value="0">Inactiva</option>
                </select>
                @error('activo')
                    <span>{{ $message }}</span>
                @enderror

                <button type="submit" wire:loading.attr="disabled" wire:loading.class="pointer-events-none opacity-50"
                    wire:target="crearCategoria">
                    <span class="block" wire:loading.class="hidden" wire:target="crearCategoria">
                        CREAR
                    </span>
                    <span class="hidden" wire:loading.class.remove="hidden" wire:target="crearCategoria">
                        Procesando...
                    </span>
                </button>
            </form>
        </div>

        <div>
            <h1>Actualizar categoría</h1>
            <form wire:submit.prevent="actualizarCategoria">
                <input type="number" wire:model.live="idCategoria">
                @error('idCategoria')
                    <span>{{ $message }}</span>
                @enderror

                <input type="text" wire:model.live="nombre">
                @error('nombre')
                    <span>{{ $message }}</span>
                @enderror

                <input type="text" wire:model.live="descripcion">
                @error('descripcion')
                    <span>{{ $message }}</span>
                @enderror

                <button type="submit" wire:loading.attr="disabled" wire:loading.class="pointer-events-none opacity-50"
                    wire:target="actualizarCategoria">
                    <span class="block" wire:loading.class="hidden" wire:target="actualizarCategoria">
                        ACTUALIZAR
                    </span>
                    <span class="hidden" wire:loading.class.remove="hidden" wire:target="actualizarCategoria">
                        Procesando...
                    </span>
                </button>
            </form>
        </div>
    @else
        <div>
            <p>No hay categorías disponibles</p>
        </div>
    @endif
    @script
        <script>
            Echo.channel('admin')
                .listen('.ActualizarCategoria', (e) => {
                    $wire.cargarCategorias();
                })
        </script>
    @endscript
</div>
