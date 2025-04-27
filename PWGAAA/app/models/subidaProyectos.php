<?php
require_once __DIR__ . '/../../config/database.php';

class uploadTfg {

    public static function obtenerAlumnos() {
        $db = conectarDB();
        $stmt = $db->query("SELECT id, nombre FROM usuarios WHERE rol = 'alumno'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inserta el TFG y asigna integrante1 (el uploader) y opcionalmente integrante2 y 3 de los alumnos adicionales
    public static function insertarTFG($titulo, $resumen, $keywords, $uploaderId, $selectedAlumnos, $incluirYo = true) {
        $db = conectarDB();
        if ($incluirYo) {
            // Si se incluye al usuario que sube el TFG como integrante1
            $integrante1 = $uploaderId;
            $integrante2 = isset($selectedAlumnos[0]) ? $selectedAlumnos[0] : NULL;
            $integrante3 = isset($selectedAlumnos[1]) ? $selectedAlumnos[1] : NULL;
        } else {
            // El profesor opta por no incluirse; se toman los seleccionados
            if (!is_array($selectedAlumnos) || count($selectedAlumnos) < 1) {
                throw new Exception("Debes seleccionar al menos 1 alumno para el TFG si no te incluyes.");
            }
            $integrante1 = $selectedAlumnos[0];
            $integrante2 = isset($selectedAlumnos[1]) ? $selectedAlumnos[1] : NULL;
            $integrante3 = isset($selectedAlumnos[2]) ? $selectedAlumnos[2] : NULL;
        }
        // Insertamos usando la fecha actual (CURRENT_DATE)
        $stmt = $db->prepare("INSERT INTO tfgs (titulo, fecha, resumen, palabras_clave, integrante1, integrante2, integrante3) VALUES (?, CURRENT_DATE, ?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $resumen, $keywords, $integrante1, $integrante2, $integrante3]);
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

    public static function registrarNotasFromTfg(int $tfgId) {
        $db = conectarDB();
        $stmt = $db->prepare(
            "SELECT integrante1, integrante2, integrante3
             FROM tfgs
             WHERE id = ?"
        );
        $stmt->execute([$tfgId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            throw new Exception("TFG #{$tfgId} no encontrado al registrar notas");
        }
        $integrantes = [];
        foreach (['integrante1','integrante2','integrante3'] as $col) {
            if (!empty($row[$col])) {
                $integrantes[] = (int)$row[$col];
            }
        }
        if (empty($integrantes)) {
            throw new Exception("El TFG #{$tfgId} no tiene ningún integrante válido.");
        }
        self::registrarNotas($tfgId, $integrantes);
    }

    public static function registrarArchivo($tfg_id, $nombre, $ruta, $tipo, $tamaño) {
        $db = conectarDB();
        $stmt = $db->prepare("INSERT INTO archivos (tfg_id, nombre, ruta, tipo, tamaño) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$tfg_id, $nombre, $ruta, $tipo, $tamaño]);
    }

    public static function reemplazarArchivo(int $tfg_id, string $nombre, string $ruta, string $tipo, int $tamaño) {
        $db = conectarDB();
        // 1) Opcionalmente, recupera la ruta física del viejo PDF y bórralo del disco:
        $stmt = $db->prepare("SELECT ruta FROM archivos WHERE tfg_id = ? AND tipo = ?");
        $stmt->execute([$tfg_id, $tipo]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $viejaRuta = dirname(realpath(__DIR__ . '/../../public')) . '/' . ltrim($row['ruta'], '/');
            if (file_exists($viejaRuta)) {
                @unlink($viejaRuta);
            }
        }
        // 2) Borra los registros antiguos en BD
        $stmt = $db->prepare("DELETE FROM archivos WHERE tfg_id = ? AND tipo = ?");
        $stmt->execute([$tfg_id, $tipo]);
    
        // 3) Inserta el nuevo
        self::registrarArchivo($tfg_id, $nombre, $ruta, $tipo, $tamaño);
    }

        // Devuelve el registro único del PDF actual para ese TFG
    public static function obtenerArchivoPorTfg(int $tfgId): ?array {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT id, nombre, ruta FROM archivos WHERE tfg_id = ? LIMIT 1");
        $stmt->execute([$tfgId]);
        $f = $stmt->fetch(PDO::FETCH_ASSOC);
        return $f ?: null;
    }

        // Borra el registro antiguo en la tabla archivos
    public static function borrarRegistroArchivo(int $tfgId): void {
        $db = conectarDB();
        $stmt = $db->prepare("DELETE FROM archivos WHERE tfg_id = ?");
        $stmt->execute([$tfgId]);
    }

    public static function obtenerNotasPorTfg(int $tfgId): array {
        $db = conectarDB();
        
        $sql = "
            SELECT u.id AS alumno_id, u.nombre, n.nota, n.comentario
            FROM notas n
            INNER JOIN usuarios u ON u.id = n.alumno_id
            WHERE n.tfg_id = ?
        ";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$tfgId]);
        $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Si no hay notas aún, construimos manualmente a partir de los integrantes del TFG
        if (empty($notas)) {
            $stmt2 = $db->prepare("
                SELECT u.id AS alumno_id, u.nombre
                FROM tfgs t
                JOIN usuarios u ON u.id IN (t.integrante1, t.integrante2, t.integrante3)
                WHERE t.id = ?
            ");
            $stmt2->execute([$tfgId]);
            $notas = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
            // Inicializamos nota y comentario como nulos
            foreach ($notas as &$n) {
                $n['nota'] = null;
                $n['comentario'] = null;
            }
        }
    
        return $notas;
    }
    
    public static function obtenerUsuarioPorId($id) {
    $db = conectarDB();
    $stmt = $db->prepare("SELECT id, nombre FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    
    // Actualiza la nota y comentario de un alumno en un TFG
    public static function actualizarNota(
        int $tfgId,
        int $alumnoId,
        float $nota,
        ?string $comentario
    ): void {
        $db = conectarDB();
        $stmt = $db->prepare("
          UPDATE notas
            SET nota = ?, comentario = ?
          WHERE tfg_id = ? AND alumno_id = ?
        ");
        $stmt->execute([$nota, $comentario, $tfgId, $alumnoId]);
    }

}
?>
