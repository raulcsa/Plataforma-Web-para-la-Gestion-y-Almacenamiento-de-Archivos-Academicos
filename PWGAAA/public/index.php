<?php
<<<<<<< HEAD
require_once __DIR__ . '/../app/controllers/TfgController.php';

$controller = new TfgController();
$controller->index();
=======
/**
 * Función para resaltar en negrita las coincidencias del término buscado.
 *
 * @param string $text El texto a procesar.
 * @param string $keyword El término de búsqueda.
 * @return string El texto con las coincidencias envueltas en <strong>.
 */
function highlight($text, $keyword) {
    if (!$keyword) {
        return htmlspecialchars($text);
    }
    $text = htmlspecialchars($text);
    $keyword = preg_quote($keyword, '/');
    return preg_replace("/($keyword)/i", "<strong>$1</strong>", $text);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Home - PWGAAA </title>
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
            <a class="navbar-brand" href="registro.php">
              <i class="bi bi-person-circle"></i> Registrarse
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <div class="container mt-5">
    <h1 class="mb-4 text-primary">Listado de TFGs</h1>
    <div class="row mb-4">
      <div class="col-md-12">
        <form method="GET" action="index.php" class="d-flex">
          <div class="input-group">
            <select name="campo" class="form-select">
              <option value="titulo" <?php if($campo === 'titulo') echo 'selected'; ?>>Título</option>
              <option value="fecha" <?php if($campo === 'fecha') echo 'selected'; ?>>Fecha</option>
              <option value="palabras_clave" <?php if($campo === 'palabras_clave') echo 'selected'; ?>>Palabras Clave</option>
              <option value="integrantes" <?php if($campo === 'integrantes') echo 'selected'; ?>>Integrantes</option>
            </select>
            <input type="text" name="buscar" class="form-control" placeholder="Buscar..." value="<?php echo htmlspecialchars($buscar); ?>">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-search"></i> Buscar
            </button>
          </div>
        </form>
      </div>
    </div>
    
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead class="table-primary">
          <tr>
            <th>Título</th>
            <th>Fecha</th>
            <th>Resumen</th>
            <th>Palabras Clave</th>
            <th>Integrantes</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultados as $fila): ?>
          <tr>
            <td><?php echo highlight($fila['titulo'], $buscar); ?></td>
            <td><?php echo highlight($fila['fecha'], $buscar); ?></td>
            <td><?php echo highlight($fila['resumen'], $buscar); ?></td>
            <td><?php echo highlight($fila['palabras_clave'], $buscar); ?></td>
            <td><?php echo highlight($fila['integrantes'], $buscar); ?></td>
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
  </footer>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
>>>>>>> b0cc8651fb063966f03855500a3ebe116100d7c9
