<?php
// Include config file
require_once "config.php";

ob_start();

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);

// Define variables and initialize with empty values
$usuCorreo = $usuPassword = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST['mail']))) {
        $username_err = "Please enter user mail.";
    } else {
        $usuCorreo = trim($_POST['mail']);
    }

    // Check if password is empty
    if (empty(trim($_POST['password']))) {
        $password_err = "Please enter your password.";
    } else {
        $usuPassword = trim($_POST['password']);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT idUser, idRole, userMail, userPassword FROM user WHERE userMail = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $usuCorreo;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {

                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $idUsuario, $idRol, $usuCorreo, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {

                        if (password_verify($usuPassword, $hashed_password)) {

                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $idUsuario;
                            $_SESSION['rol'] = $idRol;
                            $_SESSION['mail'] = $usuCorreo;

                            $mail = $_POST['mail'];

                            $response = array('mail' => $mail);

                            // header("location: ./User/index.php");
                            echo json_encode($response);

                            

                            exit;
                            // error_reporting(E_ALL | E_WARNING | E_NOTICE);
                            // ini_set('display_errors', TRUE);
                            // // Redirect user to welcome page
                            // $host  = $_SERVER['HTTP_HOST'];
                            // $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                            // $extra = 'User/index.php';
                            // header("Location: http://$host$uri/$extra");

                            // flush();
                            // header("Location: User/index.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                            echo json_encode($login_err);
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                    echo json_encode($login_err);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
                echo json_encode("Oops! Something went wrong. Please try again later.");
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
