<x-app-layout>
    <style>
        .avatar_socio {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            filter: grayscale(100%);
        }


        .dt-layout-row:first-child .dt-end {
            width: 100% !important;
        }

        .dt-layout-row:first-child {
            display: flex !important;
            flex-direction: column !important;
            flex-grow: 1;
            align-items: flex-start;
            width: 100%;
        }

        .dt-layout-row:first-child .dt-search {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .dt-layout-row:first-child .dt-search .dt-input {
            width: 100%;
            background: none !important;
        }

        select.dt-input {
            width: 5rem;
            background-position: right;
        }

        input.error,
        select.error {
            border: solid 1px #ff000096;
        }

        label.error {
            color: #ff000096;

        }

        #data-table-socios-ingresos,
        #data-table-ingresos {
            width: 100% !important;
        }

        .tab-pane {
            padding-top: 2rem;
        }
    </style>

    <section class="section_data">
        <div class="container">

            @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: "{{ session('success') }}",
                    text: "{{ session('success') }}"
                });
            </script>
            @endif

            @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: "{{ session('error') }}",
                    text: "{{ session('error') }}"
                });
            </script>
            @endif
            <!-- Recorrido - Menú -->
            <div class=" d-flex justify-content-between align-items-center">
                <nav style="--bs-breadcrumb-divider: url(data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='8' height='8'><path d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='#{$breadcrumb-divider-color}'/></svg>);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/menu/administracion') }}">Administración</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/ingreso') }}">Ingreso</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nuevo visitante</li>
                    </ol>
                </nav>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <form action="/nuevo/visitante" method="POST" enctype="multipart/form-data" class="px-4 py-2"
                        id="form_nuevo_visitante">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="inputIdentificacion" class="form-label">Identificación</label>
                            <input type="number" class="form-control" name="inputIdentificacion"
                                id="inputIdentificacion" placeholder="Ingresa número de identificación">
                        </div>
                        <div class="mb-3">
                            <label for="inputNombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" name="inputNombre" id="inputNombre"
                                placeholder="Ingresa nombre completo">
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="inputEmpresa" class="form-label">Empresa</label>
                                <input type="text" class="form-control" name="inputEmpresa"
                                    id="inputEmpresa">
                            </div>
                            <div class="col-md-6">
                                <label for="inputCargo" class="form-label">Cargo</label>
                                <input type="text" class="form-control" name="inputCargo"
                                    id="inputCargo">
                            </div>
                        </div>
                        <div class="modal-footer mt-4 gap-2">
                            <a href="/ingreso" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>



    @push('scripts')
    <script>

    </script>
    @endpush

</x-app-layout>