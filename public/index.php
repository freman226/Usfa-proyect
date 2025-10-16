<?php
// Este archivo es el punto de entrada de la aplicación. Carga la vista principal y gestiona la lógica de enrutamiento.

require_once '../src/includes/init_db.php'; // <-- Añade esta línea
require_once '../src/includes/header.php';

// Lógica de enrutamiento simple
$page = isset($_GET['page']) ? $_GET['page'] : 'productos';

switch ($page) {
    case 'productos':
        require_once '../src/views/productos.php';
        break;
    case 'compra':
        require_once '../src/views/compra.php';
        break;
    case 'pedidos':
        require_once '../src/views/pedidos.php';
        break;    
    case 'login':
        require_once '../src/views/login.php';
        break;
    case 'register':
        require_once '../src/views/register.php';
        break;
}

require_once '../src/includes/footer.php';
?>