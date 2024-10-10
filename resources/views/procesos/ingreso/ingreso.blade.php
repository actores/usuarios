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
                                <th scope="col">IDENTIFICACIÓN</th>
                                <th scope="col">NOMBRE</th>
                                <th scope="col">TIPO</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($personas as $persona)
                            <tr>
                                <td>{{ $persona->identificacion }}</td>
                                <td>{{ $persona->nombre }}</td>
                                <td>
                                    {{ $persona->tipo_persona == 0 ? 'Socio' : ($persona->tipo_persona == 1 ? 'Visitante' : 'Otro') }}
                                </td>

                                <td>
                                    <a href="javascript:void(0);" class="dar-ingreso" data-id="{{ $persona->id }}" data-tipo="{{ $persona->tipo_persona }}">Dar ingreso</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal Registrar Ingresos-->
    <div class="modal fade" id="modalNuevoIngreso" tabindex="-1" aria-labelledby="modalNuevoIngreso" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Ingreso</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/ingreso/registro" method="POST" enctype="multipart/form-data" class="px-4 py-2"
                        id="form_registro_ingreso">
                        @csrf
                        <input type="hidden" name="idSocioVisitante" id="idSocioVisitante">
                        <input type="hidden" name="tipoPersona" id="tipoPersona">
                        <div class="mb-3">
                            <label for="inputIdentificacion" class="form-label">Identificación</label>
                            <input type="number" class="form-control" name="inputIdentificacion"
                                id="inputIdentificacion" placeholder="Ingresa número de identificación" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="inputNombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" name="inputNombre" id="inputNombre"
                                placeholder="Ingresa nombre completo" readonly>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="inputFechaIngreso" class="form-label">Fecha</label>
                                <input type="date" class="form-control" name="inputFechaIngreso"
                                    id="inputFechaIngreso" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="inputHoraIngreso" class="form-label">Hora</label>
                                <input type="time" class="form-control" name="inputHoraIngreso"
                                    id="inputHoraIngreso" readonly>
                            </div>
                            <div class="col-md-12">
                                <label for="inputAreaVisita" class="form-label">Área</label>
                                <select class="form-select" name="inputAreaVisita" id="inputAreaVisita">
                                    <option value="" selected>Seleccione un área</option>
                                    <option value="TI">TI</option>
                                    <option value="CONTABILIDAD">CONTABILIDAD</option>
                                    <option value="ADMINISTRACIÓN">ADMINISTRACIÓN</option>
                                    <option value="RECURSOS HUMANOS">RECURSOS HUMANOS</option>
                                    <option value="JURÍDICA">JURÍDICA</option>
                                    <option value="DISTRIBUCIÓN">DISTRIBUCIÓN</option>
                                    <option value="INTERNACIONAL">INTERNACIONAL</option>
                                    <option value="COMUNICACIONES">COMUNICACIONES</option>
                                    <option value="BIENESTAR SOCIAL">BIENESTAR SOCIAL</option>
                                    <option value="DIRECCIÓN EJECUTIVA">DIRECCIÓN EJECUTIVA</option>
                                    <option value="GESTIÓN DE SOCIOS">GESTIÓN DE SOCIOS</option>

                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="inputMotivoVisita" class="form-label">Motivo</label>
                                <textarea name="inputMotivoVisita" id="inputMotivoVisita" cols="30" rows="10" class="form-control"></textarea>
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
        function initializeDataTable(selector) {
            return new DataTable(selector, {
                responsive: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                paging: true, // Cambia a true o false según tus necesidades
                lengthChange: false,
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
                }]
            });
        }
        // Inicializa los DataTables
        initializeDataTable('#data-table-socios-ingresos');
        initializeDataTable('#data-table-ingresos');



        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('tbody').addEventListener('click', (event) => {
                if (event.target.classList.contains('dar-ingreso')) {
                    handleIngresoClick(event.target);

                }
            });
        });

        // Función simplificada para manejar el clic
        function handleIngresoClick(target) {
            const row = target.closest('tr'); // Encuentra la fila más cercana
            const cells = row.querySelectorAll('td'); // Obtiene todas las celdas de la fila


            // Extrae los valores directamente de las celdas
            const identificacion = cells[0].innerText; // Identificación
            const nombre = cells[1].innerText; // Nombre
            const id = target.getAttribute('data-id');
            const tipo = target.getAttribute('data-tipo');
            // Muestra los valores en la consola


            $('#idSocioVisitante').val(id);
            $('#tipoPersona').val(tipo);
            $('#inputIdentificacion').val(identificacion);
            $('#inputNombre').val(nombre);
            $('#inputFechaIngreso').val(new Date().toISOString().slice(0, 10));
            $('#inputHoraIngreso').val(new Date().toLocaleTimeString('en-GB', {
                hour: '2-digit',
                minute: '2-digit'
            }));

            $('#modalNuevoIngreso').modal('show');
        }
    </script>
    @endpush

</x-app-layout>