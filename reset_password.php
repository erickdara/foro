<?php 
include('config.php');
use PHPMailer\PHPMailer\PHPMailer;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

session_start();
$errors = [];

/*
Accept email of user whose password is to be reset
Send email to user to reset their password
*/

if(isset($_POST['reset-password'])){
    $email = mysqli_real_escape_string($link, $_POST['email']);
    //ensure that the user exists on our system
    $query = "SELECT usuCorreo FROM usuario where usuCorreo='$email'";
    $results = mysqli_query($link, $query);

    if(empty($email)){
        array_push($errors, "Su correo es requerido");
    }else if(mysqli_num_rows($results) <= 0){
        array_push($errors, "Lo sentimos usuario no existe en nuestro sistema con ese correo" );
    }

    //generate a unique random token of length 100
    $token = bin2hex(random_bytes(50));

    if(count($errors) == 0){
        //Store token in the password-reset database table against the user's email
        $sql = "INSERT INTO password_reset(email, token) VALUES ('$email','$token')";
        $results = mysqli_query($link, $sql);

    $link="<a href=\"localhost/foro/new_password.php?token=" . $token . "\">link</a> restablecer conraseña en nuestro sitio";
   

    $mail = new PHPMailer();
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    // enable SMTP authentication
    $mail->SMTPAuth = true;                  
    // GMAIL username
    $mail->Username = "erick1rg@gmail.com";
    // GMAIL password
    $mail->Password = "Erda-1022";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    // sets GMAIL as the SMTP server
    $mail->Host = "smtp.gmail.com";
    // set the SMTP port for the GMAIL server
    $mail->Port = "587";
    $mail->From='your_gmail_id@gmail.com';
    $mail->FromName='Foro ASSIST';
    $mail->AddAddress($email, 'reciever_name');
    $mail->Subject  =  'Restablecer Contraseña';
    $mail->IsHTML(true);
    $mail->Body    = 'Has Click en este link para restablecer contraseña '.$link.'';
    if($mail->Send())
    {
      echo "Check Your Email and Click on the link sent to your email";
    }
    else
    {
      echo "Mail Error - >".$mail->ErrorInfo;
    }
  }
}

    // ENTER A NEW PASSWORD
if (isset($_POST['new_password'])) {
    $new_pass = mysqli_real_escape_string($link, $_POST['new_pass']);
    $new_pass_c = mysqli_real_escape_string($link, $_POST['new_pass_c']);
    
    // Grab to token that came from the email link
    $token = $_SESSION['token'];
    var_dump($token);

    if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");
    if ($new_pass !== $new_pass_c) array_push($errors, "Password do not match");
    echo "Valido si hay datos en errors: ";
    var_dump(count($errors));
    if (count($errors) == 0) {
        echo ("entro a consultar token por email: ");
      // select email address of user from the password_reset table 
      $sql = "SELECT email FROM password_reset WHERE token='$token' LIMIT 1";
      $results = mysqli_query($link, $sql);
      echo nl2br('result token query');
      var_dump($results);
      $email = mysqli_fetch_assoc($results)['email'];
      echo nl2br('result email');
      var_dump($email);
  
      if ($email) {
        $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);  
        //$new_pass = md5($new_pass);
        $sql = "UPDATE usuario SET usuPassword='$new_pass' WHERE usuCorreo='$email'";
        $results = mysqli_query($link, $sql);
        echo nl2br('result update query');
        var_dump($results);
        if($results){
            $queryToken = "UPDATE password_reset SET token=NULL WHERE email='$email' ORDER by id DESC LIMIT 1";
            $results = mysqli_query($link, $queryToken);
            echo nl2br('result update TOKEN query');
        }
        header('location: /foro/index.php');
      }
    }
  }

?>