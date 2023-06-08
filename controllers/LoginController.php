<?php 

namespace Controllers;

use Classes\Email;
use MVC\Router;
use Model\Usuario;

class LoginController{
    public static function login(Router $router) {
        $alertas = []; 

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST); 

            $alertas = $auth -> validarLogin(); 

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email); 

                if($usuario){
                    // verificar contraseña
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        // autenticar al usuario
                        session_start(); 
                        $_SESSION['id'] = $usuario -> id; 
                        $_SESSION['email'] = $usuario -> email; 
                        $_SESSION['login'] = true; 
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido; 

                        // redireccionamiento según el tipo de usuario
                            if ($usuario->admin === "1") {
                                $_SESSION['admin'] = $usuario->admin ?? null; 
                                header('location: /admin');
                            } else {
                                header('location: /cita');
                            }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado'); 
                }
            } 

        }

        $alertas=Usuario::getAlertas(); 
        $router->render('auth/login', [
            'alertas' => $alertas
        ]); 
    }

    public static function logout() {
       session_start();
       
       $_SESSION = []; 

       header('location:/');
    }

    public static function olvide(Router $router) {

        $alertas = [];
       

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail(); 

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === "1") {
                    // generar token 

                    $usuario->crearToken(); 
                    $usuario->guardar(); 

                    // ENVIAR CORREO CON TOKEN
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token); 
                    $email->enviarInstrucciones(); 

                    Usuario::setAlerta('exito', 'Se enviaron las instrucciones a tu correo electrónico');

                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no está confirmado');
                    
                }
            }
           
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/olivide-password', [
            'alertas' => $alertas
        ]); 
    }


// -------  RECUPERAR CONTRASEÑA -----------

    public static function recuperar(Router $router) {
        $alertas = []; 
        $error = false;

        $token = s($_GET['token']);

       // buscar usuario por su token
       $usuario = Usuario::where('token', $token);

       if(empty($usuario)){
            Usuario::setAlerta('error', 'Token de recuperación no válido'); 
            $error=true; 
       }

       if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // leer la nueva contraseña y guardarla
        $password = new Usuario($_POST); 
        $alertas = $password ->validarContraseña(); 

        if(empty($alertas)){

            $usuario -> password = null; 
            $usuario->password = $password ->password;
            $usuario->hashPassword(); 
            $usuario->token = null; 
    
            $resultado = $usuario->guardar(); 
            if($resultado){
                // mensaje exito:
                Usuario::setAlerta('exito', 'Contraseña restablecida correctamente');

                //redireccionar: 
                header('Refresh: 3; url=/');
            }
       }

       

       }
       
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]); 
    }

// ---------- CREAR CUENTA -----------------

    public static function crear(Router $router) {

        $usuario = new Usuario;

        //Alertas vacías
        $alertas= []; 

        
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST); // Permite conservar los datos ingresados en la vista del formulario cuando se diligencia, debe crearse el "value" en el formulario y crearse la variable usuario con antes del request method

            $alertas = $usuario -> validarNuevaCuenta();

            // Revisar que alerta esté vacío
            if(empty($alertas)){
                // Ya verificaron los datos ingresafos, ahora verificar que el email no esté registrado en la BD
                $resultado = $usuario -> existeUsuario(); 
                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                }else {
                    // hashear la contraseña
                    $usuario->hashPassword(); 

                    // generar un token único
                    $usuario->crearToken();

                    // Enviar un email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    
                    $email->enviarConfirmacion(); 

                    // crear el usuario
                    $resultado = $usuario->guardar(); 

                    if($resultado) {
                        header('location: /mensaje');
                    }
               
                }
            }
            
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas'=> $alertas
        ]); 
    }

    public static function confirmar (Router $router) {

        $alertas = []; 
        $token = s($_GET['token']); 

        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // mostrar mensaje error
            Usuario::setAlerta('error', 'Token no válido'); 

        } else {
            // Modificar estado de confirmado en BD 
            $usuario->confirmado = "1"; 
            $usuario->token = null; 
            
            $usuario->guardar(); 
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
            
            
        }

        
        $alertas = Usuario::getAlertas();
        $router -> render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ] );
        
    }

    public static function mensaje (Router $router) {
        $router -> render ('auth/mensaje'); 
    }
}