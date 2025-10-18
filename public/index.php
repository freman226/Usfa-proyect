<?php
// Este archivo es el punto de entrada de la aplicación. Carga la vista principal y gestiona la lógica de enrutamiento.

session_start();
require_once '../src/includes/init_db.php';

// Enrutamiento simple
$page = $_GET['page'] ?? 'productos';

// Páginas que requieren autenticación (cualquiera autenticado)
$protectedPages = ['productos', 'compra', 'create_product'];

// Si la página está protegida y no hay sesión, redirigir antes de emitir HTML
if (in_array($page, $protectedPages, true) && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

// Restricción específica: solo admin puede acceder a 'pedidos' y 'create_product'
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

// Ahora sí incluir header (envía HTML)
require_once '../src/includes/header.php';

// Cargar la vista correspondiente
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
    case 'edit_product':                 // <-- añadir esto
        require_once __DIR__ . '/../src/views/edit_product.php';
        break;
    default:
        require_once __DIR__ . '/../src/views/productos.php';
        break;
}

require_once __DIR__ . '/../src/includes/footer.php';
?>