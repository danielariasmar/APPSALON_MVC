<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php include_once __DIR__."/../templates/alertas.php" ?>

<form action="/" class="formulario" method="POST">

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="Correo" id="email" name="email">
    </div>

    <div class="campo">
        <label for="Contraseña">password</label>
        <input type="password" placeholder="Ingresa tu contraseña" id="password" name="password">
    </div>

    <input type="submit" class="boton" value="Iniciar sesión">

</form>

<div class="acciones"> 
    <a href="/crear-cuenta">Crear cuenta</a>
    <a href="/olvide">Recuperar contraseña</a>
</div>
