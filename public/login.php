<?php
// filepath: d:\Programación\Php\Proyecto USFA\tienda-guitarras\public\login.php
session_start();
require_once '../src/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Aquí guardas los datos en la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            echo "<script>
                window.location.href = 'index.php?page=productos';
            </script>";
            exit;
        } else {
            echo "<script>
                alert('Correo o contraseña incorrectos.');
                window.location.href = 'index.php?page=login';
            </script>";
            exit;
        }
    }
}
?>