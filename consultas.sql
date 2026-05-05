-- Vistas para obtener el total de pacientes registrados en el sistema
CREATE VIEW total_pacientes AS
SELECT COUNT(usuarios.id) AS total
FROM usuarios
INNER JOIN roles ON usuarios.rol_id = roles.id
WHERE roles.nombre = 'Paciente';