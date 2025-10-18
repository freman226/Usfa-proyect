<?php
// filepath: d:\Programación\Php\Proyecto USFA\tienda-guitarras\src\controllers\save_invoice.php
require_once __DIR__ . '/../includes/db.php';

// asegurar sesión
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $products = $_POST['products'] ?? '';
    $total = $_POST['total'] ?? 0;
    $order_date = date('Y-m-d H:i:s');

    // obtener usuario en sesión si existe
    $user_id = $_SESSION['user_id'] ?? null;
    $user_name = $_SESSION['username'] ?? null;

    if ($products && $total) {
        $stmt = $pdo->prepare("INSERT INTO invoice (products, total, order_date, user_id, user_name) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$products, $total, $order_date, $user_id, $user_name]);
        echo json_encode(['success' => true, 'message' => 'Compra registrada']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
    exit;
}
echo json_encode(['success' => false, 'message' => 'Método no permitido']);
?>