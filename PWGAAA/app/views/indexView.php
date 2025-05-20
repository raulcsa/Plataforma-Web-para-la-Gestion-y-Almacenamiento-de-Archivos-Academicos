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
  <!-- Navegadores de escritorio -->
  <link rel="icon" href="/PDF/logo.ico" type="image/x-icon">
  <link rel="icon" type="image/png" sizes="32x32" href="/PDF/logo-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/PDF/logo-16x16.png">

  <!-- Dispositivos Apple -->
  <link rel="apple-touch-icon" sizes="180x180" href="/PDF/apple-touch-icon.png">

  <!-- Android y Chrome -->
  <link rel="icon" type="image/png" sizes="192x192" href="/PDF/android-chrome-192x192.png">
  <link rel="icon" type="image/png" sizes="512x512" href="/PDF/android-chrome-512x512.png">

  <title>Página de Inicio - TFCloud</title>
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
<?php
$notificaciones = ['subida', 'registro'];
$parametroActivo = null;

foreach ($notificaciones as $n) {
    if (isset($_GET[$n]) && $_GET[$n] === 'ok') {
        $parametroActivo = $n;
        break;
    }
}
?>

<?php if ($parametroActivo): ?>
  <script>
    if (window.history.replaceState) {
      const cleanUrl = window.location.origin + window.location.pathname;
      window.history.replaceState({}, document.title, cleanUrl);
    }
  </script>
<?php endif; ?>

