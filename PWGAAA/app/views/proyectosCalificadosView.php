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
  <main class="flex-grow container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Proyectos Calificados</h1>
    
    <?php if (!empty($resultados)): ?>
      <div class="space-y-6">
  <?php foreach ($resultados as $fila): ?>
    <div class="bg-white shadow rounded-lg p-6">
      <h3 class="text-xl font-semibold text-indigo-600 mb-2">
        <a href="verTfg?id=<?= $fila['id']; ?>">
          <?= htmlspecialchars($fila['titulo']); ?>
        </a>
      </h3>
      <p class="text-gray-500 mb-2">Publicado el <?= formatDate($fila['fecha']); ?></p>
      <p class="text-gray-700"><?= htmlspecialchars(truncateText($fila['resumen'], 200)); ?></p>

      <?php if (in_array($_SESSION['usuario']['rol'], ['admin', 'profesor'])): ?>
        <button
          type="button"
          class="mt-4 text-indigo-600 hover:underline focus:outline-none"
          onclick="toggleNotas('notas-<?= $fila['id']; ?>')"
        >
          Ver calificaciones
        </button>

        <div id="notas-<?= $fila['id']; ?>" class="hidden mt-4 bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded">
          <?php if (!empty($fila['calificaciones'])): ?>
            <?php foreach ($fila['calificaciones'] as $nota): ?>
              <div class="mb-2">
                <p class="font-semibold text-gray-800"><?= htmlspecialchars($nota['nombre']); ?></p>
                <p class="text-gray-700">Nota: <?= htmlspecialchars($nota['nota']); ?></p>
                <?php if (!empty($nota['comentario'])): ?>
                  <p class="text-gray-600 text-sm mt-1">Comentario: <?= nl2br(htmlspecialchars($nota['comentario'])); ?></p>
                <?php endif; ?>
              </div>
              <hr class="my-2 border-gray-300">
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-gray-500">No hay notas registradas.</p>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>
      </div>
      
      <!-- Paginación -->
      <?php if ($totalPages > 1): ?>
        <nav class="mt-6">
          <ul class="inline-flex -space-x-px">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li>
                <a href="?page=<?= $i; ?>" class="px-3 py-2 border border-gray-300 <?= ($i === $page) ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'; ?>">
                  <?= $i; ?>
                </a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>
    <?php else: ?>
      <p class="text-center text-gray-600">No hay proyectos calificados.</p>
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
</script>

</body>
</html>
