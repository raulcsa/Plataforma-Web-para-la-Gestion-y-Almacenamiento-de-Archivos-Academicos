<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Subir TFG - PWGAAA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Cargamos Tailwind CSS desde CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Usamos la tipografía Inter para un look moderno -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Iconos de Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    /* Adaptación de estilos Select2 para combinar con Tailwind e indigo */
    .select2-container--default .select2-selection--multiple {
      background-color: #f8fafc;
      border: 1px solid #d1d5db;
      border-radius: 0.375rem;
      padding: 0.375rem;
      min-height: 38px;
    }
    .select2-selection__choice {
      background-color: #4f46e5; /* Indigo-600 */
      color: white;
      border: none;
      border-radius: 0.25rem;
      padding: 0.2rem 0.4rem;
    }
  </style>
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
      <nav>
        <?php if (isset($_SESSION['usuario'])): ?>
          <div class="relative inline-block">
            <button id="userDropdownButton" class="flex items-center focus:outline-none text-gray-600 hover:text-indigo-600">
              <i class="bi bi-person-circle text-2xl"></i>
              <span class="ml-2"><?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></span>
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div id="userDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden z-20">
              <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
              <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                <a href="panelAdmin.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Panel Admin</a>
              <?php else: ?>
                <a href="misproyectos.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Mis Proyectos</a>
                <a href="upload.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Subir Proyecto</a>
              <?php endif; ?>
              <div class="border-t border-gray-200"></div>
              <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Cerrar sesión</a>
            </div>
          </div>
        <?php else: ?>
          <a href="login.php" class="flex items-center text-gray-600 hover:text-indigo-600">
            <i class="bi bi-person-circle text-2xl"></i>
            <span class="ml-2">Login</span>
          </a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <!-- Contenido principal -->
  <main class="flex-grow container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-lg p-8">
      <h2 class="text-2xl font-bold text-indigo-600 mb-6">Subir un TFG</h2>
      <?php if (!empty($mensaje)): ?>
        <div class="mb-4 p-3 bg-indigo-100 text-indigo-700 rounded">
          <?php echo htmlspecialchars($mensaje); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="tituloProyecto" class="block text-gray-700 font-medium mb-2">Título del TFG</label>
          <input type="text" id="tituloProyecto" name="tituloProyecto" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="mb-4">
          <label for="resumenProyecto" class="block text-gray-700 font-medium mb-2">Resumen</label>
          <textarea id="resumenProyecto" name="resumenProyecto" rows="3" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
        </div>

        <div class="mb-4">
          <label for="palabraClave" class="block text-gray-700 font-medium mb-2">Palabras Clave</label>
          <input type="text" id="palabraClave" name="palabraClave" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="mb-4">
          <label for="integrantesSelect" class="block text-gray-700 font-medium mb-2">Selecciona hasta 2 alumnos adicionales</label>
          <select id="integrantesSelect" name="integrantesSelect[]" multiple="multiple" class="w-full">
            <?php foreach ($selectUsuarios as $alumno): ?>
              <option value="<?= $alumno['id'] ?>"><?= $alumno['nombre'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-6">
          <label for="fileToUpload" class="block text-gray-700 font-medium mb-2">Subir Archivo (PDF)</label>
          <input type="file" id="fileToUpload" name="fileToUpload" accept=".pdf" required class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition-colors flex items-center justify-center">
          <i class="bi bi-file-earmark-arrow-up mr-2"></i> Subir TFG
        </button>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#integrantesSelect').select2({
        placeholder: "Selecciona hasta 2 alumnos adicionales",
        maximumSelectionLength: 2,
        width: '100%',
        language: {
          maximumSelected: function () {
            return "Solo puedes seleccionar hasta 2 alumnos adicionales";
          }
        }
      });
    });

    // Toggle del dropdown del usuario
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
