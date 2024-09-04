<x-app-layout>

    <style>

        .container{
            max-width: 1400px;
        }
        .areas {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .areas .card {
            width: 300px;
            height: 300px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

   

        .btn-ingresar-modulo {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 46px;
        }

        .btn-ingresar-modulo:hover{
            background-color: #642D8E;
            color: #fff !important;
        }

        .parrafo_main {
            color: #ABABAB;
            font-size: 0.8em;

        }



        @media (max-width: 768px) {
            .areas {
                grid-template-columns: 1fr;
            }

            .areas .card {
                width: 100%;
                height: auto;
            }
            .btn-ingresar-modulo{
                position: relative;
                top: 0;
                width: 100% !important;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <section>
        <div class="container">
            <!-- Recorrido - Menú -->
            <nav aria-label="breadcrumb" class="px-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Inicio</a></li>
                </ol>
            </nav>

            <div class="row">
                <div class="areas d-flex justify-content-around flex-wrap">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2 justify-content-start align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#642D8E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-gavel">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M13 10l7.383 7.418c.823 .82 .823 2.148 0 2.967a2.11 2.11 0 0 1 -2.976 0l-7.407 -7.385" />
                                    <path d="M6 9l4 4" />
                                    <path d="M13 10l-4 -4" />
                                    <path d="M3 21h7" />
                                    <path d="M6.793 15.793l-3.586 -3.586a1 1 0 0 1 0 -1.414l2.293 -2.293l.5 .5l3 -3l-.5 -.5l2.293 -2.293a1 1 0 0 1 1.414 0l3.586 3.586a1 1 0 0 1 0 1.414l-2.293 2.293l-.5 -.5l-3 3l.5 .5l-2.293 2.293a1 1 0 0 1 -1.414 0z" />
                                </svg>

                                <span class="title_card fw-semibold">Jurídica</span>
                            </div>
                            <span class="d-block mt-4 parrafo_main">Gestiona tus documentos y procesos legales de manera eficiente. Descubre todas las herramientas jurídicas disponibles.</span>
                            <span class="btn btn-sm btn-ligh mt-3 border fw-semibold text-secondary w-75 m-auto btn-ingresar-modulo">Ingresar</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2 justify-content-start align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#642D8E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-filled icon-tabler-layout-distribute-vertical">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 3a1 1 0 0 1 1 1v16a1 1 0 0 1 -2 0v-16a1 1 0 0 1 1 -1" />
                                    <path d="M20 3a1 1 0 0 1 1 1v16a1 1 0 0 1 -2 0v-16a1 1 0 0 1 1 -1" />
                                    <path d="M13 5a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3z" />
                                </svg>
                                <span class="title_card fw-semibold">Distribución</span>
                            </div>
                            <span class="d-block mt-4 parrafo_main">Administra pagos, asignaciones y liquidaciones de forma eficiente. Descubre todas las herramientas para distribuir fondos y gestionar participación de actores.</span>
                            <span class="btn btn-sm btn-ligh mt-3 border fw-semibold text-secondary w-75 m-auto btn-ingresar-modulo">Ingresar</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2 justify-content-start align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#642D8E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                </svg>

                                <span class="title_card fw-semibold">Socios</span>
                            </div>
                            <span class="d-block mt-4 parrafo_main">Administra y controla la información de socios de manera eficiente. Descubre todas las herramientas para gestionar y actualizar datos de miembros.</span>
                            <span class="btn btn-sm btn-ligh mt-3 border fw-semibold text-secondary w-75 m-auto btn-ingresar-modulo">Ingresar</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2 justify-content-start align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#642D8E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-heart-dollar">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M13 19l-1 1l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 0 1 8.785 4.444" />
                                    <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                    <path d="M19 21v1m0 -8v1" />
                                </svg>


                                <span class="title_card fw-semibold">Bienestar</span>
                            </div>
                            <span class="d-block mt-4 parrafo_main">Administra y controla la información de socios de manera eficiente. Descubre todas las herramientas para gestionar y actualizar datos de miembros.</span>
                            <span class="btn btn-sm btn-ligh mt-3 border fw-semibold text-secondary w-75 m-auto btn-ingresar-modulo">Ingresar</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2 justify-content-start align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#642D8E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                    <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" />
                                    <path d="M12 12l0 .01" />
                                    <path d="M3 13a20 20 0 0 0 18 0" />
                                </svg>


                                <span class="title_card fw-semibold">Administración</span>
                            </div>
                            <span class="d-block mt-4 parrafo_main">Optimiza la gestión de recursos y procesos internos. Descubre herramientas clave para una administración eficiente.</span>
                            <span class="btn btn-sm btn-ligh mt-3 border fw-semibold text-secondary w-75 m-auto btn-ingresar-modulo">Ingresar</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2 justify-content-start align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#642D8E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-free-rights">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M13.867 9.75c-.246 -.48 -.708 -.769 -1.2 -.75h-1.334c-.736 0 -1.333 .67 -1.333 1.5c0 .827 .597 1.499 1.333 1.499h1.334c.736 0 1.333 .671 1.333 1.5c0 .828 -.597 1.499 -1.333 1.499h-1.334c-.492 .019 -.954 -.27 -1.2 -.75" />
                                    <path d="M12 7v2" />
                                    <path d="M12 15v2" />
                                    <path d="M6 6l1.5 1.5" />
                                    <path d="M16.5 16.5l1.5 1.5" />
                                </svg>


                                <span class="title_card fw-semibold">Contabilidad</span>
                            </div>
                            <span class="d-block mt-4 parrafo_main">Controla tus finanzas con precisión. Accede a herramientas esenciales para la gestión contable eficiente.</span>
                            <span class="btn btn-sm btn-ligh mt-3 border fw-semibold text-secondary w-75 m-auto btn-ingresar-modulo">Ingresar</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2 justify-content-start align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#642D8E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-broadcast">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M18.364 19.364a9 9 0 1 0 -12.728 0" />
                                    <path d="M15.536 16.536a5 5 0 1 0 -7.072 0" />
                                    <path d="M12 13m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                </svg>


                                <span class="title_card fw-semibold">Visionado</span>
                            </div>
                            <span class="d-block mt-4 parrafo_main">Revisa y analiza contenido audiovisual con precisión. Descubre herramientas para una evaluación detallada.</span>
                            <span class="btn btn-sm btn-ligh mt-3 border fw-semibold text-secondary w-75 m-auto btn-ingresar-modulo">Ingresar</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex gap-2 justify-content-start align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#642D8E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-address-book">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" />
                                    <path d="M10 16h6" />
                                    <path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M4 8h3" />
                                    <path d="M4 12h3" />
                                    <path d="M4 16h3" />
                                </svg>


                                <span class="title_card fw-semibold">Recursos Humanos</span>
                            </div>
                            <span class="d-block mt-4 parrafo_main">Gestiona talento y desarrollo profesional de forma efectiva. Descubre herramientas clave para optimizar el capital humano.</span>
                            <span class="btn btn-sm btn-ligh mt-3 border fw-semibold text-secondary w-75 m-auto btn-ingresar-modulo">Ingresar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>