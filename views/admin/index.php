<h1 class="nombre-pagina">Panel de administración</h1>

<?php include_once __DIR__.'/../templates/barra.php' ?>

<h2>Buscar citas</h2>
<div class="busqueda">
    <form class="formulario" action="">

        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value= "<?php echo $fecha; ?>" >
        </div>

    </form>
</div>

<?php 

    if(count($citas) === 0){
        echo "<P>No hay citas agendadas en el día seleccionado</P>";
    }
?>



<div id="citas-admin"> 
    <ul class="citas">
     <?php
        $idCita = ''; // asignar valor inicial de id Cita para que no de undefined. Este valor se le asigna al terminar cada iteración. 
        foreach($citas as $key => $cita) {  // key es para asignar valor a cada ID
           
            if($idCita !== $cita->id){  
                $total = 0; // crea variable en total e inicia en cero
    ?>
            <li>
            <p>ID: <span><?php echo $cita->id ?></span></p>
            <p>hora: <span><?php echo $cita->hora ?></span></p>
            <p>cliente: <span><?php echo $cita->cliente ?></span></p>
            <p>Email: <span><?php echo $cita->email ?></span></p>
            <h3>Servicios</h3>  
            <?php 
                $idCita = $cita->id; // asigna valor a idCita para así validar que no sea el mismo, ya que así tendría el último ID
                } //fin de if 

                $total += $cita ->precio; // suma el precio por cada iteración
            ?>
             
            <p class="servicio"><?php echo $cita->servicio . " " . $cita->precio;?></p>
            <?php 
                $actual = $cita -> id; 
                $proximo = $citas[$key + 1] -> id ?? 0; // detecta cual es el último registro con el mismo ID

                if(esUltimo($actual, $proximo)){ ?>
                    <p class="total">TOTAL: <span>$<?php echo $total;?></span></p>

                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" id="id" value="<?php echo $cita->id; ?>" >
                        <input type="submit" class="boton-eliminar" value="eliminar">
                    </form>

            <?php  }       ?>
    <?php } // fin de foreach ?>
    </ul>

   

</div>

<?php 

$script = "<script src='build/js/buscador.js'></script>";
?>