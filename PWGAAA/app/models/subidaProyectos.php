<?php
require_once __DIR__ . '/../../config/database.php';

class uploadTfg {

    public static function obtenerAlumnos() {
        $db = conectarDB();
        $stmt = $db->query("SELECT id, nombre FROM usuarios WHERE rol = 'alumno'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insertarTFG($titulo, $fecha, $resumen, $keywords) {
        $db = conectarDB();
        $stmt = $db->prepare("INSERT INTO tfgs (titulo, fecha, resumen, palabras_clave) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $fecha, $resumen, $keywords]);
        return $db->lastInsertId(); // ID del TFG recién insertado
    }

    public static function asociarAlumnos($tfg_id, $alumnos) {
        $db = conectarDB();
        $stmt = $db->prepare("INSERT INTO alumno_tfg (alumno_id, tfg_id) VALUES (?, ?)");
        foreach ($alumnos as $alumno_id) {
            $stmt->execute([$alumno_id, $tfg_id]);
        }
    }

    public static function registrarArchivo($tfg_id, $nombre, $ruta, $tipo, $tamaño) {
        $db = conectarDB();
        $stmt = $db->prepare("INSERT INTO archivos (tfg_id, nombre, ruta, tipo, tamaño) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$tfg_id, $nombre, $ruta, $tipo, $tamaño]);
    }
}
