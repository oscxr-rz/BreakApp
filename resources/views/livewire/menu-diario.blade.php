<div>
    @if (!empty($menu))
        <h1>Menú del Día - {{ $menu['fecha'] }}</h1>

        @foreach ($menu['productos'] as $categoria => $productos)
            <h2>{{ $categoria }}</h2>

            <ul>
                @foreach ($productos as $producto)
                    <li>
                        <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}">
                        <strong>{{ $producto['nombre'] }}</strong> - ${{ $producto['precio'] }}
                        <br>
                        {{ $producto['descripcion'] }}
                        <br>
                        Tiempo: {{ $producto['tiempo_preparacion'] }}
                        <br>
                        Disponibles: {{ $producto['cantidad_disponible'] }}
                        <br><br>
                    </li>
                @endforeach
            </ul>
        @endforeach
    @else
        <p>No hay menú disponible</p>
    @endif
</div>