<style>
  @keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
  }

  .animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out both;
  }

  .section-line {
    height: 4px;
    background: linear-gradient(to right, #6366f1, #8b5cf6);
    border-radius: 9999px;
    width: 60px;
    margin: 1rem auto 0 auto;
    animation: growWidth 1s ease-out forwards;
  }

  @keyframes growWidth {
    0% { width: 0; opacity: 0; }
    100% { width: 60px; opacity: 1; }
  }
</style>


</head>
<body>
<?php require_once __DIR__ . '/../views/navbarView.php'; ?>
<?php if ($parametroActivo === 'subida'): ?>
  <div id="popupNoti" class="max-w-xl mx-auto mt-6 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded shadow text-center">
  ✅ TFG subido correctamente, ahora está pendiente de ser corregido por el tutor correspondiente.
  </div>
<?php elseif ($parametroActivo === 'registro'): ?>
  <div id="popupNoti" class="max-w-xl mx-auto mt-6 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded shadow text-center">
  ✅ Registro realizado correctamente.
  </div>
<?php endif; ?>

<?php if ($parametroActivo): ?>
  <script>
    setTimeout(() => {
      const el = document.getElementById('popupNoti');
      if (el) el.remove();
    }, 5000);
  </script>
<?php endif; ?>

<main class="max-w-7xl mx-auto px-4 py-12 relative">
  <!-- HERO mejorado -->
  <section class="text-center mb-10 relative z-10">
  <div class="mx-auto max-w-3xl">
  <h2 class="text-5xl font-extrabold text-indigo-700 leading-tight animate-fade-in-up">
  Descubre los <span class="bg-indigo-100 px-2 rounded-md">mejores TFGs</span> de La Salle Institución
  </h2>
  <div class="section-line"></div>
    <p class="mt-4 text-lg text-slate-600 font-medium tracking-tight animate-fade-in-up" style="animation-delay: 0.15s;">
      Inspírate, aprende y colabora con otros estudiantes como tú.
    </p>
  </div>
</section>


  <!-- Cinta animada -->
  <section class="mb-6 text-center">
  <hr class="mb-4 border-t border-indigo-100 w-24 mx-auto">
  <p class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-medium px-6 py-2 rounded-full shadow-md animate-pulse">
    💡 “El conocimiento compartido impulsa la innovación”
  </p>
</section>


  <!-- Buscador con acento visual -->
  <section class="bg-white rounded-2xl shadow-xl p-8 mb-16 border border-gray-100">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold text-indigo-700 flex items-center gap-2">
        <i class="bi bi-search text-xl"></i> Buscar proyectos
      </h2>
    </div>
    <form method="GET" action="index" class="flex flex-col md:flex-row gap-4 items-stretch md:items-center justify-between">
      <div class="flex flex-col md:flex-row gap-4 flex-1">
        <select name="campo" class="w-full md:w-48 p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-400">
          <option value="" <?= $campo === "" ? 'selected' : ''; ?>>Todos</option>
          <option value="titulo" <?= $campo === "titulo" ? 'selected' : ''; ?>>Título</option>
          <option value="fecha" <?= $campo === "fecha" ? 'selected' : ''; ?>>Fecha</option>
          <option value="palabras_clave" <?= $campo === "palabras_clave" ? 'selected' : ''; ?>>Palabras Clave</option>
          <option value="resumen" <?= $campo === "resumen" ? 'selected' : ''; ?>>Resumen</option>
        </select>
        <input type="text" name="busqueda" placeholder="Buscar por palabra clave..." value="<?= htmlspecialchars($busqueda); ?>" class="flex-1 p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-400">
      </div>
      <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-500 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
        <i class="bi bi-search"></i><span>Buscar</span>
      </button>
    </form>
    <?php if ($busqueda !== ""): ?>
      <p class="mt-4 text-gray-500">Se han encontrado <?= htmlspecialchars($total) ?> resultado(s).</p>
    <?php endif; ?>
  </section>

  <!-- TFG Cards -->
  <section class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
    <?php if (isset($resultados) && !empty($resultados)): ?>
      <?php foreach ($resultados as $fila): ?>
        <article class="bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 relative overflow-hidden">
        <span class="absolute top-0 right-0 bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-bl-xl">TFG</span>
          <h2 class="text-lg font-semibold text-indigo-700 mb-2">
            <a href="verTfg?id=<?= $fila['id']; ?>" class="hover:underline">
              <?= highlight(htmlspecialchars($fila['titulo']), $busqueda); ?>
            </a>
          </h2>
          <p class="text-xs text-gray-500 mb-3">
            Publicado el 
            <?php
              $rawDate = $fila['fecha'] ?? '';
              if (!empty($rawDate)) {
                try {
                  $formatter = new IntlDateFormatter('es-ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE, 'Europe/Madrid', IntlDateFormatter::GREGORIAN);
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
          <p class="text-sm text-gray-600">
            <?= highlight(truncateText(htmlspecialchars($fila['resumen']), 200), $busqueda); ?>
          </p>
        </article>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-gray-500 col-span-full">No se encontraron TFGs con los criterios de búsqueda.</p>
    <?php endif; ?>
  </section>

  <!-- Paginación -->
  <?php if (isset($totalPages) && $totalPages > 1): ?>
    <nav aria-label="Paginación" class="mt-12">
      <ul class="flex justify-center flex-wrap gap-2">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li>
            <a href="index?page=<?= $i ?>&busqueda=<?= urlencode($busqueda) ?>&campo=<?= urlencode($campo) ?>" class="px-4 py-2 rounded-lg text-sm <?php echo ($page == $i) ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-100'; ?>">
              <?= $i ?>
            </a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
  <?php endif; ?>
</main>

  
  <!-- Footer -->
  <footer class="bg-indigo-700 text-white mt-20">
  <div class="max-w-7xl mx-auto px-4 py-6 text-center">
    <p class="text-sm">&copy; <?= date('Y'); ?> TFCloud - Donde los TFGs cobran vida.</p>
    <p class="text-xs text-indigo-200 mt-1">“Porque compartir el conocimiento es el primer paso hacia el cambio.”</p>
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
  <script>
// Eliminar parámetros de búsqueda de la URL una vez mostrados los resultados
if (window.history.replaceState && window.location.search.includes('busqueda')) {
    const url = new URL(window.location);
    url.searchParams.delete('busqueda');
    url.searchParams.delete('campo');
    window.history.replaceState({}, document.title, url.pathname);
}
</script>
</body>
</html>
