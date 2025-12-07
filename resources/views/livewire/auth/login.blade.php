<div>
    <h1>Iniciar Sesión</h1>
    @if (session('mensaje'))
        <p>{{ session('mensaje') }}</p>
    @endif
    @error('error')
        {{ $message }}
    @enderror
    <form wire:submit.prevent="iniciarSesion">

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

        <button type="submit" wire:loading.attr="disabled" wire:loading.class="pointer-events-none opacity-50"
            wire:target="iniciarSesion">
            <span class="block" wire:loading.class="hidden" wire:target="iniciarSesion">
                Iniciar Sesión
            </span>
            <span class="hidden" wire:loading.class.remove="hidden" wire:target="iniciarSesion">
                Procesando...
            </span>
        </button>
    </form>
</div>