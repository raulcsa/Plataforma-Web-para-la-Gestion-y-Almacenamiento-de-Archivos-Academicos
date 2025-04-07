<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Construimos un arreglo con los nombres disponibles
$autores = [];
if (!empty($tfg['nombre1'])) { 
    $autores[] = $tfg['nombre1']; 
}
if (!empty($tfg['nombre2'])) { 
    $autores[] = $tfg['nombre2']; 
}
if (!empty($tfg['nombre3'])) { 
    $autores[] = $tfg['nombre3']; 
}

// Función para formatear el listado de autores
function formatAuthors($authors) {
    $count = count($authors);
    if ($count === 0) {
        return "";
    } elseif ($count === 1) {
        return $authors[0];
    } elseif ($count === 2) {
        return $authors[0] . " y " . $authors[1];
    } else {
        // Para 3 o más: se unen todos menos el último con comas y se añade " y " antes del último
        $last = array_pop($authors);
        return implode(", ", $authors) . " y " . $last;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($tfg['titulo']); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind CSS desde CDN -->
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
<body class="min-h-screen bg-gradient-to-br from-indigo-50 to-indigo-100 flex flex-col">
  <!-- Navbar -->
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="index.php" class="text-2xl font-bold text-indigo-600">PWGAAA</a>
      <nav class="hidden md:flex items-center space-x-6">
        <?php if (isset($_SESSION['usuario'])): ?>
          <div class="relative inline-block">
            <button id="userDropdownButton" class="flex items-center focus:outline-none text-gray-600 hover:text-indigo-600">
              <i class="bi bi-person-circle text-2xl"></i>
              <span class="ml-2"><?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?> (<?php echo htmlspecialchars($_SESSION['usuario']['rol']); ?>)</span>
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div id="userDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 hidden z-20">
              <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
                <a href="panelAdmin.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Panel Admin</a>
                <?php elseif ($_SESSION['usuario']['rol'] === 'profesor'): ?>
                <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
                <a href="proyectosPorCalificar.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos por calificar</a>
                <a href="proyectosCalificados.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Proyectos Calificados</a>
              <?php else: ?>
                <a href="perfil.php" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50">Perfil</a>
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
      <!-- Botón para móviles -->
      <div class="md:hidden">
        <button id="mobileMenuButton" class="text-gray-600 hover:text-indigo-600 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
    </div>
    <!-- Menú móvil -->
    <nav id="mobileMenu" class="md:hidden bg-white border-t border-gray-200 hidden">
  <ul class="px-4 py-2">
    <?php if (isset($_SESSION['usuario'])): ?>
      <li class="py-2">
        <a href="perfil.php" class="block text-gray-700 hover:text-indigo-600">Perfil</a>
      </li>
      <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
        <li class="py-2">
          <a href="panelAdmin.php" class="block text-gray-700 hover:text-indigo-600">Panel Admin</a>
        </li>
      <?php elseif ($_SESSION['usuario']['rol'] === 'profesor'): ?>
        <li class="py-2">
          <a href="proyectosCalificados.php" class="block text-gray-700 hover:text-indigo-600">Proyectos Calificados</a>
        </li>
        <li class="py-2">
          <a href="proyectosPorCalificar.php" class="block text-gray-700 hover:text-indigo-600">Proyectos por calificar</a>
        </li>
      <?php else: ?>
        <li class="py-2">
          <a href="misproyectos.php" class="block text-gray-700 hover:text-indigo-600">Mis Proyectos</a>
        </li>
        <li class="py-2">
          <a href="upload.php" class="block text-gray-700 hover:text-indigo-600">Subir Proyecto</a>
        </li>
      <?php endif; ?>
      <li class="py-2 border-t border-gray-200 mt-2">
        <a href="logout.php" class="block text-gray-700 hover:text-indigo-600">Cerrar sesión</a>
      </li>
    <?php else: ?>
      <li class="py-2">
        <a href="login.php" class="flex items-center text-gray-700 hover:text-indigo-600">
          <i class="bi bi-person-circle text-2xl"></i>
          <span class="ml-2">Login</span>
        </a>
      </li>
    <?php endif; ?>
  </ul>
</nav>
  </header>

  <!-- Contenido principal -->
  <main class="flex-grow flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
      <!-- Título del TFG -->
      <h2 class="text-2xl font-bold text-indigo-600 mb-4"><?php echo htmlspecialchars($tfg['titulo']); ?></h2>
      <!-- Datos agrupados en un mismo cuadro -->
      <div class="space-y-4">
        <!-- Autor(es) -->
        <div>
          <span class="font-semibold text-gray-700">Autor(es):</span>
          <?php echo htmlspecialchars(formatAuthors($autores)); ?>
        </div>
        <!-- Fecha -->
        <div>
          <span class="font-semibold text-gray-700">Fecha de publicación:</span>
          <p class="text-gray-800">
            <?php 
              $rawDate = $tfg['fecha'] ?? '';
              if (!empty($rawDate)) {
                  try {
                      $formatter = new IntlDateFormatter(
                          'es-ES',
                          IntlDateFormatter::LONG,
                          IntlDateFormatter::NONE,
                          'Europe/Madrid',
                          IntlDateFormatter::GREGORIAN
                      );
                      $dateObj = new DateTime($rawDate);
                      echo $formatter->format($dateObj);
                  } catch (Exception $e) {
                      echo htmlspecialchars($rawDate);
                  }
              } else {
                  echo "Sin fecha";
              }
            ?>
          </p>
        </div>
        <!-- Palabras clave -->
        <div>
          <span class="font-semibold text-gray-700">Palabras clave:</span>
          <p class="text-gray-800"><?php echo htmlspecialchars($tfg['palabras_clave']); ?></p>
        </div>
        <!-- Resumen -->
        <div>
          <span class="font-semibold text-gray-700">Resumen:</span>
          <p class="text-gray-800"><?php echo nl2br(htmlspecialchars($tfg['resumen'])); ?></p>
        </div>
      </div>
      <!-- Archivos PDF -->
      <?php if (!empty($archivos)): ?>
        <div class="mt-6">
          <span class="font-semibold text-gray-700">Ficheros subidos:</span>
          <div class="mt-3 flex gap-4">
            <?php foreach ($archivos as $archivo): ?>
              <?php 
                $extension = strtolower(pathinfo($archivo['ruta'], PATHINFO_EXTENSION));
                if ($extension === 'pdf'): 
              ?>
                <a href="<?php echo htmlspecialchars($archivo['ruta']); ?>" target="_blank">
                  <img src="../PDF/pdf.png" alt="Icono PDF" class="w-20">
                </a>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
      <!-- Botón de volver -->
      <a href="index.php" class="mt-8 block w-full py-3 bg-indigo-600 text-white text-center rounded hover:bg-indigo-700 transition-colors">
        Volver al listado
      </a>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- Script para el dropdown del usuario -->
  <script>
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
