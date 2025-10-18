<?php
require_once __DIR__ . '/../includes/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo "<script>alert('ID inválido'); window.location.href='index.php?page=productos';</script>";
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "<script>alert('Producto no encontrado'); window.location.href='index.php?page=productos';</script>";
    exit;
}
?>

<div class="create-product-container">
    <h1>Editar Producto</h1>

    <form method="POST" action="/edit_product.php" enctype="multipart/form-data" class="create-product-form">
        <input type="hidden" name="id" value="<?php echo (int)$product['id']; ?>">

        <label for="name">Nombre</label>
        <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($product['name']); ?>">

        <label for="price">Precio (USD)</label>
        <input type="number" id="price" name="price" step="0.01" min="0" required value="<?php echo htmlspecialchars($product['price']); ?>">

        <label for="description">Descripción</label>
        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label>Imagen actual</label>
        <div style="margin-bottom:12px;">
            <img src="/img/<?php echo htmlspecialchars($product['image']); ?>" alt="" style="max-width:120px; border-radius:6px;">
        </div>

        <label for="image">Cambiar imagen (opcional)</label>
        <input type="file" id="image" name="image" accept="image/*">

        <button type="submit" class="create-product-btn">Guardar cambios</button>
        <a href="index.php?page=productos" style="margin-left:12px;">Cancelar</a>
    </form>
</div>