<?php
require_once __DIR__ . '/../controllers/ProductController.php';

$productos = getProductos();
?>

<div class="container">
    <h1>Nuestra Colección de Guitarras</h1>
    <div class="productos" id="productos">
        <?php foreach ($productos as $producto): ?>
            <div class="producto" data-id="<?php echo (int)$producto['id']; ?>">
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

                <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <button class="edit-btn" title="Editar producto" aria-label="Editar">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true">
                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                        </svg>
                    </button>

                    <button class="delete-btn" title="Eliminar producto" aria-label="Eliminar">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true">
                            <path d="M3 6h18v2H3V6zm2 3h14l-1 11H6L5 9zm5-8h4v2h-4V4z"/>
                        </svg>
                    </button>
                <?php endif; ?>
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

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productDiv = this.closest('.producto');
            const id = productDiv.getAttribute('data-id');
            window.location.href = 'index.php?page=edit_product&id=' + encodeURIComponent(id);
        });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!confirm('¿Eliminar este producto permanentemente?')) return;
            const productDiv = this.closest('.producto');
            const id = productDiv.getAttribute('data-id');
            fetch('delete_product.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    productDiv.style.transition = 'opacity .25s, transform .25s';
                    productDiv.style.opacity = '0';
                    productDiv.style.transform = 'scale(.98)';
                    setTimeout(() => productDiv.remove(), 260);
                } else {
                    alert('Error: ' + (data.message || 'No se pudo eliminar.'));
                }
            })
            .catch(() => alert('Error de red al eliminar.'));
        });
    });
});
</script>

