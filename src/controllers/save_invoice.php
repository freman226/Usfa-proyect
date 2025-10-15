<?php
// filepath: d:\Programación\Php\Proyecto USFA\tienda-guitarras\src\controllers\save_invoice.php
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $products = $_POST['products'] ?? '';
    $total = $_POST['total'] ?? 0;
    $order_date = date('Y-m-d');

    if ($products && $total) {
        $stmt = $pdo->prepare("INSERT INTO invoice (products, total, order_date) VALUES (?, ?, ?)");
        $stmt->execute([$products, $total, $order_date]);
        echo json_encode(['success' => true, 'message' => 'Compra registrada']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
    exit;
}
echo json_encode(['success' => false, 'message' => 'Método no permitido']);
?>