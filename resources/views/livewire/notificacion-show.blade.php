<div class="min-h-screen bg-white flex flex-col">
    <!-- Header minimalista -->
    <div class="bg-white px-4 py-4 flex items-center">
        <button onclick="window.history.back()"
            class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
            <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
    </div>

    @if (!empty($notificacion))
        <!-- Contenido centrado -->
        <div class="flex-1 flex flex-col items-center justify-center px-6 pb-20">
            <!-- Icono grande -->
            <div class="mb-8">
                <div class="w-32 h-32 bg-blue-50 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>

            <!-- Texto principal -->
            <div class="text-center max-w-sm">
                <h1 class="text-2xl font-semibold text-gray-900 mb-3">
                    ¡Mantente al pendiente del estado de tu orden!
                </h1>
                <p class="text-gray-500 leading-relaxed">
                    {{ $notificacion['mensaje'] }}
                </p>
            </div>
        </div>

        <!-- Botón inferior fijo -->
        <div class="p-6 bg-white border-t border-gray-100">
            <a href="{{ route('notificaciones') }}"
                class="block w-full py-4 px-6 bg-blue-500 text-white text-center rounded-lg font-medium hover:bg-blue-600 transition-colors">
                Entendido
            </a>
        </div>
    @else
        <!-- Estado vacío -->
        <div class="flex-1 flex flex-col items-center justify-center px-6">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Notificación no encontrada</h2>
            <p class="text-gray-500 text-center mb-8">
                No pudimos encontrar la notificación que buscas
            </p>
            <a href="{{ route('notificaciones') }}"
                class="py-3 px-8 bg-blue-500 text-white rounded-lg font-medium hover:bg-blue-600 transition-colors">
                Ver notificaciones
            </a>
        </div>
    @endif
</div>