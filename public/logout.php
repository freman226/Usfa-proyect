<?php
session_start();

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

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
    window.location.href = 'index.php?page=login';
</script>
</body>
</html>