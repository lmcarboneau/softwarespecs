<?php
if(Login()) {
	redirect("dashboard.php");
}
else {redirect("login.html")};

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}

function Login()
{
    if(empty($_POST['username']))
    {
        $this->HandleError("Username is empty!");
        return false;
    }
     
    if(empty($_POST['password']))
    {
        $this->HandleError("Password is empty!");
        return false;
    }
     
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
     
 /*    if(!$this->CheckLoginInDB($username,$password))
    {
        return false;
    } */
    
	session_start(); 
	include("passwords.php"); 
	if ($_POST["ac"]=="log") { /// do after login form is submitted  
		if ($USERS[$_POST["username"]]==$_POST["password"]) { /// check if submitted 
			$_SESSION["logged"]=$_POST["username"]; 
		} else { 
			echo 'Incorrect username/password. Please, try again.'; 
		}; 
	}; 
	
 /*    session_start();
     
    $_SESSION[$this->GetLoginSessionVar()] = $username;
     
    return true; */
}
?>