<!-- Table Card -->
<div class="card">
    <h2 class="card-header">Pacientes Recientes</h2>
    <table>
        <thead>
            <tr>
                <th>PACIENTE</th>
                <th>CONDICIÓN</th>
                <th>ESTADO</th>
                <th>ÚLTIMA VISITA</th>
                <th>PRÓXIMA CITA</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($pacientesEstado as $paciente)
                <tr>
                    <td>
                        <div class="patient-cell">
                            <div class="avatar">
                                {{ strtoupper(substr($paciente->nombre_completo, 0, 1)) }}
                            </div>
                            <div class="patient-info">
                                <h4>{{ $paciente->nombre_completo }}</h4>
                                <p>
                                    {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años ·
                                    {{ ucfirst($paciente->sexo) }}
                                </p>
                            </div>
                        </div>
                    </td>

                    <td>{{ $paciente->diagnostico_principal }}</td>

                    <td>
                        @if ($paciente->nivel_riesgo == 'Alto')
                            <span class="badge critico">Crítico</span>
                        @elseif($paciente->nivel_riesgo == 'Medio')
                            <span class="badge tratamiento">En Tratamiento</span>
                        @else
                            <span class="badge estable">Estable</span>
                        @endif
                    </td>

                    {{-- Fechas fijas como pediste --}}
                    <td class="date-cell">01 may<br>2026</td>
                    <td class="date-cell">05 may<br>2026</td>

                    <!-- ACCIONES -->
                    <td class="actions-cell">

                        <button class="actions-btn">
                            &#10247;
                        </button>

                        <div class="actions-menu hidden">

                            <button class="dropdown-item">
                                Ver más
                            </button>

                            <button class="dropdown-item edit-btn">
                                Editar
                            </button>

                            <button class="dropdown-item delete-item">
                                Eliminar
                            </button>

                        </div>

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
