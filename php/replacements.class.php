<?php
 /**
 * Replacement Database Management Functions
 *
 */

require_once("database.class.php");
$database = new database();
 
class replacements {

	private $database;

	// Pass an existing database object on creation
	public function __construct($db){
		$database = $db;
	}

	public function addReplacement($customerID, $gardenerID, $plantID, $light_level, $emergency, $location, $comments, $status, $date_submitted, $date_completed){
		global $database;
		$query = "INSERT INTO replacements (customerID, gardenerID, plantID, light_level, 
			emergency, location, comments, status, date_submitted, date_completed) 
			VALUES (?,?,?,?,?,?,?,?,?,?)";

		// We turn the list of parameters into a array starting at index 1
		// $database->query will insert these parameters into the '?'s in the query
		// This sanitizes the data, removes errors with ', etc.
		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));
		
		$result = $database->query($query, $bind);
		//echo "<pre>"; print_r($result); echo "</pre>";
		return $result;
	}

	public function editReplacement($customerID, $gardenerID, $plantID, $light_level, $emergency, $location, $comments, $status, $date_submitted, $date_completed, $replacementID){
		global $database;
		$query = "UPDATE replacements SET customerID=?, gardenerID=?, plantID=?, light_level=?,"
			."emergency=?, location=?, comments=?, status=?, date_submitted=?, date_completed=?"
			."WHERE replacementID = ?";

		// We turn the list of parameters into a array starting at index 1
		// $database->query will insert these parameters into the '?'s in the query
		// This sanitizes the data, removes errors with ', etc.
		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));

		$result = $database->query($query, $bind);
		//echo "<pre>"; print_r($result); echo "</pre>";
		return $result;
	}

	public function removeReplacement($id){
		global $database;
		$result = $database->query("DELETE FROM replacements WHERE id = ".$id);
		return $result;
	}

	public function getReplacementList(){
		global $database;
		$query = "SELECT c.customer_name, g.first_name, g.last_name, r.*\n"
		    . "FROM Replacements r\n"
		    . "LEFT OUTER JOIN Customers c\n"
		    . "ON r.customerID = c.customerID\n"
		    . "LEFT OUTER JOIN Gardeners g\n"
		    . "ON r.gardenerID = g.gardenerID";
		$result = $database->query($query, null, 'FETCH_ASSOC_ALL');
		return $result;
	}

	public function getReplacementsForCustomer($id, $num){
		global $database;
		$query = "SELECT g.first_name, g.last_name, r.*\n"
		    . "FROM Replacements r\n"
		    . "LEFT OUTER JOIN Gardeners g\n"
		    . "ON r.gardenerID = g.gardenerID\n"
		    . "WHERE r.customerID = ?\n"
		    . "ORDER BY r.date_submitted DESC\n"
		    . "LIMIT ?\n";
		    
		$result = $database->query($query, [1=>$id, 2=>$num], 'FETCH_ASSOC_ALL');
		return $result;
	}

	public function getReplacementsForTechnician($id, $num){
		global $database;
		$query = "SELECT c.customer_name, r.*\n"
		    . "FROM Replacements r\n"
		    . "LEFT OUTER JOIN Customers c\n"
		    . "ON c.customerID = r.customerID\n"
		    . "WHERE r.gardenerID = ?\n"
		    . "ORDER BY r.date_submitted DESC\n"
		    . "LIMIT ?\n";
		    
		$result = $database->query($query, [1=>$id, 2=>$num], 'FETCH_ASSOC_ALL');
		return $result;
	}

	public function getReplacementCounts(){
		global $database;
		$query = "SELECT status, count(*) num FROM Replacements GROUP BY status";
		$result = $database->query($query, null, 'FETCH_ASSOC_ALL');
		if ($result) {
			$counts = array();
			foreach($result as $row){
				$counts[$row["status"]] = $row["num"];
			}
			return $counts;
		}

		return $result;
	}


	public function getReplacement($id){
		global $database;
		$result = $database->query("SELECT * FROM replacements WHERE replacementID = ".$id);
		return $result;
	}

}
?>