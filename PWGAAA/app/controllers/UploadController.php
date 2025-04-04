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
            // Eliminamos el campo fecha; se usará la fecha actual (CURRENT_DATE en la BD)
            $resumen = $_POST['resumenProyecto'] ?? '';
            $keywords = $_POST['palabraClave'] ?? '';
            // Los alumnos adicionales (máximo 2)
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
                    // Forzamos que el tipo se guarde como 'pdf'
                    $tipo = 'pdf';
                    // Generar un nombre único para el archivo PDF
                    $nombreFinal = uniqid('tfg_') . '.pdf';
                    // La ruta relativa (desde public) será "../PDF/nombreFinal"
                    $rutaFinal = "../PDF/" . $nombreFinal;
                    // Calcular la ruta física: se asume que la carpeta public está en .../PWGAAA/PWGAAA/public/
                    $rutaFisica = dirname(realpath(__DIR__ . '/../../public')) . '/PDF/' . $nombreFinal;
                    
                    if (move_uploaded_file($archivo['tmp_name'], $rutaFisica)) {
                        // Insertar el TFG
                        // La función insertarTFG espera: título, resumen, palabras clave, uploaderId, y los alumnos seleccionados
                        $tfg_id = uploadTfg::insertarTFG($titulo, $resumen, $keywords, $uploaderId, $selectedAlumnos);
                        
                        // Construir el arreglo de integrantes: el usuario que sube el TFG (integrante1) y los adicionales
                        $integrantes = [$uploaderId];
                        // Agregar los adicionales (ya que el formulario ya filtra que no sean el mismo)
                        foreach ($selectedAlumnos as $alumnoId) {
                            $integrantes[] = $alumnoId;
                        }
                        // Registrar las notas (una fila por integrante con nota NULL)
                        uploadTfg::registrarNotas($tfg_id, $integrantes);

                        // Registrar el archivo en la tabla archivos
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
?>
