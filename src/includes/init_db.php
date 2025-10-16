<?php
// filepath: d:\Programación\Php\Proyecto USFA\tienda-guitarras\src\includes\init_db.php
require_once __DIR__ . '/db.php';

// Crear tabla products
$sqlProducts = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg',
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

try {
    $pdo->exec($sqlProducts);
} catch (PDOException $e) {
    echo "Error al crear la tabla products: " . $e->getMessage();
}

// Crear tabla invoice
$sqlInvoice = "CREATE TABLE IF NOT EXISTS invoice (
    id INT AUTO_INCREMENT PRIMARY KEY,
    products JSON NOT NULL,
    total INT NOT NULL,
    order_date DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

try {
    $pdo->exec($sqlInvoice);
} catch (PDOException $e) {
    echo "Error al crear la tabla invoice: " . $e->getMessage();
}

// Crear tabla users
$sqlUsers = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

try {
    $pdo->exec($sqlUsers);
} catch (PDOException $e) {
    echo "Error al crear la tabla users: " . $e->getMessage();
}
?>