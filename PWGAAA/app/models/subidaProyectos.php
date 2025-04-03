<?php
require_once __DIR__ . '/../../config/database.php';

class uploadTfg {

    public static function obtenerAlumnos() {
        $db = conectarDB();
        $stmt = $db->query("SELECT id, nombre FROM usuarios WHERE rol = 'alumno'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ahora recibe el uploaderId y los alumnos seleccionados
    public static function insertarTFG($titulo, $resumen, $keywords, $uploaderId, $selectedAlumnos) {
        $db = conectarDB();
        $integrante2 = isset($selectedAlumnos[0]) ? $selectedAlumnos[0] : NULL;
        $integrante3 = isset($selectedAlumnos[1]) ? $selectedAlumnos[1] : NULL;
        // Usamos CURRENT_DATE para que se inserte la fecha actual en la columna 'fecha'
        $stmt = $db->prepare("INSERT INTO tfgs (titulo, fecha, resumen, palabras_clave, integrante1, integrante2, integrante3) VALUES (?, CURRENT_DATE, ?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $resumen, $keywords, $uploaderId, $integrante2, $integrante3]);
        return $db->lastInsertId();
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
