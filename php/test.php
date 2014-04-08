<?php

require_once("database.class.php");
$database = new database();

$database->query("CREATE TABLE test2(test VARCHAR(20))");

?>