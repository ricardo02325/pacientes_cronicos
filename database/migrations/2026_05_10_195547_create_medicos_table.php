<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicos', function (Blueprint $table) {

            $table->id();

            // Relación con la tabla usuarios
            $table->foreignId('usuario_id')
                ->unique()
                ->constrained('usuarios')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // Información profesional
            $table->string('cedula_profesional', 30)->unique();
            $table->string('especialidad', 100);

            // Información de contacto
            $table->string('telefono', 10);
            $table->string('consultorio', 50)->nullable();

            // Datos laborales
            $table->enum('turno', ['Matutino', 'Vespertino', 'Nocturno', 'Mixto'])
                ->default('Matutino');

            // Observaciones médicas o administrativas
            $table->text('observaciones')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')
                ->useCurrent()
                ->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};