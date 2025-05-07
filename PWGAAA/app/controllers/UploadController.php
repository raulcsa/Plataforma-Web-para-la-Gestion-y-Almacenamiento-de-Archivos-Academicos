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
        $selectUsuarios = uploadTfg::obtenerAlumnos();
        $uploaderId     = $_SESSION['usuario']['id'];
        // filtramos al propio uploader
        $selectUsuarios = array_filter(
            $selectUsuarios,
            fn($u) => $u['id'] != $uploaderId
        );
        $mensaje = '';
        include __DIR__ . '/../views/subidaproyectosView.php';
    }

    public function procesarFormulario() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario'])) {
            header("Location: login.php");
            exit;
        }

        $uploaderId      = $_SESSION['usuario']['id'];
        $rol             = strtolower(trim($_SESSION['usuario']['rol']));
        $mensaje         = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo          = trim($_POST['tituloProyecto'] ?? '');
            $resumen         = trim($_POST['resumenProyecto'] ?? '');
            $keywords        = trim($_POST['palabraClave'] ?? '');
            $selectedAlumnos = $_POST['integrantesSelect'] ?? [];
            // checkbox solo para prof/admin
            $incluirYo = in_array($rol, ['profesor','admin'])
                         ? (isset($_POST['incluirYo']) && $_POST['incluirYo'] == '1')
                         : true;

            // validaciones
            if (!$titulo || !$resumen || !$keywords) {
                $mensaje = "Todos los campos son obligatorios.";
            } elseif (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] !== 0) {
                $mensaje = "Error al subir el archivo.";
            } elseif (!is_array($selectedAlumnos)) {
                $mensaje = "Error en la selección de alumnos.";
            } else {
                $maxExtra = in_array($rol, ['profesor','admin'])
                            ? ($incluirYo ? 2 : 3)
                            : 2;
                if (count($selectedAlumnos) > $maxExtra) {
                    $mensaje = "Solo puedes seleccionar hasta $maxExtra alumnos adicionales.";
                }
            }

            if (!$mensaje) {
                $archivo = $_FILES['fileToUpload'];
                $ext     = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
                if ($ext !== 'pdf') {
                    $mensaje = "Solo se permiten archivos PDF.";
                } else {
                    // preparamos rutas
                    $nombreFinal = uniqid('tfg_') . '.pdf';
                    $rutaFinal   = "../PDF/$nombreFinal";
                    $rutaFisica  = dirname(realpath(__DIR__ . '/../../public')) . "/PDF/$nombreFinal";

                    if (!move_uploaded_file($archivo['tmp_name'], $rutaFisica)) {
                        $mensaje = "No se pudo mover el archivo al destino final.";
                    } else {
                        try {
                            // 1) Insertar TFG
                            $tfgId = uploadTfg::insertarTFG(
                                $titulo, $resumen, $keywords,
                                $uploaderId, $selectedAlumnos, $incluirYo
                            );

                            // 2) Registrar notas en tabla notas
                            uploadTfg::registrarNotasFromTfg($tfgId);

                            // 3) Registrar archivo
                            uploadTfg::registrarArchivo($tfgId, $titulo, $rutaFinal, 'pdf', $archivo['size']);

                            // 4) Redirigir al listado
                            header('Location: index?subida=ok');
                            exit;

                        } catch (\Exception $e) {
                            // Atrapar cualquier fallo en modelo o registro de notas
                            $mensaje = "Error interno: " . $e->getMessage();
                        }
                    }
                }
            }
        }

        // si GET o con errores, volvemos al formulario
        include __DIR__ . '/../views/subidaproyectosView.php';
    }
}
?>