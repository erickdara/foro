<?php 

use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

include 'vendor/autoload.php';


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

            try {
            $service = $_GET['login'];

            // $hybridAuth = new Hybridauth(__DIR__ . '\config.php');


           // $adapter = new Hybridauth\Provider\Facebook($config);
            
            
            $hybridauth = new Hybridauth($config);

            $adapter = $hybridauth->authenticate($service);

            $tokens = $adapter->getAccessToken();
            $userProfile = $adapter->getUserProfile();

            //var_dump($userProfile);
            
            print_r($tokens);
            print_r($userProfile);

            //die();
            $adapter->disconnect();
            } catch (\Exception $e) {
            echo $e->getMessage();
            }
        }
    }
}
    
?>