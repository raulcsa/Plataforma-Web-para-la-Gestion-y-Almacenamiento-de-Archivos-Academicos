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
   <?php require_once __DIR__ . '/../views/navbarView.php'; ?>

  <!-- Contenido principal -->
  <main class="flex-grow container mx-auto px-4 py-8">
    <h1 class="text-center text-3xl font-semibold text-indigo-600 mb-6">Añadir Nuevo Usuario</h1>
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg p-8">
      <form method="POST" action="panelAdmin?action=store">
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
