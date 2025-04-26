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
  <title>Panel Admin - PWGAAA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Cargamos Tailwind CSS desde CDN -->
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
      <a href="index" class="text-2xl font-bold text-indigo-600">PWGAAA</a>
      <nav class="hidden md:flex space-x-6">
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
              <a href="perfil" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
              <a href="panelAdmin" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Panel Admin</a>
              <a href="misproyectos" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Mis Proyectos</a>
              <a href="upload" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Subir Proyecto</a>
              <div class="border-t border-gray-200"></div>
              <a href="logout" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Cerrar sesión</a>
            </div>
          </div>
        <?php else: ?>
          <a href="login" class="flex items-center text-gray-700 hover:text-indigo-600">
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
            <a href="perfil" class="block text-gray-700 hover:text-indigo-600">Perfil</a>
          </li>
          <li class="py-2">
            <a href="panelAdmin" class="block text-gray-700 hover:text-indigo-600">Panel Admin</a>
          </li>
          <li class="py-2">
            <a href="misproyectos" class="block text-gray-700 hover:text-indigo-600">Mis Proyectos</a>
          </li>
          <li class="py-2">
            <a href="upload" class="block text-gray-700 hover:text-indigo-600">Subir Proyecto</a>
          </li>
          <li class="py-2 border-t border-gray-200 mt-2">
            <a href="logout" class="block text-gray-700 hover:text-indigo-600">Cerrar sesión</a>
          </li>
        <?php else: ?>
          <li class="py-2">
            <a href="login" class="flex items-center text-gray-700 hover:text-indigo-600">
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
    <h1 class="text-center text-3xl font-semibold text-indigo-600 mb-6">Panel Admin - Gestión de Usuarios</h1>
    
    <!-- Formulario de búsqueda y filtrado -->
    <form method="GET" action="panelAdmin" class="mb-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <input type="text" name="busqueda" placeholder="Buscar por nombre o email" value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <select name="rol" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <option value="">Todos los roles</option>
          <option value="alumno" <?php echo (isset($_GET['rol']) && $_GET['rol'] === 'alumno') ? 'selected' : ''; ?>>Alumno</option>
          <option value="profesor" <?php echo (isset($_GET['rol']) && $_GET['rol'] === 'profesor') ? 'selected' : ''; ?>>Profesor</option>
          <option value="admin" <?php echo (isset($_GET['rol']) && $_GET['rol'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
        </select>
        <input type="date" name="fecha" value="<?php echo isset($_GET['fecha']) ? htmlspecialchars($_GET['fecha']) : ''; ?>" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <button type="submit" class="p-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition-colors">Filtrar</button>
      </div>
    </form>
    
    <div class="mb-4">
      <a href="panelAdmin?action=create" class="inline-block p-2 bg-indigo-500 text-white rounded hover:bg-indigo-600 transition-colors">Añadir Usuario</a>
    </div>
    
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white rounded-lg shadow">
        <thead class="bg-indigo-600 text-white">
          <tr>
            <th class="px-3 py-2">ID</th>
            <th class="px-3 py-2">Nombre</th>
            <th class="px-3 py-2">Correo</th>
            <th class="px-3 py-2">Rol</th>
            <th class="px-3 py-2">Fecha de Registro</th>
            <th class="px-3 py-2">Acciones</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <?php if (!empty($usuarios)): ?>
            <?php foreach ($usuarios as $usuario): ?>
              <tr class="border-t">
                <td class="px-3 py-2 text-center"><?php echo htmlspecialchars($usuario['id']); ?></td>
                <td class="px-3 py-2"><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                <td class="px-3 py-2"><?php echo htmlspecialchars($usuario['email']); ?></td>
                <td class="px-3 py-2 text-center"><?php echo htmlspecialchars($usuario['rol']); ?></td>
                <td class="px-3 py-2 text-center"><?php echo htmlspecialchars($usuario['fecha_registro']); ?></td>
                <td class="px-3 py-2 text-center">
                  <a href="panelAdmin?action=edit&id=<?php echo $usuario['id']; ?>" class="inline-block px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition-colors text-sm">Editar</a>
                  <a href="panelAdmin?action=delete&id=<?php echo $usuario['id']; ?>" class="inline-block px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition-colors text-sm" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">Eliminar</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="px-3 py-2 text-center">No se encontraron usuarios.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>
  
  <!-- Footer -->
  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>
  
  <script>
    // Toggle mobile menu
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
    
    // Toggle user dropdown menu
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
