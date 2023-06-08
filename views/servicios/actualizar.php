<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Modifica los valores del formulario</p>

<div class="barra-servicios">
        <a class="boton" href="/servicios">Atras</a>
 </div>

 <?php 

    // include_once __DIR__ .'/../templates/barra.php'
    include_once __DIR__ .'/../templates/alertas.php'

?>


<form method="POST" class="formualrio">

    <?php include_once __DIR__.'/formulario.php'; ?>
    

    <input type="submit" class="boton" value="Actualizar">

</form>