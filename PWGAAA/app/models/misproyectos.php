<?php
require_once __DIR__ . '/../../config/database.php';

class MisProyectosModel {
    public static function obtenerProyectosPorUsuario($usuarioId, $rol) {
        $db = conectarDB();
        if ($rol === 'alumno') {
            // Para alumnos: se unen las tablas tfgs y notas para obtener el proyecto y la nota asignada.
            $query = "SELECT t.*, n.nota 
                      FROM tfgs t 
                      JOIN notas n ON t.id = n.tfg_id 
                      WHERE n.alumno_id = :usuarioId 
                      ORDER BY t.fecha_subida DESC";
            $stmt = $db->prepare($query);
            $stmt->execute([':usuarioId' => $usuarioId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
