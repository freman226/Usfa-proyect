<?php

?>

<div class="create-product-container">
    <h1>Crear Producto</h1>

    <form method="POST" action="/create_product.php" enctype="multipart/form-data" class="create-product-form">
        <label for="name">Nombre</label>
        <input type="text" id="name" name="name" required>

        <label for="price">Precio (USD)</label>
        <input type="number" id="price" name="price" step="0.01" min="0" required>

        <label for="description">Descripción</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="image">Imagen (archivo opcional)</label>
        <input type="file" id="image" name="image" accept="image/*">

        <button type="submit" class="create-product-btn">Crear producto</button>
    </form>
</div>