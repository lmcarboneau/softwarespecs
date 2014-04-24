<?php

require_once("php/database.class.php");
require_once("php/util.class.php");
$database = new database();

session_start();
if(util::checkLogged()){
    redirect("dashboard.php");
}

if(Login()) {
	redirect("dashboard.php");
}

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}

function Login()
{
    global $database;
    if(empty($_POST['username']))
    {
        return false;
    }
     
    if(empty($_POST['password']))
    {
        return false;
    }
     
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
     
    $user = util::checkUser($database, $username, $password);
    if(!$user)
    {
        return false;
    } 
    
    $_SESSION["username"]=$username; 
    $_SESSION["uid"]=$user['idusers'];
    $_SESSION["displayname"]= $user['displayname'];

    return true;
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Login page for App">
    <meta name="designer" content="Stetson Gafford">
    <meta name="author" content="Lindsey Carboneau">
    <title>Login Page for IPS Replacement App</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    
    
    <div class="container">
      <div class="panel panel-default form-signin">
        <form role="form" action="login.php" method="post">
      
            <div class="row">
                <!-- Next line is for layout, because heaven forbid anything just be centered naturally -->
                <!-- It also experiences some odd behaviour at different browser zoom levels. Don't zoom. -->
                <h1><div class="col-md-1"></div><div class="col-md-1"></div><div class="col-md-1"></div> 
                <img src="img/ipslogosmall.jpg">
                </h1>
            </div>  
        
              <br>
          <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
          <br>
          <input type="password" name="password" class="form-control" placeholder="Password" required>
            <br>
          <button class="btn btn-lg btn-success btn-block" type="submit">Log in</button>
        
        </form>
      </div>
    </div> <!-- /container -->

    
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>