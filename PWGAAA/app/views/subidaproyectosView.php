<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Subir TFG - PWGAAA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .select2-container--default .select2-selection--multiple {
      background-color: #f8f9fa;
      border: 1px solid #ced4da;
      border-radius: 0.375rem;
      padding: 0.375rem;
      min-height: 38px;
    }
    .select2-selection__choice {
      background-color: #0d6efd;
      color: black;
      border: none;
      border-radius: 0.2rem;
      padding: 0.2rem 0.4rem;
    }
  </style>
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
    <h2 class="text-primary mb-4">Subir un TFG</h2>

    <?php if (!empty($mensaje)): ?>
      <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="tituloProyecto" class="form-label">Título del TFG</label>
        <input type="text" class="form-control" id="tituloProyecto" name="tituloProyecto" required>
      </div>

      <!-- Se ha eliminado el campo de fecha, pues se usará automáticamente la fecha de subida -->

      <div class="mb-3">
        <label for="resumenProyecto" class="form-label">Resumen</label>
        <textarea class="form-control" id="resumenProyecto" name="resumenProyecto" rows="3" required></textarea>
      </div>

      <div class="mb-3">
        <label for="palabraClave" class="form-label">Palabras Clave</label>
        <input type="text" class="form-control" id="palabraClave" name="palabraClave" required>
      </div>

      <div class="mb-3">
        <label for="integrantesSelect" class="form-label">Selecciona hasta 2 alumnos adicionales</label>
        <select class="form-select" id="integrantesSelect" name="integrantesSelect[]" multiple="multiple">
          <?php foreach ($selectUsuarios as $alumno): ?>
            <option value="<?= $alumno['id'] ?>"><?= $alumno['nombre'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="fileToUpload" class="form-label">Subir Archivo (PDF)</label>
        <input type="file" class="form-control" id="fileToUpload" name="fileToUpload" accept=".pdf" required>
      </div>

      <button type="submit" class="btn btn-primary">
        <i class="bi bi-file-earmark-arrow-up"></i> Subir TFG
      </button>
    </form>
  </div>

  <footer class="bg-primary text-white text-center py-3 mt-5">
    <div class="container">
      <p class="mb-0">&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
  <script>
    // Activar Select2 con máximo de 2 selecciones
    $(document).ready(function() {
      $('#integrantesSelect').select2({
        placeholder: "Selecciona hasta 2 alumnos adicionales",
        maximumSelectionLength: 2,
        width: '100%',
        language: {
          maximumSelected: function () {
            return "Solo puedes seleccionar hasta 2 alumnos adicionales";
          }
        }
      });
    });
  </script>
</body>
</html>
