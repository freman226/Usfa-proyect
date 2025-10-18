<?php
require_once __DIR__ . '/../includes/db.php';

function getProductos() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM products');
    return $stmt->fetchAll();
}

function addProducto($name, $description, $price) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO products (name, description, price) VALUES (?, ?, ?)');
    return $stmt->execute([$name, $description, $price]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '';

    if ($name && $description && $price) {
        if (addProducto($name, $description, $price)) {
            echo json_encode(['success' => true, 'message' => 'Producto añadido']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al añadir producto']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
    exit;
}
?>