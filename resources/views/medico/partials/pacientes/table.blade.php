<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Diagnóstico Principal</th>
                <th>Último Registro</th>
                <th>Nivel de Riesgo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pacientes as $paciente)
            <tr>
                <td class="td-paciente">
                    {{ $paciente->usuario->primer_nombre }} {{ $paciente->usuario->segundo_nombre }} {{ $paciente->usuario->apellido_paterno }} {{ $paciente->usuario->apellido_materno }}
                    <span>{{ $paciente->usuario->email }}</span>
                </td>
                <td>{{ $paciente->diagnostico_principal }}</td>
                <td>
                    {{-- Mostramos la fecha de la última métrica, o un texto si no hay --}}
                    @if($paciente->ultimaMetrica)
                        {{ \Carbon\Carbon::parse($paciente->ultimaMetrica->fecha_registro)->format('d/m/Y') }}
                    @else
                        <span class="text-muted">Sin registros</span>
                    @endif
                </td>
                <td>
                    @if($paciente->nivel_riesgo == 'Alto')
                        <span class="badge badge-alto"><i class="fa-solid fa-circle-exclamation"></i> Alto</span>
                    @elseif($paciente->nivel_riesgo == 'Medio')
                        <span class="badge badge-medio"><i class="fa-solid fa-triangle-exclamation"></i> Medio</span>
                    @else
                        <span class="badge badge-bajo"><i class="fa-regular fa-circle-check"></i> Bajo</span>
                    @endif
                </td>
                <td><a href="{{ route('medico.pacientes.show', $paciente->id) }}" class="action-link">Monitorear</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 2rem; color: #64748b;">
                    No se encontraron pacientes.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="padding: 16px;">
        {{ $pacientes->withQueryString()->links() }}
    </div>
</div>