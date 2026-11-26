<?php

namespace Tests\Feature;

use App\Models\Metrica;
use App\Models\Role;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MobileApiTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Test de consulta del catálogo de métricas.
     */
    public function test_catalogo_metricas_retorna_exitosamente(): void
    {
        $response = $this->getJson('/api/v1/catalogos/metricas');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id', 'nombre', 'unidad_medida', 'rango_min_normal', 'rango_max_normal']
                ]
            ]);
    }

    /**
     * Test de auto-registro del paciente desde la app móvil.
     */
    public function test_paciente_puede_auto_registrarse_desde_la_app(): void
    {
        $email = 'paciente_test_' . time() . '@example.com';

        $payload = [
            'primer_nombre'         => 'Carlos',
            'segundo_nombre'        => 'Eduardo',
            'apellido_paterno'      => 'Gómez',
            'apellido_materno'      => 'López',
            'email'                 => $email,
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'fecha_nacimiento'      => '1985-06-15',
            'telefono_emergencia'   => '5551234567',
            'sexo'                  => 'Masculino',
            'estatura'              => 1.75,
            'diagnostico_principal' => 'Hipertensión',
        ];

        $response = $this->postJson('/api/v1/auth/register-paciente', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'token',
                    'token_type',
                    'usuario' => ['id', 'nombre_completo', 'email', 'rol_id'],
                    'paciente'
                ]
            ]);

        $this->assertDatabaseHas('usuarios', [
            'email'  => $email,
            'rol_id' => 3,
        ]);

        $this->assertDatabaseHas('pacientes', [
            'sexo'     => 'Masculino',
            'estatura' => 1.75,
        ]);
    }

    public function test_registro_rechaza_diagnosticos_fuera_del_catalogo(): void
    {
        $response = $this->postJson('/api/v1/auth/register-paciente', [
            'primer_nombre'         => 'Lucía',
            'apellido_paterno'      => 'López',
            'email'                 => 'paciente_diagnostico_' . time() . '@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'fecha_nacimiento'      => '1985-06-15',
            'telefono_emergencia'   => '5551234567',
            'sexo'                  => 'Femenino',
            'estatura'              => 1.65,
            'diagnostico_principal' => 'Asma',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('diagnostico_principal');
    }

    /**
     * Test de login y registro de métrica con token Sanctum.
     */
    public function test_paciente_puede_iniciar_sesion_y_registrar_metrica(): void
    {
        $email = 'paciente_metricas_' . time() . '@example.com';

        // 1. Registrar
        $regResponse = $this->postJson('/api/v1/auth/register-paciente', [
            'primer_nombre'         => 'Ana',
            'apellido_paterno'      => 'Ruiz',
            'email'                 => $email,
            'password'              => 'segura1234',
            'password_confirmation' => 'segura1234',
            'fecha_nacimiento'      => '1990-03-20',
            'telefono_emergencia'   => '5559876543',
            'sexo'                  => 'Femenino',
            'estatura'              => 1.62,
            'diagnostico_principal' => 'Diabetes tipo 2',
        ]);

        $regResponse->assertStatus(201);
        $token = $regResponse->json('data.token');

        // 2. Obtener una métrica del catálogo (ej. Glucosa o primera disponible)
        $metrica = Metrica::first();
        $this->assertNotNull($metrica, 'Debe haber al menos una métrica en el catálogo');

        // 3. Registrar métrica enviando token Bearer
        $metricResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/metricas', [
                'tipo_metrica_id' => $metrica->id,
                'valor'           => 110.5,
                'notas'           => 'Medición en ayunas desde app móvil',
            ]);

        $metricResponse->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => ['id', 'tipo_nombre', 'unidad_medida', 'valor', 'estado', 'fecha_registro']
            ]);

        // 4. Consultar resumen dashboard
        $dashResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/metricas/resumen-dashboard');

        $dashResponse->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'paciente',
                    'metricas_resumen'
                ]
            ]);

        // 5. Cerrar sesión
        $logoutResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/logout');

        $logoutResponse->assertStatus(200)
            ->assertJson(['success' => true]);
    }
}
