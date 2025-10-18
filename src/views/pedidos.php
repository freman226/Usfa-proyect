<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

$invoices = $pdo->query("
    SELECT i.*, u.username AS username_from_users
    FROM invoice i
    LEFT JOIN users u ON u.id = i.user_id
    ORDER BY i.order_date DESC
")->fetchAll();
?>

<div class="pedidos-container">
    <h1>Pedidos realizados</h1>
    <?php if (empty($invoices)): ?>
        <p>No hay pedidos registrados.</p>
    <?php else: ?>
        <?php foreach ($invoices as $invoice): ?>
            <?php
                $who = $invoice['username_from_users'] ?? $invoice['user_name'] ?? 'Anónimo';
            ?>
            <div class="pedido">
                <h3>Pedido de <?php echo htmlspecialchars($who); ?> — <?php echo htmlspecialchars($invoice['order_date']); ?> (Total: $<?php echo htmlspecialchars($invoice['total']); ?>)</h3>
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