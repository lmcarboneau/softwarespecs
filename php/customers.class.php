<?php
 /**
 * Customer Database Management Functions
 *
 */

 
class customers {

	private $database;

	// Pass an existing database object on creation
	public function __construct($db){
		$database = $db;
	}

	

	// Attempts to add a new customer to database
	// Returns true or false based on success
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

	// Returns array of all customers and customer fields
	public function getCustomerList(){
		global $database;
		$result = $database->query("SELECT * FROM customers", null, 'FETCH_ASSOC_ALL');
		return $result;
	}

	// Returns array of all customers and customer fields
	// plus fields from associated Gardener
	// plus fields from MonthlyData for current month if they exist
	// plus total quantity of plants from Quantity
	public function getCustomerData(){
		global $database;
		$query = "SELECT * FROM\n"
		    . "Customers c LEFT OUTER JOIN Gardeners g\n"
		    . "ON c.gardenerID = g.gardenerID\n"
		    . "LEFT OUTER JOIN MonthlyData m\n"
		    . "ON c.customerID = m.customerID and MONTH(m.date) = MONTH(NOW())\n";
		$result = $database->query($query, null, 'FETCH_ASSOC_ALL');
		return $result;
	}

	public function getCustomer($id){
		global $database;
		$query = "SELECT * FROM\n"
		    . "Customers c\n"
		    . "LEFT OUTER JOIN Gardeners g\n"
		    . "ON c.gardenerID = g.gardenerID\n"
		    . "LEFT OUTER JOIN MonthlyData m\n"
		    . "ON c.customerID = m.customerID and MONTH(m.date) = MONTH(NOW())\n"
		    . "WHERE c.customerID='".$id."'\n";
		$result = $database->query($query, null, 'FETCH_ASSOC');
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