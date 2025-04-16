<?php
// Asegúrate de que la sesión esté iniciada para poder usar $_SESSION.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Navbar -->
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
              <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
                <a href="panelAdmin.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Panel Admin</a>
                <a href="upload.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Subir Proyecto</a>
                <a href="misproyectos.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Mis Proyectos</a>
                <a href="proyectosPorCalificar.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos por calificar</a>
                <a href="proyectosCalificados.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos Calificados</a>
                <?php elseif ($_SESSION['usuario']['rol'] === 'profesor'): ?>
                <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
                <a href="upload.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Subir Proyecto</a>
                <a href="proyectosPorCalificar.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos por calificar</a>
                <a href="proyectosCalificados.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos Calificados</a>
              <?php else: ?>
                <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
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
            <?php elseif ($_SESSION['usuario']['rol'] === 'profesor'): ?>
            <li class="py-2">
            <a href="proyectosPorCalificar.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos por calificar</a>
            <a href="proyectosCalificados.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos Calificados</a>
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
  