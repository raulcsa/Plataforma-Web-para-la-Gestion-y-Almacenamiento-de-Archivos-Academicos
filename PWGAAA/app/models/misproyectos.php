<?php
require_once __DIR__ . '/../../config/database.php';

class MisProyectosModel {
    public static function obtenerProyectosPorUsuario($usuarioId, $rol) {
        $db = conectarDB();

        // Buscar TFGs donde el usuario aparece como integrante (1, 2 o 3)
        $query = "SELECT t.*, n.nota, n.comentario
                  FROM tfgs t
                  LEFT JOIN notas n ON t.id = n.tfg_id AND n.alumno_id = :usuarioId
                  WHERE t.integrante1 = :usuarioId 
                     OR t.integrante2 = :usuarioId 
                     OR t.integrante3 = :usuarioId
                  ORDER BY t.fecha_subida DESC";

        $stmt = $db->prepare($query);
        $stmt->execute([':usuarioId' => $usuarioId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
