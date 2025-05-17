<?php
ob_start();

// app/controllers/CorrectionController.php

require_once __DIR__ . '/../models/index.php';        // para Tfg::actualizar()
require_once __DIR__ . '/../models/subidaProyectos.php'; // para uploadTfg::registrarArchivo()
require_once __DIR__ . '/../../config/database.php';     // para conectarDB()

class CorrectionController {

    public function editar(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $rol = strtolower($_SESSION['usuario']['rol'] ?? '');
        if (!in_array($rol, ['profesor','admin', 'alumno'])) {
            header('Location: index.php');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $tfg = Tfg::obtenerPorId($id);
        $archivos = Tfg::obtenerArchivos($id);

        require_once __DIR__ . '/../views/editarTfgView.php';
    }

    public function actualizar(): void {
        session_start();
        $rol = strtolower($_SESSION['usuario']['rol'] ?? '');
        if (!in_array($rol, ['profesor','admin'])) {
            header('Location: index.php');
            exit;
        }
    
        $id       = (int)($_GET['id'] ?? 0);
        $titulo   = trim($_POST['titulo'] ?? '');
        $resumen  = trim($_POST['resumen'] ?? '');
        $keywords = trim($_POST['palabras_clave'] ?? '');
        $integrantes = $_POST['integrantes'] ?? [];
        $fecha = $_POST['fecha'] ?? null;

    
        if (empty($titulo) || empty($resumen) || empty($keywords) || count($integrantes) < 1) {
            $_SESSION['mensaje'] = 'Rellena todos los campos y al menos un integrante.';
            header("Location: editarTfg.php?id=$id");
            exit;
        }
    
        Tfg::actualizar($id, $titulo, $resumen, $keywords, $integrantes, $fecha);
    
        if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === 0) {
            $ext = strtolower(pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
        
                // 1) Recuperar el archivo antiguo
                $oldArchivo = uploadTfg::obtenerArchivoPorTfg($id);
        
                if ($oldArchivo) {
                    $oldPath = dirname(__DIR__,2) . '/PDF/' . basename($oldArchivo['ruta']);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath); // Borra el PDF viejo del disco
                    }
                    uploadTfg::borrarRegistroArchivo($id); // Borra el registro antiguo en BD
                }
        
                // 2) Guardar el nuevo archivo
                $final     = uniqid('tfg_') . '.pdf';
                $publicUrl = '../PDF/' . $final;
                $diskPath  = dirname(__DIR__,2) . '/PDF/' . $final;
        
                if (move_uploaded_file($_FILES['pdf']['tmp_name'], $diskPath)) {
                    uploadTfg::registrarArchivo($id, $final, $publicUrl, 'pdf', $_FILES['pdf']['size']);
                } else {
                    $_SESSION['mensaje'] = 'No se pudo subir el nuevo PDF.';
                    header("Location: editarTfg.php?id=$id");
                    exit;
                }
            }
        }
        
    
        // AQUÍ DISTINGUIMOS SEGÚN EL BOTÓN QUE PULSASTE
        if (isset($_POST['action']) && $_POST['action'] === 'calificar') {
            header('Location: correction.php?action=calificar&id=' . $id);
            exit;
        } else {
            header('Location: proyectosPorCalificar.php');
            exit;
        }
    }

    public function calificar(): void {
        session_start();
        $rol = strtolower($_SESSION['usuario']['rol'] ?? '');
        if (!in_array($rol, ['profesor','admin'])) {
            header('Location: index.php');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $tfg = Tfg::obtenerPorId($id);
        $alumnosNotas = uploadTfg::obtenerNotasPorTfg($id);
        require_once __DIR__ . '/../views/calificarView.php';
    }

    public function validar(): void {
        session_start();
        $rol = strtolower($_SESSION['usuario']['rol'] ?? '');
        if (!in_array($rol, ['profesor','admin'])) {
            header('Location: index.php');
            exit;
        }
    
        $id = (int)($_GET['id'] ?? 0);
        $notas       = $_POST['nota']       ?? [];
        $comentarios = $_POST['comentario'] ?? [];
        $fecha       = $_POST['fecha']      ?? [];
    
        // Validación de notas
        foreach ($notas as $alumnoId => $valor) {
            $n = floatval($valor);
            if ($n < 1 || $n > 10) {
                $_SESSION['mensaje'] = "La nota de cada alumno debe estar entre 1 y 10.";
                header("Location: correction.php?action=calificar&id=$id");
                exit;
            }
        }

        if ($fecha && DateTime::createFromFormat('Y-m-d', $fecha) !== false) {
            $db = conectarDB();
            $stmt = $db->prepare("UPDATE tfgs SET fecha = ? WHERE id = ?");
            $stmt->execute([$fecha, $id]);
        }
    
        // Requiere el mailer
        require_once __DIR__ . '/../mailer.php';
    
        // Guardado y envío de correos
        foreach ($notas as $alumnoId => $valor) {
            $c = trim($comentarios[$alumnoId] ?? '');
            uploadTfg::actualizarNota($id, (int)$alumnoId, $valor, $c);
    
            // Obtener info del usuario (incluido email)
            $usuario = uploadTfg::obtenerUsuarioPorId($alumnoId);
            if ($usuario && filter_var($usuario['email'], FILTER_VALIDATE_EMAIL)) {
                $nombreProfesor = $_SESSION['usuario']['nombre'] ?? 'El profesor';
                $link = 'https://www.pwgaaa.xyz/proyectosCalificados';
                $asunto = 'Tu TFG ha sido corregido';
    
                $mensaje = "
                    <p>Hola <strong>{$usuario['nombre']}</strong>,</p>
                    <p>El profesor <strong>{$nombreProfesor}</strong> ha corregido tu Trabajo de Fin de Grado.</p>
                    <p>Puedes consultar tu nota en el siguiente enlace:</p>
                    <p><a href='{$link}'>{$link}</a></p>
                    <p>Gracias por usar la plataforma <strong>PWGAAA</strong>.</p>
                ";
    
                enviarCorreo($usuario['email'], $asunto, $mensaje);
            }
        }
    
        header('Location: proyectosCalificados?validacion=ok');
        exit;
    }
}
