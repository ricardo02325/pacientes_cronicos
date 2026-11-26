<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('paciente_metrica_alertas')) {
            Schema::create('paciente_metrica_alertas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
                $table->foreignId('metrica_id')->constrained('metricas')->cascadeOnDelete();
                $table->decimal('rango_min', 9, 2)->nullable();
                $table->decimal('rango_max', 9, 2)->nullable();
                $table->timestamps();

                $table->unique(['paciente_id', 'metrica_id']);
            });
        }

        if (!Schema::hasTable('medico_metrica_alertas')) {
            return;
        }

        $asignaciones = DB::table('pacientes')
            ->leftJoin('medico_paciente', 'medico_paciente.paciente_id', '=', 'pacientes.id')
            ->select([
                'pacientes.id as paciente_id',
                'pacientes.medico_id',
                'medico_paciente.medico_id as medico_asignado_id',
            ])
            ->orderBy('pacientes.id')
            ->orderByDesc('medico_paciente.es_principal')
            ->orderBy('medico_paciente.medico_id')
            ->get()
            ->groupBy('paciente_id');

        foreach ($asignaciones as $pacienteId => $asignacionesPaciente) {
            $asignacion = $asignacionesPaciente->first();
            $medicoId = $asignacion->medico_asignado_id ?? $asignacion->medico_id;

            if (!$medicoId) {
                continue;
            }

            $configuraciones = DB::table('medico_metrica_alertas')
                ->where('medico_id', $medicoId)
                ->get();

            foreach ($configuraciones as $configuracion) {
                DB::table('paciente_metrica_alertas')->insert([
                    'paciente_id' => $pacienteId,
                    'metrica_id' => $configuracion->metrica_id,
                    'rango_min' => $configuracion->rango_min,
                    'rango_max' => $configuracion->rango_max,
                    'created_at' => $configuracion->created_at,
                    'updated_at' => $configuracion->updated_at,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('paciente_metrica_alertas');
    }
};
