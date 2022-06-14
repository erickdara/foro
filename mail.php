<?php
use PHPMailer\PHPMailer\PHPMailer;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

 class Mail{


    public function sendMail($mail, $username){
        try {
            $sendMail = new PHPMailer();
            // Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
            $sendMail->isSMTP();

            $sendMail-> SMTP::DEBUG_SERVER;
            $sendMail->Host = 'smtp.gmail.com';
            $sendMail->SMTPAuth = true;
            $sendMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $sendMail->Port = 587;
        
            $sendMail->Username = 'erick1rg@gmail.com'; // YOUR gmail email
            $sendMail->Password = 'mmarviwzyrdpyuim'; // YOUR gmail password
        
            // Sender and recipient settings
            $sendMail->setFrom('erick1rg@gmail.com', 'Foro Assist');
            $sendMail->addAddress($mail, 'Receiver Name');
            $sendMail->addReplyTo('erick1rg@gmail.com', 'Sender Name'); // to set the reply to

            $message  = "<html><body>";

            $message .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";
            
            $message .= "<tr><td>";
            
            $message .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";
                
            $message .= "<thead>
                <tr height='100'>
                <th colspan='4' style='background-color:#071a39; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#ff323b; font-size:34px; padding:10px;' >¡Bienvenido a la Comunidad Assist $username!
                </tr>
                </thead>";
                
            $message .= "<tbody>                        
                <tr>
                <td colspan='4' style='padding:15px;'>
                    <p style='font-size:20px;'>Hola ".$username.",</p>
                    <hr />
                    <p style='font-size:15px; font-family:Verdana, Geneva, sans-serif;'> Tu registro en el foro de Assist ha sido exitoso!</p>
                </td>
                </tr>
                
                <tr height='80'>
                <td colspan='4' align='center' style='background-color:#ffff; border-top:dashed #071a39 2px; font-size:24px; '>
                </td>
                </tr>
                
                </tbody>";
                
            $message .= "</table>";
            
            $message .= "</td></tr>";
            $message .= "</table>";
            
            $message .= "</body></html>";
        
            // Setting the email content
            $sendMail->IsHTML(true);
            $sendMail->Subject = "Bienvenido a la Comunidad Assist ".$username."!";
            $sendMail-> Body = $message;
           // '<div style = \"background-color:rgb(7, 26, 57); color:rgb(255 50 59); text-align:center;\"><h1>¡Bienvenido a la Comunidad Assist!</h1></div>Tu registro ha sido Exitoso! <br/><br/> '.$username.' te damos la bienvenida al foro <b>Assist</b>.';
            $sendMail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';
        
            $sendMail->send();
            return true;
            
        } catch (Exception $e) {
            return "Error in sending email. Mailer Error: {$sendMail->ErrorInfo}";
            return false;
        }
    }
}


// // passing true in constructor enables exceptions in PHPMailer
// $mail = new PHPMailer(true);

// try {
//     // Server settings
//     //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
//     $mail->isSMTP();
//     $mail->Host = 'smtp.gmail.com';
//     $mail->SMTPAuth = true;
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//     $mail->Port = 587;

//     $mail->Username = 'erick1rg@gmail.com'; // YOUR gmail email
//     $mail->Password = 'Erda-1022'; // YOUR gmail password

//     // Sender and recipient settings
//     $mail->setFrom('erick1rg@gmail.com', 'Foro Assist');
//     $mail->addAddress('mandres.rang@gmail.com', 'Receiver Name');
//     $mail->addReplyTo('erick1rg@gmail.com', 'Sender Name'); // to set the reply to

//     // Setting the email content
//     $mail->IsHTML(true);
//     $mail->Subject = "Bienvenido a la Comunidad Assist!";
//     $mail->Body = '<div style = \"background-color:rgb(7, 26, 57); color:rgb(255 50 59); text-align:center;\"><h1>¡Bienvenido a la Comunidad Assist!</h1></div>Tu registro ha sido Exitoso! <br/><br/> Te damos la bienvenida al foro <b>Assist</b>.';
//     $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

//     $mail->send();
//     echo "Email message sent.";
// } catch (Exception $e) {
//     echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
// }
