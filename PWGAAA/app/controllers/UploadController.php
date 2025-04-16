<?php
require_once __DIR__ . '/../models/subidaProyectos.php';

class UploadController {

    public function mostrarFormulario() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario'])) {
            header("Location: login.php");
            exit;
        }
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
                // No se recibe fecha ya que se usa CURRENT_DATE en la BBDD
                $resumen = $_POST['resumenProyecto'] ?? '';
                $keywords = $_POST['palabraClave'] ?? '';
                // Los integrantes adicionales (los IDs de los alumnos seleccionados)
                $selectedAlumnos = $_POST['integrantesSelect'] ?? [];
        
                // Para profesor y admin, se pregunta si desea incluirse
                if ($_SESSION['usuario']['rol'] === 'profesor' || $_SESSION['usuario']['rol'] === 'admin') {
                    $incluirYo = isset($_POST['incluirYo']) && $_POST['incluirYo'] == 1;
                } else {
                    // Para otros usuarios (alumnos) se asume que ya son integrantes por defecto
                    $incluirYo = true;
                }
        
                // Validaciones según rol y cantidad de seleccionados
                if (!is_array($selectedAlumnos)) {
                    $mensaje = "Error en la selección de alumnos.";
                } elseif (($_SESSION['usuario']['rol'] === 'profesor' || $_SESSION['usuario']['rol'] === 'admin') && !$incluirYo && count($selectedAlumnos) < 1) {
                    $mensaje = "Debes seleccionar al menos 1 alumno si decides no incluirte.";
                } elseif (($_SESSION['usuario']['rol'] === 'profesor' || $_SESSION['usuario']['rol'] === 'admin') && $incluirYo && count($selectedAlumnos) > 2) {
                    $mensaje = "Debes seleccionar como máximo 2 alumnos si decides incluirte.";
                } elseif ($_SESSION['usuario']['rol'] !== 'profesor' && $_SESSION['usuario']['rol'] !== 'admin' && count($selectedAlumnos) > 2) {
                    $mensaje = "Debes seleccionar como máximo 2 alumnos.";
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
                        $tipo = 'pdf'; // Forzamos el tipo a 'pdf'
                        $nombreFinal = uniqid('tfg_') . '.pdf';
                        $rutaFinal = "../PDF/" . $nombreFinal;
                        $rutaFisica = dirname(realpath(__DIR__ . '/../../public')) . '/PDF/' . $nombreFinal;
        
                        if (move_uploaded_file($archivo['tmp_name'], $rutaFisica)) {
                            // Insertamos el TFG pasando el flag $incluirYo al método insertarTFG.
                            // (Asegúrate de que la función insertarTFG en subidaProyectos.php se actualice para recibir y utilizar el parámetro $incluirYo.)
                            $tfg_id = uploadTfg::insertarTFG($titulo, $resumen, $keywords, $uploaderId, $selectedAlumnos, $incluirYo);
                            
                            // Registrar el archivo en la base de datos
                            uploadTfg::registrarArchivo($tfg_id, $titulo, $rutaFinal, $tipo, $tamaño);
        
                            $mensaje = "TFG y archivo subidos correctamente.";
                            header('Location: index.php');
                            exit;
                        } else {
                            $mensaje = "No se pudo mover el archivo al destino final.";
                        }
                }
            }
        }
    }    
}
?>
