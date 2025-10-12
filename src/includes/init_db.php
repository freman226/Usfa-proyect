<?php
// filepath: d:\Programación\Php\Proyecto USFA\tienda-guitarras\src\includes\init_db.php
require_once __DIR__ . '/db.php';

$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg',
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

try {
    $pdo->exec($sql);
} catch (PDOException $e) {
    echo "Error al crear la tabla: " . $e->getMessage();
}
?>