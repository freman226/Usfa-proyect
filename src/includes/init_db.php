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

// Si la tabla products está vacía, semilla con los datos de public/data/db.js
try {
    $count = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    if ($count == 0) {
        $seed = [
            ['Lukather', 'guitarra_01', 'Inspirada en el sonido potente y versátil de Steve Lukather, esta guitarra combina pastillas humbucker activas y un cuerpo de aliso que ofrece un tono cálido y definido, ideal tanto para solos melódicos como para riffs agresivos.', 299.00],
            ['SRV', 'guitarra_02', 'Un homenaje al legendario Stevie Ray Vaughan. Con cuerpo de fresno y mástil de arce, produce un blues vibrante y una respuesta brillante, perfecta para amantes del tono vintage y los bends expresivos.', 349.00],
            ['Borland', 'guitarra_03', 'De estética moderna y sonido alternativo, la Borland ofrece un tono crudo y experimental gracias a su configuración H-S-H. Ideal para guitarristas que buscan destacar en estilos alternativos o industriales.', 329.00],
            ['VAI', 'guitarra_04', 'La VAI es una guitarra diseñada para la velocidad y precisión. Su diapasón de 24 trastes y puente flotante permiten una ejecución impecable, con un sustain prolongado ideal para solos virtuosos y técnicas avanzadas.', 299.00],
            ['Thompson', 'guitarra_05', 'Construida con maderas seleccionadas y una electrónica impecable, la Thompson destaca por su tono claro y natural. Perfecta para sesiones de grabación y presentaciones acústicas con gran proyección sonora.', 399.00],
            ['White', 'guitarra_06', 'Minimalista y elegante, la White ofrece un tono limpio con un ataque suave. Su acabado perlado y su diseño liviano la hacen ideal para presentaciones en vivo con un sonido moderno y cristalino.', 329.00],
            ['Cobain', 'guitarra_07', 'Diseñada para canalizar la energía del grunge, la Cobain combina pastillas P90 con una distorsión orgánica y poderosa. Ideal para acordes densos y riffs con actitud rebelde y sonido crudo.', 349.00],
            ['Dale', 'guitarra_08', 'Inspirada en el rey del surf rock, la Dale ofrece un tono brillante con una reverberación natural. Su trémolo vintage y su construcción ligera son perfectos para sonidos limpios y llenos de energía playera.', 379.00],
            ['Krieger', 'guitarra_09', 'Una guitarra con alma psicodélica y tono profundo. Con cuerpo de caoba y diapasón de palisandro, ofrece una calidez única, ideal para solos envolventes y acordes con mucho cuerpo.', 289.00],
            ['Campbell', 'guitarra_10', 'Equilibrio perfecto entre potencia y claridad. La Campbell incorpora un sistema de pastillas híbrido que permite cambiar entre sonidos clásicos y modernos con facilidad, ideal para guitarristas versátiles.', 349.00],
            ['Reed', 'guitarra_11', 'Con un carácter sobrio y elegante, la Reed está diseñada para ofrecer un tono cálido y expresivo. Su respuesta dinámica la convierte en una excelente opción para jazz, soul y blues contemporáneo.', 399.00],
            ['Hazel', 'guitarra_12', 'La Hazel destaca por su sustain prolongado y su tono balanceado. Su acabado natural y su construcción robusta la hacen ideal para guitarristas que buscan un sonido profesional y una presencia escénica elegante.', 379.00],
        ];

        $pdo->beginTransaction();
        $stmt = $pdo->prepare("INSERT INTO products (name, image, description, price) VALUES (?, ?, ?, ?)");
        foreach ($seed as $p) {
            $stmt->execute($p);
        }
        $pdo->commit();
    }
} catch (PDOException $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    error_log("Error al sembrar products: " . $e->getMessage());
}
?>