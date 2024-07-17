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



            <!-- Recorrido - Menú -->
            <div class="d-flex justify-content-between align-items-center">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/menu/socios') }}">Socios</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/menu/socios/repertorio') }}">Repertorio</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> <a
                                href="/menu/socios/repertorio/socio/{{ $socio->id }}">{{ $socio->nombre }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Agregar Producción</li>
                    </ol>
                </nav>


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
                    <h4>Selecciona las producciones</h4>
                    <table class="table" id="data-table-producciones-general">
                        <thead>
                            <tr>
                                <th scope="col">TÍTULO OBRA</th>
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
                                    <td>{{ $produccion->tipoProduccion }}</td>
                                    <td>{{ $produccion->pais }}</td>
                                    <td>{{ $produccion->anio }}</td>
                                    <td>{{ $produccion->director }}</td>
                                    <td>
                                        <a href="#" data-id="{{ $produccion->id }}"
                                            data-name="{{ $produccion->tituloObra }}"
                                            class="btnPreAgregarProduccion">Agregar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr class="my-5">
                <div class="col-md-12 mb-5">
                    <div class="d-flex justify-between my-4 align-items-center">
                        <h4 class="m-0">Bahia nuevas producciones</h4>
                        <div class="">
                            <a href="#" class="btn btn-secondary btn-sm" id="btn_limpiar">Limipiar</a>
                            <div class="btn btn-secondary btn-sm" id="btn_confirmar_agregar_modal"><i
                                    class="fa-solid fa-floppy-disk"></i> Confirmar y
                                agregar</div>
                        </div>
                    </div>
                    <ol class="list-group list-group-numbered" id="lista-producciones">
                        <div class="alert alert-light" role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            No has agregado <a href="#" class="alert-link">nuevas producciones</a>. Selecciona las
                            producciones que deseas matricular para este socio.
                        </div>
                    </ol>

                </div>
            </div>
        </div>
    </section>


    <!-- Modal Agregar Personaje-->
    <div class="modal fade" id="modalAgregarPersonaje" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                <div class="modal-body text-center">

                    <input type="text" class="form-control" id="personaje_produccion"
                        placeholder="Nombre del personaje">
                    <div id="error-message" style="color: red;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnValidate">Siguiente</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar y registrar producciones-->
    <div class="modal fade" id="confirmarProducciones" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar producciones</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="listaConfirmarProducciones"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="/agregarProducciones" method="POST">
                        @csrf
                        <input type="hidden" name="inputSocio" id="inputSocio" value="{{ $socio->id }}">
                        <input type="hidden" name="inputNuevasProducciones" id="inputNuevasProducciones">
                        <button type="submit" class="btn btn-primary">Matricular Producciones</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Array para almacenar producciones a agregar
                let produccionesAgregar = [];

                // Inicialización de DataTables
                $('#data-table-producciones-general').DataTable({
                    responsive: true,
                    paging: true,
                    language: {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sSearch": "Buscar:",
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

                // Delegación de eventos para manejar clic en elementos dinámicos
                $('#data-table-producciones-general').on('click', '.btnPreAgregarProduccion', function(event) {
                    event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace

                    let dataId = $(this).data('id'); // Obtener el valor de data-id usando jQuery
                    let dataName = $(this).data('name'); // Obtener el valor de data-name usando jQuery

                    if (dataId && dataName) {
                        if (produccionesAgregar.some(prod => prod.id === dataId)) {
                            alert('La producción ya ha sido seleccionada.');
                            // Puedes mostrar un mensaje al usuario o simplemente no hacer nada
                            return;
                        }
                        $('#title_modal_add_productio').html(dataName)
                        $('#modalAgregarPersonaje').modal('show');

                        // Evento clic en el botón de validación
                        $('#btnValidate').off('click').on('click', function(event) {
                            event.preventDefault(); // Prevenir el envío del formulario (si hay uno)

                            // Validar el campo de entrada
                            let personaje = validateInput();

                            // Agregar datos a la lista de producciones para agregar
                            if (personaje !== false) {
                                let produccionAgregar = {
                                    id: dataId,
                                    name: dataName,
                                    character: personaje
                                };

                                produccionesAgregar.push(produccionAgregar);
                                console.log(produccionesAgregar);

                                // Limpiar campo de entrada y cerrar modal
                                $('#personaje_produccion').val('');
                                $('#modalAgregarPersonaje').modal('hide');

                                // Mostrar las producciones para agregar
                                mostrarProduccionesParaAgregar();
                            }
                        });
                    } else {
                        console.error('El elemento clickeado no tiene atributo data-id o data-name definido.');
                    }
                });

                // Función para validar el campo de entrada
                function validateInput() {
                    let inputValue = $('#personaje_produccion').val().trim();

                    // Verificar si el campo está vacío
                    if (inputValue === '') {
                        $('#error-message').text('El campo no puede estar vacío');
                        return false;
                    }

                    // Limpiar mensaje de error si es válido
                    $('#error-message').text('');
                    return inputValue; // Retornar el valor del personaje ingresado
                }

                // Función para mostrar las producciones a agregar en la lista
                function mostrarProduccionesParaAgregar() {
                    let templateItem = '';
                    let templateItemModal = '';

                    if (produccionesAgregar.length === 0) {
                        // Mostrar mensaje cuando no hay producciones agregadas
                        $('#lista-producciones').html(
                            `<div class="alert alert-light" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    No has agregado <a href="#" class="alert-link">nuevas producciones</a>. Selecciona las producciones que deseas matricular para este socio.
                </div>`
                        );

                        $('#listaConfirmarProducciones').html('');
                    } else {



                        produccionesAgregar.forEach(element => {
                            templateItem += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">${element.name}</div>
                            ${element.character}
                        </div>
                        <span class="badge text-bg-secondary rounded-pill">
                            <a href="#" class="btn_delete_production_tem"><i class="fa-solid fa-circle-minus text-white"></i></a> 
                        </span>
                    </li>`;


                            templateItemModal += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">${element.name}</div>
                            ${element.character}
                        </div>
                    </li>`;
                        });

                        // Mostrar la lista de producciones para agregar
                        $('#lista-producciones').html(templateItem);
                        $('#listaConfirmarProducciones').html(templateItemModal);
                    }
                }

                function limpiarBahia() {

                    $('#btn_limpiar').click(function() {
                        $('#lista-producciones').html(
                            `
                            <div class="alert alert-light" role="alert">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                No has agregado <a href="#" class="alert-link">nuevas producciones</a>. Selecciona las producciones que deseas matricular para este socio.
                            </div>
                        `
                        )

                        $('#listaConfirmarProducciones').html('');



                        produccionesAgregar = []
                    })

                }

                function confirmarProducciones() {
                    $('#btn_confirmar_agregar_modal').click(function() {

                        let data = JSON.stringify(produccionesAgregar);

                        let numeroDeElementos = Object.keys(produccionesAgregar).length;
                        if (numeroDeElementos > 0) {
                            $('#inputNuevasProducciones').val(data)
                            $('#confirmarProducciones').modal('show');
                        } else {
                            alert('Selecciona las producciones que deseas agregar');
                        }
                    })
                }
                $('#lista-producciones').on('click', '.btn_delete_production_tem', function(event) {
                    event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace

                    // Aquí puedes ejecutar tu lógica para eliminar el elemento
                    // Por ejemplo, podrías eliminar el elemento del array `produccionesAgregar` y volver a renderizar la lista
                    let elementoParaEliminar = $(this).closest('li');
                    let nombreProduccion = elementoParaEliminar.find('.fw-bold').text();

                    // Encontrar y eliminar la producción del array `produccionesAgregar`
                    produccionesAgregar = produccionesAgregar.filter(produccion => produccion.name !==
                        nombreProduccion);

                    // Volver a renderizar la lista
                    mostrarProduccionesParaAgregar();
                });

                limpiarBahia()
                confirmarProducciones()
                mostrarProduccionesParaAgregar();



            });
        </script>
    @endpush

</x-app-layout>
