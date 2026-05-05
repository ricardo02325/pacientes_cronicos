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
    CONCAT(usuarios.primer_nombre, ' ', usuarios.apellido_paterno) AS nombre_completo,
    pacientes.fecha_nacimiento,
    pacientes.diagnostico_principal, 
    pacientes.nivel_riesgo,
    pacientes.sexo
FROM usuarios
INNER JOIN pacientes ON usuarios.id = pacientes.usuario_id
ORDER BY usuarios.created_at;