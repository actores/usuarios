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
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/menu/distribucion') }}">Distribución</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Proveedores</li>
                    </ol>
                </nav>
                <div class="">
                    <div class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalProveedor">Nuevo
                        proveedor</div>
                    <div class="btn btn-secondary btn-sm">Exportar</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="" id="data-table-socios-proveedores">
                        <thead>
                            <tr>
                                <th scope="col">PROVEEDOR</th>
                                <th scope="col">NIT</th>
                                <th scope="col">TIPO</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proveedores as $proveedor)
                                <tr>
                                    <td scope="row">
                                        <div class="d-flex gap-3 justify-content-start align-items-center">
                                            <img src="https://cdn-icons-png.flaticon.com/512/2202/2202942.png"
                                                alt="" class="avatar_socio">
                                            <span class="d-flex flex-column">
                                                {{ $proveedor->nombre }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{ $proveedor->nit }}</td>
                                    <td>{{ $proveedor->tipo_id }}</td>
                                    <td>
                                        <a href="/proveedores/detalle/{{$proveedor->id}}">Detalle</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>


    <!-- Modal nuevo proveedor-->
    <div class="modal fade" id="modalProveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo proveedor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/proveedores/nuevo" method="POST" enctype="multipart/form-data" class="px-4 py-2"
                        id="form_nuevo_proveedor">
                        @csrf

                        <div class="mb-3">
                            <label for="inputNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="inputNombre" id="inputNombre"
                                placeholder="Ingresa nombre completo">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="inputTipoProveedor" class="form-label">Tipo de proveedor</label>
                            <select class="form-select" aria-label="Tipo de socio" name="inputTipoProveedor"
                                id="inputTipoProveedor">
                                <option value="" selected>Seleccione un tipo</option>
                                @foreach ($tiposProveedor as $tipoProveedor)
                                    <option value="{{ $tipoProveedor->id }}">{{ $tipoProveedor->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="inputNit" class="form-label">Nit</label>
                            <input type="number" class="form-control" name="inputNit" id="inputNit"
                                placeholder="Ingresa número de nit">
                        </div>
                        <div class="mb-3">
                            <label for="inputDireccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="inputDireccion" id="inputDireccion"
                                placeholder="Ingresa dirección completa">
                        </div>
                        <div class="mb-3">
                            <label for="inputCiudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" name="inputCiudad" id="inputCiudad"
                                placeholder="Ingresa ciudad">
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
            new DataTable('#data-table-socios-proveedores', {
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
                $('#form_nuevo_proveedor').validate({
                    rules: {
                        inputNombre: {
                            required: true,
                        },
                        inputTipoProveedor: {
                            required: true
                        },
                        inputNit: {
                            required: true,
                            digits: true // Añadido para asegurar que solo sean dígitos
                        },
                        inputDireccion: {
                            required: true,
                        },
                        inputCiudad: {
                            required: true,
                        },
                    },
                    messages: {
                        inputNombre: {
                            required: "Por favor, ingresa el nombre",
                        },
                        inputTipoProveedor: {
                            required: "Por favor, selecciona un tipo"
                        },
                        inputNit: {
                            required: "Por favor, ingresa el número de nit",
                            digits: "El número de nit debe contener solo dígitos"
                        },
                        inputDireccion: {
                            required: "Por favor, ingresa el dirección",
                        },
                        inputCiudad: {
                            required: "Por favor, ingresa ciudad",
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
