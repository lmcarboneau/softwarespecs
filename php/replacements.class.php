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

	public function addReplacement($customerID, $gardenerID, $plantID, $light_level, $emergency, $location, $comments, $approved, $completed, $date_submitted, $date_completed){
		global $database;
		$query = "INSERT INTO replacements (customerID, gardenerID, plantID, light_level, 
			emergency, location, comments, approved, completed, date_submitted, date_complted) 
			VALUES (?,?,?,?,?,?,?,?,?,?,?)";

		// We turn the list of parameters into a array starting at index 1
		// $database->query will insert these parameters into the '?'s in the query
		// This sanitizes the data, removes errors with ', etc.
		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));
		

		$result = $database->query($query, $bind);
		return $this->successOf($result);
	}

	public function editReplacement($customerID, $gardenerID, $plantID, $light_level, $emergency, $location, $comments, $approved, $completed, $date_submitted, $date_completed){
		global $database;
		$query = "UPDATE replacements (customerID, gardenerID, plantID, light_level, 
			emergency, location, comments, approved, completed, date_submitted, date_complted) 
			SET (?,?,?,?,?,?,?,?,?,?,?)
			WHERE id = ".$customerID;

		// We turn the list of parameters into a array starting at index 1
		// $database->query will insert these parameters into the '?'s in the query
		// This sanitizes the data, removes errors with ', etc.
		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));
		

		$result = $database->query($query, $bind);
		return $this->successOf($result);
	}

	public function removeReplacement($id){
		global $database;
		$result = $database->query("DELETE FROM replacements WHERE id = ".$id);
		return $this->successOf($result);
	}

	public function getReplacementList(){
		global $database;
		$result = $database->query("SELECT * FROM replacements", null, 'FETCH_ASSOC_ALL');
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
		$result = $database->query("SELECT * FROM replacements WHERE id = ".$id);
		return $result;
	}

}
?>