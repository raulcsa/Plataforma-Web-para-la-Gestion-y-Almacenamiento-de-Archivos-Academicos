<?php
require_once __DIR__ . '/../../config/database.php';

class Tfg {
    public static function buscar($campo = 'titulo', $buscar = '') {
        $conexion = conectarDB();
        $allowedFields = ['titulo', 'fecha', 'palabras_clave', 'integrantes'];
        if (!in_array($campo, $allowedFields)) {
            $campo = 'titulo';
        }
        $whereClause = "";
        $parametros = null;
        if (!empty($buscar)) {
            $whereClause = "WHERE $campo LIKE ?";
            $parametros = ["%$buscar%"];
        }
        $sql = "SELECT titulo, fecha, resumen, integrantes, palabras_clave FROM tfgs $whereClause";
        $stmt = $conexion->prepare($sql);
        $stmt->execute($parametros);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
