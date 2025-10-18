<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Guitarras</title>
    <link rel="stylesheet" href="/css/styles.css">
    <script type="module" src="/js/main.js"></script>
</head>
<body>
    <header>
        <div class="header-content">
            <div id="title" class="title">
                <h1>Tienda de Guitarras</h1>
            </div>
            <button class="cart-btn" id="cart-btn">
                <img src="/img/carrito.png" alt="Carrito" />
            </button>

            <?php if (isset($_SESSION['username'])): ?>
            <span class="user-area">
                <span class="user-icon">
                    <img src="/img/user.png" alt="Usuario" />
                    <div class="user-menu">
                        <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="index.php?page=pedidos">Pedidos</a>
                            <a href="index.php?page=create_product">Crear producto</a>
                        <?php endif; ?>
                        <a href="/logout.php">Cerrar Sesión</a>
                    </div>
                </span>
                <span class="username-header"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </span>
            <?php endif; ?>
        </div>
    </header>