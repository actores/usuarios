<table>
    <thead>
        <tr>
            <th colspan="5">Datos del Pago</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Año Explotación</th>
            <th>Importe</th>
            <th>Estado</th>
            <th>Factura</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $pago->id }}</td>
            <td>{{ $pago->anio_explotacion }}</td>
            <td>{{ number_format($pago->importe, 2) }}</td>
            <td>{{ $pago->estadoPago }}</td>
            <td>
                @if ($pago->factura)
                    <a href="{{ asset('storage/facturas/' . $pago->factura) }}" target="_blank">Ver factura</a>
                @else
                    Sin factura
                @endif
            </td>
        </tr>
    </tbody>
</table>

<br>

<table>
    <thead>
        <tr>
            <th colspan="6">Abonos</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Año Pago</th>
            <th>Importe</th>
            <th>Tasa Administración</th>
            <th>Tasa Bienestar</th>
            <th>Factura</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($abonos as $abono)
            <tr>
                <td>{{ $abono->id }}</td>
                <td>{{ $abono->tasa->anio }}</td>
                <td>{{ number_format($abono->importe, 2) }}</td>
                <td>{{ number_format($abono->tasa_administracion, 2) }}</td>
                <td>{{ number_format($abono->tasa_bienestar, 2) }}</td>
                <td>
                    @if ($abono->factura)
                        <a href="{{ asset('storage/facturas/' . $abono->factura) }}" target="_blank">Ver factura</a>
                    @else
                        Sin factura
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
