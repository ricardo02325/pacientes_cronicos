<?php

namespace Database\Seeders;

use App\Models\Medico;
use App\Models\Metrica;
use App\Models\MetricaPaciente;
use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear Administrador
        $admin = Usuario::firstOrCreate(
            ['email' => 'admin@CroniCare.com'],
            [
                'primer_nombre' => 'Administrador',
                'segundo_nombre' => null,
                'apellido_paterno' => 'General',
                'apellido_materno' => 'CroniCare',
                'rol_id' => 1,
                'password' => Hash::make('admin123'),
                'estado' => 'Activo',
            ]
        );

        // 2. Crear Médico
        $usuarioMedico = Usuario::firstOrCreate(
            ['email' => 'medico@CroniCare.com'],
            [
                'primer_nombre' => 'Carlos',
                'segundo_nombre' => 'Eduardo',
                'apellido_paterno' => 'Hernández',
                'apellido_materno' => 'Torres',
                'rol_id' => 2,
                'password' => Hash::make('medico123'),
                'estado' => 'Activo',
            ]
        );

        $medico = Medico::firstOrCreate(
            ['usuario_id' => $usuarioMedico->id],
            [
                'cedula_profesional' => 'MED-984321',
                'especialidad' => 'Endocrinología',
                'telefono' => '3121234567',
                'consultorio' => 'Consultorio 204-B',
                'turno' => 'Matutino',
                'observaciones' => 'Especialista a cargo del programa de monitoreo crónico.',
            ]
        );

        // 3. Crear Pacientes de ejemplo
        $pacientesData = [
            [
                'nombre' => 'Juan',
                'segundo' => 'Carlos',
                'paterno' => 'Gómez',
                'materno' => 'López',
                'email' => 'juan.paciente@CroniCare.com',
                'nacimiento' => '1965-04-12',
                'telefono' => '3129876543',
                'sexo' => 'Masculino',
                'estatura' => 1.72,
                'diagnostico' => 'Diabetes Mellitus Tipo 2 e Hipertensión',
                'riesgo' => 'Alto',
            ],
            [
                'nombre' => 'María',
                'segundo' => 'Fernanda',
                'paterno' => 'Ramírez',
                'materno' => 'Castro',
                'email' => 'maria.paciente@CroniCare.com',
                'nacimiento' => '1974-08-23',
                'telefono' => '3128765432',
                'sexo' => 'Femenino',
                'estatura' => 1.60,
                'diagnostico' => 'Hipertensión Arterial Primaria',
                'riesgo' => 'Medio',
            ],
            [
                'nombre' => 'Roberto',
                'segundo' => null,
                'paterno' => 'Vargas',
                'materno' => 'Mendoza',
                'email' => 'roberto.paciente@CroniCare.com',
                'nacimiento' => '1982-11-05',
                'telefono' => '3127654321',
                'sexo' => 'Masculino',
                'estatura' => 1.78,
                'diagnostico' => 'Asma Bronquial Crónica',
                'riesgo' => 'Bajo',
            ],
        ];

        foreach ($pacientesData as $pData) {
            $userPac = Usuario::firstOrCreate(
                ['email' => $pData['email']],
                [
                    'primer_nombre' => $pData['nombre'],
                    'segundo_nombre' => $pData['segundo'],
                    'apellido_paterno' => $pData['paterno'],
                    'apellido_materno' => $pData['materno'],
                    'rol_id' => 3,
                    'password' => Hash::make('paciente123'),
                    'estado' => 'Activo',
                ]
            );

            $paciente = Paciente::firstOrCreate(
                ['usuario_id' => $userPac->id],
                [
                    'medico_id' => $medico->id,
                    'fecha_nacimiento' => $pData['nacimiento'],
                    'telefono_emergencia' => $pData['telefono'],
                    'sexo' => $pData['sexo'],
                    'estatura' => $pData['estatura'],
                    'diagnostico_principal' => $pData['diagnostico'],
                    'nivel_riesgo' => $pData['riesgo'],
                ]
            );

            // Insertar métricas de ejemplo para gráficas
            if (MetricaPaciente::where('paciente_id', $paciente->id)->count() === 0) {
                MetricaPaciente::create([
                    'paciente_id' => $paciente->id,
                    'tipo_metrica_id' => 1, // Sistólica
                    'valor' => rand(118, 145),
                    'fecha_registro' => now()->subDays(2),
                    'notas' => 'Medición rutinaria en ayunas',
                ]);

                MetricaPaciente::create([
                    'paciente_id' => $paciente->id,
                    'tipo_metrica_id' => 1, // Sistólica
                    'valor' => rand(115, 138),
                    'fecha_registro' => now()->subDay(),
                    'notas' => 'Control vespertino',
                ]);

                MetricaPaciente::create([
                    'paciente_id' => $paciente->id,
                    'tipo_metrica_id' => 1, // Sistólica
                    'valor' => rand(112, 130),
                    'fecha_registro' => now(),
                    'notas' => 'Registro matutino',
                ]);
            }
        }
    }
}
