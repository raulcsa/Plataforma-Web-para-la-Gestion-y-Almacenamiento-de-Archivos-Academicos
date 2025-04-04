<?php
require_once __DIR__ . '/../../config/database.php';

class uploadTfg {

    public static function obtenerAlumnos() {
        $db = conectarDB();
        $stmt = $db->query("SELECT id, nombre FROM usuarios WHERE rol = 'alumno'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inserta el TFG y asigna integrante1 (el uploader) y opcionalmente integrante2 y 3 de los alumnos adicionales
    public static function insertarTFG($titulo, $resumen, $keywords, $uploaderId, $selectedAlumnos) {
        $db = conectarDB();
        // Si no se selecciona ningún alumno adicional, se asignan como NULL
        $integrante2 = isset($selectedAlumnos[0]) ? $selectedAlumnos[0] : NULL;
        $integrante3 = isset($selectedAlumnos[1]) ? $selectedAlumnos[1] : NULL;
        // Insertamos el TFG; usamos CURRENT_DATE para el campo fecha (la fecha real del TFG)
        $stmt = $db->prepare("INSERT INTO tfgs (titulo, fecha, resumen, palabras_clave, integrante1, integrante2, integrante3) VALUES (?, CURRENT_DATE, ?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $resumen, $keywords, $uploaderId, $integrante2, $integrante3]);
        return $db->lastInsertId();
    }

    // Nueva función para insertar en la tabla notas una fila por cada integrante con nota en NULL
    public static function registrarNotas($tfg_id, $integrantes) {
        $db = conectarDB();
        $stmt = $db->prepare("INSERT INTO notas (alumno_id, tfg_id, nota) VALUES (?, ?, NULL)");
        foreach ($integrantes as $alumnoId) {
            $stmt->execute([$alumnoId, $tfg_id]);
        }
    }

    public static function registrarArchivo($tfg_id, $nombre, $ruta, $tipo, $tamaño) {
        $db = conectarDB();
        $stmt = $db->prepare("INSERT INTO archivos (tfg_id, nombre, ruta, tipo, tamaño) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$tfg_id, $nombre, $ruta, $tipo, $tamaño]);
    }
}
?>
