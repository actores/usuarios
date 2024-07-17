<x-app-layout>
    <style>
        .avatar_socio {
            display: block;
            width: 7rem;
            height: 7rem;
            border-radius: 50%;
            padding: 0;
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
    </style>

    <section class="section_data">
        <div class="container">

            @if (session('mensaje'))
                <script>
                    Swal.fire({
                        title: "Operación exitosa",
                        text: "{{ session('mensaje') }}",
                        icon: "success"
                    });
                </script>
            @endif
            <!-- Recorrido - Menú -->
            <div class="d-flex justify-content-between align-items-center">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/menu/socios') }}">Socios</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/menu/socios/repertorio') }}">Repertorio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $socio->nombre }}</li>
                    </ol>
                </nav>

                <div class="">
                    <a href="/agregarProduccion/{{ $socio->id }}" class="btn btn-secondary btn-sm">Agregar
                        producción</a>
                    <div class="btn btn-secondary btn-sm">Exportar repertorio</div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="profile d-flex justify-content-between align-items-center gap-4">
                        <span class="d-flex gap-4">
                            <img src="{{ asset('storage/' . $socio->imagen) }}" alt="" class="avatar_socio">
                            <div class="d-flex flex-column justify-content-center">
                                <h4 class="mb-0">{{ $socio->nombre }}</h4>
                                <span>{{ $socio->identificacion }}</span>
                            </div>
                        </span>
                        <span class="d-flex flex-column ml-5">
                            <span class="mb-0">Número Socio</span>
                            <span>{{ $socio->numeroSocio }}</span>
                        </span>
                        <span class="d-flex flex-column ml-5">
                            <span class="mb-0">Número Artista</span>
                            <span>{{ $socio->numeroArtista }}</span>
                        </span>
                        <span class="d-flex flex-column ml-5">
                            <span class="mb-0">Tipo de socio</span>
                            @if ($socio->tipoSocio == 1)
                                <span>Pleno Derecho</span>
                            @elseif($socio->tipoSocio == 2)
                                <span>Adherido</span>
                            @endif
                        </span>

                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <table class="table" id="data-table-socios-repertorio-detalle">
                        <thead>
                            <tr>
                                <th scope="col">TÍTULO OBRA</th>
                                <th scope="col">PERSONAJE</th>
                                <th scope="col">TIPO PRODUCCION</th>
                                <th scope="col">PAÍS</th>
                                <th scope="col">AÑO</th>
                                <th scope="col">DIRECTOR</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producciones as $produccion)
                                <tr>
                                    <th>{{ $produccion->tituloObra }}</th>
                                    <td>{{ $produccion->personaje }}</td>
                                    <td>{{ $produccion->tipoProduccion }}</td>
                                    <td>{{ $produccion->pais }}</td>
                                    <td>{{ $produccion->anio }}</td>
                                    <td>{{ $produccion->director }}</td>
                                    <td>
                                        <a href="#" id="btn_editar_personaje_produccion_repertorio"
                                            data-id="{{ $produccion->id }}"
                                            data-personaje="{{ $produccion->personaje }}">Editar</a>
                                        <a href="">Eliminar</a>
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
            new DataTable('#data-table-socios-repertorio-detalle', {
                responsive: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                paging: false,
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sSearch": "Buscar:",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                },
                info: false,
                columnDefs: [{
                    targets: "_all",
                    sortable: false
                }],
                paging: true,
            });


            $('#btn_editar_personaje_produccion_repertorio').click(function() {
                event.preventDefault();

                // Capturar los valores de data-id y data-personaje
                let produccionId = $(this).data('id');
                let personaje = $(this).data('personaje');

                // Puedes utilizar los valores capturados como necesites
                console.log('ID de Producción:', produccionId);
                console.log('Personaje:', personaje);
            })
        </script>
    @endpush

</x-app-layout>
