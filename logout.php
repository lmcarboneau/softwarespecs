<?php
session_start();
$_SESSION = array();
session_destroy();
header('Location: ' . "/login.html", true, 303);
die();
?>