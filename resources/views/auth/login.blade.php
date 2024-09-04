<x-guest-layout>
    <!-- Session Status -->
    <style>
        .card-header-login {
            background-color: #ED3E2A;
            color: #fff;
        }

        .btn-login {
            background-color: #ED3E2A !important;
        }
    </style>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="card border-0 card-login">
        <div class="card-header px-5 py-4 card-header-login d-flex gap-2">

            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-info-circle">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" />
            </svg>
            Por tu seguridad, verifica tu identidad.
        </div>
        <div class="card-body p-5">
            <form method="POST" action="{{ route('login') }}" class="form-login">
                @csrf

                <h1 class="fs-3 fw-semibold mb-3">Inicio de sesión</h1>
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Dirección de correo electrónico')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap group-actions-login">
                    <div class="flex items-center justify-end">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    </div>
                    <x-primary-button class="w-100">
                        Siguiente
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>


</x-guest-layout>