<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metricas', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 100)->unique();
            $table->string('unidad_medida', 20);

            $table->decimal('rango_min_normal', 7, 2)->nullable();
            $table->decimal('rango_max_normal', 7, 2)->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metricas');
    }
};