<?php
require_once __DIR__ . '/../includes/db.php';

// if (!isset($_SESSION['user_id'])) {
//     header('Location: index.php?page=login');
//     exit;
// }

require_once __DIR__ . '/../includes/header.php';

$invoices = $pdo->query('SELECT * FROM invoice ORDER BY order_date DESC')->fetchAll();
?>

<div class="pedidos-container">
    <h1>Pedidos realizados</h1>
    <?php if (empty($invoices)): ?>
        <p>No hay pedidos registrados.</p>
    <?php else: ?>
        <?php foreach ($invoices as $invoice): ?>
            <div class="pedido">
                <h3>Pedido del <?php echo htmlspecialchars($invoice['order_date']); ?> (Total: $<?php echo htmlspecialchars($invoice['total']); ?>)</h3>
                <ul>
                    <?php
                    $productos = json_decode($invoice['products'], true);
                    foreach ($productos as $producto):
                    ?>
                        <li>
                            <strong><?php echo htmlspecialchars($producto['name']); ?></strong>
                            - Precio unitario: $<?php echo htmlspecialchars($producto['price']); ?>
                            - Cantidad: <?php echo htmlspecialchars($producto['quantity']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>