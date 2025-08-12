<x-app-layout>
    <section class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ modalPago: false, modalComentarioPago: false, modalEditarUsuario: false }">
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
                    <li><a href="{{ url('/dashboard') }}" class="text-sky-600 hover:underline">Inicio</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ url('/usuarios') }}" class="text-sky-600 hover:underline">Usuarios</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-800">{{ $usuario->nombre }}</li>
                </ol>
            </nav>

            <!-- Perfil -->
            <div class="bg-white shadow rounded-lg p-6 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div
                        class="w-16 h-16 bg-sky-600 text-white rounded-full flex items-center justify-center font-bold text-lg uppercase">
                        {{ substr($usuario->nombre, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $usuario->nombre }}</h2>
                        <p class="text-sm text-gray-500">{{ $usuario->razonSocial }} / {{ $usuario->nit }}</p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-6 text-sm text-gray-700">
                    <div>
                        <p class="text-gray-500">Tipo</p>
                        <p>{{ $usuario->tipo_usuario }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Dirección</p>
                        <p>{{ $usuario->direccion }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Ciudad</p>
                        <p>{{ $usuario->ciudad }}</p>
                    </div>
                </div>

                <span>
                    <button type="button" @click="$dispatch('abrir-editar-usuario')"
                        class="px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded text-sm">
                        Editar usuario
                    </button>
                    <button class="px-4 py-2 text-white bg-sky-600 hover:bg-sky-700 rounded text-sm"
                        @click="$dispatch('abrir-modal-pago')">
                        Nuevo pago
                    </button>
                </span>
            </div>

            <!-- Tabla de pagos -->
            <div class="mt-8">
                <table class="min-w-full divide-y divide-gray-200 bg-white text-sm text-center"
                    id="data-table-usuarios-pagos-detalle">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-600 font-semibold text-center">
                        <tr>
                            <th class="px-4 py-3 text-center">Año Explotación</th>
                            <th class="px-4 py-3 text-center">Importe</th>
                            <th class="px-4 py-3 text-center">Factura</th>
                            <th class="px-4 py-3 text-center">Total Abonos</th>
                            <th class="px-4 py-3 text-center">Porcentaje</th>
                            <th class="px-4 py-3 text-center">Estado Pago</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                            <th class="px-4 py-3 text-center">Comentarios</th>
                            <th class="px-4 py-3 text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-center text-gray-700">
                        @forelse ($pagos as $pago)
                            @php
                                $rutaArchivo = 'facturas/' . $pago->factura;
                                $urlDescarga = asset(Storage::url($rutaArchivo));

                                $porcentaje = number_format($pago->porcentaje_pago, 0);
                                if ($porcentaje <= 25) {
                                    $color = 'bg-red-500';
                                } elseif ($porcentaje <= 50) {
                                    $color = 'bg-orange-500';
                                } elseif ($porcentaje <= 75) {
                                    $color = 'bg-yellow-400';
                                } else {
                                    $color = 'bg-green-500';
                                }

                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-center">{{ $pago->anio_explotacion }}</td>
                                <td class="px-4 py-2 text-center">${{ number_format($pago->importe, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="{{ $urlDescarga }}" class="text-sky-600 hover:underline"
                                        target="_blank">Ver factura</a>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    ${{ number_format($pago->total_abonos, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-center">
                                    <div x-data="{ ancho: 0, preferWhite: {{ $preferWhite ? 'true' : 'false' }} }" x-init="setTimeout(() => ancho = {{ $porcentaje }}, 200)"
                                        class="w-full bg-gray-200 rounded-full h-6 relative overflow-hidden">

                                        <!-- barra coloreada (fondo dinámico) -->
                                        <div class="absolute left-0 top-0 h-full rounded-full transition-all duration-1000 ease-out {{ $color }}"
                                            :style="'width: ' + ancho + '%'"></div>

                                        <!-- número centrado como overlay, cambia color según ancho y preferWhite -->
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none text-sm font-bold transition-colors duration-200"
                                            :class="(ancho >= 12 && preferWhite) ? 'text-white' : 'text-gray-800'">
                                            {{ $porcentaje }}%
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-2 text-center">{{ $pago->estadoPago }}</td>
                                <td class="px-4 py-2 text-center">
                                    <a href="/pagos/detalle/abonos/{{ $usuario->id }}/{{ $pago->id }}"
                                        class="text-sky-600 hover:underline">Ver abonos</a>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <a href="#" class="text-sky-600 hover:underline comentario-btn"
                                        @click="modalComentarioPago = true" data-pago-id="{{ $pago->id }}">
                                        Comentar
                                    </a>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                        <!-- Botón de tres puntos -->
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

                                        <!-- Menú desplegable -->
                                        <div x-show="open" @click.away="open = false"
                                            class="absolute right-0 z-10 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg">
                                            <ul class="py-1 text-sm text-gray-700">
                                                <li>
                                                    <a href="{{ route('exportar.pago', $pago->id) }}"
                                                        class="block px-4 py-2 hover:bg-gray-100">
                                                        Exportar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('pagos.editar', $pago->id) }}"
                                                        class="block px-4 py-2 text-sky-600 hover:bg-gray-100 hover:underline">
                                                        Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('pagos.destroy', $pago->id) }}"
                                                        method="POST" class="form-eliminar">
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
                                        <p class="text-lg font-semibold">No hay pagos registrados</p>
                                        <p class="text-sm text-gray-400 mt-1">Cuando registres pagos, aparecerán aquí.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Modal Nuevo Pago-->
            <div x-data="formPago" x-on:abrir-modal-pago.window="modalPago = true" x-show="modalPago" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div @click.away="cerrar()" class="bg-white rounded-lg shadow-lg max-w-lg w-full">
                    <!-- Header -->
                    <div class="flex justify-between items-center px-6 py-4 border-b">
                        <h2 class="text-lg font-semibold">Nuevo pago</h2>
                        <button @click="cerrar()" class="text-gray-500 hover:text-gray-700">&times;</button>
                    </div>

                    <!-- Body -->
                    <div class="px-6 py-4">
                        <form action="{{ route('pagos.nuevo') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-4" id="form_nuevo_pago">
                            @csrf
                            <input type="hidden" name="InputUsuarioId" value="{{ $usuario->id }}">

                            <div>
                                <label for="inputAnioExplotacion" class="block text-sm font-medium text-gray-700">
                                    Año explotación
                                </label>
                                <input type="number" name="inputAnioExplotacion" id="inputAnioExplotacion"
                                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
                                    placeholder="Ingresa el año de explotación">
                            </div>

                            <div>
                                <label for="inputImporte" class="block text-sm font-medium text-gray-700">
                                    Importe
                                </label>
                                <input type="number" name="inputImporte" id="inputImporte"
                                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
                                    placeholder="Ingresa valor de importe">
                            </div>

                            <div>
                                <label for="inputFactura" class="block text-sm font-medium text-gray-700">
                                    Factura
                                </label>
                                <input type="file" name="inputFactura" id="inputFactura"
                                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                            </div>

                            <!-- Footer -->
                            <div class="flex justify-end gap-2 pt-4 border-t">
                                <button type="button"
                                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
                                    @click="cerrar()">
                                    Cerrar
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Modal Comentarios-->
            <div x-show="modalComentarioPago" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div @click.away="modalComentarioPago = false"
                    class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[80vh] flex flex-col">
                    <!-- Header -->
                    <div class="flex justify-between items-center px-5 py-4 border-b">
                        <h2 class="text-lg font-semibold">Comentarios del pago</h2>
                        <button @click="modalComentarioPago = false"
                            class="text-gray-500 hover:text-gray-700 text-2xl leading-none" aria-label="Cerrar">
                            &times;
                        </button>
                    </div>

                    <!-- Loader -->
                    <div id="loaderComentarios" class="flex justify-center items-center py-6">
                        <svg class="animate-spin h-8 w-8 text-sky-600" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </div>

                    <!-- Comentarios -->
                    <div id="comentariosModalBody"
                        class="px-5 space-y-4 overflow-y-auto flex-1 py-3 opacity-0 transition-opacity duration-500">
                        <!-- Aquí se cargarán los comentarios dinámicamente -->
                    </div>

                    <!-- Formulario fijo abajo -->
                    <div class="border-t px-5 py-4 bg-white">
                        <form id="formComentario">
                            <input type="hidden" name="pagoUsuario_id" id="pagoUsuarioId">
                            <div>
                                <label for="inputComentario"
                                    class="block text-sm font-medium text-gray-700 mb-1">Nuevo comentario</label>
                                <textarea id="inputComentario" name="comentario" rows="2" placeholder="Escribe tu comentario aquí"
                                    class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                                    required></textarea>
                            </div>
                            <div class="mt-3 flex justify-end gap-2">
                                <button type="button"
                                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
                                    @click="modalComentarioPago = false">
                                    Cerrar
                                </button>
                                <button type="submit" id="btnComentar"
                                    class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">
                                    Comentar
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Modal Editar Usuario -->
            <div x-data="formEditarUsuario" x-on:abrir-editar-usuario.window="modalEditarUsuario = true"
                x-show="modalEditarUsuario" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div @click.away="cerrar()" class="bg-white rounded-lg shadow-lg w-full max-w-md">
                    <!-- Header -->
                    <div class="flex justify-between items-center px-5 py-4 border-b">
                        <h2 class="text-lg font-semibold">Actualizar Usuario</h2>
                        <button @click="cerrar()" class="text-gray-500 hover:text-gray-700 text-2xl leading-none"
                            aria-label="Cerrar">&times;</button>
                    </div>

                    <!-- Body -->
                    <div class="px-5 py-4">
                        <form action="{{ route('usuarios.actualizar', $usuario->id) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-4" id="form_editar_usuario">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="inputNombreEditar"
                                    class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" name="inputNombre" id="inputNombreEditar"
                                    placeholder="Ingresa nombre completo"
                                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
                                    value="{{ $usuario->nombre }}">
                            </div>

                            <div>
                                <label for="inputRazonSocialEditar" class="block text-sm font-medium text-gray-700">
                                    Razón Social
                                </label>
                                <input type="text" name="inputRazonSocial" id="inputRazonSocialEditar"
                                    placeholder="Ingresa razón social"
                                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
                                    value="{{ $usuario->razonSocial }}">
                            </div>

                            <div>
                                <label for="inputTipoUsuarioEditar" class="block text-sm font-medium text-gray-700">
                                    Tipo de usuario
                                </label>
                                <select name="inputTipoUsuario" id="inputTipoUsuarioEditar"
                                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                                    <option value="" {{ empty($usuario->tipo_usuario) ? 'selected' : '' }}>
                                        Seleccione un tipo
                                    </option>
                                    @foreach ($tiposUsuario as $tipoUsuario)
                                        <option value="{{ $tipoUsuario->id }}"
                                            {{ $usuario->tipo_usuario === $tipoUsuario->nombre ? 'selected' : '' }}>
                                            {{ $tipoUsuario->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="inputNitEditar"
                                    class="block text-sm font-medium text-gray-700">Nit</label>
                                <input type="number" name="inputNit" id="inputNitEditar"
                                    placeholder="Ingresa número de nit"
                                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
                                    value="{{ $usuario->nit }}">
                            </div>

                            <div>
                                <label for="inputDireccionEditar"
                                    class="block text-sm font-medium text-gray-700">Dirección</label>
                                <input type="text" name="inputDireccion" id="inputDireccionEditar"
                                    placeholder="Ingresa dirección completa"
                                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
                                    value="{{ $usuario->direccion }}">
                            </div>

                            <div>
                                <label for="inputCiudadEditar"
                                    class="block text-sm font-medium text-gray-700">Ciudad</label>
                                <input type="text" name="inputCiudad" id="inputCiudadEditar"
                                    placeholder="Ingresa ciudad"
                                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"
                                    value="{{ $usuario->ciudad }}">
                            </div>

                            <!-- Footer -->
                            <div class="flex justify-end gap-2 pt-4 border-t mt-4">
                                <button type="button" @click="cerrar()"
                                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                                    Cerrar
                                </button>
                                <button type="submit"
                                    class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded">
                                    Actualizar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>






        </div>
    </section>

    @section('scripts')
        <script>
            // Validaciones formulario neuvo pago 
            document.addEventListener('alpine:init', () => {
                Alpine.data('formPago', () => ({
                    modalPago: false,
                    cerrar() {
                        this.modalPago = false;
                        this.limpiarFormulario();
                        this.limpiarErrores();
                    },
                    limpiarFormulario() {
                        const form = document.getElementById('form_nuevo_pago');
                        if (form) form.reset();
                    },
                    limpiarErrores() {
                        document.querySelectorAll('.error-front').forEach(el => el.remove());
                        document.querySelectorAll('.error-laravel').forEach(el => el.remove());
                    }
                }));
            });

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('form_nuevo_pago');
                if (!form) return;

                form.addEventListener('submit', function(e) {
                    const campos = [{
                            id: 'inputAnioExplotacion',
                            mensaje: 'El año de explotación es obligatorio.'
                        },
                        {
                            id: 'inputImporte',
                            mensaje: 'El importe es obligatorio.'
                        },
                        {
                            id: 'inputFactura',
                            mensaje: 'Debe adjuntar la factura.'
                        }
                    ];

                    let valido = true;

                    // Quitar errores previos
                    document.querySelectorAll('.error-front').forEach(el => el.remove());

                    campos.forEach(campo => {
                        const input = document.getElementById(campo.id);
                        if (!input || !input.value.trim()) {
                            valido = false;

                            const error = document.createElement('p');
                            error.classList.add('text-red-600', 'text-sm', 'mt-1', 'error-front');
                            error.innerText = campo.mensaje;

                            input.insertAdjacentElement('afterend', error);
                        }
                    });

                    if (!valido) e.preventDefault();
                });
            });


            // Validaciones formulario editar usuario

            document.addEventListener('alpine:init', () => {
                Alpine.data('formEditarUsuario', () => ({
                    modalEditarUsuario: false,
                    cerrar() {
                        this.modalEditarUsuario = false;
                        this.limpiarFormulario();
                        this.limpiarErrores();
                    },
                    limpiarFormulario() {
                        const form = document.getElementById('form_editar_usuario');
                        if (form) form.reset();
                    },
                    limpiarErrores() {
                        document.querySelectorAll('.error-front').forEach(el => el.remove());
                        document.querySelectorAll('.error-laravel').forEach(el => el.remove());
                    }
                }));
            });

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('form_editar_usuario');
                if (!form) return;

                form.addEventListener('submit', function(e) {
                    const campos = [{
                            id: 'inputNombreEditar',
                            mensaje: 'El nombre es obligatorio.'
                        },
                        {
                            id: 'inputRazonSocialEditar',
                            mensaje: 'La razón social es obligatoria.'
                        },
                        {
                            id: 'inputTipoUsuarioEditar',
                            mensaje: 'Seleccione un tipo de usuario.'
                        },
                        {
                            id: 'inputNitEditar',
                            mensaje: 'El NIT es obligatorio.'
                        },
                        {
                            id: 'inputDireccionEditar',
                            mensaje: 'La dirección es obligatoria.'
                        },
                        {
                            id: 'inputCiudadEditar',
                            mensaje: 'La ciudad es obligatoria.'
                        }
                    ];

                    let valido = true;

                    document.querySelectorAll('.error-front').forEach(el => el.remove());

                    campos.forEach(campo => {
                        const input = document.getElementById(campo.id);
                        if (!input || !input.value.trim()) {
                            valido = false;

                            const error = document.createElement('p');
                            error.classList.add('text-red-600', 'text-sm', 'mt-1', 'error-front');
                            error.innerText = campo.mensaje;

                            input.insertAdjacentElement('afterend', error);
                        }
                    });

                    if (!valido) e.preventDefault();
                });
            });

            // Otras validaciones

            // document.addEventListener('alpine:init', () => {
            //     Alpine.data('formEditarUsuario', () => ({
            //         open: false,
            //         cerrar() {
            //             this.open = false;
            //             this.limpiarFormulario();
            //             this.limpiarErrores();
            //         },
            //         limpiarFormulario() {
            //             const form = document.getElementById('form_nuevo_usuario');
            //             if (form) form.reset();
            //         },
            //         limpiarErrores() {
            //             document.querySelectorAll('.error-front').forEach(el => el.remove());
            //             document.querySelectorAll('.error-laravel').forEach(el => el.remove());
            //         }
            //     }));

            //     Alpine.data('modalEditarUsuario', () => ({
            //         modalEditarUsuario: false,

            //         init() {
            //             this.$watch('modalEditarUsuario', (isOpen) => {
            //                 if (!isOpen) {
            //                     // Limpiar errores cuando se cierra el modal
            //                     this.limpiarErrores();
            //                     // Opcional: también puedes resetear el formulario si quieres
            //                     // document.getElementById('form_nuevo_usuario')?.reset();
            //                 }
            //             });
            //         },

            //         limpiarErrores() {
            //             document.querySelectorAll('.error-front').forEach(el => el.remove());
            //             document.querySelectorAll('.error-laravel').forEach(el => el.remove());
            //         }
            //     }));
            // });

            document.addEventListener('DOMContentLoaded', function() {

                // === VALIDACIÓN form_nuevo_usuario ===
                const form = document.getElementById('form_nuevo_usuario');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const campos = [{
                                id: 'inputNombre',
                                mensaje: 'El nombre es obligatorio.'
                            },
                            {
                                id: 'inputRazonSocial',
                                mensaje: 'La razón social es obligatoria.'
                            },
                            {
                                id: 'inputTipoUsuario',
                                mensaje: 'Seleccione un tipo de usuario.'
                            },
                            {
                                id: 'inputNit',
                                mensaje: 'El NIT es obligatorio.'
                            },
                            {
                                id: 'inputDireccion',
                                mensaje: 'La dirección es obligatoria.'
                            },
                            {
                                id: 'inputCiudad',
                                mensaje: 'La ciudad es obligatoria.'
                            },
                        ];

                        let valido = true;
                        document.querySelectorAll('.error-front').forEach(el => el.remove());

                        campos.forEach(campo => {
                            const input = document.getElementById(campo.id);
                            if (!input || !input.value.trim()) {
                                valido = false;

                                const error = document.createElement('p');
                                error.classList.add('text-red-600', 'text-sm', 'mt-1', 'error-front');
                                error.innerText = campo.mensaje;

                                input.insertAdjacentElement('afterend', error);
                            }
                        });

                        if (!valido) e.preventDefault();
                    });
                }

                // === INICIALIZA FUNCIONES PARA EL MODAL ===
                inicializarCerrarModal();
                inicializarBotonesComentario();
                inicializarFormularioComentario();
                activarConfirmacionEliminar();

                function inicializarCerrarModal() {
                    const cerrarModal = document.querySelector('.btn-cerrar-modal');
                    if (cerrarModal) {
                        cerrarModal.addEventListener('click', () => {
                            const hidden = document.getElementById('pagoUsuarioId');
                            if (hidden) hidden.value = '';
                        });
                    }
                }

                function inicializarBotonesComentario() {
                    document.body.addEventListener('click', function(event) {
                        const target = event.target.closest('.comentario-btn');
                        if (!target) return;

                        const pagoId = target.getAttribute('data-pago-id');
                        const inputHidden = document.getElementById('pagoUsuarioId');
                        if (inputHidden) inputHidden.value = pagoId;

                        cargarComentarios(pagoId);
                    });
                }

                function inicializarFormularioComentario() {
                    const form = document.getElementById('formComentario');
                    if (!form) return;

                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const pagoId = document.getElementById('pagoUsuarioId')?.value;
                        const comentario = document.getElementById('inputComentario').value.trim();

                        // Validación frontend
                        document.querySelectorAll('.error-front').forEach(el => el.remove());
                        let valido = true;

                        if (!pagoId) {
                            mostrarError('inputComentario', 'No se encontró un pago válido.');
                            valido = false;
                        }

                        if (!comentario) {
                            mostrarError('inputComentario', 'El comentario no puede estar vacío.');
                            valido = false;
                        }

                        if (!valido) return;

                        fetch(`/comentariospagos`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    pagoUsuario_id: pagoId,
                                    comentario: comentario
                                })
                            })
                            .then(response => {
                                if (!response.ok) throw new Error('Error al enviar el comentario.');
                                return response.json();
                            })
                            .then(() => {
                                document.getElementById('inputComentario').value = '';
                                cargarComentarios(pagoId);
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

                function cargarComentarios(pagoId) {
                    const modalBody = document.getElementById('comentariosModalBody');
                    const loader = document.getElementById('loaderComentarios');

                    loader.classList.remove('hidden');
                    modalBody.classList.add('opacity-0');
                    modalBody.innerHTML = '<p class="text-sm text-gray-400">Cargando comentarios...</p>';

                    fetch(`/comentariospagos/${pagoId}`)
                        .then(response => response.json())
                        .then(data => {
                            loader.classList.add('hidden');
                            modalBody.classList.remove('opacity-0');
                            modalBody.innerHTML = '';

                            if (data.length === 0) {
                                modalBody.innerHTML = `
                            <div class="text-center text-gray-500 py-4">
                                No hay comentarios registrados para este pago.
                            </div>`;
                                return;
                            }

                            data.forEach(comentario => {
                                const div = document.createElement('div');
                                div.className =
                                    'bg-white border border-gray-200 rounded-xl p-4 shadow-sm space-y-2 mb-3';
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
                                modalBody.appendChild(div);
                            });
                        })
                        .catch(error => {
                            console.error('Error cargando comentarios:', error);
                            loader.classList.add('hidden');
                            modalBody.classList.remove('opacity-0');
                            modalBody.innerHTML =
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
