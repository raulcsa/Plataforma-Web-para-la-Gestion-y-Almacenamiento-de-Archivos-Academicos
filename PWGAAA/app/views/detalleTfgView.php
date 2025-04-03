<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// Se asume que el controlador ha definido las variables $tfg y $archivos
// $tfg: arreglo asociativo con la información del TFG (título, integrantes, fecha, palabras_clave, resumen, etc.)
// $archivos: arreglo con los archivos asociados a ese TFG
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle TFG - <?php echo htmlspecialchars($tfg['titulo']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .navbar {
            background-color: #2c3e50;
        }
        .navbar-brand, .nav-link {
            color: #ecf0f1 !important;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
        }
        .tfg-detail-title {
            color: #2980b9;
            text-decoration: underline;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }
        .tfg-label {
            font-weight: bold;
            color: #2c3e50;
        }
        .tfg-section {
            margin-bottom: 1.5rem;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }
        .btn-secondary {
            background-color: #1abc9c;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #16a085;
        }
        footer {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 15px 0;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">PWGAAA</a>
        </div>
    </nav>
    
    <div class="container">
        <h2 class="tfg-detail-title"><?php echo htmlspecialchars($tfg['titulo']); ?></h2>
        <div class="tfg-section">
            <span class="tfg-label">Autor(es):</span>
            <?php echo htmlspecialchars($tfg['integrantes_nombres']); ?>
        </div>
        <div class="tfg-section">
            <span class="tfg-label">Fecha de publicación:</span>
            <?php echo htmlspecialchars($tfg['fecha']); ?>
        </div>
        <div class="tfg-section">
            <span class="tfg-label">Palabras clave:</span>
            <?php echo htmlspecialchars($tfg['palabras_clave']); ?>
        </div>
        <div class="tfg-section">
            <span class="tfg-label">Resumen:</span>
            <p><?php echo nl2br(htmlspecialchars($tfg['resumen'])); ?></p>
        </div>

        <!-- Sección para mostrar el PDF asociado -->
        <?php if (!empty($archivos)): ?>
            <?php foreach ($archivos as $archivo): ?>
                <?php 
                    // Se obtiene la extensión del archivo para verificar si es PDF.
                    $extension = strtolower(pathinfo($archivo['ruta'], PATHINFO_EXTENSION));
                    if ($extension === 'pdf'): 
                ?>
                    <div class="pdf-container">
                        <h5 class="tfg-label">Ficheros subidos:</h5>
                        <!-- Enlace para abrir el PDF en una nueva pestaña -->
                        <a href="<?php echo htmlspecialchars($archivo['ruta']); ?>" target="_blank">
                            <img src="../PDF/pdf_img.png" alt="Icono PDF" style="width: 80px;">
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary w-100 mt-3">Volver al listado</a>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
