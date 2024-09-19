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
    </style>

    <section class="section_data">
        <div class="container">

            @if(session('success'))
            <script>
                alert();
                Swal.fire({
                    icon: 'success',
                    title: "{{ session('success') }}",
                    text: "{{ session('success') }}"
                });
            </script>
            @endif

            @if(session('error'))
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
                <nav style="--bs-breadcrumb-divider: url(data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='8' height='8'><path d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='#{$breadcrumb-divider-color}'/></svg>);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/menu/socios') }}">Socios</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Repertorio</li>
                    </ol>
                </nav>
                <div class="">
                    <div class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalSocio">Nuevo socio</div>
                    <a href="/exportarRepertorio" class="btn btn-outline-secondary btn-sm">Exportar repertorio</a>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <table class="table table-hover" id="data-table-socios-repertorio">
                        <thead>
                            <tr>
                                <th scope="col">SOCIO</th>
                                <th scope="col">IDENTIFICACIÓN</th>
                                <th scope="col">NÚMERO DE SOCIO</th>
                                <th scope="col">NÚMERO DE ARTISTA</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($socios as $socio)
                            <tr>
                                <td scope="row">
                                    <div class="d-flex gap-3">
                                        <img src="{{ asset('storage/' . $socio->imagen) }}" alt="" class="avatar_socio">
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
                                    <a href="/menu/socios/repertorio/socio/{{ $socio->id }}">Repertorio</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>


    <!-- Modal gestión Socio-->
    <div class="modal fade" id="modalSocio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo socio</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/nuevosocio" method="POST" enctype="multipart/form-data" class="px-4 py-2" id="form_nuevo_socio">
                        @csrf
                        <div class="mb-3">
                            <label for="inputIdentificacion" class="form-label">Identificación</label>
                            <input type="number" class="form-control" name="inputIdentificacion" id="inputIdentificacion" placeholder="Ingresa número de identificación">
                        </div>
                        <div class="mb-3">
                            <label for="inputNombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" name="inputNombre" id="inputNombre" placeholder="Ingresa nombre completo">
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="inputNumeroSocio" class="form-label">Número Socio</label>
                                <input type="number" class="form-control" name="inputNumeroSocio" id="inputNumeroSocio" placeholder="Número de socio" aria-label="Número de socio">
                            </div>
                            <div class="col-md-6">
                                <label for="inputNumeroArtista" class="form-label">Número Artista</label>
                                <input type="number" class="form-control" name="inputNumeroArtista" id="inputNumeroArtista" placeholder="Número de artista" aria-label="Número artista">
                            </div>
                            <div class="col-md-12">
                                <label for="inputTipoSocio" class="form-label">Tipo de socio</label>
                                <select class="form-select" aria-label="Tipo de socio" name="inputTipoSocio" id="inputTipoSocio">
                                    <option value="" selected>Seleccione un tipo</option>
                                    <option value="1">Pleno Derecho</option>
                                    <option value="2">Adherido</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="inputFoto" class="form-label">Foto</label>
                                <input type="file" class="form-control" name="inputFoto" id="inputFoto" placeholder="Foto" aria-label="Foto">
                            </div>
                        </div>
                        <div class="modal-footer mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        new DataTable('#data-table-socios-repertorio', {
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


        $(document).ready(function() {
            $('#form_nuevo_socio').validate({
                rules: {
                    inputIdentificacion: {
                        required: true,
                    },
                    inputNombre: {
                        required: true,
                    },
                    inputNumeroSocio: {
                        required: true,
                        digits: true // Añadido para asegurar que solo sean dígitos
                    },
                    inputNumeroArtista: {
                        required: true,
                        digits: true // Añadido para asegurar que solo sean dígitos
                    },
                    inputTipoSocio: {
                        required: true,
                    },
                    inputFoto: {
                        required: true,
                    },
                },
                messages: {
                    inputIdentificacion: {
                        required: "Por favor, ingresa la identificación",
                    },
                    inputNombre: {
                        required: "Por favor, ingresa el nombre",
                    },
                    inputNumeroSocio: {
                        required: "Por favor, ingresa el número de socio",
                        digits: "El número de socio debe contener solo dígitos"
                    },
                    inputNumeroArtista: {
                        required: "Por favor, ingresa el número de artista",
                        digits: "El número de artista debe contener solo dígitos"
                    },
                    inputTipoSocio: {
                        required: "Por favor, ingresa el tipo de socio",
                    },
                    inputFoto: {
                        required: "Por favor, selecciona una foto",
                    },
                },
                submitHandler: function(form) {
                    // Aquí se ejecuta cuando el formulario es válido
                    form.submit(); // Esto envía el formulario como si se hubiera hecho clic en el botón de submit
                }
            });
        });
    </script>
    @endpush

</x-app-layout>