<?php
session_start();
require_once __DIR__ . '/../src/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT image FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row) {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
        exit;
    }
    $image = $row['image'];

    $del = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $del->execute([$id]);

    if (!empty($image) && $image !== 'default.jpg') {
        $path = __DIR__ . '/img/' . $image;
        if (is_file($path)) @unlink($path);
    }

    echo json_encode(['success' => true]);
    exit;
} catch (PDOException $e) {
    error_log('delete_product error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error en servidor']);
    exit;
}
?>