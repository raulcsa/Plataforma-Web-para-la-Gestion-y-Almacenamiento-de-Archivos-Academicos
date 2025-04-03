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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Panel Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .navbar {
            background-color: #2c3e50;
        }
        .navbar-brand, .nav-link {
            color: #ecf0f1 !important;
        }
        .container {
            margin-top: 50px;
        }
        .btn-primary {
            background-color: #1abc9c;
            border: none;
        }
        .btn-primary:hover {
            background-color: #16a085;
        }
        .btn-success {
            background-color: #27ae60;
            border: none;
        }
        .btn-success:hover {
            background-color: #2ecc71;
        }
        .form-control, .form-select {
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }
        .form-label {
            font-weight: bold;
        }
        footer {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 15px 0;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">PWGAAA</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="panelAdmin.php">Volver</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center text-dark">Editar Usuario</h1>

        <form method="POST" action="panelAdmin.php?action=update">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select name="rol" id="rol" class="form-select" required>
                    <option value="alumno" <?php if($usuario['rol'] == 'alumno') echo 'selected'; ?>>Alumno</option>
                    <option value="profesor" <?php if($usuario['rol'] == 'profesor') echo 'selected'; ?>>Profesor</option>
                    <option value="admin" <?php if($usuario['rol'] == 'admin') echo 'selected'; ?>>Admin</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña (dejar en blanco para no cambiar)</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <button type="submit" class="btn btn-success w-100">Actualizar Usuario</button>
        </form>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
