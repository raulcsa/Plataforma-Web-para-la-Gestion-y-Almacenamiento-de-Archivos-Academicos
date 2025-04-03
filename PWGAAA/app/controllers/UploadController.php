<?php
require_once __DIR__ . '/../models/subidaProyectos.php';

class UploadController {

    public function mostrarFormulario() {
        session_start();
        // Obtener todos los alumnos
        $selectUsuarios = uploadTfg::obtenerAlumnos();
        // Filtrar el alumno que está logueado (ya que será integrante1)
        $uploaderId = $_SESSION['usuario']['id'] ?? null;
        if ($uploaderId !== null) {
            $selectUsuarios = array_filter($selectUsuarios, function($alumno) use ($uploaderId) {
                return $alumno['id'] != $uploaderId;
            });
        }
        $mensaje = '';
        include __DIR__ . '/../views/subidaproyectosView.php';
    }

    public function procesarFormulario() {
        session_start();
        $selectUsuarios = uploadTfg::obtenerAlumnos();
        $uploaderId = $_SESSION['usuario']['id'] ?? null;
        if (!$uploaderId) {
            $mensaje = "No has iniciado sesión.";
            include __DIR__ . '/../views/subidaproyectosView.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['tituloProyecto'] ?? '';
            // Se elimina el campo fecha ya que se usa la fecha predeterminada en la base de datos
            $resumen = $_POST['resumenProyecto'] ?? '';
            $keywords = $_POST['palabraClave'] ?? '';
            // Los integrantes adicionales (máximo 2)
            $selectedAlumnos = $_POST['integrantesSelect'] ?? [];

            if (!is_array($selectedAlumnos) || count($selectedAlumnos) > 2) {
                $mensaje = "Debes seleccionar como máximo 2 alumnos adicionales.";
            } elseif (empty($titulo) || empty($resumen) || empty($keywords)) {
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
                    // Forzar que el tipo sea 'pdf'
                    $tipo = 'pdf';
                    // Generar un nombre único para el archivo PDF
                    $nombreFinal = uniqid('tfg_') . '.pdf';
                    // La ruta relativa (desde public) será "../PDF/nombreFinal"
                    $rutaFinal = "../PDF/" . $nombreFinal;
                    // Calcular la ruta física:
                    // Suponiendo que public está en /home/bookworm-tfg/Documentos/PWGAAA/PWGAAA/public,
                    // el directorio padre de public es: dirname(realpath(__DIR__ . '/../../public'))
                    $rutaFisica = dirname(realpath(__DIR__ . '/../../public')) . '/PDF/' . $nombreFinal;
                    
                    if (move_uploaded_file($archivo['tmp_name'], $rutaFisica)) {
                        // Insertar el TFG, usando el usuario logueado (integrante1) y los alumnos seleccionados (integrante2 y 3)
                        $tfg_id = uploadTfg::insertarTFG($titulo, $resumen, $keywords, $uploaderId, $selectedAlumnos);
                        
                        // Registrar el archivo (usando el título como nombre en la base de datos)
                        uploadTfg::registrarArchivo($tfg_id, $titulo, $rutaFinal, $tipo, $tamaño);

                        $mensaje = "TFG y archivo subidos correctamente.";
                        header('Location: index.php');
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
