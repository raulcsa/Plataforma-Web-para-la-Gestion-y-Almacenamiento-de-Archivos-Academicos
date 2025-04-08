<?php
// public/perfil.php

// Incluir el controlador que gestiona la página de perfil
require_once __DIR__ . '/../app/controllers/PerfilController.php';

// Con el simple require, se ejecuta el código del controlador que:
// 1. Verifica la sesión.
// 2. Si el usuario está logueado, define la variable $user y carga la vista (perfilView.php)
