<x-app-layout>
    <section class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mx-auto space-y-6">

            <!-- Formulario de edición -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Editar abono</h2>
                <form action="{{ route('abonos.actualizar', $abono->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="usuario_id" value="{{ $abono->pagoUsuario->usuario_id }}">

                    <!-- Año de abono -->
                    <div>
                        <label for="inputAnioPago" class="block text-sm font-medium text-gray-700">Año de abono</label>
                        <select
                            id="inputAnioPago"
                            name="inputAnioPago"
                            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Seleccione un año y tasa</option>
                            @foreach ($tasas as $anio => $tasaPorAnio)
                            @php
                            $adminTasa = $tasaPorAnio->where('tipo', 1)->first();
                            $bienestarTasa = $tasaPorAnio->where('tipo', 2)->first();
                            $selected = $abono->anio_pago == $adminTasa->id ? 'selected' : '';
                            @endphp
                            <option value="{{ $adminTasa->id }}" {{ $selected }}>
                                {{ $anio }} - ADM - {{ number_format($adminTasa->tasa, 0) }}% - BNS - {{ $bienestarTasa->tasa }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Importe -->
                    <div>
                        <label for="inputImporte" class="block text-sm font-medium text-gray-700">Importe</label>
                        <input
                            type="number"
                            step="0.01"
                            id="inputImporte"
                            name="inputImporte"
                            value="{{ old('inputImporte', $abono->importe) }}"
                            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <!-- Factura -->
                    <div>
                        <label for="inputFactura" class="block text-sm font-medium text-gray-700">Factura (PDF)</label>
                        <input
                            type="file"
                            id="inputFactura"
                            name="inputFactura"
                            class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            accept="application/pdf">
                        @if ($abono->factura)
                        <p class="text-sm text-gray-500 mt-1">
                            Archivo actual:
                            <a href="{{ asset('storage/facturas/' . $abono->factura) }}" target="_blank" class="text-sky-600 hover:underline">
                                Ver factura
                            </a>
                        </p>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-between pt-4">
                        <a href="/pagos/detalle/abonos/{{ $usuario }}/{{ $pago }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">Guardar cambios</button>
                    </div>
                </form>

            </div>

        </div>
    </section>
</x-app-layout>