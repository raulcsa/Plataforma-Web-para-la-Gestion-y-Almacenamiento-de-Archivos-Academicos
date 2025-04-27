<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Navbar -->
<header class="bg-white shadow-md sticky top-0 z-50">
  <div class="max-w-7xl mx-auto flex justify-between items-center p-4">
    <a href="index" class="text-2xl font-extrabold text-indigo-700 hover:text-indigo-900 transition">PWGAAA</a>

    <nav class="hidden md:flex items-center space-x-8">
      <?php if (isset($_SESSION['usuario'])): ?>
        <div class="relative z-50">
          <button id="userDropdownButton" class="flex items-center focus:outline-none text-gray-700 hover:text-indigo-700 transition">
            <i class="bi bi-person-circle text-2xl"></i>
            <span class="ml-2 font-semibold"><?= htmlspecialchars($_SESSION['usuario']['nombre']); ?> (<?= htmlspecialchars($_SESSION['usuario']['rol']); ?>)</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          <div id="userDropdownMenu" class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg border border-gray-200 hidden transition-all duration-300">
            <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
              <a href="perfil" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
              <a href="panelAdmin" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Panel Admin</a>
              <a href="upload" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Subir Proyecto</a>
              <a href="misproyectos" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Mis Proyectos</a>
              <a href="proyectosPorCalificar" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos por Calificar</a>
              <a href="proyectosCalificados" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos Calificados</a>
            <?php elseif ($_SESSION['usuario']['rol'] === 'profesor'): ?>
              <a href="perfil" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
              <a href="upload" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Subir Proyecto</a>
              <a href="proyectosPorCalificar" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos por Calificar</a>
              <a href="proyectosCalificados" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos Calificados</a>
            <?php else: ?>
              <a href="perfil" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
              <a href="misproyectos" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Mis Proyectos</a>
              <a href="upload" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Subir Proyecto</a>
            <?php endif; ?>
            <div class="border-t border-gray-200"></div>
            <a href="logout" class="block px-4 py-2 text-red-600 hover:bg-red-50">Cerrar sesión</a>
          </div>
        </div>
      <?php else: ?>
        <a href="login" class="flex items-center text-gray-600 hover:text-indigo-600">
          <i class="bi bi-person-circle text-2xl"></i>
          <span class="ml-2">Login</span>
        </a>
      <?php endif; ?>
    </nav>

    <!-- Botón menú móvil -->
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
    <ul class="px-4 py-4 space-y-2">
      <?php if (isset($_SESSION['usuario'])): ?>
        <li><a href="perfil" class="block text-gray-700 hover:text-indigo-600">Perfil</a></li>
        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
          <li><a href="panelAdmin" class="block text-gray-700 hover:text-indigo-600">Panel Admin</a></li>
          <li><a href="upload" class="block text-gray-700 hover:text-indigo-600">Subir Proyecto</a></li>
          <li><a href="misproyectos" class="block text-gray-700 hover:text-indigo-600">Mis Proyectos</a></li>
          <li><a href="proyectosPorCalificar" class="block text-gray-700 hover:text-indigo-600">Por Calificar</a></li>
          <li><a href="proyectosCalificados" class="block text-gray-700 hover:text-indigo-600">Calificados</a></li>
        <?php elseif ($_SESSION['usuario']['rol'] === 'profesor'): ?>
          <li><a href="upload" class="block text-gray-700 hover:text-indigo-600">Subir Proyecto</a></li>
          <li><a href="proyectosPorCalificar" class="block text-gray-700 hover:text-indigo-600">Por Calificar</a></li>
          <li><a href="proyectosCalificados" class="block text-gray-700 hover:text-indigo-600">Calificados</a></li>
        <?php else: ?>
          <li><a href="misproyectos" class="block text-gray-700 hover:text-indigo-600">Mis Proyectos</a></li>
          <li><a href="upload" class="block text-gray-700 hover:text-indigo-600">Subir Proyecto</a></li>
        <?php endif; ?>
        <li class="border-t border-gray-200 pt-2"><a href="logout" class="block text-red-600 hover:text-red-700">Cerrar sesión</a></li>
      <?php else: ?>
        <li><a href="login" class="flex items-center text-gray-700 hover:text-indigo-600">
          <i class="bi bi-person-circle text-2xl"></i><span class="ml-2">Login</span>
        </a></li>
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


