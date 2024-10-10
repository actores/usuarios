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
                        <li class="breadcrumb-item active" aria-current="page">Ingreso</li>
                    </ol>
                </nav>
                <div class="">
                    <a href="{{ url('/nuevo/visitante') }}" class="btn btn-primary btn-sm">Nuevo visitante</a>
                    <a href="{{url('/consulta/registros')}}" class="btn btn-outline-secondary btn-sm">Consultar ingresos</a>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">

                    <table class="table table-hover" id="data-table-ingresos">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">NOMBRE</th>
                                <th scope="col">TIPO</th>
                                <th scope="col">FECHA</th>
                                <th scope="col">ENTRADA</th>
                                <th scope="col">ÁREA</th>
                                <th scope="col">MOTIVO</th>
                                <th scope="col">HORA_SALIDA</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ingresos as $ingreso)
                            @if($ingreso->tipo == 0)
                            <tr>
                                <td>{{ $ingreso->id }}</td>
                                <td>
                                    <span class="d-flex flex-column">
                                        <span class="fw-medium">{{ $ingreso->socio_nombre }}</span>
                                        <span>{{ $ingreso->socio_identificacion }}</span>
                                    </span>
                                </td>
                                <td>Socio</td>
                                <td>{{ $ingreso->fecha }}</td>
                                <td>{{ $ingreso->hora_entrada }}</td>
                                <td>{{ $ingreso->area }}</td>
                                <td>{{ $ingreso->motivo }}</td>
                                <td>{{ $ingreso->hora_salida == NULL ? '-- -- --' : $ingreso->hora_salida }}</td>
                                <td>
                                <a href="/salida/{{ $ingreso->id }}" data-id="{{ $ingreso->id }}" class="dar-salida">Dar salida</a>
                                </td>
                            </tr>
                            @elseif($ingreso->tipo == 1)
                            <tr>
                                <td>{{ $ingreso->id }}</td>
                                <td>
                                    <span class="d-flex flex-column">
                                        <span class="fw-medium">{{ $ingreso->visitante_nombre }}</span>
                                        <span>{{ $ingreso->visitante_identificacion }}</span>
                                    </span>
                                </td>
                                <td>Visitante</td>
                                <td>{{ $ingreso->fecha }}</td>
                                <td>{{ $ingreso->hora_entrada }}</td>
                                <td>{{ $ingreso->area }}</td>
                                <td>{{ $ingreso->motivo }}</td>
                                <td>{{ $ingreso->hora_salida == NULL ? '-- -- --' : $ingreso->hora_salida }}</td>
                                <td>
                                    <a href="/salida/{{ $ingreso->id }}" data-id="{{ $ingreso->id }}" class="dar-salida">Dar salida</a>
                                </td>
                            </tr>
                            @endif

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    @push('scripts')
    <script>

    </script>
    @endpush

</x-app-layout>