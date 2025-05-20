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
  <!-- Navegadores de escritorio -->
  <link rel="icon" href="/PDF/logo.ico" type="image/x-icon">
  <link rel="icon" type="image/png" sizes="32x32" href="/PDF/logo-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/PDF/logo-16x16.png">

  <!-- Dispositivos Apple -->
  <link rel="apple-touch-icon" sizes="180x180" href="/PDF/apple-touch-icon.png">

  <!-- Android y Chrome -->
  <link rel="icon" type="image/png" sizes="192x192" href="/PDF/android-chrome-192x192.png">
  <link rel="icon" type="image/png" sizes="512x512" href="/PDF/android-chrome-512x512.png">

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
    @keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
  }

  .animate-fade-in-up {
    animation: fadeInUp 0.7s ease-out both;
  }

  .section-line {
    height: 4px;
    background: linear-gradient(to right, #6366f1, #8b5cf6);
    border-radius: 9999px;
    width: 60px;
    margin: 1rem auto 0 auto;
    animation: growWidth 1s ease-out forwards;
  }

  @keyframes growWidth {
    0% { width: 0; opacity: 0; }
    100% { width: 60px; opacity: 1; }
  }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 to-indigo-100 flex flex-col">
   <!-- Navbar -->
   <?php require_once __DIR__ . '/../views/navbarView.php'; ?>

  <!-- Contenido principal -->
  <main class="flex-grow max-w-4xl mx-auto px-4 py-12">
  <section class="text-center mb-10">
    <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-700 animate-fade-in-up">Añadir Nuevo Usuario</h1>
    <p class="text-gray-600 mt-2 text-sm">Desde aquí puedes registrar usuarios en la plataforma como administrador</p>
    <div class="section-line"></div>
  </section>

  <div class="mx-auto max-w-xl backdrop-blur-xl bg-white/70 border border-indigo-100 rounded-2xl shadow-xl p-8 animate-fade-in-up">
    <form method="POST" action="panelAdmin?action=store" class="space-y-5">
      <div>
        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
        <input type="text" name="nombre" id="nombre" required class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
        <input type="email" name="email" id="email" required class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
      </div>

      <div>
        <label for="rol" class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
        <select name="rol" id="rol" required class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 bg-white">
          <option value="alumno">Alumno</option>
          <option value="profesor">Profesor</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
        <input type="password" name="password" id="password" required class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
      </div>

      <div class="flex flex-col md:flex-row gap-4 pt-2">
      <a href="panelAdmin" class="flex-1 py-3 bg-white border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-all flex items-center justify-center gap-2 font-medium">
          <i class="bi bi-arrow-left-circle"></i> Volver al Panel
        </a>
        <button type="submit" class="flex-1 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 font-medium">
          <i class="bi bi-person-plus-fill"></i> Crear Usuario
        </button>
      </div>
    </form>
  </div>
</main>


  <!-- Footer -->
  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?php echo date('Y'); ?> TFCloud. Todos los derechos reservados.</p>
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
