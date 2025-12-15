<div class="flex items-center justify-center w-full pt-20 px-4">

    <div class="max-w-md w-full space-y-4">
        <div
            class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">

            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <a href="/" class="transform hover:scale-110 transition-transform duration-200">
                    <img src="{{ asset('storage/logos/4.png') }}" alt="Logo" class="h-20 w-20 rounded-full shadow-sm">
                </a>
            </div>

            <!-- Título -->
            <h2 class="text-2xl font-bold text-center mb-2 text-gray-800">Crear Cuenta</h2>
            <p class="text-center text-gray-500 text-sm mb-6">Únete a BreakApp hoy</p>

            <!-- Mensaje de éxito -->
            @if (session('mensaje'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-md text-sm">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('mensaje') }}
                    </div>
                </div>
            @endif

            <!-- Mensaje de erro (Login Google) -->
            @if (session('error'))
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-md text-sm">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Error general -->
            @error('error')
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-md text-sm">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </div>
                </div>
            @enderror

            <!-- Formulario -->
            <form wire:submit.prevent="crearCuenta" class="mt-4 space-y-4">
                <div class="space-y-4">

                    <!-- Nombre -->
                    <div>
                        <input type="text" wire:model.live="nombre" autocomplete="given-name"
                            class="appearance-none w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                            placeholder="Nombre">
                        @error('nombre')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Apellido -->
                    <div>
                        <input type="text" wire:model.live="apellido" autocomplete="family-name"
                            class="appearance-none w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                            placeholder="Apellido">
                        @error('apellido')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <input type="email" wire:model.live="email" autocomplete="email"
                            class="appearance-none w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                            placeholder="Correo electrónico">
                        @error('email')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <input type="tel" wire:model.live="telefono" pattern="[0-9]{10}" maxlength="10"
                            autocomplete="tel"
                            class="appearance-none w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                            placeholder="Número de teléfono">
                        @error('telefono')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div class="relative">
                        <input id="password-field" type="password" wire:model.live="password"
                            autocomplete="new-password"
                            class="appearance-none w-full px-3 py-2 pr-10 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                            placeholder="Contraseña">
                        <button type="button"
                            onclick="togglePasswordVisibility('password-field', 'password-eye-open', 'password-eye-closed')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="password-eye-open" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="password-eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                        @error('password')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="relative">
                        <input id="password-confirm-field" type="password" wire:model.live="passwordVerificacion"
                            autocomplete="new-password"
                            class="appearance-none w-full px-3 py-2 pr-10 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                            placeholder="Confirmar contraseña">
                        <button type="button"
                            onclick="togglePasswordVisibility('password-confirm-field', 'confirm-eye-open', 'confirm-eye-closed')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="confirm-eye-open" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="confirm-eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                        @error('passwordVerificacion')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Semestre y Grupo -->
                    <div
                        class="flex flex-col lg:flex-row items-center justify-center w-full space-y-4 lg:space-y-0 lg:space-x-4">

                        <!-- Semestre -->
                        <div class="w-full">
                            <select wire:model.live="semestre"
                                class="appearance-none w-full px-3 py-2 border border-gray-300 text-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200 cursor-pointer">
                                <option value="" class="text-gray-500">Semestre (Opcional)</option>
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

                        <!-- Grupo -->
                        <div class="w-full">
                            <select wire:model.live="grupo"
                                class="appearance-none w-full px-3 py-2 border border-gray-300 text-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200 cursor-pointer">
                                <option value="" class="text-gray-500">Grupo (Opcional)</option>
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

                <!-- Botón Crear Cuenta -->
                <button type="submit" wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed" wire:target="crearCuenta"
                    class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition-all duration-200 transform hover:scale-105 active:scale-95">

                    <span wire:loading.remove wire:target="crearCuenta">
                        Crear Cuenta
                    </span>
                    <span wire:loading wire:target="crearCuenta" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Procesando...
                    </span>
                </button>

                <!-- Google Login Button -->
                <a href="{{ route('auth.google') }}"
                    class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transform hover:scale-[1.02]">
                    <!-- Google Icon SVG -->
                    <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    Continuar con Google
                </a>
            </form>
        </div>

        <!-- Link a Login -->
        <div
            class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 text-center hover:shadow-md transition-shadow duration-300">
            <p class="text-sm text-gray-700">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" wire:navigate
                    class="text-blue-500 font-semibold hover:text-blue-600 hover:underline transition-all duration-200">
                    Iniciar sesión
                </a>
            </p>
        </div>

    </div>

    @push('script')
        <script>
            function togglePasswordVisibility(fieldId, eyeOpenId, eyeClosedId) {
                const input = document.getElementById(fieldId);
                const eyeOpen = document.getElementById(eyeOpenId);
                const eyeClosed = document.getElementById(eyeClosedId);

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
        </script>
    @endpush
</div>
