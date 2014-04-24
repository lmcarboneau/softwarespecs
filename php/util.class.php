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


	public static function getUserID($database, $username){
		$result = $database->query("SELECT id FROM Users WHERE username = ?", [1=>$username]);
		return $result;
	}

	public static function checkLogged(){
		return !empty($_SESSION['username']);
	}


	public static function checkUser($database, $username, $password){
        $result = $database->query("SELECT * FROM Users WHERE username = ?", [1=>$username]);
        
        //echo "<pre>"; print_r($result); echo "</pre>";
        if (!$result){
            return false;
        }
        //echo sha1($password);
        if( $username == $result['username'] && sha1($password) === $result['password']){
        	return $result;
        }
        return false;
    }
}
?>