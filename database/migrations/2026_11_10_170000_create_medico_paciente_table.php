<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medico_paciente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')
                ->constrained('medicos')
                ->cascadeOnDelete();
            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->cascadeOnDelete();
            $table->boolean('es_principal')->default(false);
            $table->timestamps();

            $table->unique(['medico_id', 'paciente_id']);
        });

        $pacientesConMedico = DB::table('pacientes')
            ->whereNotNull('medico_id')
            ->get(['id', 'medico_id']);

        foreach ($pacientesConMedico as $paciente) {
            DB::table('medico_paciente')->insertOrIgnore([
                'medico_id' => $paciente->medico_id,
                'paciente_id' => $paciente->id,
                'es_principal' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('medico_paciente');
    }
};
