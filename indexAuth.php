<?php

session_start();

require_once('vendor/autoload.php');
require_once('App/Auth/Auth.php');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/bootstrap-social.css">
    <script src="assets/js/jquery.js" charset="utf-8"></script>
</head>
<body>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v13.0&appId=427082155860894&autoLogAppEvents=1" nonce="CAeLFipW"></script>

<div class="container">
    <div class="row">
        <?php 
        Auth::getUserAuth();
        ?>
        <div class="col-md-4">
            <a href="?login=Facebook" class="btn btn-block btn-social btn-facebook"><span class="fa fa-facebook"></span>Iniciar sesion con Facebook</a>
            <a href="?login=Google" class="btn btn-block btn-social btn-google"><span class="fa fa-google"></span>Iniciar sesion con Google</a>
            <a href="?login=Twitter" class="btn btn-block btn-social btn-twitter"><span class="fa fa-twitter"></span>Iniciar sesion con Twitter</a>
        </div>
    </div>
</div>


<div class="fb-login-button" data-width="200" data-size="small" data-button-type="login_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="false"></div>


<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{your-app-id}',
      cookie     : true,
      xfbml      : true,
      version    : '{api-version}'
    });
      
    FB.AppEvents.logPageView();   
      
  };



  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
    
</body>
</html>