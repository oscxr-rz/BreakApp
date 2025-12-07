<div>
    @if (!empty($carrito['productos']))

        @if (session('mensaje'))
            <p>{{ session('mensaje') }}</p>
        @endif
        @error('error')
            {{ $message }}
        @enderror
        @foreach ($carrito['productos'] as $categoria => $productos)
            <h2>{{ $categoria }}</h2>

            <ul>
                @foreach ($productos as $producto)
                    <li
                        class="{{ $producto['activoAhora'] === 1 && $producto['disponible'] ? 'bg-green-600' : 'bg-red-600' }}">
                        <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}">
                        <strong>{{ $producto['nombre'] }}</strong> - ${{ $producto['precio_unitario'] }}
                        <br>
                        {{ $producto['descripcion'] }}
                        <br>
                        Tiempo: {{ $producto['tiempo_preparacion'] }}
                        <br>
                        Cantidad: {{ $producto['cantidad'] }}
                        <br>
                        Disponibles: {{ $producto['cantidad_disponible'] }}
                        <br><br>

                        <button wire:click="agregarAlCarrito({{ $producto['id_producto'] }}, 1)"
                            wire:loading.attr="disabled" class="text-cyan-300 text-5xl">
                            <span class="block" wire:loading.class="hidden"
                                wire:target="agregarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                +
                            </span>
                            <span class="hidden" wire:loading.class.remove="hidden"
                                wire:target="agregarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                Procesando...
                            </span>
                        </button>

                        <button wire:click="eliminarAlCarrito({{ $producto['id_producto'] }}, 1)"
                            wire:loading.attr="disabled" class="text-cyan-300 text-5xl">
                            <span class="block" wire:loading.class="hidden"
                                wire:target="eliminarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                -
                            </span>
                            <span class="hidden" wire:loading.class.remove="hidden"
                                wire:target="eliminarAlCarrito({{ $producto['id_producto'] }}, 1)">
                                Procesando...
                            </span>
                        </button>

                        <button wire:click="quitarDelCarrito({{ $producto['id_producto'] }})"
                            wire:loading.attr="disabled">
                            <span class="block" wire:loading.class="hidden"
                                wire:target="quitarDelCarrito({{ $producto['id_producto'] }})">
                                🗑️
                            </span>
                            <span class="hidden" wire:loading.class.remove="hidden"
                                wire:target="quitarDelCarrito({{ $producto['id_producto'] }})">
                                Procesando...
                            </span>
                        </button>
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
            <form wire:submit.prevent="comprarCarrito">
                <select wire:model.live="metodo_pago">
                    <option value="EFECTIVO">EFECTIVO</option>
                    <option value="SALDO">TARJETA LOCAL</option>
                </select>
                @error('metodo_pago')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <input type="time" wire:model.live="hora_recogida">
                @error('hora_recogida')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                @error('productos')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <button type="submit" wire:loading.attr="disabled" wire:loading.class="pointer-events-none opacity-50"
                    wire:target="comprarCarrito">
                    <span class="block" wire:loading.class="hidden" wire:target="comprarCarrito">
                        COMPRAR
                    </span>
                    <span class="hidden" wire:loading.class.remove="hidden" wire:target="comprarCarrito">
                        Procesando...
                    </span>
                </button>
            </form>
        </div>
    @elseif (!session('idUsuario'))
        <p>Inicie sesion o cree una cuenta para acceder al carrito</p>
    @else
        <p>No hay productos en el carrito</p>
    @endif
    @script
        <script>
            Echo.private('usuario.{{ $id }}')
                .listen('ActualizarCarrito', (e) => {
                    $wire.cargarCarrito();
                })
        </script>
    @endscript
</div>
