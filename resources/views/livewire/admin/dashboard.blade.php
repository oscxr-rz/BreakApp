<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-sm text-gray-500 mt-1">Resumen general del sistema</p>
                </div>
                <div class="flex items-center gap-3">
                    <button wire:click="cargarDatos"
                        class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span class="hidden sm:inline">Actualizar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Grid de estadísticas principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Card Usuarios -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Usuarios</p>
                    <p class="text-3xl font-bold text-gray-900 mb-2">{{ $totalUsuarios }}</p>
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                            {{ $totalUsuariosActivos }} activos
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card Órdenes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Ordenes</p>
                    <p class="text-3xl font-bold text-gray-900 mb-2">{{ $totalOrdenes }}</p>
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $totalOrdenesEntregadas }} entregadas
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card Productos -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Productos</p>
                    <p class="text-3xl font-bold text-gray-900 mb-2">{{ $totalProductos }}</p>
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                            {{ $totalProductosActivos }} activos
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card Categorías -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Categorías</p>
                    <p class="text-3xl font-bold text-gray-900 mb-2">{{ $totalCategorias }}</p>
                    <div class="flex items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                            {{ $totalCategoriasActivas }} activas
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de gráficos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Gráfico de Órdenes por Estado -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Estado de Ordenes</h3>
                    <span class="text-sm text-gray-500">{{ $totalOrdenes }} total</span>
                </div>
                <div class="space-y-4">
                    <!-- Barra Entregadas -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Entregadas</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $totalOrdenesEntregadas }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-linear-to-r from-green-500 to-emerald-500 h-3 rounded-full transition-all duration-500"
                                style="width: {{ $totalOrdenes > 0 ? ($totalOrdenesEntregadas / $totalOrdenes) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <!-- Barra Pendientes -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Pendientes</span>
                            <span
                                class="text-sm font-semibold text-gray-900">{{ $totalOrdenes - $totalOrdenesEntregadas }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-linear-to-r from-yellow-500 to-orange-500 h-3 rounded-full transition-all duration-500"
                                style="width: {{ $totalOrdenes > 0 ? (($totalOrdenes - $totalOrdenesEntregadas) / $totalOrdenes) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Usuarios -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Estado de Usuarios</h3>
                    <span class="text-sm text-gray-500">{{ $totalUsuarios }} total</span>
                </div>
                <div class="space-y-4">
                    <!-- Barra Activos -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Activos</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $totalUsuariosActivos }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-linear-to-r from-blue-500 to-indigo-500 h-3 rounded-full transition-all duration-500"
                                style="width: {{ $totalUsuarios > 0 ? ($totalUsuariosActivos / $totalUsuarios) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <!-- Barra Inactivos -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Inactivos</span>
                            <span
                                class="text-sm font-semibold text-gray-900">{{ $totalUsuarios - $totalUsuariosActivos }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-linear-to-r from-gray-400 to-gray-500 h-3 rounded-full transition-all duration-500"
                                style="width: {{ $totalUsuarios > 0 ? (($totalUsuarios - $totalUsuariosActivos) / $totalUsuarios) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de resumen adicional -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Card Productos -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Productos</h3>
                    <span class="text-sm text-gray-500">{{ $totalProductos }} total</span>
                </div>
                <div class="flex items-center gap-6">
                    <div class="flex-1">
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    <span class="text-xs font-semibold inline-block text-green-600">
                                        Activos
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold inline-block text-green-600">
                                        {{ $totalProductos > 0 ? round(($totalProductosActivos / $totalProductos) * 100) : 0 }}%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-green-200">
                                <div style="width: {{ $totalProductos > 0 ? ($totalProductosActivos / $totalProductos) * 100 : 0 }}%"
                                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500 transition-all duration-500">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-gray-900">{{ $totalProductosActivos }}</p>
                        <p class="text-xs text-gray-500 mt-1">Disponibles</p>
                    </div>
                </div>
            </div>

            <!-- Card Categorías -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Categorías</h3>
                    <span class="text-sm text-gray-500">{{ $totalCategorias }} total</span>
                </div>
                <div class="flex items-center gap-6">
                    <div class="flex-1">
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    <span class="text-xs font-semibold inline-block text-orange-600">
                                        Activas
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold inline-block text-orange-600">
                                        {{ $totalCategorias > 0 ? round(($totalCategoriasActivas / $totalCategorias) * 100) : 0 }}%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-orange-200">
                                <div style="width: {{ $totalCategorias > 0 ? ($totalCategoriasActivas / $totalCategorias) * 100 : 0 }}%"
                                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-orange-500 transition-all duration-500">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-gray-900">{{ $totalCategoriasActivas }}</p>
                        <p class="text-xs text-gray-500 mt-1">Disponibles</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Tickets -->
        @if ($totalTickets > 0)
            <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">Tickets en el Sistema</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-gray-900">{{ $totalTickets }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
