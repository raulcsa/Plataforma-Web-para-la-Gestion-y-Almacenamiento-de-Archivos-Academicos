<?php
require_once __DIR__ . '/../../config/database.php';

class Tfg
{
    public static function buscar($busqueda = "", $campo = "", $limit = 6, $offset = 0)
    {
        $db = conectarDB();
        // Consulta base con LEFT JOIN para obtener los nombres de los integrantes
        $baseQuery = "SELECT t.*, CONCAT_WS(' ', u1.nombre, u2.nombre, u3.nombre) AS integrantes_nombres
                      FROM tfgs t
                      LEFT JOIN usuarios u1 ON t.integrante1 = u1.id
                      LEFT JOIN usuarios u2 ON t.integrante2 = u2.id
                      LEFT JOIN usuarios u3 ON t.integrante3 = u3.id ";

        if ($busqueda === "") {
            // Sólo TFGs completamente calificados (todas las notas != NULL)
            // 1) Contar cuántos TFGs cumplen la condición
            $stmtTotal = $db->query("
                SELECT COUNT(*) 
                FROM tfgs t
                WHERE EXISTS (
                SELECT 1 FROM notas n WHERE n.tfg_id = t.id
                )
                AND NOT EXISTS (
                SELECT 1 FROM notas n WHERE n.tfg_id = t.id AND n.nota IS NULL
                )
            ");
            $total = $stmtTotal->fetchColumn();

            // 2) Traer los resultados paginados
            $query = $baseQuery . "
                WHERE EXISTS (
                SELECT 1 FROM notas n WHERE n.tfg_id = t.id
                )
                AND NOT EXISTS (
                SELECT 1 FROM notas n WHERE n.tfg_id = t.id AND n.nota IS NULL
                )
                ORDER BY t.fecha_subida DESC, t.id DESC
                LIMIT ? OFFSET ?
                ";
                $stmt = $db->prepare($query);
                $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
                $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
                $stmt->execute();
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
            // Si se realiza una búsqueda, definimos la cláusula WHERE
            if ($campo === "integrantes") {
                $whereClause = "WHERE CONCAT_WS(' ', u1.nombre, u2.nombre, u3.nombre) LIKE ?";
                $params = ["%" . $busqueda . "%"];
            } elseif (in_array($campo, ['titulo', 'fecha', 'palabras_clave', 'resumen'])) {
                if ($campo === "fecha") {
                    // Mapeo de meses en su número correspondiente (dos dígitos)
                    $meses = [
                        'enero'      => '01',
                        'febrero'    => '02',
                        'marzo'      => '03',
                        'abril'      => '04',
                        'mayo'       => '05',
                        'junio'      => '06',
                        'julio'      => '07',
                        'agosto'     => '08',
                        'septiembre' => '09',
                        'octubre'    => '10',
                        'noviembre'  => '11',
                        'diciembre'  => '12'
                    ];
                    $busquedaLower = strtolower($busqueda);
                    if (isset($meses[$busquedaLower])) {
                        // Si el término es un mes, se busca en t.fecha (formato YYYY-MM-DD) usando el patrón
                        $busqueda = "%-" . $meses[$busquedaLower] . "-%";
                    } else {
                        $busqueda = "%" . $busqueda . "%";
                    }
                } else {
                    $busqueda = "%" . $busqueda . "%";
                }
                $whereClause = "WHERE t.$campo LIKE ?";
                $params = [$busqueda];
            } else {
                // Opción "Todos": se busca en varios campos
                $monthMap = [
                    'enero'      => '01',
                    'febrero'    => '02',
                    'marzo'      => '03',
                    'abril'      => '04',
                    'mayo'       => '05',
                    'junio'      => '06',
                    'julio'      => '07',
                    'agosto'     => '08',
                    'septiembre' => '09',
                    'octubre'    => '10',
                    'noviembre'  => '11',
                    'diciembre'  => '12'
                ];
                $busquedaLower = strtolower($busqueda);
                if (isset($monthMap[$busquedaLower])) {
                    $busquedaNumeric = "%-" . $monthMap[$busquedaLower] . "-%";
                    $whereClause = "WHERE t.titulo LIKE ? OR t.fecha LIKE ? OR t.palabras_clave LIKE ? OR t.resumen LIKE ? OR CONCAT_WS(' ', u1.nombre, u2.nombre, u3.nombre) LIKE ? OR t.fecha LIKE ?";
                    $params = [
                        "%" . $busqueda . "%",
                        "%" . $busqueda . "%",
                        "%" . $busqueda . "%",
                        "%" . $busqueda . "%",
                        "%" . $busqueda . "%",
                        $busquedaNumeric
                    ];
                } else {
                    $whereClause = "WHERE t.titulo LIKE ? OR t.fecha LIKE ? OR t.palabras_clave LIKE ? OR t.resumen LIKE ? OR CONCAT_WS(' ', u1.nombre, u2.nombre, u3.nombre) LIKE ?";
                    $params = array_fill(0, 5, "%" . $busqueda . "%");
                }
            }

            // Obtener el total de registros filtrados
            $stmtTotal = $db->prepare("SELECT COUNT(*) FROM tfgs t 
                                       LEFT JOIN usuarios u1 ON t.integrante1 = u1.id 
                                       LEFT JOIN usuarios u2 ON t.integrante2 = u2.id 
                                       LEFT JOIN usuarios u3 ON t.integrante3 = u3.id " . $whereClause);
            $stmtTotal->execute($params);
            $total = $stmtTotal->fetchColumn();

            // Obtener los resultados paginados
            // Usamos t.fecha_subida para ordenar, de modo que los TFGs subidos más recientemente aparezcan primero
            $query = $baseQuery . " " . $whereClause . " ORDER BY t.fecha_subida DESC, t.id DESC LIMIT ? OFFSET ?";
            $stmt = $db->prepare($query);
            foreach ($params as $i => $param) {
                $stmt->bindValue($i + 1, $param);
            }
            $stmt->bindValue(count($params) + 1, (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(count($params) + 2, (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return ['resultados' => $resultados, 'total' => $total];
    }

    public static function actualizar(int $id, string $titulo, string $resumen, string $keywords, array $integrantes, ?string $fecha = null): void {
        $db = conectarDB();
        $stmt = $db->prepare("
        UPDATE tfgs
           SET titulo = ?, resumen = ?, palabras_clave = ?, fecha = ?,
               integrante1 = ?, integrante2 = ?, integrante3 = ?
         WHERE id = ?
    ");
    
        $i1 = $integrantes[0] ?? null;
        $i2 = $integrantes[1] ?? null;
        $i3 = $integrantes[2] ?? null;
        $stmt->execute([$titulo, $resumen, $keywords, $fecha, $i1, $i2, $i3, $id]);

        // Repoblamos la tabla notas con los nuevos integrantes
        self::registrarNotasFromTfg($id);
    }

    public static function registrarNotasFromTfg(int $tfgId): void {
        $db = conectarDB();
        // 1) Obtenemos los integrantes desde tfgs
        $stmt = $db->prepare("
            SELECT integrante1, integrante2, integrante3
              FROM tfgs
             WHERE id = ?
        ");
        $stmt->execute([$tfgId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) throw new Exception("TFG #$tfgId no encontrado al registrar notas");

        // 2) Borramos notas previas
        $db->prepare("DELETE FROM notas WHERE tfg_id = ?")
           ->execute([$tfgId]);

        // 3) Insertamos notas NULL para cada integrante
        $ins = $db->prepare("
            INSERT INTO notas (tfg_id, alumno_id, nota)
            VALUES (?, ?, NULL)
        ");
        foreach (['integrante1','integrante2','integrante3'] as $col) {
            if (!empty($row[$col])) {
                $ins->execute([$tfgId, (int)$row[$col]]);
            }
        }
    }

    public static function obtenerPorId($id)
    {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT 
          t.*,
          u1.nombre AS nombre1, u1.email AS email1,
          u2.nombre AS nombre2, u2.email AS email2,
          u3.nombre AS nombre3, u3.email AS email3
        FROM tfgs t
        LEFT JOIN usuarios u1 ON t.integrante1 = u1.id
        LEFT JOIN usuarios u2 ON t.integrante2 = u2.id
        LEFT JOIN usuarios u3 ON t.integrante3 = u3.id
        WHERE t.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function obtenerArchivos($tfgId)
    {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT * FROM archivos WHERE tfg_id = ? AND tipo = 'pdf'");
        $stmt->execute([$tfgId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorCalificar($limit = 6, $offset = 0)
    {
        $db = conectarDB();
        $query = "SELECT t.*, CONCAT_WS(' ', u1.nombre, u2.nombre, u3.nombre) AS integrantes_nombres
                  FROM tfgs t
                  LEFT JOIN usuarios u1 ON t.integrante1 = u1.id 
                  LEFT JOIN usuarios u2 ON t.integrante2 = u2.id 
                  LEFT JOIN usuarios u3 ON t.integrante3 = u3.id
                  WHERE EXISTS (
                      SELECT 1 FROM notas n 
                      WHERE n.tfg_id = t.id AND n.nota IS NULL
                  )
                  ORDER BY t.fecha_subida DESC, t.id DESC
                  LIMIT ? OFFSET ?";
        $stmt = $db->prepare($query);
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmtTotal = $db->query("SELECT COUNT(*) FROM tfgs t 
                                 WHERE EXISTS (
                                     SELECT 1 FROM notas n 
                                     WHERE n.tfg_id = t.id AND n.nota IS NULL
                                 )");
        $total = $stmtTotal->fetchColumn();

        return ['resultados' => $resultados, 'total' => $total];
    }

    public static function buscarCalificados($limit = 6, $offset = 0)
    {
        $db = conectarDB();
        $query = "SELECT DISTINCT t.*, CONCAT_WS(' ', u1.nombre, u2.nombre, u3.nombre) AS integrantes_nombres
        FROM tfgs t
        LEFT JOIN usuarios u1 ON t.integrante1 = u1.id 
        LEFT JOIN usuarios u2 ON t.integrante2 = u2.id 
        LEFT JOIN usuarios u3 ON t.integrante3 = u3.id
        WHERE EXISTS (
            SELECT 1 FROM notas n 
            WHERE n.tfg_id = t.id
        )
        AND NOT EXISTS (
            SELECT 1 FROM notas n 
            WHERE n.tfg_id = t.id AND n.nota IS NULL
        )
        ORDER BY t.fecha_subida DESC, t.id DESC
        LIMIT ? OFFSET ?";

        $stmt = $db->prepare($query);
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Contar solo aquellos TFGs que tienen notas y ninguna en NULL.
        $stmtTotal = $db->query("SELECT COUNT(*) FROM tfgs t 
                                 WHERE EXISTS (
                                     SELECT 1 FROM notas n 
                                     WHERE n.tfg_id = t.id
                                 )
                                 AND NOT EXISTS (
                                     SELECT 1 FROM notas n 
                                     WHERE n.tfg_id = t.id AND n.nota IS NULL
                                 )");
        $total = $stmtTotal->fetchColumn();

        return ['resultados' => $resultados, 'total' => $total];
    }
}
