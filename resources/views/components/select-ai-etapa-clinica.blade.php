@props([
    'name' => 'etapa_clinica',
    'id' => 'select_etapa_clinica',
    'selected' => '',
    'label' => 'Etapa Clínica & Protocolo de Monitoreo',
    'required' => false
])

<div 
    x-data="selectAiClinical({
        currentPhase: '{{ old($name, $selected) }}'
    })"
    class="w-full max-w-4xl mx-auto space-y-4 font-sans select-ai-container"
>
    <!-- Encabezado del Campo con Badge AI -->
    <div class="flex flex-wrap items-center justify-between gap-2">
        <label for="{{ $id }}" class="flex items-center gap-2 text-sm font-semibold text-slate-800 dark:text-slate-200">
            <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400 border border-blue-200/60 dark:border-blue-800/60 shadow-xs">
                <i class="fa-solid fa-notes-medical text-xs"></i>
            </span>
            <span>{{ $label }}</span>
            @if($required)
                <span class="text-rose-500 font-bold">*</span>
            @endif
        </label>

        <!-- Indicador de Asistente IA -->
        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full bg-linear-to-r from-blue-500/10 via-indigo-500/10 to-teal-500/10 border border-blue-200/50 dark:border-blue-800/50 text-blue-700 dark:text-blue-300 backdrop-blur-xs">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
            </span>
            <i class="fa-solid fa-wand-magic-sparkles text-[10px]"></i>
            <span class="tracking-wide uppercase text-[10px] font-bold">Protocolos Sugeridos por IA</span>
        </div>
    </div>

    <!-- Menú Desplegable Principal -->
    <div class="relative group">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-600 transition-colors">
            <i class="fa-solid fa-diagram-project text-sm"></i>
        </div>

        <select
            name="{{ $name }}"
            id="{{ $id }}"
            x-model="currentPhase"
            @change="onPhaseChange"
            {{ $required ? 'required' : '' }}
            class="block w-full pl-10 pr-10 py-3 text-sm font-medium rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 shadow-xs hover:border-slate-400 dark:hover:border-slate-600 focus:outline-hidden focus:ring-3 focus:ring-blue-500/20 focus:border-blue-600 transition-all duration-200 cursor-pointer appearance-none"
        >
            <option value="" disabled :selected="!currentPhase">
                -- Seleccionar fase clínica del paciente (Guía ADA / KDIGO) --
            </option>
            <template x-for="(phase, key) in phases" :key="key">
                <option :value="key" x-text="phase.name" :selected="currentPhase === key"></option>
            </template>
        </select>

        <!-- Indicador de Flecha Desplegable -->
        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
            <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 group-focus-within:rotate-180"></i>
        </div>
    </div>

    <!-- Panel de Estado Vacío (Sin fase seleccionada) -->
    <div 
        x-show="!currentPhase" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="p-4 rounded-xl border border-dashed border-slate-300 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-900/40 text-slate-500 dark:text-slate-400 text-xs flex items-center gap-3"
    >
        <div class="p-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xs text-blue-500">
            <i class="fa-solid fa-info text-sm"></i>
        </div>
        <div>
            <span class="font-semibold text-slate-700 dark:text-slate-300">Asignación de Protocolo:</span> 
            Al seleccionar la etapa clínica, el sistema precargará las métricas obligatorias, frecuencias de toma sugeridas y umbrales críticos de alarma médica.
        </div>
    </div>

    <!-- Tarjeta Informativa Asistida por IA (Se despliega al seleccionar) -->
    <div 
        x-show="currentPhase && activePhaseData" 
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2 scale-[0.99]"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        class="overflow-hidden rounded-2xl border transition-all duration-300 shadow-md backdrop-blur-md"
        :class="activePhaseData ? activePhaseData.cardBorder : ''"
    >
        <!-- Header de la Tarjeta con Badges de Riesgo y Resumen -->
        <div class="p-4 sm:p-5 border-b" :class="activePhaseData ? activePhaseData.headerBg : ''">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold tracking-wide uppercase shadow-2xs"
                              :class="activePhaseData ? activePhaseData.riskBadgeClass : ''"
                              x-text="activePhaseData ? activePhaseData.riskLevel : ''">
                        </span>
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400" x-text="activePhaseData ? activePhaseData.code : ''"></span>
                    </div>
                    <h4 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i :class="activePhaseData ? activePhaseData.icon : ''" class="text-sm"></i>
                        <span x-text="activePhaseData ? activePhaseData.title : ''"></span>
                    </h4>
                    <p class="text-xs text-slate-600 dark:text-slate-300" x-text="activePhaseData ? activePhaseData.description : ''"></p>
                </div>

                <!-- Resumen de frecuencia requerida -->
                <div class="self-start sm:self-center shrink-0 px-3 py-1.5 rounded-xl bg-white/80 dark:bg-slate-900/80 border border-slate-200/80 dark:border-slate-700/80 shadow-xs text-right">
                    <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Intensidad</span>
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5" x-text="activePhaseData ? activePhaseData.intensity : ''">
                    </span>
                </div>
            </div>
        </div>

        <!-- Cuerpo: Listado de Mediciones Necesarias (Métricas) -->
        <div class="p-4 sm:p-5 bg-white dark:bg-slate-900 space-y-4">
            <div class="flex items-center justify-between">
                <h5 class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-list-check text-blue-600"></i>
                    <span>Mediciones Necesarias & Rangos de Control</span>
                </h5>
                <span class="text-[11px] text-slate-400">Sincronización automática de telemonitoreo</span>
            </div>

            <!-- Grid de Mediciones Clínicas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <template x-for="(metric, idx) in (activePhaseData ? activePhaseData.metrics : [])" :key="idx">
                    <div class="p-3.5 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors flex flex-col justify-between space-y-2.5">
                        
                        <!-- Título de la Métrica & Icono -->
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs shadow-2xs"
                                      :class="metric.iconBg">
                                    <i :class="metric.icon"></i>
                                </span>
                                <div>
                                    <h6 class="text-xs font-bold text-slate-900 dark:text-slate-100" x-text="metric.name"></h6>
                                    <span class="text-[10px] text-slate-500 dark:text-slate-400" x-text="metric.frequency"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Valores Objetivo / Rangos Esperados -->
                        <div class="p-2.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200/70 dark:border-slate-800 space-y-1.5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-[10px] font-semibold text-slate-500 uppercase">Objetivo:</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400" x-text="metric.target"></span>
                            </div>

                            <div x-show="metric.alert" class="flex items-center justify-between text-[11px] pt-1 border-t border-slate-100 dark:border-slate-800">
                                <span class="text-[10px] font-semibold text-rose-500 uppercase flex items-center gap-1">
                                    <i class="fa-solid fa-triangle-exclamation text-[9px]"></i> Alerta:
                                </span>
                                <span class="font-medium text-rose-600 dark:text-rose-400 text-right" x-text="metric.alert"></span>
                            </div>
                        </div>

                        <!-- Nota clínica contextual -->
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-tight italic" x-text="metric.note"></p>
                    </div>
                </template>
            </div>

            <!-- Footer Informativo / Aviso Clínico -->
            <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800/80 text-[11px] text-slate-500 dark:text-slate-400">
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-halved text-blue-500"></i>
                    <span>Parámetros basados en criterios ADA (Standards of Care) & KDIGO.</span>
                </span>
                <span class="font-mono text-[10px] bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded text-slate-600 dark:text-slate-300">
                    ID Backend: <strong x-text="currentPhase"></strong>
                </span>
            </div>
        </div>
    </div>
