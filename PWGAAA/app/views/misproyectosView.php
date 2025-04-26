<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Proyectos - PWGAAA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-200 flex flex-col">
<?php require_once __DIR__ . '/../views/navbarView.php'; ?>
  
  <!-- Contenido principal -->
  <main class="flex-grow container mx-auto px-4 py-8">
    <h1 class="mb-6 text-3xl font-semibold text-indigo-600 text-center">Mis Proyectos</h1>

    <?php if (!empty($proyectos)): ?>
      <div class="space-y-10">
        <?php foreach ($proyectos as $proyecto): ?>
          <div class="bg-white rounded-md shadow p-3">
            <h3 class="text-md font-bold text-indigo-600 mb-1">
              <a href="verTfg?id=<?php echo $proyecto['id']; ?>" class="hover:underline">
                <?php echo htmlspecialchars($proyecto['titulo']); ?>
              </a>
            </h3>
            <p class="text-xs text-gray-500 mb-1">
              Fecha: <?php echo htmlspecialchars($proyecto['fecha']); ?>
            </p>
            <p class="text-sm text-gray-700 mb-1">
              <?php echo htmlspecialchars($proyecto['resumen']); ?>
            </p>
          <?php if (isset($proyecto['nota'])): ?>
              <div class="mt-2 p-3 bg-indigo-50 border-l-4 border-indigo-500 rounded">
              <span class="font-medium text-gray-700">Nota:</span>
              <p class="mt-1 text-gray-800"><?= htmlspecialchars($proyecto['nota']); ?></p>
            </div>
          <?php endif; ?>
          <?php if (!empty($proyecto['comentario'])): ?>
              <div class="mt-2 p-3 bg-indigo-50 border-l-4 border-indigo-500 rounded">
                <span class="font-medium text-gray-700">Comentario:</span>
                <p class="mt-1 text-gray-800"><?= nl2br(htmlspecialchars($proyecto['comentario'])); ?></p>
              </div>
          <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-gray-600">No tienes proyectos asociados.</p>
    <?php endif; ?>
  </main>
  
  
  <!-- Footer -->
  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
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
