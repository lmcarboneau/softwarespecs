<?php
 /**
 * Technician Database Management Functions
 *
 */

require_once("database.class.php");
$database = new database();
 
class technicians {

	public function addTechnician($first_name, $last_name){
		global $database;
		$query = "INSERT INTO gardeners (first_name, last_name) 
			VALUES (?,?)";

		// We turn the list of parameters into a array starting at index 1
		// $database->query will insert these parameters into the '?'s in the query
		// This sanitizes the data, removes errors with ', etc.
		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));
		

		$result = $database->query($query, $bind);
		return $result;
	}

	public function editTechnician($first_name, $last_name, $gardenerID){
		global $database;
		$query = "UPDATE gardeners SET first_name = ?, last_name = ?
			WHERE gardenerID = ?";

		// We turn the list of parameters into a array starting at index 1
		// $database->query will insert these parameters into the '?'s in the query
		// This sanitizes the data, removes errors with ', etc.
		$parameters = func_get_args();
		$bind = array_combine(range(1, count($parameters)), array_values($parameters));
		

		$result = $database->query($query, $bind);
		return $result;
	}

	public function removeTechnician($id){
		global $database;
		$result = $database->query("DELETE FROM gardeners WHERE id = ".$id);
		return $this->successOf($result);
	}

	public function getTechnicianList(){
		global $database;
		$result = $database->query("SELECT * FROM gardeners", null, 'FETCH_ASSOC_ALL');
		return $result;
	}
	
	// Modified version of getCustomerData()
	// Combine replacement and profit stats for all customers
	// for this
	public function getTechnicianData(){
		global $database;
		$query = "SELECT g.*, c.num_customers, m.amount_billed, m.number_of_replacements, m.cost_of_replacements, m.num_plants FROM\n"
		    . "Gardeners g LEFT OUTER JOIN (\n"
		    . "	SELECT gardenerID, COUNT(*) num_customers FROM\n"
		    . " Customers\n"
		    . " GROUP BY gardenerID\n"
		    . "	) AS c\n"
		    . "ON g.gardenerID = c.gardenerID\n"
		    . "LEFT OUTER JOIN (\n"
		    . "	SELECT gardenerID,\n" 
			. "    	SUM(number_of_replacements) number_of_replacements,\n"
			. "    	SUM(num_plants) num_plants,\n"
			. "    	SUM(amount_billed) amount_billed,\n"
			. "    	SUM(cost_of_replacements) cost_of_replacements\n"
			. "  FROM MonthlyData\n"
			. "  WHERE MONTH(date) = MONTH(NOW())\n"
			. "  GROUP BY gardenerID\n"
		    . ") AS m\n"
		    . "ON g.gardenerID = m.gardenerID\n";
		$result = $database->query($query, null, 'FETCH_ASSOC_ALL');
		return $result;
	}

	public function getMonthlyData($id, $num){
		global $database;
		$query = "SELECT MONTH(date) month,date,\n" 
			. "    	SUM(number_of_replacements) number_of_replacements,\n"
			. "    	SUM(num_plants) num_plants,\n"
			. "    	SUM(amount_billed) amount_billed,\n"
			. "    	SUM(cost_of_replacements) cost_of_replacements\n"
			. "  FROM MonthlyData\n"
			. "  WHERE gardenerID=?\n"
			. "  GROUP BY MONTH(date)\n"
		    . "  ORDER BY MONTH(date) ASC\n"
		    . "  LIMIT ?\n";
		$result = $database->query($query, [1=>$id, 2=>$num], 'FETCH_ASSOC_ALL');
		return $result;
	}

	public function getTechnician($id){
		global $database;
		$query = "SELECT * FROM gardeners WHERE gardenerID = ".$id;
		$result = $database->query($query);
		return $result;
	}

	public function getMostEfficient(){
		global $database;
		$technicianList = $this->getTechnicianData();

		if (isset($technicianList[0])){
			$maxPoints = $rating = $this->getRating($technicianList[0]);;
			$technician = $technicianList[0];
			$technician['rating'] = $rating;
		} else {
			return false;
		}

		foreach($technicianList as $technicianRow){
			$rating = $this->getRating($technicianRow);
			$technicianRow['rating'] = $rating;

			if ($rating > $maxPoints){
				$maxPoints = $rating;
				$technician = $technicianRow;
			}

		}
		return $technician;
	}

	public function getLeastEfficient(){
		global $database;
		$technicianList = $this->getTechnicianData();

		if (isset($technicianList[0])){
			$maxPoints = $rating = $this->getRating($technicianList[0]);;
			$technician = $technicianList[0];
			$technician['rating'] = $rating;
		} else {
			return false;
		}

		foreach($technicianList as $technicianRow){
			$rating = $this->getRating($technicianRow);
			$technicianRow['rating'] = $rating;

			if ($rating < $maxPoints){
				$maxPoints = $rating;
				$technician = $technicianRow;
				$technician['rating'] = $rating;
			}

		}
		return $technician;
	}

	public function getRating($technicianRow){
		$profit = 0;
			if ($technicianRow['amount_billed'] > 0){
				if ($technicianRow['cost_of_replacements'] > 0){
					$profit = ($technicianRow['amount_billed'] - $technicianRow['cost_of_replacements']);
				} else {
					$profit = $technicianRow['amount_billed'];
				}
			}

			$replacements = 0;
			if ($technicianRow['number_of_replacements'] > 0 && $technicianRow['num_plants'] > 0){
				$replacements = $technicianRow['number_of_replacements'] / $technicianRow['num_plants'] * 100;
				$replacements = round($replacements);
			}

			$rating = 0;
			if ($profit!=0){
				$rating = ($replacements > 0) ? log($profit/($replacements/6))*10 : log($profit)*10;
			}
		return $rating;
	}
}
?>