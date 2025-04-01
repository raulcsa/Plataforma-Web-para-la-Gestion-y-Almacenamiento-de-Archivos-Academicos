<?php
require_once __DIR__ . '/../models/uploadtfg.php';
require_once __DIR__ . '/../models/upload.php';

class UploadController {
    public function upload() {
        $mensaje = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del formulario
            $tituloProyecto   = trim($_POST['tituloProyecto']);
            $resumenProyecto  = trim($_POST['resumenProyecto']);
            $palabraClave     = trim($_POST['palabraClave']);
            
            // Validar que se haya subido el archivo correctamente
            if (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] !== UPLOAD_ERR_OK) {
                $mensaje = "Error en la subida del archivo.";
            } else {
                $file = $_FILES['fileToUpload'];
                $nombreOriginal = $file['name'];
                $tipo = $file['type'];
                $tamaño = $file['size'];
                $tempPath = $file['tmp_name'];
                
                // Definir carpeta de subida (asegúrate de que existe y tiene permisos)
                $uploadDir = __DIR__ . '/../../uploads';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // Generar un nombre único para evitar colisiones
                $uniqueName = uniqid() . "_" . $nombreOriginal;
                $uploadPath = $uploadDir . $uniqueName;
                
                // Mover el archivo a la carpeta de destino
                if (move_uploaded_file($tempPath, $uploadPath)) {
                    // Inserción del TFG
                    // En este ejemplo, no se recoge el campo "integrantes", lo dejamos como null
                    $tfg_id = Tfg::crear($tituloProyecto, $resumenProyecto, $palabraClave, null);
                    
                    // Ruta relativa para guardar en la base de datos
                    $relativePath = "uploads/" . $uniqueName;
                    
                    // Inserción del archivo en la tabla archivos
                    // Usamos el resumen como descripción (puedes cambiarlo según tus necesidades)
                    Archivo::subir($tfg_id, $nombreOriginal, $relativePath, $tipo, $tamaño, $resumenProyecto);
                    
                    $mensaje = "El TFG y el archivo se han subido correctamente.";
                } else {
                    $mensaje = "Error al mover el archivo a la carpeta de destino.";
                }
            }
        }
        
        // Cargar la vista, pasando el mensaje
        require_once __DIR__ . '/../views/uploadView.php';
    }
}
