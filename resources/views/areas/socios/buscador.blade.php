<x-app-layout>

    <style>
        .section_buscador_principal {
            background: #fff;
            height: 100vh;
        }

        main {
            padding-top: 0;
        }
    </style>
    <section class="section_buscador_principal">

        <div class="container h-100 w-100 d-flex flex-column justify-center align-items-center">

            <div class="w-50">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/menu/socios') }}">Socios</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Repertorio</li>
                    </ol>
                </nav>
                <div class="d-block fw-medium my-2">Buscador de socios</div>
                <form action="/menu/socios/repertorio/buscar" method="POST" class="d-flex gap-3">
                    @csrf
                    <input type="number" class="form-control m-auto" name="data_buscar" id="buscar_identificacion"
                        placeholder="Ingresa número de identificación">
                    <button type="submit" class="btn btn-secondary btn-sm">Buscar</button>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
