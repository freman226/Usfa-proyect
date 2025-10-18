<?php

session_start();
require_once '../src/includes/init_db.php';

$page = $_GET['page'] ?? 'productos';

$protectedPages = ['productos', 'compra', 'create_product'];

if (in_array($page, $protectedPages, true) && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

if (in_array($page, ['pedidos', 'create_product'], true)) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php?page=login');
        exit;
    }
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: index.php?page=productos');
        exit;
    }
}

require_once '../src/includes/header.php';

switch ($page) {
    case 'login':
        require_once __DIR__ . '/../src/views/login.php';
        break;
    case 'register':
        require_once __DIR__ . '/../src/views/register.php';
        break;
    case 'compra':
        require_once __DIR__ . '/../src/views/compra.php';
        break;
    case 'pedidos':
        require_once __DIR__ . '/../src/views/pedidos.php';
        break;
    case 'create_product':
        require_once __DIR__ . '/../src/views/create_product.php';
        break;
    case 'edit_product':                 
        require_once __DIR__ . '/../src/views/edit_product.php';
        break;
    default:
        require_once __DIR__ . '/../src/views/productos.php';
        break;
}

require_once __DIR__ . '/../src/includes/footer.php';
?>