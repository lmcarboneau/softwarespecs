<?php
 /**
 * Customer Database Management Functions
 *
 */

 
class customers {

	public function __construct($db){
		$database = $db;
	}
	public function addCustomer($name, $firstname, $lastname, $address1, $address2, $city, $state, $zip, $phonenumber, $gardenerID, $monthlycharge, $averagehours, $quantityTableID, $active){
		global $database;
		$query = "INSERT INTO customers (customer_name, contact_first_name, contact_last_name, address_line_one, 
			address_line_two, city, state, zip, phonenumber, gardenerID, monthly_revenue, hours_to_service, quantityTableID, active) 
			VALUES ('".$name."','".$firstname."','".$lastname."','".$address1."','".$address2."','".$city."','"
					.$state."','".$zip."','".$phonenumber."','".$gardenerID."','".$monthlycharge."','".$averagehours."','".$quantityTableID."','".$active."')";
		return $database->query($query);
	}

	public function editCustomer($id, $name, $firstname, $lastname, $address1, $address2, $city, $state, $zip, $phonenumber, $gardenerID, $monthlycharge, $averagehours, $quantityTableID, $active){
		global $database;
		return $database->query("UPDATE customers (customer_name, contact_first_name, contact_last_name, address_line_one, 
			address_line_two, city, state, zip, gardenerID, monthly_revenue, hours_to_service, quantityTableID, active) 
			SET (".$id.",".$name.",".$firstname.",".$lastname.",".$address1.",".$address2.",".$city.","
					.$state.",".$zip.",".$phonenumber.",".$gardenerID.",".$monthlycharge.",".$averagehours.",".$quantityTableID.",".$active.")
			WHERE id = ".$id);
	}

	public function removeCustomer($id){
		global $database;
		return $database->query("DELETE FROM customers WHERE id = ".$id);
	}

	public function getCustomerList(){
		global $database;
		$result = $database->query("SELECT * FROM customers");
		return $result;
	}

	public function getCustomer($id){
		global $database;
		$result = $database->query("SELECT * FROM customers WHERE id = ".$id);
		return $result;
	}

}
?>