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

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = trim($_POST['name'] ?? '');
$price = $_POST['price'] ?? '';
$description = trim($_POST['description'] ?? '');

if ($id <= 0 || $name === '' || $price === '' || !is_numeric($price)) {
    echo "<script>alert('Datos inválidos.'); window.location.href='index.php?page=edit_product&id=' + " . json_encode($id) . ";</script>";
    exit;
}

$imageFilename = null;
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

        $stmt = $pdo->prepare('SELECT image FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $old = $stmt->fetchColumn();
        if ($old && $old !== 'default.jpg') {
            $path = __DIR__ . '/img/' . $old;
            if (is_file($path)) @unlink($path);
        }
    }
}

try {
    if ($imageFilename) {
        $stmt = $pdo->prepare('UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?');
        $stmt->execute([$name, $description, $price, $imageFilename, $id]);
    } else {
        $stmt = $pdo->prepare('UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?');
        $stmt->execute([$name, $description, $price, $id]);
    }
    echo "<script>alert('Producto actualizado.'); window.location.href='index.php?page=productos';</script>";
    exit;
} catch (PDOException $e) {
    error_log('edit_product error: ' . $e->getMessage());
    echo "<script>alert('Error al actualizar.'); window.location.href='index.php?page=edit_product&id=' + " . json_encode($id) . ";</script>";
    exit;
}
?>