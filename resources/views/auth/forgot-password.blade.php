<x-guest-layout>
    <div class="bg-gray-50">
        <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
            <div class="max-w-md w-full">
                <div class="p-8 rounded-2xl bg-white shadow">
                    <h2 class="text-slate-900 text-center text-2xl font-semibold">¿Olvidaste tu contraseña?</h2>
                    <p class="text-slate-600 text-center text-sm mt-2">
                        No te preocupes. Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla.
                    </p>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4 mt-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Correo electrónico')" />
                            <x-text-input id="email" class="block mt-1 w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                                type="email" name="email" :value="old('email')" required autofocus />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Submit Button -->
                        <div class="!mt-6">
                            <x-primary-button class="w-full py-2 px-4 text-[15px] font-medium tracking-wide rounded-md text-white bg-[#642D8E] hover:bg-blue-700 focus:outline-none cursor-pointer">
                                {{ __('Enviar enlace de recuperación') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <div class="text-center mt-6 text-sm text-slate-600 dark:text-slate-400">
                        <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                            Volver al inicio de sesión
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>