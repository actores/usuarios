<x-app-layout>
    <section class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-auto bg-white p-6 shadow rounded">
            <h2 class="text-lg font-bold mb-4">Editar Tipo de Usuario - ID {{ $tipo->id }}</h2>

            <form action="{{ route('tipos_usuarios.update', $tipo->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Nombre del tipo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nombre
                    </label>
                    <input type="text" name="nombre" 
                        value="{{ old('nombre', $tipo->nombre) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-sky-500 focus:border-sky-500">
                    @error('nombre')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex justify-between pt-4">
                    <a href="{{ route('tipos_usuarios.listar') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
