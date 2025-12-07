<div>
    <h1>Crear Cuenta</h1>
    @if (session('mensaje'))
        <p>{{ session('mensaje') }}</p>
    @endif
    @error('error')
        {{ $message }}
    @enderror
    <form wire:submit.prevent="crearCuenta">
        <input type="text" wire:model.live="nombre" placeholder="Nombres">
        @error('nombre')
            <span>{{ $message }}</span>
        @enderror

        <input type="text" wire:model.live="apellido" placeholder="Apellidos">
        @error('apellido')
            <span>{{ $message }}</span>
        @enderror

        <input type="email" wire:model.live="email" placeholder="Email">
        @error('email')
            <span>{{ $message }}</span>
        @enderror

        <input type="number" wire:model.live="telefono" placeholder="Teléfono">
        @error('telefono')
            <span>{{ $message }}</span>
        @enderror

        <input type="password" wire:model.live="password" placeholder="Contraseña">
        @error('password')
            <span>{{ $message }}</span>
        @enderror

        <input type="password" wire:model.live="passwordVerificacion" placeholder="Repita la Contraseña">
        @error('passwordVerificacion')
            <span>{{ $message }}</span>
        @enderror

        <select wire:model.live="semestre">
            <option value="null">Seleccione el semestre...</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select>
        @error('semestre')
            <span>{{ $message }}</span>
        @enderror

        <select wire:model.live="grupo">
            <option value="null">Seleccione el grupo...</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
            <option value="G">G</option>
        </select>
        @error('grupo')
            <span>{{ $message }}</span>
        @enderror

        <button type="submit" wire:loading.attr="disabled" wire:loading.class="pointer-events-none opacity-50"
            wire:target="crearCuenta">
            <span class="block" wire:loading.class="hidden" wire:target="crearCuenta">
                CREAR
            </span>
            <span class="hidden" wire:loading.class.remove="hidden" wire:target="crearCuenta">
                Procesando...
            </span>
        </button>
    </form>
</div>
