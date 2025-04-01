<?php
require_once __DIR__ . '/../../config/database.php';

class Tfg {
    public static function buscar() {
        $conexion = conectarDB();
        $sql = "SELECT titulo, fecha, resumen, integrantes, palabras_clave FROM tfgs order by fecha";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
