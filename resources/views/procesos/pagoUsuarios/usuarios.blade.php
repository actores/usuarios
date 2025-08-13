<x-app-layout>

    <section class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="formUsuario">

        {{-- Notificaciones --}}
        @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: "{{ session('success') }}"
            });
        </script>
        @endif

        @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}"
            });
        </script>
        @endif

        @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Errores al guardar',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'Entendido'
            });
        </script>
        @endif

        {{-- Encabezado --}}
        <nav class="text-sm text-gray-600 mb-5">
            <ol class="flex space-x-2">
                <li><a href="{{ url('/dashboard') }}" class="text-blue-600 hover:underline">Inicio</a></li>
                <li>/</li>
                <li class="text-gray-500">Usuarios</li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <!-- Formulario de búsqueda -->
            <form method="GET" action="{{ route('usuarios.listar') }}"
                onsubmit="return document.getElementById('buscar-input').value.trim() !== ''"
                class="flex flex-wrap items-center gap-2 w-full md:w-2/3">

                <input
                    id="buscar-input"
                    type="text"
                    name="buscar"
                    placeholder="Buscar por nombre, NIT o Razón Social"
                    value="{{ request('buscar') }}"
                    class="border border-gray-300 rounded px-4 py-2 text-sm w-full md:flex-1 focus:outline-none focus:ring-2 focus:ring-sky-300" />

                <button
                    type="submit"
                    class="bg-sky-600 hover:bg-sky-700 text-white text-sm px-4 py-2 rounded">
                    Buscar
                </button>

                @if(request('buscar'))
                <a href="{{ route('usuarios.listar') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm px-4 py-2 rounded">
                    Limpiar
                </a>
                @endif
            </form>

            <!-- Botones de acciones -->
            <div class="flex gap-2 justify-end">
                <button
                    @click="open = true"
                    class="bg-sky-600 hover:bg-sky-700 text-white text-sm px-4 py-2 rounded">
                    Nuevo Usuario
                </button>
                <a
                    href="{{ route('exportar.usuarios') }}"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded">
                    Exportar Usuarios
                </a>
            </div>
        </div>

        {{-- Tabla --}}

        <div class="overflow-x-auto bg-white shadow rounded-md">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Usuario</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Datos</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Tipo</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($usuarios as $usuario)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-sky-600 text-white flex items-center justify-center rounded-lg font-bold uppercase">
                                    {{ substr($usuario->nombre, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $usuario->nombre }}</div>
                                    <div class="text-gray-500 text-xs">{{ $usuario->razonSocial ?? 'Sin razón social' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3 text-gray-700">
                            <div>NIT: {{ $usuario->nit }}</div>
                            <div>{{ $usuario->direccion }}</div>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <span class="inline-block bg-sky-100 text-sky-800 text-xs px-2 py-1 rounded-full">
                                {{ $usuario->tipo_usuarios }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <a href="{{ url('/usuarios/detalle/' . $usuario->id) }}" class="text-blue-600 hover:underline">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Contenedor de paginación --}}
            <div class="my-4 px-4 bg-info-500">
                {{ $usuarios->links() }}
            </div>

        </div>

        {{-- MODAL NUEVO USUARIO --}}
        <div
            x-show="open"
            x-cloak
            @close-modal.window="cerrar()"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">

            <div @click.away="open = false"
                class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg overflow-hidden">

                <!-- Encabezado -->
                <div class="flex justify-between items-center px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold">Nuevo Usuario</h3>
                    <button @click="open = false" class="text-gray-600 hover:text-gray-800 text-xl">&times;</button>
                </div>

                <!-- Formulario -->
                <form id="formUsuario" action="/usuarios/nuevo" method="POST" enctype="multipart/form-data" class="px-6 pt-0 py-4 space-y-4">
                    @csrf

                    <!-- Nombre -->
                    <div>
                        <label for="inputNombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" id="inputNombre" name="inputNombre" value="{{ old('inputNombre') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('inputNombre')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Razón Social -->
                    <div>
                        <label for="inputRazonSocial" class="block text-sm font-medium text-gray-700">Razón Social</label>
                        <input type="text" id="inputRazonSocial" name="inputRazonSocial" value="{{ old('inputRazonSocial') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('inputRazonSocial')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Usuario -->
                    <div>
                        <label for="inputTipoUsuario" class="block text-sm font-medium text-gray-700">Tipo de Usuario</label>
                        <select id="inputTipoUsuario" name="inputTipoUsuario"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Seleccione un tipo</option>
                            @foreach ($tiposUsuario as $tipoUsuario)
                            <option value="{{ $tipoUsuario->id }}" {{ old('inputTipoUsuario') == $tipoUsuario->id ? 'selected' : '' }}>
                                {{ $tipoUsuario->nombre }}
                            </option>
                            @endforeach
                        </select>
                        @error('inputTipoUsuario')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIT -->
                    <div>
                        <label for="inputNit" class="block text-sm font-medium text-gray-700">NIT</label>
                        <input type="number" id="inputNit" name="inputNit" value="{{ old('inputNit') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('inputNit')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dirección -->
                    <div>
                        <label for="inputDireccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                        <input type="text" id="inputDireccion" name="inputDireccion" value="{{ old('inputDireccion') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('inputDireccion')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ciudad -->
                    <div>
                        <label for="inputCiudad" class="block text-sm font-medium text-gray-700">Ciudad</label>
                        <input type="text" id="inputCiudad" name="inputCiudad" value="{{ old('inputCiudad') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('inputCiudad')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" @click="cerrar()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded">
                            Cerrar
                        </button>
                        <button type="submit"
                            class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </section>
    @section('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('formUsuario', () => ({
                open: false,
                cerrar() {
                    this.open = false;
                    this.limpiarFormulario();
                    this.limpiarErrores();
                },
                limpiarFormulario() {
                    const form = document.getElementById('formUsuario');
                    if (form) form.reset();
                },
                limpiarErrores() {
                    // Quita errores frontend
                    document.querySelectorAll('.error-front').forEach(el => el.remove());

                    // Quita errores de Laravel (si quieres que también se limpien)
                    document.querySelectorAll('.error-laravel').forEach(el => el.remove());
                }
            }));
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formUsuario');
            if (!form) return;

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

                // Limpia errores previos
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

                if (!valido) e.preventDefault(); // Evita envío si hay errores
            });
        });
    </script>
    @endsection




</x-app-layout>