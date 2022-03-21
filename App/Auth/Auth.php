<?php

use Hybridauth\Hybridauth;
use Hybridauth\Storage\Session;

class Auth
{
    protected static function issetRequest()
    {
        $storage = new Session();
        //print_r($_GET['provider']);

        if (isset($_GET['provider'])) {
            $storage->set('provider', $_GET['provider']);
            return true;
        }

        return false;
    }

    public static function getUserAuth()
    {
        if (self::issetRequest()) {
            include 'config.php';

            include '../../hybridauth/src/autoload.php';

            $provider = $_GET['provider'];

            $hybridAuth = new Hybridauth($config);

            $adapter = $hybridAuth->authenticate($provider);

            $userProfile = $adapter->getUserProfile();

            var_dump($userProfile);

            self::storeUser($provider, $userProfile);

            //redirect user
            header('Location: indexTest.php');
        }
    }

    protected static function storeUser($provider, $socialUser)
    {
        $db = new PDO("mysql:host=localhost;dbname=databaseforo", "root", "");

        $user = self::getExistingUser($socialUser, $db);

        $db->beginTransaction();

        $idRol = 1;

        if ($user === null) {

            $user = array(
                'idRol' => $idRol,
                'name' => $socialUser->firstName,
                'email' => $socialUser->email,

            );

            try {
                $ps = $db->prepare("INSERT INTO usuario (idRol, usuNombres,  usuCorreo) VALUES(:idRol, :name, :email)");
                $ps->execute($user);

            } catch (Exception $e) {
                echo '' . $e->getMessage();
                $db->rollback();
            }

            $user['id'] = $db->lastInsertId();

            self::storeUserSocial($user, $socialUser, $provider, $db);

        } else {

            if (!self::checkUserSocialService($user, $socialUser, $provider, $db)) {
                self::storeUserSocial($user, $socialUser, $provider, $db);
            }

        }

        self::login($user);

    }

    protected static function getExistingUser($socialUser, $db)
    {
        $ps = $db->prepare("SELECT idUsuario, usuNombres, usuCorreo FROM usuario WHERE usuCorreo = :email");
        $ps->execute([
            ':email' => $socialUser->email,
        ]);

        $result = $ps->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result[0] : null;
    }

    protected static function storeUserSocial($user, $socialUser, $provider, $db)
    {
        //$db->beginTransaction();

        try {

            $hoy = date("F j, Y, g:i a");
            $ps = $db->prepare("INSERT INTO user_social (user_id, social_id, provider, created_a) VALUES(:user_id, :social_id, :provider, :created_at)");
            $ps->execute([
                ':user_id' => $user['id'],
                ':social_id' => $socialUser->identifier,
                ':provider' => $provider,
                ':created_at' => $hoy,
            ]);

            $db->commit();

        } catch (Exception $e) {
            echo '' . $e->getMessage();
            $db->rollback();
        }

    }

    protected static function checkUserSocialService($user, $socialUser, $provider, $db)
    {
        $ps = $db->prepare("SELECT * FROM user_social WHERE user_id = :user_id AND provider = :provider AND social_id = :social_id");
        $ps->execute([
            ':user_id' => $user['id'],
            ':provider' => $provider,
            ':social_id' => $socialUser->identifier,
        ]);

        return (bool) $ps->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function isLogin()
    {
        return (bool) isset($_SESSION['user']);
    }

    protected static function login($user)
    {
        $_SESSION['user'] = $user;
    }

    public static function logout()
    {
        if (self::isLogin()) {
            unset($_SESSION['user']);
        }
    }

}
