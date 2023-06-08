<h1 class="nombre-pagina">Reestablecer contraseña</h1>
<p class="descripcion-pagina">Restablece tu password escribiendo tu email a continuación:</p>

<?php include_once __DIR__."/../templates/alertas.php" ?>

<form class="formulario" action="/olvide" method="POST">

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="Tu email" name="email" id="email">
    </div>

    <input type="submit" class="boton" value="Enviar instrucciones">

</form>

<div class="acciones"> 
    <a href="/crear-cuenta">Crear cuenta</a>
</div>