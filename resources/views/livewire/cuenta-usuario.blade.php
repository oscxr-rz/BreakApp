<div>
    @if (!session('id'))
        <p>Inicie sesión para acceder a los datos de su cuenta</p>
    @elseif(!empty($usuario))
        @if (session('mensaje'))
            {{ session('mensaje') }}
        @endif
        <form wire:submit.prevent="actualizarImg">
            <img src="{{ $usuario['imagen_url'] }}" alt="imagen_usuario_{{ $usuario['id_usuario'] }}">

            <input type="file" wire:model="imagen" accept="image/png,image/jpeg">

            @error('imagen')
                <span>{{ $message }}</span>
            @enderror

            <button type="submit" wire:loading.attr="disabled" wire:loading.class="pointer-events-none opacity-50"
                wire:target="actualizarImg">
                <span class="block" wire:loading.class="hidden" wire:target="actualizarImg">
                    Actualizar
                </span>
                <span class="hidden" wire:loading.class.remove="hidden" wire:target="actualizarImg">
                    Procesando...
                </span>
            </button>
        </form>
        <form wire:submit.prevent="actualizarDatos">
            <input type="text" wire:model.live="nombre">
            @error('nombre')
                <span>{{ $message }}</span>
            @enderror

            <input type="text" wire:model.live="apellido">
            @error('apellido')
                <span>{{ $message }}</span>
            @enderror

            <input type="email" wire:model.live="email">
            @error('email')
                <span>{{ $message }}</span>
            @enderror

            <input type="number" wire:model.live="telefono">
            @error('telefono')
                <span>{{ $message }}</span>
            @enderror

            <div class="w-full">
                <select wire:model.live="semestre"
                    class="appearance-none w-full px-3 py-2 border border-gray-300 text-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200 cursor-pointer">
                    <option value="" class="text-gray-500">Semestre (Opcional)</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
                @error('semestre')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <select wire:model.live="grupo"
                    class="appearance-none w-full px-3 py-2 border border-gray-300 text-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200 cursor-pointer">
                    <option value="" class="text-gray-500">Grupo (Opcional)</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                    <option value="F">F</option>
                    <option value="G">G</option>
                </select>
                @error('grupo')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:loading.class="pointer-events-none opacity-50"
                wire:target="actualizarDatos">
                <span class="block" wire:loading.class="hidden" wire:target="actualizarDatos">
                    Actualizar
                </span>
                <span class="hidden" wire:loading.class.remove="hidden" wire:target="actualizarDatos">
                    Procesando...
                </span>
            </button>
        </form>
        <form wire:submit.prevent="actualizarPassword">
            <div>
                <input type="password" wire:model.live="password" autocomplete="new-password"
                    class="appearance-none w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                    placeholder="Contraseña actual">
                @error('password')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <input type="password" wire:model.live="newPassword" autocomplete="new-password"
                    class="appearance-none w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                    placeholder="Nueva contraseña">
                @error('newPassword')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:loading.class="pointer-events-none opacity-50"
                wire:target="actualizarPassword">
                <span class="block" wire:loading.class="hidden" wire:target="actualizarPassword">
                    Actualizar
                </span>
                <span class="hidden" wire:loading.class.remove="hidden" wire:target="actualizarPassword">
                    Procesando...
                </span>
            </button>
        </form>
        <form wire:submit.prevent="desactivarCuenta">
            <input type="password" wire:model.live="password" autocomplete="new-password"
                class="appearance-none w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                placeholder="Contraseña">
            @error('password')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror

            <button type="submit" wire:loading.attr="disabled" wire:loading.class="pointer-events-none opacity-50"
                wire:target="desactivarCuenta">
                <span class="block" wire:loading.class="hidden" wire:target="desactivarCuenta">
                    Desactivar
                </span>
                <span class="hidden" wire:loading.class.remove="hidden" wire:target="desactivarCuenta">
                    Procesando...
                </span>
            </button>
        </form>
    @else
        <p>No se pudo acceder a los datos de su cuenta</p>
    @endif
</div>
