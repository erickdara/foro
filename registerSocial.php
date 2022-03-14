<?php
require_once 'config.php';

class RegisterSocial
{
    public function insertUser($data, $name)
    {
        echo 'El identifier: ' . $data->{'identifier'};
        echo 'El correo: ' . $data->{'emailVerified'};

        $identifier = $data->{'identifier'};
        $mail = $data->{'emailVerified'};
        // var_dump($data);
        echo 'El nombre provedor: ' . $name;

        $conn = mysqli_connect("localhost", "root", "", "databaseforo");
        if (mysqli_connect_errno()) {
            printf("Falló la conexión: %s\n", mysqli_connect_error());
        }

        $queryUser = "INSERT INTO usuario(idUsuario, idRol, usuCorreo, created_at) VALUES ('','1','$mail',now())";

        $result = mysqli_query($conn, $queryUser);

        //return $result->num_rows;

        $sql = "SELECT idUsuario FROM usuario WHERE usuCorreo= ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
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
                        $querySocial = "INSERT INTO user_social(id, user_id, social_id, service) VALUES ('','$idUsuario','$identifier','mail')";
                        $result = mysqli_query($conn, $querySocial);

                    }

                }
            }
        }

        /* cerrar la sentencia */
        $stmt->close();

        /* cerrar la conexión */
        $conn->close();
    }
}
