<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Medico extends Model
{
    public const DIAGNOSTICOS = [
        'Hipertensión',
        'Diabetes tipo 2',
        'Obesidad',
    ];

    public const ESPECIALIDADES = [
        'Cardiología',
        'Endocrinología',
        'Medicina Bariátrica',
    ];

    protected $table = 'medicos';

    protected $fillable = [
        'usuario_id',
        'cedula_profesional',
        'especialidad',
        'telefono',
        'consultorio',
        'turno',
        'observaciones',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function pacientes(): BelongsToMany
    {
        return $this->belongsToMany(Paciente::class, 'medico_paciente')
            ->withPivot('es_principal')
            ->withTimestamps();
    }

    public static function diagnosticosParaEspecialidad(?string $especialidad): array
    {
        $especialidadNormalizada = Str::ascii(Str::lower($especialidad ?? ''));

        return match ($especialidadNormalizada) {
            'cardiologia' => ['Hipertensión'],
            'endocrinologia' => ['Diabetes tipo 2'],
            'medicina bariatrica' => ['Obesidad'],
            default => [],
        };
    }

    public static function especialidadesParaDiagnostico(?string $diagnostico): array
    {
        return array_values(array_filter(
            self::ESPECIALIDADES,
            fn (string $especialidad) => in_array(
                $diagnostico,
                self::diagnosticosParaEspecialidad($especialidad),
                true
            )
        ));
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->usuario ? $this->usuario->nombre_completo : 'Dr(a). Sin Asignar';
    }

    public function getEmailAttribute(): string
    {
        return $this->usuario ? $this->usuario->email : '';
    }

    public function getEstadoAttribute(): string
    {
        return $this->usuario ? $this->usuario->estado : 'Activo';
    }
}
