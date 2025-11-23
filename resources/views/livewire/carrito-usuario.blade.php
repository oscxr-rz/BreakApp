<div>
    @if (!empty($carrito['productos']))

        @if (session('mensaje'))
            <p>{{ session('mensaje') }}</p>
        @endif
        @foreach ($carrito['productos'] as $categoria => $productos)
            <h2>{{ $categoria }}</h2>

            <ul>
                @foreach ($productos as $producto)
                    <li class="{{ $producto['activoAhora'] === 0 ? 'bg-red-600' : 'bg-green-600' }}">
                        <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}">
                        <strong>{{ $producto['nombre'] }}</strong> - ${{ $producto['precio_unitario'] }}
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
        <div>
            <h1>Comprar carrito</h1>
            <p>Productos: {{ collect($carrito['productos'])->flatten(1)->where('activoAhora', 1)->sum('cantidad') }}
            </p>
            <p>Total:
                {{ number_format(
                    collect($carrito['productos'])->flatten(1)->where('activoAhora', 1)->sum(function ($producto) {
                            return $producto['precio_unitario'] * $producto['cantidad'];
                        }),
                    2,
                ) }}
            </p>
            <form action="{{ route('carrito.comprar') }}" method="POST">
                @csrf
                <input type="hidden" name="productos" id=""
                    value="{{ json_encode([collect($carrito['productos'])->flatten(1)->where('activoAhora', 1)]) }}">
                <select name="metodo_pago" id="">
                    <option value="EFECTIVO">EFECTIVO</option>
                    <option value="SALDO">TARJETA LOCAL</option>
                </select>
                <input type="time" name="hora_recogida" id="">
                <button type="submit">COMPRAR</button>
            </form>
        </div>
    @elseif (!session('idUsuario'))
        <p>Inicie sesion o cree una cuenta para acceder al carrito</p>
    @else
        <p>No hay productos en el carrito</p>
    @endif
</div>
