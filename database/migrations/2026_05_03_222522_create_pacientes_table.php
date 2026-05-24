<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->unique()
                ->constrained('usuarios')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('medico_id')
                ->constrained('medicos')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->date('fecha_nacimiento');
            $table->string('telefono_emergencia', 20);
            $table->string('sexo', 10);
            $table->decimal('estatura', 3, 2);
            $table->string('diagnostico_principal', 255);

            $table->enum('nivel_riesgo', ['Bajo', 'Medio', 'Alto'])
                ->default('Bajo');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};