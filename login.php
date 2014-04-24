<?php

require_once("php/database.class.php");
require_once("php/util.class.php");
$database = new database();


if(Login()) {
	redirect("dashboard.php");
}
else {
    redirect("login.html");
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
    
	session_start(); 
    $_SESSION["username"]=$username; 
    $_SESSION["uid"]=$user['idusers'];
    $_SESSION["displayname"]= $user['displayname'];

    return true;
}


?>