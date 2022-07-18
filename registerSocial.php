
<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(32767);

require_once 'config.php';


class RegisterSocial{

    
    public static function isLogin()
    {
        
        return (bool) isset($_SESSION['id']);
    }

    private $host  = 'localhost';
    private $user  = 'root';
    private $password   = '';
    private $database  = 'forumdatabase';
    private $dbConnect = false;

    public function __construct()
    {
        if (!$this->dbConnect) {
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if ($conn->connect_error) {
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            } else {
                $this->dbConnect = $conn;
            }
        }
    }

    public function getExistingUser($socialUser)
    {
        $query = "SELECT idUser, usernames, userMail FROM user WHERE userMail = '$socialUser'";
        $result = mysqli_query($this->dbConnect, $query);

        return $result->num_rows;
    }

    public function loginUser($data, $provider){
        $conn = mysqli_connect("localhost", "root", "", "forumdatabase");
            if (mysqli_connect_errno()) {
                printf("Falló la conexión: %s\n", mysqli_connect_error());
            }

            $mail = $data['email'];

            $query = mysqli_query($conn,"SELECT idUser, idRole, userMail, userImage FROM user WHERE userMail = '$mail'");
            $result = mysqli_fetch_array($query);

            $idUsuario = $result['idUser'];
            $idRol = $result['idRole'];
            $userMail = $result['userMail'];

                    session_start();

                    // Store data in session variables
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $idUsuario;
                    $_SESSION['rol'] = $idRol;
                    $_SESSION['mail'] = $userMail;

                    /* cerrar la conexión */
                    $conn->close();
                    //TODO: si no hace el redirect retornar un bool con la consulta realizada puede ser en una función
                    header('Location:./User/index.php?provider='. $provider);
                    exit();
    }

    public function insertUser($data, $provider)
    {

        $provider = $provider;
        $identifier = $data['identifier'];
        $mail = $data['email'];
        $username = $data['first_name'];

        echo 'El nombre provedor: ' . $provider;

        $conn = mysqli_connect("localhost", "root", "", "forumdatabase");
        if (mysqli_connect_errno()) {
            printf("Falló la conexión: %s\n", mysqli_connect_error());
        }

        mysqli_autocommit($conn, false);

        $ExistingUser = new RegisterSocial();
        $ifExistingUser = $ExistingUser->getExistingUser($mail);

        if ($ifExistingUser == 0) { //No existe el usuario se realiza insert del correo
            $queryUser = "INSERT INTO user(idUser, idRole, usernames, userMail, created_at) VALUES ('','1','$username','$mail',now())";

            //Resultado del INSERT
            $result = mysqli_query($conn, $queryUser);

            /* if ($result !== true) {
                mysqli_rollback($conn); //If error, roll back transaction
            } */

            //return $result->num_rows;
            //Consultar el usuario 
            $sql = "SELECT idUser FROM user WHERE userMail = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                require_once  'mail.php';
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_mail);

                // Set parameters
                $param_mail = $mail;

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Store result
                    mysqli_stmt_store_result($stmt);

                    // Check if username exists, if yes then verify password
                    if (mysqli_stmt_num_rows($stmt) == 1) {

                        // Bind result variables
                        mysqli_stmt_bind_result($stmt, $idUsuario);
                        if (mysqli_stmt_fetch($stmt)) {
                            echo 'entro al BIND';

                            //$idUsuario = $idUsuario;

                            //TODO: Enviar estas variables por parametro para una función que realize el insert de user-social
                            $querySocial = "INSERT INTO user_social(id, user_id, social_id, provider, created_at) VALUES ('','$idUsuario','$identifier','$provider',now())";
                            $result = mysqli_query($conn, $querySocial);

                            if ($result !== true) {
                                mysqli_rollback($conn); //If error, roll back transaction
                            }

                            //Assuming no error, commit transaction
                            mysqli_commit($conn);

                            $sendMail = new Mail();
                                
                            $sendMail -> sendMail($mail,$username);

                            if($sendMail){
                                // Redirect to login page
                                echo 'Se envió email correctamente';
                                //header("location: index.php");
                            }else{
                                echo 'No se envió email';
                            }
                            /* cerrar la sentencia */
                            $stmt->close();
                            
                            /* cerrar la conexión */
                            $conn->close();
                            
                            $this->loginUser($data, $provider);
                        }
                    }
                }
            }
        } else {
            $this->loginUser($data, $provider);
        }
    }
}
ob_end_flush();
?>