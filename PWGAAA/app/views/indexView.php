<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
$campo = isset($_GET['campo']) ? trim($_GET['campo']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Función para resaltar el término de búsqueda con un toque moderno
function highlight($text, $search) {
    if ($search === "") return $text;
    return preg_replace('/(' . preg_quote($search, '/') . ')/i', '<strong class="text-indigo-600">$1</strong>', $text);
}

// Función para truncar el resumen a un límite de caracteres
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
  <title>TFGs - PWGAAA</title>
  <!-- Uso de la tipografía Inter para un look moderno -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Tailwind CSS desde CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Iconos de Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-200 text-gray-700">
  <!-- Navbar -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <a href="index.php" class="text-2xl font-bold text-indigo-600">PWGAAA</a>
      <nav class="hidden md:flex items-center space-x-6">
        <?php if (isset($_SESSION['usuario'])): ?>
          <div class="relative inline-block">
            <button id="userDropdownButton" class="flex items-center focus:outline-none text-gray-600 hover:text-indigo-600">
              <i class="bi bi-person-circle text-2xl"></i>
              <span class="ml-2"><?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?> (<?php echo htmlspecialchars($_SESSION['usuario']['rol']); ?>)</span>
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div id="userDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden z-20">
              <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
                <a href="panelAdmin.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Panel Admin</a>
              <?php else: ?>
                <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
                <a href="misproyectos.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Mis Proyectos</a>
                <a href="upload.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Subir Proyecto</a>
              <?php endif; ?>
              <div class="border-t border-gray-200"></div>
              <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Cerrar sesión</a>
            </div>
          </div>
        <?php else: ?>
          <a href="login.php" class="flex items-center text-gray-600 hover:text-indigo-600">
            <i class="bi bi-person-circle text-2xl"></i>
            <span class="ml-2">Login</span>
          </a>
        <?php endif; ?>
      </nav>
      <!-- Botón para móviles -->
      <div class="md:hidden">
        <button id="mobileMenuButton" class="text-gray-600 hover:text-indigo-600 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </div>
    <!-- Menú móvil -->
    <nav id="mobileMenu" class="md:hidden bg-white border-t border-gray-200 hidden">
      <ul class="px-4 py-2">
        <?php if (isset($_SESSION['usuario'])): ?>
          <li class="py-2">
            <a href="perfil.php" class="block text-gray-700 hover:text-indigo-600">Perfil</a>
          </li>
          <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
            <li class="py-2">
              <a href="panelAdmin.php" class="block text-gray-700 hover:text-indigo-600">Panel Admin</a>
            </li>
          <?php else: ?>
            <li class="py-2">
              <a href="misproyectos.php" class="block text-gray-700 hover:text-indigo-600">Mis Proyectos</a>
            </li>
            <li class="py-2">
              <a href="upload.php" class="block text-gray-700 hover:text-indigo-600">Subir Proyecto</a>
            </li>
          <?php endif; ?>
          <li class="py-2 border-t border-gray-200 mt-2">
            <a href="logout.php" class="block text-gray-700 hover:text-indigo-600">Cerrar sesión</a>
          </li>
        <?php else: ?>
          <li class="py-2">
            <a href="login.php" class="flex items-center text-gray-700 hover:text-indigo-600">
              <i class="bi bi-person-circle text-2xl"></i>
              <span class="ml-2">Login</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>
  
  <!-- Contenido principal -->
  <main class="max-w-7xl mx-auto px-4 py-8">
    <!-- Sección de búsqueda -->
    <section class="mb-10 text-center">
      <h1 class="text-4xl font-bold text-indigo-700 mb-6">Explora TFGs</h1>
      <form method="GET" action="index.php" class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <select name="campo" class="p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-indigo-400">
          <option value="" <?php echo ($campo === "") ? 'selected' : ''; ?>>Todos</option>
          <option value="titulo" <?php echo ($campo === "titulo") ? 'selected' : ''; ?>>Título</option>
          <option value="fecha" <?php echo ($campo === "fecha") ? 'selected' : ''; ?>>Fecha</option>
          <option value="palabras_clave" <?php echo ($campo === "palabras_clave") ? 'selected' : ''; ?>>Palabras Clave</option>
          <option value="resumen" <?php echo ($campo === "resumen") ? 'selected' : ''; ?>>Resumen</option>
          <option value="integrantes" <?php echo ($campo === "integrantes") ? 'selected' : ''; ?>>Integrantes</option>
        </select>
        <input type="text" name="busqueda" placeholder="Buscar..." value="<?= htmlspecialchars($busqueda); ?>" class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-indigo-400">
        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-500 transition-colors flex items-center">
          <i class="bi bi-search"></i>
          <span class="ml-2">Buscar</span>
        </button>
      </form>
    </section>
    
    <!-- Grid de TFGs -->
    <section class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-1">
      <?php if (isset($resultados) && !empty($resultados)): ?>
        <?php foreach ($resultados as $fila): ?>
          <article class="bg-white rounded-xl shadow hover:shadow-lg transition-shadow duration-300 p-6">
            <h2 class="text-2xl font-semibold text-indigo-700 mb-3">
              <a href="verTfg.php?id=<?= $fila['id']; ?>" class="hover:underline">
                <?= highlight(htmlspecialchars($fila['titulo']), $busqueda); ?>
              </a>
            </h2>
            <p class="text-sm text-gray-500 mb-3">
              Publicado el 
              <?php 
              $rawDate = $fila['fecha'] ?? '';
              if (!empty($rawDate)) {
                  try {
                      $formatter = new IntlDateFormatter(
                          'es-ES',
                          IntlDateFormatter::LONG,
                          IntlDateFormatter::NONE,
                          'Europe/Madrid',
                          IntlDateFormatter::GREGORIAN
                      );
                      $dateObj = new DateTime($rawDate);
                      echo highlight(htmlspecialchars($formatter->format($dateObj)), $busqueda);
                  } catch (Exception $e) {
                      echo htmlspecialchars($rawDate);
                  }
              } else {
                  echo "Sin fecha";
              }
              ?>
            </p>
            <p class="text-base text-gray-600">
              <?= highlight(truncateText(htmlspecialchars($fila['resumen']), 200), $busqueda); ?>
            </p>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-gray-500 col-span-full">No se encontraron TFGs.</p>
      <?php endif; ?>
    </section>
    
    <!-- Paginación -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
      <nav aria-label="Pagination" class="mt-10">
        <ul class="flex justify-center space-x-2">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li>
              <a href="index.php?page=<?= $i ?>&busqueda=<?= urlencode($busqueda) ?>&campo=<?= urlencode($campo) ?>" class="px-4 py-2 rounded-md <?php echo ($page == $i) ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-100'; ?>">
                <?= $i ?>
              </a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </main>
  
  <!-- Footer -->
  <footer class="bg-white shadow-inner mt-12">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?= date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>
  
  <!-- Scripts para interacción -->
  <script>
    // Toggle menú móvil
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // Toggle dropdown usuario
    const userDropdownButton = document.getElementById('userDropdownButton');
    const userDropdownMenu = document.getElementById('userDropdownMenu');
    if(userDropdownButton) {
      userDropdownButton.addEventListener('click', () => {
        userDropdownMenu.classList.toggle('hidden');
      });
    }
  </script>
</body>
</html>
