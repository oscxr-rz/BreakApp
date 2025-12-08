<div class="flex items-center justify-center w-full pt-20 px-4">

    <!-- INICIAR SESIÓN -->
    <div class="max-w-md w-full space-y-4">
        <div
            class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300">

            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <a href="/" class="transform hover:scale-110 transition-transform duration-200">
                    <img src="{{ asset('storage/logo.jpg') }}" alt="Logo" class="h-20 w-20 rounded-full shadow-sm">
                </a>
            </div>

            <!-- Título -->
            <h2 class="text-2xl font-bold text-center mb-2 text-gray-800">Iniciar Sesión</h2>
            <p class="text-center text-gray-500 text-sm mb-6">Bienvenido de nuevo</p>

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
            <form wire:submit.prevent="iniciarSesion" class="mt-4 space-y-6" x-data="{ metodoLogin: 'email' }">
                <div class="space-y-4">

                    <!-- Selector de método de inicio de sesión -->
                    <div class="flex bg-gray-100 rounded-lg p-1">
                        <button type="button" @click="metodoLogin = 'email'"
                            :class="metodoLogin === 'email' ? 'bg-white text-blue-600 shadow-sm' :
                                'text-gray-600 hover:text-gray-800'"
                            class="flex-1 py-2 text-sm font-medium rounded-md transition-all duration-200">
                            Email
                        </button>
                        <button type="button" @click="metodoLogin = 'telefono'"
                            :class="metodoLogin === 'telefono' ? 'bg-white text-blue-600 shadow-sm' :
                                'text-gray-600 hover:text-gray-800'"
                            class="flex-1 py-2 text-sm font-medium rounded-md transition-all duration-200">
                            Teléfono
                        </button>
                    </div>

                    <!-- Email (se muestra cuando metodoLogin === 'email') -->
                    <div x-show="metodoLogin === 'email'" x-transition>
                        <input type="email" wire:model.live="email" autocomplete="email"
                            class="appearance-none w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                            placeholder="Correo electrónico">
                        @error('email')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Teléfono (se muestra cuando metodoLogin === 'telefono') -->
                    <div x-show="metodoLogin === 'telefono'" x-transition>
                        <input type="tel" wire:model.live="telefono" pattern="[0-9]{10}" maxlength="10"
                            autocomplete="tel"
                            class="appearance-none w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                            placeholder="Número de teléfono">
                        @error('telefono')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <input type="password" wire:model.live="password" autocomplete="current-password"
                            class="appearance-none w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                            placeholder="Contraseña">
                        @error('password')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <!-- Botón Iniciar Sesión -->
                <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                    wire:target="iniciarSesion"
                    class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition-all duration-200 transform hover:scale-105 active:scale-95">

                    <span wire:loading.remove wire:target="iniciarSesion">
                        Iniciar Sesión
                    </span>
                    <span wire:loading wire:target="iniciarSesion" class="flex items-center">
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

                {{-- <!-- Divisor -->
                <div class="flex items-center my-3">
                    <div class="grow border-t border-gray-300"></div>
                    <span class="mx-4 text-gray-500 text-sm font-medium">O</span>
                    <div class="grow border-t border-gray-300"></div>
                </div>

                <!-- Google -->
                <div class="text-center">
                    <a href="#"
                        class="text-blue-900 text-sm font-semibold hover:text-blue-700 transition-colors duration-200">
                        Iniciar sesión con Google
                    </a>
                </div> --}}

                {{-- <!-- Olvidaste contraseña -->
                <div class="text-center">
                    <a href="#"
                        class="text-xs text-blue-500 hover:text-blue-600 hover:underline transition-all duration-200">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div> --}}

            </form>
        </div>

        <!-- Link a Registro -->
        <div
            class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 text-center hover:shadow-md transition-shadow duration-300">
            <p class="text-sm text-gray-700">
                ¿Todavía no tienes cuenta?
                <a href="{{ route('singup') }}" wire:navigate
                    class="text-blue-500 font-semibold hover:text-blue-600 hover:underline transition-all duration-200">
                    Registrarme
                </a>
            </p>
        </div>

    </div>
</div>
