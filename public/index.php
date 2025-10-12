<?php
// Este archivo es el punto de entrada de la aplicación. Carga la vista principal y gestiona la lógica de enrutamiento.

require_once '../src/includes/init_db.php'; // <-- Añade esta línea
require_once '../src/includes/header.php';

// Lógica de enrutamiento simple
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'productos':
        require_once '../src/views/productos.php';
        break;
    case 'contacto':
        require_once '../src/views/contacto.php';
        break;
    case 'home':
    default:
        require_once '../src/views/home.php';
        break;
}

require_once '../src/includes/footer.php';
?>