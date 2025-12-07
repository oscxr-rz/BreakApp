<div class="flex items-center justify-center w-full pt-20 px-4">

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
                    <div>
                        <input type="password" wire:model.live="password" autocomplete="new-password"
                            class="appearance-none w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                            placeholder="Contraseña">
                        @error('password')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <input type="password" wire:model.live="passwordVerificacion" autocomplete="new-password"
                            class="appearance-none w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent sm:text-sm transition-all duration-200"
                            placeholder="Confirmar contraseña">
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
                <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                    wire:target="crearCuenta"
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

                {{-- <!-- Divisor -->
                <div class="flex items-center my-3">
                    <div class="grow border-t border-gray-300"></div>
                    <span class="mx-4 text-gray-500 text-sm font-medium">O</span>
                    <div class="grow border-t border-gray-300"></div>
                </div> --}}

            </form>
        </div>

        <!-- Link a Login -->
        <div
            class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 text-center hover:shadow-md transition-shadow duration-300">
            <p class="text-sm text-gray-700">
                ¿Ya tienes cuenta?
                <a href="" wire:navigate
                    class="text-blue-500 font-semibold hover:text-blue-600 hover:underline transition-all duration-200">
                    Iniciar sesión
                </a>
            </p>
        </div>

    </div>
</div>
