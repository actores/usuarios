<x-app-layout>
    <section class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="text-lg font-bold mb-4">Resumen de Pagos y Abonos</h2>

        <div class="overflow-x-auto bg-white shadow rounded-md">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Año Explotación</th>
                        <th class="px-6 py-3 text-right font-semibold text-gray-700">Importe</th>
                        <th class="px-6 py-3 text-right font-semibold text-gray-700">Total Administración</th>
                        <th class="px-6 py-3 text-right font-semibold text-gray-700">Total Bienestar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($pagos as $pago)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 text-gray-700">{{ $pago['id'] }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $pago['anio_explotacion'] }}</td>
                            <td class="px-6 py-3 text-right text-gray-700">{{ number_format($pago['importe'], 2) }}</td>
                            <td class="px-6 py-3 text-right text-gray-700">{{ number_format($pago['total_admin'], 2) }}</td>
                            <td class="px-6 py-3 text-right text-gray-700">{{ number_format($pago['total_bienestar'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginación si usas paginate en lugar de get --}}
            {{-- <div class="my-4 px-4">
                {{ $pagos->links() }}
            </div> --}}
        </div>

    </section>
</x-app-layout>
