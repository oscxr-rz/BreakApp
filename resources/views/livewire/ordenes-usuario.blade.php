<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div
        class="bg-[#951327] border-b border-gray-100 px-4 py-4 flex items-center justify-between sticky top-0 z-10 shadow-sm">
        <button onclick="window.history.back()"
            class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/10 transition-colors">
            <svg class="w-6 h-6 text-[#FBE8Da]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <h1 class="text-lg font-semibold text-[#FBE8Da]">Mis Ordenes</h1>
        <div class="w-10"></div>
    </div>

    @if (!session('id'))
        <div class="max-w-md mx-auto pt-20 px-4">
            <div class="bg-white rounded-2xl shadow-sm p-8 text-center border border-gray-100">
                <div class="w-20 h-20 bg-[#FBE8DA] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-[#951327]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Acceso Requerido</h2>
                <p class="text-gray-500 text-sm mb-6">Inicie sesión para ver sus órdenes</p>
                <a href="{{ route('login') }}"
                    class="inline-block w-full py-3 bg-[#951327] text-white rounded-xl font-medium hover:bg-[#B50001] transition-colors">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    @elseif (!empty($ordenes))
        <div class="max-w-2xl mx-auto pb-24">
            <!-- Filtros -->
            <div class="bg-white border-b border-gray-100 px-4 py-3">
                <div class="flex gap-2 overflow-x-auto">
                    <button data-valor=""
                        class="filtro-estado px-4 py-2 rounded-lg bg-[#951327] text-white text-sm font-medium whitespace-nowrap">
                        Todas
                    </button>
                    <button data-valor="PENDIENTE"
                        class="filtro-estado px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 text-sm font-medium whitespace-nowrap hover:border-[#951327] hover:text-[#951327] transition-all">
                        Pendiente
                    </button>
                    <button data-valor="PREPARANDO"
                        class="filtro-estado px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 text-sm font-medium whitespace-nowrap hover:border-[#951327] hover:text-[#951327] transition-all">
                        Preparando
                    </button>
                    <button data-valor="LISTO"
                        class="filtro-estado px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 text-sm font-medium whitespace-nowrap hover:border-[#951327] hover:text-[#951327] transition-all">
                        Listo
                    </button>
                    <button data-valor="ENTREGADO"
                        class="filtro-estado px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 text-sm font-medium whitespace-nowrap hover:border-[#951327] hover:text-[#951327] transition-all">
                        Entregado
                    </button>
                </div>
            </div>

            <!-- Lista de Órdenes -->
            <div id="lista" class="p-4 space-y-4">
                @foreach ($ordenes as $orden)
                    <div class="orden bg-white rounded-2xl shadow-sm overflow-hidden border {{ $orden['vencido'] === 1 ? 'border-red-300' : 'border-gray-100' }}"
                        data-estado="{{ $orden['estado'] }}" data-pagado="{{ $orden['pagado'] }}">

                        @if ($orden['vencido'] === 1)
                            <!-- Banner de orden vencida -->
                            <div class="bg-red-50 border-b border-red-200 px-6 py-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium text-red-700">Esta orden ha vencido</span>
                            </div>
                        @endif

                        <div class="px-6 py-6">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs text-gray-500">Orden #{{ $orden['id_orden'] }}</span>
                                        <span class="badge px-2.5 py-0.5 rounded-full text-white text-xs font-medium"
                                            data-estado="{{ $orden['estado'] }}">
                                            {{ $orden['estado'] }}
                                        </span>
                                    </div>
                                    <p class="text-3xl font-bold text-gray-900">${{ number_format($orden['total'], 2) }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    @if ($orden['pagado'] === 1)
                                        <!-- Botón Descargar Ticket -->
                                        <button wire:click="obtenerTicket({{ $orden['id_orden'] }})"
                                            wire:loading.attr="disabled" wire:loading.class="opacity-50"
                                            class="group relative shrink-0 bg-white hover:bg-[#FBE8DA] p-2 rounded-xl transition-colors border border-gray-200"
                                            title="Descargar ticket">
                                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span
                                                class="absolute bottom-full right-0 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                Descargar ticket
                                            </span>
                                        </button>
                                    @endif
                                    @if ($orden['estado'] === 'ENTREGADO' || $orden['vencido'] === 1)
                                        <!-- Botón Eliminar -->
                                        <button wire:click="ocultarOrden({{ $orden['id_orden'] }})"
                                            wire:loading.attr="disabled" wire:loading.class="opacity-50"
                                            class="group relative shrink-0 bg-white hover:bg-red-50 p-2 rounded-xl transition-colors border border-gray-200"
                                            title="Eliminar orden">
                                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span
                                                class="absolute bottom-full right-0 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                Eliminar orden
                                            </span>
                                        </button>
                                    @endif

                                    <!-- Botón QR -->
                                    <button
                                        onclick="mostrarQR('{{ $orden['imagen_url'] }}', '{{ $orden['id_orden'] }}')"
                                        class="shrink-0 bg-white hover:bg-gray-50 p-2 rounded-xl transition-colors border border-gray-200">
                                        <img src="{{ $orden['imagen_url'] }}" alt="QR"
                                            class="w-16 h-16 rounded-lg">
                                    </button>
                                </div>
                            </div>

                            <!-- Mensaje de pago pendiente -->
                            @if ($orden['pagado'] === 0 && !empty($orden['fecha_vencimiento']))
                                <div class="mb-4 p-3 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-3">
                                    <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm text-amber-800">
                                        <span class="font-semibold">Paga tu orden antes de <span class="fecha-vencimiento" data-timestamp="{{ $orden['fecha_vencimiento'] }}"></span></span> para comenzar a prepararla
                                    </p>
                                </div>
                            @endif

                            <!-- Info -->
                            <div class="flex flex-wrap items-center gap-3 mb-4">
                                @if ($orden['estado'] !== 'ENTREGADO' && !empty($orden['hora_recogida']))
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-[#951327]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="hora-recogida" data-timestamp="{{ $orden['hora_recogida'] }}"></span>
                                    </div>
                                @endif

                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-[#951327]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <span>{{ $orden['metodo_pago'] }}</span>
                                </div>

                                <span class="px-2.5 py-1 rounded-full text-xs font-medium border"
                                    style="background-color: {{ $orden['pagado'] === 1 ? '#dcfce7' : '#FBE8DA' }}; 
                                           color: {{ $orden['pagado'] === 1 ? '#166534' : '#951327' }};
                                           border-color: {{ $orden['pagado'] === 1 ? '#bbf7d0' : '#FCC88A' }}">
                                    {{ $orden['pagado'] === 1 ? 'Pagado' : 'Pendiente' }}
                                </span>

                                @if (!empty($orden['fecha_vencimiento']))
                                    <div
                                        class="flex items-center gap-2 text-sm {{ $orden['vencido'] === 1 ? 'text-red-600' : 'text-gray-600' }}">
                                        <svg class="w-4 h-4 {{ $orden['vencido'] === 1 ? 'text-red-600' : 'text-[#951327]' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="{{ $orden['vencido'] === 1 ? 'font-semibold' : '' }}">
                                            Vence: <span class="fecha-vencimiento" data-timestamp="{{ $orden['fecha_vencimiento'] }}"></span>
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Toggle Productos -->
                            <button onclick="toggleProductos({{ $orden['id_orden'] }})"
                                class="w-full flex items-center justify-between text-sm text-gray-700 hover:text-[#951327] font-medium py-3 border-t border-gray-100 transition-colors">
                                <span class="toggle-text">Ver {{ count($orden['productos']) }} producto(s)</span>
                                <svg class="w-5 h-5 transition-transform text-[#951327]" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>

                        <!-- Productos Ocultos -->
                        <div id="productos-{{ $orden['id_orden'] }}" class="hidden bg-gray-50">
                            <div class="px-6 pb-6 divide-y divide-gray-100">
                                @foreach ($orden['productos'] as $producto)
                                    <div class="py-4 flex items-center gap-4">
                                        <img src="{{ $producto['imagen_url'] }}" alt="{{ $producto['nombre'] }}"
                                            class="w-16 h-16 rounded-xl object-cover shrink-0 border border-gray-100">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between gap-2 mb-1">
                                                <h4 class="font-medium text-gray-900 text-sm">
                                                    {{ $producto['nombre'] }}</h4>
                                                <span
                                                    class="text-xs text-gray-500 whitespace-nowrap">x{{ $producto['cantidad'] }}</span>
                                            </div>
                                            @if (!empty($producto['notas']))
                                                <p class="text-xs text-gray-500 mb-1">{{ $producto['notas'] }}</p>
                                            @endif
                                            <p class="text-sm font-semibold text-gray-900">
                                                ${{ number_format($producto['precio'], 2) }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Sin Resultados -->
            <div id="sinResultados"
                class="hidden bg-white rounded-2xl shadow-sm p-8 text-center mx-4 mt-8 border border-gray-100">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="text-gray-600">No se encontraron órdenes con esos filtros</p>
            </div>
        </div>
    @else
        <!-- Sin Órdenes -->
        <div class="max-w-md mx-auto pt-20 px-4">
            <div class="bg-white rounded-2xl shadow-sm p-8 text-center border border-gray-100">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Aún no tienes pedidos</h2>
                <p class="text-gray-500 text-sm mb-6">Explora el menú y haz tu primer pedido</p>
                <a href="{{ route('index') }}"
                    class="inline-block w-full py-3 bg-[#951327] text-white rounded-xl font-medium hover:bg-[#B50001] transition-colors">
                    Ver Menú
                </a>
            </div>
        </div>
    @endif

    <!-- Modal QR -->
    <div id="modalQR"
        class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        onclick="cerrarQR()">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 border border-gray-100"
            onclick="event.stopPropagation()">
            <h3 class="text-lg font-semibold text-gray-900 text-center mb-1">Código QR</h3>
            <p class="text-sm text-gray-500 text-center mb-4">Orden #<span id="qrOrdenId"></span></p>
            <div class="bg-gray-50 p-4 rounded-xl mb-4 border border-gray-100">
                <img id="qrImagen" alt="QR" class="w-full rounded-lg">
            </div>
            <button onclick="cerrarQR()"
                class="w-full py-3 bg-[#951327] text-white rounded-xl font-medium hover:bg-[#B50001] transition-colors">
                Cerrar
            </button>
        </div>
    </div>

    @push('script')
        <script>
            // Función para formatear fecha MySQL/SQL a "Hoy/Mañana - H:i"
            function formatearFecha(fechaSQL) {
                if (!fechaSQL) return '';
                
                // Convertir fecha SQL (YYYY-MM-DD HH:MM:SS) a objeto Date
                const fecha = new Date(fechaSQL.replace(' ', 'T'));
                const hoy = new Date();
                const manana = new Date(hoy);
                manana.setDate(hoy.getDate() + 1);
                
                // Resetear horas para comparar solo fechas
                const fechaSinHora = new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate());
                const hoySinHora = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate());
                const mananaSinHora = new Date(manana.getFullYear(), manana.getMonth(), manana.getDate());
                
                let dia = '';
                if (fechaSinHora.getTime() === hoySinHora.getTime()) {
                    dia = 'Hoy';
                } else if (fechaSinHora.getTime() === mananaSinHora.getTime()) {
                    dia = 'Mañana';
                } else {
                    // Si no es hoy ni mañana, mostrar día de la semana
                    const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                    dia = dias[fecha.getDay()];
                }
                
                // Formatear hora en formato H:i (24 horas)
                const horas = fecha.getHours().toString().padStart(2, '0');
                const minutos = fecha.getMinutes().toString().padStart(2, '0');
                
                return `${dia} - ${horas}:${minutos}`;
            }
            
            // Aplicar formateo a todas las fechas SQL
            document.addEventListener('DOMContentLoaded', function() {
                // Formatear horas de recogida
                document.querySelectorAll('.hora-recogida').forEach(el => {
                    const fechaSQL = el.dataset.timestamp;
                    if (fechaSQL) {
                        el.textContent = formatearFecha(fechaSQL);
                    }
                });
                
                // Formatear fechas de vencimiento
                document.querySelectorAll('.fecha-vencimiento').forEach(el => {
                    const fechaSQL = el.dataset.timestamp;
                    if (fechaSQL) {
                        el.textContent = formatearFecha(fechaSQL);
                    }
                });
            });

            // Toast notifications
            window.addEventListener('mostrar-toast', event => {
                const tipo = event.detail.tipo;
                const mensaje = event.detail.mensaje;

                const toast = document.createElement('div');
                toast.className = `fixed top-6 right-6 px-6 py-4 rounded-xl shadow-xl z-50 transform transition-all duration-300 border ${
                    tipo === 'exito' 
                        ? 'bg-white text-green-700 border-green-200' 
                        : 'bg-white text-red-700 border-red-200'
                }`;

                toast.innerHTML = `
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            ${tipo === 'exito' 
                                ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>'
                                : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>'
                            }
                        </svg>
                        <span class="font-medium text-sm">${mensaje}</span>
                    </div>
                `;

                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.style.transform = 'translateX(400px)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            });

            // Colores para badges de estado
            document.querySelectorAll('.badge').forEach(b => {
                const e = b.dataset.estado;
                b.style.backgroundColor =
                    e === 'PENDIENTE' ? '#6b7280' :
                    e === 'PREPARANDO' ? '#F3B900' :
                    e === 'LISTO' ? '#951327' :
                    e === 'ENTREGADO' ? '#16a34a' : '#9ca3af';
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
                            'filtro-estado px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 text-sm font-medium whitespace-nowrap hover:border-[#951327] hover:text-[#951327] transition-all';
                    });
                    this.className =
                        'filtro-estado px-4 py-2 rounded-lg bg-[#951327] text-white text-sm font-medium whitespace-nowrap';
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