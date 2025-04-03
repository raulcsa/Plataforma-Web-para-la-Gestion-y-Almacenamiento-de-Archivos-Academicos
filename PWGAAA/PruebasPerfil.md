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
            margin-bottom: 0; /* Elimina el margen inferior */
            padding-bottom: 0; /* Elimina el espacio inferior */
            border-bottom: none; /* Elimina el borde inferior */
            min-height: 180px; /* Mantiene la altura mínima */
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
            margin-bottom: 15px; /* Ajustado para que sea más compacto */
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
            margin-top: 20px; /* Espaciado ajustado para un diseño más compacto */
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
        /* Estilo para el campo de subida de archivo PDF */
        .input-file {
            width: auto;
            display: inline-block;
        }
        /* Evitar redimensionamiento del contenedor del textarea */
        textarea {
            resize: none; /* Evita que el usuario cambie el tamaño */
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
            <input type="file" id="profile-photo" name="profile-photo" accept="image/*" onchange="previewImage(event)">
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

    <!-- Un poco de mí -->
    <div class="section">
        <h2>Un poco de mí</h2>
        <textarea placeholder="Breve descripción sobre ti" rows="4" class="input-field"></textarea>
    </div>

    <!-- Actividad de acceso -->
    <div class="section">
        <h2>Actividad de acceso</h2>
        <p><strong>Último acceso:</strong> 02 de abril de 2025, 14:30</p>
        <p><strong>IP de acceso:</strong> 192.168.1.10</p>
    </div>

    <!-- Informes -->
    <div class="section">
        <h2>Informes</h2>
        <h3>Resumen de calificaciones</h3>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Asignatura</th>
                    <th>1er Parcial</th>
                    <th>2do Parcial</th>
                    <th>3er Parcial</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Administración de Sistemas</td>
                    <td>9</td>
                    <td>9</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>Gestores de bases de datos</td>
                    <td>9</td>
                    <td>9</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>Administración de Sistemas Operativos</td>
                    <td>9</td>
                    <td>8</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>Empresa e iniciativa emprendedora</td>
                    <td>9</td>
                    <td>8</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>Implantación de Aplicaciones web</td>
                    <td>9</td>
                    <td>8</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>Inglés Técnico para Grado Superior</td>
                    <td>8</td>
                    <td>9</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>Seguridad y Alta Disponibilidad</td>
                    <td>9</td>
                    <td>8</td>
                    <td>9</td>
                </tr>
                <tr>
                    <td>Servicios de Red e Internet</td>
                    <td>5</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
                <tr>
                    <td>Proyecto de administración de sistemas informáticos en red</td>
                    <td colspan="3">Excelente</td>
                </tr>
                <tr>
                    <td>Formación en centros de trabajo</td>
                    <td colspan="3">Aprobado</td>
                </tr>
            </tbody>
        </table>
    </div>

    <button id="guardar">Guardar</button>
</div>

<!-- Footer -->
<div class="footer-banner">
    <p>© 2025 Nombre de la Empresa. Todos los derechos reservados.</p>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profile-image');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

</body>
</html>
