<?php
require_once __DIR__ . '/../models/index.php';

class TfgController {
    public function index() {
        $busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
        $campo = isset($_GET['campo']) ? trim($_GET['campo']) : '';
        $limit = 6;
        
        if ($busqueda === "") {
            // Cuando no hay búsqueda, ignoramos la paginación (si existieran más registros, solo mostramos 6)
            $page = 1;
            $offset = 0;
            $resultado = Tfg::buscar("", "", $limit, $offset);
            $totalPages = 1;
        } else {
            // Si hay búsqueda, se utiliza el parámetro 'page'
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
            $resultado = Tfg::buscar($busqueda, $campo, $limit, $offset);
            $total = $resultado['total'];
            $totalPages = ceil($total / $limit);
        }
        
        $resultados = $resultado['resultados'];
        require_once __DIR__ . '/../views/indexView.php';
    }
    public function verDetalle() {
        // Recogemos el ID del TFG por GET
        if (!isset($_GET['id'])) {
            // Si no se pasa ID, redirigimos a index
            header("Location: index.php");
            exit;
        }
        $id = (int) $_GET['id'];

        // Obtenemos el TFG
        $tfg = Tfg::obtenerPorId($id);
        if (!$tfg) {
            // Si no existe ese TFG, redirigimos o mostramos un error
            header("Location: index.php");
            exit;
        }

        // Obtenemos los archivos asociados a este TFG
        $archivos = Tfg::obtenerArchivos($id);

        // Cargamos la vista de detalle
        require_once __DIR__ . '/../views/detalleTfgView.php';
    }
}
?>
