<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Calificar TFG: <?= htmlspecialchars($tfg['titulo']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>body { font-family:'Inter',sans-serif; }</style>
</head>
<body class="min-h-screen bg-indigo-50 flex flex-col">
  <?php require __DIR__ . '/navbarView.php'; ?>

  <main class="flex-grow flex items-center justify-center p-4">
    <div class="w-full max-w-lg bg-white rounded-xl shadow p-8">
      <h1 class="text-2xl font-bold text-indigo-600 mb-6">Calificar TFG</h1>

      <?php if (!empty($_SESSION['mensaje'])): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
          <?= htmlspecialchars($_SESSION['mensaje']); unset($_SESSION['mensaje']); ?>
        </div>
      <?php endif; ?>

      <form action="correction.php?action=validar&id=<?= $tfg['id'] ?>" method="POST">
        <?php foreach($alumnosNotas as $row): ?>
          <div class="mb-6">
            <!-- Primera fila: cuadro nombre + cuadro nota -->
            <div class="grid grid-cols-2 gap-4 mb-2">
              <input
                type="text"
                value="<?= htmlspecialchars($row['nombre']) ?>"
                disabled
                class="p-2 border border-gray-300 rounded bg-gray-100"
              />
              <input
                type="number"
                name="nota[<?= $row['alumno_id'] ?>]"
                value="<?= htmlspecialchars($row['nota'] ?? '') ?>"
                min="1"
                max="10"
                required
                class="p-2 border border-gray-300 rounded"
                placeholder="Nota (1-10)"
              />
            </div>
            <!-- Segunda fila: comentario -->
            <textarea
              name="comentario[<?= $row['alumno_id'] ?>]"
              rows="3"
              placeholder="Comentario (opcional)"
              class="w-full p-2 border border-gray-300 rounded"
            ><?= htmlspecialchars($row['comentario'] ?? '') ?></textarea>
          </div>
        <?php endforeach; ?>

        <!-- Botones al final -->
        <div class="flex gap-4 mt-6">
          <button
            type="submit"
            class="flex-1 bg-indigo-600 text-white py-2 rounded hover:bg-indigo-500 transition"
          >
            Validar
          </button>
          <a
            href="editarTfg.php?id=<?= $tfg['id'] ?>"
            class="flex-1 text-center border border-gray-300 py-2 rounded hover:bg-gray-100 transition"
          >
            Atrás
          </a>
        </div>
      </form>
    </div>
  </main>

  <footer class="bg-white shadow-inner">
    <div class="max-w-7xl mx-auto py-4 text-center text-gray-600">
      &copy; <?= date('Y') ?> PWGAAA. Todos los derechos reservados.
    </div>
  </footer>
</body>
</html>
