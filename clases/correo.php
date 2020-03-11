
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class Correo{ 
    private $correo;
    private $nombreUsuario;
    private $asunto="Creacion usuario avisosHN";
    private $mensajeEncabezado="<br>Bienvenido a AvisosHN la mejor plataforma de Anuncios de Honduras<br>";
    

    public function __construct($correo,$nombreUsuario){
        $this->correo=$correo;
        $this->nombreUsuario=$nombreUsuario;
        
            
    }

    public function enviarCorreo(){
        $mail = new PHPMailer(true);
        try {
        //Server settings
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'serprehn@gmail.com';                     // SMTP username
            $mail->Password   = 'Serprehn20';                               // SMTP password
            $mail->SMTPSecure = "tls";         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            

            //Recipients
            $mail->setFrom('serprehn@gmail.com', 'SerpreHN');
            $mail->addAddress($this->correo, $this->nombreUsuario);     // Add a recipient
            
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->asunto;
            $mail->Body    = "Estimado: ".$this->nombreUsuario.$this->mensajeEncabezado;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            

        } catch (Exception $e) {
            
            echo "ERRROR:". $e;
            
            
        }

    }

}

        
    







