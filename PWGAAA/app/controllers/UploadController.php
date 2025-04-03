<?php
require_once __DIR__ . '/../models/subidaProyectos.php';

class UploadController {

    public function mostrarFormulario() {
        $selectUsuarios = uploadTfg::obtenerAlumnos();
        $mensaje = '';
        include __DIR__ . '/../views/subidaproyectosView.php';
    }

    public function procesarFormulario() {
        $mensaje = '';
        $selectUsuarios = uploadTfg::obtenerAlumnos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['tituloProyecto'] ?? '';
            $fecha = $_POST['fechaProyecto'] ?? '';
            $resumen = $_POST['resumenProyecto'] ?? '';
            $keywords = $_POST['palabraClave'] ?? '';
            $alumnos = $_POST['integrantesSelect'] ?? [];

            if (!is_array($alumnos) || count($alumnos) < 1 || count($alumnos) > 3) {
                $mensaje = "Debes seleccionar entre 1 y 3 alumnos.";
            } elseif (empty($titulo) || empty($fecha) || empty($resumen) || empty($keywords)) {
                $mensaje = "Todos los campos son obligatorios.";
            } elseif (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] !== 0) {
                $mensaje = "Error al subir el archivo.";
            } else {
                // Validación del archivo
                $archivo = $_FILES['fileToUpload'];
                $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
                $tipo = $archivo['type'];
                $tamaño = $archivo['size'];

                if ($extension !== 'pdf') {
                    $mensaje = "Solo se permiten archivos PDF.";
                } else {
                    $nombreFinal = uniqid('tfg_') . '.pdf';
                    $rutaFinal = '/uploads/' . $nombreFinal;
                    $rutaFisica = __DIR__ . '/../../uploads/' . $nombreFinal;

                    if (move_uploaded_file($archivo['tmp_name'], $rutaFisica)) {
                        // Guardar el TFG
                        $tfg_id = uploadTfg::insertarTFG($titulo, $fecha, $resumen, $keywords);

                        // Asociar alumnos
                        uploadTfg::asociarAlumnos($tfg_id, $alumnos);

                        // Registrar archivo
                        uploadTfg::registrarArchivo($tfg_id, $archivo['name'], $rutaFinal, $tipo, $tamaño);

                        $mensaje = "TFG y archivo subidos correctamente.";
                        header('location:index.php');
                        exit;
                    } else {
                        $mensaje = "No se pudo mover el archivo al destino final.";
                    }
                }
            }

            include __DIR__ . '/../views/formularioSubida.php';
        }
    }
}
