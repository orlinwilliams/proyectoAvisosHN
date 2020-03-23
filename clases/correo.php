
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

class Correo{ 
    private $correo;
    private $nombreUsuario;
    private $asunto;
    private $mensaje;
    private $mensajeEncabezado="<br><br><p color='blue'>AvisosHN la mejor plataforma de Anuncios de Honduras.</p><br>";
    

    public function __construct($correo,$nombreUsuario,$asunto,$mensaje){
        $this->correo=$correo;
        $this->nombreUsuario=$nombreUsuario;
        $this->asunto=$asunto;
        $this->mensaje=$mensaje;
        
            
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
            $mail->setFrom('serprehn@gmail.com', 'AvisosHN');
            $mail->addAddress($this->correo, $this->nombreUsuario);     // Add a recipient
            
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->asunto;
            $mail->Body    = "Estimado: ".$this->nombreUsuario."<br>".$this->mensaje.$this->mensajeEncabezado;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if($mail->send()){
                return true;
            }
            
            

        } catch (Exception $e) {
            
            return false;
            
            
        }

    }

}

        
    







