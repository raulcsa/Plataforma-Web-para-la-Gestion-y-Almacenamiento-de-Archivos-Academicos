<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function truncateText($text, $limit = 200) {
    return (strlen($text) > $limit) ? substr($text, 0, $limit) . '...' : $text;
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
                <?php if ($_SESSION['usuario']['rol'] === 'profesor'): ?>
                <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
                <a href="proyectosPorCalificar.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos por calificar</a>
                <a href="proyectosCalificados.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos Calificados</a>
              <?php endif; ?>
              <div class="border-t border-gray-200"></div>
              <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Cerrar sesión</a>
            </div>
          </div>
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
          <?php if ($_SESSION['usuario']['rol'] === 'profesor'): ?>
            <li class="py-2">
            <a href="proyectosPorCalificar.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos por calificar</a>
            <a href="proyectosCalificados.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos Calificados</a>
            </li>
          <?php endif; ?>
          <li class="py-2 border-t border-gray-200 mt-2">
            <a href="logout.php" class="block text-gray-700 hover:text-indigo-600">Cerrar sesión</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>
  <section class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-1">
  <div class="container mt-5">
    <h1 class="mb-4">Proyectos Calificados</h1>
    <?php if (!empty($resultados)): ?>
      <?php foreach ($resultados as $fila): ?>
        <div class="card mb-3">
          <div class="card-body">
            <h3 class="card-title">
              <a href="verTfg.php?id=<?= $fila['id']; ?>">
                <?= htmlspecialchars($fila['titulo']); ?>
              </a>
            </h3>
            <p class="card-text text-muted">Publicado el <?= htmlspecialchars($fila['fecha']); ?></p>
            <p class="card-text"><?= htmlspecialchars(truncateText($fila['resumen'])); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
      <!-- Paginación -->
      <?php if ($totalPages > 1): ?>
        <nav>
          <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?= ($i === $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      <?php endif; ?>
    <?php else: ?>
      <p>No hay proyectos calificados.</p>
    <?php endif; ?>
  </div>
  </section>
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