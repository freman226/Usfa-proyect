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

// crear tabla users (si no existe) con columna role
$sqlUsers = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
try {
    $pdo->exec($sqlUsers);
} catch (PDOException $e) {
    error_log("Error crear users: " . $e->getMessage());
}

// Si la tabla ya existía pero no tiene la columna role, añadirla
$colCheck = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'role'");
$colCheck->execute();
if ($colCheck->fetchColumn() == 0) {
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN role VARCHAR(20) NOT NULL DEFAULT 'user'");
    } catch (PDOException $e) {
        error_log("Error añadiendo role: " . $e->getMessage());
    }
}

// Opcional: crear un admin inicial si no existe (cambiar credenciales por defecto)
$adminEmail = 'admin@tudominio.com';
$adminUser = 'admin';
$adminPass = 'admin123'; // cambia esto ahora mismo
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
$stmt->execute([$adminEmail]);
if ($stmt->fetchColumn() == 0) {
    $hash = password_hash($adminPass, PASSWORD_DEFAULT);
    $insert = $pdo->prepare("INSERT INTO users (username, email, password, fullname, address, role) VALUES (?, ?, ?, ?, ?, 'admin')");
    try {
        $insert->execute([$adminUser, $adminEmail, $hash, 'Administrador', 'Dirección admin']);
    } catch (PDOException $e) {
        error_log("Error insert admin: " . $e->getMessage());
    }
}
?>