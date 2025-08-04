<x-guest-layout>
    <!-- Session Status -->
    <!-- <x-auth-session-status class="mb-4" :status="session('status')" /> -->

    <div class="bg-gray-50">
        <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
            <div class="max-w-md w-full">
                <div class="p-8 rounded-2xl bg-white shadow">
                    <h2 class="text-slate-900 text-center text-3xl font-semibold">Iniciar sesión</h2>
                    <p class="text-slate-600 text-center text-sm mt-2">Por favor, ingresa tus datos para acceder a tu cuenta.</p>
                    @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 text-center">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-6">
                        @csrf

                        <!-- Username -->
                        <div>
                            <x-input-label for="email" :value="__('Usuario')" />
                            <x-text-input id="email" class="block mt-1 w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Contraseña')" />
                            <x-text-input id="password" class="block mt-1 w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600"
                                type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Sign In Button -->
                        <div class="!mt-6">
                            <x-primary-button class="w-full py-2 px-4 text-[15px] font-medium tracking-wide rounded-md text-white bg-[#642D8E] hover:bg-blue-700 focus:outline-none cursor-pointer">
                                {{ __('Iniciar sesión') }}
                            </x-primary-button>
                        </div>

                    </form>

                    <div class="text-center mt-6 text-sm text-slate-600 dark:text-slate-400">
                        <a href="{{ route('password.request') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-guest-layout>