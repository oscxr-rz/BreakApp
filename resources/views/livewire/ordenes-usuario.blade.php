<div class="min-h-screen bg-gray-50 py-6">
    <div class="container mx-auto px-4 max-w-4xl">

        @if (!session('id'))
            <!-- Sin sesión -->
            <div class="bg-white rounded-2xl p-8 shadow-sm text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Inicia sesión para ver tus pedidos</h2>
                <a href="{{ route('login') }}"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition mt-4">
                    Iniciar Sesión
                </a>
            </div>
        @elseif (!empty($ordenes))
            <!-- Filtros -->
            <div class="bg-white rounded-xl p-4 shadow-sm mb-4">
                <div class="flex gap-2 overflow-x-auto">
                    <button data-tipo="estado" data-valor=""
                        class="filtro-estado px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium whitespace-nowrap">
                        Todas
                    </button>
                    <button data-tipo="estado" data-valor="EN_PREPARACION"
                        class="filtro-estado px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium whitespace-nowrap hover:bg-gray-200">
                        Preparando
                    </button>
                    <button data-tipo="estado" data-valor="LISTO"
                        class="filtro-estado px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium whitespace-nowrap hover:bg-gray-200">
                        Listo
                    </button>
                    <button data-tipo="estado" data-valor="ENTREGADO"
                        class="filtro-estado px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium whitespace-nowrap hover:bg-gray-200">
                        Entregado
                    </button>
                </div>
            </div>

            <!-- Lista de Órdenes -->
            <div id="lista" class="space-y-4">
                @foreach ($ordenes as $orden)
                    <div class="orden bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition"
                        data-estado="{{ $orden['estado'] }}" data-pagado="{{ $orden['pagado'] }}">

                        <div class="p-5">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-sm text-gray-500">Orden #{{ $orden['id_orden'] }}</span>
                                        <span class="badge px-2 py-0.5 rounded text-white text-xs font-medium"
                                            data-estado="{{ $orden['estado'] }}">
                                            {{ $orden['estado'] === 'EN_PREPARACION' ? 'PREPARANDO' : str_replace('_', ' ', $orden['estado']) }}
                                        </span>
                                    </div>
                                    <p class="text-2xl font-bold text-gray-900">${{ number_format($orden['total'], 2) }}
                                    </p>
                                </div>

                                <button onclick="mostrarQR('{{ $orden['imagen_url'] }}', '{{ $orden['id_orden'] }}')"
                                    class="bg-gray-100 hover:bg-gray-200 p-2 rounded-lg transition">
                                    <img src="{{ $orden['imagen_url'] }}" alt="QR" class="w-16 h-16 rounded">
                                </button>
                            </div>

                            <!-- Info -->
                            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                                <span>🕐 {{ $orden['hora_recogida'] }}</span>
                                <span>{{ $orden['metodo_pago'] }}</span>
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium"
                                    style="background-color: {{ $orden['pagado'] === 1 ? '#dcfce7' : '#fef9c3' }}; color: {{ $orden['pagado'] === 1 ? '#166534' : '#854d0e' }}">
                                    {{ $orden['pagado'] === 1 ? 'Pagado' : 'Pendiente' }}
                                </span>
                            </div>

                            <!-- Productos -->
                            <button onclick="toggleProductos({{ $orden['id_orden'] }})"
                                class="w-full text-left text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                                <span class="toggle-text">Ver {{ count($orden['productos']) }} producto(s)</span>
                                <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Productos Ocultos -->
                            <div id="productos-{{ $orden['id_orden'] }}" class="hidden mt-4 pt-4 border-t space-y-3">
                                @foreach ($orden['productos'] as $producto)
                                    <div class="flex gap-3">
                                        <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}"
                                            class="w-16 h-16 rounded-lg object-cover">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between gap-2">
                                                <h4 class="font-medium text-gray-900">{{ $producto['nombre'] }}</h4>
                                                <span
                                                    class="text-sm text-gray-500 whitespace-nowrap">x{{ $producto['cantidad'] }}</span>
                                            </div>
                                            @if (!empty($producto['notas']))
                                                <p class="text-xs text-gray-600 mt-1">{{ $producto['notas'] }}</p>
                                            @endif
                                            <p class="text-sm font-semibold text-gray-900 mt-1">
                                                ${{ number_format($producto['precio'], 2) }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach

                                @if ($orden['estado'] === 'ENTREGADO')
                                    <button wire:click="ocultarOrden({{ $orden['id_orden'] }})"
                                        class="w-full mt-2 text-sm text-red-600 hover:text-red-700 font-medium">
                                        Eliminar orden
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Sin Resultados -->
            <div id="sinResultados" class="hidden bg-white rounded-xl p-8 shadow-sm text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="text-gray-600">No se encontraron órdenes con esos filtros</p>
            </div>
        @else
            <!-- Sin Órdenes -->
            <div class="bg-white rounded-xl p-8 shadow-sm text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Aún no tienes pedidos</h2>
                <a href="{{ route('index') }}"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition mt-4">
                    Ver Menú
                </a>
            </div>
        @endif
    </div>

    <!-- Modal QR -->
    <div id="modalQR" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
        onclick="cerrarQR()">
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full" onclick="event.stopPropagation()">
            <h3 class="text-lg font-semibold text-gray-900 mb-1 text-center">Código QR</h3>
            <p class="text-sm text-gray-500 text-center mb-4">Orden #<span id="qrOrdenId"></span></p>
            <div class="bg-gray-50 p-4 rounded-xl mb-4">
                <img id="qrImagen" alt="QR" class="w-full rounded-lg">
            </div>
            <button onclick="cerrarQR()"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-medium transition">
                Cerrar
            </button>
        </div>
    </div>

    @push('script')
        <script>
            // Colores para badges de estado
            document.querySelectorAll('.badge').forEach(b => {
                const e = b.dataset.estado;
                b.className += e === 'EN_PREPARACION' ? ' bg-yellow-500' :
                    e === 'LISTO' ? ' bg-blue-500' :
                    e === 'ENTREGADO' ? ' bg-green-500' : ' bg-gray-500';
            });

            let estadoFiltro = '';

            function filtrar() {
                const ordenes = Array.from(document.querySelectorAll('.orden'));
                let visibles = ordenes.filter(o => !estadoFiltro || o.dataset.estado === estadoFiltro);

                ordenes.forEach(o => o.style.display = 'none');

                if (visibles.length) {
                    visibles.forEach(o => o.style.display = 'block');
                    document.getElementById('sinResultados').classList.add('hidden');
                } else {
                    document.getElementById('sinResultados').classList.remove('hidden');
                }
            }

            document.querySelectorAll('.filtro-estado').forEach(b => {
                b.addEventListener('click', function() {
                    document.querySelectorAll('.filtro-estado').forEach(f => {
                        f.className =
                            'filtro-estado px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium whitespace-nowrap hover:bg-gray-200';
                    });
                    this.className =
                        'filtro-estado px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium whitespace-nowrap';
                    estadoFiltro = this.dataset.valor;
                    filtrar();
                });
            });

            function toggleProductos(ordenId) {
                const productos = document.getElementById(`productos-${ordenId}`);
                const button = event.currentTarget;
                const text = button.querySelector('.toggle-text');
                const icon = button.querySelector('svg');

                if (productos.classList.contains('hidden')) {
                    productos.classList.remove('hidden');
                    text.textContent = text.textContent.replace('Ver', 'Ocultar');
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    productos.classList.add('hidden');
                    text.textContent = text.textContent.replace('Ocultar', 'Ver');
                    icon.style.transform = 'rotate(0deg)';
                }
            }

            function mostrarQR(url, id) {
                document.getElementById('qrImagen').src = url;
                document.getElementById('qrOrdenId').textContent = id;
                document.getElementById('modalQR').classList.remove('hidden');
            }

            function cerrarQR() {
                document.getElementById('modalQR').classList.add('hidden');
            }
        </script>
    @endpush
</div>
