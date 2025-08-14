<x-app-layout>
    <section class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-auto bg-white p-6 shadow rounded">
            <h2 class="text-lg font-bold mb-4">Editar Tasas - Año {{ $anio }}</h2>

            <form action="{{ route('tasas.update', $anio) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Tasa Administración -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Tasa Administración (%)
                    </label>
                    <input type="number" step="0.01" name="tasa_admin"
                        value="{{ old('tasa_admin', $admin->tasa ?? '') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-sky-500 focus:border-sky-500">
                    @error('tasa_admin')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tasa Bienestar -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Tasa Bienestar (%)
                    </label>
                    <input type="number" step="0.01" name="tasa_bienestar"
                        value="{{ old('tasa_bienestar', $bienestar->tasa ?? '') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-sky-500 focus:border-sky-500">
                    @error('tasa_bienestar')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex justify-between pt-4">
                    <a href="{{ route('tasas.listar') }}"
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
