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
                <li class="text-gray-500">Tasas</li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <!-- Formulario de búsqueda -->
            <form method="GET" action="{{ route('tasas.listar') }}"
                class="flex flex-wrap items-center gap-2 w-full md:w-2/3">

                {{-- Input de búsqueda --}}
                <input id="buscar-input" type="text" name="buscar" placeholder="Buscar por año"
                    value="{{ request('buscar') }}"
                    class="border border-gray-300 rounded px-4 py-2 text-sm w-full md:flex-1 focus:outline-none focus:ring-2 focus:ring-sky-300" />

                {{-- Botón de búsqueda --}}
                <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white text-sm px-4 py-2 rounded">
                    Buscar
                </button>

                {{-- Botón limpiar --}}
                @if (request('buscar'))
                    <a href="{{ route('tasas.listar') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm px-4 py-2 rounded">
                        Limpiar
                    </a>
                @endif
            </form>


            <!-- Botones de acciones -->
            <div class="flex gap-2 justify-end">
                <!-- Contenedor Alpine -->
                <div x-data="tasaForm()">
                    <!-- Botón para abrir el modal -->
                    <button @click="open = true"
                        class="bg-sky-600 hover:bg-sky-700 text-white text-sm px-4 py-2 rounded">
                        Nuevo año
                    </button>

                    {{-- MODAL NUEVA TASA --}}
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">

                        <div @click.outside="cerrarModal"
                            class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg overflow-hidden">

                            <!-- Encabezado -->
                            <div class="flex justify-between items-center px-6 py-4 border-b">
                                <h3 class="text-lg font-semibold">Nueva Tasa</h3>
                                <button @click="cerrarModal"
                                    class="text-gray-600 hover:text-gray-800 text-xl">&times;</button>
                            </div>

                            <!-- Formulario -->
                            <form x-ref="formTasa" @submit.prevent="validateForm" action="{{ route('tasas.store') }}"
                                method="POST" class="px-6 pt-0 py-4 space-y-4">
                                @csrf

                                <!-- Año -->
                                <div>
                                    <label for="anio" class="block text-sm font-medium text-gray-700">Año</label>
                                    <input type="number" id="anio" name="anio" x-model="form.anio"
                                        value="{{ old('anio') }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500">

                                    <template x-if="errors.anio">
                                        <p class="text-red-600 text-sm mt-1" x-text="errors.anio"></p>
                                    </template>
                                    @error('anio')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tasa Administración -->
                                <div>
                                    <label for="tasa_admin" class="block text-sm font-medium text-gray-700">Tasa
                                        Administración (%)</label>
                                    <input type="number" step="0.01" id="tasa_admin" name="tasa_admin"
                                        x-model="form.tasa_admin" value="{{ old('tasa_admin') }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">

                                    <template x-if="errors.tasa_admin">
                                        <p class="text-red-600 text-sm mt-1" x-text="errors.tasa_admin"></p>
                                    </template>
                                    @error('tasa_admin')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tasa Bienestar -->
                                <div>
                                    <label for="tasa_bienestar" class="block text-sm font-medium text-gray-700">Tasa
                                        Bienestar (%)</label>
                                    <input type="number" step="0.01" id="tasa_bienestar" name="tasa_bienestar"
                                        x-model="form.tasa_bienestar" value="{{ old('tasa_bienestar') }}"
                                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">

                                    <template x-if="errors.tasa_bienestar">
                                        <p class="text-red-600 text-sm mt-1" x-text="errors.tasa_bienestar"></p>
                                    </template>
                                    @error('tasa_bienestar')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Botones -->
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

                <a href="{{ route('tasas.exportar', ['buscar' => $buscar]) }}"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded">
                    Exportar Tasas
                </a>
            </div>
        </div>

        {{-- Tabla --}}

        <div class="overflow-x-auto bg-white shadow rounded-md">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Año</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Tasa Administración</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Tasa Bienestar</th>
                        <th class="px-6 py-3 text-center font-semibold text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($tasas->groupBy('anio') as $anio => $items)
                        @php
                            $admin = $items->firstWhere('tipo', 1);
                            $bienestar = $items->firstWhere('tipo', 2);
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 text-gray-700">{{ $anio }}</td>
                            <td class="px-6 py-3 text-center text-gray-700">
                                {{ $admin ? $admin->tasa . ' %' : '-' }}
                            </td>
                            <td class="px-6 py-3 text-center text-gray-700">
                                {{ $bienestar ? $bienestar->tasa . ' %' : '-' }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('tasas.edit', $anio) }}" class="text-blue-600 hover:underline">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            {{-- Contenedor de paginación --}}
            <div class="my-4 px-4">
                {{ $tasas->appends(['buscar' => request('buscar')])->links() }}
            </div>

        </div>


    </section>
    @section('scripts')
        <script>
            function tasaForm() {
                return {
                    open: false,
                    form: {
                        anio: '',
                        tasa_admin: '',
                        tasa_bienestar: ''
                    },
                    errors: {},

                    validateForm() {
                        this.errors = {};

                        if (!this.form.anio) {
                            this.errors.anio = "El año es obligatorio";
                        } else if (this.form.anio < 2000) {
                            this.errors.anio = "El año debe ser mayor a 2000";
                        }

                        if (!this.form.tasa_admin) {
                            this.errors.tasa_admin = "La tasa de Administración es obligatoria";
                        } else if (this.form.tasa_admin <= 0) {
                            this.errors.tasa_admin = "Debe ser mayor a 0";
                        }

                        if (!this.form.tasa_bienestar) {
                            this.errors.tasa_bienestar = "La tasa de Bienestar es obligatoria";
                        } else if (this.form.tasa_bienestar <= 0) {
                            this.errors.tasa_bienestar = "Debe ser mayor a 0";
                        }

                        // Si no hay errores, enviamos el form
                        if (Object.keys(this.errors).length === 0) {
                            this.$refs.formTasa.submit();
                        }
                    },

                    cerrarModal() {
                        this.open = false;
                        this.limpiar();
                    },

                    limpiar() {
                        this.errors = {};
                        this.form = {
                            anio: '',
                            tasa_admin: '',
                            tasa_bienestar: ''
                        };
                    }
                }
            }
        </script>
    @endsection




</x-app-layout>
