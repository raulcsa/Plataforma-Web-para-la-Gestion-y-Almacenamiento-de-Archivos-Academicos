<?php
require_once  __DIR__ . '/../models/usuario.php';


class UsuarioController {
    public function registrar() {
        $mensaje = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = trim($_POST["nombre"]);
            $email = trim($_POST["email"]);
            $password = $_POST["password"];
            $confirm_password = $_POST["confirm_password"];

            if (empty($nombre) || empty($email) || empty($password) || empty($confirm_password)) {
                $mensaje = "Por favor, completa todos los campos.";
            } elseif ($password !== $confirm_password) {
                $mensaje = "Las contraseñas no coinciden.";
            } else {
                try {
                    Usuario::registrar($nombre, $email, $password);
                    $mensaje = "Registro completado con éxito.";
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) {
                        $mensaje = "El correo ya está registrado.";
                    } else {
                        $mensaje = "Error: " . $e->getMessage();
                    }
                }
            }
        }

        // Se carga la vista y se le pasa el mensaje (si lo hubiera)
        require_once __DIR__ . '/../views/registro.php';
    }
}

