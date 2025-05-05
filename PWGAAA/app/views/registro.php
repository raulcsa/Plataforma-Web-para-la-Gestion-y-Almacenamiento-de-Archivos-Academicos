<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Usuario - PWGAAA</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
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
      <a href="index" class="text-2xl font-bold text-indigo-600">PWGAAA</a>
    </div>
  </header>

  <!-- Contenedor del formulario de registro -->
  <main class="flex-grow flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-6">Registro de Usuario</h2>
      <?php if (!empty($mensaje)): ?>
        <div class="mb-4 p-3 bg-indigo-100 text-indigo-700 rounded">
          <?php echo htmlspecialchars($mensaje); ?>
        </div>
      <?php endif; ?>
      <form method="POST" action="">
        <div class="mb-4">
          <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre</label>
          <input type="text" id="nombre" name="nombre" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-medium mb-2">Correo Electrónico</label>
          <input type="email" id="email" name="email" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-medium mb-2">Contraseña</label>
          <input type="password" id="password" name="password" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="mb-6">
          <label for="confirm_password" class="block text-gray-700 font-medium mb-2">Confirmar Contraseña</label>
          <input type="password" id="confirm_password" name="confirm_password" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition-colors flex items-center justify-center">
          <i class="bi bi-person-plus mr-2"></i> Registrarse
        </button>
      </form>

      <!-- Botón de registro con Google -->
      <div class="mt-6">
        <form action="google-login.php" method="GET">
          <button type="submit" class="w-full py-3 bg-white text-gray-700 border border-gray-300 rounded hover:bg-gray-100 transition flex items-center justify-center">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="w-5 h-5 mr-3">
            Registrarse con Google
          </button>
        </form>
      </div>

      <p class="mt-6 text-center text-gray-600">
        ¿Ya tienes cuenta?
        <a href="login" class="text-indigo-600 hover:underline">Inicia Sesión</a>
      </p>
    </div>
  </main>

  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>
</body>
</html>
