<?php

namespace Tests\Feature;

use App\Models\Medico;
use App\Models\MetricaPaciente;
use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MedicoAlertasTest extends TestCase
{
    use DatabaseTransactions;

    public function test_alertas_usan_rangos_individuales_por_paciente(): void
    {
        foreach ([2 => 'Medico de prueba', 3 => 'Paciente de prueba'] as $id => $nombre) {
            DB::table('roles')->insertOrIgnore([
                'id' => $id,
                'nombre' => $nombre,
                'descripcion' => 'Rol para pruebas',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $metricaId = DB::table('metricas')->insertGetId([
            'nombre' => 'Métrica de prueba de alertas',
            'unidad_medida' => 'u',
            'rango_min_normal' => 80,
            'rango_max_normal' => 120,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $medico = $this->crearMedico('medico_alertas');
        $otroMedico = $this->crearMedico('otro_medico_alertas');

        $pacienteDentroDelRango = $this->crearPaciente($medico, 'lectura_en_rango');
        $pacienteFueraDelRango = $this->crearPaciente($medico, 'lectura_fuera_rango');
        $pacienteDebajoDelRango = $this->crearPaciente($medico, 'lectura_bajo_rango');
        $pacienteRangoAmplio = $this->crearPaciente($medico, 'lectura_rango_amplio');
        $pacienteRangoNormal = $this->crearPaciente($medico, 'lectura_rango_normal');
        $pacienteOtroMedico = $this->crearPaciente($otroMedico, 'lectura_otro_medico');

        $lecturaEnRangoId = $this->crearLectura($pacienteDentroDelRango, $metricaId, 125);
        $lecturaFueraRangoId = $this->crearLectura($pacienteFueraDelRango, $metricaId, 135);
        $lecturaBajoRangoId = $this->crearLectura($pacienteDebajoDelRango, $metricaId, 70);
        $lecturaRangoAmplioId = $this->crearLectura($pacienteRangoAmplio, $metricaId, 135);
        $lecturaRangoNormalId = $this->crearLectura($pacienteRangoNormal, $metricaId, 125);
        $lecturaOtroMedicoId = $this->crearLectura($pacienteOtroMedico, $metricaId, 125);

        $this->actingAs($medico->usuario)->put(route('medico.pacientes.alertas.rangos.update', $pacienteDentroDelRango->id), [
            'rangos' => [
                ['metrica_id' => $metricaId, 'min' => 80, 'max' => 130],
            ],
        ])->assertRedirect(route('medico.pacientes.show', $pacienteDentroDelRango->id));

        $this->assertDatabaseHas('paciente_metrica_alertas', [
            'paciente_id' => $pacienteDentroDelRango->id,
            'metrica_id' => $metricaId,
            'rango_min' => 80,
            'rango_max' => 130,
        ]);

        $this->actingAs($medico->usuario)->put(route('medico.pacientes.alertas.rangos.update', $pacienteDentroDelRango->id), [
            'rangos' => [
                ['metrica_id' => $metricaId, 'min' => 140, 'max' => 130],
            ],
        ])->assertSessionHasErrors('rangos');

        $this->assertDatabaseHas('paciente_metrica_alertas', [
            'paciente_id' => $pacienteDentroDelRango->id,
            'metrica_id' => $metricaId,
            'rango_min' => 80,
            'rango_max' => 130,
        ]);

        $this->actingAs($medico->usuario)->put(route('medico.pacientes.alertas.rangos.update', $pacienteRangoAmplio->id), [
            'rangos' => [
                ['metrica_id' => $metricaId, 'min' => 80, 'max' => 150],
            ],
        ])->assertRedirect(route('medico.pacientes.show', $pacienteRangoAmplio->id));

        $this->actingAs($medico->usuario)->put(route('medico.pacientes.alertas.rangos.update', $pacienteOtroMedico->id), [
            'rangos' => [
                ['metrica_id' => $metricaId, 'min' => 80, 'max' => 130],
            ],
        ])->assertNotFound();

        $this->actingAs($medico->usuario)->get(route('medico.reportes'))
            ->assertOk()
            ->assertViewHas('alertasRecientes', function ($alertas) use (
                $lecturaEnRangoId,
                $lecturaFueraRangoId,
                $lecturaBajoRangoId,
                $lecturaRangoAmplioId,
                $lecturaRangoNormalId,
                $lecturaOtroMedicoId
            ) {
                $ids = $alertas->pluck('id');

                return !$ids->contains($lecturaEnRangoId)
                    && $ids->contains($lecturaFueraRangoId)
                    && $ids->contains($lecturaBajoRangoId)
                    && !$ids->contains($lecturaRangoAmplioId)
                    && $ids->contains($lecturaRangoNormalId)
                    && !$ids->contains($lecturaOtroMedicoId);
            });

        $this->actingAs($medico->usuario)->get(route('medico.pacientes.show', [
            'id' => $pacienteDentroDelRango->id,
            'metrica_id' => $metricaId,
        ]))
            ->assertOk()
            ->assertSee('Alertas de este paciente')
            ->assertViewHas('rangosAlertas', fn ($rangos) => (float) $rangos[$metricaId]['max'] === 130.0);
    }

    private function crearMedico(string $prefijo): Medico
    {
        $usuario = Usuario::create([
            'primer_nombre' => 'Doctor',
            'apellido_paterno' => 'Prueba',
            'apellido_materno' => 'Alertas',
            'rol_id' => 2,
            'email' => $prefijo . '_' . uniqid() . '@example.com',
            'password' => 'password',
        ]);

        return Medico::create([
            'usuario_id' => $usuario->id,
            'cedula_profesional' => uniqid('cedula_'),
            'especialidad' => 'Cardiología',
            'telefono' => '5551234567',
            'consultorio' => '1',
            'turno' => 'Matutino',
        ])->setRelation('usuario', $usuario);
    }

    private function crearPaciente(Medico $medico, string $prefijo): Paciente
    {
        $usuario = Usuario::create([
            'primer_nombre' => $prefijo,
            'apellido_paterno' => 'Paciente',
            'apellido_materno' => 'Prueba',
            'rol_id' => 3,
            'email' => $prefijo . '_' . uniqid() . '@example.com',
            'password' => 'password',
        ]);

        $paciente = Paciente::create([
            'usuario_id' => $usuario->id,
            'medico_id' => $medico->id,
            'fecha_nacimiento' => '1980-01-01',
            'telefono_emergencia' => '5551234567',
            'sexo' => 'Masculino',
            'estatura' => 1.75,
            'diagnostico_principal' => 'Hipertensión',
        ]);

        $paciente->medicos()->attach($medico->id, ['es_principal' => true]);

        return $paciente;
    }

    private function crearLectura(Paciente $paciente, int $metricaId, float $valor): int
    {
        return MetricaPaciente::create([
            'paciente_id' => $paciente->id,
            'tipo_metrica_id' => $metricaId,
            'valor' => $valor,
            'fecha_registro' => now(),
        ])->id;
    }
}
