<?php
 /**
 * Customer Database Management Functions
 *
 */

class util {

	public static function sqlToTableRows($rows, $columns){
		$result = "";
		foreach($rows as $row){
			$result .= "\n<tr>\n";
			foreach($row as $column => $data){
				if(array_key_exists($column, $columns)){
					$result .= "\t<td class='".$column."' ";
					if (!$columns[$column]){
						$result .= "style='display:none;'";
					}
					$result .= ">".$data."</td>\n";
				}
			}
			$result .= "</tr>";
		}
		return $result;
	}
}

?>

 