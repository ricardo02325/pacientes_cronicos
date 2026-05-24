@foreach($medicos as $medico)

<div class="doctor-card">

    <i class="fa-solid fa-ellipsis card-menu"></i>

    <div class="doctor-header">

        <div class="avatar">
            {{ strtoupper(substr($medico->nombre_completo, 0, 1)) }}
        </div>

        <div class="doctor-info">

            <h3 class="doctor-name">
                {{ $medico->nombre_completo }}
            </h3>

            <span class="badge badge-specialty doctor-specialty">
                {{ $medico->especialidad }}
            </span>

        </div>

    </div>

    <div class="doctor-details">

        <div class="detail-item">
            <i class="fa-solid fa-phone"></i>

            <span>
                {{ $medico->telefono }}
            </span>
        </div>

        <div class="detail-item">
            <i class="fa-regular fa-envelope"></i>

            <span>
                {{ $medico->email }}
            </span>
        </div>

        <div class="detail-item">
            <i class="fa-regular fa-circle-check"></i>

            <span>
                Cédula: {{ $medico->cedula_profesional }}
            </span>
        </div>

    </div>

    <div class="divider"></div>

    <div class="doctor-footer">

        <span class="badge badge-status">

            {{ $medico->estado }}

        </span>

    </div>

</div>

@endforeach