<?php
require_once __DIR__ . '/../models/misproyectos.php';

class MisProyectosController {
    public function index() {
        session_start();
        if (!isset($_SESSION['usuario'])) {
            header("Location: login.php");
            exit;
        }
        $usuarioId = $_SESSION['usuario']['id'];
        $rol = $_SESSION['usuario']['rol'];
        $proyectos = MisProyectosModel::obtenerProyectosPorUsuario($usuarioId, $rol);
        require_once __DIR__ . '/../views/misproyectosView.php';
    }
}
?>
