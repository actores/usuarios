<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <section>
        <div class="container">

            <!-- Recorrido - Menú -->
            <nav aria-label="breadcrumb"
                style="--bs-breadcrumb-divider: url(data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='8' height='8'><path d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='#{$breadcrumb-divider-color}'/></svg>);">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Administración</li>
                </ol>
            </nav>

            <div class="row mt-5">
                <div class="areas">
                    <a href="{{ url('/ingreso') }}">
                        <div class="card px-2">
                            <div class="card-body d-flex gap-2 justify-start align-items-center">
                                <i class="fa-regular fa-folder fs-3 text-primary"></i>
                                <span class="title_card">Ingreso</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
