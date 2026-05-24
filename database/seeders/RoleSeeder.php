<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Gestión integral de usuarios y configuración',
                'created_at' => now(),
            ],
            [
                'nombre' => 'Médico',
                'descripcion' => 'Consulta de métricas y seguimiento de pacientes',
                'created_at' => now(),
            ],
            [
                'nombre' => 'Paciente',
                'descripcion' => 'Registro de métricas personales y consulta de historial',
                'created_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}