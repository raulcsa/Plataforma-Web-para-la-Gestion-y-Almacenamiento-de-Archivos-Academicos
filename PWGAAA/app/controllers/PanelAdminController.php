<?php
require_once __DIR__ . '/../models/usuario.php';

class PanelAdminController {
    // Muestra la lista de usuarios
    public function index() {
        $busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
        $filtroRol = isset($_GET['rol']) ? trim($_GET['rol']) : '';
        $filtroFecha = isset($_GET['fecha']) ? trim($_GET['fecha']) : '';
    
        // Si hay filtros aplicados, guardarlos en sesión y redirigir para limpiar la URL
        if (!empty($_GET)) {
            $_SESSION['filtros_panel'] = [
                'busqueda' => $busqueda,
                'rol' => $filtroRol,
                'fecha' => $filtroFecha
            ];
            header('Location: panelAdmin');
            exit;
        }
    
        // Recuperar filtros desde sesión si existen
        $filtros = $_SESSION['filtros_panel'] ?? [
            'busqueda' => '',
            'rol' => '',
            'fecha' => ''
        ];
        unset($_SESSION['filtros_panel']);
    
        // Obtener usuarios según filtros
        if ($filtros['busqueda'] === '' && $filtros['rol'] === '' && $filtros['fecha'] === '') {
            $usuarios = Usuario::obtenerTodos();
        } else {
            $usuarios = Usuario::obtenerFiltrados($filtros['busqueda'], $filtros['rol'], $filtros['fecha']);
        }
    
        // Hacer los filtros disponibles en la vista
        $_GET = $filtros;
    
        require_once __DIR__ . '/../views/adminPanelView.php';
    }
    
    
    // Muestra el formulario de edición de usuario
    public function edit() {
        if (!isset($_GET['id'])) {
            header("Location: panelAdmin");
            exit;
        }
        $id = $_GET['id'];
        $usuario = Usuario::obtenerPorId($id);
        if (!$usuario) {
            header("Location: panelAdmin");
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
        header("Location: panelAdmin");
        exit;
    }
    
    // Elimina un usuario
    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            Usuario::eliminar($id);
        }
        header("Location: panelAdmin");
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
        header("Location: panelAdmin");
        exit;
    }
}
?>
