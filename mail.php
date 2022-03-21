<?php
use PHPMailer\PHPMailer\PHPMailer;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = 'erick1rg@gmail.com'; // YOUR gmail email
    $mail->Password = 'Erda-1022'; // YOUR gmail password

    // Sender and recipient settings
    $mail->setFrom('erick1rg@gmail.com', 'Foro Assist');
    $mail->addAddress('mandres.rang@gmail.com', 'Receiver Name');
    $mail->addReplyTo('erick1rg@gmail.com', 'Sender Name'); // to set the reply to

    // Setting the email content
    $mail->IsHTML(true);
    $mail->Subject = "Bienvenido a la Comunidad Assist!";
    $mail->Body = '<h1>¡Bienvenido a la Comunidad Assist!</h1>Tu registro ha sido Exitoso! <br/><br/> Te damos la bienvenida al foro <b>Assist</b>.';
    $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

    $mail->send();
    echo "Email message sent.";
} catch (Exception $e) {
    echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
}
