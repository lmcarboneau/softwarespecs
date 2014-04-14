<?php
error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

require_once("database.class.php");
$database = new database();
require_once("customers.class.php");
$customers = new customers($database);

$result = $customers->addCustomer("Bobs Auto", "Bob", "Roberts", "555-5555", "1234 Main St", "", "", "", "", "", "", "", "", "");

?>