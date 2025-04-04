<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis Proyectos - PWGAAA</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }

        .proyecto-card {
            margin-bottom: 1.5rem;
        }

        .proyecto-title {
            color: #007bff;
            text-decoration: underline;
            margin-bottom: 0.5rem;
        }

        .proyecto-date {
            color: #6c757d;
            margin-bottom: 0.75rem;
        }

        .proyecto-summary {
            font-size: 1rem;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <!-- Puedes incluir aquí tu navbar si lo tienes en un archivo común -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">PWGAAA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?> (<?php echo htmlspecialchars($_SESSION['usuario']['rol']); ?>)
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
                                <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                                    <li><a class="dropdown-item" href="panelAdmin.php">Panel Admin</a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="misproyectos.php">Mis Proyectos</a></li>
                                    <li><a class="dropdown-item" href="upload.php">Subir Proyecto</a></li>
                                <?php endif; ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php"><i class="bi bi-person-circle"></i> Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4 text-primary">Mis Proyectos</h1>

        <?php if (!empty($proyectos)): ?>
            <?php foreach ($proyectos as $proyecto): ?>
                <div class="card proyecto-card">
                    <div class="card-body">
                        <h3 class="card-title proyecto-title">
                            <a href="verTfg.php?id=<?php echo $proyecto['id']; ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($proyecto['titulo']); ?>
                            </a>
                        </h3>
                        <p class="card-text proyecto-date">
                            Fecha: <?php echo htmlspecialchars($proyecto['fecha']); ?>
                        </p>
                        <p class="card-text proyecto-summary">
                            <?php echo htmlspecialchars($proyecto['resumen']); ?>
                        </p>
                        <?php if (isset($proyecto['nota'])): ?>
                            <p class="card-text">
                                <strong>Nota:</strong> <?php echo htmlspecialchars($proyecto['nota']); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No tienes proyectos asociados.</p>
        <?php endif; ?>
    </div>

    <footer class="bg-primary text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> PWGAAA. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>