<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="https://actores.org.co/favicon.ico" type="image/x-icon">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .main {
            background-image: url("{{ asset('assets/img/fondos/a.png') }}");
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100vw;
            height: 100vh;
        }

        .container {
            max-width: 1000px;
        }

        @media (max-width: 990px) {
            .title_app {
                display: none;
            }
            .card-login{
                width: 90vw;
                height: 90vh;
                margin: auto;
            }

            .card-login .card-body{
                padding: 2rem !important;
            }
            .card-login .card-header{
                padding: 1rem !important;
            }
            .form-login{
                position: relative;
            }
            .group-actions-login{
                width: 100%;
                margin-top: 3rem;
                position: absolute;
                bottom: -10rem;
                display: flex;
                justify-content: center !important;
                align-items: center !important;
                flex-direction: row-reverse !important;
            }
            .btn-login{
                width: 100%;
                margin-top: 2rem;
            }
        }
    </style>
</head>

<body class="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="w-100 h-100 d-flex justify-content-start align-items-center">
                    <div class="title_app">
                        <!-- <img src="{{ asset('assets/img/logos/wordmark.png') }}" alt=""> -->
                        <span class="text-white fw-bold fs-1">ACTORES ID</span>
                        <h6 class="text-white">Inicia sesión o crea una cuenta</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6">
                {{ $slot }}
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>