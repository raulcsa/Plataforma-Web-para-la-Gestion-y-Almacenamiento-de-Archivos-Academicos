<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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

  <title>Subir TFG - TFCloud</title>
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
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-200 flex flex-col">
  <!-- Navbar -->
  <?php require_once __DIR__ . '/../views/navbarView.php'; ?>

  <!-- Contenido principal -->
  <main class="flex-grow container mx-auto px-4 py-12">
  <section class="text-center mb-10">
    <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-700 animate-fade-in-up">Subir un TFG</h1>
    <p class="text-gray-600 mt-2 text-sm">Completa todos los campos y sube tu archivo PDF</p>
    <div class="section-line"></div>
  </section>

  <div class="max-w-2xl mx-auto bg-white/80 border border-indigo-100 rounded-2xl shadow-lg p-8 backdrop-blur-md animate-fade-in-up">
    <h2 class="text-xl font-semibold text-indigo-700 mb-6">Datos del Proyecto</h2>

    <?php if (!empty($mensaje)): ?>
      <div class="mb-4 p-3 bg-indigo-100 text-indigo-700 rounded">
        <?php echo htmlspecialchars($mensaje); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data" class="space-y-6">
      <div>
        <label for="tituloProyecto" class="block text-sm font-medium text-gray-700 mb-1">Título del TFG</label>
        <input type="text" id="tituloProyecto" name="tituloProyecto" required class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
      </div>

      <div>
        <label for="resumenProyecto" class="block text-sm font-medium text-gray-700 mb-1">Resumen</label>
        <textarea id="resumenProyecto" name="resumenProyecto" rows="3" required class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"></textarea>
      </div>

      <div>
        <label for="palabraClave" class="block text-sm font-medium text-gray-700 mb-1">Palabras Clave</label>
        <input type="text" id="palabraClave" name="palabraClave" required class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
      </div>

      <?php if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] === 'profesor' || $_SESSION['usuario']['rol'] === 'admin')): ?>
        <div class="flex items-center gap-2">
          <input type="checkbox" id="incluirYo" name="incluirYo" value="1" class="accent-indigo-600">
          <label for="incluirYo" class="text-sm text-gray-700">Incluirte como integrante de este TFG</label>
        </div>
      <?php endif; ?>

      <div>
        <label for="integrantesSelect" id="integrantesSelectLabel" class="block text-sm font-medium text-gray-700 mb-1">
          <?php
            if (isset($_SESSION['usuario']) && 
                ($_SESSION['usuario']['rol'] === 'profesor' || $_SESSION['usuario']['rol'] === 'admin')) {
              echo "Selecciona hasta 3 alumnos";
            } else {
              echo "Selecciona hasta 2 alumnos";
            }
          ?>
        </label>
        <select id="integrantesSelect" name="integrantesSelect[]" multiple="multiple" class="w-full">
          <?php foreach ($selectUsuarios as $alumno): ?>
            <option value="<?= htmlspecialchars($alumno['id']); ?>"><?= htmlspecialchars($alumno['nombre']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label for="fileToUpload" class="block text-sm font-medium text-gray-700 mb-1">Archivo del TFG (PDF) - (Máximo 10MB)</label>
        <input type="file" id="fileToUpload" name="fileToUpload" accept=".pdf" required class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
      </div>

      <div class="pt-2">
        <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition flex items-center justify-center gap-2 font-medium">
          <i class="bi bi-file-earmark-arrow-up text-lg"></i>
          <span>Subir TFG</span>
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


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    // Función para inicializar Select2 con los parámetros indicados
    function initSelect2(maxSelection, placeholderText) {
      $('#integrantesSelect').select2({
        placeholder: placeholderText,
        maximumSelectionLength: maxSelection,
        width: '100%',
        language: {
          maximumSelected: function () {
            return "Solo puedes seleccionar hasta " + maxSelection + " alumnos";
          }
        }
      });
    }

    <?php if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] === 'profesor' || $_SESSION['usuario']['rol'] === 'admin')): ?>
      // Para profesor o admin se comprueba el estado del checkbox "incluirYo"
      var incluirYoChecked = $('#incluirYo').is(':checked');
      if (incluirYoChecked) {
        initSelect2(2, "Selecciona hasta 2 alumnos");
        $('#integrantesSelectLabel').text("Selecciona hasta 2 alumnos");
      } else {
        initSelect2(3, "Selecciona hasta 3 alumnos");
        $('#integrantesSelectLabel').text("Selecciona hasta 3 alumnos");
      }

      // Al cambiar el estado del checkbox, destruir y re-inicializar Select2 y actualizar el label
      $('#incluirYo').change(function() {
        $('#integrantesSelect').select2('destroy');
        if ($(this).is(':checked')) {
          initSelect2(2, "Selecciona hasta 2 alumnos");
          $('#integrantesSelectLabel').text("Selecciona hasta 2 alumnos");
        } else {
          initSelect2(3, "Selecciona hasta 3 alumnos");
          $('#integrantesSelectLabel').text("Selecciona hasta 3 alumnos");
        }
      });
    <?php else: ?>
      // Para otros usuarios (alumnos) se permite siempre seleccionar hasta 2
      initSelect2(2, "Selecciona hasta 2 alumnos");
    <?php endif; ?>
  });
</script>
<script>
    // Toggle menú móvil
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  
    // Toggle dropdown usuario
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
