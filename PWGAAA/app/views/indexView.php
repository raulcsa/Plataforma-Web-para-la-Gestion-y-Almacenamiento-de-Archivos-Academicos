<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Home - PWGAAA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
  <!-- Navbar -->
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
              <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?> (<?php echo htmlspecialchars($_SESSION['usuario']['rol']); ?>)
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="usuarioDropdown">
                <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
                <li><a class="dropdown-item" href="misproyectos.php">Mis Proyectos</a></li>
                <li><a class="dropdown-item" href="uploadtfg.php">Subir Proyecto</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">
                <i class="bi bi-person-circle"></i> Login
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Fin Navbar -->

  <div class="container mt-5">
    <h1 class="mb-4 text-primary">Listado de TFGs</h1>

    <!-- Tabla de TFGs -->
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead class="table-primary">
          <tr>
            <th>Título</th>
            <th>Fecha</th>
            <th>Resumen</th>
            <th>Integrantes</th>
          </tr>
        </thead>
        <tbody>
          <?php if (isset($resultados) && !empty($resultados)): ?>
            <?php foreach ($resultados as $fila): ?>
              <tr>
                <td><?php echo htmlspecialchars($fila['titulo']); ?></td>
                <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
                <td><?php echo htmlspecialchars($fila['resumen']); ?></td>
                <td><?php echo htmlspecialchars($fila['integrantes']); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center">No se encontraron TFGs.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <!-- Fin Tabla -->
  </div>

  <footer class="bg-primary text-white text-center py-3 mt-5">
    <div class="container">
      <p class="mb-0">&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>