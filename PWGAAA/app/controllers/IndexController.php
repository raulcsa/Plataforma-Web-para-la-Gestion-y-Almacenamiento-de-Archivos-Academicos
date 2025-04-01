<?php
require_once __DIR__ . '/../models/index.php';

class TfgController {
    public function index() {
        $resultados = Tfg::buscar();
        require_once __DIR__ . '/../views/indexView.php';
    }
}
