<?php
require_once __DIR__ . '/../models/index.php';

class TfgController {
    public function index() {
        $busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
        $campo = isset($_GET['campo']) ? trim($_GET['campo']) : '';
        $limit = 6;
        
        if ($busqueda === "") {
            // Cuando no hay búsqueda, siempre mostramos la primera página (6 TFGs)
            $page = 1;
            $offset = 0;
            // Se llaman los 6 más recientes; en este caso ignoramos la paginación (aunque existan más TFGs en la BBDD)
            $resultado = Tfg::buscar("", "", $limit, $offset);
            // Para la vista forzamos que totalPages sea 1, de modo que no se muestre paginación
            $totalPages = 1;
        } else {
            // Si hay búsqueda, se recoge el parámetro "page"
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
            $resultado = Tfg::buscar($busqueda, $campo, $limit, $offset);
            // Se calcula el total de páginas según el total de resultados filtrados
            $total = $resultado['total'];
            $totalPages = ceil($total / $limit);
        }
        
        $resultados = $resultado['resultados'];
        require_once __DIR__ . '/../views/indexView.php';
    }
}
?>
