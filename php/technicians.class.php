<?php
 /**
 * Technician Database Management Functions
 *
 */

require_once("database.class.php");
$database = new database();
 
class technicians {

	public function addTechnician($gardenerID, $first_name, $last_name, $hourly_wage){
		$query = "INSERT INTO gardeners (gardenerID, first_name, last_name, hourly_wage) 
			VALUES (?,?,?,?)";

		// We turn the list of parameters into a array starting at index 1
		// $database->query will insert these parameters into the '?'s in the query
		// This sanitizes the data, removes errors with ', etc.
		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));
		

		$result = $database->query($query, $bind);
		return $this->successOf($result);
	}

	public function editTechnician($gardenerID, $first_name, $last_name, $hourly_wage){
		$query = "UPDATE gardeners (gardenerID, first_name, last_name, hourly_wage) 
			SET (?,?,?,?)
			WHERE id = ".$gardenerID;

		// We turn the list of parameters into a array starting at index 1
		// $database->query will insert these parameters into the '?'s in the query
		// This sanitizes the data, removes errors with ', etc.
		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));
		

		$result = $database->query($query, $bind);
		return $this->successOf($result);
	}

	public function removeTechnician($id){
		global $database;
		$result = $database->query("DELETE FROM gardeners WHERE id = ".$id);
		return $this->successOf($result);
	}

	public function getTechnicianList(){
		global $database;
		$result = $database->query("SELECT * FROM gardeners", null, 'fetchAll');
		return $result;
	}
	
	// Modified version of getCustomerData()
	public function getTechnicianData(){
		global $database;
		$query = "SELECT * FROM\n"
		    . "Gardeners g LEFT OUTER JOIN Customers c\n"
		    . "ON g.gardenerID = c.gardenerID\n"
		    . "LEFT OUTER JOIN MonthlyData m\n"
		    . "ON g.gardenerID = m.gardenerID and MONTH(m.date) = MONTH(NOW())\n"
		    . "LEFT OUTER JOIN (\n"
		    . " SELECT customerID, SUM(quantity) quantity \n"
		    . " FROM Quantity\n"
		    . " GROUP BY customerID\n"
		    . ") q\n"
		    . "ON c.customerID = q.customerID";
		$result = $database->query($query, null, 'FETCH_ASSOC_ALL');
		return $result;
	}

	public function getTechnician($id){
		global $database;
		$query = "SELECT * FROM gardeners WHERE gardenerID = ".$id;
		$result = $database->query($query);
		return $result;
	}

}
?>