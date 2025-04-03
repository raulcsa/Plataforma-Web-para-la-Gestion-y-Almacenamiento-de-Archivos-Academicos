<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Subir TFG - PWGAAA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="index.php">PWGAAA</a>
    </div>
  </nav>

  <div class="container mt-5">
    <h2 class="text-primary mb-4">Subir un TFG</h2>

    <!-- Mensaje de error o éxito -->
    <?php if (!empty($mensaje)): ?>
      <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <form method="POST" action="upload.php" enctype="multipart/form-data">
      <!-- Título -->
      <div class="mb-3">
        <label for="tituloProyecto" class="form-label">Título del TFG</label>
        <input type="text" class="form-control" id="tituloProyecto" name="tituloProyecto" required>
      </div>

      <!-- Fecha -->
      <div class="mb-3">
        <label for="fechaProyecto" class="form-label">Fecha</label>
        <input type="date" class="form-control" id="fechaProyecto" name="fechaProyecto" required>
      </div>

      <!-- Resumen -->
      <div class="mb-3">
        <label for="resumenProyecto" class="form-label">Resumen</label>
        <textarea class="form-control" id="resumenProyecto" name="resumenProyecto" rows="3" required></textarea>
      </div>

      <!-- Palabras Clave -->
      <div class="mb-3">
        <label for="palabraClave" class="form-label">Palabras Clave</label>
        <input type="text" class="form-control" id="palabraClave" name="palabraClave" required>
      </div>
      <!-- Integrantes -->
      <div class="mb-3">
        <label for="palabraClave" class="form-label">Integrantes</label>
        <select class="form-select" id="integrantesSelect" name="integrantesSelect">
          <option value="">Todos los alumnos</option>
          
          <?php foreach ($selectVareadores as $vareador): // CAMBIAR ESTO PARA QUE MUESTRE TODOS LOS ALUMNOS DISPONIBLES  ?>
            <option value="<?= $vareador['ID'] ?>" <?= $filtroVareadorId == $vareador['ID'] ? "selected" : "" ?>>
              <?= $vareador['NOMBRE'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Archivo PDF -->
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
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

</body>

</html>