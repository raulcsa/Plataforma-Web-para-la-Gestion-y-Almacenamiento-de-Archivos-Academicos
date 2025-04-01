<?php
session_start();
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
$campo = isset($_GET['campo']) ? trim($_GET['campo']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Función para resaltar el término de búsqueda
function highlight($text, $search) {
    if ($search === "") return $text;
    return preg_replace('/(' . preg_quote($search, '/') . ')/i', '<strong>$1</strong>', $text);
}

// Función para truncar el resumen a un límite de caracteres (por ejemplo, 200)
function truncateText($text, $limit = 200) {
    if (strlen($text) > $limit) {
        return substr($text, 0, $limit) . '...';
    }
    return $text;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Home - PWGAAA</title>
  <!-- Importa Google Fonts para "Open Sans" -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
    }
    .tfg-card {
      margin-bottom: 1.5rem;
    }
    .tfg-title {
      color: #007bff; /* Ajusta el color según la imagen de referencia */
      text-decoration: underline;
      margin-bottom: 0.5rem;
    }
    .tfg-date {
      color: #6c757d; /* Tono gris */
      margin-bottom: 0.75rem;
    }
    .tfg-summary {
      font-size: 1rem;
      line-height: 1.5;
    }
  </style>
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
    
    <!-- Formulario de búsqueda con desplegable -->
    <form method="GET" action="index.php" class="mb-4">
      <div class="input-group">
        <select name="campo" class="form-select" style="max-width: 200px;">
          <option value="" <?php echo ($campo === "") ? 'selected' : ''; ?>>Todos</option>
          <option value="titulo" <?php echo ($campo === "titulo") ? 'selected' : ''; ?>>Título</option>
          <option value="fecha" <?php echo ($campo === "fecha") ? 'selected' : ''; ?>>Fecha</option>
          <option value="palabras_clave" <?php echo ($campo === "palabras_clave") ? 'selected' : ''; ?>>Palabras Clave</option>
          <option value="resumen" <?php echo ($campo === "resumen") ? 'selected' : ''; ?>>Resumen</option>
          <option value="integrantes" <?php echo ($campo === "integrantes") ? 'selected' : ''; ?>>Integrantes</option>
        </select>
        <input type="text" class="form-control" name="busqueda" placeholder="Buscar" value="<?php echo htmlspecialchars($busqueda); ?>">
        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Buscar</button>
      </div>
    </form>
    
    <!-- Listado de TFGs en formato de tarjetas, una debajo del otro -->
    <?php if (isset($resultados) && !empty($resultados)): ?>
      <?php foreach ($resultados as $fila): ?>
        <div class="card tfg-card">
          <div class="card-body">
            <h3 class="card-title tfg-title">
              <?php 
                echo ($campo === 'titulo' || $campo === '') 
                      ? highlight(htmlspecialchars($fila['titulo']), $busqueda) 
                      : htmlspecialchars($fila['titulo']);
              ?>
            </h3>
            <p class="card-text tfg-date">
              <?php 
                echo ($campo === 'fecha' || $campo === '') 
                      ? highlight(htmlspecialchars($fila['fecha']), $busqueda) 
                      : htmlspecialchars($fila['fecha']);
              ?>
            </p>
            <p class="card-text tfg-summary">
              <?php 
                $resumenTruncado = truncateText(htmlspecialchars($fila['resumen']), 200);
                echo ($campo === 'resumen' || $campo === '') 
                      ? highlight($resumenTruncado, $busqueda) 
                      : $resumenTruncado;
              ?>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center">No se encontraron TFGs.</p>
    <?php endif; ?>

    <!-- Controles de paginación: se muestran únicamente si se ha realizado una búsqueda -->
    <?php if (!empty($busqueda) && $totalPages > 1): ?>
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
          <?php if ($page > 1): ?>
            <li class="page-item">
              <a class="page-link" href="index.php?page=<?php echo $page-1; ?>&busqueda=<?php echo urlencode($busqueda); ?>&campo=<?php echo urlencode($campo); ?>" aria-label="Anterior">
                <span aria-hidden="true"><i class="bi bi-arrow-up"></i></span>
              </a>
            </li>
          <?php endif; ?>
          <li class="page-item disabled">
            <a class="page-link" href="#"><?php echo $page; ?> de <?php echo $totalPages; ?></a>
          </li>
          <?php if ($page < $totalPages): ?>
            <li class="page-item">
              <a class="page-link" href="index.php?page=<?php echo $page+1; ?>&busqueda=<?php echo urlencode($busqueda); ?>&campo=<?php echo urlencode($campo); ?>" aria-label="Siguiente">
                <span aria-hidden="true"><i class="bi bi-arrow-down"></i></span>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>

  </div>

  <footer class="bg-primary text-white text-center py-3 mt-5">
    <div class="container">
      <p class="mb-0">&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
