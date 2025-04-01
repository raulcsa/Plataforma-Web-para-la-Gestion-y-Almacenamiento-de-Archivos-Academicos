<?php
require_once __DIR__ . '/../models/tfgs.php';

class TfgController {
    public function index() {
        $resultados = Tfg::buscar();
        require_once __DIR__ . '/../views/tfgsView.php';
    }
}
