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
  <!-- Navegadores de escritorio -->
  <link rel="icon" href="/PDF/logo.ico" type="image/x-icon">
  <link rel="icon" type="image/png" sizes="32x32" href="/PDF/logo-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/PDF/logo-16x16.png">

  <!-- Dispositivos Apple -->
  <link rel="apple-touch-icon" sizes="180x180" href="/PDF/apple-touch-icon.png">

  <!-- Android y Chrome -->
  <link rel="icon" type="image/png" sizes="192x192" href="/PDF/android-chrome-192x192.png">
  <link rel="icon" type="image/png" sizes="512x512" href="/PDF/android-chrome-512x512.png">

  <title>Iniciar Sesión - TFCloud</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
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
    animation: fadeInUp 0.8s ease-out both;
  }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-200 flex flex-col">


<main class="flex-grow flex items-center justify-center px-4 relative overflow-hidden">
  <!-- Fondo decorativo con degradado suave -->
  <div class="absolute inset-0 bg-gradient-to-br from-indigo-100 via-white to-purple-100 opacity-60"></div>

  <!-- Contenedor del formulario -->
  <div class="relative z-10 w-full max-w-md backdrop-blur-xl bg-white/70 border border-indigo-100 rounded-2xl shadow-xl p-8 animate-fade-in-up">
    
    <!-- Logo centrado clicable -->
    <div class="flex justify-center mb-6">
      <a href="index">
        <img src="../PDF/logo_sinfondo.png" alt="TFCloud" class="h-12 w-auto hover:scale-105 transition-transform duration-200">
      </a>
    </div>

    <h2 class="text-2xl font-extrabold text-center text-indigo-700 mb-4">Iniciar Sesión</h2>
    <p class="text-center text-gray-500 mb-6 text-sm">Accede a tu cuenta para continuar</p>

    <?php if (isset($_GET['expirada'])): ?>
      <div class="mb-4 p-3 bg-yellow-100 text-yellow-800 border border-yellow-300 rounded text-sm">
        Tu sesión ha expirado por inactividad. Por favor, inicia sesión de nuevo.
      </div>
    <?php endif; ?>

    <?php if (!empty($mensaje)): ?>
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
        <?= htmlspecialchars($mensaje); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
        <input type="email" id="email" name="email" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
        <input type="password" id="password" name="password" required class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
      </div>
      <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 font-medium">
        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
      </button>
    </form>

    <div class="mt-6">
      <div class="flex items-center text-gray-400 text-sm mb-4">
        <hr class="flex-grow border-gray-300"> <span class="mx-2">o</span> <hr class="flex-grow border-gray-300">
      </div>
      <a href="google-login.php" class="w-full flex justify-center items-center gap-3 border border-gray-300 rounded-md py-2 px-4 hover:bg-gray-50 transition text-sm font-medium text-gray-700">
        <img src="https://developers.google.com/identity/images/g-logo.png" class="w-5 h-5" alt="Google logo">
        Iniciar sesión con Google
      </a>
    </div>

    <p class="mt-6 text-center text-sm text-gray-600">
      ¿No tienes cuenta? <a href="registro" class="text-indigo-600 hover:underline">Regístrate</a>
    </p>
  </div>
</main>



  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?php echo date('Y'); ?> TFCloud. Todos los derechos reservados.</p>
    </div>
  </footer>
</body>
</html>