<?php
session_start();
// Se asume que el controlador ha definido las variables $tfg y $archivos
// $tfg: arreglo asociativo con la información del TFG (título, integrantes, fecha, palabras_clave, resumen, etc.)
// $archivos: arreglo con los archivos asociados a ese TFG
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle TFG - <?php echo htmlspecialchars($tfg['titulo']); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Fuente "Open Sans" desde Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
    }
    .tfg-detail-title {
      color: #007bff;
      text-decoration: underline;
      font-size: 1.5rem;
      margin-bottom: 1rem;
    }
    .tfg-label {
      font-weight: bold;
    }
    .tfg-section {
      margin-bottom: 1rem;
    }
    .pdf-container {
      margin-top: 2rem;
    }
  </style>
</head>
<body>
  <!-- Navbar (mismo que en el listado) -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="index.php">PWGAAA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <?php if (isset($_SESSION['usuario'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?> (<?php echo htmlspecialchars($_SESSION['usuario']['rol']); ?>)
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="usuarioDropdown">
                <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
                <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                  <li><a class="dropdown-item" href="panelAdmin.php">Panel Admin</a></li>
                <?php else: ?>
                  <li><a class="dropdown-item" href="misproyectos.php">Mis Proyectos</a></li>
                  <li><a class="dropdown-item" href="uploadtfg.php">Subir Proyecto</a></li>
                <?php endif; ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php"><i class="bi bi-person-circle"></i> Login</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  
  <div class="container mt-5">
    <h2 class="tfg-detail-title"><?php echo htmlspecialchars($tfg['titulo']); ?></h2>
    <div class="tfg-section">
      <span class="tfg-label">Autor(es):</span>
      <?php echo htmlspecialchars($tfg['integrantes']); ?>
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
            <h5 class="tfg-label">Documento PDF:</h5>
            <!-- Enlace para abrir el PDF en una nueva pestaña -->
            <a href="<?php echo htmlspecialchars($archivo['ruta']); ?>" target="_blank" class="btn btn-primary mb-2">
              Abrir PDF en nueva pestaña
            </a>
            <!-- Incrustamos el PDF inline -->
            <embed src="<?php echo htmlspecialchars($archivo['ruta']); ?>" type="application/pdf" width="100%" height="600px" />
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary mt-3">Volver al listado</a>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
