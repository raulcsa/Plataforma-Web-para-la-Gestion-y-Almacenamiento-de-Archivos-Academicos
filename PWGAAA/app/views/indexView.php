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
  <title>Página de Inicio - PWGAAA</title>
  <!-- Uso de la tipografía Inter para un look moderno -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Tailwind CSS desde CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Iconos de Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
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
      color: rgb(18, 136, 112);
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
<?php require_once __DIR__ . '/../views/navbarView.php'; ?>

  <main class="max-w-7xl mx-auto px-4 py-8">
    <!-- Sección de búsqueda -->
    <section class="mb-10 text-center">
      <h1 class="text-4xl font-bold text-indigo-700 mb-6">Explora TFGs</h1>
      <form method="GET" action="index" class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <select name="campo" class="p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-indigo-400">
          <option value="" <?php echo ($campo === "") ? 'selected' : ''; ?>>Todos</option>
          <option value="titulo" <?php echo ($campo === "titulo") ? 'selected' : ''; ?>>Título</option>
          <option value="fecha" <?php echo ($campo === "fecha") ? 'selected' : ''; ?>>Fecha</option>
          <option value="palabras_clave" <?php echo ($campo === "palabras_clave") ? 'selected' : ''; ?>>Palabras Clave</option>
          <option value="resumen" <?php echo ($campo === "resumen") ? 'selected' : ''; ?>>Resumen</option>
        </select>
        <input type="text" name="busqueda" placeholder="Buscar..." value="<?= htmlspecialchars($busqueda); ?>" class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-indigo-400">
        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-500 transition-colors flex items-center">
          <i class="bi bi-search"></i>
          <span class="ml-2">Buscar</span>
        </button>
      </form>
      
      <!-- Mostrar el número total de resultados encontrados en la búsqueda -->
      <?php if ($busqueda !== ""): ?>
        <p class="mt-4 text-center text-gray-600">Se han encontrado <?= htmlspecialchars($total) ?> resultado(s).</p>
      <?php endif; ?>
    </section>
    
    <!-- Grid de TFGs -->
    <section class="grid gap-8 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2">
      <?php if (isset($resultados) && !empty($resultados)): ?>
        <?php foreach ($resultados as $fila): ?>
          <article class="bg-white rounded-xl shadow hover:shadow-lg transition-shadow duration-300 p-6">
            <h2 class="text-2xl font-semibold text-indigo-700 mb-3">
              <a href="verTfg?id=<?= $fila['id']; ?>" class="hover:underline">
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
              <a href="index?page=<?= $i ?>&busqueda=<?= urlencode($busqueda) ?>&campo=<?= urlencode($campo) ?>" class="px-4 py-2 rounded-md <?php echo ($page == $i) ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-100'; ?>">
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
      <p class="mb-0">&copy; <?= date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
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
