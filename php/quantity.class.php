<?php
 /**
 * Quantity Database Management Functions
 */

require_once("database.class.php");
$database = new database();
 
class quantity {

	private $database;

	// Pass an existing database object on creation
	public function __construct($db){
		$database = $db;
	}

	public function addQuantity($customerID, $plantID, $quantity){
		global $database;
		$query = "INSERT INTO quantity (customerID, plantID, quantity) 
			VALUES (?,?,?)";

		// We turn the list of parameters into a array starting at index 1
		// $database->query will insert these parameters into the '?'s in the query
		// This sanitizes the data, removes errors with ', etc.
		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));
		
		$result = $database->query($query, $bind);
		//echo "<pre>"; print_r($result); echo "</pre>";
		return $result;
	}

	public function editQuantity($customerID, $plantID, $quantity, $id){
		global $database;
		$query = "UPDATE quantity SET customerID=?, plantID=?, quantity=?"
			."WHERE quantityID = ?";

		// We turn the list of parameters into a array starting at index 1
		// $database->query will insert these parameters into the '?'s in the query
		// This sanitizes the data, removes errors with ', etc.
		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));

		$result = $database->query($query, $bind);
		//echo "<pre>"; print_r($result); echo "</pre>";
		return $result;
	}
	
		public function getAllQuantityList(){
		global $database;
		$result = $database->query("SELECT * FROM quantity", null, 'FETCH_ASSOC_ALL');
		return $result;
	}
	
		public function getCustomerQuantityList($id){
		global $database;
		$result = $database->query("SELECT * FROM quantity WHERE customerID = ".$id);
		return $result;
	}

	public function removeQuantity($id){
		global $database;
		$result = $database->query("DELETE FROM quantity WHERE id = ".$id);
		return $result;
	}


	public function getQuantity($id){
		global $database;
		$result = $database->query("SELECT * FROM quantity WHERE quantityID = ".$id);
		return $result;
	}

}
?>