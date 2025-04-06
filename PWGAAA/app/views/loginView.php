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
  <title>Iniciar Sesión - PWGAAA</title>
  <!-- Cargamos Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Tipografía Inter para un look moderno -->
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
    </div>
  </header>

  <!-- Contenedor del formulario de login -->
  <main class="flex-grow flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-2xl font-bold text-center text-indigo-800 mb-6">Iniciar Sesión</h2>
      <?php if (!empty($mensaje)): ?>
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <?php echo htmlspecialchars($mensaje); ?>
      </div>
      <?php endif; ?>
      <form method="POST" action="">
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-medium mb-2">Correo Electrónico</label>
          <input type="email" id="email" name="email" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="mb-6">
          <label for="password" class="block text-gray-700 font-medium mb-2">Contraseña</label>
          <input type="password" id="password" name="password" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition-colors flex items-center justify-center">
          <i class="bi bi-box-arrow-in-right mr-2"></i> Iniciar Sesión
        </button>
      </form>
      <p class="mt-6 text-center text-gray-600">
        ¿No tienes cuenta? <a href="registro.php" class="text-indigo-600 hover:underline">Regístrate</a>
      </p>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>
</body>
</html>
