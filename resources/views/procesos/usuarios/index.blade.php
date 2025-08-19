<x-app-layout>
    <section class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

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

        {{-- Encabezado --}}
        <nav class="text-sm text-gray-600 mb-5">
            <ol class="flex space-x-2">
                <li><a href="{{ url('/dashboard') }}" class="text-blue-600 hover:underline">Inicio</a></li>
                <li>/</li>
                <li class="text-gray-500">Tipos de Usuarios</li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">

            <!-- Formulario de búsqueda -->
            <form method="GET" action="{{ route('tipos_usuarios.listar') }}"
                class="flex flex-wrap items-center gap-2 w-full md:w-2/3">

                <input type="text" name="buscar" placeholder="Buscar por nombre" value="{{ request('buscar') }}"
                    class="border border-gray-300 rounded px-4 py-2 text-sm w-full md:flex-1 focus:outline-none focus:ring-2 focus:ring-sky-300" />

                <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white text-sm px-4 py-2 rounded">
                    Buscar
                </button>

                @if (request('buscar'))
                    <a href="{{ route('tipos_usuarios.listar') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm px-4 py-2 rounded">
                        Limpiar
                    </a>
                @endif
            </form>

            <div class="flex gap-2 justify-end items-center">
                <!-- Botón Nuevo tipo con su modal dentro -->
                <div x-data="tipoUsuarioForm()">
                    <button @click="open = true"
                        class="bg-sky-600 hover:bg-sky-700 text-white text-sm px-4 py-2 rounded">
                        Nuevo tipo
                    </button>

                    <!-- Modal -->
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">

                        <div @click.outside="cerrarModal"
                            class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg overflow-hidden">

                            <!-- Encabezado -->
                            <div class="flex justify-between items-center px-6 py-4 border-b">
                                <h3 class="text-lg font-semibold">Nuevo Tipo de Usuario</h3>
                                <button @click="cerrarModal"
                                    class="text-gray-600 hover:text-gray-800 text-xl">&times;</button>
                            </div>

                            <!-- Formulario -->
                            <form x-ref="formTipo" @submit.prevent="validateForm"
                                action="{{ route('tipos_usuarios.store') }}" method="POST"
                                class="px-6 pt-0 py-4 space-y-4">
                                @csrf

                                <div>
                                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" id="nombre" name="nombre" x-model="form.nombre"
                                        value="{{ old('nombre') }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">

                                    <template x-if="errors.nombre">
                                        <p class="text-red-600 text-sm mt-1" x-text="errors.nombre"></p>
                                    </template>
                                    @error('nombre')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="cerrarModal"
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
                </div>


                <!-- Botón Exportar -->
                <a href="{{ route('tipos_usuarios.exportar', ['buscar' => request('buscar')]) }}"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded flex items-center justify-center">
                    Exportar Tipos
                </a>
            </div>

        </div>

        {{-- Tabla --}}
        <div class="overflow-x-auto bg-white shadow rounded-md">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Nombre</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($tipos as $tipo)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 text-gray-700">{{ $tipo->id }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $tipo->nombre }}</td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('tipos_usuarios.edit', $tipo->id) }}"
                                    class="text-blue-600 hover:underline">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="my-4 px-4">
                {{ $tipos->appends(['buscar' => request('buscar')])->links() }}
            </div>
        </div>

    </section>

    @section('scripts')
        <script>
            function tipoUsuarioForm() {
                return {
                    open: false,
                    form: {
                        nombre: ''
                    },
                    errors: {},

                    validateForm() {
                        this.errors = {};
                        if (!this.form.nombre) {
                            this.errors.nombre = "El nombre es obligatorio";
                        }

                        if (Object.keys(this.errors).length === 0) {
                            this.$refs.formTipo.submit();
                        }
                    },

                    cerrarModal() {
                        this.open = false;
                        this.limpiar();
                    },

                    limpiar() {
                        this.errors = {};
                        this.form = {
                            nombre: ''
                        };
                    }
                }
            }
        </script>
    @endsection

</x-app-layout>
