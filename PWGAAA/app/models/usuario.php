<?php
require_once __DIR__ . '/../../config/database.php';

class Usuario {
    // Registra un nuevo usuario; por defecto el rol es 'alumno'
    public static function registrar($nombre, $email, $password, $rol = 'alumno') {
        $db = conectarDB();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $email, $hash, $rol]);
    }
    
    // Obtiene todos los usuarios
    public static function obtenerTodos() {
        $db = conectarDB();
        $stmt = $db->query("SELECT * FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Obtiene un usuario por su ID
    public static function obtenerPorId($id) {
        $db = conectarDB();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Actualiza los datos del usuario; si $password está vacío, se conserva el actual
    public static function actualizar($id, $nombre, $email, $rol, $password = null) {
        $db = conectarDB();
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol = ?, password = ? WHERE id = ?");
            $stmt->execute([$nombre, $email, $rol, $hash, $id]);
        } else {
            $stmt = $db->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?");
            $stmt->execute([$nombre, $email, $rol, $id]);
        }
    }
    
    // Elimina un usuario
    public static function eliminar($id) {
        $db = conectarDB();
        $stmt = $db->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
    }

// Obtiene usuarios filtrados por búsqueda, rol y fecha (si se proporcionan)
    public static function obtenerFiltrados($busqueda = '', $rol = '', $fecha = '') {
        $db = conectarDB();
        $query = "SELECT * FROM usuarios WHERE 1=1 ";
        $params = [];
    
    if (!empty($busqueda)) {
        // Buscamos coincidencias en nombre o email
        $query .= "AND (nombre LIKE ? OR email LIKE ?) ";
        $params[] = '%' . $busqueda . '%';
        $params[] = '%' . $busqueda . '%';
    }
    
    if (!empty($rol)) {
        $query .= "AND rol = ? ";
        $params[] = $rol;
    }
    
    if (!empty($fecha)) {
        // Comparamos solo la parte de la fecha
        $query .= "AND DATE(fecha_registro) = ? ";
        $params[] = $fecha;
    }
    
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}

?>
