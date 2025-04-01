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
}
?>
