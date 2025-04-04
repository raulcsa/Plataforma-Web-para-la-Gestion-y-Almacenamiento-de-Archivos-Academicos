<?php
require_once __DIR__ . '/../../config/database.php';

class Tfg {
    public static function buscar($busqueda = "", $campo = "", $limit = 6, $offset = 0) {
        $db = conectarDB();
        // Consulta base con LEFT JOIN para obtener los nombres de los integrantes
        $baseQuery = "SELECT t.*, CONCAT_WS(' ', u1.nombre, u2.nombre, u3.nombre) AS integrantes_nombres
                      FROM tfgs t
                      LEFT JOIN usuarios u1 ON t.integrante1 = u1.id
                      LEFT JOIN usuarios u2 ON t.integrante2 = u2.id
                      LEFT JOIN usuarios u3 ON t.integrante3 = u3.id ";
                      
        if ($busqueda === "") {
            // Sin filtro: obtenemos el total de registros sin limitación
            $stmtTotal = $db->query("SELECT COUNT(*) FROM tfgs");
            $total = $stmtTotal->fetchColumn();

            $query = $baseQuery . "ORDER BY t.fecha_subida DESC, t.id DESC LIMIT ? OFFSET ?";
            $stmt = $db->prepare($query);
            $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Si se realiza una búsqueda, definimos la cláusula WHERE
            if ($campo === "integrantes") {
                $whereClause = "WHERE CONCAT_WS(' ', u1.nombre, u2.nombre, u3.nombre) LIKE ?";
                $params = [ "%" . $busqueda . "%" ];
            } elseif (in_array($campo, ['titulo', 'fecha', 'palabras_clave', 'resumen'])) {
                if ($campo === "fecha") {
                    // Mapeo de meses en español a su número correspondiente (dos dígitos)
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
                $params = [ $busqueda ];
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
    
    public static function obtenerPorId($id) {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT t.*, CONCAT_WS(' ', u1.nombre, u2.nombre, u3.nombre) AS integrantes_nombres 
                              FROM tfgs t 
                              LEFT JOIN usuarios u1 ON t.integrante1 = u1.id 
                              LEFT JOIN usuarios u2 ON t.integrante2 = u2.id 
                              LEFT JOIN usuarios u3 ON t.integrante3 = u3.id 
                              WHERE t.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function obtenerArchivos($tfgId) {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT * FROM archivos WHERE tfg_id = ? AND tipo = 'pdf'");
        $stmt->execute([$tfgId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
