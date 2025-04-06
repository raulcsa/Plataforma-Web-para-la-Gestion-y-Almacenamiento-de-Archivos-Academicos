<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Añadir Nuevo Usuario - Panel Admin</title>
  <!-- Tailwind CSS desde CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Tipografía Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <!-- Iconos de Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 to-indigo-100 flex flex-col">
  <!-- Navbar -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="index.php" class="text-2xl font-bold text-indigo-600">PWGAAA</a>
      <nav class="hidden md:flex items-center space-x-6">
        <?php if (isset($_SESSION['usuario'])): ?>
          <div class="relative">
            <button id="userDropdownButton" class="flex items-center text-gray-700 hover:text-indigo-600 focus:outline-none">
              <i class="bi bi-person-circle text-2xl"></i>
              <span class="ml-2"><?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?> (<?php echo htmlspecialchars($_SESSION['usuario']['rol']); ?>)</span>
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <div id="userDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg hidden z-20">
              <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
              <a href="panelAdmin.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Panel Admin</a>
              <a href="misproyectos.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Mis Proyectos</a>
              <a href="upload.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Subir Proyecto</a>
              <div class="border-t border-gray-200"></div>
              <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Cerrar sesión</a>
            </div>
          </div>
        <?php else: ?>
          <a href="login.php" class="flex items-center text-gray-700 hover:text-indigo-600">
            <i class="bi bi-person-circle text-2xl"></i>
            <span class="ml-2">Login</span>
          </a>
        <?php endif; ?>
      </nav>
      <!-- Botón para móviles -->
      <div class="md:hidden">
        <button id="mobileMenuButton" class="text-gray-700 hover:text-indigo-600 focus:outline-none">
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
          <li class="py-2">
            <a href="panelAdmin.php" class="block text-gray-700 hover:text-indigo-600">Panel Admin</a>
          </li>
          <li class="py-2">
            <a href="misproyectos.php" class="block text-gray-700 hover:text-indigo-600">Mis Proyectos</a>
          </li>
          <li class="py-2">
            <a href="upload.php" class="block text-gray-700 hover:text-indigo-600">Subir Proyecto</a>
          </li>
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
    <h1 class="text-center text-3xl font-semibold text-indigo-600 mb-6">Añadir Nuevo Usuario</h1>
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg p-8">
      <form method="POST" action="panelAdmin.php?action=store">
        <div class="mb-4">
          <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre</label>
          <input type="text" name="nombre" id="nombre" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-semibold mb-2">Correo Electrónico</label>
          <input type="email" name="email" id="email" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="mb-4">
          <label for="rol" class="block text-gray-700 font-semibold mb-2">Rol</label>
          <select name="rol" id="rol" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="alumno">Alumno</option>
            <option value="profesor">Profesor</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-semibold mb-2">Contraseña</label>
          <input type="password" name="password" id="password" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">Crear Usuario</button>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script>
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

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
