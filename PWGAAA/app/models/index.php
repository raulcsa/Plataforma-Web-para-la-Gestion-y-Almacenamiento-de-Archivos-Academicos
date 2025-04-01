<?php
require_once __DIR__ . '/../../config/database.php';

class Tfg {
    public static function buscar($busqueda = "", $campo = "", $limit = 6, $offset = 0) {
        $db = conectarDB();
        if ($busqueda === "") {
            // Sin filtro: siempre 6 TFGs, ordenados por fecha descendente (el más nuevo primero)
            $stmt = $db->prepare("SELECT * FROM tfgs ORDER BY fecha DESC LIMIT ? OFFSET ?");
            $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(2, (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
            // Total se fija en 6, ya que no mostramos paginación en este caso
            $total = 6;
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $like = "%" . $busqueda . "%";
            $allowedFields = ['titulo', 'fecha', 'palabras_clave', 'resumen', 'integrantes'];
            if ($campo !== "" && in_array($campo, $allowedFields)) {
                $where = "WHERE $campo LIKE ?";
                $params = [$like];
            } else {
                $where = "WHERE titulo LIKE ? OR fecha LIKE ? OR palabras_clave LIKE ? OR resumen LIKE ? OR integrantes LIKE ?";
                $params = [$like, $like, $like, $like, $like];
            }
            // Consulta para contar el total de registros filtrados
            $stmtCount = $db->prepare("SELECT COUNT(*) FROM tfgs $where");
            $stmtCount->execute($params);
            $total = $stmtCount->fetchColumn();
            // Consulta para obtener la página actual
            $query = "SELECT * FROM tfgs $where ORDER BY fecha DESC LIMIT ? OFFSET ?";
            $stmt = $db->prepare($query);
            $i = 0;
            foreach ($params as $param) {
                $stmt->bindValue(++$i, $param);
            }
            $stmt->bindValue(++$i, (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(++$i, (int)$offset, PDO::PARAM_INT);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return ['resultados' => $resultados, 'total' => $total];
    }

    public static function obtenerPorId($id) {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT * FROM tfgs WHERE id = ?");
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
