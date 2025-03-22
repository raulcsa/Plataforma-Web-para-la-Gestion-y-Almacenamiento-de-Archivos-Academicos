<?php
require_once '../config/database.php';

$conexion = conectarDB();
$mostrartfgs = "SELECT titulo, fecha, resumen, integrantes FROM tfgs";
$resultados = realizarquery($conexion, $mostrartfgs, null, true);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de TFGs</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="index.php">PWGAAA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="login.php">
              <i class="bi bi-person-circle"></i> Iniciar sesión
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <div class="container mt-5">
    <h1 class="mb-4 text-primary">Listado de TFGs</h1>
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
          <?php foreach ($resultados as $fila): ?>
          <tr>
            <td><?php echo htmlspecialchars($fila['titulo']); ?></td>
            <td><?php echo htmlspecialchars($fila['fecha']); ?></td>
            <td><?php echo htmlspecialchars($fila['resumen']); ?></td>
            <td><?php echo htmlspecialchars($fila['integrantes']); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>


  <footer class="bg-primary text-white text-center py-3 mt-5">
    <div class="container">
      <p class="mb-0">&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
