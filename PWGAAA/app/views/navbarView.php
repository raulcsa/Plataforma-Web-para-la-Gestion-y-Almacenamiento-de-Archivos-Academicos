<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$tiempoLimite = 300;

// Verificamos si hay una sesión activa y tiempo de último acceso
if (isset($_SESSION['ultimoAcceso'])) {
    $inactividad = time() - $_SESSION['ultimoAcceso'];
    if ($inactividad > $tiempoLimite) {
        session_unset();
        session_destroy();
        header("Location: login");
        exit;
    }
}

// Guardamos el tiempo actual como última actividad
$_SESSION['ultimoAcceso'] = time();
?>
<!-- Navbar -->
<header class="bg-white border-b shadow-sm sticky top-0 z-50">
  <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-3">
    <!-- Logo -->
    <a href="index" class="flex items-center space-x-2">
      <img src="../PDF/logo_sinfondo.png" alt="TFCloud" class="h-10 w-auto">
      <span class="text-xl font-bold text-indigo-700 hidden sm:inline">TFCloud</span>
    </a>

    <!-- Menú de navegación escritorio -->
    <nav class="hidden md:flex items-center space-x-6">
      <?php if (isset($_SESSION['usuario'])): ?>
        <div class="relative">
          <button id="userDropdownButton" class="flex items-center space-x-2 px-4 py-2 rounded-md text-gray-700 hover:text-indigo-700 focus:outline-none transition-all">
            <i class="bi bi-person-circle text-2xl"></i>
            <span class="text-sm font-medium"><?= htmlspecialchars($_SESSION['usuario']['nombre']); ?> (<?= htmlspecialchars($_SESSION['usuario']['rol']); ?>)</span>
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          <div id="userDropdownMenu" class="absolute right-0 mt-2 w-60 bg-white rounded-xl shadow-lg border border-gray-200 hidden overflow-hidden z-50">
            <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
              <a href="panelAdmin" class="block px-5 py-3 text-sm hover:bg-indigo-50">Panel Admin</a>
              <a href="upload" class="block px-5 py-3 text-sm hover:bg-indigo-50">Subir Proyecto</a>
              <a href="misproyectos" class="block px-5 py-3 text-sm hover:bg-indigo-50">Mis Proyectos</a>
              <a href="proyectosPorCalificar" class="block px-5 py-3 text-sm hover:bg-indigo-50">Por Calificar</a>
              <a href="proyectosCalificados" class="block px-5 py-3 text-sm hover:bg-indigo-50">Calificados</a>
            <?php elseif ($_SESSION['usuario']['rol'] === 'profesor'): ?>
              <a href="upload" class="block px-5 py-3 text-sm hover:bg-indigo-50">Subir Proyecto</a>
              <a href="misproyectos" class="block px-5 py-3 text-sm hover:bg-indigo-50">Mis Proyectos</a>
              <a href="proyectosPorCalificar" class="block px-5 py-3 text-sm hover:bg-indigo-50">Por Calificar</a>
              <a href="proyectosCalificados" class="block px-5 py-3 text-sm hover:bg-indigo-50">Calificados</a>
            <?php else: ?>
              <a href="misproyectos" class="block px-5 py-3 text-sm hover:bg-indigo-50">Mis Proyectos</a>
              <a href="upload" class="block px-5 py-3 text-sm hover:bg-indigo-50">Subir Proyecto</a>
            <?php endif; ?>
            <div class="border-t border-gray-200"></div>
            <a href="logout" class="block px-5 py-3 text-sm text-red-600 hover:bg-red-50">Cerrar sesión</a>
          </div>
        </div>
      <?php else: ?>
        <a href="login" class="flex items-center space-x-2 text-gray-600 hover:text-indigo-600">
          <i class="bi bi-person-circle text-2xl"></i>
          <span class="text-sm">Login</span>
        </a>
      <?php endif; ?>
    </nav>

    <!-- Botón hamburguesa -->
    <div class="md:hidden">
      <button id="mobileMenuButton" class="text-gray-600 hover:text-indigo-600 focus:outline-none">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Menú móvil -->
  <nav id="mobileMenu" class="md:hidden bg-white border-t border-gray-200 hidden">
    <ul class="px-4 py-4 space-y-3">
      <?php if (isset($_SESSION['usuario'])): ?>
        <li class="flex items-center text-indigo-700 font-medium">
          <i class="bi bi-person-circle mr-2 text-xl"></i>
          <?= htmlspecialchars($_SESSION['usuario']['nombre']); ?> (<?= htmlspecialchars($_SESSION['usuario']['rol']); ?>)
        </li>
        <li class="border-t border-gray-200 pt-2"></li>
        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
          <li><a href="panelAdmin" class="block text-sm text-gray-700 hover:text-indigo-600">Panel Admin</a></li>
          <li><a href="upload" class="block text-sm text-gray-700 hover:text-indigo-600">Subir Proyecto</a></li>
          <li><a href="misproyectos" class="block text-sm text-gray-700 hover:text-indigo-600">Mis Proyectos</a></li>
          <li><a href="proyectosPorCalificar" class="block text-sm text-gray-700 hover:text-indigo-600">Por Calificar</a></li>
          <li><a href="proyectosCalificados" class="block text-sm text-gray-700 hover:text-indigo-600">Calificados</a></li>
        <?php elseif ($_SESSION['usuario']['rol'] === 'profesor'): ?>
          <li><a href="upload" class="block text-sm text-gray-700 hover:text-indigo-600">Subir Proyecto</a></li>
          <li><a href="misproyectos" class="block text-sm text-gray-700 hover:text-indigo-600">Mis Proyectos</a></li>
          <li><a href="proyectosPorCalificar" class="block text-sm text-gray-700 hover:text-indigo-600">Por Calificar</a></li>
          <li><a href="proyectosCalificados" class="block text-sm text-gray-700 hover:text-indigo-600">Calificados</a></li>
        <?php else: ?>
          <li><a href="misproyectos" class="block text-sm text-gray-700 hover:text-indigo-600">Mis Proyectos</a></li>
          <li><a href="upload" class="block text-sm text-gray-700 hover:text-indigo-600">Subir Proyecto</a></li>
        <?php endif; ?>
        <li class="border-t border-gray-200 pt-2">
          <a href="logout" class="block text-sm text-red-600 hover:text-red-700">Cerrar sesión</a>
        </li>
      <?php else: ?>
        <li>
          <a href="login" class="flex items-center text-gray-700 hover:text-indigo-600 text-sm">
            <i class="bi bi-person-circle text-2xl mr-2"></i>
            Login
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>
</header>


<script>
  const userDropdownButton = document.getElementById('userDropdownButton');
  const userDropdownMenu = document.getElementById('userDropdownMenu');

  if (userDropdownButton) {
    // Cuando pinchas en el botón del usuario, abres/cierra el dropdown
    userDropdownButton.addEventListener('click', (e) => {
      e.stopPropagation(); // Para evitar que también dispare el evento global
      userDropdownMenu.classList.toggle('hidden');
    });

    // Cuando pinchas fuera, se cierra automáticamente
    document.addEventListener('click', function(event) {
      const isClickInside = userDropdownButton.contains(event.target) || userDropdownMenu.contains(event.target);

      if (!isClickInside) {
        userDropdownMenu.classList.add('hidden');
      }
    });
  }
</script>
<script>
  const mobileMenuButton = document.getElementById('mobileMenuButton');
  const mobileMenu = document.getElementById('mobileMenu');

  if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener('click', function () {
      mobileMenu.classList.toggle('hidden');
    });
  }
</script>



