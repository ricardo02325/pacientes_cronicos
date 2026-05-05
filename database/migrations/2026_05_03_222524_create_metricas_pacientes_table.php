<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metricas_pacientes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('tipo_metrica_id')
                ->constrained('metricas')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->decimal('valor', 8, 2);
            $table->dateTime('fecha_registro')->useCurrent();

            $table->string('notas', 255)->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->index(['paciente_id', 'fecha_registro']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metricas_pacientes');
    }
};