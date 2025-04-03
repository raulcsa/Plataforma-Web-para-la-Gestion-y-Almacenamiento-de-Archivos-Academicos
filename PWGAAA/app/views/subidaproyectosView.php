<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Subir TFG - PWGAAA</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
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
    .navbar-brand {
        font-weight: bold;
    }
    .container {
        max-width: 600px;
        margin-top: 50px;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }
    .btn-primary {
        background-color: #1abc9c;
        border: none;
    }
    .btn-primary:hover {
        background-color: #16a085;
    }
    footer {
        background-color: #2c3e50;
        color: #ecf0f1;
        padding: 15px 0;
        margin-top: 30px;
        text-align: center;
    }
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

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="index.php">PWGAAA</a>
  </div>
</nav>

<div class="container">
  <h2 class="text-primary mb-4">Subir un TFG</h2>

  <?php if (!empty($mensaje)): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
  <?php endif; ?>

  <form method="POST" action="" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="tituloProyecto" class="form-label">Título del TFG</label>
      <input type="text" class="form-control" id="tituloProyecto" name="tituloProyecto" required>
    </div>

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

<footer>
  <p>&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
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
