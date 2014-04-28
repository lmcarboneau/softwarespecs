<?php
 /**
 * Plant Database Management Functions
 */

require_once("database.class.php");
$database = new database();
 
class plants {

	private $database;

	// Pass an existing database object on creation
	public function __construct($db){
		$database = $db;
	}

	public function addPlant($name, $diameter, $cost){
		global $database;
		$query = "INSERT INTO plants (name, plant_diameter, cost_to_service) 
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

	public function editPlant($name, $diameter, $cost, $id){
		global $database;
		$query = "UPDATE plants SET name=?, plant_diameter=?, cost=?"
			."WHERE plantID = ?";

		// We turn the list of parameters into a array starting at index 1
		// $database->query will insert these parameters into the '?'s in the query
		// This sanitizes the data, removes errors with ', etc.
		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));

		$result = $database->query($query, $bind);
		//echo "<pre>"; print_r($result); echo "</pre>";
		return $result;
	}
	
		public function getPlantList(){
		global $database;
		$result = $database->query("SELECT * FROM plants", null, 'FETCH_ASSOC_ALL');
		return $result;
	}

	public function removePlant($id){
		global $database;
		$result = $database->query("DELETE FROM plants WHERE id = ".$id);
		return $result;
	}


	public function getPlant($id){
		global $database;
		$result = $database->query("SELECT * FROM plants WHERE plantID = ".$id);
		return $result;
	}

}
?>