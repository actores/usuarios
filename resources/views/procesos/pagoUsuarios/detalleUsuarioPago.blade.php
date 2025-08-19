<x-app-layout>
    <section class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ modalComentarioAbono: false }">
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
                    <div x-data="">
                        <!-- Botón para abrir modal -->
                        <button
                            @click="$dispatch('abrir-modal-abono')"
                            class="px-4 py-2 text-white bg-sky-600 hover:bg-sky-700 rounded text-sm transition">
                            Nuevo abono
                        </button>

                    </div>
                    @else
                    <div
                        role="alert"
                        aria-live="polite"
                        class="px-4 py-3 bg-green-50 border border-green-400 text-green-800 flex items-center gap-3 text-sm font-semibold rounded-lg shadow-sm">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 flex-shrink-0 text-green-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                            aria-hidden="true">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                        </svg>
                        <div class="flex flex-col leading-tight">
                            <span class="text-base">Pago completo</span>
                            <span class="text-[10px] text-green-600 font-normal mt-0.5">
                                No se pueden registrar más abonos
                            </span>
                        </div>
                    </div>

                    @endif
                </span>


            </div>



            <!-- Tabla de detalles -->
            <div class="mt-10">
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
                        @forelse ($detallesPago as $detallePago)
                        @php
                        $rutaArchivo = 'facturas/' . $detallePago->factura;
                        $urlDescarga = asset(Storage::url($rutaArchivo));
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $detallePago->anio }}</td>
                            <td class="px-4 py-2">${{ number_format($detallePago->importe, 2, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                {{ number_format($detallePago->tasa_tipo1, 0, ',', '.') }}% -
                                ${{ number_format($detallePago->tasa_administracion, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-2">
                                {{ number_format($detallePago->tasa_tipo2, 2, ',', '.') }}% -
                                ${{ number_format($detallePago->tasa_bienestar, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ $urlDescarga }}" target="_blank" class="text-sky-600 hover:underline">Ver factura</a>
                            </td>
                            <td class="px-4 py-2">
                                <a href="#"
                                    class="text-sky-600 hover:underline comentario-abono-btn"
                                    data-abono-id="{{ $detallePago->id }}"
                                    @click.prevent="modalComentarioAbono = true">
                                    Comentar
                                </a>
                            </td>
                            <td class="px-4 py-2 relative overflow-visible">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button @click="open = !open"
                                        class="flex items-center justify-center text-gray-500 hover:text-black focus:outline-none opacity-70 hover:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        </svg>
                                    </button>

                                    <div x-show="open" x-cloak @click.outside="open = false"
                                        class="absolute right-0 z-10 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg">

                                        <ul class="py-1 text-sm text-gray-700">
                                            <li>
                                                <a href="{{ route('abonos.editar', $detallePago->id) }}"
                                                    class="block px-4 py-2 text-sky-600 hover:bg-gray-100 hover:underline">
                                                    Editar
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('abonos.destroy', $detallePago->id) }}" method="POST" class="form-eliminar">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="py-12">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.75 17l-4.75-4.75m0 0L9.75 7.5m-4.75 4.75h14.5" />
                                    </svg>
                                    <p class="text-lg font-semibold">No hay abonos registrados</p>
                                    <p class="text-sm text-gray-400 mt-1">Cuando registres abonos, aparecerán aquí.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>

        <!-- Modal Nuevo Abono -->
        <div x-data="{
        abierto: false,
        cerrarModal() {
            this.abierto = false;
            // Eliminar mensajes de error
            document.querySelectorAll('.error-front').forEach(el => el.remove());
            // Resetear formulario
            document.getElementById('form_nuevo_abono')?.reset();
        }
    }"
            x-show="abierto"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            @abrir-modal-abono.window="abierto = true"
            @keydown.escape.window="cerrarModal()"
            style="display: none;">
            <div
                class="bg-white rounded-lg shadow-lg w-full max-w-lg mx-4"
                @click.away="cerrarModal()">
                <!-- Encabezado -->
                <div class="flex justify-between items-center px-5 py-4 border-b">
                    <h5 class="text-lg font-semibold">Nuevo abono</h5>
                    <button
                        @click="cerrarModal()"
                        class="text-gray-500 hover:text-gray-700"
                        aria-label="Cerrar modal">
                        ✕
                    </button>
                </div>

                <!-- Cuerpo -->
                <div class="px-5 py-4">
                    <form action="/abonos/nuevo" method="POST" enctype="multipart/form-data" id="form_nuevo_abono" class="space-y-4">
                        @csrf
                        <input type="hidden" name="InputPagoUsuarioId" value="{{ $pago->id }}">

                        <!-- Año -->
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

                        <!-- Importe -->
                        <div>
                            <label for="inputImporte" class="block text-sm font-medium text-gray-700">Importe</label>
                            <input
                                type="number"
                                id="inputImporte"
                                name="inputImporte"
                                placeholder="Ingresa valor de importe"
                                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01"
                                    min="0">
                        </div>

                        <!-- Factura -->
                        <div>
                            <label for="inputFactura" class="block text-sm font-medium text-gray-700">Factura</label>
                            <input
                                type="file"
                                id="inputFactura"
                                name="inputFactura"
                                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Footer -->
                        <div class="flex justify-end gap-2 pt-4 border-t">
                            <button
                                type="button"
                                @click="cerrarModal()"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                                Cerrar
                            </button>
                            <button
                                type="submit"
                                class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- Modal Comentarios Abono -->
        <div x-show="modalComentarioAbono" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="modalComentarioAbono = false"
                class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[80vh] flex flex-col">

                <!-- Header -->
                <div class="flex justify-between items-center px-5 py-4 border-b">
                    <h2 class="text-lg font-semibold" id="modalComentarioLabel">Comentarios del abono</h2>
                    <button @click="modalComentarioAbono = false"
                        class="text-gray-500 hover:text-gray-700 text-2xl leading-none" aria-label="Cerrar">
                        &times;
                    </button>
                </div>

                <!-- Loader -->
                <div id="loaderComentariosAbono" class="flex justify-center items-center py-6 hidden">
                    <svg class="animate-spin h-8 w-8 text-sky-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </div>

                <!-- Contenedor de comentarios -->
                <div id="comentariosContainerAbono"
                    class="px-5 space-y-4 overflow-y-auto flex-1 py-3 opacity-0 transition-opacity duration-500">
                    <!-- Comentarios se insertan aquí vía JS -->
                </div>

                <!-- Formulario fijo abajo -->
                <div class="border-t px-5 py-4 bg-white">
                    <form id="formComentarioAbono">
                        <!-- Este hidden es donde el JS guarda el abonoId -->
                        <input type="hidden" id="abonoId" name="abono_id">

                        <div>
                            <label for="inputComentarioAbono"
                                class="block text-sm font-medium text-gray-700 mb-1">Nuevo comentario</label>
                            <textarea id="inputComentarioAbono" name="comentario" rows="2"
                                placeholder="Escribe tu comentario aquí"
                                class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                                required></textarea>
                        </div>

                        <div class="mt-3 flex justify-end gap-2">
                            <button type="button"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
                                @click="modalComentarioAbono = false">
                                Cerrar
                            </button>
                            <button type="submit" id="btnComentarAbono"
                                class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">
                                Comentar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>









    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('form_nuevo_abono');
            if (!form) return;

            // Validación simple con mensajes rojos
            form.addEventListener('submit', (e) => {
                const campos = [{
                        id: 'inputAnioPago',
                        mensaje: 'Por favor seleccione un año.'
                    },
                    {
                        id: 'inputImporte',
                        mensaje: 'Por favor ingrese un importe válido.'
                    },
                    {
                        id: 'inputFactura',
                        mensaje: 'Debe adjuntar la factura.'
                    }
                ];

                let valido = true;
                document.querySelectorAll('.error-front').forEach(el => el.remove());

                campos.forEach(({
                    id,
                    mensaje
                }) => {
                    const input = document.getElementById(id);
                    if (!input) return;

                    if (id === 'inputImporte') {
                        if (!input.value.trim() || isNaN(input.value)) {
                            mostrarError(input, mensaje);
                            valido = false;
                        }
                    } else if (id === 'inputFactura') {
                        const file = input.files[0];
                        if (!file) {
                            mostrarError(input, mensaje);
                            valido = false;
                        } else {
                            const ext = file.name.split('.').pop().toLowerCase();
                            if (!['pdf', 'jpg', 'png'].includes(ext)) {
                                mostrarError(input, 'Solo se permiten archivos PDF, JPG o PNG.');
                                valido = false;
                            }
                        }
                    } else {
                        if (!input.value.trim()) {
                            mostrarError(input, mensaje);
                            valido = false;
                        }
                    }
                });

                if (!valido) e.preventDefault();
            });

            function mostrarError(input, mensaje) {
                const error = document.createElement('p');
                error.classList.add('text-red-600', 'text-sm', 'mt-1', 'error-front');
                error.innerText = mensaje;
                input.insertAdjacentElement('afterend', error);
            }

            // --- Aquí está la clave: limpiar errores y resetear formulario al cerrar el modal ---

            // Cambia #modalNuevoAbono por el id real de tu modal
            const modal = document.getElementById('modalNuevoAbono');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', () => {
                    // Eliminar mensajes de error
                    document.querySelectorAll('.error-front').forEach(el => el.remove());
                    // Resetear formulario
                    form.reset();
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            inicializarBotonesComentarioAbono();
            inicializarFormularioComentarioAbono();
             activarConfirmacionEliminar();

            function inicializarBotonesComentarioAbono() {
                document.body.addEventListener('click', function(event) {
                    const target = event.target.closest('.comentario-abono-btn');
                    if (!target) return;

                    const abonoId = target.getAttribute('data-abono-id');
                    const inputHidden = document.getElementById('abonoId');
                    if (inputHidden) inputHidden.value = abonoId;

                    cargarComentariosAbono(abonoId);
                });
            }

            function inicializarFormularioComentarioAbono() {
                const form = document.getElementById('formComentarioAbono');
                if (!form) return;

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const abonoId = document.getElementById('abonoId')?.value;
                    const comentario = document.getElementById('inputComentarioAbono').value.trim();

                    // Validación
                    document.querySelectorAll('.error-front').forEach(el => el.remove());
                    let valido = true;

                    if (!abonoId) {
                        mostrarError('inputComentarioAbono', 'No se encontró un abono válido.');
                        valido = false;
                    }
                    if (!comentario) {
                        mostrarError('inputComentarioAbono', 'El comentario no puede estar vacío.');
                        valido = false;
                    }
                    if (!valido) return;

                    fetch(`/comentariosabonos`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                abono_id: abonoId,
                                comentario: comentario
                            })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Error al enviar el comentario.');
                            return response.json();
                        })
                        .then(() => {
                            document.getElementById('inputComentarioAbono').value = '';
                            cargarComentariosAbono(abonoId);
                        })
                        .catch(error => {
                            console.error('Error al comentar:', error);
                        });
                });
            }

            function mostrarError(inputId, mensaje) {
                const input = document.getElementById(inputId);
                if (!input) return;
                const error = document.createElement('p');
                error.classList.add('text-red-600', 'text-sm', 'mt-1', 'error-front');
                error.innerText = mensaje;
                input.insertAdjacentElement('afterend', error);
            }

            function cargarComentariosAbono(abonoId) {
                const loader = document.getElementById('loaderComentariosAbono');
                const container = document.getElementById('comentariosContainerAbono');

                loader.classList.remove('hidden');
                container.classList.add('opacity-0');
                container.innerHTML = '<p class="text-sm text-gray-400">Cargando comentarios...</p>';

                fetch(`/comentariosabonos/${abonoId}`)
                    .then(response => response.json())
                    .then(data => {
                        loader.classList.add('hidden');
                        container.classList.remove('opacity-0');
                        container.innerHTML = '';

                        if (!data.length) {
                            container.innerHTML = `
                        <div class="text-center text-gray-500 py-4">
                            No hay comentarios registrados para este abono.
                        </div>`;
                            return;
                        }

                        data.forEach(comentario => {
                            const div = document.createElement('div');
                            div.className = 'bg-white border border-gray-200 rounded-xl p-4 shadow-sm space-y-2 mb-3';
                            div.innerHTML = `
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    ${comentario.usuario?.name || 'Usuario'}
                                </p>
                                <p class="text-sm text-gray-700 mt-1 whitespace-pre-line">
                                    ${comentario.comentario}
                                </p>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap ml-4">
                                ${new Date(comentario.created_at).toLocaleString()}
                            </span>
                        </div>`;
                            container.appendChild(div);
                        });
                    })
                    .catch(error => {
                        console.error('Error cargando comentarios:', error);
                        loader.classList.add('hidden');
                        container.classList.remove('opacity-0');
                        container.innerHTML =
                            '<p class="text-red-500">Error al cargar los comentarios. Intente nuevamente.</p>';
                    });
            }

            function activarConfirmacionEliminar() {
                const formularios = document.querySelectorAll('.form-eliminar');

                formularios.forEach(formulario => {
                    formulario.addEventListener('submit', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: 'Esta acción no se puede deshacer',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                formulario.submit();
                            }
                        });
                    });
                });
            }
        });
    </script>


    @endsection
</x-app-layout>