<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            
            $table->string('primer_nombre', 50);
            $table->string('segundo_nombre', 50)->nullable();
            $table->string('apellido_paterno', 50);
            $table->string('apellido_materno', 50);

            $table->foreignId('rol_id')
                ->constrained('roles')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->string('email', 50)->unique();
            $table->string('password', 255);

            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamp('ultimo_acceso')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};