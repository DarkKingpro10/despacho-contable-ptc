<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libraries/PHPMailer/src/Exception.php';
require 'libraries/PHPMailer/src/PHPMailer.php';
require 'libraries/PHPMailer/src/SMTP.php';

// Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
session_start();

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$result = array('message' => null, 'exception' => null, 'status' => null);


//Declaramos algunas variables
$cliente =  $_SESSION['nombreUsuario'].''. $_SESSION['apellidoUsuario'];
$usuario = $_SESSION['usuario'];
$pin = $_SESSION['PIN'];
$correo = $_POST['correo'];
$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">




<head>
<!--Import Google Icon Font-->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<!--Import materialize.css-->
<!-- Compiled and minified CSS -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8" />
<title>Smart Bookkeeping-Codigo de restablecer contraseña</title>
<style>
*{
    margin: 0;
    padding: 0;
}
body{
    background-color: white;/*cambiar a predeterminado(blanco)*/
}
.fondo-0{
    padding: 20px;
    background-color: #dee8f1;
    text-align: center;
    /*margin: 100px;*//*borrar linea*/
}
.fondo {
    padding: 40px;
    background-color: #F1F5F9;
    text-align: center;
    box-shadow: 3px 3px 4px 2px rgb(138, 136, 136);
}
.encabezado{
    width: 100%;
    height: 100px;
    background-color: #F4A172;
    text-align: center;
    border-radius: 5px;
    font-family: '.'Poppins'.', sans-serif;
    padding-top: 10px;
}
.card-panel {
    background-color: #FA7479;
    width: 300px;
    height: 60px;
    border-radius: 10px;
    margin-top: 30px;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
}
.card-panel h1{
    text-align: center;
    padding-top: 20px;
    font-family: '.'Poppins'.', sans-serif;
}
.container h1{
    padding-top: 10px;
    font-family: '.'Poppins'.', sans-serif;
}
.container p{
    margin-top: 20px;
    font-family: '.'Poppins'.', sans-serif;
}
.fila1 {
    margin-left: 0%;
    margin-top: 1%;
}
@media screen and (min-width: 200px) and (max-width: 433px)  {
    .encabezado{
    width: 100%;
    height: 40%;
    background-color: #F4A172;
    text-align: center;
    border-radius: 5px;
    font-family: '.'Poppins'.', sans-serif;
    padding-top: 10px;
}
.card-panel {
    background-color: #FA7479;
    width: 180px;
    height: 60px;
    border-radius: 10px;
    margin-top: 30px;
    margin-left: auto;
    margin-right: auto;
}
}
</style>
</head>
<body class=" grey lighten-3" style="margin: 0; padding:0;">
<div class="fondo-0">
    <div class="edge">
        <div class="fondo">
            <div class="encabezado">
                <nav class="orange darken-4 center">
                    <div class="nav-wrapper">
                        <h1 style="margin: 0; font-size: 55px;">Smart Book</h1>
                    </div>
                </nav>
            </div>
        <div class="container">
            <h1 class="center-align">Recuperar contraseña</h1>
            <p>En Smart Bookkeeping nos preocupamos por ti, a continuación veras un codigo de 6 digitos que deberás de colocar en el formulario de tu pantalla <b>'.$cliente.'</b>, no
                olvides que este solo dura 1h y es distinto conforme tu continues generando más codigos <b>¡Apresurate '.$usuario.' ! codigo: </b></p>
                <div class="fila1">
                <div class="card-panel orange darken-4 white-text">
                    <h1>'.$pin.'</h1>
                </div>
            </div>
        </div>
    </div>  
    </div>
</div>    
    <!--JavaScript al final para optimizar-->
    <!-- Compiled and minified JavaScript -->
</body>
</html>';

$mensaje = wordwrap($body, 70, "\r\n");

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'despcontableesquivel@gmail.com';                     //SMTP username
    $mail->Password   = 'uzviadjrgvklbecp';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('despcontableesquivel@gmail.com', 'Smart Bookeeping');
    $mail->addAddress($correo, $cliente);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Código para restablecer contraseña';
    $mail->Body    = $mensaje;
    $mail->AltBody = 'Código para restablecer la contraseña: '.$pin;
    $mail->CharSet  = 'utf-8';
    $mail->send();
    $result['status'] = 1;
    $result['message'] = 'Mensaje enviado correctamente';
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result)); 
} catch (Exception $e) {
    $result['exception'] = $mail->ErrorInfo . ' ' . $correo;
    print(json_encode($result)); 
}
?>
