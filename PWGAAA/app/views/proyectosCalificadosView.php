<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$mostrarPopup = isset($_GET['validacion']) && $_GET['validacion'] === 'ok';


// Función para truncar el resumen a 200 caracteres
function truncateText($text, $limit = 200) {
    return (strlen($text) > $limit) ? substr($text, 0, $limit) . '...' : $text;
}

// Función para formatear una fecha en el formato "12 de enero de 2012"
function formatDate($dateString) {
    try {
        $dateObj = new DateTime($dateString);
        $formatter = new IntlDateFormatter(
            'es-ES', 
            IntlDateFormatter::LONG, 
            IntlDateFormatter::NONE, 
            'Europe/Madrid',
            IntlDateFormatter::GREGORIAN
        );
        return $formatter->format($dateObj);
    } catch (Exception $e) {
        return htmlspecialchars($dateString);
    }
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

  <title>Proyectos Calificados - TFCloud</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <style>
  .animate-fade-in {
    animation: fadeIn 0.7s ease-in-out;
  }
  .animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out;
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  @keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
  }

  .transition-all {
    transition: all 0.3s ease;
  }
  .rotate-180 {
    transform: rotate(180deg);
  }
  .slide-toggle {
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    transition: max-height 0.4s ease, opacity 0.4s ease;
  }
  .slide-toggle.active {
    max-height: 1000px; /* Suficiente para cualquier contenido */
    opacity: 1;
  }
</style>

</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-200 text-gray-700 flex flex-col min-h-screen">

  <!-- Header / Navbar -->
  <?php require_once __DIR__ . '/../views/navbarView.php'; ?>
  <!-- Mensaje de feedback -->
  <?php if ($mostrarPopup): ?>
  <div id="popupNoti" class="max-w-xl mx-auto mt-6 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded shadow text-center">
  ✅ TFG corregido y evaluado correctamente.
  </div>
  <script>
    // Ocultar popup a los 5 segundos
    setTimeout(() => {
      const popup = document.getElementById('popupNoti');
      if (popup) popup.remove();
    }, 5000);

    // Eliminar parámetro ?validacion=ok de la URL sin recargar
    if (window.history.replaceState) {
      const url = new URL(window.location);
      url.searchParams.delete('validacion');
      window.history.replaceState({}, document.title, url.pathname + url.search);
    }
  </script>
<?php endif; ?>

  
  <!-- Contenido principal -->
  <main class="flex-grow container mx-auto px-4 py-12 relative">
  <section class="text-center mb-12">
    <h1 class="text-4xl font-extrabold text-indigo-700 tracking-tight animate-fade-in">
      Proyectos Calificados
    </h1>
    <p class="mt-2 text-gray-600">Consulta las calificaciones y comentarios de los TFG evaluados</p>
  </section>

  <!-- Buscador -->
<form method="GET" action="proyectosCalificados" class="max-w-3xl mx-auto mb-8 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
  <input type="text" name="busqueda" placeholder="Buscar TFG por título, resumen, autor..." value="<?= htmlspecialchars($_GET['busqueda'] ?? '') ?>" class="p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
  
  <select name="campo" class="p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
    <option value="">Todos los campos</option>
    <option value="titulo" <?= ($_GET['campo'] ?? '') === 'titulo' ? 'selected' : '' ?>>Título</option>
    <option value="palabras_clave" <?= ($_GET['campo'] ?? '') === 'palabras_clave' ? 'selected' : '' ?>>Palabras clave</option>
    <option value="resumen" <?= ($_GET['campo'] ?? '') === 'resumen' ? 'selected' : '' ?>>Resumen</option>
    <option value="fecha" <?= ($_GET['campo'] ?? '') === 'fecha' ? 'selected' : '' ?>>Fecha</option>
    <option value="integrantes" <?= ($_GET['campo'] ?? '') === 'integrantes' ? 'selected' : '' ?>>Integrantes</option>
  </select>

  <button type="submit" class="p-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all">
    Buscar
  </button>

  <a href="proyectosCalificados" class="p-3 text-center bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all">Reiniciar</a>
