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

-- Vistas para obtener el total de pacientes por diagnóstico principal
CREATE VIEW pacientes_estado AS
SELECT 
    usuarios.id,
    CONCAT(usuarios.primer_nombre, ' ', usuarios.apellido_paterno) AS nombre_completo,
    pacientes.fecha_nacimiento,
    pacientes.diagnostico_principal, 
    pacientes.nivel_riesgo,
    pacientes.estado,
    pacientes.sexo
FROM usuarios
INNER JOIN pacientes ON usuarios.id = pacientes.usuario_id
WHERE usuarios.estado = 'Activo'
ORDER BY usuarios.created_at;

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

