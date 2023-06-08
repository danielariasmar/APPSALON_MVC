<?php 

namespace Controllers;

use Model\servicio;
use Model\Cita;
use Model\CitaServicio;

class APIController {
    public static function index(){
        $servicios = Servicio::all(); 
        echo json_encode($servicios);
    }

    public static function guardar(){

        // guarda la cita en tabla citas (modelo citas) y devuelve el id del servicio
       $cita = new Cita($_POST);
       $resultado = $cita->guardar(); 
        $id = $resultado['id']; 


       // almacena la cita y el servicio
       $idServicios = explode(",",$_POST['servicios'] ); // convierte la respuesta en un arreglo, cada ID seperado

        foreach($idServicios as $idServicio){
            $args = [
                'citaId' => $id, 
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args); 
            exit();
            $citaServicio -> guardar();
        }

       $respuesta = [
        'resultado' =>  $resultado  // servicios ya está en el app js 
       ];

        echo json_encode($respuesta);
    }

    public static function eliminar (){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('location:'.$_SERVER['HTTP_REFERER']);
        }
    }
}