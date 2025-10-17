<?php
// Este archivo es el punto de entrada de la aplicación. Carga la vista principal y gestiona la lógica de enrutamiento.

session_start();
require_once '../src/includes/init_db.php';

// Enrutamiento simple
$page = $_GET['page'] ?? 'productos';

// Páginas que requieren autenticación
$protectedPages = ['productos', 'pedidos', 'compra'];

// Si la página está protegida y no hay sesión, redirigir antes de emitir HTML
if (in_array($page, $protectedPages, true) && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
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
    default:
        require_once __DIR__ . '/../src/views/productos.php';
        break;
}

require_once __DIR__ . '/../src/includes/footer.php';
?>