<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Académico</title>
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
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
            min-height: 180px;
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
            width: 250px;
            height: 250px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #003366;
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
            margin-bottom: 15px;
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
            margin-top: 20px;
            display: none; /* Ocultar por defecto */
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
            margin-left: 40px;
            max-width: 500px;
        }
        /* Estilo para el campo de subida de archivo PDF */
        .input-file {
            width: auto;
            display: inline-block;
        }
        /* Evitar redimensionamiento del contenedor del textarea */
        textarea {
            resize: none;
        }
        /* Estilo para el nombre y edad */
        .name-age {
            margin-bottom: 20px;
            text-align: right;
        }
        .name-age h1 {
            font-size: 2em;
            margin: 0;
        }
        .name-age p {
            font-size: 1.2em;
            color: #666;
        }
        .edit-button {
            font-size: 20px;
            color: white; /* Texto blanco para "Editar perfil" */
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .edit-button:hover {
            color: #00509e;
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
    <!-- Botón de Editar -->
    <span class="edit-button" id="edit-button">⚙️ Editar perfil</span>

    <!-- Nombre, Apellidos y Edad -->
    <div class="name-age">
        <h1>Juan Pérez</h1>
        <p>Edad: 25 años</p>
    </div>

    <!-- Datos de contacto -->
    <div class="profile-container">
        <div class="profile-photo">
            <img id="profile-image" src="" alt="Foto de perfil">
            <input type="file" id="profile-photo" name="profile-photo" accept="image/*" onchange="previewImage(event)">
            <label for="profile-photo" id="upload-label" style="display: none;">Sube tu foto</label> <!-- Ocultar por defecto -->
        </div>
        <div class="profile-info">
            <div class="section">
                <h2>Datos de contacto</h2>
                <input type="text" placeholder="Teléfono" class="input-field" disabled>
                <input type="email" placeholder="Correo electrónico" class="input-field" disabled>
            </div>
        </div>
    </div>

    <!-- Un poco de mí -->
    <div class="section">
        <h2>Un poco de mí</h2>
        <textarea placeholder="Breve descripción sobre ti" rows="4" class="input-field" disabled></textarea>
    </div>

    <hr style="border: 1px solid #ccc; margin: 10px 0;">
    <!-- Actividad de acceso -->
    <div class="section">
        <h2>Actividad de acceso</h2>
        <p><strong>Último acceso:</strong> 02 de abril de 2025, 14:30</p>
        <p><strong>IP de acceso:</strong> 192.168.1.10</p>
    </div>

    <hr style="border: 1px solid #ccc; margin: 10px 0;">
    <!-- Informes -->
    <div class="section">
        <h2>Informes</h2>

        <h3>Estado de Anteproyecto TFG</h3>
        <p id="anteproyecto-status">No subido</p>

        <h3>Estado de Proyecto Final TFG</h3>
        <p id="proyecto-status">No subido</p>

        <h3>Nota de Trabajo de Fin de Grado</h3>
        <input type="number" id="nota-final" value="8.5" readonly class="input-field" placeholder="Nota final">
    </div>

    <button id="guardar">Guardar</button>
</div>

<!-- Footer -->
<div class="footer-banner">
    <p>© 2025 Nombre de la Empresa. Todos los derechos reservados.</p>
</div>

<script>
    let editMode = false;

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profile-image');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Cambiar a modo de edición
    document.getElementById('edit-button').onclick = function() {
        editMode = !editMode;

        // Mostrar/ocultar el botón "Sube tu foto" y el botón "Guardar"
        document.getElementById('upload-label').style.display = editMode ? 'inline-block' : 'none';
        document.getElementById('guardar').style.display = editMode ? 'block' : 'none';

        // Activar o desactivar campos de entrada
        document.querySelectorAll('.input-field').forEach(field => {
            field.disabled = !editMode;
        });
        document.getElementById('profile-photo').disabled = !editMode;
    };

    // Al hacer clic en guardar, desactivar la edición
    document.getElementById('guardar').onclick = function() {
        editMode = false;
        document.querySelectorAll('.input-field').forEach(field => {
            field.disabled = true;
        });
        document.getElementById('profile-photo').disabled = true;
        document.getElementById('upload-label').style.display = 'none';
        document.getElementById('guardar').style.display = 'none';
    };
</script>

</body>
</html>