</div>

<script>
    function selectAiClinical(config) {
        return {
            currentPhase: config.currentPhase || '',
            phases: {
                fase_1: {
                    code: 'Fase 01',
                    name: 'Fase 1: Prediabetes / Resistencia a la Insulina',
                    title: 'Prediabetes y Resistencia a la Insulina',
                    riskLevel: 'Riesgo Preventivo',
                    intensity: 'Monitoreo Periódico',
                    icon: 'fa-solid fa-seedling text-teal-600',
                    cardBorder: 'border-teal-200 dark:border-teal-900/60 shadow-teal-500/5',
                    headerBg: 'bg-teal-50/70 dark:bg-teal-950/30 border-teal-100 dark:border-teal-900/40',
                    riskBadgeClass: 'bg-teal-100 text-teal-800 border border-teal-200 dark:bg-teal-900/50 dark:text-teal-300',
                    description: 'Enfoque en intervención de estilo de vida, reversión de resistencia periférica y prevención de progresión.',
                    metrics: [
                        {
                            name: 'Glucosa en Ayunas',
                            frequency: 'Control semanal / quincenal',
                            icon: 'fa-solid fa-droplet',
                            iconBg: 'bg-teal-100 text-teal-700 dark:bg-teal-950 dark:text-teal-400',
                            target: '70 - 99 mg/dL',
                            alert: '100 - 125 mg/dL',
                            note: 'Normal: 70-99 mg/dL. Rango de alerta de alteración: 100-125 mg/dL.'
                        },
                        {
                            name: 'IMC y Peso Corporal',
                            frequency: 'Registro quincenal',
                            icon: 'fa-solid fa-weight-scale',
                            iconBg: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400',
                            target: 'IMC 18.5 - 24.9',
                            alert: 'IMC ≥ 25 (Sobrepeso/Obesidad)',
                            note: 'Control y reducción del perímetro abdominal y grasa visceral.'
                        },
                        {
                            name: 'Presión Arterial',
                            frequency: 'Control basal / mensual',
                            icon: 'fa-solid fa-heart-pulse',
                            iconBg: 'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-400',
                            target: '< 120/80 mmHg',
                            alert: '≥ 130/80 mmHg',
                            note: 'Monitoreo preventivo ante síndrome metabólico temprano.'
                        }
                    ]
                },
                fase_2: {
                    code: 'Fase 02',
                    name: 'Fase 2: Diabetes Tipo 2 (Inicial / Controlada con dieta y orales)',
                    title: 'Diabetes Tipo 2 — Control Inicial / Farmacológico Oral',
                    riskLevel: 'Riesgo Moderado',
                    intensity: 'Monitoreo Semanal',
                    icon: 'fa-solid fa-capsules text-blue-600',
                    cardBorder: 'border-blue-200 dark:border-blue-900/60 shadow-blue-500/5',
                    headerBg: 'bg-blue-50/70 dark:bg-blue-950/30 border-blue-100 dark:border-blue-900/40',
                    riskBadgeClass: 'bg-blue-100 text-blue-800 border border-blue-200 dark:bg-blue-900/50 dark:text-blue-300',
                    description: 'Manejo con antidiabéticos orales y plan nutricional. Énfasis en prevención de picos y control tensional estricto.',
                    metrics: [
                        {
                            name: 'Glucosa Capilar Ayunas',
                            frequency: 'Ayunas (3-4 veces por semana)',
                            icon: 'fa-solid fa-droplet',
                            iconBg: 'bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-400',
                            target: '80 - 130 mg/dL',
                            alert: '> 140 mg/dL o < 70 mg/dL',
                            note: 'Rango objetivo estándar ADA para paciente diabético adulto controlado.'
                        },
                        {
                            name: 'Presión Arterial Sist/Diast',
                            frequency: 'Registro semanal',
                            icon: 'fa-solid fa-heart-pulse',
                            iconBg: 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-400',
                            target: '< 130/80 mmHg',
                            alert: '≥ 130/80 mmHg',
                            note: 'Objetivo estricto para mitigar comorbilidad por hipertensión asociada.'
                        },
                        {
                            name: 'Peso Corporal Mensual',
                            frequency: 'Registro cada 30 días',
                            icon: 'fa-solid fa-weight-scale',
                            iconBg: 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                            target: 'Mantenimiento / Reducción 5%',
                            alert: 'Ganancia ponderal brusca',
                            note: 'Evaluación del impacto de la terapia farmacológica y respuesta metabólica.'
                        }
                    ]
                },
                fase_3: {
                    code: 'Fase 03',
                    name: 'Fase 3: Diabetes Tipo 2 (Avanzada / Insulinodependiente o Descontrolada)',
                    title: 'Diabetes Tipo 2 — Avanzada / Insulina / Descontrol',
                    riskLevel: 'Riesgo Alto',
                    intensity: 'Monitoreo Diario Intensivo',
                    icon: 'fa-solid fa-syringe text-amber-600',
                    cardBorder: 'border-amber-200 dark:border-amber-900/60 shadow-amber-500/5',
                    headerBg: 'bg-amber-50/70 dark:bg-amber-950/30 border-amber-100 dark:border-amber-900/40',
                    riskBadgeClass: 'bg-amber-100 text-amber-800 border border-amber-200 dark:bg-amber-900/50 dark:text-amber-300',
                    description: 'Paciente con esquemas de insulina basal/bolos o falla terapéutica oral. Riesgo cardiovascular significativamente alto.',
                    metrics: [
                        {
                            name: 'Glucosa Capilar Múltiple',
                            frequency: 'Preprandial & Postprandial (1-2h)',
                            icon: 'fa-solid fa-chart-line',
                            iconBg: 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400',
                            target: '< 180 mg/dL (Postprandial)',
                            alert: '> 180 mg/dL ó < 70 mg/dL (Hipoglucemia)',
                            note: 'Monitoreo preprandial (80-130) y 1-2 horas tras comidas (<180 mg/dL).'
                        },
                        {
                            name: 'Presión Arterial Diaria',
                            frequency: 'Diario (Misma hora)',
                            icon: 'fa-solid fa-heart-pulse',
                            iconBg: 'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-400',
                            target: '< 130/80 mmHg',
                            alert: '≥ 140/90 mmHg',
                            note: 'Control diario imperativo por elevado riesgo micro y macrovascular.'
                        },
                        {
                            name: 'Síntomas de Hipoglucemia',
                            frequency: 'Monitoreo continuo de eventos',
                            icon: 'fa-solid fa-triangle-exclamation',
                            iconBg: 'bg-orange-100 text-orange-700 dark:bg-orange-950 dark:text-orange-400',
                            target: '0 episodios semanales',
                            alert: 'Diaforesis, temblor, mareo',
                            note: 'Ajuste dinámico de dosis de insulina para prevenir eventos graves.'
                        }
                    ]
                },
                fase_4: {
                    code: 'Fase 04',
                    name: 'Fase 4: Diabetes con Complicaciones Crónicas (Nefropatía / Daño Renal)',
                    title: 'Complicaciones Crónicas — Nefropatía & Daño Renal',
                    riskLevel: 'Riesgo Crítico Orgánico',
                    intensity: 'Telemonitoreo Diario Estricto',
                    icon: 'fa-solid fa-lungs-virus text-rose-600',
                    cardBorder: 'border-rose-300 dark:border-rose-900/70 shadow-rose-500/10',
                    headerBg: 'bg-rose-50/80 dark:bg-rose-950/40 border-rose-200 dark:border-rose-900/50',
                    riskBadgeClass: 'bg-rose-100 text-rose-800 border border-rose-300 dark:bg-rose-900/60 dark:text-rose-200',
                    description: 'Afectación renal establecida (TFG reducida / albuminuria). Monitoreo enfocado en protección nefronal y volemia.',
                    metrics: [
                        {
                            name: 'Presión Arterial Estricta',
                            frequency: 'Diaria (2 tomas: Mañana / Noche)',
                            icon: 'fa-solid fa-heart-pulse',
                            iconBg: 'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-400',
                            target: '< 120-130 / < 80 mmHg',
                            alert: '≥ 135/85 mmHg',
                            note: 'Crítico: La hipertensión acelera la esclerosis glomerular y la falla renal terminal.'
                        },
                        {
                            name: 'Glucosa Capilar Múltiple',
                            frequency: 'Diario (Antes y después de comer)',
                            icon: 'fa-solid fa-droplet',
                            iconBg: 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-400',
                            target: 'Individualizado (90 - 150 mg/dL)',
                            alert: 'Hipoglucemia por acumulación de fármacos',
                            note: 'Mayor riesgo de hipoglucemia por disminución del aclaramiento de insulina.'
                        },
                        {
                            name: 'Peso Diario (Retención Hídrica)',
                            frequency: 'Diario en ayunas tras micción',
                            icon: 'fa-solid fa-weight-scale',
                            iconBg: 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-400',
                            target: 'Peso seco estable (±0.5 kg)',
                            alert: '+1.5 a 2 kg en 48-72h (Edema)',
                            note: 'Monitoreo de sobrecarga de volumen, edema en extremidades y falla cardíaca/renal.'
                        }
                    ]
                }
            },
            get activePhaseData() {
                return this.phases[this.currentPhase] || null;
            },
            onPhaseChange() {
                // Emite evento nativo si otros componentes necesitan reaccionar
                this.$dispatch('clinical-phase-changed', {
                    phase: this.currentPhase,
                    data: this.activePhaseData
                });
            }
        };
    }
</script>
