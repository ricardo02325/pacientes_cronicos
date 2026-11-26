<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Procedimiento cambiar_estado_usuario
        DB::unprepared("DROP PROCEDURE IF EXISTS cambiar_estado_usuario;");
        DB::unprepared("
            CREATE PROCEDURE cambiar_estado_usuario(
                IN p_id BIGINT,
                IN p_estado ENUM('Activo', 'Inactivo')
            )
            BEGIN
                IF EXISTS (SELECT 1 FROM usuarios WHERE id = p_id) THEN
                    UPDATE usuarios
                    SET estado = p_estado,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = p_id;
                ELSE
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'El usuario no existe';
                END IF;
            END;
        ");

        // 2. Procedimiento sp_registrar_medico
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_registrar_medico;");
        DB::unprepared("
            CREATE PROCEDURE sp_registrar_medico(
                IN p_primer_nombre VARCHAR(50),
                IN p_segundo_nombre VARCHAR(50),
                IN p_apellido_paterno VARCHAR(50),
                IN p_apellido_materno VARCHAR(50),
                IN p_rol_id BIGINT,
                IN p_email VARCHAR(50),
                IN p_password VARCHAR(255),
                IN p_cedula_profesional VARCHAR(30),
                IN p_especialidad VARCHAR(100),
                IN p_telefono VARCHAR(10),
                IN p_consultorio VARCHAR(50),
                IN p_turno ENUM('Matutino', 'Vespertino', 'Nocturno', 'Mixto'),
                IN p_observaciones TEXT
            )
            BEGIN
                DECLARE v_usuario_id BIGINT;

                INSERT INTO usuarios (
                    primer_nombre,
                    segundo_nombre,
                    apellido_paterno,
                    apellido_materno,
                    rol_id,
                    email,
                    password
                )
                VALUES (
                    p_primer_nombre,
                    NULLIF(TRIM(p_segundo_nombre), ''),
                    p_apellido_paterno,
                    p_apellido_materno,
                    p_rol_id,
                    p_email,
                    p_password
                );

                SET v_usuario_id = LAST_INSERT_ID();

                INSERT INTO medicos (
                    usuario_id,
                    cedula_profesional,
                    especialidad,
                    telefono,
                    consultorio,
                    turno,
                    observaciones
                )
                VALUES (
                    v_usuario_id,
                    p_cedula_profesional,
                    p_especialidad,
                    p_telefono,
                    NULLIF(TRIM(p_consultorio), ''),
                    p_turno,
                    NULLIF(TRIM(p_observaciones), '')
                );
            END;
        ");

        // 3. Procedimiento insertar_paciente
        DB::unprepared("DROP PROCEDURE IF EXISTS insertar_paciente;");
        DB::unprepared("
            CREATE PROCEDURE insertar_paciente (
                IN p_primer_nombre VARCHAR(50),
                IN p_segundo_nombre VARCHAR(50),
                IN p_apellido_paterno VARCHAR(50),
                IN p_apellido_materno VARCHAR(50),
                IN p_email VARCHAR(50),
                IN p_password VARCHAR(255),
                IN p_medico_id BIGINT UNSIGNED,
                IN p_fecha_nacimiento DATE,
                IN p_telefono_emergencia VARCHAR(20),
                IN p_sexo VARCHAR(10),
                IN p_diagnostico_principal VARCHAR(255),
                IN p_nivel_riesgo VARCHAR(10)
            )
            BEGIN
                DECLARE v_usuario_id BIGINT UNSIGNED;

                INSERT INTO usuarios (
                    primer_nombre,
                    segundo_nombre,
                    apellido_paterno,
                    apellido_materno,
                    rol_id,
                    email,
                    password
                )
                VALUES (
                    p_primer_nombre,
                    NULLIF(TRIM(p_segundo_nombre), ''),
                    p_apellido_paterno,
                    p_apellido_materno,
                    3,
                    p_email,
                    p_password
                );

                SET v_usuario_id = LAST_INSERT_ID();

                INSERT INTO pacientes (
                    usuario_id,
                    medico_id,
                    fecha_nacimiento,
                    telefono_emergencia,
                    sexo,
                    estatura,
                    diagnostico_principal,
                    nivel_riesgo
                )
                VALUES (
                    v_usuario_id,
                    p_medico_id,
                    p_fecha_nacimiento,
                    p_telefono_emergencia,
                    p_sexo,
                    1.70,
                    p_diagnostico_principal,
                    p_nivel_riesgo
                );
            END;
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS insertar_paciente;");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_registrar_medico;");
        DB::unprepared("DROP PROCEDURE IF EXISTS cambiar_estado_usuario;");
    }
};
