<?php
// Este archivo representa la vista de la página de productos, donde se listan todas las guitarras disponibles para la venta.
require_once __DIR__ . '/../controllers/ProductController.php';

$productos = getProductos();
?>

<div class="container">
    <h1>Nuestra Colección de Guitarras</h1>
    <div class="productos" id="productos">
        <?php foreach ($productos as $producto): ?>
            <div class="producto">
                <img src="/img/<?php echo htmlspecialchars($producto['image']); ?>" alt="<?php echo htmlspecialchars($producto['name']); ?>">
                <div class="info">
                    <h2><?php echo htmlspecialchars($producto['name']); ?></h2>
                    <p><?php echo htmlspecialchars($producto['description']); ?></p>
                    <p><strong>Precio: $<?php echo htmlspecialchars($producto['price']); ?></strong></p>
                    <form method="POST" action="/product_endpoint.php">
                        <input type="hidden" name="name" value="<?php echo htmlspecialchars($producto['name']); ?>">
                        <input type="hidden" name="description" value="<?php echo htmlspecialchars($producto['description']); ?>">
                        <input type="hidden" name="price" value="<?php echo htmlspecialchars($producto['price']); ?>">
                        <button type="submit" class="add-cart-btn">Añadir al carrito</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.add-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productoDiv = this.closest('.producto');
            const name = productoDiv.querySelector('h2').textContent;
            const price = productoDiv.querySelector('strong').textContent.replace('Precio: $', '').trim();
            const image = productoDiv.querySelector('img').getAttribute('src');
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const index = cart.findIndex(item => item.name === name);
            if (index > -1) {
                cart[index].quantity += 1;
            } else {
                cart.push({ name, price, image, quantity: 1 });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            alert('Producto añadido al carrito');
        });
    });
});
</script>

