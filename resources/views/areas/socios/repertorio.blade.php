<x-app-layout>
    <style>
        .avatar_socio {
            width: 50px;
            height: 50px;
            background: red;
            border-radius: 50%;
        }

        table {
            font-size: 14px;
        }

        [role="navigation"] {
            margin-top: 2rem;
        }

        [role="navigation"] div:nth-child(2) {
            flex-direction: column !important;
        }


    </style>

    <section class="section_data">
        <div class="container">
            <!-- Recorrido - Menú -->
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/menu/socios') }}">Socios</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Repertorio</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <table class="" id="data-table-socios-repertorio">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Identificación</th>
                                <th scope="col">Número Socio</th>
                                <th scope="col">Número Actor</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($socios as $socio)
                                <tr>
                                    <td scope="row">
                                        <div class="d-flex gap-3">
                                            <img src="{{ $socio->imagen }}" alt="" class="avatar_socio">
                                            <span class="d-flex flex-column">
                                                <span>{{ $socio->nombre }}</span>
                                                @if ($socio->tipoSocio == 1)
                                                    <span>Pleno Derecho</span>
                                                @elseif($socio->tipoSocio == 2)
                                                    <span>Adherido</span>
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{ $socio->identificacion }}</td>
                                    <td>{{ $socio->numeroSocio }}</td>
                                    <td>{{ $socio->numeroArtista }}</td>
                                    <td>
                                        <a href="">Detalles</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            new DataTable('#data-table-socios-repertorio', {
                responsive: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                paging: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json' // Ruta al archivo JSON de localización
                },
                info: false,
                columnDefs: [{
                    targets: "_all",
                    sortable: false
                }],
                paging: true,
            });
        </script>
    @endpush

</x-app-layout>
