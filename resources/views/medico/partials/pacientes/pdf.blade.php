<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Clínico de Monitoreo</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1e293b; font-size: 13px; line-height: 1.5; }
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .logo-title { font-size: 24px; font-weight: bold; color: #2563eb; }
        .report-info { text-align: right; color: #64748b; font-size: 11px; }
        
        .section-title { font-size: 14px; font-weight: bold; background-color: #f1f5f9; padding: 6px 10px; margin-bottom: 15px; border-left: 4px solid #2563eb; }
        
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .info-table td { padding: 6px; vertical-align: top; }
        .label { font-weight: bold; color: #475569; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th { background-color: #2563eb; color: white; font-weight: bold; text-align: left; padding: 8px 12px; font-size: 12px; }
        .data-table td { padding: 10px 12px; border-bottom: 1px solid #e2e8f0; }
        .data-table tr:nth-child(even) { background-color: #f8fafc; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #94a3b8; border-t: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="logo-title">CróniCare</td>
            <td class="report-info">
                <strong>Generado el:</strong> {{ now()->format('d/m/Y H:i') }}<br>
                <strong>Rango evaluado:</strong> {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
            </td>
        </tr>
    </table>

    <div class="section-title">Información del Paciente</div>
    <table class="info-table">
        <tr>
            <td width="15%" class="label">Nombre:</td>
            <td width="35%">{{ $paciente->usuario->primer_nombre }} {{ $paciente->usuario->apellido_paterno }} {{ $paciente->usuario->apellido_materno }}</td>
            <td width="15%" class="label">Diagnóstico:</td>
            <td width="35%">{{ $paciente->diagnostico_principal }}</td>
        </tr>
        <tr>
            <td class="label">Edad:</td>
            <td>{{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años</td>
            <td class="label">Nivel Riesgo:</td>
            <td><strong>{{ $paciente->nivel_riesgo }}</strong></td>
        </tr>
        <tr>
            <td class="label">Género:</td>
            <td>{{ ucfirst($paciente->sexo) }}</td>
            <td class="label">Estatura:</td>
            <td>{{ $paciente->estatura }} m</td>
        </tr>
    </table>

    <div class="section-title">Historial Clínico: {{ $metricaSeleccionada->nombre }}</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="35%">Fecha y Hora de Registro</th>
                <th width="25%">Valor Registrado</th>
                <th width="40%">Notas Médicas / Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($historial as $registro)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($registro->fecha_registro)->format('d/m/Y H:i A') }}</td>
                    <td>
                        <strong>{{ $registro->valor }}</strong> {{ $metricaSeleccionada->unidad_medida }}
                    </td>
                    <td>{{ $registro->notas ?? 'Sin observaciones.' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #64748b;">No se encontraron mediciones registradas para este periodo.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Este documento es un reporte electrónico emitido por la plataforma CróniCare de monitoreo clínico continuo.
    </div>

</body>
</html>