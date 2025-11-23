<div>
    @if (!empty($carrito['productos']))

        @if (Session::has('mensaje'))
            <div>
                {{ Session::get('mensaje') }}
            </div>
        @endif
        @foreach ($carrito['productos'] as $categoria => $productos)
            <h2>{{ $categoria }}</h2>

            <ul>
                @foreach ($productos as $producto)
                    <li class="{{ $producto['activoAhora'] === 0 ? 'bg-red-600' : 'bg-green-600' }}">
                        <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}">
                        <strong>{{ $producto['nombre'] }}</strong> - ${{ $producto['precio'] }}
                        <br>
                        {{ $producto['descripcion'] }}
                        <br>
                        Tiempo: {{ $producto['tiempo_preparacion'] }}
                        <br>
                        Cantidad: {{ $producto['cantidad'] }}
                        <br><br>

                        <button wire:click="agregarAlCarrito({{ $producto['id_producto'] }}, 1)"
                            class="text-cyan-300 text-5xl">+</button>

                        <button wire:click="eliminarAlCarrito({{ $producto['id_producto'] }}, 1)"
                            class="text-cyan-300 text-5xl">-</button>

                        <button wire:click="quitarDelCarrito({{ $producto['id_producto'] }}, 1)">🗑️</button>
                    </li>
                @endforeach
            </ul>
        @endforeach
    @else
        <p>No hay productos en el carrito</p>
    @endif
</div>
