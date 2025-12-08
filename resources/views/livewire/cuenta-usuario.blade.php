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

            <!-- Mostrar preview mientras se sube -->
            <div wire:loading wire:target="imagen">Subiendo...</div>

            @if ($imagen)
                <div>
                    <img src="{{ $imagen->temporaryUrl() }}" width="200">
                </div>
            @endif

            <button type="submit" wire:loading.attr="disabled" wire:target="actualizarImg">
                <span wire:loading.remove wire:target="actualizarImg">ACTUALIZAR IMAGEN</span>
                <span wire:loading wire:target="actualizarImg">Procesando...</span>
            </button>
        </form>
        <form action="">
            <label for=""></label>
            <input type="text" name="" id="" value="{{ $usuario['nombre'] }}">
            <input type="text" name="" id="" value="{{ $usuario['apellido'] }}">
            <input type="text" name="" id="" value="{{ $usuario['email'] }}">
            <input type="text" name="" id="" value="{{ $usuario['telefono'] }}">
            <input type="text" name="" id="" value="{{ $semestre }}">
            <input type="text" name="" id="" value="{{ $grupo }}">
        </form>
        <form action="">
            <input type="password" name="" id="">
            <input type="password" name="" id="">
        </form>
        <form action="">
            <button></button>
        </form>
    @else
        <p>No se pudo acceder a los datos de su cuenta</p>
    @endif
</div>
