<div class="min-h-screen bg-linear-to-br from-[#fff5e6] via-white to-[#ffe8e8] py-8">
    <div class="container mx-auto px-4 max-w-5xl">

        @if (!session('id'))
            <!-- Sin sesión -->
            <div class="bg-white/80 backdrop-blur rounded-3xl p-8 shadow-lg text-center">
                <div class="w-20 h-20 bg-[#951327]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-[#951327]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-[#951327] mb-3">Acceso Requerido</h2>
                <p class="text-[#768e78] mb-6">Inicia sesión para ver tus órdenes</p>
                <a href="{{ route('login') }}"
                    class="inline-block bg-[#951327] hover:bg-[#ea5f3a] text-white px-6 py-3 rounded-xl font-semibold transition-all">
                    Iniciar Sesión
                </a>
            </div>
        @elseif (!empty($ordenes))
            <!-- Filtros -->
            <div class="bg-white/80 backdrop-blur rounded-2xl p-4 shadow-sm mb-6">
                <!-- Filtros por Estado -->
                <div class="mb-3">
                    <p class="text-xs font-semibold text-gray-500 mb-2 uppercase">Estado de Orden</p>
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        <button data-tipo="estado" data-valor=""
                            class="filtro-estado px-3 py-2 rounded-lg bg-[#951327] text-white text-sm font-medium whitespace-nowrap">Todas</button>
                        <button data-tipo="estado" data-valor="EN_PREPARACION"
                            class="filtro-estado px-3 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium whitespace-nowrap border">Preparando</button>
                        <button data-tipo="estado" data-valor="LISTO"
                            class="filtro-estado px-3 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium whitespace-nowrap border">Listo</button>
                        <button data-tipo="estado" data-valor="ENTREGADO"
                            class="filtro-estado px-3 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium whitespace-nowrap border">Entregado</button>
                    </div>
                </div>

                <!-- Filtros por Pago -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 mb-2 uppercase">Estado de Pago</p>
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        <button data-tipo="pago" data-valor=""
                            class="filtro-pago px-3 py-2 rounded-lg bg-[#951327] text-white text-sm font-medium whitespace-nowrap">Todos</button>
                        <button data-tipo="pago" data-valor="1"
                            class="filtro-pago px-3 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium whitespace-nowrap border">Pago
                            Completo</button>
                        <button data-tipo="pago" data-valor="0"
                            class="filtro-pago px-3 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium whitespace-nowrap border">Pago
                            Pendiente</button>
                    </div>
                </div>
            </div>

            <!-- Lista de Órdenes -->
            <div id="lista" class="space-y-6">
                @foreach ($ordenes as $orden)
                    <div class="orden bg-white/80 backdrop-blur rounded-3xl shadow-lg overflow-hidden hover:shadow-xl transition-all"
                        data-estado="{{ $orden['estado'] }}" data-pagado="{{ $orden['pagado'] }}">

                        <!-- Contenido Principal -->
                        <div class="p-5">
                            <div class="flex flex-col md:flex-row gap-5">
                                <!-- QR Grande a la Izquierda -->
                                <div class="flex-shrink-0">
                                    <button
                                        onclick="mostrarQR('{{ $orden['imagen_url'] }}', '{{ $orden['id_orden'] }}')"
                                        class="group relative block">
                                        <div
                                            class="bg-linear-to-br from-[#f2cc88]/20 to-[#fcc88a]/10 p-3 rounded-2xl">
                                            <img src="{{ $orden['imagen_url'] }}" alt="QR"
                                                class="w-32 h-32 md:w-40 md:h-40 rounded-xl">
                                        </div>
                                        <div
                                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-2xl flex items-center justify-center">
                                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                            </svg>
                                        </div>
                                    </button>
                                    <p class="text-xs text-center text-gray-500 mt-2">Click para ampliar</p>
                                </div>

                                <!-- Detalles de la Orden -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-3 mb-3">
                                        <div>
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-gray-600 text-sm font-medium">Orden
                                                    #{{ $orden['id_orden'] }}</span>
                                                <span
                                                    class="badge px-2.5 py-1 rounded-full text-white text-xs font-semibold"
                                                    data-estado="{{ $orden['estado'] }}">
                                                    {{ $orden['estado'] === 'EN_PREPARACION' ? 'PREPARANDO' : str_replace('_', ' ', $orden['estado']) }}
                                                </span>
                                            </div>
                                            <p class="text-3xl font-bold text-[#951327] mb-2">
                                                ${{ number_format($orden['total'], 2) }}</p>
                                        </div>

                                        <div class="text-right bg-[#f2cc88]/20 px-3 py-2 rounded-xl">
                                            <p class="text-xs text-gray-600">Recoger a las</p>
                                            <p class="text-xl font-bold text-[#951327]">{{ $orden['hora_recogida'] }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center gap-2 text-sm">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            <span class="text-gray-700 font-medium">{{ $orden['metodo_pago'] }}</span>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="px-2.5 py-1 rounded-full font-semibold text-xs"
                                                style="background-color: {{ $orden['pagado'] === 1 ? '#86efac' : '#fef08a' }}; color: {{ $orden['pagado'] === 1 ? '#166534' : '#854d0e' }}">
                                                {{ $orden['pagado'] === 1 ? 'PAGO COMPLETO' : 'PAGO PENDIENTE' }}
                                            </span>
                                        </div>

                                        <div class="flex items-center gap-2 text-sm">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            <span class="text-gray-700">{{ count($orden['productos']) }}
                                                producto(s)</span>
                                        </div>
                                    </div>

                                    <!-- Botón Ver Productos -->
                                    <button onclick="toggleProductos({{ $orden['id_orden'] }})"
                                        class="w-full bg-[#951327] hover:bg-[#ea5f3a] text-white px-4 py-2.5 rounded-xl font-semibold transition-all flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                        <span class="toggle-text">Ver Productos</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Productos (Ocultos por defecto) -->
                            <div id="productos-{{ $orden['id_orden'] }}"
                                class="hidden mt-5 pt-5 border-t border-gray-200">
                                <h3 class="text-lg font-bold text-[#951327] mb-4">Productos</h3>
                                <div class="space-y-3">
                                    @foreach ($orden['productos'] as $producto)
                                        <div class="flex gap-3 pb-3 border-b last:border-0 border-gray-100">
                                            <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}"
                                                class="w-20 h-20 rounded-xl object-cover shadow-sm">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start justify-between gap-2">
                                                    <h4 class="font-bold text-[#951327]">{{ $producto['nombre'] }}
                                                    </h4>
                                                    <span
                                                        class="bg-gray-100 px-2 py-0.5 rounded-lg text-sm font-semibold text-[#768e78] whitespace-nowrap">x{{ $producto['cantidad'] }}</span>
                                                </div>
                                                @if (!empty($producto['notas']))
                                                    <p
                                                        class="text-xs text-[#951327] bg-[#f2cc88]/20 px-2 py-1 rounded-lg inline-block mt-1">
                                                        {{ $producto['notas'] }}</p>
                                                @endif
                                                <p class="text-lg font-bold text-[#951327] mt-1">
                                                    ${{ number_format($producto['precio'], 2) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($orden['estado'] === 'ENTREGADO')
                                    <button wire:click="ocultarOrden({{ $orden['id_orden'] }})"
                                        wire:loading.attr="disabled"
                                        class="w-full mt-4 bg-red-500 hover:bg-red-600 disabled:bg-gray-300 text-white px-4 py-2.5 rounded-xl font-semibold transition-all">
                                        <span wire:loading.remove
                                            wire:target="ocultarOrden({{ $orden['id_orden'] }})">Eliminar Orden</span>
                                        <span class="hidden" wire:loading.class.remove="hidden"
                                            wire:target="ocultarOrden({{ $orden['id_orden'] }})">Eliminando...</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Sin Resultados -->
            <div id="sinResultados" class="hidden bg-white/80 backdrop-blur rounded-3xl p-8 shadow-lg text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-600">No se encontraron órdenes</h3>
                <p class="text-gray-500 text-sm mt-1">Intenta con otros filtros</p>
            </div>
        @else
            <!-- Sin Órdenes -->
            <div class="bg-white/80 backdrop-blur rounded-3xl p-8 shadow-lg text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-600 mb-2">No hay órdenes aún</h2>
                <p class="text-gray-500 mb-6 text-sm">Cuando realices tu primer pedido aparecerá aquí</p>
                <a href="{{ route('index') }}"
                    class="inline-block bg-[#951327] hover:bg-[#ea5f3a] text-white px-6 py-3 rounded-xl font-semibold transition-all">
                    Ver Menú
                </a>
            </div>
        @endif
    </div>

    <!-- Modal QR -->
    <div id="modalQR"
        class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        onclick="cerrarQR()">
        <div class="bg-white rounded-3xl p-6 max-w-sm w-full animate-fade-in" onclick="event.stopPropagation()">
            <div class="text-center mb-4">
                <h3 class="text-xl font-bold text-[#951327] mb-1">Código QR</h3>
                <p class="text-sm text-gray-600">Orden #<span id="qrOrdenId"></span></p>
            </div>
            <div class="bg-linear-to-br from-[#f2cc88]/20 to-[#fcc88a]/10 p-4 rounded-2xl mb-4">
                <img id="qrImagen" alt="QR" class="w-full rounded-xl">
            </div>
            <p class="text-xs text-center text-gray-600 mb-4">Muestra este código al recoger tu pedido</p>
            <button onclick="cerrarQR()"
                class="w-full bg-[#951327] hover:bg-[#ea5f3a] text-white py-2.5 rounded-xl font-semibold transition-all">
                Cerrar
            </button>
        </div>
    </div>

    <!-- Toast -->
    <div id="toast"
        class="hidden fixed top-5 left-1/2 -translate-x-1/2 text-white px-4 py-3 rounded-xl shadow-xl z-[9999] text-sm font-medium min-w-[280px] items-center gap-2 animate-fade-in">
        <svg id="toastIcon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"></svg>
        <span id="toastMensaje" class="flex-1"></span>
        <button onclick="cerrarToast()" class="hover:bg-white/20 rounded-full p-1 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    @push('script')
        <script>
            // Colores badges
            document.querySelectorAll('.badge').forEach(b => {
                const e = b.dataset.estado;
                b.classList.add(e === 'EN_PREPARACION' ? 'bg-yellow-500' : e === 'LISTO' ? 'bg-blue-500' : e ===
                    'ENTREGADO' ? 'bg-green-500' : 'bg-gray-500');
            });

            let estadoFiltro = '';
            let pagoFiltro = '';

            function filtrar() {
                const ordenes = Array.from(document.querySelectorAll('.orden'));

                let visibles = ordenes.filter(o => {
                    const estado = o.dataset.estado;
                    const pagado = o.dataset.pagado;

                    const coincideEstado = !estadoFiltro || estado === estadoFiltro;
                    const coincidePago = pagoFiltro === '' || pagado === pagoFiltro;

                    return coincideEstado && coincidePago;
                });

                ordenes.forEach(o => o.style.display = 'none');

                if (visibles.length) {
                    visibles.forEach(o => o.style.display = 'block');
                    document.getElementById('sinResultados').classList.add('hidden');
                } else {
                    document.getElementById('sinResultados').classList.remove('hidden');
                }
            }

            // Filtros de estado
            document.querySelectorAll('.filtro-estado').forEach(b => {
                b.addEventListener('click', function() {
                    document.querySelectorAll('.filtro-estado').forEach(f => {
                        f.className =
                            'filtro-estado px-3 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium whitespace-nowrap border';
                    });
                    this.className =
                        'filtro-estado px-3 py-2 rounded-lg bg-[#951327] text-white text-sm font-medium whitespace-nowrap';
                    estadoFiltro = this.dataset.valor;
                    filtrar();
                });
            });

            // Filtros de pago
            document.querySelectorAll('.filtro-pago').forEach(b => {
                b.addEventListener('click', function() {
                    document.querySelectorAll('.filtro-pago').forEach(f => {
                        f.className =
                            'filtro-pago px-3 py-2 rounded-lg bg-white text-gray-700 text-sm font-medium whitespace-nowrap border';
                    });
                    this.className =
                        'filtro-pago px-3 py-2 rounded-lg bg-[#951327] text-white text-sm font-medium whitespace-nowrap';
                    pagoFiltro = this.dataset.valor;
                    filtrar();
                });
            });

            // Toggle productos
            function toggleProductos(ordenId) {
                const productos = document.getElementById(`productos-${ordenId}`);
                const button = event.currentTarget;
                const text = button.querySelector('.toggle-text');
                const icon = button.querySelector('svg');

                if (productos.classList.contains('hidden')) {
                    productos.classList.remove('hidden');
                    text.textContent = 'Ocultar Productos';
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    productos.classList.add('hidden');
                    text.textContent = 'Ver Productos';
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

            function mostrarToast(tipo, mensaje) {
                const toast = document.getElementById('toast');
                const icon = document.getElementById('toastIcon');

                toast.className =
                    'fixed top-5 left-1/2 -translate-x-1/2 text-white px-4 py-3 rounded-xl shadow-xl z-[9999] text-sm font-medium min-w-[280px] flex items-center gap-2 animate-fade-in ' +
                    (tipo === 'exito' ? 'bg-green-500' : 'bg-red-500');

                icon.innerHTML = tipo === 'exito' ?
                    '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>' :
                    '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';

                document.getElementById('toastMensaje').textContent = mensaje;
                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 3000);
            }

            function cerrarToast() {
                document.getElementById('toast').classList.add('hidden');
            }

            window.addEventListener('mensaje-exito', e => mostrarToast('exito', e.detail.mensaje));
            window.addEventListener('mensaje-error', e => mostrarToast('error', e.detail.mensaje));
        </script>
    @endpush
</div>
