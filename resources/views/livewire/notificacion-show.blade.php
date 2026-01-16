<div class="min-h-screen bg-gray-50 flex flex-col">
    <!-- Header -->
    <div class="bg-[#8b3a46] px-4 py-4 flex items-center sticky top-0 z-10">
        <button onclick="window.history.back()"
            class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/10 transition-colors">
            <svg class="w-6 h-6 text-[#FBE8Da]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <h1 class="ml-3 text-lg font-semibold text-[#FBE8Da]">Estado de tu orden</h1>
    </div>

    @if (!empty($notificacion))
        <!-- Contenido principal -->
        <div class="flex-1 overflow-y-auto pb-24">
            <div class="max-w-lg mx-auto px-6 py-8 space-y-6">
                
                <!-- Card principal con ícono -->
                <div class="bg-white rounded-2xl overflow-hidden">
                    <!-- Header con ícono -->
                    <div class="px-6 py-8 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full mb-4">
                            @php
                                $estado = $notificacion['orden']['estado'];
                                $iconColor = match($estado) {
                                    'PENDIENTE' => 'text-amber-500',
                                    'PREPARANDO' => 'text-[#951327]',
                                    'LISTO' => 'text-green-500',
                                    'ENTREGADO' => 'text-gray-500',
                                    default => 'text-gray-400'
                                };
                            @endphp
                            <svg class="w-10 h-10 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($estado === 'PENDIENTE')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @elseif($estado === 'PREPARANDO')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                @elseif($estado === 'LISTO')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                @endif
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            @if($estado === 'PENDIENTE')
                                Orden Recibida
                            @elseif($estado === 'PREPARANDO')
                                Preparando tu Orden
                            @elseif($estado === 'LISTO')
                                ¡Orden Lista!
                            @else
                                Orden Entregada
                            @endif
                        </h2>
                        <p class="text-gray-600 leading-relaxed">{{ $notificacion['mensaje'] }}</p>
                    </div>

                    <!-- Barra de progreso mejorada -->
                    <div class="px-6 py-10 bg-white">
                        <div class="relative">
                            <!-- Contenedor de la línea -->
                            <div class="absolute top-6 left-0 right-0 flex items-center px-8">
                                <div class="flex-1 flex items-center gap-1">
                                    @php
                                        $totalPasos = 4;
                                        $pasoActual = match($estado) {
                                            'PENDIENTE' => 1,
                                            'PREPARANDO' => 2,
                                            'LISTO' => 3,
                                            'ENTREGADO' => 4,
                                            default => 0
                                        };
                                    @endphp
                                    
                                    @for($i = 1; $i < $totalPasos; $i++)
                                        <div class="flex-1 h-1 rounded-full {{ $i < $pasoActual ? 'bg-[#951327]' : 'bg-gray-200' }}"></div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Pasos -->
                            <div class="relative flex justify-between">
                                <!-- Recibida -->
                                <div class="flex flex-col items-center" style="width: 80px;">
                                    <div class="relative z-10 w-12 h-12 rounded-full border-3 flex items-center justify-center bg-white
                                        {{ $pasoActual >= 1 ? 'border-[#951327] shadow-md' : 'border-gray-300' }}">
                                        @if($pasoActual > 1)
                                            <svg class="w-6 h-6 text-[#951327]" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <div class="w-4 h-4 rounded-full {{ $pasoActual == 1 ? 'bg-[#951327]' : 'bg-gray-300' }}"></div>
                                        @endif
                                    </div>
                                    <p class="mt-3 text-xs font-semibold text-center {{ $pasoActual >= 1 ? 'text-gray-900' : 'text-gray-400' }}">
                                        Recibida
                                    </p>
                                </div>

                                <!-- Preparando -->
                                <div class="flex flex-col items-center" style="width: 80px;">
                                    <div class="relative z-10 w-12 h-12 rounded-full border-3 flex items-center justify-center bg-white
                                        {{ $pasoActual >= 2 ? 'border-[#951327] shadow-md' : 'border-gray-300' }}">
                                        @if($pasoActual > 2)
                                            <svg class="w-6 h-6 text-[#951327]" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <div class="w-4 h-4 rounded-full {{ $pasoActual == 2 ? 'bg-[#951327]' : 'bg-gray-300' }}"></div>
                                        @endif
                                    </div>
                                    <p class="mt-3 text-xs font-semibold text-center {{ $pasoActual >= 2 ? 'text-gray-900' : 'text-gray-400' }}">
                                        Preparando
                                    </p>
                                </div>

                                <!-- Lista -->
                                <div class="flex flex-col items-center" style="width: 80px;">
                                    <div class="relative z-10 w-12 h-12 rounded-full border-3 flex items-center justify-center bg-white
                                        {{ $pasoActual >= 3 ? 'border-[#951327] shadow-md' : 'border-gray-300' }}">
                                        @if($pasoActual > 3)
                                            <svg class="w-6 h-6 text-[#951327]" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <div class="w-4 h-4 rounded-full {{ $pasoActual == 3 ? 'bg-[#951327]' : 'bg-gray-300' }}"></div>
                                        @endif
                                    </div>
                                    <p class="mt-3 text-xs font-semibold text-center {{ $pasoActual >= 3 ? 'text-gray-900' : 'text-gray-400' }}">
                                        Lista
                                    </p>
                                </div>

                                <!-- Entregada -->
                                <div class="flex flex-col items-center" style="width: 80px;">
                                    <div class="relative z-10 w-12 h-12 rounded-full border-3 flex items-center justify-center bg-white
                                        {{ $pasoActual >= 4 ? 'border-[#951327] shadow-md' : 'border-gray-300' }}">
                                        @if($pasoActual >= 4)
                                            <svg class="w-6 h-6 text-[#951327]" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <div class="w-4 h-4 rounded-full bg-gray-300"></div>
                                        @endif
                                    </div>
                                    <p class="mt-3 text-xs font-semibold text-center {{ $pasoActual >= 4 ? 'text-gray-900' : 'text-gray-400' }}">
                                        Entregada
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estado actual -->
                    <div class="px-6 pb-6">
                        <div class="border-t border-gray-100 pt-6">
                            <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl">
                                <div class="shrink-0">
                                    <div class="w-10 h-10 rounded-full {{ 
                                        $estado === 'PENDIENTE' ? 'bg-amber-100' : 
                                        ($estado === 'PREPARANDO' ? 'bg-red-100' : 
                                        ($estado === 'LISTO' ? 'bg-green-100' : 'bg-gray-100'))
                                    }} flex items-center justify-center">
                                        <svg class="w-5 h-5 {{ 
                                            $estado === 'PENDIENTE' ? 'text-amber-600' : 
                                            ($estado === 'PREPARANDO' ? 'text-[#951327]' : 
                                            ($estado === 'LISTO' ? 'text-green-600' : 'text-gray-600'))
                                        }}" fill="currentColor" viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="3"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        @if($estado === 'PENDIENTE')
                                            Tu orden ha sido recibida y pronto comenzaremos a prepararla
                                        @elseif($estado === 'PREPARANDO')
                                            Se está preparando tu orden, pronto estará lista!
                                        @elseif($estado === 'LISTO')
                                            Tu orden está lista. ¡Ven a recogerla!
                                        @else
                                            Tu orden ha sido entregada. ¡Esperamos que la disfrutes!
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hora de recogida -->
                @if($estado !== 'ENTREGADO')
                    <div class="bg-white rounded-2xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="shrink-0">
                                <div class="w-12 h-12 bg-[#951327]/10 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-[#951327]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 mb-1">Tiempo aproximado para recoger tu orden</p>
                                <p class="text-xl font-bold text-gray-900">
                                    @php
                                        $horaRecogida = \Carbon\Carbon::parse($notificacion['orden']['hora_recogida']);
                                        $hoy = \Carbon\Carbon::now();
                                        
                                        if ($horaRecogida->isToday()) {
                                            $diaTexto = 'Hoy';
                                        } elseif ($horaRecogida->isTomorrow()) {
                                            $diaTexto = 'Mañana';
                                        } else {
                                            $diaTexto = ucfirst($horaRecogida->locale('es')->isoFormat('dddd D'));
                                        }
                                    @endphp
                                    {{ $diaTexto }} - {{ $horaRecogida->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Estado vacío -->
        <div class="flex-1 flex flex-col items-center justify-center px-6">
            <div class="max-w-sm text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Notificación no encontrada</h2>
                <p class="text-gray-500 mb-8">
                    No pudimos encontrar la información de esta notificación
                </p>
                <a href="{{ route('notificaciones') }}"
                    class="inline-flex items-center gap-2 py-3 px-8 bg-[#951327] text-white rounded-xl font-medium hover:bg-[#7a0f1f] transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Ver todas las notificaciones
                </a>
            </div>
        </div>
    @endif
</div>