<?php
 /**
 * Replacement Database Management Functions
 *
 */

require_once("database.class.php");
$database = new database();
 
class replacements {

	public function addReplacement($customerID, $gardenerID, $plantID, $light_level, $emergency, $location, $comments, $approved, $completed, $date_submitted, $date_completed){
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
		$result = $database->query("SELECT * FROM replacements", null, 'fetchAll');
		return $result;
	}

	public function getReplacement($id){
		global $database;
		$result = $database->query("SELECT * FROM replacements WHERE id = ".$id);
		return $result;
	}

}
?>