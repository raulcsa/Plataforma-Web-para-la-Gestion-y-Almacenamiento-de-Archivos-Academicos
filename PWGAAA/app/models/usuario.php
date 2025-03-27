<?php
require_once __DIR__ . '/../../config/database.php';

class Usuario {
    public static function registrar($nombre, $email, $password) {
        $conexion = conectarDB();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $rol = "alumno"; // Rol fijo

        $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (:nombre, :email, :password, :rol)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':nombre'   => $nombre,
            ':email'    => $email,
            ':password' => $hashed_password,
            ':rol'      => $rol
        ]);
    }
}
