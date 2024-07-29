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

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: "Operación exitosa",
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
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/menu/socios') }}">Socios</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Obras</li>

                    </ol>
                </nav>
                <div class="">
                    <div class="btn btn-secondary btn-sm" id="openModalNuevaObra">Nueva obra
                    </div>
                    <a href="/exportarProducciones" class="btn btn-secondary btn-sm">Exportar obras</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="" id="data-table-obras">
                        <thead>
                            <tr>
                                <th scope="col">Título</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">País</th>
                                <th scope="col">Año</th>
                                <th scope="col">Director</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producciones as $produccion)
                                <tr>
                                    <td>{{ $produccion->tituloObra }}</td>
                                    <td>{{ $produccion->tipoProduccion }}</td>
                                    <td>{{ $produccion->pais }}</td>
                                    <td>{{ $produccion->anio }}</td>
                                    <td>{{ $produccion->director }}</td>
                                    <td>
                                        <a href="#" class="edit-link" data-id="{{ $produccion->id }}">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>


    <!-- Modal Nueva Obra-->
    <div class="modal fade" id="modalObra" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tituloModal">Nueva Obra</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/agregarProduccion" method="POST" enctype="multipart/form-data" class="px-4 py-2"
                        id="form_nueva_obra">
                        @csrf
                        <input type="hidden" name="operacion" value="1" id="operacion">
                        <input type="hidden" name="inputProduccionId" id="inputProduccionId">
                        <div class="mb-3">
                            <label for="inputTituloObra" class="form-label">Título Obra</label>
                            <input type="text" class="form-control" name="inputTituloObra" id="inputTituloObra"
                                placeholder="Ingresa título de la obra">
                        </div>
                        <div class="mb-3">
                            <label for="inputTipoProduccion" class="form-label">Tipo de producción</label>
                            <select class="form-select" aria-label="Tipo de producción" name="inputTipoProduccion"
                                id="inputTipoProduccion">
                                <option value="" selected>Seleccione un tipo</option>
                                <option value="Serie">Serie</option>
                                <option value="Miniserie">Miniserie</option>
                                <option value="Película">Película</option>
                                <option value="Documental">Documental</option>
                                <option value="Programa de entretenimiento">Programa de entretenimiento</option>
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="inputPais" class="form-label">País</label>
                                <input type="text" class="form-control" name="inputPais" id="inputPais"
                                    placeholder="Ingrese país" aria-label="País">
                            </div>
                            <div class="col-md-6">
                                <label for="inputAnio" class="form-label">Año</label>
                                <input type="number" class="form-control" name="inputAnio" id="inputAnio"
                                    placeholder="Año" aria-label="año">
                            </div>
                            <div class="col-md-12">
                                <label for="inputDirector" class="form-label">Director</label>
                                <input type="text" class="form-control" name="inputDirector" id="inputDirector"
                                    placeholder="ingrese director" aria-label="Director">
                            </div>

                        </div>
                        <div class="modal-footer mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="btn_action_modal">Guardar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>




    @push('scripts')
        <script>
            new DataTable('#data-table-obras', {
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
                $('#form_nueva_obra').validate({
                    rules: {
                        inputTituloObra: {
                            required: true,
                        },
                        inputTipoProduccion: {
                            required: true,
                        },
                        inputPais: {
                            required: true,
                        },
                        inputAnio: {
                            required: true,
                            digits: true // Asegura que solo sean dígitos
                        },
                        inputDirector: {
                            required: true,
                        }
                    },
                    messages: {
                        inputTituloObra: {
                            required: "Por favor, ingresa el título de la obra",
                        },
                        inputTipoProduccion: {
                            required: "Por favor, selecciona el tipo de producción",
                        },
                        inputPais: {
                            required: "Por favor, ingresa el país"
                        },
                        inputAnio: {
                            required: "Por favor, ingresa el año de producción",
                            digits: "El año debe ser un valor numérico"
                        },
                        inputDirector: {
                            required: "Por favor, ingresa el nombre del director",
                        }
                    },
                    submitHandler: function(form) {
                        // Aquí se ejecuta cuando el formulario es válido
                        form
                            .submit(); // Esto envía el formulario como si se hubiera hecho clic en el botón de submit
                    }
                });
            });

            $('#openModalNuevaObra').click(() => {
                $('#form_nueva_obra')[0].reset();
                document.getElementById('operacion').value = 1
                document.getElementById('btn_action_modal').innerHTML = 'Guardar'
                document.getElementById('tituloModal').innerHTML = 'Nueva Obra'
                $('#modalObra').modal('show');
            })

            function attachEditEvent() {
                // Selecciona todos los enlaces de edición
                const editLinks = document.querySelectorAll('.edit-link');

                // Itera sobre cada enlace y añade el evento de clic
                editLinks.forEach(function(link) {
                    link.addEventListener('click', function(event) {
                        event.preventDefault(); // Evita el comportamiento por defecto del enlace

                        // Obtiene la fila (tr) más cercana al enlace
                        const row = this.closest('tr');

                        // Obtiene todos los <td> dentro de esa fila
                        const cells = row.querySelectorAll('td');

                        const dataId = this.getAttribute('data-id');

                        // Extrae los valores de los <td>
                        const values = Array.from(cells).map(cell => cell.textContent.trim());


                        // Llena el formulario con los valores extraídos
                        document.getElementById('inputProduccionId').value = dataId;
                        document.getElementById('operacion').value = 2;
                        document.getElementById('inputTituloObra').value = values[0];
                        document.getElementById('inputTipoProduccion').value = values[1];
                        document.getElementById('inputPais').value = values[2];
                        document.getElementById('inputAnio').value = values[3];
                        document.getElementById('inputDirector').value = values[4];
                        document.getElementById('btn_action_modal').innerHTML = 'Editar';
                        document.getElementById('tituloModal').innerHTML = 'Editar Obra';

                        // Muestra el modal
                        $('#modalObra').modal('show');
                    });
                });
            }

            // Adjunta los eventos de clic iniciales
            attachEditEvent();

            // Adjunta los eventos de clic después de cada redibujado de DataTables
            $('#data-table-obras').on('draw.dt', function() {
                attachEditEvent();
            });



            $('#modalObra').on('hidden.bs.modal', function() {

                $('#form_nueva_obra')[0].reset();
            });
        </script>
    @endpush

</x-app-layout>
