<?php
?>

<div class="contacto">
    <h1>Contacto</h1>
    <p>Si tienes alguna pregunta o necesitas más información, no dudes en contactarnos.</p>
    <form action="enviar_contacto.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje" name="mensaje" required></textarea>

        <button type="submit">Enviar</button>
    </form>
</div>

<?php
?>