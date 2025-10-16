<?php
// Este archivo es el punto de entrada de la aplicación. Carga la vista principal y gestiona la lógica de enrutamiento.

session_start();
require_once '../src/includes/init_db.php';
require_once '../src/includes/header.php';

$page = $_GET['page'] ?? 'productos';
switch ($page) {
    case 'login':
        require_once '../src/views/login.php';
        break;
    case 'register':
        require_once '../src/views/register.php';
        break;
    case 'compra':
        require_once '../src/views/compra.php';
        break;
    case 'pedidos':
        require_once '../src/views/pedidos.php';
        break;
    default:
        require_once '../src/views/productos.php';
        break;
}

require_once '../src/includes/footer.php';
?>