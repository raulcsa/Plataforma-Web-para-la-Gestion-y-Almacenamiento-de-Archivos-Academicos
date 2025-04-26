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
  <title>Proyectos por Calificar - PWGAAA</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-gray-200 text-gray-700">
<?php require_once __DIR__ . '/../views/navbarView.php'; ?>
  <!-- Main Content -->
  <main class="flex-grow container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Proyectos por Calificar</h1>
    <?php if (!empty($resultados)): ?>
      <div class="space-y-6">
        <?php foreach ($resultados as $fila): ?>
          <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-xl font-semibold text-indigo-600 mb-2">
              <a href="editarTfg?id=<?= $fila['id']; ?>">
                <?= htmlspecialchars($fila['titulo']); ?>
              </a>
            </h3>
            <p class="text-gray-500 mb-2">Publicado el <?= formatDate($fila['fecha']); ?></p>
            <p class="text-gray-700"><?= htmlspecialchars(truncateText($fila['resumen'], 200)); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      
      <!-- Paginación -->
      <?php if ($totalPages > 1): ?>
        <nav class="mt-6 flex justify-center">
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
      <p class="text-center text-gray-600">No hay proyectos por calificar.</p>
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
