<?php
require_once __DIR__ . '/../models/index.php';
require_once __DIR__ . '/../models/subidaProyectos.php';


class ProyectosCalificadosController {
    public function index() {
        session_start();
    
        if (!isset($_SESSION['usuario']) || !in_array(strtolower(trim($_SESSION['usuario']['rol'])), ['profesor', 'admin'])) {
            header("Location: login");
            exit;
        }
    
        $busqueda = trim($_GET['busqueda'] ?? '');
        $campo = trim($_GET['campo'] ?? '');
        $limit = 6;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
    
        if ($busqueda !== '') {
            $resultado = Tfg::buscar($busqueda, $campo, $limit, $offset);
        } else {
            $resultado = Tfg::buscarCalificados($limit, $offset);
        }
    
        $resultados = $resultado['resultados'];
        $total = $resultado['total'];
        $totalPages = ceil($total / $limit);
    
        // Añadir calificaciones
        if (!empty($resultados)) {
            foreach ($resultados as &$tfg) {
                $tfg['calificaciones'] = uploadTfg::obtenerNotasPorTfg($tfg['id']);
            }
            unset($tfg);
        }
    
        require_once __DIR__ . '/../views/proyectosCalificadosView.php';
    }
    
}
?>
