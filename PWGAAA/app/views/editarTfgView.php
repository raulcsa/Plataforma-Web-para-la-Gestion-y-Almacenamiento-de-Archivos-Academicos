<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$role = $_SESSION['usuario']['rol'] ?? '';
$isEditor = in_array(strtolower($role), ['profesor','admin']);

// Listado de todos los alumnos para el <select>
require_once __DIR__ . '/../models/subidaProyectos.php';
$alumnos = uploadTfg::obtenerAlumnos();

// Preparamos el array de IDs de los integrantes actuales
$currentIntegrantes = array_filter([
    $tfg['integrante1'],
    $tfg['integrante2'],
    $tfg['integrante3']
]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($tfg['titulo']); ?> — Edición</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .select2-container--default .select2-selection--multiple {
      background: #f8fafc; border:1px solid #d1d5db; border-radius:.375rem; padding:.375rem;
    }
    .select2-selection__choice {
      background: #4f46e5; color:#fff; border:none; border-radius:.25rem; padding:.2rem .4rem;
    }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 to-indigo-100 flex flex-col">
  <?php require __DIR__ . '/navbarView.php'; ?>

  <main class="flex-grow flex items-center justify-center p-4">
    <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg p-8">
      <h1 class="text-3xl font-bold text-indigo-600 mb-6">
        <?= $isEditor ? 'Editar TFG' : 'Detalle del TFG' ?>
      </h1>

      <?php if ($isEditor): ?>
        <form action="editarTfg.php?id=<?= $tfg['id'] ?>" method="POST" enctype="multipart/form-data">
      <?php endif; ?>

        <!-- Título -->
        <div class="mb-4">
          <label class="font-semibold text-gray-700 block mb-1">Título</label>
          <?php if ($isEditor): ?>
            <input type="text" name="titulo" value="<?= htmlspecialchars($tfg['titulo']) ?>"
              class="w-full p-3 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-400"
              required>
          <?php else: ?>
            <p class="text-gray-800"><?= htmlspecialchars($tfg['titulo']) ?></p>
          <?php endif; ?>
        </div>

        <!-- Integrantes -->
        <div class="mb-4">
          <label class="font-semibold text-gray-700 block mb-1">Integrantes</label>
          <?php if ($isEditor): ?>
            <select id="integrantes" name="integrantes[]" multiple class="w-full">
              <?php foreach($alumnos as $al): ?>
                <option value="<?= $al['id'] ?>"
                  <?= in_array($al['id'], $currentIntegrantes) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($al['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          <?php else: ?>
            <p class="text-gray-800"><?= htmlspecialchars(formatAuthors([$tfg['nombre1'],$tfg['nombre2'],$tfg['nombre3']])) ?></p>
          <?php endif; ?>
        </div>

        <!-- Fecha de publicación -->
        <div class="mb-4">
          <label class="font-semibold text-gray-700 block mb-1">Fecha de publicación</label>
          <?php if ($isEditor): ?>
            <input type="date" name="fecha" value="<?= htmlspecialchars($tfg['fecha']) ?>"
              class="p-3 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-400">
          <?php else: ?>
            <?php
              $fmt = new IntlDateFormatter('es-ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE,
                                           'Europe/Madrid', IntlDateFormatter::GREGORIAN);
              echo '<p class="text-gray-800">'. $fmt->format(new DateTime($tfg['fecha'] ?? '')) .'</p>';
            ?>
          <?php endif; ?>
        </div>

        <!-- Palabras clave -->
        <div class="mb-4">
          <label class="font-semibold text-gray-700 block mb-1">Palabras clave</label>
          <?php if ($isEditor): ?>
            <input type="text" name="palabras_clave" value="<?= htmlspecialchars($tfg['palabras_clave']) ?>"
              class="w-full p-3 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-400"
              required>
          <?php else: ?>
            <p class="text-gray-800"><?= htmlspecialchars($tfg['palabras_clave']) ?></p>
          <?php endif; ?>
        </div>

        <!-- Resumen -->
        <div class="mb-4">
          <label class="font-semibold text-gray-700 block mb-1">Resumen</label>
          <?php if ($isEditor): ?>
            <textarea name="resumen" rows="4"
              class="w-full p-3 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-400"
              required><?= htmlspecialchars($tfg['resumen']) ?></textarea>
          <?php else: ?>
            <p class="text-gray-800"><?= nl2br(htmlspecialchars($tfg['resumen'])) ?></p>
          <?php endif; ?>
        </div>

        <!-- PDF -->
        <div class="mb-6">
          <label class="font-semibold text-gray-700 block mb-1">Documento PDF</label>
          <?php if ($isEditor): ?>
            <input type="file" name="pdf" accept=".pdf"
              class="block w-full text-gray-600">
                <?php if (!empty($archivos)): ?>
                    <p class="mt-2">
                        <a href="<?= htmlspecialchars($archivos[0]['ruta']) ?>" target="_blank"
                            class="text-indigo-600 hover:underline">
                        <i class="bi bi-file-earmark-pdf"></i> Ver PDF actual
                        </a>
                    </p>
                <?php endif; ?>

          <?php else: ?>
            <?php if (!empty($archivos)): ?>
              <a href="<?= $archivos[0]['ruta'] ?>" target="_blank"
                class="inline-block bg-indigo-100 text-indigo-700 px-3 py-1 rounded">
                <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
              </a>
            <?php else: ?>
              <p class="text-gray-500">No hay PDF subido</p>
            <?php endif; ?>
          <?php endif; ?>
        </div>

        <?php if ($isEditor): ?>
        <div class="flex gap-4">
          <button type="submit"
            class="flex-1 bg-indigo-600 text-white py-2 rounded hover:bg-indigo-500 transition">
            Guardar cambios
          </button>
          <a href="proyectosPorCalificar.php"
            class="flex-1 text-center border border-gray-300 py-2 rounded hover:bg-gray-100 transition">
            Atrás
          </a>
        </div>
        </form>
        <?php else: ?>
          <a href="index.php"
            class="mt-6 block w-full bg-gray-200 text-gray-800 py-2 rounded text-center hover:bg-gray-300 transition">
            Volver al listado
          </a>
        <?php endif; ?>
    </div>
  </main>

  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto py-4 text-center text-gray-600">
      &copy; <?= date('Y') ?> PWGAAA. Todos los derechos reservados.
    </div>
  </footer>

  <script>
    $(document).ready(function(){
      <?php if ($isEditor): ?>
        $('#integrantes').select2({
          placeholder: "Selecciona hasta 3 integrantes",
          maximumSelectionLength: 3,
          width:'100%'
        });
      <?php endif; ?>
      // dropdown user
      $('#userDropdownButton').click(()=>$('#userDropdownMenu').toggleClass('hidden'));
      $('#mobileMenuButton').click(()=>$('#mobileMenu').toggleClass('hidden'));
    });
  </script>
</body>
</html>
