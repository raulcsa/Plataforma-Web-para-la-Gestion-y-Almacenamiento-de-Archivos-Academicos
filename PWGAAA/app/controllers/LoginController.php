<?php
require_once __DIR__ . '/../models/LoginUsuario.php';

class LoginController {
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $mensaje = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"]);
            $password = $_POST["password"];

            $usuario = LoginUsuario::login($email, $password);
            if ($usuario) {
                // Iniciar la sesión y guardar la información del usuario
                $_SESSION['usuario'] = $usuario;
                // Redirigir a la página de inicio (o a una página protegida)
                header("Location: index");
                exit;
            } else {
                $mensaje = "Correo o contraseña incorrectos.";
            }
        }
        // Cargar la vista del login
        require_once __DIR__ . '/../views/loginView.php';
    }
}
