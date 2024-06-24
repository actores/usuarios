<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <section>
        <div class="container">

            <!-- Recorrido - Menú -->
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Distribucion</li>
                </ol>
            </nav>

            <div class="row">
                <div class="areas">
                    <a href="/proveedores">
                        <div class="card px-4 py-2">
                            <div class="card-body d-flex gap-2 justify-between align-items-center">
                                <i class="fa-solid fa-folder fs-1"></i>
                                <span class="title_card">Pago Usuarios</span>
                            </div>
                        </div>
                    </a>
                    <a href="/distribucion/recuento">
                        <div class="card px-4 py-2">
                            <div class="card-body d-flex gap-2 justify-between align-items-center">
                                <i class="fa-solid fa-folder fs-1"></i>
                                <span class="title_card">Distribuciones</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
