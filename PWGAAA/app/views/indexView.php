<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
$campo = isset($_GET['campo']) ? trim($_GET['campo']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Función para resaltar el término de búsqueda
function highlight($text, $search) {
    if ($search === "") return $text;
    return preg_replace('/(' . preg_quote($search, '/') . ')/i', '<strong class="text-primary">$1</strong>', $text);
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - PWGAAA</title>
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
    .tfg-card {
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
      transition: all 0.2s;
    }
    .tfg-card:hover {
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }
    .tfg-title a {
      color: #2c3e50;
      font-weight: 700;
      text-decoration: none;
    }
    .tfg-title a:hover {
      color: #1abc9c;
      text-decoration: underline;
    }
    .tfg-summary {
      font-size: 1rem;
      color: #555;
    }
    footer {
      background-color: #2c3e50;
      color: #ecf0f1;
      padding: 15px 0;
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

  <div class="container mt-5">
    <h1 class="mb-4 text-dark">Listado de TFGs</h1>
    <form method="GET" action="index.php" class="mb-4">
      <div class="input-group">
        <select name="campo" class="form-select" style="max-width: 200px;">
          <option value="" <?= $campo === "" ? 'selected' : ''; ?>>Todos</option>
          <option value="titulo" <?= $campo === "titulo" ? 'selected' : ''; ?>>Título</option>
          <option value="fecha" <?= $campo === "fecha" ? 'selected' : ''; ?>>Fecha</option>
          <option value="resumen" <?= $campo === "resumen" ? 'selected' : ''; ?>>Resumen</option>
        </select>
        <input type="text" class="form-control" name="busqueda" placeholder="Buscar" value="<?= htmlspecialchars($busqueda); ?>">
        <button class="btn btn-dark" type="submit"><i class="bi bi-search"></i> Buscar</button>
      </div>
    </form>
    <?php if (isset($resultados) && !empty($resultados)): ?>
      <?php foreach ($resultados as $fila): ?>
        <div class="card tfg-card mb-4">
          <div class="card-body">
            <h3 class="card-title tfg-title">
              <a href="verTfg.php?id=<?= $fila['id']; ?>">
                <?= highlight(htmlspecialchars($fila['titulo']), $busqueda); ?>
              </a>
            </h3>
            <p class="card-text text-muted">Publicado el <?= highlight(htmlspecialchars($fila['fecha']), $busqueda); ?></p>
            <p class="card-text tfg-summary">
              <?= highlight(truncateText(htmlspecialchars($fila['resumen']), 200), $busqueda); ?>
            </p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-muted">No se encontraron TFGs.</p>
    <?php endif; ?>
  </div>
  <footer class="text-center">
    <div class="container">
      <p class="mb-0">&copy; <?= date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>