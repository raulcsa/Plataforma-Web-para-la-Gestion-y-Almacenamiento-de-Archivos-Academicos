<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Navegadores de escritorio -->
  <link rel="icon" href="/PDF/logo.ico" type="image/x-icon">
  <link rel="icon" type="image/png" sizes="32x32" href="/PDF/logo-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/PDF/logo-16x16.png">

  <!-- Dispositivos Apple -->
  <link rel="apple-touch-icon" sizes="180x180" href="/PDF/apple-touch-icon.png">

  <!-- Android y Chrome -->
  <link rel="icon" type="image/png" sizes="192x192" href="/PDF/android-chrome-192x192.png">
  <link rel="icon" type="image/png" sizes="512x512" href="/PDF/android-chrome-512x512.png">
  <title>Calificar TFG: <?= htmlspecialchars($tfg['titulo']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>body { font-family:'Inter',sans-serif; }
  @keyframes fade-in {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
  }
  .animate-fade-in {
    animation: fade-in 0.4s ease-out both;
  }
  </style>
</head>
<body class="min-h-screen bg-indigo-50 flex flex-col">
  <?php require __DIR__ . '/navbarView.php'; ?>

  <main class="flex-grow flex items-center justify-center px-6 py-10 bg-indigo-50">
  <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-8 transition-all duration-300 animate-fade-in">
    <h1 class="text-3xl font-bold text-indigo-600 mb-8 text-center">Calificar TFG</h1>

    <?php if (!empty($_SESSION['mensaje'])): ?>
      <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded shadow-sm">
        <?= htmlspecialchars($_SESSION['mensaje']); unset($_SESSION['mensaje']); ?>
      </div>
    <?php endif; ?>

    <form action="correction?action=validar&id=<?= $tfg['id'] ?>" method="POST" class="space-y-6">
      <?php foreach($alumnosNotas as $row): ?>
        <div class="space-y-2">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <input
              type="text"
              value="<?= htmlspecialchars($row['nombre']) ?>"
              disabled
              class="bg-gray-100 border border-gray-300 rounded-md px-4 py-3 text-gray-700"
            />
            <input
              type="number"
              name="nota[<?= $row['alumno_id'] ?>]"
              value="<?= htmlspecialchars($row['nota'] ?? '') ?>"
              min="1"
              max="10"
              required
              class="border border-gray-300 rounded-md px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition"
              placeholder="Nota (1-10)"
            />
          </div>
          <textarea
            name="comentario[<?= $row['alumno_id'] ?>]"
            rows="3"
            placeholder="Comentario (opcional)"
            class="w-full px-4 py-3 border border-gray-300 rounded-md resize-none focus:ring-2 focus:ring-indigo-500 transition"
          ><?= htmlspecialchars($row['comentario'] ?? '') ?></textarea>
        </div>
      <?php endforeach; ?>

      <div class="flex flex-col sm:flex-row gap-4 pt-6">
      <a
          href="editarTfg?id=<?= $tfg['id'] ?>"
          class="flex-1 text-center py-3 border border-gray-300 rounded-md hover:bg-gray-100 transition"
        >
          Atrás
        </a>
        <button
          type="submit"
          class="flex-1 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-transform transform hover:scale-[1.02] shadow-md inline-flex items-center justify-center gap-2"
        >
          <i class="bi bi-check2-circle text-lg"></i> Validar
        </button>
      </div>
    </form>
  </div>
</main>


  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto py-4 text-center text-gray-600">
      &copy; <?= date('Y') ?> TFCloud. Todos los derechos reservados.
    </div>
  </footer>
  <script>
document.addEventListener('DOMContentLoaded', function () {
  var userButton = document.getElementById('userDropdownButton');
  var userMenu = document.getElementById('userDropdownMenu');

  if (userButton && userMenu) {
    userButton.addEventListener('click', function () {
      userMenu.classList.toggle('hidden');
    });
  }

  var mobileButton = document.getElementById('mobileMenuButton');
  var mobileMenu = document.getElementById('mobileMenu');

  if (mobileButton && mobileMenu) {
    mobileButton.addEventListener('click', function () {
      mobileMenu.classList.toggle('hidden');
    });
  }
});
</script>
</body>
</html>
