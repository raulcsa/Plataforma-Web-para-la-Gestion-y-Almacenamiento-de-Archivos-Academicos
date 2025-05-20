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
  <!-- Navegadores de escritorio -->
  <link rel="icon" href="/PDF/logo.ico" type="image/x-icon">
  <link rel="icon" type="image/png" sizes="32x32" href="/PDF/logo-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/PDF/logo-16x16.png">

  <!-- Dispositivos Apple -->
  <link rel="apple-touch-icon" sizes="180x180" href="/PDF/apple-touch-icon.png">

  <!-- Android y Chrome -->
  <link rel="icon" type="image/png" sizes="192x192" href="/PDF/android-chrome-192x192.png">
  <link rel="icon" type="image/png" sizes="512x512" href="/PDF/android-chrome-512x512.png">

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
<?php require_once __DIR__ . '/../views/navbarView.php'; ?>

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
      <?php
          $volverA = 'index'; // valor por defecto
            if (isset($_SERVER['HTTP_REFERER'])) {
              $referer = $_SERVER['HTTP_REFERER'];
              // Solo permitimos volver si viene de una de estas páginas conocidas
                if (strpos($referer, 'index') !== false) {
                  $volverA = 'index';
                } elseif (strpos($referer, 'proyectosCalificados') !== false) {
                  $volverA = 'proyectosCalificados';
                }
            }
        ?>
        <a href="<?= $volverA ?>" class="mt-8 block w-full py-3 bg-indigo-600 text-white text-center rounded hover:bg-indigo-700 transition-colors">
          Volver atrás
        </a>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto px-4 py-4 text-center text-gray-600">
      <p>&copy; <?php echo date('Y'); ?> TFCloud. Todos los derechos reservados.</p>
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
