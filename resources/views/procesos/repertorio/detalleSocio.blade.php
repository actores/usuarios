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
                    <a href="/exportarRepertorioIndividual/{{$socio->id}}" class="btn btn-secondary btn-sm">Exportar repertorio</a>
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
                                        <a href="#" class="btn_editar_personaje_produccion_repertorio"
                                            data-id="{{ $produccion->id }}"
                                            data-personaje="{{ $produccion->personaje }}"
                                            data-titulo="{{ $produccion->tituloObra }}">Editar</a>

                                        <a href="#" class="btn_eliminar_produccion_repertorio"
                                            data-id="{{ $produccion->id }}"
                                            data-personaje="{{ $produccion->personaje }}"
                                            data-titulo="{{ $produccion->tituloObra }}">Eliminar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal Agregar Personaje-->
    <div class="modal fade" id="modaEditarPersonaje" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <div class="modal-title fw-bold" id="title_modal_add_productio"></div>
                        <label for="" class="text-center">Ingresa el personaje del socio en esta
                            producción</label>
                    </div>
                </div>
                <form action="/editarPersonaje" method="POST" id="actualizar_personaje_produccion">
                    @csrf
                    <div class="modal-body text-center">
                        <input type="hidden" name="socio_id" id="socio_id" value="{{ $socio->id }}">
                        <input type="hidden" name="produccion_id" id="produccion_id">
                        <input type="text" class="form-control" id="personaje_produccion" name="personaje_produccion"
                            placeholder="Nombre del personaje">
                        <div id="error-message" style="color: red;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btnValidate">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Agregar Personaje-->
    <div class="modal fade" id="modalEliminarProduccionRepertorio" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="modal-title fw-bold w-100 text-center">Confirmar y Eliminar</div>

                </div>

                <div class="modal-body">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p id="title_modal_add_production_delete" class="fw-bold text-secondary"></p>
                        <p id="personaje_modal_add_production_delete" class="fw-bold text-secondary"></p>
                    </div>



                    <input type="hidden" name="socio_id" id="socio_id" value="{{ $socio->id }}">

                    <div class="modal-footer  d-flex  justify-content-center align-items-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="" class="btn btn-secondary" id="btnDeleteProduccionRepertorio">Eliminar</a>
                    </div>
                    </form>
                </div>



            </div>
        </div>
    </div>

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

            $('.btn_editar_personaje_produccion_repertorio').each(function() {
                $(this).click(function() {
                    event.preventDefault();

                    // Capturar los valores de data-id y data-personaje
                    let produccionId = $(this).data('id');
                    let personaje = $(this).data('personaje');
                    let titulo = $(this).data('titulo');


                    $('#title_modal_add_productio').html(titulo)

                    $('#personaje_produccion').val(personaje)
                    $('#produccion_id').val(produccionId)
                    $('#modaEditarPersonaje').modal('show');

                    // personaje_produccion

                })
            });


            $('.btn_eliminar_produccion_repertorio').each(function() {
                $(this).click(function() {
                    event.preventDefault();

                    // Capturar los valores de data-id y data-personaje
                    let produccionId = $(this).data('id');
                    let personaje = $(this).data('personaje');
                    let titulo = $(this).data('titulo');


                    $('#title_modal_add_production_delete').html(titulo)
                    $('#personaje_modal_add_production_delete').html(personaje)

                    let ruta = `/eliminarProduccion/${produccionId}`

                    $('#btnDeleteProduccionRepertorio').attr('href', ruta);

                    $('#modalEliminarProduccionRepertorio').modal('show');
                })
            });

            $("#actualizar_personaje_produccion").validate({
                rules: {
                    personaje_produccion: {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    personaje_produccion: {
                        required: "Por favor, ingrese el nombre del personaje.",
                        minlength: "El nombre del personaje debe tener al menos 3 caracteres."
                    }
                },
                errorPlacement: function(error, element) {
                    error.appendTo("#error-message");
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        </script>
    @endpush

</x-app-layout>
