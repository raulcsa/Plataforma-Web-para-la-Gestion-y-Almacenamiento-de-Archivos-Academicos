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
            color:rgb(37, 53, 68);
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }
        .tfg-label {
            font-weight: bold;
            color:rgb(44, 62, 80);
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
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <?php if (isset($_SESSION['usuario'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
                <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                  <li><a class="dropdown-item" href="panelAdmin.php">Panel Admin</a></li>
                <?php else: ?>
                  <li><a class="dropdown-item" href="misproyectos.php">Mis Proyectos</a></li>
                  <li><a class="dropdown-item" href="upload.php">Subir Proyecto</a></li>
                <?php endif; ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="login.php"><i class="bi bi-person-circle"></i> Login</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
    
    <div class="container">
        <h2 class="tfg-detail-title">Título: <?php echo htmlspecialchars($tfg['titulo']); ?></h2>
        <div class="tfg-section">
            <span class="tfg-label">Autor(es):</span>
            <?php echo htmlspecialchars($tfg['integrantes_nombres']); ?>
        </div>
        <div class="tfg-section">
            <span class="tfg-label">Fecha de publicación: </span>
            <?php 
                $formatter = new IntlDateFormatter(
                    'es-ES',
                    IntlDateFormatter::LONG,
                    IntlDateFormatter::NONE,
                    'Europe/Madrid',
                    IntlDateFormatter::GREGORIAN
                );
                $date = new DateTime($tfg['fecha_subida']);
                echo $formatter->format($date);
            ?>
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
