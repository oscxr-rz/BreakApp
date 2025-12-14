<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-100 px-4 py-4 flex items-center justify-between sticky top-0 z-10">
        <button onclick="window.history.back()"
            class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <h1 class="text-lg font-semibold text-gray-900">Mis Notificaciones</h1>
        <div class="w-10"></div>
    </div>

    @if (!empty($notificaciones))
        <div class="max-w-2xl mx-auto pb-24">
            <!-- Filtros -->
            <div class="bg-white border-b border-gray-100 px-4 py-3">
                <div class="flex gap-2 overflow-x-auto">
                    <button data-valor=""
                        class="filtro-notif px-4 py-2 rounded-lg bg-blue-500 text-white text-sm font-medium whitespace-nowrap">
                        Todas
                    </button>
                    <button data-valor="0"
                        class="filtro-notif px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium whitespace-nowrap hover:bg-gray-200">
                        No leídas
                    </button>
                    <button data-valor="1"
                        class="filtro-notif px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium whitespace-nowrap hover:bg-gray-200">
                        Leídas
                    </button>
                </div>
            </div>

            <!-- Lista de Notificaciones -->
            <div id="lista-notificaciones">
                @foreach ($notificaciones as $notificacion)
                    <div class="notificacion bg-white border-t border-red-200"
                        data-leido="{{ $notificacion['leido'] }}">
                        <div class="px-6 py-6">
                            <!-- Header -->
                            <a href="{{ route('notificacion', ['id' => $notificacion['id_notificacion']]) }}">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            @if ($notificacion['leido'] === 0)
                                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                            @endif
                                            <span
                                                class="badge-tipo px-2 py-0.5 rounded-full text-white text-xs font-medium"
                                                data-tipo="{{ $notificacion['tipo'] }}">
                                                {{ $notificacion['tipo'] }}
                                            </span>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                            {{ $notificacion['titulo'] }}
                                        </h3>
                                    </div>
                                </div>
                            </a>

                            <!-- Estado -->
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium"
                                    style="background-color: {{ $notificacion['leido'] === 0 ? '#fef9c3' : '#dcfce7' }}; color: {{ $notificacion['leido'] === 0 ? '#854d0e' : '#166534' }}">
                                    {{ $notificacion['leido'] === 0 ? 'No leída' : 'Leída' }}
                                </span>

                                @if ($notificacion['leido'] === 1)
                                    <button wire:click="ocultarNotificacion({{ $notificacion['id_notificacion'] }})"
                                        wire:loading.attr="disabled" wire:loading.class="opacity-50"
                                        class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors border border-red-200"
                                        title="Eliminar notificación">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Sin Resultados -->
            <div id="sinResultados" class="hidden bg-white rounded-3xl shadow-sm p-8 text-center mx-4 mt-8">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <p class="text-gray-600">No se encontraron notificaciones con esos filtros</p>
            </div>
        </div>
    @else
        <!-- Sin Notificaciones -->
        <div class="max-w-md mx-auto pt-20 px-4">
            <div class="bg-white rounded-3xl shadow-sm p-8 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">No tienes notificaciones</h2>
                <p class="text-gray-500 text-sm mb-6">Aquí aparecerán las actualizaciones importantes</p>
                <a href="{{ route('index') }}"
                    class="inline-block w-full py-3 bg-linear-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-medium hover:shadow-lg transition-all">
                    Ir al Inicio
                </a>
            </div>
        </div>
    @endif

    @push('script')
        <script>
            // Toast notifications
            window.addEventListener('mostrar-toast', event => {
                const tipo = event.detail.tipo;
                const mensaje = event.detail.mensaje;

                const toast = document.createElement('div');
                toast.className = `fixed top-6 right-6 px-6 py-4 rounded-2xl shadow-xl z-50 transform transition-all duration-300 ${
                    tipo === 'exito' 
                        ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white' 
                        : 'bg-gradient-to-r from-red-500 to-pink-500 text-white'
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

            // Colores para badges de tipo
            document.querySelectorAll('.badge-tipo').forEach(b => {
                const tipo = b.dataset.tipo;
                b.className += tipo === 'ORDEN' ? ' bg-blue-500' :
                    tipo === 'PROMOCION' ? ' bg-green-500' :
                    tipo === 'SISTEMA' ? ' bg-purple-500' : ' bg-gray-400';
            });

            let filtroLeido = '';

            function filtrarNotificaciones() {
                const notificaciones = Array.from(document.querySelectorAll('.notificacion'));
                let visibles = notificaciones.filter(n => !filtroLeido || n.dataset.leido === filtroLeido);

                notificaciones.forEach(n => n.style.display = 'none');

                if (visibles.length) {
                    visibles.forEach(n => n.style.display = 'block');
                    document.getElementById('sinResultados').classList.add('hidden');
                } else {
                    document.getElementById('sinResultados').classList.remove('hidden');
                }
            }

            document.querySelectorAll('.filtro-notif').forEach(b => {
                b.addEventListener('click', function() {
                    document.querySelectorAll('.filtro-notif').forEach(f => {
                        f.className =
                            'filtro-notif px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium whitespace-nowrap hover:bg-gray-200';
                    });
                    this.className =
                        'filtro-notif px-4 py-2 rounded-lg bg-blue-500 text-white text-sm font-medium whitespace-nowrap';
                    filtroLeido = this.dataset.valor;
                    filtrarNotificaciones();
                });
            });
        </script>
    @endpush>
    @script
        <script>
            const id = localStorage.getItem('id');
            if (id) {
                Echo.private(`usuario.${id}`).listen('ActualizarEstadoOrden', (e) => {
                    $wire.cargarNotificaciones();
                });
            }
        </script>
    @endscript
</div>
