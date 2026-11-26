@extends('medico.layouts.app')

@section('title', 'Centro de Reportes & Telemetría Clínica')

@push('styles')
    @vite('resources/css/medico/pacientes.css')
    <style>
        .tabs-header-container {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            padding: 6px;
            border-radius: 14px;
            border: 1px solid var(--border-color);
            margin: 20px 0 24px;
            width: fit-content;
            box-shadow: var(--shadow-xs);
        }

        .tab-btn-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-muted);
            border: none;
            background: transparent;
            cursor: pointer;
            transition: all var(--transition-fast);
            text-decoration: none;
        }

        .tab-btn-pill:hover {
            color: var(--text-main);
            background: #f1f5f9;
        }

        .tab-btn-pill.active {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .tab-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 2px 7px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        /* Paneles */
        .tab-panel-container {
            display: none;
            animation: fadeInTab 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .tab-panel-container.active {
            display: block;
        }

        @keyframes fadeInTab {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* GRID REPORTES CLÁSICO */
        .report-grid-modern {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
        }

        .report-card-modern {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all var(--transition-normal);
        }

        .report-card-modern:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            border-color: var(--border-hover);
        }

        .report-card-top {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 14px;
        }

        .report-icon-box {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
            flex-shrink: 0;
        }

        .report-card-heading {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-main);
        }

        .report-card-body-text {
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 24px;
        }

        /* PANEL RADAR CLINICO */
        .radar-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 18px;
            padding: 24px 28px;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: var(--shadow-md);
            flex-wrap: wrap;
        }

        .radar-hero-content h2 {
            font-size: 20px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .radar-hero-content p {
            color: #94a3b8;
            font-size: 13.5px;
            margin-top: 6px;
            max-width: 650px;
            line-height: 1.45;
        }

        .radar-stats-group {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .radar-stat-box {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            padding: 12px 18px;
            border-radius: 14px;
            text-align: center;
            min-width: 100px;
        }

        .radar-stat-number {
            font-size: 24px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }

        .radar-stat-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #cbd5e1;
            font-weight: 600;
        }

        /* LAYOUT EN 2 COLUMNAS PARA EL RADAR */
        .radar-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        @media (max-width: 1024px) {
            .radar-layout {
                grid-template-columns: 1fr;
            }
        }

        .clinical-panel {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 22px;
            box-shadow: var(--shadow-sm);
        }

        .clinical-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-color);
        }

        .clinical-panel-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* TABLA DE RADAR */
        .radar-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13.5px;
        }

        .radar-table th {
            background: #f8fafc;
            color: var(--text-muted);
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 10px 14px;
            border-bottom: 1px solid var(--border-color);
            text-align: left;
        }

        .radar-table td {
            padding: 14px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: var(--text-main);
        }

        .radar-table tr:hover td {
            background: #f8fafc;
        }

        .patient-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-initial {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            border: 1px solid #bfdbfe;
        }

        .risk-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .risk-pill.alto {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .risk-pill.medio {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .risk-pill.bajo {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        /* ALERTAS CRÍTICAS LATERAL */
        .alert-card-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid #fee2e2;
            margin-bottom: 12px;
            border-left: 4px solid #ef4444;
            transition: transform var(--transition-fast);
        }

        .alert-card-item:hover {
            transform: translateX(3px);
            box-shadow: var(--shadow-sm);
        }

        .alert-icon-ring {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #fef2f2;
            color: #ef4444;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .alert-item-content {
            flex: 1;
        }

        .alert-item-title {
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
        }

        .alert-item-meta {
            font-size: 11.5px;
            color: #64748b;
            margin-top: 2px;
            display: flex;
            justify-content: space-between;
        }

        .alert-item-badge {
            font-weight: 700;
            color: #dc2626;
            background: #fff1f2;
            padding: 1px 6px;
            border-radius: 4px;
        }
    </style>
@endpush

@section('content')
<!-- Header Principal -->
<div class="patients-header-container">
    <div class="patients-title-group">
        <h1 class="page-main-heading">Centro de Reportes & Telemetría</h1>
        <p class="page-sub-heading">
            Expedientes clínicos, auditoría de métricas y radar predictivo de pacientes • Dr(a). {{ auth()->user()->nombre_completo ?? 'Médico' }}
        </p>
    </div>

    <div class="patients-header-actions">
        <a href="{{ route('medico.pacientes.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Volver a Pacientes</span>
        </a>
    </div>
</div>

<!-- NAVEGACIÓN POR PESTAÑAS (TABS) -->
<div class="tabs-header-container">
    <button type="button" class="tab-btn-pill active" onclick="switchTab('radar', this)">
        <i class="fa-solid fa-wave-square"></i>
        <span>Radar de Pacientes & Riesgo Vivo</span>
        <span class="tab-badge" style="background: #ef4444; color: white;">{{ $riesgoAlto }} Críticos</span>
    </button>

    <button type="button" class="tab-btn-pill" onclick="switchTab('exportables', this)">
        <i class="fa-solid fa-folder-open"></i>
        <span>Reportes Exportables & Filtros</span>
    </button>
</div>

<!-- ========================================================================= -->
<!-- PESTAÑA 1: NUEVO RADAR CLÍNICO Y TELEMETRÍA EN TIEMPO REAL -->
<!-- ========================================================================= -->
<div id="panel-radar" class="tab-panel-container active">
    
    <!-- Hero Banner con Indicadores Clave -->
    <div class="radar-hero">
        <div class="radar-hero-content">
            <h2>
                <i class="fa-solid fa-shield-heart text-red-400"></i>
                Vigilancia Epidemiológica de Pacientes Crónicos
            </h2>
            <p>
                Visualización centralizada de pacientes según su última telemetría biométrica registrada. 
                Los pacientes con signos de descontrol glucémico o tensional se categorizan automáticamente para intervención temprana.
            </p>
        </div>

        <div class="radar-stats-group">
            <div class="radar-stat-box" style="border-color: rgba(239, 68, 68, 0.4);">
                <div class="radar-stat-number" style="color: #f87171;">{{ $riesgoAlto }}</div>
                <div class="radar-stat-label">Riesgo Alto</div>
            </div>
            <div class="radar-stat-box" style="border-color: rgba(245, 158, 11, 0.4);">
                <div class="radar-stat-number" style="color: #fbbf24;">{{ $riesgoMedio }}</div>
                <div class="radar-stat-label">Riesgo Medio</div>
            </div>
            <div class="radar-stat-box" style="border-color: rgba(16, 185, 129, 0.4);">
                <div class="radar-stat-number" style="color: #34d399;">{{ $riesgoBajo }}</div>
                <div class="radar-stat-label">Estables</div>
            </div>
            <div class="radar-stat-box">
                <div class="radar-stat-number" style="color: #60a5fa;">{{ $totalPacientes }}</div>
                <div class="radar-stat-label">Total Activos</div>
            </div>
        </div>
    </div>

    <!-- Layout en 2 columnas: Radar y Alertas Críticas -->
    <div class="radar-layout">
        
        <!-- Columna Izquierda: Tabla Inteligente de Pacientes Asignados -->
        <div class="clinical-panel">
            <div class="clinical-panel-header">
                <h3 class="clinical-panel-title">
                    <i class="fa-solid fa-microscope text-blue-600"></i>
                    Matriz de Monitoreo Biométrico
                </h3>
                <span class="text-xs text-slate-500 font-medium">
                    {{ $pacientesConMetricas->count() }} pacientes evaluados
                </span>
            </div>

            <div style="overflow-x: auto;">
                <table class="radar-table">
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Diagnóstico</th>
                            <th>Riesgo</th>
                            <th>Última Métrica</th>
                            <th>Acción Rápida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pacientesConMetricas as $p)
                            <tr>
                                <td>
                                    <div class="patient-cell">
                                        <div class="avatar-initial">
                                            {{ strtoupper(substr($p->usuario->primer_nombre ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: #0f172a;">
                                                {{ $p->usuario->nombre_completo ?? 'Paciente' }}
                                            </div>
                                            <div style="font-size: 11px; color: #64748b;">
                                                {{ $p->usuario->email ?? 'Sin correo' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-weight: 500; font-size: 12.5px;">
                                        {{ $p->diagnostico_principal ?? 'Monitoreo Preventivo' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $rClass = strtolower($p->nivel_riesgo ?? 'bajo');
                                    @endphp
                                    <span class="risk-pill {{ $rClass }}">
                                        @if($rClass == 'alto')
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        @elseif($rClass == 'medio')
                                            <i class="fa-solid fa-circle-dot"></i>
                                        @else
                                            <i class="fa-solid fa-circle-check"></i>
                                        @endif
                                        {{ $p->nivel_riesgo ?? 'Bajo' }}
                                    </span>
                                </td>
                                <td>
                                    @if($p->ultimaMetrica)
                                        <div style="font-weight: 700; color: #1e293b; font-size: 13px;">
                                            {{ $p->ultimaMetrica->valor }} <span style="font-size: 10.5px; color: #64748b;">{{ $p->ultimaMetrica->tipoMetrica->unidad_medida ?? '' }}</span>
                                        </div>
                                        <div style="font-size: 10.5px; color: #94a3b8;">
                                            {{ $p->ultimaMetrica->tipoMetrica->nombre ?? 'Métrica' }} • {{ \Carbon\Carbon::parse($p->ultimaMetrica->fecha_registro)->diffForHumans() }}
                                        </div>
                                    @else
                                        <span style="color: #94a3b8; font-style: italic; font-size: 11.5px;">Sin lecturas</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('medico.pacientes.show', $p->id) }}" 
                                       class="btn-secondary" 
                                       style="padding: 6px 12px; font-size: 12px; border-radius: 8px;"
                                       title="Ver Gráfica y Detalles">
                                        <i class="fa-solid fa-chart-line text-blue-600"></i>
                                        <span>Monitoreo</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px; color: #94a3b8;">
                                    No hay pacientes asignados registrados en este momento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Columna Derecha: Alertas de Telemetría Crítica -->
        <div class="clinical-panel">
            <div class="clinical-panel-header">
                <h3 class="clinical-panel-title">
                    <i class="fa-solid fa-bell text-rose-500"></i>
                    Alertas Descontrol Clínico
                </h3>
                <span class="text-xs bg-rose-50 text-rose-600 px-2.5 py-1 rounded-full font-bold">
                    Últimas tomas
                </span>
            </div>

            <p style="font-size: 12.5px; color: #64748b; margin-bottom: 16px;">
                Lecturas de los últimos 15 días fuera de los rangos configurados para cada paciente.
            </p>

            <div class="alert-list-scroll">
                @forelse($alertasRecientes as $alerta)
                    <div class="alert-card-item">
                        <div class="alert-icon-ring">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div class="alert-item-content">
                            <div class="alert-item-title">
                                {{ $alerta->paciente->usuario->nombre_completo ?? 'Paciente' }}
                            </div>
                            <div class="alert-item-meta">
                                <span>{{ $alerta->tipoMetrica->nombre ?? 'Signo vital' }}</span>
                                <span class="alert-item-badge">
                                    {{ $alerta->valor }} {{ $alerta->tipoMetrica->unidad_medida ?? '' }}
                                </span>
                            </div>
                            <div style="font-size: 10.5px; color: #94a3b8; margin-top: 4px;">
                                <i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($alerta->fecha_registro)->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 24px 12px; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1;">
                        <i class="fa-solid fa-circle-check text-emerald-500" style="font-size: 28px; margin-bottom: 8px;"></i>
                        <p style="font-size: 13px; font-weight: 600; color: #334155;">Sin alertas críticas</p>
                        <p style="font-size: 11.5px; color: #64748b;">Todas las mediciones recientes están en rango.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<!-- ========================================================================= -->
<!-- PESTAÑA 2: REPORTES EXPORTABLES CLÁSICOS (CON TUS FILTROS PREEXISTENTES) -->
<!-- ========================================================================= -->
<div id="panel-exportables" class="tab-panel-container">
    <div class="report-grid-modern">
        <div class="report-card-modern">
            <div>
                <div class="report-card-top">
                    <div class="report-icon-box">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <h3 class="report-card-heading">Expedientes en PDF</h3>
                </div>
                <p class="report-card-body-text">
                    Genera el resumen clínico detallado de cualquier paciente asignado, incluyendo datos biométricos de presión arterial, glucosa en sangre y signos vitales para consulta impresa.
                </p>
            </div>
            <a href="{{ route('medico.pacientes.index') }}" class="btn-primary" style="width: 100%; justify-content: center;">
                <i class="fa-solid fa-arrow-right"></i> Ver Pacientes para Exportar
            </a>
        </div>

        <div class="report-card-modern">
            <div>
                <div class="report-card-top">
                    <div class="report-icon-box" style="background: #fef2f2; color: #dc2626; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="report-card-heading">Pacientes en Riesgo Alto</h3>
                </div>
                <p class="report-card-body-text">
                    Filtra y revisa de forma prioritaria a los pacientes clasificados con riesgo crítico para agendar citas de control urgente o reajustar dosis terapéuticas.
                </p>
            </div>
            <a href="{{ route('medico.pacientes.index', ['riesgo' => 'alto']) }}" class="btn-primary" style="width: 100%; justify-content: center; background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);">
                <i class="fa-solid fa-filter"></i> Filtrar Casos Críticos ({{ $riesgoAlto }})
            </a>
        </div>

        <div class="report-card-modern">
            <div>
                <div class="report-card-top">
                    <div class="report-icon-box" style="background: #ecfdf5; color: #059669; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="report-card-heading">Evolución y Gráficas</h3>
                </div>
                <p class="report-card-body-text">
                    Monitorea la serie temporal de mediciones de signos vitales, detectando variaciones bruscas o tendencias anómalas en los últimos 7 a 30 días.
                </p>
            </div>
            <a href="{{ route('medico.pacientes.index') }}" class="btn-primary" style="width: 100%; justify-content: center; background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                <i class="fa-solid fa-chart-pie"></i> Ir al Monitoreo
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchTab(tabId, triggerBtn) {
        // Remover clase activa de todos los botones y paneles
        document.querySelectorAll('.tab-btn-pill').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-panel-container').forEach(panel => panel.classList.remove('active'));

        // Activar el seleccionado
        triggerBtn.classList.add('active');
        const activePanel = document.getElementById('panel-' + tabId);
        if (activePanel) {
            activePanel.classList.add('active');
        }
    }
</script>
@endpush
