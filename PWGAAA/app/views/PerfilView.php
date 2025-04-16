<?php
// /app/views/perfilView.php
// Se asume que $user ya está disponible (proviene de la sesión)
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil Académico - PWGAAA</title>
  <!-- Google Fonts - Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100 text-gray-700">
<?php require_once __DIR__ . '/../views/navbarView.php'; ?>

  <!-- Main Content -->
  <main class="flex-grow container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-lg p-8">
      <!-- Perfil Header -->
      <div class="flex flex-col md:flex-row items-center">
        <div class="w-48 h-48 mb-4 md:mb-0 relative">
          <img id="profile-image" src="<?php echo htmlspecialchars($user['foto'] ?? 'https://via.placeholder.com/250'); ?>" class="w-full h-full object-cover rounded-full border-4 border-indigo-600">
          <!-- Botón para editar foto, opcional (puedes implementar funcionalidad en el futuro) -->
          <button id="edit-photo" class="absolute bottom-0 right-0 bg-indigo-600 text-white p-2 rounded-full shadow hover:bg-indigo-700 focus:outline-none">
            <i class="bi bi-camera"></i>
          </button>
        </div>
        <div class="md:ml-8 text-center md:text-left">
          <h1 class="text-3xl font-bold text-indigo-600"><?php echo htmlspecialchars($user['nombre']); ?></h1>
          <p class="text-lg text-gray-600"><?php echo htmlspecialchars($user['apellidos'] ?? 'Apellidos no definidos'); ?></p>
          <p class="text-md text-gray-500"><?php echo htmlspecialchars($user['edad'] ?? 'Edad no definida'); ?> años</p>
        </div>
      </div>

      <!-- Datos de Contacto -->
      <div class="mt-8">
        <h2 class="text-2xl font-semibold text-indigo-600 mb-4">Datos de contacto</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" class="p-3 border rounded" placeholder="Teléfono" value="<?php echo htmlspecialchars($user['telefono'] ?? ''); ?>" disabled>
          <input type="email" class="p-3 border rounded" placeholder="Correo electrónico" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" disabled>
        </div>
      </div>

      <!-- Sobre mí -->
      <div class="mt-8">
        <h2 class="text-2xl font-semibold text-indigo-600 mb-4">Un poco sobre mí</h2>
        <textarea class="w-full p-3 border rounded resize-none" rows="4" placeholder="Breve descripción sobre ti" disabled><?php echo htmlspecialchars($user['descripcion'] ?? ''); ?></textarea>
      </div>

      <!-- Actividad de acceso -->
      <div class="mt-8">
        <h2 class="text-2xl font-semibold text-indigo-600 mb-4">Actividad de acceso</h2>
        <p class="mb-2"><strong>Último acceso:</strong> <?php echo htmlspecialchars($user['ultimo_acceso'] ?? 'No definido'); ?></p>
        <p><strong>IP de acceso:</strong> <?php echo htmlspecialchars($user['ip_acceso'] ?? 'No definido'); ?></p>
      </div>

      <!-- Botón de Editar Perfil -->
      <div class="mt-8">
        <a href="editarPerfil.php" class="block w-full bg-indigo-600 text-white text-center py-3 rounded hover:bg-indigo-700 transition-colors">
          Editar Perfil
        </a>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?= date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- Scripts -->
  <script>
    // Toggle dropdown (desktop)
    const userDropdownButton = document.getElementById('userDropdownButton');
    const userDropdownMenu = document.getElementById('userDropdownMenu');
    if (userDropdownButton) {
      userDropdownButton.addEventListener('click', () => {
        userDropdownMenu.classList.toggle('hidden');
      });
    }
    // Toggle mobile menu
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenuButton) {
      mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });
    }
  </script>
</body>
</html>
