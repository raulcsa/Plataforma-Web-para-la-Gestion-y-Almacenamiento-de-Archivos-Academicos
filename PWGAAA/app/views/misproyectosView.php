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
  <!-- Navbar -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="index.php" class="text-2xl font-bold text-indigo-600">PWGAAA</a>
      <nav>
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
              <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
              <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                <a href="panelAdmin.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Panel Admin</a>
              <?php else: ?>
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
  <main class="flex-grow container mx-auto px-4 py-8">
    <h1 class="mb-6 text-3xl font-semibold text-indigo-600 text-center">Mis Proyectos</h1>

    <?php if (!empty($proyectos)): ?>
      <div class="space-y-10">
        <?php foreach ($proyectos as $proyecto): ?>
          <div class="bg-white rounded-md shadow p-3">
            <h3 class="text-md font-bold text-indigo-600 mb-1">
              <a href="verTfg.php?id=<?php echo $proyecto['id']; ?>" class="hover:underline">
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
              <p class="text-sm text-gray-800">
                <strong>Nota:</strong> <?php echo htmlspecialchars($proyecto['nota']); ?>
              </p>
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
