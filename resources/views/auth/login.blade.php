<x-guest-layout>
    <!-- Session Status -->
    <style>
        .card-header-login {
            background: var(--bs-primary);
            color: #fff;

        }

        .btn-login {
            background-color: var(--bs-primary) !important;
        }

        .card-login {
            /* border: solid 0.2px #ccc !important; */
            padding: 2rem
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none !important;
            box-shadow: none !important;
        }
    </style>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="card border-0 card-login">

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" class="form-login pb-3">
                @csrf

                <h1 class="fs-3 fw-semibold mb-3">Inicio de sesión</h1>
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Dirección de correo electrónico')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username"  />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Contraseña')" />

                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap group-actions-login">
                    {{-- <div class="flex items-center justify-end">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                            href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    </div> --}}
                    <x-primary-button class="w-100">
                        Siguiente
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>


</x-guest-layout>
