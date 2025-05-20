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
  <!-- Navegadores de escritorio -->
  <link rel="icon" href="/PDF/logo.ico" type="image/x-icon">
  <link rel="icon" type="image/png" sizes="32x32" href="/PDF/logo-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/PDF/logo-16x16.png">

  <!-- Dispositivos Apple -->
  <link rel="apple-touch-icon" sizes="180x180" href="/PDF/apple-touch-icon.png">

  <!-- Android y Chrome -->
  <link rel="icon" type="image/png" sizes="192x192" href="/PDF/android-chrome-192x192.png">
  <link rel="icon" type="image/png" sizes="512x512" href="/PDF/android-chrome-512x512.png">
  <title>Panel Admin - TFCloud</title>
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

<style>
  @keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
  }

  .animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out both;
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
  <main class="flex-grow max-w-7xl mx-auto px-4 py-10">

<!-- Título animado -->
<section class="text-center mb-10">
  <h1 class="text-4xl font-extrabold text-indigo-700 animate-fade-in-up">Panel de Administración</h1>
  <p class="text-gray-600 mt-2">Gestiona usuarios registrados en TFCloud</p>
  <div class="section-line"></div>
</section>

<!-- Filtros -->
<section class="mb-8">
  <form method="GET" action="panelAdmin" class="bg-white rounded-xl shadow p-6 border border-gray-100">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
        <input type="text" name="busqueda" placeholder="Nombre o email" value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
        <select name="rol" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
          <option value="">Todos</option>
          <option value="alumno" <?= (isset($_GET['rol']) && $_GET['rol'] === 'alumno') ? 'selected' : ''; ?>>Alumno</option>
          <option value="profesor" <?= (isset($_GET['rol']) && $_GET['rol'] === 'profesor') ? 'selected' : ''; ?>>Profesor</option>
          <option value="admin" <?= (isset($_GET['rol']) && $_GET['rol'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha registro</label>
        <input type="date" name="fecha" value="<?= isset($_GET['fecha']) ? htmlspecialchars($_GET['fecha']) : ''; ?>" class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
      </div>
      <div>
        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-all">Filtrar</button>
      </div>
    </div>
  </form>
</section>

<!-- Botón añadir usuario -->
<div class="mb-6">
  <a href="panelAdmin?action=create" class="inline-flex items-center gap-2 bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-2 rounded-md transition-all shadow">
    <i class="bi bi-person-plus"></i> Añadir Usuario
  </a>
</div>

<!-- Tabla -->
<section class="overflow-x-auto">
  <div class="shadow border border-gray-200 rounded-xl overflow-hidden">
    <table class="min-w-full bg-white text-sm">
      <thead class="bg-indigo-600 text-white text-left">
        <tr>
          <th class="px-4 py-3">ID</th>
          <th class="px-4 py-3">Nombre</th>
          <th class="px-4 py-3">Correo</th>
          <th class="px-4 py-3">Rol</th>
          <th class="px-4 py-3">Fecha</th>
          <th class="px-4 py-3 text-center">Acciones</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 divide-y divide-gray-100">
        <?php if (!empty($usuarios)): ?>
          <?php foreach ($usuarios as $usuario): ?>
            <tr class="hover:bg-gray-50 transition-all">
              <td class="px-4 py-2"><?= htmlspecialchars($usuario['id']); ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($usuario['nombre']); ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($usuario['email']); ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($usuario['rol']); ?></td>
              <td class="px-4 py-2"><?= htmlspecialchars($usuario['fecha_registro']); ?></td>
              <td class="px-4 py-2 text-center">
                <a href="panelAdmin?action=edit&id=<?= $usuario['id']; ?>" class="inline-block px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-xs transition">Editar</a>
                <a href="panelAdmin?action=delete&id=<?= $usuario['id']; ?>" class="inline-block px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs transition" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="px-4 py-6 text-center text-gray-500">No se encontraron usuarios.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</section>
</main>
  
  <!-- Footer -->
  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?php echo date('Y'); ?> TFCloud. Todos los derechos reservados.</p>
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
  <script>
  window.addEventListener('DOMContentLoaded', () => {
    const url = new URL(window.location);
    const params = url.searchParams;

    // Elimina parámetros vacíos
    ['busqueda', 'rol', 'fecha'].forEach(key => {
      if (!params.get(key)) {
        params.delete(key);
      }
    });

    // Si hay cambios, actualiza la URL sin recargar
    const newParams = params.toString();
    const cleanUrl = newParams ? `${url.pathname}?${newParams}` : url.pathname;
    if (window.location.href !== cleanUrl) {
      window.history.replaceState({}, '', cleanUrl);
    }
  });
</script>

</body>
</html>
