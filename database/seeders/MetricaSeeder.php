<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetricaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metricas = [
            [
                'nombre' => 'Presión Arterial Sistólica',
                'unidad_medida' => 'mmHg',
                'rango_min_normal' => 90.00,
                'rango_max_normal' => 120.00,
                'created_at' => now(),
            ],
            [
                'nombre' => 'Presión Arterial Diastólica',
                'unidad_medida' => 'mmHg',
                'rango_min_normal' => 60.00,
                'rango_max_normal' => 80.00,
                'created_at' => now(),
            ],
            [
                'nombre' => 'Glucosa en Sangre',
                'unidad_medida' => 'mg/dL',
                'rango_min_normal' => 70.00,
                'rango_max_normal' => 100.00,
                'created_at' => now(),
            ],
            [
                'nombre' => 'Peso Corporal',
                'unidad_medida' => 'kg',
                'rango_min_normal' => null, // El IMC varía por paciente
                'rango_max_normal' => null, 
                'created_at' => now(),
            ],
            [
                'nombre' => 'Frecuencia Cardíaca',
                'unidad_medida' => 'lpm',
                'rango_min_normal' => 60.00,
                'rango_max_normal' => 100.00,
                'created_at' => now(),
            ],
        ];

        DB::table('metricas')->insert($metricas);
    }
}