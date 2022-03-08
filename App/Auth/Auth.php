<?php

use Hybridauth\Hybridauth;
  class Auth
  {
    protected static $allow = ['Facebook', 'Twitter', 'Google'];

    protected static function issetRequest()
    {
      if(isset($_GET['login'])){
        if(in_array($_GET['login'], self::$allow)){
          return true;
        }
      }
      return false;
    }

    public static function getUserAuth()
    {

        include 'config.php';

      if(self::issetRequest())
      {
        $service = $_GET['login'];

        $hybridauth = new Hybridauth($config);

        $adapter = $hybridauth->authenticate($service);

        $userProfile = $adapter->getUserProfile();

        print_r($userProfile);

        self::storeUser($service, $userProfile);

        //redirect user
        header('Location: indexAuth.php');
      }
    }

    protected static function storeUser($service, $socialUser)
    {
      $db = new PDO("mysql:host=localhost;dbname=sociallogin", "root", "");

      $user = self::getExistingUser($socialUser, $db);

      if($user === null){

        $user = array(
          'name' => $socialUser->firstName,
          'email' => $socialUser->email
        );

        $ps = $db->prepare("INSERT INTO users (name, email) VALUES(:name, :email)");
        $ps->execute($user);

        $user['id'] = $db->lastInsertId();

        self::storeUserSocial($user, $socialUser, $service, $db);

      }else{

        if(!self::checkUserSocialService($user, $socialUser, $service, $db)){
          self::storeUserSocial($user, $socialUser, $service, $db);
        }

      }

      self::login($user);

    }

    protected static function getExistingUser($socialUser, $db)
    {
      $ps = $db->prepare("SELECT id, name, email FROM users WHERE email = :email");
      $ps->execute([
        ':email' => $socialUser->email
      ]);

      $result = $ps->fetchAll(PDO::FETCH_ASSOC);

      return $result ? $result[0] : null;
    }

    protected static function storeUserSocial($user, $socialUser, $service, $db)
    {
      $ps = $db->prepare("INSERT INTO users_social (user_id, social_id, service) VALUES(:user_id, :social_id, :service)");
      $ps->execute([
      ':user_id' => $user['id'],
      ':social_id' => $socialUser->identifier,
      ':service' => $service
      ]);
    }

    protected static function checkUserSocialService($user, $socialUser, $service, $db)
    {
      $ps = $db->prepare("SELECT * FROM users_social WHERE user_id = :user_id AND service = :service AND social_id = :social_id");
      $ps->execute([
      ':user_id' => $user['id'],
      ':service' => $service,
      ':social_id' => $socialUser->identifier
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
      if(self::isLogin()){
        unset($_SESSION['user']);
      }
    }

  }

 ?>
