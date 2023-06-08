<h1 class="nombre-pagina">Recuperar password</h1>
<p class="descripcion-pagina"> Ingresa tu nueva contraseña a continuación</p>

<?php include_once __DIR__."/../templates/alertas.php" ?>

<?php if ($error) return; ?>
<form class="formulario" method="POST">
<div class="campo">
    <input type="password" id="password" name="password" placeholder="Nueva contraseña">
</div>

<input type="submit" class="boton" value="Guardar nueva contraseña">

</form>

<div class="acciones"> 
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">Crear cuenta</a>
</div>