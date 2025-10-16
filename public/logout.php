<?php
// Cerrar sesión en servidor
session_start();

// Vaciar variables de sesión
$_SESSION = [];

// Eliminar cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir sesión
session_destroy();

// Responder con JS que limpia localStorage y redirige al login
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Salir</title>
</head>
<body>
<script>
    try { localStorage.removeItem('cart'); } catch(e) {}
    // Redirigir a la vista de login (ajusta la URL si tu enrutado es distinto)
    window.location.href = 'index.php?page=login';
</script>
</body>
</html>