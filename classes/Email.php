<?php 

namespace Classes; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {

    public $email;
    public $nombre;
    public $token; 

    public function __construct($email, $nombre, $token)
    {
       $this->email = $email;  
       $this->nombre = $nombre;  
       $this->token = $token;  
    }

    public function enviarConfirmacion() {
     
     // crear una instancia de phpmailer

            // Configurar SMTP
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'e1eca53ecf1fa1';
            $mail->Password = '7d441b85a63d34';
            $mail->SMTPSecure = 'tls';

            //Habilitar HTML
            $mail->isHTML(true); 
            $mail->CharSet = "UTF-8";

            $mail->setfrom('cuentas@apsalon.com', 'Remitente'); 
            $mail->addAddress('cuenta@appsalon.com', 'Destinatario'); 
            $mail->Subject = 'Confirma tu cuenta'; 

            $contenido ="<html>";
            $contenido .="<p><strong>Hola ". $this->nombre . "</strong>";
            $contenido .=", has creado tu cuenta, para confirmarla ingresa al siguiente enlace</p>";
            $contenido .="<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=". $this->token ."'>Confirmar cuenta</a></p>";
            $contenido .= "<p>Si no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
            $contenido .="</html>";

            $mail->Body = $contenido;

            // ENVIAR EMAIL
            if($mail->send()){
                echo "mensaje enviado correctamente"; 
            } else {
                echo  "El mensaje no se pudo enviar"; 
            }
    }

    public function enviarInstrucciones(){
        // Configurar SMTP
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'e1eca53ecf1fa1';
        $mail->Password = '7d441b85a63d34';
        $mail->SMTPSecure = 'tls';

        //Habilitar HTML
        $mail->isHTML(true); 
        $mail->CharSet = "UTF-8";

        $mail->setfrom('cuentas@apsalon.com', 'Remitente'); 
        $mail->addAddress('cuenta@appsalon.com', 'Destinatario'); 
        $mail->Subject = 'Reestablecer contraseña'; 

        $contenido ="<html>";
        $contenido .="<p><strong>Hola ". $this->nombre . "</strong>";
        $contenido .=", has solicitado reestablecer su contraseña, ingresa al siguiente enlace para hacerlo:</p>";
        $contenido .="<p>Presiona aquí: <a href='http://localhost:3000/recuperar?token=". $this->token ."'>Reestablecer contraseña</a></p>";
        $contenido .= "<p>Si no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .="</html>";

        $mail->Body = $contenido;

        // ENVIAR EMAIL
        if($mail->send()){
            echo "mensaje enviado correctamente"; 
        } else {
            echo  "El mensaje no se pudo enviar"; 
        }
    }
    

}