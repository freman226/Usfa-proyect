<?php
?>

<div class="register-container">
    <h1>Registro de Usuario</h1>
    <form method="POST" action="register.php" class="register-form">
        <label for="username">Usuario</label>
        <input type="text" id="username" name="username" required autocomplete="username">

        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required autocomplete="email">

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required autocomplete="new-password">

        <label for="fullname">Nombre Completo</label>
        <input type="text" id="fullname" name="fullname" required>

        <label for="address">Dirección</label>
        <input type="text" id="address" name="address" required>

        <button type="submit" class="register-btn">Registrarse</button>
    </form>
    <p class="register-login-msg">
        ¿Ya tienes una cuenta? Inicia sesión <a href="index.php?page=login">aquí</a>
    </p>
</div>