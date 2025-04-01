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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="index.php">PWGAAA</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-5">
    <h1>Panel Admin - Gestión de Usuarios</h1>
    
    <!-- Formulario de búsqueda y filtrado -->
    <form method="GET" action="panelAdmin.php" class="mb-3">
      <div class="row g-3">
        <div class="col-md-4">
          <input type="text" class="form-control" name="busqueda" placeholder="Buscar por nombre o email" value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>">
        </div>
        <div class="col-md-3">
          <select class="form-select" name="rol">
            <option value="">Todos los roles</option>
            <option value="alumno" <?php echo (isset($_GET['rol']) && $_GET['rol'] === 'alumno') ? 'selected' : ''; ?>>Alumno</option>
            <option value="profesor" <?php echo (isset($_GET['rol']) && $_GET['rol'] === 'profesor') ? 'selected' : ''; ?>>Profesor</option>
            <option value="admin" <?php echo (isset($_GET['rol']) && $_GET['rol'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
          </select>
        </div>
        <div class="col-md-3">
          <input type="date" class="form-control" name="fecha" value="<?php echo isset($_GET['fecha']) ? htmlspecialchars($_GET['fecha']) : ''; ?>">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
      </div>
    </form>
    
    <a href="panelAdmin.php?action=create" class="btn btn-success mb-3">Añadir Usuario</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Rol</th>
          <th>Fecha de Registro</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($usuarios)): ?>
          <?php foreach ($usuarios as $usuario): ?>
            <tr>
              <td><?php echo htmlspecialchars($usuario['id']); ?></td>
              <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
              <td><?php echo htmlspecialchars($usuario['email']); ?></td>
              <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
              <td><?php echo htmlspecialchars($usuario['fecha_registro']); ?></td>
              <td>
                <a href="panelAdmin.php?action=edit&id=<?php echo $usuario['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                <a href="panelAdmin.php?action=delete&id=<?php echo $usuario['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center">No se encontraron usuarios.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
