<?php
require_once __DIR__ . '/../models/index.php';
require_once __DIR__ . '/../models/subidaProyectos.php';


class ProyectosCalificadosController {
    public function index() {
        session_start();
        
        // Verificar que el usuario esté logueado y que sea profesor o admin
        if (!isset($_SESSION['usuario']) || (strtolower(trim($_SESSION['usuario']['rol'])) !== 'profesor' && strtolower(trim($_SESSION['usuario']['rol'])) !== 'admin')) {
            header("Location: login");
            exit;
        }
        
        $limit = 6;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        $resultado = Tfg::buscarCalificados($limit, $offset);
        $total = $resultado['total'];
        $totalPages = ceil($total / $limit);
        $resultados = $resultado['resultados'];

        // Añadir calificaciones a cada TFG si hay resultados
        if (!empty($resultados)) {
            foreach ($resultados as &$tfg) {
                if (isset($tfg['id'])) {
                    $tfg['calificaciones'] = uploadTfg::obtenerNotasPorTfg($tfg['id']);
                } else {
                    $tfg['calificaciones'] = [];
                }
            }
            unset($tfg); // Romper referencia
        }

        require_once __DIR__ . '/../views/proyectosCalificadosView.php';
    }
}
?>
