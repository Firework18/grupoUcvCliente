<?php
session_start(); // Asegúrate de que la sesión se inicie al principio

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_POST['enviar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'adelcarpiobravo@gmail.com'; // Tu dirección de correo Gmail
        $mail->Password = 'lngk bcsl xnkw ltur'; // Tu contraseña de Gmail o App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinatarios
        $mail->setFrom('adelcarpiobravo@gmail.com', 'Administrador');
        $mail->addAddress('adelcarpiobravo@gmail.com', $nombre); // Puedes agregar destinatarios dinámicamente aquí

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = "Nombre: $nombre<br>Correo: $correo<br>Mensaje: $mensaje";
        $mail->AltBody = "Nombre: $nombre\nCorreo: $correo\nMensaje: $mensaje";

        $mail->send();
        $_SESSION['message'] = 'El mensaje ha sido enviado con éxito';
        $_SESSION['msg_type'] = 'success';
    } catch (Exception $e) {
        $_SESSION['message'] = "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
        $_SESSION['msg_type'] = 'danger';
    }

    header('Location: contact.php');
    exit();
}
?>
