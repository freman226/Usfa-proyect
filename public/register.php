<?php
require_once '../src/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $fullname = trim($_POST['fullname'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($username && $email && $password && $fullname && $address) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, fullname, address) VALUES (?, ?, ?, ?, ?)");
        try {
            $stmt->execute([$username, $email, $hashedPassword, $fullname, $address]);
            echo "<script>
        alert('¡Usuario registrado exitosamente!');
        window.location.href = 'index.php?page=login';
    </script>";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                echo "<div class='register-error'>El usuario o correo ya existe.</div>";
            } else {
                echo "<div class='register-error'>Error al registrar usuario.</div>";
            }
        }
    } else {
        echo "<div class='register-error'>Todos los campos son obligatorios.</div>";
    }
}
?>