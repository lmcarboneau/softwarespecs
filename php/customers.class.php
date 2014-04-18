<?php
 /**
 * Customer Database Management Functions
 *
 */

 
class customers {

	// Pass an existing database object on creation
	public function __construct($db){
		$database = $db;
	}

	

	// Attempts to add a new customer to database
	// Returns true or false based on successd
	public function addCustomer($name, $firstname, $lastname, $address1, $address2, $city, $state, $zip, $phonenumber, $gardenerID, $monthlycharge, $averagehours, $quantityTableID, $active){
		global $database;
		$query = "INSERT INTO customers (customer_name, contact_first_name, contact_last_name, address_line_one, 
			address_line_two, city, state, zip, phonenumber, gardenerID, monthly_revenue, hours_to_service, quantityTableID, active) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

		// We turn the list of parameters into a array starting at index 1
		// $database->query will insert these parameters into the '?'s in the query
		// This sanitizes the data, removes errors with ', etc.
		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));
		

		$result = $database->query($query, $bind);
		return $this->successOf($result);
	}


	public function editCustomer($id, $name, $firstname, $lastname, $address1, $address2, $city, $state, $zip, $phonenumber, $gardenerID, $monthlycharge, $averagehours, $quantityTableID, $active){
		global $database;
		$query = "UPDATE customers (customer_name, contact_first_name, contact_last_name, address_line_one, 
			address_line_two, city, state, zip, gardenerID, monthly_revenue, hours_to_service, quantityTableID, active) 
			SET (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
			WHERE id = ".$id;

		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));
		
		$result = $database->query($query);
		return $this->successOf($result);
	}


	public function removeCustomer($id){
		global $database;
		$result = $database->query("DELETE FROM customers WHERE id = ".$id);
		return $this->successOf($result);
	}

	// Returns MySQL results table of all customers and customer data
	public function getCustomerList(){
		global $database;
		$result = $database->query("SELECT * FROM customers", null, 'FETCH_ASSOC_ALL');
		return $result;
	}

	public function getCustomer($id){
		global $database;
		$result = $database->query("SELECT * FROM customers WHERE id = ".$id);
		return $result;
	}

	// Returns true or false based on a MySQL result table
	public function successOf($result){
		// $result is either empty or contains a MySQL results table
		if(is_null($result[1])){
			return true;
		}
		// Convert value in MySQL results table (usually "false")
		// to an actual PHP boolean value
		return filter_var($result[1], FILTER_VALIDATE_BOOLEAN);
	}	

}
?>