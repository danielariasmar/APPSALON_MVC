<h1 class="nombre-pagina">Nuevo Servicio</h1>
<p class="descripcion-pagina">Llena los campos para agregar un nuevo servicio</p>

<div class="barra-servicios">
        <a class="boton" href="/admin">Atras</a>
 </div>

<?php 

    // include_once __DIR__ .'/../templates/barra.php'
    include_once __DIR__ .'/../templates/alertas.php'

?>


<form action="/servicios/crear" method="POST" class="formualrio">

    <?php include_once __DIR__.'/formulario.php'; ?>
    

    <input type="submit" class="boton" value="Guardar servicio">

</form>