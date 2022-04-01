
<?php
require_once 'config.php';


class RegisterSocial{

    
    public static function isLogin()
    {
        
        return (bool) isset($_SESSION['id']);
    }

    private $host  = 'localhost';
    private $user  = 'root';
    private $password   = '';
    private $database  = 'databaseforo';
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
        $query = "SELECT idUsuario, usuNombres, usuCorreo FROM usuario WHERE usuCorreo = '$socialUser'";
        $result = mysqli_query($this->dbConnect, $query);

        return $result->num_rows;
    }

    public function insertUser($data, $provider)
    {
        echo 'El identifier: ' . $data->{'identifier'};
        echo 'El correo: ' . $data->{'emailVerified'};

        $provider = $provider;
        $identifier = $data->{'identifier'};
        $mail = $data->{'emailVerified'};
        $username = $data->{'displayName'};

        echo 'El nombre provedor: ' . $provider;

        $conn = mysqli_connect("localhost", "root", "", "databaseforo");
        if (mysqli_connect_errno()) {
            printf("Falló la conexión: %s\n", mysqli_connect_error());
        }

        mysqli_autocommit($conn, false);

        $ExistingUser = new RegisterSocial();
        $ifExistingUser = $ExistingUser->getExistingUser($mail);

        if ($ifExistingUser == 0) { //No existe el usuario
            $queryUser = "INSERT INTO usuario(idUsuario, idRol, usuNombres, usuCorreo, created_at) VALUES ('','1','$username','$mail',now())";

            $result = mysqli_query($conn, $queryUser);

            if ($result !== true) {
                mysqli_rollback($conn); //If error, roll back transaction
            }

            //return $result->num_rows;

            $sql = "SELECT idUsuario FROM usuario WHERE usuCorreo= ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                include 'mail.php';
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

                            $idUsuario = $idUsuario;

                            //TODO: Enviar estas variables por parametro para una función que realize el insert de user-social
                            $querySocial = "INSERT INTO user_social(id, user_id, social_id, provider, created_at) VALUES ('','$idUsuario','$identifier','$provider',now())";
                            $result = mysqli_query($conn, $querySocial);

                                $sendMail = new Mail();
                                

                            
                            $sendMail -> sendMail($mail,$username);

                            if($sendMail){
                                // Redirect to login page
                                header("location: index.php");
                            }else{
                                echo 'No se envió email';
                            }

                            if ($result !== true) {
                                mysqli_rollback($conn); //If error, roll back transaction
                            }

                            //Assuming no error, commit transaction
                            mysqli_commit($conn);


                            /* cerrar la sentencia */
                            $stmt->close();

                            /* cerrar la conexión */
                            $conn->close();
                        }
                    }
                }
            }
        } else {
            // session_start();
            // $_SESSION["loggedin"] = true;
            // header('Location: ./User/index.php');
            // $validateUser = 'ya existe el usuario';
            // echo json_encode(array("response"=>$validateUser));
            $conn = mysqli_connect("localhost", "root", "", "databaseforo");
            if (mysqli_connect_errno()) {
                printf("Falló la conexión: %s\n", mysqli_connect_error());
            }

            $mail = $data->{'emailVerified'};

            $query = mysqli_query($conn,"SELECT idUsuario, idRol, usuCorreo, usuImagen FROM usuario WHERE usuCorreo = '$mail'");
            $result = mysqli_fetch_array($query);

            $idUsuario = $result['idUsuario'];
            $idRol = $result['idRol'];
            $usuCorreo = $result['usuCorreo'];

                    session_start();

                    // Store data in session variables
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $idUsuario;
                    $_SESSION['rol'] = $idRol;
                    $_SESSION['mail'] = $usuCorreo;

                    header('Location: ./User/index.php?provider=' . $provider);
        }
    }
}
