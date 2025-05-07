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
  <?php require_once __DIR__ . '/../views/navbarView.php'; ?>
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
