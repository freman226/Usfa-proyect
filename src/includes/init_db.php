<?php
require_once __DIR__ . '/db.php';

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

$colCheck = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'role'");
$colCheck->execute();
if ($colCheck->fetchColumn() == 0) {
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN role VARCHAR(20) NOT NULL DEFAULT 'user'");
    } catch (PDOException $e) {
        error_log("Error añadiendo role: " . $e->getMessage());
    }
}

$adminEmail = 'admin@email.com';
$adminUser = 'admin';
$adminPass = 'admin123'; 
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

$colCheck = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'invoice' AND COLUMN_NAME = ?");
$colCheck->execute(['user_id']);
if ($colCheck->fetchColumn() == 0) {
    $pdo->exec("ALTER TABLE invoice ADD COLUMN user_id INT NULL");
}
$colCheck->execute(['user_name']);
if ($colCheck->fetchColumn() == 0) {
    $pdo->exec("ALTER TABLE invoice ADD COLUMN user_name VARCHAR(255) NULL");
}
?>