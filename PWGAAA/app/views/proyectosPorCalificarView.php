<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Función que trunca el texto a una longitud determinada.
 */
function truncateText($text, $limit = 200) {
    return (strlen($text) > $limit) ? substr($text, 0, $limit) . '...' : $text;
}

/**
 * Función para formatear una fecha en un estilo largo en español.
 * Por ejemplo: "12 de enero de 2012".
 */
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

  <title>Proyectos por Calificar - TFCloud</title>
  <!-- Tailwind CSS CDN -->
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
    0% {
      opacity: 0;
      transform: translateY(20px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

</head>
<body class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-200 text-gray-700">
<?php require_once __DIR__ . '/../views/navbarView.php'; ?>
  <!-- Main Content -->
  <main class="flex-grow container mx-auto px-4 py-12 relative">
  <section class="text-center mb-12">
    <h1 class="text-4xl font-extrabold text-indigo-700 tracking-tight animate-fade-in">
      Proyectos por Calificar
    </h1>
    <p class="mt-2 text-gray-600">Consulta y califica los TFGs pendientes de revisión</p>
  </section>

  <?php if (!empty($resultados)): ?>
    <section class="grid gap-10 sm:grid-cols-1 md:grid-cols-2">
      <?php foreach ($resultados as $fila): ?>
        <article class="bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-lg transition-shadow p-6 relative overflow-hidden animate-fade-in-up">
          <h2 class="text-lg font-semibold text-indigo-700 mb-2">
            <a href="editarTfg?id=<?= $fila['id']; ?>" class="hover:underline">
              <?= htmlspecialchars($fila['titulo']); ?>
            </a>
          </h2>
          <p class="text-sm text-gray-500 mb-3">
            Publicado el <?= formatDate($fila['fecha']); ?>
          </p>
          <p class="text-sm text-gray-700">
            <?= htmlspecialchars(truncateText($fila['resumen'], 200)); ?>
          </p>
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
    <p class="text-center text-gray-600 text-lg animate-fade-in">
      No hay proyectos por calificar.
    </p>
  <?php endif; ?>
</main>

  
  <!-- Footer -->
  <footer class="bg-white shadow-inner mt-12">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?= date('Y'); ?> TFCloud. Todos los derechos reservados.</p>
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
  
    // Toggle dropdown usuario (Desktop)
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
