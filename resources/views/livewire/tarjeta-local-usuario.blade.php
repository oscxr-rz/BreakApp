<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-100 px-4 py-4 flex items-center justify-between sticky top-0 z-10">
        <button onclick="window.history.back()"
            class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <h1 class="text-lg font-semibold text-gray-900">Tarjeta Local</h1>
        <div class="w-10"></div>
    </div>
    @if (!session('id'))
        <div class="max-w-md mx-auto pt-20 px-4">
            <div class="bg-white rounded-3xl shadow-sm p-8 text-center">
                <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Acceso Requerido</h2>
                <p class="text-gray-500 text-sm mb-6">Inicie sesión para acceder a los datos de su tarjeta</p>
                <a href="{{ route('login') }}"
                    class="inline-block w-full py-3 bg-linear-to-r from-[#951327] to-[#b50001] text-white rounded-xl font-medium hover:shadow-lg transition-all">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    @elseif (!empty($tarjetaLocal))
        <div class="max-w-2xl mx-auto">
            <!-- Tarjeta Visual -->
            <div class="bg-white px-6 py-8">
                <div
                    class="relative w-full max-w-[380px] mx-auto aspect-[1.586/1] bg-linear-to-br from-[#951327] via-[#b50001] to-[#951327] rounded-3xl shadow-xl p-6 text-white overflow-hidden">
                    <!-- Patrón decorativo -->
                    <div class="absolute inset-0 opacity-10">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full -translate-y-1/2 translate-x-1/2">
                        </div>
                        <div
                            class="absolute bottom-0 left-0 w-24 h-24 bg-white rounded-full translate-y-1/2 -translate-x-1/2">
                        </div>
                    </div>

                    <!-- Contenido -->
                    <div class="relative h-full flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs opacity-80 mb-1">Tarjeta Local</p>
                                <p class="text-lg font-bold">BreakApp</p>
                            </div>
                            <div class="w-10 h-10 bg-linear-to-br from-[#fcc88a] to-[#f2cc88] rounded-lg"></div>
                        </div>

                        <div>
                            <p class="text-xl font-bold tracking-wider mb-1">
                                {{ substr($tarjetaLocal['id_tarjeta_local'], 0, 4) }}
                                {{ substr($tarjetaLocal['id_tarjeta_local'], 4, 4) }}
                                {{ substr($tarjetaLocal['id_tarjeta_local'], 8, 4) }}
                            </p>
                        </div>

                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[10px] opacity-70 mb-1">Titular</p>
                                <p class="text-sm font-semibold">{{ session('nombre', 'Usuario') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] opacity-70 mb-1">Creada</p>
                                <p class="text-sm font-semibold">
                                    {{ date('d/m/Y', strtotime($tarjetaLocal['fecha_creacion'])) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Saldo -->
            <div class="border-t-8 border-gray-50">
                <div class="bg-white px-6 py-8 text-center">
                    <p class="text-sm text-gray-500 mb-2">Saldo Disponible</p>
                    <p class="text-5xl font-bold text-[#951327] mb-1">
                        ${{ number_format($tarjetaLocal['saldo'], 2) }}
                    </p>
                    <p class="text-xs text-gray-400">MXN</p>
                </div>
            </div>

            <!-- Detalles -->
            <div class="bg-white">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Detalles de la Tarjeta</h3>
                </div>

                <div class="divide-y divide-gray-100">
                    <!-- ID -->
                    <div class="px-6 py-4 flex items-center gap-4">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs text-gray-500 mb-1">ID de Tarjeta</label>
                            <p class="text-sm font-medium text-gray-900">{{ $tarjetaLocal['id_tarjeta_local'] }}</p>
                        </div>
                    </div>

                    <!-- Fecha Creación -->
                    <div class="px-6 py-4 flex items-center gap-4">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs text-gray-500 mb-1">Fecha de Creación</label>
                            <p class="text-sm font-medium text-gray-900">
                                {{ date('d/m/Y H:i', strtotime($tarjetaLocal['fecha_creacion'])) }}
                            </p>
                        </div>
                    </div>

                    <!-- Última Actualización -->
                    <div class="px-6 py-4 flex items-center gap-4">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs text-gray-500 mb-1">Última Actualización</label>
                            <p class="text-sm font-medium text-gray-900">
                                {{ date('d/m/Y H:i', strtotime($tarjetaLocal['ultima_actualizacion'])) }}
                            </p>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="px-6 py-4 flex items-center gap-4">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs text-gray-500 mb-1">Estado</label>
                            <p class="text-sm font-medium text-green-600">Activa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="max-w-md mx-auto pt-20 px-4">
            <div class="bg-white rounded-3xl shadow-sm p-8 text-center">
                <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Error de Acceso</h2>
                <p class="text-gray-500 text-sm">No se pudo acceder a los datos de su tarjeta</p>
            </div>
        </div>
    @endif
</div>
