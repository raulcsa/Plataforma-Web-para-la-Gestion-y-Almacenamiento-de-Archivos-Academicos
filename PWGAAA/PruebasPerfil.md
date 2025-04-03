<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f9fc;
            color: #333;
        }
        /* Banner */
        .banner {
            display: flex;
            align-items: center;
            background-color: #003366;
            color: white;
            padding: 15px 20px;
        }
        .banner img {
            height: 50px;
            margin-right: 20px;
        }
        .banner p {
            font-size: 1.5em;
            font-weight: bold;
            margin: 0;
        }
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        /* Separadores */
        .section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ccc; /* Línea separadora más fina */
        }
        .profile-photo {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
        }
        .profile-photo input[type="file"] {
            display: none;
        }
        .profile-photo label {
            background-color: #003366;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 20px;
        }
        .profile-photo label:hover {
            background-color: #00509e;
        }
        .profile-photo img {
            width: 250px; /* Aumento el tamaño de la imagen */
            height: 250px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #003366; /* Color del marco */
            transition: transform 0.3s ease;
            display: none;
        }
        .profile-photo .camera-icon {
            font-size: 25px;
            color: white;
            text-align: center;
        }
        h2 {
            color: #003366;
        }
        .input-field, .input-file {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 16px;
        }
        #nota-final {
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            cursor: not-allowed;
        }
        /* Barra Progresiva */
        .progress-container {
            background-color: #f1f1f1;
            border-radius: 5px;
            width: 100%;
            height: 40px;
            margin-top: 10px;
            display: flex;
        }
        .progress-segment {
            flex: 1;
            background-color: #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.5s ease;
            padding: 10px;
        }
        .completed { background-color: #4caf50; }
        .in-progress { background-color: #ff9800; }
        .not-completed { background-color: #ddd; }
        /* Botón Guardar */
        #guardar {
            background-color: #003366;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        #guardar:hover {
            background-color: #00509e;
        }
        /* Footer */
        .footer-banner {
            background-color: #003366;
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 1.2em;
        }
        .profile-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-info {
            margin-left: 40px; /* Separar más a la derecha */
            max-width: 500px;
        }
    </style>
</head>
<body>

<!-- Banner Inicial -->
<div class="banner">
    <img src="https://via.placeholder.com/50" alt="Logo de la empresa"> <!-- Logo inventado -->
    <p>Nombre de la Empresa</p>
</div>

<div class="container">
    <!-- Foto de Perfil y Datos de Contacto -->
    <div class="profile-container">
        <div class="profile-photo">
            <img id="profile-image" src="" alt="Foto de perfil">
            <input type="file" id="profile-photo" name="profile-photo" accept="image/*">
            <label for="profile-photo">Sube tu foto</label>
        </div>
        <div class="profile-info">
            <div class="section">
                <h2>Datos de contacto</h2>
                <input type="text" placeholder="Teléfono" class="input-field">
                <input type="email" placeholder="Correo electrónico" class="input-field">
            </div>
        </div>
    </div>

    <!-- Descripción -->
    <div class="section">
        <h2>Descripción</h2>
        <textarea placeholder="Breve descripción sobre ti" rows="4" class="input-field"></textarea>
    </div>

    <!-- Información Académica (solo lectura, con valores por defecto) -->
    <div class="section">
        <h2>Información académica</h2>
        <input type="text" value="Segundo de ASIR" class="input-field" readonly>
        <input type="text" value="Curso 2024/2025" class="input-field" readonly>
        <input type="text" value="Modalidad Presencial" class="input-field" readonly>
    </div>

    <!-- Subida de Archivos (solo PDF) -->
    <div class="section">
        <h2>Subir archivos</h2>
        <label for="anteproyecto">Ante proyecto (PDF):</label>
        <input type="file" id="anteproyecto" name="anteproyecto" class="input-file" accept=".pdf"><br><br>
        <label for="proyecto">Proyecto (PDF):</label>
        <input type="file" id="proyecto" name="proyecto" class="input-file" accept=".pdf"><br><br>
        <input type="text" placeholder="Nota final del proyecto" class="input-field" id="nota-final" readonly>
    </div>

    <!-- Barra Progresiva -->
    <div class="section">
        <h2>Progreso de las etapas</h2>
        <div class="progress-container">
            <div class="progress-segment not-completed" id="anteproyecto-bar">Entrega del anteproyecto</div>
            <div class="progress-segment not-completed" id="proyecto-bar">Entrega del proyecto</div>
            <div class="progress-segment not-completed" id="nota-bar">Recibo de nota del proyecto</div>
        </div>
    </div>

    <!-- Botón de Guardado -->
    <div class="section">
        <button id="guardar">Guardar</button>
    </div>
</div>

<!-- Footer -->
<div class="footer-banner">
    <p>© 2025 Nombre de la Empresa | Todos los derechos reservados</p>
</div>

<script>
    // Función para previsualizar la foto de perfil
    document.getElementById("profile-photo").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById("profile-image");
                imagePreview.src = e.target.result;
                imagePreview.style.display = "block";  // Mostrar la imagen
            };
            reader.readAsDataURL(file);
        }
    });

    // Minimizar el botón una vez suba la foto
    document.getElementById("profile-photo").addEventListener("change", function() {
        const label = document.querySelector("label[for='profile-photo']");
        label.style.display = "none";  // Minimizar el botón de subir foto
    });

    // Funciones para actualizar la barra progresiva
    document.getElementById("anteproyecto").addEventListener("change", function() {
        document.getElementById("anteproyecto-bar").classList.add("completed");
        document.getElementById("anteproyecto-bar").classList.remove("not-completed");
    });

    document.getElementById("proyecto").addEventListener("change", function() {
        document.getElementById("proyecto-bar").classList.add("in-progress");
        document.getElementById("proyecto-bar").classList.remove("not-completed");
    });

    document.getElementById("nota-final").addEventListener("change", function() {
        document.getElementById("nota-bar").classList.add("completed");
        document.getElementById("nota-bar").classList.remove("not-completed");
    });
</script>

</body>
</html>
