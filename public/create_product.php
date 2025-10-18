<?php

session_start();
require_once __DIR__ . '/../src/includes/db.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?page=productos');
    exit;
}

$name = trim($_POST['name'] ?? '');
$price = $_POST['price'] ?? '';
$description = trim($_POST['description'] ?? '');
$imageFilename = 'default.jpg';

if ($name === '' || $price === '' || !is_numeric($price)) {
    echo "<script>alert('Datos inválidos.'); window.location.href='index.php?page=create_product';</script>";
    exit;
}

if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['image']['tmp_name'];
    $origName = basename($_FILES['image']['name']);
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp','gif'];
    if (in_array($ext, $allowed, true)) {
        $imageFilename = uniqid('p_', true) . '.' . $ext;
        $destDir = __DIR__ . '/img/';
        if (!is_dir($destDir)) mkdir($destDir, 0755, true);
        move_uploaded_file($tmp, $destDir . $imageFilename);
    }
}

try {
    $stmt = $pdo->prepare("INSERT INTO products (name, image, description, price) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $imageFilename, $description, $price]);
    echo "<script>alert('Producto creado.'); window.location.href='index.php?page=productos';</script>";
    exit;
} catch (PDOException $e) {
    error_log('Error crear producto: ' . $e->getMessage());
    echo "<script>alert('Error al crear producto.'); window.location.href='index.php?page=create_product';</script>";
    exit;
}
?>