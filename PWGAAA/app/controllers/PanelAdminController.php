<?php
require_once __DIR__ . '/../models/usuario.php';

class PanelAdminController {
    // Muestra la lista de usuarios
    public function index() {
        $busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
        $filtroRol = isset($_GET['rol']) ? trim($_GET['rol']) : '';
        $filtroFecha = isset($_GET['fecha']) ? trim($_GET['fecha']) : '';
        
        // Si no se aplican filtros, se podrían obtener todos:
        if ($busqueda === '' && $filtroRol === '' && $filtroFecha === '') {
            $usuarios = Usuario::obtenerTodos();
        } else {
            $usuarios = Usuario::obtenerFiltrados($busqueda, $filtroRol, $filtroFecha);
        }
        
        require_once __DIR__ . '/../views/adminPanelView.php';
    }
    
    
    // Muestra el formulario de edición de usuario
    public function edit() {
        if (!isset($_GET['id'])) {
            header("Location: panelAdmin.php");
            exit;
        }
        $id = $_GET['id'];
        $usuario = Usuario::obtenerPorId($id);
        if (!$usuario) {
            header("Location: panelAdmin.php");
            exit;
        }
        require_once __DIR__ . '/../views/adminEditUserView.php';
    }
    
    // Procesa la actualización del usuario
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $rol = $_POST['rol'];
            $password = $_POST['password']; // Si está vacío, no se actualizará
            Usuario::actualizar($id, $nombre, $email, $rol, $password);
        }
        header("Location: panelAdmin.php");
        exit;
    }
    
    // Elimina un usuario
    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            Usuario::eliminar($id);
        }
        header("Location: panelAdmin.php");
        exit;
    }
    
    // Muestra el formulario para crear un nuevo usuario
    public function create() {
        require_once __DIR__ . '/../views/adminNewUserView.php';
    }
    
    // Procesa la creación de un nuevo usuario
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $rol = $_POST['rol'];
            $password = $_POST['password'];
            Usuario::registrar($nombre, $email, $password, $rol);
        }
        header("Location: panelAdmin.php");
        exit;
    }
}
?>
