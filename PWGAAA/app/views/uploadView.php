<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Archivo - PWGAAA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
          <a class="navbar-brand" href="index.php">PWGAAA</a>
      </div>
  </nav>
  
  <div class="container mt-5">
      <?php if (!empty($mensaje)): ?>
          <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
      <?php endif; ?>
      <form method="POST" action="" enctype="multipart/form-data">
          <div class="mb-3">
              <label for="tituloProyecto" class="form-label">Título</label>
              <input type="text" class="form-control" id="tituloProyecto" name="tituloProyecto" required>
          </div>
          <div class="mb-3">
              <label for="tituloProyecto" class="form-label">Fecha</label>
              <input type="date" class="form-control" id="fechaProyecto" name="fechaProyecto" required>
          </div>
          <div class="mb-3">
              <label for="resumenProyecto" class="form-label">Resumen</label>
              <input type="text" class="form-control" id="resumenProyecto" name="resumenProyecto" required>
          </div>
          <div class="mb-3">
              <label for="palabraClave" class="form-label">Palabras Clave</label>
              <input type="text" class="form-control" id="palabraClave" name="palabraClave" required>
          </div>
          <div class="mb-3">
              <label for="fileToUpload" class="form-label">Archivo</label>
              <input type="file" class="form-control" id="fileToUpload" name="fileToUpload" required>
          </div>
          <button type="submit" class="btn btn-primary">
              <i class="bi bi-file-earmark-arrow-up"></i> Subir
          </button>
      </form>
  </div>
  
  <footer class="bg-primary text-white text-center py-3 mt-5">
      <div class="container">
          <p class="mb-0">&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
      </div>
  </footer>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
