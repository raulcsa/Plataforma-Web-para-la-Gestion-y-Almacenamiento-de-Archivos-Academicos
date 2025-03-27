<?php
require_once __DIR__ . '/../models/tfgs.php';

class TfgController {
    public function index() {
        $campo = 'titulo';
        $buscar = "";
        if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
            $allowedFields = ['titulo', 'fecha', 'palabras_clave', 'integrantes'];
            $campo = in_array($_GET['campo'], $allowedFields) ? $_GET['campo'] : 'titulo';
            $buscar = trim($_GET['buscar']);
        }
        $resultados = Tfg::buscar($campo, $buscar);
        // Llamada a la vista, pasando las variables necesarias
        require_once __DIR__ . '/../views/tfgsView.php';
    }
}
