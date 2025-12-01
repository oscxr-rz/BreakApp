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
                                wire:click="cambiarEstado({{ $categoria['id_categoria'] }}, {{ $categoria['activo'] === 1 ? 0 : 1 }})">
                                <span
                                    wire:loading.remove>{{ $categoria['activo'] === 1 ? 'Desactivar' : 'Activar' }}</span>
                                <span wire:loading>Procesando...</span></button>
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

                <button type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove>CREAR</span>
                    <span wire:loading>Procesando...</span>
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

                <button type="submit" wire:loading.attr="disabled">
                    <span wire:loading.remove>Actualizar</span>
                    <span wire:loading>Procesando...</span>
                </button>
            </form>
        </div>
    @else
        <div>
            <p>No hay categorías disponibles</p>
        </div>
    @endif
</div>
