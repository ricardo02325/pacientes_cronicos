-- Vistas para obtener el total de pacientes registrados en el sistema
CREATE VIEW total_pacientes AS
SELECT COUNT(usuarios.id) AS total
FROM usuarios
INNER JOIN roles ON usuarios.rol_id = roles.id
WHERE roles.nombre = 'Paciente';

-- Vistas para obtener el total de pacientes por nivel de riesgo
CREATE VIEW total_pacientes_riesgo_alto AS
SELECT COUNT(nivel_riesgo) AS total
FROM pacientes
WHERE nivel_riesgo = 'Alto';

-- Vistas para obtener el total de pacientes por nivel de riesgo
CREATE VIEW total_pacientes_estables AS
SELECT COUNT(*) AS total
FROM pacientes
WHERE nivel_riesgo = 'Bajo';

-- Vistas para obtener el total de pacientes
CREATE VIEW pacientes_estado AS
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

-- Vista para médicos
CREATE VIEW vista_medicos AS
SELECT
    usuarios.id usuario_id,
    medicos.id medico_id,

    CONCAT(
        usuarios.primer_nombre,' ',
        usuarios.apellido_paterno
    ) nombre_completo,

    medicos.telefono,
    usuarios.email,
    medicos.cedula_profesional,
    medicos.especialidad,
    usuarios.estado

FROM medicos
INNER JOIN usuarios
    ON medicos.usuario_id = usuarios.id;
    
-- Procedimiento almacenados
-- Actualizar el estado de un usuario (Activo/Inactivo)
DELIMITER $$

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

END $$

DELIMITER ;


-- Procedimiento para registrar un nuevo médico, insertando primero en la tabla usuarios y luego en la tabla medicos
DELIMITER $$

CREATE PROCEDURE sp_registrar_medico(

    -- DATOS USUARIO
    IN p_primer_nombre VARCHAR(50),
    IN p_segundo_nombre VARCHAR(50),
    IN p_apellido_paterno VARCHAR(50),
    IN p_apellido_materno VARCHAR(50),
    IN p_rol_id BIGINT,
    IN p_email VARCHAR(50),
    IN p_password VARCHAR(255),

    -- DATOS MÉDICO
    IN p_cedula_profesional VARCHAR(30),
    IN p_especialidad VARCHAR(100),
    IN p_telefono VARCHAR(10),
    IN p_consultorio VARCHAR(50),
    IN p_turno ENUM('Matutino', 'Vespertino', 'Nocturno', 'Mixto'),
    IN p_observaciones TEXT
)

BEGIN

    DECLARE v_usuario_id BIGINT;

    -- =========================
    -- INSERTAR EN USUARIOS
    -- =========================
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

    -- OBTENER EL ID GENERADO
    SET v_usuario_id = LAST_INSERT_ID();

    -- =========================
    -- INSERTAR EN MEDICOS
    -- =========================
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

END $$

DELIMITER ;


DELIMITER $$

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

    DECLARE v_usuario_id INT UNSIGNED;

    START TRANSACTION;

    -- Insertar usuario
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
        p_segundo_nombre,
        p_apellido_paterno,
        p_apellido_materno,
        1,
        p_email,
        SHA2(p_password, 256)
    );

    SET v_usuario_id = LAST_INSERT_ID();

    -- Insertar paciente
    INSERT INTO pacientes (
        usuario_id,
        medico_id,
        fecha_nacimiento,
        telefono_emergencia,
        sexo,
        diagnostico_principal,
        nivel_riesgo
    )
    VALUES (
        v_usuario_id,
        p_medico_id,
        p_fecha_nacimiento,
        p_telefono_emergencia,
        p_sexo,
        p_diagnostico_principal,
        p_nivel_riesgo
    );

    COMMIT;

END$$

DELIMITER ;