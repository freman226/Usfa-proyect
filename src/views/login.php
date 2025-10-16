<div class="login-container">
    <h1>Iniciar Sesión</h1>
    <form method="POST" action="login.php" class="login-form">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" required autocomplete="username">

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required autocomplete="current-password">

        <button type="submit" class="login-btn">Ingresar</button>
    </form>
    <p class="login-register-msg">
        ¿No tienes una cuenta? Regístrate <a href="index.php?page=register">aquí</a>
    </p>
</div>