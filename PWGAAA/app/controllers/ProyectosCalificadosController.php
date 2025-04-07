<?php
require_once __DIR__ . '/../models/index.php';

class ProyectosCalificadosController {
    public function index() {
        session_start();
        // Verificar que el usuario esté logueado y que sea profesor
        if (!isset($_SESSION['usuario']) || strtolower(trim($_SESSION['usuario']['rol'])) !== 'profesor') {
            header("Location: login.php");
            exit;
        }
        $limit = 6;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        $resultado = Tfg::buscarCalificados($limit, $offset);
        $total = $resultado['total'];
        $totalPages = ceil($total / $limit);
        $resultados = $resultado['resultados'];
        require_once __DIR__ . '/../views/proyectosCalificadosView.php';
    }
}
?>
