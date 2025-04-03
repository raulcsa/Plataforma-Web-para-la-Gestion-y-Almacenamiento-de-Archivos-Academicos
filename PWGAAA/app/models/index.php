<?php
require_once __DIR__ . '/../../config/database.php';

class Tfg {public static function buscar($busqueda = "", $campo = "", $limit = 6, $offset = 0) {
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

        $query = $baseQuery . "ORDER BY t.fecha DESC LIMIT ? OFFSET ?";
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
            $whereClause = "WHERE t.$campo LIKE ?";
            $params = [ "%" . $busqueda . "%" ];
        } else {
            // Búsqueda en varios campos si no se especifica un campo concreto
            $whereClause = "WHERE t.titulo LIKE ? OR t.fecha LIKE ? OR t.palabras_clave LIKE ? OR t.resumen LIKE ? OR CONCAT_WS(' ', u1.nombre, u2.nombre, u3.nombre) LIKE ?";
            $params = array_fill(0, 5, "%" . $busqueda . "%");
        }
        
        // Obtener el total de registros filtrados
        $stmtTotal = $db->prepare("SELECT COUNT(*) FROM tfgs t 
                                   LEFT JOIN usuarios u1 ON t.integrante1 = u1.id 
                                   LEFT JOIN usuarios u2 ON t.integrante2 = u2.id 
                                   LEFT JOIN usuarios u3 ON t.integrante3 = u3.id " . $whereClause);
        $stmtTotal->execute($params);
        $total = $stmtTotal->fetchColumn();

        // Obtener los resultados paginados
        $query = $baseQuery . " " . $whereClause . " ORDER BY t.fecha DESC LIMIT ? OFFSET ?";
        $stmt = $db->prepare($query);
        // Vinculamos los parámetros de búsqueda
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
        // Si sólo quieres obtener archivos de tipo pdf:
        $stmt = $db->prepare("SELECT * FROM archivos WHERE tfg_id = ? AND tipo = 'pdf'");
        $stmt->execute([$tfgId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
