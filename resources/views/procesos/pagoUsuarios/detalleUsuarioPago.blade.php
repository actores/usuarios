<x-app-layout>
    <section class="py-6">
        <div class="mx-auto">

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
            @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'No pudimos guardar el usuario',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonText: 'Entendido'
                });
            </script>
            @endif

            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
                <ol class="flex p-0 m-0 list-none">
                    <li>
                        <a href="{{ url('/dashboard') }}" class="hover:underline text-blue-600">Inicio</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li>
                        <a href="{{ url('/usuarios') }}" class="hover:underline text-blue-600">Usuarios</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li>
                        <a href="{{ url('/usuarios/detalle') . '/' . $usuario->id }}" class="hover:underline text-blue-600">{{ $usuario->nombre }}</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="text-gray-500" aria-current="page">{{ $pago->anio_explotacion }}</li>
                </ol>
            </nav>


            <!-- Perfil -->
            <div class="bg-white shadow rounded-lg p-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-sky-600 text-white rounded-full flex items-center justify-center font-bold text-lg uppercase">
                        {{ substr($usuario->nombre, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">{{ $usuario->nombre }}</h2>
                        <span class="flex flex-col">
                            <span class="text-sm text-gray-500">Año de explotación {{ $pago->anio_explotacion }}</span>
                            <span class="text-sm text-gray-500 fw-medium">Obligación ${{ number_format($pago->importe, 0, ',', '.') }}</span>
                        </span>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-6 text-sm text-gray-700">
                    <div>
                        <p class="text-gray-500">Pagado</p>
                        <p class="text-green-500">${{ number_format($totalPagado, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Pendiente</p>
                        <p class="text-red-500">${{ number_format($pago->importe - $totalPagado, 0, ',', '.') }}</p>
                    </div>
                </div>

                <span>

                    @if ($registrarAbono == 1)
                    <button
                        class="px-4 py-2 text-white bg-sky-600 hover:bg-sky-700 rounded text-sm transition"
                        data-bs-toggle="modal" data-bs-target="#modalAbono">
                        Nuevo abono
                    </button>
                    @else
                    <div class="px-3 py-2 bg-green-100 border border-green-400 text-green-700 flex items-center gap-2 text-sm font-semibold rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                        <span class="flex flex-col">
                            <span>Pago completo</span>
                            <span class="text-sm text-green-600 text-[10px]">No se pueden registrar más abonos</span>
                        </span>
                    </div>
                    @endif


                </span>
            </div>



            <!-- Tabla de detalles -->
            <div class="mt-10 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 bg-white text-sm text-center" id="data-table-detalles-pago">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-600 font-semibold text-center">
                        <tr>
                            <th class="px-4 py-3 text-center">Año de Abono</th>
                            <th class="px-4 py-3 text-center">Abono</th>
                            <th class="px-4 py-3 text-center">Tasa Admin</th>
                            <th class="px-4 py-3 text-center">Tasa Bienestar</th>
                            <th class="px-4 py-3 text-center">Factura</th>
                            <th class="px-4 py-3 text-center">Comentarios</th>
                            <th class="px-4 py-3 text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-center text-gray-700">
                        @foreach ($detallesPago as $detallePago)
                        @php
                        $rutaArchivo = 'facturas/' . $detallePago->factura;
                        $urlDescarga = asset(Storage::url($rutaArchivo));
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-center">{{ $detallePago->anio }}</td>
                            <td class="px-4 py-2 text-center">${{ number_format($detallePago->importe, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format($detallePago->tasa_tipo1, 0, ',', '.') }}% -
                                ${{ number_format($detallePago->tasa_administracion, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ number_format($detallePago->tasa_tipo2, 0, ',', '.') }}% -
                                ${{ number_format($detallePago->tasa_bienestar, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ $urlDescarga }}" target="_blank" class="text-sky-600 hover:underline">Ver factura</a>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <a href="#"
                                    class="text-sky-600 hover:underline"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalComentarioAbono"
                                    data-abonoid="{{ $detallePago->id }}">
                                    Comentar
                                </a>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <div class="dropdown-center flex items-center justify-center">
                                    <a href="#" class="text-dark text-decoration-none" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        </svg>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item text-sm" href="#" data-bs-toggle="modal" data-bs-target="#modalEditarAbono">Editar</a></li>
                                        <li><a class="dropdown-item text-danger" href="#">Eliminar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>
    </section>

    <!-- Modal Nuevo Abono -->
    <div class="modal fade" id="modalAbono" tabindex="-1" aria-labelledby="modalAbonoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header px-5 py-4">
                    <h5 class="text-lg font-semibold" id="modalAbonoLabel">Nuevo abono</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body px-5">
                    <form action="/abonos/nuevo" method="POST" enctype="multipart/form-data" id="form_nuevo_abono" class="space-y-4">
                        @csrf
                        <input type="hidden" name="InputPagoUsuarioId" value="{{ $pago->id }}">

                        <div>
                            <label for="inputAnioPago" class="block text-sm font-medium text-gray-700">Año de abono</label>
                            <select
                                id="inputAnioPago"
                                name="inputAnioPago"
                                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="" selected>Seleccione un año y tasa</option>
                                @foreach ($tasas as $anio => $tasaPorAnio)
                                @php
                                $adminTasa = $tasaPorAnio->where('tipo', 1)->first();
                                $bienestarTasa = $tasaPorAnio->where('tipo', 2)->first();
                                @endphp
                                <option value="{{ $adminTasa->id }}">
                                    {{ $anio }} - ADM - {{ number_format($adminTasa->tasa, 0) ?? '' }} % - BNS - {{ $bienestarTasa->tasa ?? '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="inputImporte" class="block text-sm font-medium text-gray-700">Importe</label>
                            <input
                                type="number"
                                id="inputImporte"
                                name="inputImporte"
                                placeholder="Ingresa valor de importe"
                                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="inputFactura" class="block text-sm font-medium text-gray-700">Factura</label>
                            <input
                                type="file"
                                id="inputFactura"
                                name="inputFactura"
                                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="modal-footer mt-4 flex justify-end gap-2">
                            <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Comentarios-->
    <div class="modal fade" id="modalComentarioAbono" tabindex="-1" aria-labelledby="modalComentarioLabel" aria-hidden="true" data-abonoid="">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content max-h-[80vh] flex flex-col">
                <div class="modal-header px-5 py-4">
                    <h2 class="text-lg font-semibold" id="modalComentarioLabel">Comentarios del pago</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div id="loaderComentarios" class="flex justify-center items-center py-6">
                    <svg class="animate-spin h-8 w-8 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </div>
                <div id="comentariosContainer" class="px-5 space-y-4 overflow-y-auto flex-1 py-3 opacity-0 transition-opacity duration-500">
                    <!-- Comentarios aquí -->
                </div>
                <!-- Formulario fijo abajo -->
                <div class="border-t px-5 py-4 bg-white">
                    <form>
                        <div>
                            <label for="inputComentario" class="block text-sm font-medium text-gray-700 mb-1">Nuevo comentario</label>
                            <textarea
                                id="inputComentario"
                                rows="2"
                                placeholder="Escribe tu comentario aquí"
                                class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                        </div>
                        <div class="mt-3 flex justify-end gap-2">
                            <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" id="btnComentar" class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">Comentar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @if(count($detallesPago) > 0)
    <!-- Modal Editar Abono -->
    <div class="modal fade" id="modalEditarAbono" tabindex="-1" aria-labelledby="modalEditarAbonoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header px-5 py-4">
                    <h5 class="text-lg font-semibold" id="modalEditarAbonoLabel">Editar abono</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body px-5">
                    <form method="POST" enctype="multipart/form-data" id="form_editar_abono" class="space-y-4">
                        @csrf
                        @method('PUT') <!-- Para indicar que es una actualización -->

                        <input type="hidden" name="InputAbonoId" id="editarAbonoId">

                        <div>
                            <label for="editarAnioPago" class="block text-sm font-medium text-gray-700">Año de abono</label>
                            <select
                                id="editarAnioPago"
                                name="inputAnioPago"
                                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="" selected>Seleccione un año y tasa</option>
                                @foreach ($tasas as $anio => $tasaPorAnio)
                                @php
                                $adminTasa = $tasaPorAnio->where('tipo', 1)->first();
                                $bienestarTasa = $tasaPorAnio->where('tipo', 2)->first();
                                @endphp
                                <option value="{{ $adminTasa->id }}">
                                    {{ $anio }} - ADM - {{ number_format($adminTasa->tasa, 0) ?? '' }} % - BNS - {{ $bienestarTasa->tasa ?? '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="editarImporte" class="block text-sm font-medium text-gray-700">Importe</label>
                            <input
                                type="number"
                                id="editarImporte"
                                name="inputImporte"
                                placeholder="Ingresa valor de importe"
                                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="editarFactura" class="block text-sm font-medium text-gray-700">Factura</label>
                            <input
                                type="file"
                                id="editarFactura"
                                name="inputFactura"
                                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <small id="facturaActual" class="text-xs text-gray-500"></small>
                        </div>

                        <div class="modal-footer mt-4 flex justify-end gap-2">
                            <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endif

    @push('scripts')
    <script>
        new DataTable('#data-table-detalles-pago', {
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
            lengthChange: false,
        });

        $(document).ready(function() {
            $('#form_nuevo_abono').validate({
                rules: {
                    inputAnioPago: {
                        required: true
                    },
                    inputImporte: {
                        required: true,
                        number: true
                    },
                    inputFactura: {
                        required: "Por favor, sube la factura",
                        extension: "Solo se permiten archivos PDF o imágenes (jpg, png)"
                    }
                },
                messages: {
                    inputAnioPago: {
                        required: "Por favor seleccione un año"
                    },
                    inputImporte: {
                        required: "Por favor ingrese un importe válido",
                        number: "Solo números"
                    },
                    inputFactura: {
                        required: "Por favor, sube la factura",
                        extension: "Solo se permiten archivos PDF o imágenes (jpg, png)"
                    }
                }
            });
        });


        let abonoIdSeleccionado = null;

        function cargarComentarios(abonoId) {
            const container = $('#comentariosContainer');
            const loader = $('#loaderComentarios');

            container.empty().removeClass('opacity-100').addClass('opacity-0');
            loader.removeClass('hidden');

            $.get('/comentariosabonos/' + abonoId, function(data) {
                loader.addClass('hidden');

                if (data.length === 0) {
                    container.append('<p class="text-gray-500">No hay comentarios aún.</p>');
                } else {
                    data.forEach(comentario => {
                        const fecha = new Date(comentario.created_at);
                        const fechaFormateada = fecha.toLocaleDateString() + ' ' + fecha.toLocaleTimeString();

                        const comentarioHtml = `
                        <div class="bg-gray-100 p-3 rounded mb-3 transition-opacity duration-500 ease-in-out opacity-0 transform translate-y-2">
                            <p class="text-sm text-gray-800">${comentario.comentario}</p>
                            <div class="text-xs text-gray-500 mt-1">${comentario.usuario.name} - ${fechaFormateada}</div>
                        </div>
                    `;
                        container.append(comentarioHtml);
                    });

                    container.children().each(function(index, el) {
                        setTimeout(() => {
                            $(el).removeClass('opacity-0 translate-y-2').addClass('opacity-100 translate-y-0');
                        }, index * 100);
                    });
                }

                container.removeClass('opacity-0').addClass('opacity-100');
            });
        }

        // Configurar token CSRF para peticiones AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Al abrir el modal, capturar el ID y cargar comentarios
        $('#modalComentarioAbono').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget); // botón que abrió el modal
            const abonoId = button.data('abonoid');
            const modal = $(this);

            abonoIdSeleccionado = abonoId;
            modal.attr('data-abonoid', abonoId);

            cargarComentarios(abonoId);
        });

        // Limpiar comentarios al cerrar el modal
        $('#modalComentarioAbono').on('hidden.bs.modal', function() {
            $('#comentariosContainer').empty();
            $('#loaderComentarios').addClass('hidden');
            $('#inputComentario').val('');
        });

        // Al enviar comentario
        $('#btnComentar').on('click', function() {
            const comentario = $('#inputComentario').val().trim();

            if (!comentario) {
                alert('Por favor escribe un comentario.');
                return;
            }

            $(this).prop('disabled', true).text('Enviando...');

            $.post('/comentariosabonos', {
                abono_id: abonoIdSeleccionado,
                comentario: comentario
            }).done(function(respuesta) {
                $('#inputComentario').val('');
                cargarComentarios(abonoIdSeleccionado);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error AJAX:', textStatus, errorThrown);
                console.error('Respuesta del servidor:', jqXHR.responseText);
                alert('Error al enviar el comentario. Intenta de nuevo.');
            }).always(() => {
                $('#btnComentar').prop('disabled', false).text('Comentar');
            });
        });
    </script>
    @endpush
</x-app-layout>