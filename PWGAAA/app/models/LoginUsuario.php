<?php
require_once __DIR__ . '/../../config/database.php';

class LoginUsuario {
    public static function login($email, $password) {
        $conexion = conectarDB();
        $sql = "SELECT id, nombre, email, password, rol FROM usuarios WHERE email = :email";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Si se encontró el usuario y la contraseña es correcta, lo retornamos.
        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }
        return false;
    }
}
