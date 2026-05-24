<div class="historial-card">
    <h3>Registros Recientes</h3>
    <table class="historial-table">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($historialTabla as $registro)
            <tr>
                <td>
                    {{ \Carbon\Carbon::parse($registro->fecha_registro)->format('d/m/Y') }}<br>
                    <small style="color: #94a3b8;">{{ $registro->notas }}</small>
                </td>
                <td style="font-weight: 600;">
                    {{ $registro->valor }} 
                    <span style="font-weight: normal; font-size: 12px; color: #64748b;">{{ $metricaSeleccionada->unidad_medida }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" style="text-align: center; color: #94a3b8; padding: 20px;">
                    No hay registros en este periodo.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>