<x-guest-layout>
    <div class="bg-gray-50">
        <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
            <div class="max-w-md w-full">
                <div class="p-8 rounded-2xl bg-white shadow">
                    <h2 class="text-slate-900 text-center text-2xl font-semibold">Restablecer contraseña</h2>
                    <p class="text-slate-600 text-center text-sm mt-2">
                        Ingresa tu nueva contraseña para acceder nuevamente.
                    </p>

                    <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <!-- Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email -->
                        <!-- Campo visible pero deshabilitado -->
                        <div>
                            <x-input-label for="email" :value="__('Correo electrónico')" />
                            <x-text-input
                                id="email"
                                class="block mt-1 w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600 bg-gray-100 cursor-not-allowed"
                                type="email"
                                name="email_disabled"
                                :value="old('email', $request->email)"
                                disabled />
                        </div>

                        <!-- Campo oculto para enviar el valor -->
                        <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

                        <!-- Nueva contraseña -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Nueva contraseña')" />
                            <x-text-input id="password" class="block mt-1 w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                                type="password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirmar contraseña -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirmar nueva contraseña')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                                type="password" name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Submit -->
                        <div class="!mt-6">
                            <x-primary-button class="w-full py-2 px-4 text-[15px] font-medium tracking-wide rounded-md text-white bg-[#642D8E] hover:bg-blue-700 focus:outline-none cursor-pointer">
                                {{ __('Restablecer contraseña') }}
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