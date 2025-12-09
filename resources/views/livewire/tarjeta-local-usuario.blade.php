<div class="container mx-auto px-4 py-6 pb-24 max-w-md lg:max-w-2xl">
    <!-- Header -->
    <div class="text-center bg-[#951327] pt-3 pb-3">
        <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">Tarjeta Local</h1>
        <p class="text-sm lg:text-base text-white">Gestiona tu saldo</p>
    </div>

    @if (!session('id'))
        <!-- Estado: Sin sesión -->
        <div class="bg-white rounded-3xl p-8 shadow-lg border border-[#f2cc88]/30 text-center">
            <div
                class="w-20 h-20 lg:w-24 lg:h-24 bg-[#951327]/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 lg:w-12 lg:h-12 text-[#951327]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-xl lg:text-2xl font-bold text-[#951327] mb-3">Acceso Requerido</h2>
            <p class="text-sm lg:text-base text-[#768e78] mb-6">
                Inicia sesión para acceder a los datos de tu tarjeta
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('login') }}"
                    class="bg-[#951327] hover:bg-[#ea5f3a] text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    @elseif (!empty($tarjetaLocal))
        <!-- Tarjeta de Crédito Visual -->
        <div class="mb-6">
            <div
                class="relative w-full max-w-[400px] mx-auto aspect-[1.586/1] bg-linear-to-br from-[#951327] via-[#b50001] to-[#951327] rounded-3xl shadow-2xl p-6 lg:p-8 text-white overflow-hidden">
                <!-- Patrón de fondo decorativo -->
                <div class="absolute inset-0 opacity-10">
                    <div
                        class="absolute top-0 right-0 w-40 h-40 bg-white rounded-full -translate-y-1/2 translate-x-1/2">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-32 h-32 bg-white rounded-full translate-y-1/2 -translate-x-1/2">
                    </div>
                </div>

                <!-- Contenido de la tarjeta -->
                <div class="relative h-full flex flex-col justify-between">
                    <!-- Header -->
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs lg:text-sm opacity-80 mb-1">Tarjeta Local</p>
                            <p class="text-lg lg:text-xl font-bold">BreakApp</p>
                        </div>
                        <div class="w-10 h-10 bg-linear-to-br from-[#fcc88a] to-[#f2cc88] rounded-lg shadow-md">
                        </div>
                    </div>

                    <!-- Número de tarjeta -->
                    <div class="my-4">
                        <p class="text-xl lg:text-2xl font-bold tracking-wider mb-1">
                            {{ substr($tarjetaLocal['id_tarjeta_local'], 0, 4) }}
                            {{ substr($tarjetaLocal['id_tarjeta_local'], 4, 4) }}
                            {{ substr($tarjetaLocal['id_tarjeta_local'], 8, 4) }}
                        </p>
                        <p class="text-xs lg:text-sm opacity-70">ID: {{ $tarjetaLocal['id_tarjeta_local'] }}</p>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-xs opacity-70 mb-1">Titular</p>
                            <p class="text-sm lg:text-base font-semibold">{{ session('nombre', 'Usuario') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs opacity-70 mb-1">Creada</p>
                            <p class="text-sm lg:text-base font-semibold">
                                {{ date('d/m/Y', strtotime($tarjetaLocal['fecha_creacion'])) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Saldo -->
        <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-lg border border-[#f2cc88]/30 mb-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl lg:text-2xl font-bold text-[#951327]">Saldo Disponible</h2>
                <div class="w-12 h-12 bg-[#951327]/10 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#951327]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="text-center py-6">
                <p class="text-5xl lg:text-6xl font-bold text-[#951327] mb-2">
                    ${{ number_format($tarjetaLocal['saldo'], 2) }}
                </p>
                <p class="text-sm lg:text-base text-[#768e78]">Pesos Mexicanos</p>
            </div>
        </div>

        <!-- Detalles de la Tarjeta -->
        <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-lg border border-[#f2cc88]/30 mb-6">
            <h3 class="text-lg lg:text-xl font-bold text-[#951327] mb-4">Detalles de la Tarjeta</h3>

            <div class="space-y-4">
                <!-- Fecha de Creación -->
                <div class="flex items-center justify-between py-3 border-b border-[#f2cc88]/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#f2cc88]/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#951327]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs lg:text-sm text-[#768e78]">Fecha de Creación</p>
                            <p class="text-sm lg:text-base font-semibold text-[#951327]">
                                {{ date('d/m/Y H:i', strtotime($tarjetaLocal['fecha_creacion'])) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Última Actualización -->
                <div class="flex items-center justify-between py-3 border-b border-[#f2cc88]/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#f2cc88]/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#951327]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs lg:text-sm text-[#768e78]">Última Actualización</p>
                            <p class="text-sm lg:text-base font-semibold text-[#951327]">
                                {{ date('d/m/Y H:i', strtotime($tarjetaLocal['ultima_actualizacion'])) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Estado de la Tarjeta -->
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs lg:text-sm text-[#768e78]">Estado</p>
                            <p class="text-sm lg:text-base font-semibold text-green-600">Activa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
