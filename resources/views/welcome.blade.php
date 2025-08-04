<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Styles -->

        <style>
            body{
                height: 100vh;
                width: 100vw;
                display: flex;
                justify-content: center;
                align-items: center;
                /* background-image: url('/assets/img/fondos/a.png'); */
                background-size:cover;
                background-position:center;  
            }
        </style>
     
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="d-flex flex-column">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <span class="fs-3 opacity-40 d-block mb-5">ACTORES ID</span>
                        </div>
                        @if (Route::has('login'))
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="text-center btn btn-sm btn-primary"
                                    >
                                        Ir a menú principal
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        Iniciar sesión
                                    </a>

                                    @if (Route::has('register'))
                                        {{-- <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Registrarme
                                        </a> --}}
                                    @endif
                                @endauth
                        @endif
                    </header>

                    <main class="mt-6">
                       
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        
                    </footer>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