</form>


  <?php if (!empty($resultados)): ?>
    <section class="grid gap-10 sm:grid-cols-1 md:grid-cols-2">
      <?php foreach ($resultados as $fila): ?>
        <article class="bg-white border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all p-6 animate-fade-in-up">
          <h2 class="text-lg font-semibold text-indigo-700 mb-2">
            <a href="verTfg?id=<?= $fila['id']; ?>" class="hover:underline">
              <?= htmlspecialchars($fila['titulo']); ?>
            </a>
          </h2>
          <p class="text-sm text-gray-500 mb-2">
            Publicado el <?= formatDate($fila['fecha']); ?>
          </p>
          <p class="text-sm text-gray-700">
            <?= htmlspecialchars(truncateText($fila['resumen'], 200)); ?>
          </p>
          <?php if (in_array($_SESSION['usuario']['rol'], ['admin', 'profesor'])): ?>
            <button type="button"
              class="mt-4 flex items-center gap-1 text-sm text-indigo-600 hover:underline focus:outline-none transition-all"
              onclick="toggleNotas(this, 'notas-<?= $fila['id']; ?>')"
              >
              <span>Ver calificaciones</span>
              <i class="bi bi-chevron-down transition-all duration-300"></i>
            </button>
            <div id="notas-<?= $fila['id']; ?>" class="slide-toggle mt-4 bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded">
              <?php if (!empty($fila['calificaciones'])): ?>
                <?php foreach ($fila['calificaciones'] as $nota): ?>
                  <div class="mb-3">
                    <p class="font-medium text-gray-800"><?= htmlspecialchars($nota['nombre']); ?></p>
                    <p class="text-sm text-indigo-700">Nota: <?= htmlspecialchars($nota['nota']); ?></p>
                    <?php if (!empty($nota['comentario'])): ?>
                      <p class="text-sm text-gray-600 mt-1">
                        <span class="font-medium">Comentario:</span> <?= nl2br(htmlspecialchars($nota['comentario'])); ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <hr class="my-2 border-gray-300">
                <?php endforeach; ?>
              <?php else: ?>
                <p class="text-sm text-gray-500">No hay notas registradas.</p>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </section>

    <?php if ($totalPages > 1): ?>
      <nav aria-label="Paginación" class="mt-12">
        <ul class="flex justify-center flex-wrap gap-2">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li>
              <a href="?page=<?= $i; ?>" class="px-4 py-2 rounded-lg text-sm transition-all duration-200 <?php echo ($i === $page) ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-100'; ?>">
                <?= $i; ?>
              </a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    <?php endif; ?>
  <?php else: ?>
    <p class="text-center text-gray-600 text-lg animate-fade-in">No hay proyectos calificados.</p>
  <?php endif; ?>
</main>

  
  <!-- Footer -->
  <footer class="bg-gray-100 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?= date('Y'); ?> TFCloud. Todos los derechos reservados.</p>
    </div>
  </footer>
  
  <!-- Scripts para el menú móvil y dropdown -->
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
    if (userDropdownButton) {
      userDropdownButton.addEventListener('click', () => {
        userDropdownMenu.classList.toggle('hidden');
      });
    }
  </script>
  <script>
function toggleNotas(id) {
  const notasDiv = document.getElementById(id);
  if (notasDiv) {
    notasDiv.classList.toggle('hidden');
  }
}

function toggleNotas(button, id) {
  const notasDiv = document.getElementById(id);
  const icon = button.querySelector('i');

  if (notasDiv.classList.contains('active')) {
    notasDiv.classList.remove('active');
    icon.classList.remove('rotate-180');
  } else {
    notasDiv.classList.add('active');
    icon.classList.add('rotate-180');
  }
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
