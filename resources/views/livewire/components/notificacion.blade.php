<div id="notificaciones-container" class="fixed top-4 right-4 z-50 flex flex-col gap-3 pointer-events-none max-w-sm">
    @script
        <script>
            (function() {
                function mostrarNotificacion(data) {
                    const notif = document.createElement('div');
                    notif.className =
                        'notificacion pointer-events-auto bg-white rounded-2xl shadow-xl transform transition-all duration-500 ease-out translate-x-[120%] opacity-0 border border-blue-100 overflow-hidden backdrop-blur-sm hover:shadow-2xl';

                    notif.innerHTML = `
                        <div class="relative">
                            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
                            <div class="flex items-start gap-4 p-5">
                                <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0 pt-1">
                                    <p class="text-sm font-semibold text-gray-900 mb-1.5 leading-tight">${data.titulo}</p>
                                    <div class="flex items-center gap-2 text-xs text-gray-600">
                                        <span class="font-medium text-blue-600">Orden #${data.idOrden}</span>
                                        <span class="text-gray-400">•</span>
                                        <span>${data.estado}</span>
                                    </div>
                                </div>
                                <button onclick="this.closest('.notificacion').remove()" class="flex-shrink-0 w-8 h-8 rounded-lg hover:bg-gray-100 transition-colors flex items-center justify-center group">
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `;

                    document.getElementById('notificaciones-container').appendChild(notif);

                    setTimeout(() => notif.classList.remove('translate-x-[120%]', 'opacity-0'), 10);
                    setTimeout(() => {
                        notif.classList.add('translate-x-[120%]', 'opacity-0');
                        setTimeout(() => notif.remove(), 500);
                    }, 5000);
                }

                const id = localStorage.getItem('id');
                if (id) {
                    Echo.private(`usuario.${id}`).listen('ActualizarEstadoOrden', (e) => {
                        mostrarNotificacion({
                            titulo: e.titulo,
                            idOrden: e.idOrden,
                            estado: e.estado
                        });
                    });
                }
            })();
        </script>
    @endscript
</div>
