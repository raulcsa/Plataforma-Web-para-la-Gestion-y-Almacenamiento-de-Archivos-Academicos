<?php
// app/controllers/CorrectionController.php

require_once __DIR__ . '/../models/index.php';        // para Tfg::actualizar()
require_once __DIR__ . '/../models/subidaProyectos.php'; // para uploadTfg::registrarArchivo()
require_once __DIR__ . '/../../config/database.php';     // para conectarDB()

class CorrectionController {

    /**
     * Muestra el formulario de edición (o detalle) de un TFG.
     */
    public function editar(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Sólo profesores y admins pueden editar; otros verán sólo el detalle
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

    /**
     * Procesa el POST de edición y guarda cambios.
     */
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

        // 1) Validaciones mínimas
        if (empty($titulo) || empty($resumen) || empty($keywords) || count($integrantes) < 1) {
            $_SESSION['mensaje'] = 'Rellena todos los campos y al menos un integrante.';
            header("Location: editarTfg.php?id=$id");
            exit;
        }

        // 2) Actualizamos los datos del TFG (tfgs + notas)
        Tfg::actualizar($id, $titulo, $resumen, $keywords, $integrantes);

        // 2) Procesar sustitución de PDF si se ha enviado uno nuevo
        if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === 0) {
            $ext = strtolower(pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                // 2.a) Obtenemos el registro actual en 'archivos' para borrar el anterior
                $old = uploadTfg::obtenerArchivoPorTfg($id); 
                // Debes implementar este método (o consulta) en tu model para traer:
                // nombre, ruta, y ruta fisica si quieres, p.ej.:
                // SELECT nombre, ruta FROM archivos WHERE tfg_id = ? LIMIT 1
                if ($old) {
                    // Ruta física del antiguo
                    $oldPath = dirname(__DIR__,2) . '/PDF/' . basename($old['ruta']);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                    // Y eliminar el registro en la tabla
                    uploadTfg::borrarRegistroArchivo($id);
                    // Implementa borrarRegistroArchivo() con:
                    // DELETE FROM archivos WHERE tfg_id = ?
                }
    
                // 2.b) Guardamos el nuevo PDF
                $final     = uniqid('tfg_') . '.pdf';
                $publicUrl = '../PDF/' . $final;           // lo que guardas en BD
                $diskPath  = dirname(__DIR__,2) . '/PDF/' . $final; // dónde se guarda en disco
    
                if (move_uploaded_file($_FILES['pdf']['tmp_name'], $diskPath)) {
                    // 2.c) Insertar el nuevo registro en la tabla archivos
                    uploadTfg::registrarArchivo($id, $final, $publicUrl, 'pdf', $_FILES['pdf']['size']);
                } else {
                    $_SESSION['mensaje'] = 'No se pudo subir el nuevo PDF.';
                    header("Location: editarTfg.php?id=$id");
                    exit;
                }
            }
        }
    // 3) Finalmente redirigir de vuelta a pendientes
    header('Location: proyectosPorCalificar.php');
    exit;
}
    // GET  /correction.php?action=calificar&id=123
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

    // POST /correction.php?action=validar&id=123
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

        // Validar que cada alumno tenga nota del 1 al 10
        foreach ($notas as $alumnoId => $valor) {
            $n = floatval($valor);
            if ($n < 1 || $n > 10) {
                $_SESSION['mensaje'] = "La nota de cada alumno debe estar entre 1 y 10.";
                header("Location: correction.php?action=calificar&id=$id");
                exit;
            }
        }

        // Guardar cada nota+comentario
        foreach ($notas as $alumnoId => $valor) {
            $c = trim($comentarios[$alumnoId] ?? '');
            uploadTfg::actualizarNota($id, (int)$alumnoId, $valor, $c);
        }

        // Al terminar, redirigimos a proyectos ya calificados
        header('Location: proyectosCalificados.php');
        exit;
    }
}