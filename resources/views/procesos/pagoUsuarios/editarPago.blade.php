<x-app-layout>
    <section class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-auto space-y-6">

         

            <!-- Formulario de edición -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Editar pago</h2>

                <form action="{{ route('pagos.actualizar', $pago->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">

                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full">
                            <label for="inputAnioExplotacion" class="block text-sm font-medium text-gray-700 mb-1">Año de explotación</label>
                            <input type="number" name="inputAnioExplotacion" id="inputAnioExplotacion"
                                class="block w-full border border-gray-300 rounded px-3 py-2"
                                value="{{ old('inputAnioExplotacion', $pago->anio_explotacion) }}" required>
                        </div>

                        <div class="w-full">
                            <label for="inputImporte" class="block text-sm font-medium text-gray-700 mb-1">Importe</label>
                            <input type="number" step="0.01" name="inputImporte" id="inputImporte"
                                class="block w-full border border-gray-300 rounded px-3 py-2"
                                value="{{ old('inputImporte', $pago->importe) }}" step="0.01" min="0" required>
                        </div>
                    </div>

                    <div>
                        <label for="inputFactura" class="block text-sm font-medium text-gray-700 mb-1">Factura (PDF)</label>
                        <input type="file" name="inputFactura" id="inputFactura"
                            class="block w-full border border-gray-300 rounded px-3 py-2" accept="application/pdf">
                        @if ($pago->factura)
                            <p class="text-sm text-gray-500 mt-1">
                                Archivo actual:
                                <a href="{{ asset('storage/facturas/' . $pago->factura) }}" target="_blank" class="text-sky-600 hover:underline">
                                    Ver factura
                                </a>
                            </p>
                        @endif
                    </div>

                    <div class="flex justify-between pt-4">
                        <a href="{{ route('usuarios.detalle', $usuario->id) }}"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</x-app-layout>
