<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medico_metrica_alertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medico_id')->constrained('medicos')->cascadeOnDelete();
            $table->foreignId('metrica_id')->constrained('metricas')->cascadeOnDelete();
            $table->decimal('rango_min', 9, 2)->nullable();
            $table->decimal('rango_max', 9, 2)->nullable();
            $table->timestamps();

            $table->unique(['medico_id', 'metrica_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medico_metrica_alertas');
    }
};
