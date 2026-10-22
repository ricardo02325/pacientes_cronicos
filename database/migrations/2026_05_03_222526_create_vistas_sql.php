<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Total Pacientes
        DB::statement("
            CREATE OR REPLACE VIEW total_pacientes AS
            SELECT COUNT(usuarios.id) AS total
            FROM usuarios
            INNER JOIN roles ON usuarios.rol_id = roles.id
            WHERE roles.nombre = 'Paciente';
        ");

        // 2. Total Pacientes Riesgo Alto
        DB::statement("
            CREATE OR REPLACE VIEW total_pacientes_riesgo_alto AS
            SELECT COUNT(nivel_riesgo) AS total
            FROM pacientes
            WHERE nivel_riesgo = 'Alto';
        ");

        // 3. Total Pacientes Estables (Riesgo Bajo)
        DB::statement("
            CREATE OR REPLACE VIEW total_pacientes_estables AS
            SELECT COUNT(*) AS total
            FROM pacientes
            WHERE nivel_riesgo = 'Bajo';
        ");

        // 4. Pacientes Estado
        DB::statement("
            CREATE OR REPLACE VIEW pacientes_estado AS
            SELECT 
                usuarios.id,
                CONCAT(usuarios.primer_nombre, ' ', usuarios.apellido_paterno) AS nombre_completo,
                pacientes.fecha_nacimiento,
                pacientes.diagnostico_principal, 
                pacientes.nivel_riesgo,
                pacientes.sexo
            FROM usuarios
            INNER JOIN pacientes ON usuarios.id = pacientes.usuario_id
            WHERE usuarios.estado = 'Activo'
            ORDER BY usuarios.created_at;
        ");

        // 5. Vista Médicos
        DB::statement("
            CREATE OR REPLACE VIEW vista_medicos AS
            SELECT
                usuarios.id AS usuario_id,
                medicos.id AS medico_id,
                CONCAT(
                    usuarios.primer_nombre, ' ',
                    usuarios.apellido_paterno
                ) AS nombre_completo,
                medicos.telefono,
                usuarios.email,
                medicos.cedula_profesional,
                medicos.especialidad,
                usuarios.estado
            FROM medicos
            INNER JOIN usuarios ON medicos.usuario_id = usuarios.id;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vista_medicos;");
        DB::statement("DROP VIEW IF EXISTS pacientes_estado;");
        DB::statement("DROP VIEW IF EXISTS total_pacientes_estables;");
        DB::statement("DROP VIEW IF EXISTS total_pacientes_riesgo_alto;");
        DB::statement("DROP VIEW IF EXISTS total_pacientes;");
    }
};
