<!-- Patient Table -->
<div class="patient-card">
    <table class="table">

        <thead class="table-header">
            <tr class="table-header-row">
                <th>PACIENTE</th>
                <th>CONDICIÓN</th>
                <th>ESTADO</th>
                <th>ÚLTIMA VISITA</th>
                <th>PRÓXIMA CITA</th>
                <th>ACCIONES</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($pacientes as $paciente)
                <tr class="table-row">

                    <!-- PACIENTE -->
                    <td>
                        <div class="patient-info">

                            <div class="avatar">
                                {{ strtoupper(substr($paciente->nombre_completo, 0, 1)) }}
                            </div>

                            <div class="patient-details">

                                <h4>
                                    {{ $paciente->nombre_completo }}
                                </h4>

                                <p>
                                    {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años ·
                                    {{ ucfirst($paciente->sexo) }}
                                </p>
                            </div>

                        </div>
                    </td>

                    <!-- CONDICIÓN -->
                    <td>
                        {{ $paciente->diagnostico_principal }}
                    </td>

                    <!-- ESTADO -->
                    <td>
                        <span class="status-badge status-tratamiento">
                            {{ $paciente->estado }}
                        </span>
                    </td>

                    <!-- DATOS FIJOS -->
                    <td>01 may 2026</td>

                    <td>15 may 2026</td>

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

                            <button class="dropdown-item delete-item" data-id="{{ $paciente->id }}">
                                Eliminar
                            </button>

                        </div>

                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>
</div>
