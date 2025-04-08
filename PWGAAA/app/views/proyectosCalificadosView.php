<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

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
  <title>Proyectos Calificados - PWGAAA</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-200 text-gray-700 flex flex-col min-h-screen">

  <!-- Header / Navbar -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <a href="index.php" class="text-2xl font-bold text-indigo-600">PWGAAA</a>
      <!-- Menú para dispositivos md+ -->
      <nav class="hidden md:flex items-center space-x-6">
        <?php if (isset($_SESSION['usuario'])): ?>
          <div class="relative inline-block">
            <button id="userDropdownButton" class="flex items-center focus:outline-none text-gray-600 hover:text-indigo-600">
              <i class="bi bi-person-circle text-2xl"></i>
              <span class="ml-2"><?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?> (<?php echo htmlspecialchars($_SESSION['usuario']['rol']); ?>)</span>
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <div id="userDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden z-20">
              <?php if (strtolower(trim($_SESSION['usuario']['rol'])) === 'profesor'): ?>
                <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
                <a href="proyectosPorCalificar.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos por calificar</a>
                <a href="proyectosCalificados.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos calificados</a>
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
      <!-- Botón menú móvil -->
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
          <?php if (strtolower(trim($_SESSION['usuario']['rol'])) === 'profesor'): ?>
            <li class="py-2">
              <a href="proyectosPorCalificar.php" class="block text-gray-700 hover:text-indigo-600">Proyectos por calificar</a>
            </li>
            <li class="py-2">
              <a href="proyectosCalificados.php" class="block text-gray-700 hover:text-indigo-600">Proyectos calificados</a>
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
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Proyectos Calificados</h1>
    
    <?php if (!empty($resultados)): ?>
      <div class="space-y-6">
        <?php foreach ($resultados as $fila): ?>
          <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-xl font-semibold text-indigo-600 mb-2">
              <a href="verTfg.php?id=<?= $fila['id']; ?>">
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
      <p>&copy; <?= date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
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
</body>
</html>
