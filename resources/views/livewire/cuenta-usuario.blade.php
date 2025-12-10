<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-100 px-4 py-4 flex items-center justify-between sticky top-0 z-10">
        <button onclick="window.history.back()"
            class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <h1 class="text-lg font-semibold text-gray-900">Mi Perfil</h1>
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
                <p class="text-gray-500 text-sm mb-6">Inicie sesión para acceder a los datos de su cuenta</p>
                <a href="{{ route('login') }}"
                    class="inline-block w-full py-3 bg-linear-to-rrom-[#951327] to-[#b50001] text-white rounded-xl font-medium hover:shadow-lg transition-all">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    @elseif(!empty($usuario))
        <div class="max-w-2xl mx-auto">
            <!-- Profile Section -->
            <div class="bg-white px-6 py-8">
                <form wire:submit.prevent="actualizarImg">
                    <div class="flex items-start gap-4 mb-8">
                        <div class="relative">
                            <div
                                class="w-24 h-24 rounded-full overflow-hidden bg-linear-to-br from-blue-400 to-purple-500">
                                @if ($usuario['imagen_url'] ?? false)
                                    <img src="{{ $usuario['imagen_url'] }}" alt="Perfil"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <input type="file" wire:model="imagen" accept="image/png,image/jpeg" class="hidden"
                                id="imagen-upload">
                            <label for="imagen-upload"
                                class="absolute bottom-0 right-0 w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center border-2 border-white cursor-pointer hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-gray-900 mb-1">{{ $usuario['nombre'] ?? 'Usuario' }}
                                {{ $usuario['apellido'] ?? '' }}</h2>
                            <p class="text-gray-500 text-sm">{{ $usuario['email'] ?? '' }}</p>
                        </div>
                    </div>

                    @error('imagen')
                        <p class="text-red-500 text-xs mb-3">{{ $message }}</p>
                    @enderror

                    @if ($imagen)
                        <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-50"
                            class="w-full py-3 bg-linear-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-medium hover:shadow-lg transition-all">
                            <span class="block" wire:loading.class="hidden" wire:target="actualizarImg">
                                Guardar Imagen
                            </span>
                            <span class="hidden" wire:loading.class.remove="hidden" wire:target="actualizarImg">
                                Procesando...
                            </span>
                        </button>
                    @endif
                </form>
            </div>

            <!-- Menu Principal -->
            <div id="menu-section" class="bg-white rounded-2xl shadow-sm overflow-hidden mx-4 mt-4">
                <!-- Settings Section -->
                <div class="px-6 py-3">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Configuración</p>
                </div>

                <div class="divide-y divide-gray-100">
                    <!-- Información Personal -->
                    <button onclick="showSection('account')"
                        class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex items-center justify-center bg-blue-50 rounded-lg">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Información Personal</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- Seguridad -->
                    <button onclick="showSection('security')"
                        class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex items-center justify-center bg-purple-50 rounded-lg">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Seguridad</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Gestión de Cuenta -->
                <div class="px-6 py-3 mt-4 border-t-2 border-red-50">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Gestión de Cuenta</p>
                </div>

                <div class="divide-y divide-gray-100">
                    <!-- Cerrar Sesión -->
                    <button wire:click="cerrarSesion()" wire:loading.attr="disabled"
                        class="w-full px-6 py-4 flex items-center justify-between hover:bg-red-50 transition-colors text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex items-center justify-center bg-red-50 rounded-lg">
                                <svg class="w-4 h-4 text-[#951327]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Cerrar Sesión</span>
                        </div>
                        <span class="hidden" wire:loading wire:target="cerrarSesion">
                            <svg class="animate-spin h-5 w-5 text-[#951327]" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                        <svg class="w-5 h-5 text-gray-400" wire:loading.class="hidden" wire:target="cerrarSesion"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- Desactivar Cuenta -->
                    <button onclick="showSection('danger')"
                        class="w-full px-6 py-4 flex items-center justify-between hover:bg-red-50 transition-colors text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 flex items-center justify-center bg-red-50 rounded-lg">
                                <svg class="w-4 h-4 text-[#951327]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Desactivar Cuenta</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Sección Información Personal -->
            <div id="account-section" class="hidden">
                <div class="bg-white border-b border-gray-100 px-4 py-4 flex items-center gap-3 sticky top-0 z-10">
                    <button onclick="hideSection('account')"
                        class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-900">Información Personal</h2>
                </div>

                <div class="bg-white">
                    <form wire:submit.prevent="actualizarDatos">
                        <div class="divide-y divide-gray-100">
                            <!-- Email -->
                            <div class="px-6 py-4 flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs text-gray-500 mb-1">Email</label>
                                    <input type="email" wire:model.live="email"
                                        class="w-full text-gray-900 text-sm font-medium focus:outline-none"
                                        placeholder="refero.john.doe@gmail.com">
                                    @error('email')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="px-6 py-4 flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs text-gray-500 mb-1">Teléfono</label>
                                    <input type="number" wire:model.live="telefono"
                                        class="w-full text-gray-900 text-sm font-medium focus:outline-none"
                                        placeholder="Agregar número de teléfono">
                                    @error('telefono')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="px-6 py-4 flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs text-gray-500 mb-1">Nombre</label>
                                    <input type="text" wire:model.live="nombre"
                                        class="w-full text-gray-900 text-sm font-medium focus:outline-none"
                                        placeholder="Tu nombre">
                                    @error('nombre')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="px-6 py-4 flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs text-gray-500 mb-1">Apellido</label>
                                    <input type="text" wire:model.live="apellido"
                                        class="w-full text-gray-900 text-sm font-medium focus:outline-none"
                                        placeholder="Tu apellido">
                                    @error('apellido')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Semester -->
                            <div class="px-6 py-4 flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs text-gray-500 mb-1">Semestre</label>
                                    <select wire:model.live="semestre"
                                        class="w-full text-gray-900 text-sm font-medium focus:outline-none bg-transparent">
                                        <option value="">Seleccionar semestre</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
                                    @error('semestre')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Group -->
                            <div class="px-6 py-4 flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-xs text-gray-500 mb-1">Grupo</label>
                                    <select wire:model.live="grupo"
                                        class="w-full text-gray-900 text-sm font-medium focus:outline-none bg-transparent">
                                        <option value="">Seleccionar grupo</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                        <option value="G">G</option>
                                    </select>
                                    @error('grupo')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4">
                            <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-50"
                                class="w-full py-3 bg-linear-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-medium hover:shadow-lg transition-all">
                                <span class="block" wire:loading.class="hidden" wire:target="actualizarDatos">
                                    Guardar Cambios
                                </span>
                                <span class="hidden" wire:loading.class.remove="hidden"
                                    wire:target="actualizarDatos">
                                    Procesando...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sección Seguridad -->
            <div id="security-section" class="hidden">
                <div class="bg-white border-b border-gray-100 px-4 py-4 flex items-center gap-3 sticky top-0 z-10">
                    <button onclick="hideSection('security')"
                        class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-900">Seguridad</h2>
                </div>

                <div class="bg-white">
                    <form wire:submit.prevent="actualizarPassword">
                        <input type="email" name="email" autocomplete="username" class="hidden"
                            value="{{ $usuario['email'] ?? '' }}">
                        <div class="px-6 py-4">
                            <h3 class="text-sm font-semibold text-gray-900 mb-4">Cambiar Contraseña</h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs text-gray-500 mb-2">Contraseña Actual</label>
                                    <div class="relative">
                                        <input id="current-password" type="password" wire:model.live="password"
                                            autocomplete="current-password"
                                            class="w-full px-4 py-3 pr-12 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-purple-500 transition-colors"
                                            placeholder="••••••••">
                                        <button type="button" onclick="togglePassword('current')"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <svg id="current-eye-open" class="w-5 h-5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg id="current-eye-closed" class="w-5 h-5 hidden" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('password')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-2">Nueva Contraseña</label>
                                    <div class="relative">
                                        <input id="new-password" type="password" wire:model.live="newPassword"
                                            autocomplete="new-password"
                                            class="w-full px-4 py-3 pr-12 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-purple-500 transition-colors"
                                            placeholder="••••••••">
                                        <button type="button" onclick="togglePassword('new')"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <svg id="new-eye-open" class="w-5 h-5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg id="new-eye-closed" class="w-5 h-5 hidden" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('newPassword')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-50"
                                    class="w-full py-3 bg-linear-to-r from-purple-500 to-pink-500 text-white rounded-xl font-medium hover:shadow-lg transition-all">
                                    <span class="block" wire:loading.class="hidden"
                                        wire:target="actualizarPassword">
                                        Actualizar Contraseña
                                    </span>
                                    <span class="hidden" wire:loading.class.remove="hidden"
                                        wire:target="actualizarPassword">
                                        Procesando...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sección Zona de Peligro -->
            <div id="danger-section" class="hidden">
                <div class="bg-white border-b border-gray-100 px-4 py-4 flex items-center gap-3 sticky top-0 z-10">
                    <button onclick="hideSection('danger')"
                        class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-900">Zona de Peligro</h2>
                </div>

                <div class="bg-white px-6 py-6">
                    <div class="flex items-center justify-center w-14 h-14 bg-red-100 rounded-full mx-auto mb-4">
                        <svg class="w-7 h-7 text-[#951327]" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600 mb-4 text-center">Esta acción desactivará tu cuenta permanentemente
                    </p>
                    <button onclick="showModal()"
                        class="w-full py-3 bg-red-50 text-[#951327] rounded-xl font-medium hover:bg-red-100 transition-colors border border-red-200">
                        Desactivar Cuenta
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Desactivar Cuenta -->
        <div id="modal-desactivar"
            class="hidden fixed inset-0 bg-white/80 backdrop-blur-md z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-6 border border-gray-100">
                <div class="flex items-center justify-center w-14 h-14 bg-red-100 rounded-full mx-auto mb-4">
                    <svg class="w-7 h-7 text-[#951327]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">¿Desactivar cuenta?</h3>
                <p class="text-sm text-gray-500 text-center mb-6">Esta acción desactivará tu cuenta permanentemente</p>

                <form wire:submit.prevent="desactivarCuenta">
                    <input type="email" name="email" autocomplete="username" class="hidden"
                        value="{{ $usuario['email'] ?? '' }}">
                    <div class="mb-4">
                        <div class="relative">
                            <input id="modal-password" type="password" wire:model="passwordConfirm"
                                autocomplete="current-password"
                                class="w-full px-4 py-3 pr-12 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-red-500"
                                placeholder="Confirmar contraseña">
                            <button type="button" onclick="toggleModalPassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg id="modal-eye-open" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="modal-eye-closed" class="w-5 h-5 hidden" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-liejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('passwordConfirm')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeModal()"
                            class="flex-1 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-50"
                            class="flex-1 py-3 bg-linear-to-r from-[#951327] to-[#b50001] text-white rounded-xl font-medium hover:shadow-lg transition-all">
                            <span class="block" wire:loading.class="hidden" wire:target="desactivarCuenta">
                                Desactivar
                            </span>
                            <span class="hidden" wire:loading.class.remove="hidden" wire:target="desactivarCuenta">
                                Procesando...
                            </span>
                        </button>
                    </div>
                </form>
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
                <p class="text-gray-500 text-sm">No se pudo acceder a los datos de su cuenta</p>
            </div>
        </div>
    @endif

    @push('script')
        <script>
            // Funciones de navegación
            function showSection(section) {
                document.getElementById('profile-section')?.classList.add('hidden');
                document.getElementById('menu-section')?.classList.add('hidden');
                document.getElementById('account-section')?.classList.add('hidden');
                document.getElementById('security-section')?.classList.add('hidden');
                document.getElementById('danger-section')?.classList.add('hidden');

                document.getElementById(section + '-section')?.classList.remove('hidden');
            }

            function hideSection(section) {
                document.getElementById(section + '-section')?.classList.add('hidden');
                document.getElementById('profile-section')?.classList.remove('hidden');
                document.getElementById('menu-section')?.classList.remove('hidden');
            }

            // Funciones para mostrar/ocultar contraseñas
            function togglePassword(type) {
                const input = document.getElementById(type + '-password');
                const eyeOpen = document.getElementById(type + '-eye-open');
                const eyeClosed = document.getElementById(type + '-eye-closed');

                if (input.type === 'password') {
                    input.type = 'text';
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                }
            }

            function toggleModalPassword() {
                const input = document.getElementById('modal-password');
                const eyeOpen = document.getElementById('modal-eye-open');
                const eyeClosed = document.getElementById('modal-eye-closed');

                if (input.type === 'password') {
                    input.type = 'text';
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                }
            }

            // Función para cerrar modal
            function showModal() {
                document.getElementById('modal-desactivar')?.classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('modal-desactivar')?.classList.add('hidden');
                const input = document.getElementById('modal-password');
                const eyeOpen = document.getElementById('modal-eye-open');
                const eyeClosed = document.getElementById('modal-eye-closed');
                if (input) {
                    input.type = 'password';
                    input.value = '';
                }
                if (eyeOpen && eyeClosed) {
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                }
            }

            // Cerrar modal al hacer clic fuera (pero no en el formulario)
            const modal = document.getElementById('modal-desactivar');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeModal();
                    }
                });
            }

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
        </script>
    @endpush
</div>
