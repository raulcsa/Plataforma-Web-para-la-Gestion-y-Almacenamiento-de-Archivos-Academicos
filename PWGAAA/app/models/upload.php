<?php
require_once __DIR__ . '/../../config/database.php';

class Archivo {
    /**
     * Inserta un registro en la tabla archivos.
     *
     * @param int $tfg_id
     * @param string $nombreArchivo Nombre original del archivo.
     * @param string $rutaArchivo Ruta (relativa) donde se almacenó el archivo.
     * @param string $tipo MIME type del archivo.
     * @param int $tamaño Tamaño en bytes.
     * @param string|null $descripcion Descripción del archivo.
     */
    public static function subir($tfg_id, $nombreArchivo, $rutaArchivo, $tipo, $tamaño, $descripcion = null) {
        $conexion = conectarDB();
        $sql = "INSERT INTO archivos (tfg_id, nombre, ruta, tipo, tamaño, descripcion)
                VALUES (:tfg_id, :nombre, :ruta, :tipo, :tamaño, :descripcion)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':tfg_id'      => $tfg_id,
            ':nombre'      => $nombreArchivo,
            ':ruta'        => $rutaArchivo,
            ':tipo'        => $tipo,
            ':tamaño'      => $tamaño,
            ':descripcion' => $descripcion
        ]);
    }
}
