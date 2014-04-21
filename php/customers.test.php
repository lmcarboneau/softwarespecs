<?php
error_reporting(-1);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

require_once("util.class.php");
require_once("database.class.php");
$database = new database();
require_once("customers.class.php");
$customers = new customers($database);

// Test addCustomer, $result is true or false
$result = $customers->addCustomer("FGCU", "Bob", "Roberts", "555-5555", "1234 Main St", "Fort Myers", "", "", "", "", "", "", "", "");
echo "addCustomer result: ";
echo $result ? "Success" : "Fail";
echo "<hr>";
?>

<table>
<?php
$result = $customers->getCustomerList();
$filter = array(
	"customerID" => false,
	"customer_name" => true,
	"zip" => true
);
echo "getCustomerList: <br>";
echo util::sqlToTableRows($result, $filter);
echo "<hr>";

?>
</table>