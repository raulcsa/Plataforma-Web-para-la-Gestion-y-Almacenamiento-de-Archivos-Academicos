<?php
require_once __DIR__ . '/../../config/database.php';

class Tfg {
    /**
     * Inserta un TFG y retorna el ID generado.
     *
     * @param string $titulo
     * @param string $resumen
     * @param string $palabrasClave
     * @param string|null $integrantes
     * @return int El ID del TFG insertado.
     */
    public static function crear($titulo,$fecha ,$resumen, $palabrasClave, $integrantes = null) {
        $conexion = conectarDB();
        $sql = "INSERT INTO tfgs (titulo, fecha ,resumen, palabras_clave, integrantes) 
                VALUES (:titulo, :fecha ,:resumen, :palabras_clave, :integrantes)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':fecha' => $fecha,
            ':resumen' => $resumen,
            ':palabras_clave' => $palabrasClave,
            ':integrantes' => $integrantes
        ]);
        return $conexion->lastInsertId();
    }
}
