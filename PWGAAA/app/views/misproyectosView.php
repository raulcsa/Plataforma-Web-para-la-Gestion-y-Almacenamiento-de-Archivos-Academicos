<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$fmt = new IntlDateFormatter(
    'es_ES',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
    'Europe/Madrid',
    IntlDateFormatter::GREGORIAN
);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Proyectos - TFCloud</title>
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

  <!-- Tailwind CSS desde CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Usamos la tipografía Inter para un look moderno -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Iconos de Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

  @keyframes fade-in {
    0% { opacity: 0; transform: translateY(10px); }
    100% { opacity: 1; transform: translateY(0); }
  }
  .animate-fade-in {
    animation: fade-in 0.5s ease-out both;
  }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-200 flex flex-col">
<?php require_once __DIR__ . '/../views/navbarView.php'; ?>
  
  <!-- Contenido principal -->
  <main class="flex-grow container mx-auto px-4 py-12">
  <h1 class="mb-10 text-4xl font-extrabold text-center text-indigo-700 animate-fade-in">Mis Proyectos</h1>

  <?php if (!empty($proyectos)): ?>
    <div class="grid gap-8 animate-fade-in">
      <?php foreach ($proyectos as $proyecto): ?>
        <div class="bg-white border border-gray-200 rounded-2xl shadow hover:shadow-lg transition p-6">
          <h3 class="text-xl font-semibold text-indigo-700 mb-2">
            <a href="verTfg?id=<?= $proyecto['id']; ?>" class="hover:underline">
              <?= htmlspecialchars($proyecto['titulo']); ?>
            </a>
          </h3>
          <p class="text-sm text-gray-500 mb-2">
            Publicado el 
              <?php
                $fecha = $proyecto['fecha'] ?? '';
                  if (!empty($fecha)) {
                    try {
                      $dateObj = new DateTime($fecha);
                      echo htmlspecialchars($fmt->format($dateObj));
                    } catch (Exception $e) {
                      echo htmlspecialchars($fecha);
                    }
                } else {
                echo "Sin fecha";
                }
              ?>
          </p>
          <p class="text-gray-700 text-sm leading-relaxed">
            <?= nl2br(htmlspecialchars($proyecto['resumen'])); ?>
          </p>

          <?php if (isset($proyecto['nota'])): ?>
            <div class="mt-4 px-4 py-3 bg-indigo-50 border-l-4 border-indigo-500 rounded">
              <span class="block text-sm font-semibold text-gray-700">Nota:</span>
              <p class="mt-1 text-gray-900"><?= htmlspecialchars($proyecto['nota']); ?></p>
            </div>
          <?php endif; ?>

          <?php if (!empty($proyecto['comentario'])): ?>
            <div class="mt-3 px-4 py-3 bg-indigo-50 border-l-4 border-indigo-500 rounded">
              <span class="block text-sm font-semibold text-gray-700">Comentario:</span>
              <p class="mt-1 text-gray-900"><?= nl2br(htmlspecialchars($proyecto['comentario'])); ?></p>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="text-center text-gray-600 animate-fade-in">No tienes proyectos asociados.</p>
  <?php endif; ?>
</main>

  
  
  <!-- Footer -->
  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?php echo date('Y'); ?> TFCloud. Todos los derechos reservados.</p>
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
